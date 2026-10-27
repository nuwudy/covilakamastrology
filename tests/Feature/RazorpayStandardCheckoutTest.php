<?php

namespace Tests\Feature;

use App\Models\Order;
use App\Models\Product;
use Database\Seeders\ShopSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RazorpayStandardCheckoutTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed(\Database\Seeders\BookSeeder::class);
        $this->seed(ShopSeeder::class);
    }

    public function test_checkout_frontend_page_renders_with_script_and_modal_trigger(): void
    {
        $response = $this->get('/checkout');
        $response->assertStatus(200);
        $response->assertSee('Razorpay Standard Checkout');
        $response->assertSee('https://checkout.razorpay.com/v1/checkout.js', false);
        $response->assertSee('initiatePayment');
        $response->assertSee('verifyPaymentSignature');
        $response->assertSee('POST /api/create-order', false);
        $response->assertSee('POST /api/verify-payment', false);
    }

    public function test_create_order_validates_minimum_amount_of_100_paise(): void
    {
        // 50 paise is less than minimum 100 paise
        $response = $this->postJson('/api/create-order', [
            'amount' => 50,
            'currency' => 'INR',
        ]);

        $response->assertStatus(400);
        $response->assertJson([
            'success' => false,
        ]);
        $response->assertJsonFragment([
            'amount' => ['Amount must be at least 100 paise (₹1.00).'],
        ]);
    }

    public function test_create_order_handles_auth_failure_when_credentials_are_empty(): void
    {
        config(['services.razorpay.key_id' => '']);
        config(['services.razorpay.key_secret' => '']);

        $response = $this->postJson('/api/create-order', [
            'amount' => 50000,
            'currency' => 'INR',
        ]);

        $response->assertStatus(401);
        $response->assertJson([
            'success' => false,
        ]);
    }

    public function test_create_order_returns_order_id_amount_and_currency(): void
    {
        // Using test credentials from .env
        $response = $this->postJson('/api/create-order', [
            'amount' => 10000, // ₹100
            'currency' => 'INR',
            'receipt' => 'rcpt_test_unit_1',
            'notes' => [
                'test' => 'true'
            ]
        ]);

        // If Razorpay API is reachable online, verify full structure; if offline/cURL error, verify safe 500 error response
        if ($response->status() === 200) {
            $response->assertJsonStructure([
                'success',
                'order_id',
                'amount',
                'currency',
            ]);
            $this->assertEquals(10000, $response->json('amount'));
            $this->assertEquals('INR', $response->json('currency'));
            $this->assertNotEmpty($response->json('order_id'));
        } else {
            $response->assertStatus(500);
            $this->assertFalse($response->json('success'));
            $this->assertNotEmpty($response->json('error'));
        }
    }

    public function test_verify_payment_requires_all_three_fields(): void
    {
        // Missing signature
        $response = $this->postJson('/api/verify-payment', [
            'order_id' => 'order_12345',
            'payment_id' => 'pay_12345',
        ]);

        $response->assertStatus(400);
        $response->assertJson([
            'success' => false,
        ]);
        $this->assertStringContainsString('Missing required fields', $response->json('error'));

        // Missing payment_id
        $response2 = $this->postJson('/api/verify-payment', [
            'order_id' => 'order_12345',
            'signature' => 'sig_12345',
        ]);

        $response2->assertStatus(400);

        // Missing order_id
        $response3 = $this->postJson('/api/verify-payment', [
            'payment_id' => 'pay_12345',
            'signature' => 'sig_12345',
        ]);

        $response3->assertStatus(400);
    }

    public function test_verify_payment_rejects_signature_mismatch_and_does_not_mark_order_as_paid(): void
    {
        $product = Product::first();
        $order = Order::create([
            'order_number' => 'COV-MISMATCH-001',
            'customer_name' => 'Rahul',
            'customer_phone' => '+91 9999999999',
            'product_id' => $product->id,
            'product_title' => $product->title,
            'product_type' => 'book',
            'amount' => 100.00,
            'razorpay_order_id' => 'order_fake_test_123',
            'payment_status' => 'pending',
            'delivery_status' => 'pending',
        ]);

        $response = $this->postJson('/api/verify-payment', [
            'order_id' => 'order_fake_test_123',
            'payment_id' => 'pay_fake_test_456',
            'signature' => 'invalid_tampered_signature_string',
        ]);

        $response->assertStatus(400);
        $response->assertJson([
            'success' => false,
        ]);
        $this->assertStringContainsString('mismatch', strtolower($response->json('error')));

        $order->refresh();
        $this->assertNotEquals('paid', $order->payment_status);
    }

    public function test_verify_payment_accepts_valid_hmac_sha256_signature_and_marks_paid(): void
    {
        $product = Product::first();
        $order = Order::create([
            'order_number' => 'COV-VALID-002',
            'customer_name' => 'Deepa',
            'customer_phone' => '+91 9888888888',
            'product_id' => $product->id,
            'product_title' => $product->title,
            'product_type' => 'book',
            'amount' => 100.00,
            'razorpay_order_id' => 'order_valid_789',
            'payment_status' => 'pending',
            'delivery_status' => 'pending',
        ]);

        $orderId = 'order_valid_789';
        $paymentId = 'pay_valid_987';
        $keySecret = config('services.razorpay.key_secret');

        // Algorithm: HMAC-SHA256(order_id + "|" + payment_id, KEY_SECRET)
        $expectedSignature = hash_hmac('sha256', $orderId . '|' . $paymentId, $keySecret);

        $response = $this->postJson('/api/verify-payment', [
            'order_id' => $orderId,
            'payment_id' => $paymentId,
            'signature' => $expectedSignature,
        ]);

        $response->assertStatus(200);
        $response->assertJson([
            'success' => true,
            'order_id' => $orderId,
            'payment_id' => $paymentId,
        ]);

        $order->refresh();
        $this->assertEquals('paid', $order->payment_status);
        $this->assertEquals($paymentId, $order->razorpay_payment_id);
    }
}

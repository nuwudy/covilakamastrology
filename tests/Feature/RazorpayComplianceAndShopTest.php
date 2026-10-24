<?php

namespace Tests\Feature;

use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Database\Seeders\ShopSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RazorpayComplianceAndShopTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed(ShopSeeder::class);
    }

    public function test_all_razorpay_compliance_pages_load_successfully(): void
    {
        // 1. Terms and Conditions
        $response = $this->get('/terms-and-conditions');
        $response->assertStatus(200);
        $response->assertSee('Terms and Conditions');
        $response->assertSee('Razorpay');

        // 2. Privacy Policy
        $response = $this->get('/privacy-policy');
        $response->assertStatus(200);
        $response->assertSee('Privacy Policy');
        $response->assertSee('PCI-DSS Level 1');

        // 3. Cancellation & Refund Policy
        $response = $this->get('/refund-policy');
        $response->assertStatus(200);
        $response->assertSee('Cancellation & Refund Policy');
        $response->assertSee('5 to 7 business days');

        // 4. Shipping & Delivery Policy
        $response = $this->get('/shipping-policy');
        $response->assertStatus(200);
        $response->assertSee('Shipping & Delivery Policy');
        $response->assertSee('India Post Speed Post');

        // 5. Contact Us Page
        $response = $this->get('/contact');
        $response->assertStatus(200);
        $response->assertSee('Contact Covilakam Astrology');
        $response->assertSee('+91 7907052160');

        // 6. About Us Page
        $response = $this->get('/about-us');
        $response->assertStatus(200);
        $response->assertSee('DR. E. K. Raja Varma');
    }

    public function test_bookstore_catalog_and_product_show_pages(): void
    {
        // Catalog
        $response = $this->get('/shop');
        $response->assertStatus(200);
        $response->assertSee('Kerala Jyothisha Deepika');
        $response->assertSee('Deluxe Vedic Jathakam');
        $response->assertSee('Razorpay');

        // Individual Product
        $book = Product::where('slug', 'kerala-jyothisha-deepika')->first();
        $this->assertNotNull($book);

        $response = $this->get('/shop/' . $book->slug);
        $response->assertStatus(200);
        $response->assertSee('₹499');
        $response->assertSee('DR. E. K. Raja Varma');
    }

    public function test_razorpay_order_creation_and_payment_verification_flow(): void
    {
        $product = Product::where('slug', 'deluxe-vedic-jathakam-pdf-report')->first();

        // 1. Create Order
        $orderPayload = [
            'product_id' => $product->id,
            'customer_name' => 'Suresh Kumar',
            'customer_phone' => '+91 9876543210',
            'customer_email' => 'suresh@example.com',
            'birth_date' => '1990-05-15',
            'birth_time' => '07:30 AM',
            'birth_place' => 'Thrissur, Kerala',
        ];

        $res = $this->postJson('/checkout/create-order', $orderPayload);
        $res->assertStatus(200);
        $res->assertJsonStructure(['success', 'order_number', 'amount', 'razorpay_order_id']);

        $orderNumber = $res->json('order_number');
        $order = Order::where('order_number', $orderNumber)->first();
        $this->assertNotNull($order);
        $this->assertEquals('pending', $order->payment_status);

        // 2. Verify Payment
        $verifyRes = $this->postJson('/checkout/verify-payment', [
            'order_number' => $orderNumber,
            'razorpay_payment_id' => 'pay_test_123456789',
            'razorpay_order_id' => $order->razorpay_order_id,
            'razorpay_signature' => 'dummy_signature',
        ]);

        $verifyRes->assertStatus(200);
        $order->refresh();
        $this->assertEquals('paid', $order->payment_status);
        $this->assertEquals('pay_test_123456789', $order->razorpay_payment_id);

        // 3. Confirmation page loads
        $confRes = $this->get('/orders/' . $orderNumber . '/confirmation');
        $confRes->assertStatus(200);
        $confRes->assertSee('Suresh Kumar');
        $confRes->assertSee('Download Deluxe Jathakam PDF Now');

        // 4. Download Jathakam PDF loads and renders Vedic chart
        $pdfRes = $this->get('/orders/' . $orderNumber . '/download-jathakam');
        $pdfRes->assertStatus(200);
        $pdfRes->assertSee('DELUXE VEDIC JATHAKAM REPORT');
        $pdfRes->assertSee('Suresh Kumar');
        $pdfRes->assertSee('Rasi Chakra');
        $pdfRes->assertSee('DR. E. K. RAJA VARMA');
    }

    public function test_admin_orders_dashboard_is_protected_and_manageable(): void
    {
        // Guest cannot access
        $this->get('/admin/orders')->assertRedirect('/login');

        // Authenticated admin can access
        $admin = User::factory()->create([
            'email' => 'admin@covilakamastrology.com',
            'password' => bcrypt('password'),
        ]);

        $product = Product::first();
        $order = Order::create([
            'order_number' => 'COV-TEST-001',
            'customer_name' => 'Meera Nair',
            'customer_phone' => '+91 9447000000',
            'product_id' => $product->id,
            'product_title' => $product->title,
            'product_type' => 'book',
            'amount' => 499.00,
            'payment_status' => 'paid',
            'delivery_status' => 'pending',
            'shipping_address' => 'Covilakam Lane, Kottayam, Kerala',
        ]);

        $res = $this->actingAs($admin)->get('/admin/orders');
        $res->assertStatus(200);
        $res->assertSee('COV-TEST-001');
        $res->assertSee('Orders & Razorpay', false);

        // Update status
        $statusRes = $this->actingAs($admin)->post('/admin/orders/' . $order->id . '/status', [
            'delivery_status' => 'shipped',
        ]);
        $statusRes->assertRedirect();
        $order->refresh();
        $this->assertEquals('shipped', $order->delivery_status);
    }
}

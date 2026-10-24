<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Product;
use App\Models\Setting;
use App\Services\VedicDobCalculator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class ShopController extends Controller
{
    private function getSettings(): array
    {
        return Setting::all()->pluck('value', 'key')->toArray();
    }

    /**
     * Display the bookstore and services catalog
     */
    public function index(Request $request)
    {
        $settings = $this->getSettings();
        $type = $request->query('type', 'all');

        $query = Product::where('is_active', true)->orderBy('sort_order', 'asc');

        if ($type && in_array($type, ['book', 'digital_pdf', 'consultation'])) {
            $query->where('type', $type);
        }

        $products = $query->get();
        $featuredBook = Product::where('slug', 'kerala-jyothisha-deepika')->first();
        $jathakamPdfProduct = Product::where('slug', 'deluxe-vedic-jathakam-pdf-report')->first();

        return view('shop.index', compact('products', 'settings', 'type', 'featuredBook', 'jathakamPdfProduct'));
    }

    /**
     * Display a specific book or service product
     */
    public function show($slug)
    {
        $settings = $this->getSettings();
        $product = Product::where('slug', $slug)->where('is_active', true)->firstOrFail();
        $relatedProducts = Product::where('id', '!=', $product->id)
            ->where('is_active', true)
            ->inRandomOrder()
            ->take(3)
            ->get();

        $razorpayKeyId = config('services.razorpay.key_id', 'rzp_test_sampleKey123');

        return view('shop.show', compact('product', 'relatedProducts', 'settings', 'razorpayKeyId'));
    }

    /**
     * Create an order in DB and initialize Razorpay Order
     */
    public function createRazorpayOrder(Request $request)
    {
        $validated = $request->validate([
            'product_id' => 'required|exists:products,id',
            'customer_name' => 'required|string|max:150',
            'customer_phone' => 'required|string|max:20',
            'customer_email' => 'nullable|email|max:150',
            'shipping_address' => 'nullable|string|max:500',
            'birth_date' => 'nullable|date',
            'birth_time' => 'nullable|string',
            'birth_place' => 'nullable|string|max:150',
            'notes' => 'nullable|string|max:500',
        ]);

        $product = Product::findOrFail($validated['product_id']);
        $orderNumber = Order::generateOrderNumber();
        $amountInPaise = (int) round($product->price * 100);

        $birthDetails = null;
        if (!empty($validated['birth_date'])) {
            $birthDetails = [
                'name' => $validated['customer_name'],
                'birth_date' => $validated['birth_date'],
                'birth_time' => $validated['birth_time'] ?? null,
                'birth_place' => $validated['birth_place'] ?? null,
            ];
        }

        $keyId = config('services.razorpay.key_id');
        $keySecret = config('services.razorpay.key_secret');

        $razorpayOrderId = 'order_' . uniqid();

        // Attempt actual Razorpay API order creation if live/test credentials exist and not sample
        if ($keyId && $keySecret && !str_contains($keyId, 'sampleKey')) {
            try {
                $response = Http::withBasicAuth($keyId, $keySecret)
                    ->post('https://api.razorpay.com/v1/orders', [
                        'amount' => $amountInPaise,
                        'currency' => 'INR',
                        'receipt' => $orderNumber,
                        'payment_capture' => 1,
                        'notes' => [
                            'product' => $product->title,
                            'customer' => $validated['customer_name'],
                            'phone' => $validated['customer_phone'],
                        ],
                    ]);

                if ($response->successful()) {
                    $razorpayOrderId = $response->json('id');
                } else {
                    Log::warning('Razorpay Order API response error: ' . $response->body());
                }
            } catch (\Exception $e) {
                Log::error('Razorpay Order API Exception: ' . $e->getMessage());
            }
        }

        $order = Order::create([
            'order_number' => $orderNumber,
            'customer_name' => $validated['customer_name'],
            'customer_phone' => $validated['customer_phone'],
            'customer_email' => $validated['customer_email'] ?? null,
            'shipping_address' => $validated['shipping_address'] ?? null,
            'product_id' => $product->id,
            'product_title' => $product->title,
            'product_type' => $product->type,
            'amount' => $product->price,
            'currency' => 'INR',
            'razorpay_order_id' => $razorpayOrderId,
            'payment_status' => 'pending',
            'delivery_status' => 'pending',
            'birth_details' => $birthDetails,
            'notes' => $validated['notes'] ?? null,
        ]);

        return response()->json([
            'success' => true,
            'order_number' => $order->order_number,
            'razorpay_order_id' => $razorpayOrderId,
            'amount' => $amountInPaise,
            'amount_display' => $product->formatted_price,
            'key_id' => $keyId,
            'product_title' => $product->title,
            'customer_name' => $order->customer_name,
            'customer_phone' => $order->customer_phone,
            'customer_email' => $order->customer_email,
        ]);
    }

    /**
     * Verify payment from Razorpay modal callback
     */
    public function verifyPayment(Request $request)
    {
        $validated = $request->validate([
            'order_number' => 'required|string',
            'razorpay_payment_id' => 'required|string',
            'razorpay_order_id' => 'nullable|string',
            'razorpay_signature' => 'nullable|string',
        ]);

        $order = Order::where('order_number', $validated['order_number'])->firstOrFail();

        $keySecret = config('services.razorpay.key_secret');
        $isSignatureValid = true;

        if ($keySecret && !str_contains($keySecret, 'sampleSecret') && !empty($validated['razorpay_signature'])) {
            $expectedSignature = hash_hmac(
                'sha256',
                $validated['razorpay_order_id'] . '|' . $validated['razorpay_payment_id'],
                $keySecret
            );
            $isSignatureValid = hash_equals($expectedSignature, $validated['razorpay_signature']);
        }

        if ($isSignatureValid) {
            $deliveryStatus = 'pending';
            if ($order->product_type === 'digital_pdf') {
                $deliveryStatus = 'ready_for_download';
            } elseif ($order->product_type === 'consultation') {
                $deliveryStatus = 'scheduled';
            } else {
                $deliveryStatus = 'processing_shipment';
            }

            $order->update([
                'payment_status' => 'paid',
                'razorpay_payment_id' => $validated['razorpay_payment_id'],
                'razorpay_signature' => $validated['razorpay_signature'] ?? null,
                'delivery_status' => $deliveryStatus,
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Payment successfully verified!',
                'redirect_url' => route('shop.confirmation', $order->order_number),
            ]);
        }

        $order->update(['payment_status' => 'failed']);

        return response()->json([
            'success' => false,
            'message' => 'Payment signature verification failed. Please contact support.',
        ], 400);
    }

    /**
     * Display order confirmation and invoice/receipt
     */
    public function confirmation($orderNumber)
    {
        $settings = $this->getSettings();
        $order = Order::where('order_number', $orderNumber)->firstOrFail();

        return view('shop.confirmation', compact('order', 'settings'));
    }

    /**
     * Download or view the Deluxe Jathakam PDF report
     */
    public function downloadJathakam($orderNumber)
    {
        $settings = $this->getSettings();
        $order = Order::where('order_number', $orderNumber)->firstOrFail();

        $birthDate = $order->birth_details['birth_date'] ?? now()->toDateString();
        $customerName = $order->birth_details['name'] ?? $order->customer_name;
        $birthTime = $order->birth_details['birth_time'] ?? '10:30 AM';
        $birthPlace = $order->birth_details['birth_place'] ?? 'Kerala, India';

        $calculator = new VedicDobCalculator();
        $jathakamData = $calculator->calculate($birthDate, $customerName, 'Deluxe Vedic Jathakam');

        return view('shop.jathakam-pdf-template', compact(
            'order',
            'settings',
            'customerName',
            'birthDate',
            'birthTime',
            'birthPlace',
            'jathakamData'
        ));
    }
}

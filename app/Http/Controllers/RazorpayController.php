<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Razorpay\Api\Api;
use Razorpay\Api\Errors\BadRequestError;

class RazorpayController extends Controller
{
    /**
     * Display standard Razorpay checkout frontend page.
     */
    public function checkoutPage()
    {
        $keyId = config('services.razorpay.key_id');
        $merchantName = config('services.razorpay.merchant_name', 'Covilakam Astrology');

        return view('razorpay.checkout', compact('keyId', 'merchantName'));
    }

    /**
     * STEP 1: BACKEND - Create Order
     * Endpoint: POST /api/create-order
     *
     * Request: { amount (paise), currency, receipt }
     * Minimum amount: 100 paise
     * Return: { order_id, amount, currency }
     */
    public function createOrder(Request $request): JsonResponse
    {
        // Validate input - minimum 100 paise (₹1.00)
        $validator = Validator::make($request->all(), [
            'amount' => 'required|numeric|min:100',
            'currency' => 'nullable|string|size:3',
            'receipt' => 'nullable|string|max:40',
            'notes' => 'nullable|array',
        ], [
            'amount.min' => 'Amount must be at least 100 paise (₹1.00).',
            'amount.required' => 'Amount in paise is required.',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'error' => 'Validation error: ' . $validator->errors()->first(),
                'messages' => $validator->errors(),
            ], 400);
        }

        $amountInPaise = (int) round($request->input('amount'));
        $currency = strtoupper($request->input('currency', 'INR'));
        $receipt = (string) ($request->input('receipt') ?: 'rcpt_' . substr(uniqid(), -6) . '_' . time());
        $notes = $request->input('notes', ['source' => 'standard_checkout']);

        $keyId = config('services.razorpay.key_id');
        $keySecret = config('services.razorpay.key_secret');

        // Check authentication credentials
        if (empty($keyId) || empty($keySecret)) {
            Log::error('Razorpay authentication failure: Missing RAZORPAY_KEY_ID or RAZORPAY_KEY_SECRET in configuration.');
            return response()->json([
                'success' => false,
                'error' => 'Authentication failure: Razorpay API credentials are not configured.',
            ], 401);
        }

        try {
            $api = new Api($keyId, $keySecret);

            $orderData = [
                'receipt' => $receipt,
                'amount' => $amountInPaise,
                'currency' => $currency,
                'payment_capture' => 1,
                'notes' => $notes,
            ];

            $razorpayOrder = $api->order->create($orderData);

            $orderId = is_array($razorpayOrder) ? $razorpayOrder['id'] : ($razorpayOrder->id ?? null);
            $returnedAmount = is_array($razorpayOrder) ? $razorpayOrder['amount'] : ($razorpayOrder->amount ?? $amountInPaise);
            $returnedCurrency = is_array($razorpayOrder) ? $razorpayOrder['currency'] : ($razorpayOrder->currency ?? $currency);

            Log::info("Razorpay order created successfully: {$orderId} for amount: {$returnedAmount} {$returnedCurrency}");

            return response()->json([
                'success' => true,
                'order_id' => $orderId,
                'amount' => (int) $returnedAmount,
                'currency' => $returnedCurrency,
                'receipt' => $receipt,
                'key_id' => $keyId, // Key ID is public to frontend (never Secret)
            ], 200);

        } catch (BadRequestError $e) {
            $message = $e->getMessage();
            $code = $e->getCode();
            Log::error("Razorpay API BadRequestError ({$code}): {$message}");

            // Handle authentication failures (HTTP 401 / unauthorized)
            if ($code === 401 || str_contains(strtolower($message), 'unauthorized') || str_contains(strtolower($message), 'authentication')) {
                return response()->json([
                    'success' => false,
                    'error' => 'Authentication failed with Razorpay API. Verify RAZORPAY_KEY_ID and RAZORPAY_KEY_SECRET.',
                ], 401);
            }

            return response()->json([
                'success' => false,
                'error' => 'Razorpay API Error: ' . $message,
            ], 500);

        } catch (Exception $e) {
            $message = $e->getMessage();
            $code = $e->getCode();
            Log::error("Razorpay Order Creation Exception ({$code}): {$message}");

            // Handle auth failures (return 401)
            if ($code === 401 || str_contains(strtolower($message), 'unauthorized') || str_contains(strtolower($message), 'authentication')) {
                return response()->json([
                    'success' => false,
                    'error' => 'Authentication failed with Razorpay API. Verify credentials.',
                ], 401);
            }

            // Handle Razorpay API errors (return 500)
            return response()->json([
                'success' => false,
                'error' => 'Failed to create Razorpay order: ' . $message,
            ], 500);
        }
    }

    /**
     * STEP 3: BACKEND - Verify Signature
     * Endpoint: POST /api/verify-payment
     *
     * Algorithm: HMAC-SHA256(order_id + "|" + payment_id, KEY_SECRET)
     * Compare generated signature with razorpay_signature
     * Return success only if signatures match
     */
    public function verifyPayment(Request $request): JsonResponse
    {
        // Support both naming formats (order_id/razorpay_order_id, payment_id/razorpay_payment_id, signature/razorpay_signature)
        $orderId = $request->input('order_id') ?? $request->input('razorpay_order_id');
        $paymentId = $request->input('payment_id') ?? $request->input('razorpay_payment_id');
        $signature = $request->input('signature') ?? $request->input('razorpay_signature');

        // Missing fields: return 400
        if (empty($orderId) || empty($paymentId) || empty($signature)) {
            return response()->json([
                'success' => false,
                'error' => 'Missing required fields. order_id, payment_id, and signature are all required.',
            ], 400);
        }

        $keySecret = config('services.razorpay.key_secret');

        if (empty($keySecret)) {
            Log::error('Razorpay verify-payment error: Missing RAZORPAY_KEY_SECRET in configuration.');
            return response()->json([
                'success' => false,
                'error' => 'Server configuration error: Razorpay secret not set.',
            ], 500);
        }

        // Algorithm: HMAC-SHA256(order_id + "|" + payment_id, KEY_SECRET)
        $payload = $orderId . '|' . $paymentId;
        $expectedSignature = hash_hmac('sha256', $payload, $keySecret);

        // Compare generated signature with razorpay_signature using timing-safe hash_equals
        $isSignatureValid = hash_equals($expectedSignature, (string) $signature);

        if (!$isSignatureValid) {
            // Signature mismatch: return 400, do NOT mark as paid
            Log::warning("Razorpay Signature Verification Failed! Order: {$orderId}, Payment: {$paymentId}");

            // Ensure database order is NOT marked as paid
            $order = Order::where('razorpay_order_id', $orderId)
                ->orWhere('order_number', $request->input('order_number'))
                ->first();

            if ($order && $order->payment_status !== 'paid') {
                $order->update([
                    'payment_status' => 'failed',
                    'razorpay_payment_id' => $paymentId,
                    'razorpay_signature' => $signature,
                ]);
            }

            return response()->json([
                'success' => false,
                'error' => 'Signature mismatch. Payment verification failed.',
            ], 400);
        }

        // Return success only if signatures match
        Log::info("Razorpay Signature Successfully Verified. Order: {$orderId}, Payment: {$paymentId}");

        // If order exists in DB, mark it as paid
        $order = Order::where('razorpay_order_id', $orderId)
            ->orWhere('order_number', $request->input('order_number'))
            ->first();

        if ($order) {
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
                'razorpay_payment_id' => $paymentId,
                'razorpay_signature' => $signature,
                'delivery_status' => $deliveryStatus,
            ]);
        }

        return response()->json([
            'success' => true,
            'message' => 'Payment verified successfully.',
            'order_id' => $orderId,
            'payment_id' => $paymentId,
            'redirect_url' => $order ? route('shop.confirmation', $order->order_number) : null,
        ], 200);
    }
}

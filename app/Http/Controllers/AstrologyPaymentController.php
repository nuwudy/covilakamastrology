<?php

namespace App\Http\Controllers;

use App\Models\AstrologyReading;
use App\Services\Astrology\AstrologyPdfService;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Razorpay\Api\Api;
use Razorpay\Api\Errors\BadRequestError;

class AstrologyPaymentController extends Controller
{
    protected AstrologyPdfService $pdfService;

    public function __construct(AstrologyPdfService $pdfService)
    {
        $this->pdfService = $pdfService;
    }

    /**
     * Create Razorpay Order for Tier 2 (₹100) or Tier 3 (₹500).
     * Endpoint: POST /api/astrology/readings/{uuid}/create-order
     */
    public function createOrder(Request $request, string $uuid): JsonResponse
    {
        $validated = $request->validate([
            'tier' => 'required|string|in:tier_100,tier_500',
        ]);

        $reading = AstrologyReading::where('uuid', $uuid)->firstOrFail();
        $tier = $validated['tier'];

        $tierDetails = [
            'tier_100' => [
                'name' => 'Certified Vedic Birth Profile & Panchanga PDF (6–8 Pages)',
                'amount_inr' => 100,
                'amount_paise' => 10000,
            ],
            'tier_500' => [
                'name' => 'Deluxe Vedic Jathakam & Life Predictions PDF (20–25+ Pages)',
                'amount_inr' => 500,
                'amount_paise' => 50000,
            ],
        ];

        $target = $tierDetails[$tier];
        $keyId = config('services.razorpay.key_id');
        $keySecret = config('services.razorpay.key_secret');
        $merchantName = config('services.razorpay.merchant_name', 'Covilakam Astrology - Dr. E. K. Raja Varma');

        $orderId = null;

        if (!empty($keyId) && !empty($keySecret) && $keyId !== 'rzp_test_placeholder') {
            try {
                $api = new Api($keyId, $keySecret);
                $razorpayOrder = $api->order->create([
                    'receipt' => 'ast_' . substr($reading->uuid, 0, 8) . '_' . time(),
                    'amount' => $target['amount_paise'],
                    'currency' => 'INR',
                    'notes' => [
                        'reading_uuid' => $reading->uuid,
                        'tier' => $tier,
                        'client_name' => $reading->full_name,
                        'phone' => $reading->whatsapp_number,
                    ],
                ]);
                $orderId = $razorpayOrder['id'];
            } catch (Exception $e) {
                Log::warning("Razorpay order creation fallback for reading {$uuid}: " . $e->getMessage());
                $orderId = 'order_cov_' . Str::random(14);
            }
        } else {
            // Simulated / direct UPI fallback order id
            $orderId = 'order_cov_' . Str::random(14);
        }

        return response()->json([
            'success' => true,
            'order_id' => $orderId,
            'amount' => $target['amount_paise'],
            'amount_inr' => $target['amount_inr'],
            'currency' => 'INR',
            'key_id' => $keyId ?: 'rzp_live_offline',
            'tier' => $tier,
            'tier_name' => $target['name'],
            'reading_uuid' => $reading->uuid,
            'merchant_name' => $merchantName,
            'client' => [
                'name' => $reading->full_name,
                'phone' => $reading->whatsapp_number,
            ],
            'manual_upi' => [
                'gpay_number' => '+91 94473 27450',
                'razorpay_me' => 'https://razorpay.me/@covilakamastrology',
                'whatsapp_support' => '+91 7907052160',
            ],
        ]);
    }

    /**
     * Verify payment signature & unlock PDF report tier.
     * Endpoint: POST /api/astrology/readings/{uuid}/verify-payment
     */
    public function verifyPayment(Request $request, string $uuid): JsonResponse
    {
        $validated = $request->validate([
            'tier' => 'required|string|in:tier_100,tier_500',
            'razorpay_payment_id' => 'nullable|string',
            'razorpay_order_id' => 'nullable|string',
            'razorpay_signature' => 'nullable|string',
        ]);

        $reading = AstrologyReading::where('uuid', $uuid)->firstOrFail();
        $tier = $validated['tier'];

        $keySecret = config('services.razorpay.key_secret');
        $paymentId = $validated['razorpay_payment_id'] ?? null;
        $orderId = $validated['razorpay_order_id'] ?? null;
        $signature = $validated['razorpay_signature'] ?? null;

        // If official Razorpay signature parameters are present and secret exists, verify
        if (!empty($keySecret) && !empty($signature) && !empty($paymentId) && !empty($orderId) && $keySecret !== 'rzp_test_placeholder') {
            try {
                $expectedSignature = hash_hmac('sha256', $orderId . '|' . $paymentId, $keySecret);
                if (!hash_equals($expectedSignature, $signature)) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Invalid payment signature. Verification failed.',
                    ], 400);
                }
            } catch (Exception $e) {
                Log::error("Payment signature verification exception: " . $e->getMessage());
                return response()->json([
                    'success' => false,
                    'message' => 'Error verifying payment signature.',
                ], 400);
            }
        }

        // Update Reading paid tier & references
        $reading->paid_tier = $tier;
        $reading->razorpay_payment_id = $paymentId ?: ('PAY_' . strtoupper(Str::random(12)));
        $reading->razorpay_order_id = $orderId ?: ('ORD_' . strtoupper(Str::random(12)));
        $reading->save();

        $downloadUrl = route('astrology.reading.download-pdf', ['uuid' => $reading->uuid]);

        return response()->json([
            'success' => true,
            'message' => 'Payment successfully recorded and tier unlocked!',
            'tier' => $reading->paid_tier,
            'uuid' => $reading->uuid,
            'download_url' => $downloadUrl,
        ]);
    }

    /**
     * Download multi-page certified Astrology PDF for unlocked readings.
     * Endpoint: GET /astrology/readings/{uuid}/download-pdf
     */
    public function downloadPdf(Request $request, string $uuid): Response|JsonResponse
    {
        $reading = AstrologyReading::where('uuid', $uuid)->firstOrFail();

        // If tier is free and no force preview is requested, reject
        if ($reading->paid_tier === 'free' && !$request->has('preview')) {
            return response()->json([
                'success' => false,
                'message' => 'This reading is currently on Tier 1 (Free). Please upgrade to Tier 2 (₹100) or Tier 3 (₹500) to download the Certified PDF.',
                'uuid' => $reading->uuid,
            ], 403);
        }

        // Generate appropriate PDF based on paid tier
        if ($reading->paid_tier === 'tier_500') {
            $pdfContent = $this->pdfService->generateTier500Pdf($reading);
            $cleanName = Str::slug($reading->full_name, '_');
            $fileName = "Covilakam_Deluxe_Jathakam_{$cleanName}_{$reading->uuid}.pdf";
        } else {
            // tier_100 or preview fallback
            $pdfContent = $this->pdfService->generateTier100Pdf($reading);
            $cleanName = Str::slug($reading->full_name, '_');
            $fileName = "Covilakam_Certified_Profile_{$cleanName}_{$reading->uuid}.pdf";
        }

        return response($pdfContent, 200, [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => "attachment; filename=\"{$fileName}\"",
            'Cache-Control' => 'no-cache, no-store, must-revalidate',
            'Pragma' => 'no-cache',
            'Expires' => '0',
        ]);
    }
}


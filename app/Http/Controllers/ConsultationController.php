<?php

namespace App\Http\Controllers;

use App\Models\Consultation;
use App\Services\VedicDobCalculator;
use Illuminate\Http\Request;

class ConsultationController extends Controller
{
    /**
     * Process Free DOB Instant Astro Reading Funnel
     */
    public function calculateDob(Request $request, VedicDobCalculator $calculator)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:120',
            'birth_date' => 'required|date',
            'phone' => 'nullable|string|max:30',
            'service_requested' => 'nullable|string|max:150',
        ]);

        $calculation = $calculator->calculate(
            $validated['birth_date'],
            $validated['name'],
            $validated['service_requested'] ?? 'Comprehensive Astro Consultation'
        );

        // Save consultation lead
        $consultation = Consultation::create([
            'name' => $validated['name'],
            'phone' => $validated['phone'] ?? null,
            'whatsapp_number' => $validated['phone'] ?? null,
            'service_requested' => $validated['service_requested'] ?? 'Free DOB Astro Reading',
            'birth_date' => $validated['birth_date'],
            'calculated_summary' => $calculation,
            'status' => 'dob_calculator_lead',
            'message' => 'Submitted via Free DOB Instant Astro Reading Funnel on Homepage.',
        ]);

        $calculation['consultation_id'] = $consultation->id;
        $calculation['report_url'] = route('consultations.prediction', $consultation->id);

        if ($request->wantsJson() || $request->ajax()) {
            return response()->json([
                'success' => true,
                'data' => $calculation,
            ]);
        }

        return redirect()->to(url()->previous() . '#dob-calculator')
            ->with('dob_result', $calculation)
            ->with('success', 'Your Vedic DOB Reading has been generated successfully!');
    }

    /**
     * View dedicated full prediction report on site.
     */
    public function showPrediction(int $id, VedicDobCalculator $calculator)
    {
        $consultation = Consultation::findOrFail($id);
        $reading = $consultation->calculated_summary;

        if (!$reading || empty($reading['ruling_planet']) || !is_array($reading['ruling_planet']) || empty($reading['name'])) {
            $birthDate = $consultation->birth_date ? $consultation->birth_date->format('Y-m-d') : '1992-04-18';
            $reading = $calculator->calculate(
                $birthDate,
                $consultation->name,
                $consultation->service_requested
            );
            $consultation->update(['calculated_summary' => $reading]);
        }

        return view('consultations.prediction', compact('consultation', 'reading'));
    }

    /**
     * Process Full Consultation Booking
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:120',
            'phone' => 'required|string|max:30',
            'whatsapp_number' => 'nullable|string|max:30',
            'email' => 'nullable|email|max:120',
            'service_requested' => 'required|string|max:150',
            'birth_date' => 'nullable|date',
            'birth_time' => 'nullable|string|max:30',
            'birth_place' => 'nullable|string|max:150',
            'message' => 'nullable|string|max:1000',
        ]);

        $consultation = Consultation::create([
            'name' => $validated['name'],
            'phone' => $validated['phone'],
            'whatsapp_number' => $validated['whatsapp_number'] ?? $validated['phone'],
            'email' => $validated['email'] ?? null,
            'service_requested' => $validated['service_requested'],
            'birth_date' => $validated['birth_date'] ?? null,
            'birth_time' => $validated['birth_time'] ?? null,
            'birth_place' => $validated['birth_place'] ?? null,
            'message' => $validated['message'] ?? null,
            'status' => 'booking_request',
        ]);

        // Construct pre-filled WhatsApp link
        $msg = "Namaskaram Dr. E. K. Raja Varma (Vidya Vachaspathi in Vedic Astrology),\n\n"
            . "I would like to book a consultation on Covilakam Astrology:\n"
            . "• Name: {$validated['name']}\n"
            . "• Service: {$validated['service_requested']}\n"
            . "• Phone: {$validated['phone']}\n"
            . (!empty($validated['birth_date']) ? "• Birth Date: {$validated['birth_date']}\n" : "")
            . (!empty($validated['birth_time']) ? "• Birth Time: {$validated['birth_time']}\n" : "")
            . (!empty($validated['birth_place']) ? "• Birth Place: {$validated['birth_place']}\n" : "")
            . (!empty($validated['message']) ? "• Notes: {$validated['message']}\n\n" : "\n")
            . "Please let me know the available consultation slot. Thank you!";

        $whatsappUrl = 'https://wa.me/917907052160?text=' . rawurlencode($msg);

        if ($request->wantsJson() || $request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Consultation inquiry received! Redirecting to WhatsApp...',
                'whatsapp_url' => $whatsappUrl,
            ]);
        }

        return redirect()->away($whatsappUrl);
    }
}

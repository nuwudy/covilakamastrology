<?php

namespace App\Http\Controllers;

use App\Models\AstrologyReading;
use App\Models\Consultation;
use App\Services\AntiSpamService;
use App\Services\VedicDobCalculator;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

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
            'language' => 'nullable|string|in:en,ml,ta,hi',
            'birth_time' => 'nullable|string|max:30',
            'birth_place' => 'nullable|string|max:150',
        ]);

        $selectedLang = $validated['language'] ?? 'en';
        $birthTime = $validated['birth_time'] ?? null;
        $birthPlace = $validated['birth_place'] ?? null;

        // Anti-spam silent handling: prevent bot entries from polluting leads
        if (AntiSpamService::isSpam($request)) {
            $calculation = $calculator->calculate(
                $validated['birth_date'],
                $validated['name'],
                $validated['service_requested'] ?? 'Accurate Predictions',
                $birthTime,
                $birthPlace
            );
            $calculation['selected_language'] = $selectedLang;
            $calculation['reading_uuid'] = (string) Str::uuid();
            $calculation['consultation_id'] = 0;
            $calculation['report_url'] = url('/#dob-calculator');

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

        $calculation = $calculator->calculate(
            $validated['birth_date'],
            $validated['name'],
            $validated['service_requested'] ?? 'Accurate Predictions',
            $birthTime,
            $birthPlace
        );

        $calculation['selected_language'] = $selectedLang;

        $rulingPlanetName = is_array($calculation['ruling_planet'])
            ? ($calculation['ruling_planet']['en'] ?? 'Surya')
            : $calculation['ruling_planet'];

        $langLabels = [
            'en' => 'English',
            'ml' => 'Malayalam (മലയാളം)',
            'ta' => 'Tamil (தமிழ்)',
            'hi' => 'Hindi (हिन्दी)',
        ];
        $langLabel = $langLabels[$selectedLang] ?? 'English';

        $notes = "DOB Reading ({$langLabel}) | Mulank: {$calculation['mulank']}, Bhagyank: {$calculation['bhagyank']}, Ruling: {$rulingPlanetName}, Gemstone: {$calculation['gemstone_en']}";
        if ($birthTime) {
            $notes .= " | Time: {$birthTime}";
        }
        if ($birthPlace) {
            $notes .= " | Place: {$birthPlace}";
        }

        $userPhone = !empty($validated['phone']) ? trim($validated['phone']) : null;

        // Save consultation lead with pending status for Admin Dashboard collection
        $consultation = Consultation::create([
            'name' => $validated['name'],
            'phone' => $userPhone ?? 'Online Visitor',
            'whatsapp_number' => $userPhone,
            'service_requested' => $validated['service_requested'] ?? 'Free DOB Astro Reading',
            'birth_date' => $validated['birth_date'],
            'calculated_summary' => $calculation,
            'status' => 'pending',
            'message' => $notes,
        ]);

        // Also save to astrology_readings table
        try {
            $readingUuid = (string) Str::uuid();
            $reading = AstrologyReading::create([
                'uuid' => $readingUuid,
                'full_name' => $validated['name'],
                'gender' => $request->input('gender', 'male'),
                'whatsapp_number' => $userPhone,
                'language' => $selectedLang,
                'dob' => $validated['birth_date'],
                'birth_time' => $birthTime ?: '12:00:00',
                'is_approximate_time' => empty($birthTime),
                'birth_place' => $birthPlace ?: 'Ernakulam / Kochi, Kerala, India',
                'latitude' => (float)($request->input('latitude', 9.9312)),
                'longitude' => (float)($request->input('longitude', 76.2673)),
                'timezone' => $request->input('timezone', 'Asia/Kolkata'),
                'chart_data' => $calculation,
                'paid_tier' => 'free',
            ]);
            $calculation['reading_uuid'] = $reading->uuid;
        } catch (\Throwable $e) {
            // Silently continue if reading already exists or database exception
        }

        $calculation['consultation_id'] = $consultation->id;
        $calculation['report_url'] = route('consultations.prediction', $consultation->id);

        try {
            $consultation->update(['calculated_summary' => $calculation]);
        } catch (\Throwable $e) {
            // Ignore if update fails
        }

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
     * Update requested service on an existing consultation lead.
     */
    public function updateService(Request $request, int $id)
    {
        $validated = $request->validate([
            'service_requested' => 'required|string|max:150',
        ]);

        $consultation = Consultation::find($id);
        if ($consultation) {
            $consultation->update([
                'service_requested' => $validated['service_requested'],
            ]);
            return response()->json(['success' => true]);
        }

        return response()->json(['success' => false], 404);
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

        // Ensure rich Dasha hierarchy (Mahadashas, Antardashas, Pratyantardashas) is present
        if (empty($reading['dasha']) || empty($reading['dasha']['mahadashas']) || empty($reading['dasha']['mahadashas'][0]['apaharas'][0]['pratyantardashas'])) {
            try {
                $engine = app(\App\Services\Astrology\AstrologyEngineService::class);
                $birthDate = $consultation->birth_date ? $consultation->birth_date->format('Y-m-d') : '1992-04-18';
                $birthTime = $consultation->birth_time ?: ($reading['birth_time'] ?? '12:00:00');
                $calcInput = [
                    'name' => $consultation->name,
                    'gender' => $reading['gender'] ?? 'male',
                    'dob' => $birthDate,
                    'birth_time' => $birthTime,
                    'is_approximate_time' => empty($consultation->birth_time),
                    'birth_place' => $consultation->birth_place ?: 'Ernakulam / Kochi, Kerala',
                    'latitude' => (float)($reading['latitude'] ?? 9.9312),
                    'longitude' => (float)($reading['longitude'] ?? 76.2673),
                    'timezone' => $reading['timezone'] ?? 'Asia/Kolkata',
                    'phone' => $consultation->phone,
                    'language' => request('lang', 'en'),
                ];
                $fullData = $engine->calculate($calcInput);
                $reading = array_merge($reading ?? [], $fullData);
                $consultation->update(['calculated_summary' => $reading]);
            } catch (\Throwable $e) {
                \Illuminate\Support\Facades\Log::warning('showPrediction full calculation failed: ' . $e->getMessage());
            }
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

        // Anti-spam silent handling for booking inquiries
        if (AntiSpamService::isSpam($request)) {
            if ($request->wantsJson() || $request->ajax()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Consultation inquiry received! Redirecting to WhatsApp...',
                    'whatsapp_url' => 'https://wa.me/917907052160',
                ]);
            }
            return redirect()->away('https://wa.me/917907052160');
        }

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

<?php

namespace App\Http\Controllers;

use App\Models\AstrologyReading;
use App\Models\Consultation;
use App\Services\Astrology\AstrologyEngineService;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class AstrologyReadingController extends Controller
{
    protected AstrologyEngineService $engine;

    public function __construct(AstrologyEngineService $engine)
    {
        $this->engine = $engine;
    }

    /**
     * Compute full Sidereal Vedic Kundali & DOB profile.
     * Endpoint: POST /api/astrology/calculate
     */
    public function calculate(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:120',
            'gender' => 'nullable|string|in:male,female',
            'birth_date' => 'required|string|max:30',
            'birth_time' => 'nullable|string|max:30',
            'is_approximate_time' => 'nullable|boolean',
            'birth_place' => 'nullable|string|max:150',
            'latitude' => 'nullable|numeric|between:-90,90',
            'longitude' => 'nullable|numeric|between:-180,180',
            'timezone' => 'nullable|string|max:60',
            'phone' => 'required|string|min:8|max:30',
            'language' => 'nullable|string|in:en,ml,ta,hi',
        ]);

        // Standardize DOB format to Y-m-d
        $rawDob = trim($validated['birth_date']);
        try {
            $dobCarbon = Carbon::parse($rawDob);
            $dobFormatted = $dobCarbon->format('Y-m-d');
        } catch (\Throwable $e) {
            $dobFormatted = $rawDob;
        }

        // Standardize Birth Time
        $rawTime = trim($validated['birth_time'] ?? '');
        $birthTime = '12:00:00';
        if (!empty($rawTime)) {
            try {
                $timeCarbon = Carbon::parse($rawTime);
                $birthTime = $timeCarbon->format('H:i:s');
            } catch (\Throwable $e) {
                $birthTime = '12:00:00';
            }
        }

        $calcInput = [
            'name' => $validated['name'],
            'gender' => $validated['gender'] ?? 'male',
            'dob' => $dobFormatted,
            'birth_time' => $birthTime,
            'is_approximate_time' => !empty($validated['is_approximate_time']),
            'birth_place' => $validated['birth_place'] ?? 'Ernakulam / Kochi, Kerala, India',
            'latitude' => (float)($validated['latitude'] ?? 9.9312),
            'longitude' => (float)($validated['longitude'] ?? 76.2673),
            'timezone' => $validated['timezone'] ?? 'Asia/Kolkata',
            'language' => $validated['language'] ?? 'en',
        ];

        $chartResult = $this->engine->calculate($calcInput);

        // Persist to astrology_readings table
        $uuid = (string) Str::uuid();
        $reading = AstrologyReading::create([
            'uuid' => $uuid,
            'full_name' => $validated['name'],
            'gender' => $calcInput['gender'],
            'whatsapp_number' => $validated['phone'],
            'language' => $calcInput['language'],
            'dob' => $dobFormatted,
            'birth_time' => $birthTime,
            'is_approximate_time' => $calcInput['is_approximate_time'],
            'birth_place' => $calcInput['birth_place'],
            'latitude' => $calcInput['latitude'],
            'longitude' => $calcInput['longitude'],
            'timezone' => $calcInput['timezone'],
            'chart_data' => $chartResult,
            'paid_tier' => 'free',
        ]);

        // Also track as Consultation lead for admin visibility
        $consultation = Consultation::create([
            'name' => $validated['name'],
            'phone' => $validated['phone'],
            'whatsapp_number' => $validated['phone'],
            'service_requested' => 'Free DOB Astro Reading',
            'birth_date' => $dobFormatted,
            'calculated_summary' => $chartResult,
            'status' => 'pending',
            'message' => "Vedic Reading ({$calcInput['language']}) | Rasi: " . ($chartResult['moon_sign']['name_ml'] ?? '') . " | Lagna: " . ($chartResult['lagna']['name_ml'] ?? '') . " | Dasha: " . ($chartResult['active_dasha']['summary_ml'] ?? ''),
        ]);

        $chartResult['reading_uuid'] = $reading->uuid;
        $chartResult['consultation_id'] = $consultation->id;

        return response()->json([
            'success' => true,
            'uuid' => $reading->uuid,
            'data' => $chartResult,
        ]);
    }
}

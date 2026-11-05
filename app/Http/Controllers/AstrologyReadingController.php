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
     * Universal Birth Place Geocoding endpoint with Google Maps & OpenStreetMap fallback.
     * Endpoint: GET /api/astrology/geocode?q={query}
     */
    public function geocode(Request $request): JsonResponse
    {
        $query = trim($request->query('q', ''));
        if (mb_strlen($query) < 2) {
            return response()->json(['success' => true, 'places' => []]);
        }

        $results = [];

        // 1. Fast local Kerala/India presets check
        $localPresets = [
            'mankada' => ['name' => 'Mankada, Malappuram, Kerala', 'lat' => 11.1000, 'lng' => 76.2000, 'tz' => 'Asia/Kolkata'],
            'malappuram' => ['name' => 'Malappuram, Kerala', 'lat' => 11.0732, 'lng' => 76.0740, 'tz' => 'Asia/Kolkata'],
            'aluva' => ['name' => 'Aluva, Ernakulam, Kerala', 'lat' => 10.1076, 'lng' => 76.3516, 'tz' => 'Asia/Kolkata'],
            'thripunithura' => ['name' => 'Thripunithura, Kochi, Kerala', 'lat' => 9.9507, 'lng' => 76.3496, 'tz' => 'Asia/Kolkata'],
            'muppathadam' => ['name' => 'Muppathadam, Ernakulam, Kerala', 'lat' => 10.0890, 'lng' => 76.3190, 'tz' => 'Asia/Kolkata'],
            'perumbavoor' => ['name' => 'Perumbavoor, Ernakulam, Kerala', 'lat' => 10.1118, 'lng' => 76.4784, 'tz' => 'Asia/Kolkata'],
            'angamaly' => ['name' => 'Angamaly, Ernakulam, Kerala', 'lat' => 10.1960, 'lng' => 76.3860, 'tz' => 'Asia/Kolkata'],
            'paravur' => ['name' => 'North Paravur, Ernakulam, Kerala', 'lat' => 10.1458, 'lng' => 76.2309, 'tz' => 'Asia/Kolkata'],
            'palakkad' => ['name' => 'Palakkad, Kerala', 'lat' => 10.7867, 'lng' => 76.6548, 'tz' => 'Asia/Kolkata'],
            'thrissur' => ['name' => 'Thrissur, Kerala', 'lat' => 10.5276, 'lng' => 76.2144, 'tz' => 'Asia/Kolkata'],
            'kozhikode' => ['name' => 'Kozhikode (Calicut), Kerala', 'lat' => 11.2588, 'lng' => 75.7804, 'tz' => 'Asia/Kolkata'],
            'kannur' => ['name' => 'Kannur, Kerala', 'lat' => 11.8745, 'lng' => 75.3704, 'tz' => 'Asia/Kolkata'],
            'kollam' => ['name' => 'Kollam, Kerala', 'lat' => 8.8932, 'lng' => 76.6141, 'tz' => 'Asia/Kolkata'],
            'thiruvananthapuram' => ['name' => 'Thiruvananthapuram, Kerala', 'lat' => 8.5241, 'lng' => 76.9366, 'tz' => 'Asia/Kolkata'],
            'ernakulam' => ['name' => 'Ernakulam / Kochi, Kerala', 'lat' => 9.9312, 'lng' => 76.2673, 'tz' => 'Asia/Kolkata'],
            'kottayam' => ['name' => 'Kottayam, Kerala', 'lat' => 9.5916, 'lng' => 76.5222, 'tz' => 'Asia/Kolkata'],
            'alappuzha' => ['name' => 'Alappuzha, Kerala', 'lat' => 9.4981, 'lng' => 76.3388, 'tz' => 'Asia/Kolkata'],
            'kasaragod' => ['name' => 'Kasaragod, Kerala', 'lat' => 12.5102, 'lng' => 74.9852, 'tz' => 'Asia/Kolkata'],
            'pathanamthitta' => ['name' => 'Pathanamthitta, Kerala', 'lat' => 9.2648, 'lng' => 76.7870, 'tz' => 'Asia/Kolkata'],
            'idukki' => ['name' => 'Idukki / Thodupuzha, Kerala', 'lat' => 9.8959, 'lng' => 76.7184, 'tz' => 'Asia/Kolkata'],
            'wayanad' => ['name' => 'Wayanad / Kalpetta, Kerala', 'lat' => 11.6103, 'lng' => 76.0828, 'tz' => 'Asia/Kolkata'],
            'guruvayur' => ['name' => 'Guruvayur, Thrissur, Kerala', 'lat' => 10.5946, 'lng' => 76.0416, 'tz' => 'Asia/Kolkata'],
            'tirur' => ['name' => 'Tirur, Malappuram, Kerala', 'lat' => 10.9146, 'lng' => 75.9224, 'tz' => 'Asia/Kolkata'],
            'perinthalmanna' => ['name' => 'Perinthalmanna, Malappuram, Kerala', 'lat' => 10.9760, 'lng' => 76.2254, 'tz' => 'Asia/Kolkata'],
            'ottapalam' => ['name' => 'Ottapalam, Palakkad, Kerala', 'lat' => 10.7734, 'lng' => 76.3811, 'tz' => 'Asia/Kolkata'],
            'changanassery' => ['name' => 'Changanassery, Kottayam, Kerala', 'lat' => 9.4447, 'lng' => 76.5392, 'tz' => 'Asia/Kolkata'],
            'tiruvalla' => ['name' => 'Tiruvalla, Pathanamthitta, Kerala', 'lat' => 9.3835, 'lng' => 76.5741, 'tz' => 'Asia/Kolkata'],
            'kayamkulam' => ['name' => 'Kayamkulam, Alappuzha, Kerala', 'lat' => 9.1726, 'lng' => 76.5004, 'tz' => 'Asia/Kolkata'],
        ];

        $lowerQ = strtolower($query);
        foreach ($localPresets as $key => $preset) {
            if (str_contains($lowerQ, $key) || str_contains(strtolower($preset['name']), $lowerQ)) {
                $results[] = $preset;
            }
        }

        // 2. Google Maps Geocoding API if key configured
        $googleKey = config('services.google.maps_key') ?: env('GOOGLE_MAPS_API_KEY');
        if (!empty($googleKey)) {
            try {
                $response = \Illuminate\Support\Facades\Http::timeout(3)->get('https://maps.googleapis.com/maps/api/geocode/json', [
                    'address' => $query,
                    'key' => $googleKey,
                    'region' => 'in',
                ]);
                if ($response->successful()) {
                    $json = $response->json();
                    foreach ($json['results'] ?? [] as $item) {
                        $name = $item['formatted_address'] ?? $query;
                        $lat = (float)($item['geometry']['location']['lat'] ?? 0);
                        $lng = (float)($item['geometry']['location']['lng'] ?? 0);
                        if ($lat != 0 && $lng != 0) {
                            $results[] = [
                                'name' => $name,
                                'lat' => round($lat, 4),
                                'lng' => round($lng, 4),
                                'tz' => 'Asia/Kolkata',
                            ];
                        }
                    }
                }
            } catch (\Throwable $e) {
                \Illuminate\Support\Facades\Log::warning('Google Maps Geocoding exception: ' . $e->getMessage());
            }
        }

        // 3. Fallback to OpenStreetMap Nominatim API if results < 3
        if (count($results) < 3) {
            try {
                $response = \Illuminate\Support\Facades\Http::timeout(4)
                    ->withHeaders(['User-Agent' => 'CovilakamAstrology/2.0 (info@covilakamastrology.com)'])
                    ->get('https://nominatim.openstreetmap.org/search', [
                        'format' => 'json',
                        'addressdetails' => 1,
                        'limit' => 8,
                        'q' => $query,
                    ]);

                if ($response->successful()) {
                    $items = $response->json();
                    foreach ($items ?? [] as $item) {
                        $disp = $item['display_name'] ?? '';
                        $parts = array_map('trim', explode(',', $disp));
                        // Format clean short place name
                        $shortName = implode(', ', array_slice($parts, 0, 3));
                        $lat = (float)($item['lat'] ?? 0);
                        $lng = (float)($item['lon'] ?? 0);
                        if ($lat != 0 && $lng != 0) {
                            $results[] = [
                                'name' => $shortName ?: $disp,
                                'full_address' => $disp,
                                'lat' => round($lat, 4),
                                'lng' => round($lng, 4),
                                'tz' => 'Asia/Kolkata',
                            ];
                        }
                    }
                }
            } catch (\Throwable $e) {
                \Illuminate\Support\Facades\Log::warning('Nominatim Geocoding exception: ' . $e->getMessage());
            }
        }

        // Deduplicate results by rounded lat/lng
        $unique = [];
        $seen = [];
        foreach ($results as $r) {
            $key = round($r['lat'], 2) . '_' . round($r['lng'], 2);
            if (!isset($seen[$key])) {
                $seen[$key] = true;
                $unique[] = $r;
            }
        }

        return response()->json([
            'success' => true,
            'query' => $query,
            'places' => array_slice($unique, 0, 8),
        ]);
    }

    /**
     * Compute full Sidereal Vedic Kundali & DOB profile.
     * Endpoint: POST /api/astrology/calculate
     */
    public function calculate(Request $request): JsonResponse
    {
        try {
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
                'phone' => 'nullable|string|max:30',
                'language' => 'nullable|string|in:en,ml,ta,hi',
            ]);
        } catch (\Illuminate\Validation\ValidationException $ve) {
            return response()->json([
                'success' => false,
                'message' => collect($ve->errors())->flatten()->first() ?? 'Invalid input data. Please verify your fields.',
                'errors' => $ve->errors(),
            ], 422);
        }

        try {
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

            $phone = !empty($validated['phone']) ? trim($validated['phone']) : null;
            $uuid = (string) Str::uuid();

            // Persist to astrology_readings table (with fallback if migration is pending)
            try {
                $reading = AstrologyReading::create([
                    'uuid' => $uuid,
                    'full_name' => $validated['name'],
                    'gender' => $calcInput['gender'],
                    'whatsapp_number' => $phone,
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
                $chartResult['reading_uuid'] = $reading->uuid;
            } catch (\Throwable $dbe) {
                \Illuminate\Support\Facades\Log::warning('Astrology reading DB save skipped: ' . $dbe->getMessage());
                $chartResult['reading_uuid'] = $uuid;
            }

            // Also track as Consultation lead for admin visibility
            try {
                $consultation = Consultation::create([
                    'name' => $validated['name'],
                    'phone' => $phone ?? 'Online Visitor',
                    'whatsapp_number' => $phone,
                    'service_requested' => 'Free DOB Astro Reading',
                    'birth_date' => $dobFormatted,
                    'calculated_summary' => $chartResult,
                    'status' => 'pending',
                    'message' => "Vedic Reading ({$calcInput['language']}) | Rasi: " . ($chartResult['moon_sign']['name_ml'] ?? '') . " | Lagna: " . ($chartResult['lagna']['name_ml'] ?? '') . " | Dasha: " . ($chartResult['active_dasha']['summary_ml'] ?? ''),
                ]);
                $chartResult['consultation_id'] = $consultation->id;
            } catch (\Throwable $dbe2) {
                \Illuminate\Support\Facades\Log::warning('Consultation lead DB save skipped: ' . $dbe2->getMessage());
            }

            return response()->json([
                'success' => true,
                'uuid' => $chartResult['reading_uuid'],
                'data' => $chartResult,
            ]);
        } catch (\Throwable $e) {
            \Illuminate\Support\Facades\Log::error('Astrology calculate error: ' . $e->getMessage(), [
                'trace' => $e->getTraceAsString(),
                'input' => $request->all(),
            ]);
            return response()->json([
                'success' => false,
                'message' => 'Astrology calculation error: ' . $e->getMessage(),
            ], 500);
        }
    }
}


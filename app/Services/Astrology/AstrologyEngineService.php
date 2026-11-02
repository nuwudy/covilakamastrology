<?php

namespace App\Services\Astrology;

use Carbon\Carbon;

class AstrologyEngineService
{
    protected ChitrapakshaEphemerisService $ephemeris;
    protected PanchangaService $panchanga;
    protected VargaAndBhavaService $vargas;
    protected DashaService $dashas;
    protected AshtakavargaAndDignityService $dignities;
    protected VedangaPredictionService $predictions;

    public function __construct(
        ?ChitrapakshaEphemerisService $ephemeris = null,
        ?PanchangaService $panchanga = null,
        ?VargaAndBhavaService $vargas = null,
        ?DashaService $dashas = null,
        ?AshtakavargaAndDignityService $dignities = null,
        ?VedangaPredictionService $predictions = null
    ) {
        $this->ephemeris = $ephemeris ?? new ChitrapakshaEphemerisService();
        $this->panchanga = $panchanga ?? new PanchangaService();
        $this->vargas = $vargas ?? new VargaAndBhavaService();
        $this->dashas = $dashas ?? new DashaService();
        $this->dignities = $dignities ?? new AshtakavargaAndDignityService();
        $this->predictions = $predictions ?? new VedangaPredictionService($this->ephemeris);
    }

    /**
     * Compute full Vedic Astrology chart & profile according to Vedanga Jyothisham.
     *
     * @param array $input
     * @return array
     */
    public function calculate(array $input): array
    {
        $fullName = trim($input['name'] ?? $input['full_name'] ?? 'Devotee');
        $gender = strtolower(trim($input['gender'] ?? 'male'));
        if (!in_array($gender, ['male', 'female'], true)) {
            $gender = 'male';
        }

        $dob = $input['birth_date'] ?? $input['dob'] ?? Carbon::now()->format('Y-m-d');
        $birthTime = $input['birth_time'] ?? '12:00:00';
        $isApproximate = !empty($input['is_approximate_time']);

        $birthPlace = $input['birth_place'] ?? 'Ernakulam / Kochi, Kerala, India';
        $latitude = (float)($input['latitude'] ?? 9.9312);
        $longitude = (float)($input['longitude'] ?? 76.2673);
        $timezone = $input['timezone'] ?? 'Asia/Kolkata';
        $lang = $input['language'] ?? 'en';

        // 1. Compute Chitrapaksha Planetary Longitudes, Lagna, and Gulika
        $ephem = $this->ephemeris->calculateEphemeris(
            $dob,
            $birthTime,
            $latitude,
            $longitude,
            $timezone
        );

        $planets = $ephem['planets'];
        $lagna = $ephem['lagna'];
        $gulika = $ephem['gulika'];
        $ayanamsa = $ephem['ayanamsa_deg'] ?? 23.85;

        $moonLong = (float)($planets['Mo']['longitude'] ?? 0.0);
        $sunLong = (float)($planets['Su']['longitude'] ?? 0.0);
        $lagnaLong = (float)($lagna['longitude'] ?? 0.0);

        // 2. Compute Panchanga, Rasis, Nakshatra, and Numerology
        $panchangaData = $this->panchanga->calculatePanchanga(
            $sunLong,
            $moonLong,
            Carbon::parse($dob)
        );

        // 3. Compute 12 Bhavas and Shadvargas
        $allBodies = array_merge($planets, [
            'As' => [
                'key' => 'As',
                'name_en' => 'Lagna (Ascendant)',
                'name_ml' => 'ലഗ്നം (Lagna)',
                'longitude' => $lagnaLong,
            ],
            'Md' => [
                'key' => 'Md',
                'name_en' => 'Gulika (Maandhi)',
                'name_ml' => 'ഗുളികൻ (Maandhi)',
                'longitude' => (float)($gulika['longitude'] ?? 0.0),
            ],
        ]);

        $bhavaData = $this->vargas->computeBhavas($lagnaLong, $allBodies);
        $shadvargas = $this->vargas->computeAllShadvargas($allBodies);

        // 4. Compute Vimshottari Dasha timeline & current active period
        $dashaData = $this->dashas->computeVimshottariDasha($moonLong, $dob, $birthTime);

        // 5. Compute Planetary Dignities, Ashtakavarga (337 bindus), Yogas & Gemstone
        $planetDignities = $this->dignities->computePlanetaryDignities($planets);
        $ashtakavarga = $this->dignities->computeAshtakavarga($allBodies);
        $yogas = $this->dignities->computeClassicalYogas($allBodies, $planetDignities);

        $lagnaRasi = $lagna['rasi_index'] ?? ((int)floor($lagnaLong / 30.0) + 1);
        $gemstoneData = $this->dignities->computeGemstoneRecommendation($lagnaRasi, $gender, $planetDignities);

        // Build South Indian Chart cell placements (Rasi D1 & Navamsha D9)
        // Sign index 1 (Aries) .. 12 (Pisces)
        $chartGridD1 = array_fill(1, 12, []);
        $chartGridD9 = array_fill(1, 12, []);

        foreach ($allBodies as $bKey => $bData) {
            $rD1 = $shadvargas[$bKey]['d1_rasi'] ?? 1;
            $rD9 = $shadvargas[$bKey]['d9_navamsha'] ?? 1;

            $dispLabel = $bKey;
            if (!empty($bData['is_retrograde']) && in_array($bKey, ['Ma', 'Me', 'Ju', 'Ve', 'Sa', 'Ra', 'Ke'])) {
                $dispLabel .= ' (R)';
            }

            $chartGridD1[$rD1][] = [
                'key' => $bKey,
                'label' => $dispLabel,
                'name_en' => $bData['name_en'] ?? $bKey,
                'name_ml' => $bData['name_ml'] ?? $bKey,
                'deg' => round($shadvargas[$bKey]['deg_in_rasi'] ?? 0.0, 1),
            ];

            $chartGridD9[$rD9][] = [
                'key' => $bKey,
                'label' => $dispLabel,
                'name_en' => $bData['name_en'] ?? $bKey,
                'name_ml' => $bData['name_ml'] ?? $bKey,
            ];
        }

        // 6. Deep Vedanga Jyothisham Predictions & Transits
        $vedangaPredictions = $this->predictions->evaluateChart([
            'gender' => $gender,
            'lagna' => $lagna,
            'gulika' => $gulika,
            'planets' => $planets,
            'planet_bhavas' => $bhavaData['planet_bhavas'],
            'dignities' => $planetDignities,
            'moon_sign' => $panchangaData['chandra_sign'],
        ], $lang);

        // WhatsApp consultation URL pre-filled with client's exact coordinates
        $waMsg = "Namaskaram Dr. E. K. Raja Varma. I have calculated my Vedic Jathakam on Covilakam Astrology:\n"
            . "- Name: {$fullName}\n"
            . "- DOB: " . Carbon::parse($dob)->format('d-m-Y') . " at " . Carbon::parse($birthTime)->format('h:i A') . "\n"
            . "- Birth Place: {$birthPlace}\n"
            . "- Lagna: " . ($lagna['name_ml'] ?? $lagna['name_en'] ?? '') . "\n"
            . "- Janma Rasi: " . ($panchangaData['chandra_sign']['name_ml'] ?? '') . "\n"
            . "- Nakshatra: " . ($panchangaData['nakshatra']['name_ml'] ?? '') . " (Pada " . ($panchangaData['nakshatra']['pada'] ?? '') . ")\n"
            . "- Active Dasha: " . ($dashaData['active_dasha']['summary_ml'] ?? $dashaData['active_dasha']['summary_en'] ?? '') . "\n"
            . "I would like to book a detailed Vedic consultation with you. Please guide me.";

        $whatsappUrl = 'https://wa.me/917907052160?text=' . rawurlencode($waMsg);

        // Consolidate response
        return [
            'status' => 'success',
            'full_name' => $fullName,
            'gender' => $gender,
            'birth_date' => $dob,
            'birth_time' => $birthTime,
            'is_approximate_time' => $isApproximate,
            'birth_place' => $birthPlace,
            'latitude' => $latitude,
            'longitude' => $longitude,
            'timezone' => $timezone,
            'ayanamsa_deg' => round($ayanamsa, 4),

            // Astronomical & Panchanga
            'solar_sign' => $panchangaData['solar_sign'],
            'moon_sign' => $panchangaData['chandra_sign'],
            'lunar_sign' => $panchangaData['chandra_sign'], // backward compatibility alias
            'lagna' => $lagna,
            'gulika' => $gulika,
            'nakshatra' => $panchangaData['nakshatra'],
            'tithi' => $panchangaData['tithi'],
            'karana' => $panchangaData['karana'],
            'nityayoga' => $panchangaData['nityayoga'],

            // Numerology
            'mulank' => $panchangaData['mulank'],
            'bhagyank' => $panchangaData['bhagyank'],

            // Charts & Vargas
            'planets' => $planets,
            'bhavas' => $bhavaData['bhavas'],
            'planet_bhavas' => $bhavaData['planet_bhavas'],
            'shadvarga' => $shadvargas,
            'chart_grid_d1' => $chartGridD1,
            'chart_grid_d9' => $chartGridD9,

            // Dasha
            'dasha' => $dashaData,
            'garbhashishta' => $dashaData['garbhashishta'],
            'active_dasha' => $dashaData['active_dasha'],

            // Dignity, Ashtakavarga, Yogas
            'dignities' => $planetDignities,
            'ashtakavarga' => $ashtakavarga,
            'yogas' => $yogas,
            'vedanga_predictions' => $vedangaPredictions,

            // Gemstone recommendation
            'gemstone' => $gemstoneData,
            'gemstone_en' => $gemstoneData['gemstone_en'],
            'gemstone_ml' => $gemstoneData['gemstone_ml'],
            'gemstone_ta' => $gemstoneData['gemstone_ta'],
            'gemstone_hi' => $gemstoneData['gemstone_hi'],
            'wearing_rule' => $gemstoneData['wearing_rule'],

            // Links & CTAs
            'whatsapp_url' => $whatsappUrl,
            'tier_upgrades' => [
                'tier_100' => [
                    'title' => 'Certified Birth Profile & Panchanga PDF',
                    'amount' => 100,
                    'features' => [
                        'Complete Sidereal Planetary Longitudes & Vargas',
                        'Detailed 12 Bhava Strengths & Bhavasandhi Analysis',
                        'Vimshottari Dasha & Apahara Timelines',
                        'High-resolution Printable South Indian Kundali',
                    ],
                ],
                'tier_500' => [
                    'title' => 'Deluxe Vedic Jathakam & Life Predictions PDF',
                    'amount' => 500,
                    'features' => [
                        'Complete 25+ Page Vedic Jathakam Portfolio',
                        '337-Point Samudaya Ashtakavarga Analysis',
                        'Comprehensive Classical Yoga Predictions',
                        'Customized Remedial Gemstone & Temple Pariharams',
                        'Certified by Dr. E. K. Raja Varma',
                    ],
                ],
            ],
        ];
    }
}

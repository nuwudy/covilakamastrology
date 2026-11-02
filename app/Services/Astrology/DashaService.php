<?php

namespace App\Services\Astrology;

use Carbon\Carbon;

class DashaService
{
    /**
     * Vimshottari Dasha Lords and their full durations (years).
     * Order from Ketu (1) to Mercury (9).
     */
    public const DASHA_ORDER = [
        [
            'key' => 'Ke',
            'name_en' => 'Ketu',
            'name_ml' => 'കേതു (Ketu)',
            'name_ta' => 'கேது (Ketu)',
            'name_hi' => 'केतु (Ketu)',
            'years' => 7,
        ],
        [
            'key' => 'Ve',
            'name_en' => 'Venus (Shukra)',
            'name_ml' => 'ശുക്രൻ (Shukra)',
            'name_ta' => 'சுக்கிரன் (Shukra)',
            'name_hi' => 'शुक्र (Shukra)',
            'years' => 20,
        ],
        [
            'key' => 'Su',
            'name_en' => 'Sun (Surya)',
            'name_ml' => 'സൂര്യൻ (Surya)',
            'name_ta' => 'சூரியன் (Surya)',
            'name_hi' => 'सूर्य (Surya)',
            'years' => 6,
        ],
        [
            'key' => 'Mo',
            'name_en' => 'Moon (Chandra)',
            'name_ml' => 'ചന്ദ്രൻ (Chandra)',
            'name_ta' => 'சந்திரன் (Chandra)',
            'name_hi' => 'चन्द्र (Chandra)',
            'years' => 10,
        ],
        [
            'key' => 'Ma',
            'name_en' => 'Mars (Kuja)',
            'name_ml' => 'ചൊവ്വ (Kuja)',
            'name_ta' => 'செவ்வாய் (Kuja)',
            'name_hi' => 'मंगल (Kuja)',
            'years' => 7,
        ],
        [
            'key' => 'Ra',
            'name_en' => 'Rahu',
            'name_ml' => 'രാഹു (Rahu)',
            'name_ta' => 'ராகு (Rahu)',
            'name_hi' => 'राहु (Rahu)',
            'years' => 18,
        ],
        [
            'key' => 'Ju',
            'name_en' => 'Jupiter (Guru)',
            'name_ml' => 'വ്യാഴം (Guru)',
            'name_ta' => 'குரு (Guru)',
            'name_hi' => 'गुरु (Guru)',
            'years' => 16,
        ],
        [
            'key' => 'Sa',
            'name_en' => 'Saturn (Shani)',
            'name_ml' => 'ശനി (Shani)',
            'name_ta' => 'சனி (Shani)',
            'name_hi' => 'शनि (Shani)',
            'years' => 19,
        ],
        [
            'key' => 'Me',
            'name_en' => 'Mercury (Budha)',
            'name_ml' => 'ബുധൻ (Budha)',
            'name_ta' => 'புதன் (Budha)',
            'name_hi' => 'बुध (Budha)',
            'years' => 17,
        ],
    ];

    /**
     * Compute Garbhashishta Dasha (Balance at birth) & full 120-year timeline.
     *
     * @param float $moonLongitude Nirayana Sidereal Moon longitude (0..360)
     * @param string $birthDate YYYY-MM-DD
     * @param string $birthTime HH:MM:SS
     * @return array
     */
    public function computeVimshottariDasha(float $moonLongitude, string $birthDate, string $birthTime = '12:00:00'): array
    {
        $moonLongitude = fmod($moonLongitude, 360.0);
        if ($moonLongitude < 0) {
            $moonLongitude += 360.0;
        }

        $nakSpan = 360.0 / 27.0; // 13°20' = 13.33333333°
        $nakIndex = (int)floor($moonLongitude / $nakSpan); // 0..26
        $degInNak = fmod($moonLongitude, $nakSpan);

        // Nakshatra ruler sequence: (nakIndex % 9) maps directly to DASHA_ORDER
        $dashaOrderIndex = $nakIndex % 9;
        $birthLord = self::DASHA_ORDER[$dashaOrderIndex];

        // Traversed & balance fraction
        $traversedFrac = $degInNak / $nakSpan;
        $balanceFrac = 1.0 - $traversedFrac;
        if ($balanceFrac < 0.0) {
            $balanceFrac = 0.0;
        }

        $totalBalanceYears = $birthLord['years'] * $balanceFrac;
        $balYears = (int)floor($totalBalanceYears);
        $remY = $totalBalanceYears - $balYears;
        $totalBalMonths = $remY * 12.0;
        $balMonths = (int)floor($totalBalMonths);
        $remM = $totalBalMonths - $balMonths;
        $balDays = (int)round($remM * 30.4375);

        if ($balDays >= 30) {
            $balDays -= 30;
            $balMonths++;
        }
        if ($balMonths >= 12) {
            $balMonths -= 12;
            $balYears++;
        }

        $birthDt = Carbon::parse("{$birthDate} {$birthTime}");
        $balanceDaysTotal = (int)round($totalBalanceYears * 365.25);
        $firstDashaEnd = (clone $birthDt)->addDays($balanceDaysTotal);

        $balanceInfo = [
            'lord_key' => $birthLord['key'],
            'lord_name_en' => $birthLord['name_en'],
            'lord_name_ml' => $birthLord['name_ml'],
            'lord_name_ta' => $birthLord['name_ta'],
            'lord_name_hi' => $birthLord['name_hi'],
            'full_years' => $birthLord['years'],
            'balance_years' => $balYears,
            'balance_months' => $balMonths,
            'balance_days' => $balDays,
            'balance_fraction' => round($balanceFrac, 4),
            'end_date' => $firstDashaEnd->format('Y-m-d'),
            'summary_en' => "{$birthLord['name_en']} Dasha balance at birth: {$balYears} Years, {$balMonths} Months, {$balDays} Days (up to {$firstDashaEnd->format('d M Y')})",
            'summary_ml' => "ജനന ശിഷ്ട ദശ: {$birthLord['name_ml']} - {$balYears} കൊല്ലം, {$balMonths} മാസം, {$balDays} ദിവസം ({$firstDashaEnd->format('d-m-Y')} വരെ)",
            'summary_ta' => "பிறப்பு திசை இருப்பு: {$birthLord['name_ta']} - {$balYears} வருடம், {$balMonths} மாதம், {$balDays} நாள் ({$firstDashaEnd->format('d-m-Y')} வரை)",
            'summary_hi' => "जन्म शिष्ट दशा: {$birthLord['name_hi']} - {$balYears} वर्ष, {$balMonths} माह, {$balDays} दिन ({$firstDashaEnd->format('d-m-Y')} तक)",
        ];

        // Generate full 120-year sequence of Mahadashas & Apaharas
        $mahadashas = [];
        $currentDate = clone $birthDt;
        $now = Carbon::now();

        $activeMahadasha = null;
        $activeApahara = null;

        for ($i = 0; $i < 9; $i++) {
            $currIndex = ($dashaOrderIndex + $i) % 9;
            $lord = self::DASHA_ORDER[$currIndex];

            $startDate = clone $currentDate;
            if ($i === 0) {
                // First Dasha only lasts the balance duration
                $endDate = clone $firstDashaEnd;
                $durationDays = $balanceDaysTotal;
            } else {
                $durationDays = (int)round($lord['years'] * 365.25);
                $endDate = (clone $startDate)->addDays($durationDays);
            }

            // Calculate 9 Apaharas (Bhuktis) within this Mahadasha
            $apaharas = [];
            $apaharaCursor = clone $startDate;

            for ($j = 0; $j < 9; $j++) {
                $subIndex = ($currIndex + $j) % 9;
                $subLord = self::DASHA_ORDER[$subIndex];

                // Standard full Apahara years = (Maha_years * Sub_years) / 120
                $fullApaharaYears = ($lord['years'] * $subLord['years']) / 120.0;
                $fullApaharaDays = $fullApaharaYears * 365.25;

                if ($i === 0) {
                    // Scale proportionally for the first partial Mahadasha
                    $apaharaDays = (int)round($fullApaharaDays * $balanceFrac);
                } else {
                    $apaharaDays = (int)round($fullApaharaDays);
                }

                if ($apaharaDays < 1) {
                    $apaharaDays = 1;
                }

                $apStart = clone $apaharaCursor;
                $apEnd = (clone $apStart)->addDays($apaharaDays);
                $apaharaCursor = clone $apEnd;

                $isApActive = $now->between($apStart, $apEnd);

                $apaharaEntry = [
                    'sub_lord_key' => $subLord['key'],
                    'sub_lord_en' => $subLord['name_en'],
                    'sub_lord_ml' => $subLord['name_ml'],
                    'sub_lord_ta' => $subLord['name_ta'],
                    'sub_lord_hi' => $subLord['name_hi'],
                    'start_date' => $apStart->format('Y-m-d'),
                    'end_date' => $apEnd->format('Y-m-d'),
                    'is_active' => $isApActive,
                ];

                $apaharas[] = $apaharaEntry;

                if ($isApActive) {
                    $activeApahara = $apaharaEntry;
                }
            }

            $isMahaActive = $now->between($startDate, $endDate);

            $mahaEntry = [
                'lord_key' => $lord['key'],
                'lord_name_en' => $lord['name_en'],
                'lord_name_ml' => $lord['name_ml'],
                'lord_name_ta' => $lord['name_ta'],
                'lord_name_hi' => $lord['name_hi'],
                'start_date' => $startDate->format('Y-m-d'),
                'end_date' => $endDate->format('Y-m-d'),
                'is_active' => $isMahaActive,
                'apaharas' => $apaharas,
            ];

            $mahadashas[] = $mahaEntry;

            if ($isMahaActive) {
                $activeMahadasha = $mahaEntry;
            }

            $currentDate = clone $endDate;
        }

        // Fallback for active if outside 120 years or edge
        if (!$activeMahadasha && !empty($mahadashas)) {
            $activeMahadasha = $mahadashas[0];
            $activeApahara = $mahadashas[0]['apaharas'][0] ?? null;
        }

        return [
            'garbhashishta' => $balanceInfo,
            'active_dasha' => [
                'mahadasha' => $activeMahadasha['lord_name_en'] ?? 'N/A',
                'mahadasha_ml' => $activeMahadasha['lord_name_ml'] ?? 'N/A',
                'mahadasha_ta' => $activeMahadasha['lord_name_ta'] ?? 'N/A',
                'mahadasha_hi' => $activeMahadasha['lord_name_hi'] ?? 'N/A',
                'apahara' => $activeApahara['sub_lord_en'] ?? 'N/A',
                'apahara_ml' => $activeApahara['sub_lord_ml'] ?? 'N/A',
                'apahara_ta' => $activeApahara['sub_lord_ta'] ?? 'N/A',
                'apahara_hi' => $activeApahara['sub_lord_hi'] ?? 'N/A',
                'start_date' => $activeApahara['start_date'] ?? '',
                'end_date' => $activeApahara['end_date'] ?? '',
                'summary_en' => ($activeMahadasha['lord_name_en'] ?? '') . ' - ' . ($activeApahara['sub_lord_en'] ?? ''),
                'summary_ml' => ($activeMahadasha['lord_name_ml'] ?? '') . ' - ' . ($activeApahara['sub_lord_ml'] ?? ''),
                'summary_ta' => ($activeMahadasha['lord_name_ta'] ?? '') . ' - ' . ($activeApahara['sub_lord_ta'] ?? ''),
                'summary_hi' => ($activeMahadasha['lord_name_hi'] ?? '') . ' - ' . ($activeApahara['sub_lord_hi'] ?? ''),
            ],
            'mahadashas' => $mahadashas,
        ];
    }
}

<?php

namespace App\Services\Astrology;

class AshtakavargaAndDignityService
{
    /**
     * Rasi ownership lords (1 to 12).
     */
    public const RASI_LORDS = [
        1 => 'Ma', // Mesha - Mars
        2 => 'Ve', // Vrishabha - Venus
        3 => 'Me', // Mithuna - Mercury
        4 => 'Mo', // Karkidakam - Moon
        5 => 'Su', // Simha - Sun
        6 => 'Me', // Kanni - Mercury
        7 => 'Ve', // Thula - Venus
        8 => 'Ma', // Vrishchika - Mars
        9 => 'Ju', // Dhanu - Jupiter
        10 => 'Sa', // Makara - Saturn
        11 => 'Sa', // Kumbha - Saturn
        12 => 'Ju', // Meena - Jupiter
    ];

    /**
     * Planetary exaltation, debilitation, and own signs.
     */
    public const DIGNITIES = [
        'Su' => [
            'name_en' => 'Sun (Surya)',
            'name_ml' => 'സൂര്യൻ (Surya)',
            'uccha_rasi' => 1,
            'deep_uccha_deg' => 10.0,
            'neecha_rasi' => 7,
            'deep_neecha_deg' => 10.0,
            'own_rasis' => [5],
            'moolatrikona_rasi' => 5,
            'moolatrikona_range' => [0.0, 20.0],
        ],
        'Mo' => [
            'name_en' => 'Moon (Chandra)',
            'name_ml' => 'ചന്ദ്രൻ (Chandra)',
            'uccha_rasi' => 2,
            'deep_uccha_deg' => 3.0,
            'neecha_rasi' => 8,
            'deep_neecha_deg' => 3.0,
            'own_rasis' => [4],
            'moolatrikona_rasi' => 2,
            'moolatrikona_range' => [3.0, 30.0],
        ],
        'Ma' => [
            'name_en' => 'Mars (Kuja)',
            'name_ml' => 'ചൊവ്വ (Kuja)',
            'uccha_rasi' => 10,
            'deep_uccha_deg' => 28.0,
            'neecha_rasi' => 4,
            'deep_neecha_deg' => 28.0,
            'own_rasis' => [1, 8],
            'moolatrikona_rasi' => 1,
            'moolatrikona_range' => [0.0, 12.0],
        ],
        'Me' => [
            'name_en' => 'Mercury (Budha)',
            'name_ml' => 'ബുധൻ (Budha)',
            'uccha_rasi' => 6,
            'deep_uccha_deg' => 15.0,
            'neecha_rasi' => 12,
            'deep_neecha_deg' => 15.0,
            'own_rasis' => [3, 6],
            'moolatrikona_rasi' => 6,
            'moolatrikona_range' => [15.0, 20.0],
        ],
        'Ju' => [
            'name_en' => 'Jupiter (Guru)',
            'name_ml' => 'വ്യാഴം (Guru)',
            'uccha_rasi' => 4,
            'deep_uccha_deg' => 5.0,
            'neecha_rasi' => 10,
            'deep_neecha_deg' => 5.0,
            'own_rasis' => [9, 12],
            'moolatrikona_rasi' => 9,
            'moolatrikona_range' => [0.0, 10.0],
        ],
        'Ve' => [
            'name_en' => 'Venus (Shukra)',
            'name_ml' => 'ശുക്രൻ (Shukra)',
            'uccha_rasi' => 12,
            'deep_uccha_deg' => 27.0,
            'neecha_rasi' => 6,
            'deep_neecha_deg' => 27.0,
            'own_rasis' => [2, 7],
            'moolatrikona_rasi' => 7,
            'moolatrikona_range' => [0.0, 15.0],
        ],
        'Sa' => [
            'name_en' => 'Saturn (Shani)',
            'name_ml' => 'ശനി (Shani)',
            'uccha_rasi' => 7,
            'deep_uccha_deg' => 20.0,
            'neecha_rasi' => 1,
            'deep_neecha_deg' => 20.0,
            'own_rasis' => [10, 11],
            'moolatrikona_rasi' => 11,
            'moolatrikona_range' => [0.0, 20.0],
        ],
        'Ra' => [
            'name_en' => 'Rahu',
            'name_ml' => 'രാഹു (Rahu)',
            'uccha_rasi' => 2, // Taurus / Gemini
            'deep_uccha_deg' => 15.0,
            'neecha_rasi' => 8, // Scorpio / Sagittarius
            'deep_neecha_deg' => 15.0,
            'own_rasis' => [11], // Aquarius co-lord
            'moolatrikona_rasi' => 3,
            'moolatrikona_range' => [0.0, 30.0],
        ],
        'Ke' => [
            'name_en' => 'Ketu',
            'name_ml' => 'കേതു (Ketu)',
            'uccha_rasi' => 8,
            'deep_uccha_deg' => 15.0,
            'neecha_rasi' => 2,
            'deep_neecha_deg' => 15.0,
            'own_rasis' => [8], // Scorpio co-lord
            'moolatrikona_rasi' => 9,
            'moolatrikona_range' => [0.0, 30.0],
        ],
    ];

    /**
     * Exact Ashtakavarga Bindu matrices (Pages 61-67 of Vedanga Jyothisham).
     * [Planet Being Computed => [Reference Body => [Houses from Reference]]]
     */
    public const ASHTAKAVARGA_RULES = [
        // SUN (Surya) - 48 bindus
        'Su' => [
            'Su' => [1, 2, 4, 7, 8, 9, 10, 11],
            'Mo' => [3, 6, 10, 11],
            'Ma' => [1, 2, 4, 7, 8, 9, 10, 11],
            'Me' => [3, 5, 6, 9, 10, 11, 12],
            'Ju' => [5, 6, 9, 11],
            'Ve' => [6, 7, 12],
            'Sa' => [1, 2, 4, 7, 8, 9, 10, 11],
            'As' => [3, 4, 6, 10, 11, 12],
        ],
        // MOON (Chandra) - 49 bindus
        'Mo' => [
            'Su' => [3, 6, 7, 8, 10, 11],
            'Mo' => [1, 3, 6, 7, 10, 11],
            'Ma' => [2, 3, 5, 6, 9, 10, 11],
            'Me' => [1, 3, 4, 5, 7, 8, 10, 11],
            'Ju' => [1, 4, 7, 8, 10, 11, 12],
            'Ve' => [3, 4, 5, 7, 9, 10, 11],
            'Sa' => [3, 5, 6, 11],
            'As' => [3, 6, 10, 11],
        ],
        // MARS (Kuja) - 39 bindus
        'Ma' => [
            'Su' => [3, 5, 6, 10, 11],
            'Mo' => [3, 6, 11],
            'Ma' => [1, 2, 4, 7, 8, 10, 11],
            'Me' => [3, 5, 6, 11],
            'Ju' => [6, 10, 11, 12],
            'Ve' => [6, 8, 11, 12],
            'Sa' => [1, 4, 7, 8, 9, 10, 11],
            'As' => [1, 3, 6, 10, 11],
        ],
        // MERCURY (Budha) - 54 bindus
        'Me' => [
            'Su' => [5, 6, 9, 11, 12],
            'Mo' => [2, 4, 6, 8, 10, 11],
            'Ma' => [1, 2, 4, 7, 8, 9, 10, 11],
            'Me' => [1, 3, 5, 6, 9, 10, 11, 12],
            'Ju' => [6, 8, 11, 12],
            'Ve' => [1, 2, 3, 4, 5, 8, 9, 11],
            'Sa' => [1, 2, 4, 7, 8, 9, 10, 11],
            'As' => [1, 2, 4, 6, 8, 10, 11],
        ],
        // JUPITER (Guru) - 56 bindus
        'Ju' => [
            'Su' => [1, 2, 3, 4, 7, 8, 9, 10, 11],
            'Mo' => [2, 5, 7, 9, 11],
            'Ma' => [1, 2, 4, 7, 8, 10, 11],
            'Me' => [1, 2, 4, 5, 6, 9, 10, 11],
            'Ju' => [1, 2, 3, 4, 7, 8, 10, 11],
            'Ve' => [2, 5, 6, 9, 10, 11],
            'Sa' => [3, 5, 6, 12],
            'As' => [1, 2, 4, 5, 6, 7, 9, 10, 11],
        ],
        // VENUS (Shukra) - 52 bindus
        'Ve' => [
            'Su' => [8, 11, 12],
            'Mo' => [1, 2, 3, 4, 5, 8, 9, 11, 12],
            'Ma' => [3, 4, 6, 9, 11, 12],
            'Me' => [3, 5, 6, 9, 11],
            'Ju' => [5, 8, 9, 10, 11],
            'Ve' => [1, 2, 3, 4, 5, 8, 9, 10, 11],
            'Sa' => [3, 4, 5, 8, 9, 10, 11],
            'As' => [1, 2, 3, 4, 5, 8, 9, 11],
        ],
        // SATURN (Shani) - 39 bindus
        'Sa' => [
            'Su' => [1, 2, 4, 7, 8, 10, 11],
            'Mo' => [3, 6, 11],
            'Ma' => [3, 5, 6, 10, 11, 12],
            'Me' => [6, 8, 9, 10, 11, 12],
            'Ju' => [5, 6, 11, 12],
            'Ve' => [6, 11, 12],
            'Sa' => [3, 5, 6, 11],
            'As' => [1, 3, 4, 6, 10, 11],
        ],
    ];

    /**
     * Compute Dignity for all planets (Uccha, Neecha, Moolatrikona, Swakshetra, Mitra, Shatru, Sama).
     *
     * @param array $planets
     * @return array
     */
    public function computePlanetaryDignities(array $planets): array
    {
        $dignities = [];

        foreach ($planets as $key => $pData) {
            $long = (float)($pData['longitude'] ?? 0.0);
            $rasi = (int)floor($long / 30.0) + 1;
            $degInRasi = fmod($long, 30.0);

            $meta = self::DIGNITIES[$key] ?? null;
            if (!$meta) {
                continue;
            }

            $status = 'neutral';
            $statusEn = 'Neutral Sign (Sama)';
            $statusMl = 'സമക്ഷേത്രം (Sama)';
            $points = 50;

            if ($rasi === $meta['uccha_rasi']) {
                $status = 'exalted';
                $distFromDeep = abs($degInRasi - $meta['deep_uccha_deg']);
                $statusEn = ($distFromDeep <= 3.0) ? 'Deep Exaltation (Parama Uccha)' : 'Exalted (Uccha)';
                $statusMl = ($distFromDeep <= 3.0) ? 'പരമോച്ചം (Parama Uccha)' : 'ഉച്ചക്ഷേത്രം (Uccha)';
                $points = 100 - (int)round($distFromDeep);
            } elseif ($rasi === $meta['neecha_rasi']) {
                $status = 'debilitated';
                $distFromDeep = abs($degInRasi - $meta['deep_neecha_deg']);
                $statusEn = ($distFromDeep <= 3.0) ? 'Deep Debilitation (Parama Neecha)' : 'Debilitated (Neecha)';
                $statusMl = ($distFromDeep <= 3.0) ? 'പരമനീചം (Parama Neecha)' : 'നീചക്ഷേത്രം (Neecha)';
                $points = 10 + (int)round($distFromDeep);
            } elseif ($rasi === $meta['moolatrikona_rasi'] && $degInRasi >= $meta['moolatrikona_range'][0] && $degInRasi <= $meta['moolatrikona_range'][1]) {
                $status = 'moolatrikona';
                $statusEn = 'Moolatrikona (Highly Auspicious)';
                $statusMl = 'മൂലത്രികോണം (Moolatrikona)';
                $points = 85;
            } elseif (in_array($rasi, $meta['own_rasis'], true)) {
                $status = 'own';
                $statusEn = 'Own Sign (Swakshetra)';
                $statusMl = 'സ്വക്ഷേത്രം (Swakshetra)';
                $points = 75;
            }

            $dignities[$key] = [
                'planet_key' => $key,
                'name_en' => $meta['name_en'],
                'name_ml' => $meta['name_ml'],
                'rasi' => $rasi,
                'deg_in_rasi' => round($degInRasi, 2),
                'status' => $status,
                'status_en' => $statusEn,
                'status_ml' => $statusMl,
                'strength_score' => $points,
                'is_combust' => !empty($pData['is_combust']),
                'is_retrograde' => !empty($pData['is_retrograde']),
            ];
        }

        return $dignities;
    }

    /**
     * Compute Bhinna Ashtakavarga (BAV) for 7 planets & Samudaya Ashtakavarga (SAV - 337 points).
     *
     * @param array $allBodies Must include Su, Mo, Ma, Me, Ju, Ve, Sa, and As (Lagna)
     * @return array
     */
    public function computeAshtakavarga(array $allBodies): array
    {
        // Extract Rasi (1..12) for each reference body
        $positions = [];
        foreach (['Su', 'Mo', 'Ma', 'Me', 'Ju', 'Ve', 'Sa', 'As'] as $k) {
            $long = (float)($allBodies[$k]['longitude'] ?? 0.0);
            $positions[$k] = (int)floor(fmod($long + 360.0, 360.0) / 30.0) + 1;
        }

        $bav = [];
        $sav = array_fill(1, 12, 0);

        foreach (self::ASHTAKAVARGA_RULES as $planetKey => $refRules) {
            $rasiPoints = array_fill(1, 12, 0);

            foreach ($refRules as $refKey => $houses) {
                $refRasi = $positions[$refKey] ?? 1;

                foreach ($houses as $house) {
                    // Target Rasi = refRasi + house - 1
                    $targetRasi = (($refRasi - 1 + ($house - 1)) % 12) + 1;
                    $rasiPoints[$targetRasi]++;
                }
            }

            $planetTotal = array_sum($rasiPoints);
            $bav[$planetKey] = [
                'planet_key' => $planetKey,
                'points_by_rasi' => $rasiPoints,
                'total_points' => $planetTotal,
            ];

            // Add to Samudaya Ashtakavarga
            for ($r = 1; $r <= 12; $r++) {
                $sav[$r] += $rasiPoints[$r];
            }
        }

        $savTotal = array_sum($sav); // Grand total: exactly 337 points

        return [
            'bav' => $bav,
            'sav' => $sav,
            'sav_total' => $savTotal,
            'average_per_rasi' => round($savTotal / 12.0, 1), // 28.1
        ];
    }

    /**
     * Identify Classical Yogas per Vedanga Jyothisham Pages 52–56.
     *
     * @param array $allBodies Positions with longitude & Rasi
     * @param array $dignities
     * @return array
     */
    public function computeClassicalYogas(array $allBodies, array $dignities): array
    {
        $yogas = [];

        $lagnaRasi = (int)floor(fmod(($allBodies['As']['longitude'] ?? 0.0) + 360.0, 360.0) / 30.0) + 1;
        $moonRasi = (int)floor(fmod(($allBodies['Mo']['longitude'] ?? 0.0) + 360.0, 360.0) / 30.0) + 1;
        $sunRasi = (int)floor(fmod(($allBodies['Su']['longitude'] ?? 0.0) + 360.0, 360.0) / 30.0) + 1;
        $mercuryRasi = (int)floor(fmod(($allBodies['Me']['longitude'] ?? 0.0) + 360.0, 360.0) / 30.0) + 1;
        $marsRasi = (int)floor(fmod(($allBodies['Ma']['longitude'] ?? 0.0) + 360.0, 360.0) / 30.0) + 1;
        $jupiterRasi = (int)floor(fmod(($allBodies['Ju']['longitude'] ?? 0.0) + 360.0, 360.0) / 30.0) + 1;
        $venusRasi = (int)floor(fmod(($allBodies['Ve']['longitude'] ?? 0.0) + 360.0, 360.0) / 30.0) + 1;
        $saturnRasi = (int)floor(fmod(($allBodies['Sa']['longitude'] ?? 0.0) + 360.0, 360.0) / 30.0) + 1;

        // Helper: House from reference (1..12)
        $houseFrom = function (int $targetRasi, int $refRasi): int {
            return (($targetRasi - $refRasi + 12) % 12) + 1;
        };

        // 1. PANCHAMAHAPURUSHA YOGAS (Kendra from Lagna in Own or Exalted Sign)
        $kendraHouses = [1, 4, 7, 10];

        // Mars: Ruchaka Yoga
        $marsHouseFromLagna = $houseFrom($marsRasi, $lagnaRasi);
        if (in_array($marsHouseFromLagna, $kendraHouses, true) && in_array($dignities['Ma']['status'] ?? '', ['exalted', 'own', 'moolatrikona'], true)) {
            $yogas[] = [
                'name_en' => 'Ruchaka Mahapurusha Yoga',
                'name_ml' => 'രുചക മഹാപുരുഷ യോഗം',
                'name_ta' => 'ருசக யோகம்',
                'name_hi' => 'रुचक महापुरुष योग',
                'description_en' => 'Formed by exalted or own Mars in a Kendra. Bestows courage, leadership, commanding authority, real estate prowess, and victory over adversaries.',
                'description_ml' => 'ചൊവ്വ സ്വക്ഷേത്രത്തിലോ ഉച്ചത്തിലോ കേന്ദ്രഭാവത്തിൽ നിൽക്കുന്നതിനാൽ ധീരത, ഭൂസ്വത്ത്, നേതൃപാടവം, ശത്രുജയം എന്നിവ പ്രദാനം ചെയ്യുന്നു.',
            ];
        }

        // Mercury: Bhadra Yoga
        $mercuryHouseFromLagna = $houseFrom($mercuryRasi, $lagnaRasi);
        if (in_array($mercuryHouseFromLagna, $kendraHouses, true) && in_array($dignities['Me']['status'] ?? '', ['exalted', 'own', 'moolatrikona'], true)) {
            $yogas[] = [
                'name_en' => 'Bhadra Mahapurusha Yoga',
                'name_ml' => 'ഭദ്ര മഹാപുരുഷ യോഗം',
                'name_ta' => 'பத்ர யோகம்',
                'name_hi' => 'भद्र महापुरुष योग',
                'description_en' => 'Formed by Mercury in own/exaltation in a Kendra. Bestows sharp analytical intellect, business acumen, eloquence, and longevity.',
                'description_ml' => 'ബുധൻ കേന്ദ്രത്തിൽ സ്വക്ഷേത്രത്തിലോ ഉച്ചത്തിലോ നിൽക്കുന്ന വിശിഷ്ട യോഗം. സൂക്ഷ്മ ബുദ്ധി, വ്യാപാര വിജയം, വാഗ്സാമർത്ഥ്യം എന്നിവ ഫലം.',
            ];
        }

        // Jupiter: Hamsa Yoga
        $jupiterHouseFromLagna = $houseFrom($jupiterRasi, $lagnaRasi);
        if (in_array($jupiterHouseFromLagna, $kendraHouses, true) && in_array($dignities['Ju']['status'] ?? '', ['exalted', 'own', 'moolatrikona'], true)) {
            $yogas[] = [
                'name_en' => 'Hamsa Mahapurusha Yoga',
                'name_ml' => 'ഹംസ മഹാപുരുഷ യോഗം',
                'name_ta' => 'ஹம்ச யோகம்',
                'name_hi' => 'हंस महापुरुष योग',
                'description_en' => 'Formed by Jupiter in Kendra in own/exaltation. Bestows spiritual wisdom, high social honor, ethical prosperity, and righteous renown.',
                'description_ml' => 'വ്യാഴം കേന്ദ്രത്തിൽ ഉച്ചത്തിലോ സ്വക്ഷേത്രത്തിലോ ഉള്ള യോഗം. ജ്ഞാനം, ഉന്നത പദവി, സദാചാര നിഷ്ഠ, ദൈവാനുഗ്രഹം എന്നിവ നൽകുന്നു.',
            ];
        }

        // Venus: Malavya Yoga
        $venusHouseFromLagna = $houseFrom($venusRasi, $lagnaRasi);
        if (in_array($venusHouseFromLagna, $kendraHouses, true) && in_array($dignities['Ve']['status'] ?? '', ['exalted', 'own', 'moolatrikona'], true)) {
            $yogas[] = [
                'name_en' => 'Malavya Mahapurusha Yoga',
                'name_ml' => 'മാളവ്യ മഹാപുരുഷ യോഗം',
                'name_ta' => 'மாளவ்ய யோகம்',
                'name_hi' => 'मालव्य महापुरुष योग',
                'description_en' => 'Formed by Venus in Kendra in own/exaltation. Bestows aesthetic elegance, luxurious vehicles, happy family life, and creative fame.',
                'description_ml' => 'ശുക്രൻ കേന്ദ്രത്തിൽ ഉച്ചത്തിലോ സ്വക്ഷേത്രത്തിലോ നിൽക്കുന്ന യോഗം. ഐശ്വര്യം, കലാവാസന, വാഹനാദി സൗഭാഗ്യങ്ങൾ എന്നിവ ഉറപ്പാക്കുന്നു.',
            ];
        }

        // Saturn: Sasa Yoga
        $saturnHouseFromLagna = $houseFrom($saturnRasi, $lagnaRasi);
        if (in_array($saturnHouseFromLagna, $kendraHouses, true) && in_array($dignities['Sa']['status'] ?? '', ['exalted', 'own', 'moolatrikona'], true)) {
            $yogas[] = [
                'name_en' => 'Sasa Mahapurusha Yoga',
                'name_ml' => 'ശശ മഹാപുരുഷ യോഗം',
                'name_ta' => 'சச யோகம்',
                'name_hi' => 'शश महापुरुष योग',
                'description_en' => 'Formed by Saturn in Kendra in own/exaltation. Bestows enduring perseverance, administrative power, public authority, and mastery over mass organizations.',
                'description_ml' => 'ശനി കേന്ദ്രത്തിൽ സ്വക്ഷേത്രത്തിലോ ഉച്ചത്തിലോ സ്ഥിതിചെയ്യുന്ന യോഗം. ദൃഢനിശ്ചയം, ജനപിന്തുണ, ഭരണാധികാരം എന്നിവ ഫലം.',
            ];
        }

        // 2. GAJAKESARI YOGA (Jupiter in Kendra 1, 4, 7, 10 from Moon)
        $jupFromMoon = $houseFrom($jupiterRasi, $moonRasi);
        if (in_array($jupFromMoon, [1, 4, 7, 10], true)) {
            $yogas[] = [
                'name_en' => 'Gajakesari Yoga',
                'name_ml' => 'ഗജകേസരി യോഗം',
                'name_ta' => 'கஜகேசரி யோகம்',
                'name_hi' => 'गजकेसरी योग',
                'description_en' => 'Jupiter occupies an auspicious angle (Kendra) from the Moon. Conveys invincibility, lasting name and fame, noble character, and immense wisdom.',
                'description_ml' => 'ചന്ദ്രനിൽ നിന്ന് വ്യാഴം കേന്ദ്രത്തിൽ (1, 4, 7, 10 ഭാവങ്ങളിൽ) നിൽക്കുന്ന മഹാഭാഗ്യ യോഗം. അചഞ്ചലമായ യശസ്സും ഉന്നത സ്ഥാനമാനങ്ങളും നൽകുന്നു.',
            ];
        }

        // 3. BUDHADITYA YOGA (Sun + Mercury conjunct in same Rasi, not combust)
        if ($sunRasi === $mercuryRasi && empty($allBodies['Me']['is_combust'])) {
            $yogas[] = [
                'name_en' => 'Budhaditya Yoga (Nipuna Yoga)',
                'name_ml' => 'ബുധാദിത്യ യോഗം (നിപുണ യോഗം)',
                'name_ta' => 'புதாதித்ய யோகம்',
                'name_hi' => 'बुधादित्य योग',
                'description_en' => 'Sun and Mercury conjunct in the same sign without combustion. Bestows intellectual brilliance, mathematical skill, scholarship, and executive dexterity.',
                'description_ml' => 'സൂര്യനും ബുധനും ഒരേ രാശിയിൽ ഒന്നിച്ചുനിൽക്കുന്ന യോഗം. പാണ്ഡിത്യം, ഭരണസാമർത്ഥ്യം, ബുദ്ധിശക്തി, പ്രശസ്തി എന്നിവ പ്രദാനം ചെയ്യുന്നു.',
            ];
        }

        // 4. CHANDRA YOGAS: Sunapha, Anapha, Durudhura, Kemadruma
        $planets2ndFromMoon = [];
        $planets12thFromMoon = [];
        $kendraPlanetsFromMoon = [];

        foreach (['Ma', 'Me', 'Ju', 'Ve', 'Sa'] as $pk) {
            $pRasi = (int)floor(fmod(($allBodies[$pk]['longitude'] ?? 0.0) + 360.0, 360.0) / 30.0) + 1;
            $hMoon = $houseFrom($pRasi, $moonRasi);
            if ($hMoon === 2) {
                $planets2ndFromMoon[] = $pk;
            } elseif ($hMoon === 12) {
                $planets12thFromMoon[] = $pk;
            } elseif (in_array($hMoon, [1, 4, 7, 10], true)) {
                $kendraPlanetsFromMoon[] = $pk;
            }
        }

        if (!empty($planets2ndFromMoon) && !empty($planets12thFromMoon)) {
            $yogas[] = [
                'name_en' => 'Durudhura Yoga',
                'name_ml' => 'ദുരുധുര യോഗം',
                'name_ta' => 'துருதுர யோகம்',
                'name_hi' => 'दुरुधुरा योग',
                'description_en' => 'Planets occupy both the 2nd and 12th houses from Moon. Bestows abundant conveyances, generous disposition, and lasting material comforts.',
                'description_ml' => 'ചന്ദ്രന്റെ ഇരുവശങ്ങളിലും (രണ്ടിലും പന്ത്രണ്ടിലും) ഗ്രഹങ്ങൾ നിൽക്കുന്ന യോഗം. സർവ്വ സുഖസൗകര്യങ്ങളും ഉദാരമനസ്സും ധനാഭിവൃദ്ധിയും ഫലം.',
            ];
        } elseif (!empty($planets2ndFromMoon)) {
            $yogas[] = [
                'name_en' => 'Sunapha Yoga',
                'name_ml' => 'സുനഫാ യോഗം',
                'name_ta' => 'சுனபா யோகம்',
                'name_hi' => 'सुनफा योग',
                'description_en' => 'Planets in the 2nd house from Moon. Endows self-earned prosperity, eloquence, and respected status.',
                'description_ml' => 'ചന്ദ്രന്റെ രണ്ടാം ഭാവത്തിൽ ഗ്രഹങ്ങൾ സ്ഥിതിചെയ്യുന്ന യോഗം. സ്വന്തം പരിശ്രമത്താൽ നേടുന്ന ഐശ്വര്യവും ആദരണീയമായ പദവിയും.',
            ];
        } elseif (!empty($planets12thFromMoon)) {
            $yogas[] = [
                'name_en' => 'Anapha Yoga',
                'name_ml' => 'അനഫാ യോഗം',
                'name_ta' => 'அனபா யோகம்',
                'name_hi' => 'अनफा योग',
                'description_en' => 'Planets in the 12th house from Moon. Bestows magnetic charm, noble virtue, peaceful living, and renown.',
                'description_ml' => 'ചന്ദ്രന്റെ പന്ത്രണ്ടാം ഭാവത്തിൽ ഗ്രഹങ്ങൾ സ്ഥിതിചെയ്യുന്ന യോഗം. സൽസ്വഭാവം, മനശ്ശാന്തി, പരോപകാര ചിന്ത എന്നിവ ഫലം.',
            ];
        } elseif (empty($planets2ndFromMoon) && empty($planets12thFromMoon) && empty($kendraPlanetsFromMoon)) {
            $yogas[] = [
                'name_en' => 'Kemadruma Yoga (Mitigated by Vedanga rules)',
                'name_ml' => 'കേമദ്രുമ യോഗം (പരിഹാര ലക്ഷണങ്ങളോടെ)',
                'name_ta' => 'கேமத்ரும யோகம்',
                'name_hi' => 'केमद्रुम योग',
                'description_en' => 'Moon isolated with no planets in 2nd/12th or Kendras. Indicates periods of mental restlessness, overcome by Jupiter/Venus aspects.',
                'description_ml' => 'ചന്ദ്രന്റെ ഇരുവശങ്ങളിലും കേന്ദ്രങ്ങളിലും ഗ്രഹങ്ങൾ ഇല്ലാത്ത സ്ഥിതി. ഈശ്വര ഭജനത്താലും വ്യാഴ-ശുക്ര കടാക്ഷത്താലും തടസ്സങ്ങൾ മാറുന്നു.',
            ];
        }

        // 5. GURU-MANGALA YOGA (Jupiter & Mars conjunct or in 7th mutual aspect)
        $marsJupDiff = abs($marsRasi - $jupiterRasi);
        if ($marsRasi === $jupiterRasi || $marsJupDiff === 6) {
            $yogas[] = [
                'name_en' => 'Guru-Mangala Yoga',
                'name_ml' => 'ഗുരു-മംഗള യോഗം',
                'name_ta' => 'குரு மங்கள யோகம்',
                'name_hi' => 'गुरु-मंगल योग',
                'description_en' => 'Jupiter and Mars in mutual connection. Bestows formidable energy guided by moral righteousness, engineering or surgical brilliance, and leadership.',
                'description_ml' => 'വ്യാഴവും ചൊവ്വയും തമ്മിൽ ചേരുകയോ പരസ്പരം വീക്ഷിക്കുകയോ ചെയ്യുന്ന യോഗം. ധർമ്മിഷ്ഠമായ വീര്യം, നിർമ്മാണ സാമർത്ഥ്യം, നേതൃഗുണം എന്നിവ ഫലം.',
            ];
        }

        // 6. CHANDRA-MANGALA YOGA (Moon & Mars conjunct)
        if ($moonRasi === $marsRasi) {
            $yogas[] = [
                'name_en' => 'Chandra-Mangala Yoga (Mahalaxmi Yoga)',
                'name_ml' => 'ചന്ദ്ര-മംഗള യോഗം (മഹാലക്ഷ്മി യോഗം)',
                'name_ta' => 'சந்திர மங்கள யோகம்',
                'name_hi' => 'चन्द्र-मंगल योग',
                'description_en' => 'Moon and Mars conjunct in the same sign. Awakens intense financial acumen, lucrative enterprise, property accumulation, and material affluence.',
                'description_ml' => 'ചന്ദ്രനും ചൊവ്വയും ഒന്നിച്ചുനിൽക്കുന്ന മഹാലക്ഷ്മി യോഗം. വൻ സാമ്പത്തിക അഭിവൃദ്ധി, ഭൂമി ക്രയവിക്രയ വിജയം, വ്യവസായ പുരോഗതി എന്നിവ നൽകുന്നു.',
            ];
        }

        // 7. AMALA YOGA (Benefic Jupiter, Venus, or Mercury in 10th house from Lagna or Moon)
        $h10Lagna = (($lagnaRasi - 1 + 9) % 12) + 1;
        $h10Moon = (($moonRasi - 1 + 9) % 12) + 1;
        if (in_array($jupiterRasi, [$h10Lagna, $h10Moon], true) || in_array($venusRasi, [$h10Lagna, $h10Moon], true)) {
            $yogas[] = [
                'name_en' => 'Amala Yoga (Spotless Fame)',
                'name_ml' => 'അമല യോഗം (കളങ്കമില്ലാത്ത കീർത്തി)',
                'name_ta' => 'அமல யோகம்',
                'name_hi' => 'अमल योग',
                'description_en' => 'Natural benefic in the 10th house from Lagna or Moon. Bestows immaculate reputation, unblemished professional stature, and high philanthropy.',
                'description_ml' => 'ലഗ്നത്തിൽ നിന്നോ ചന്ദ്രനിൽ നിന്നോ പത്താം ഭാവത്തിൽ ശുഭഗ്രഹങ്ങൾ നിൽക്കുന്ന യോഗം. കളങ്കമില്ലാത്ത സൽപ്പേര്, ഉയർന്ന തൊഴിൽ പദവി എന്നിവ ഫലം.',
            ];
        }

        return $yogas;
    }

    /**
     * Prescribed Gemstones by Planet (Vedanga Jyothisham Chapter 16).
     */
    public const GEMSTONE_DATA = [
        'Su' => [
            'planet_en' => 'Sun (Surya)',
            'planet_ml' => 'സൂര്യൻ (Surya)',
            'gem_en' => 'Ruby (Manikyam)',
            'gem_ml' => 'മാണിക്യം (Ruby)',
            'gem_ta' => 'மாணிக்கம் (Ruby)',
            'gem_hi' => 'माणिक्य (Ruby)',
            'uparatna_en' => 'Red Garnet / Sunstone',
            'uparatna_ml' => 'ചുവന്ന ഗാർനെറ്റ് / സൺസ്റ്റോൺ',
            'carat' => '3 to 5 Carats (Ratti)',
            'metal_en' => 'Gold or Copper',
            'metal_ml' => 'സ്വർണ്ണം അല്ലെങ്കിൽ ചെമ്പ്',
            'finger_en' => 'Ring finger',
            'finger_ml' => 'മോതിരവിരൽ (Ring finger)',
            'hora_day_en' => 'Sunday morning during Sun Hora (6:00 AM - 7:00 AM)',
            'hora_day_ml' => 'ഞായറാഴ്ച പ്രഭാതത്തിൽ സൂര്യ ഹോരയിൽ (രാവിലെ 6:00 - 7:00)',
            'group' => 'deva',
        ],
        'Mo' => [
            'planet_en' => 'Moon (Chandra)',
            'planet_ml' => 'ചന്ദ്രൻ (Chandra)',
            'gem_en' => 'Natural Pearl (Muthu)',
            'gem_ml' => 'മുത്ത് (Natural Pearl)',
            'gem_ta' => 'முத்து (Pearl)',
            'gem_hi' => 'मोती (Pearl)',
            'uparatna_en' => 'Moonstone',
            'uparatna_ml' => 'മൂൺസ്റ്റോൺ',
            'carat' => '4 to 6 Carats',
            'metal_en' => 'Pure Silver',
            'metal_ml' => 'ശുദ്ധമായ വെള്ളി',
            'finger_en' => 'Little finger or Ring finger',
            'finger_ml' => 'ചെറുവിരൽ അല്ലെങ്കിൽ മോതിരവിരൽ',
            'hora_day_en' => 'Monday morning during Moon Hora (6:00 AM - 7:00 AM)',
            'hora_day_ml' => 'തിങ്കളാഴ്ച പ്രഭാതത്തിൽ ചന്ദ്ര ഹോരയിൽ (രാവിലെ 6:00 - 7:00)',
            'group' => 'deva',
        ],
        'Ma' => [
            'planet_en' => 'Mars (Kuja)',
            'planet_ml' => 'ചൊവ്വ (Kuja)',
            'gem_en' => 'Red Coral (Pavizham)',
            'gem_ml' => 'പവിഴം (Red Coral)',
            'gem_ta' => 'பவளம் (Red Coral)',
            'gem_hi' => 'मूंगा (Red Coral)',
            'uparatna_en' => 'Red Jasper / Carnelian',
            'uparatna_ml' => 'റെഡ് ജാസ്പർ / കാർണീലിയൻ',
            'carat' => '5 to 8 Carats',
            'metal_en' => 'Copper or Gold',
            'metal_ml' => 'ചെമ്പ് അല്ലെങ്കിൽ സ്വർണ്ണം',
            'finger_en' => 'Ring finger',
            'finger_ml' => 'മോതിരവിരൽ (Ring finger)',
            'hora_day_en' => 'Tuesday morning during Mars Hora (6:00 AM - 7:00 AM)',
            'hora_day_ml' => 'ചൊവ്വാഴ്ച പ്രഭാതത്തിൽ കുജ ഹോരയിൽ (രാവിലെ 6:00 - 7:00)',
            'group' => 'deva',
        ],
        'Me' => [
            'planet_en' => 'Mercury (Budha)',
            'planet_ml' => 'ബുധൻ (Budha)',
            'gem_en' => 'Emerald (Marakathapacha)',
            'gem_ml' => 'മരതകം (Emerald)',
            'gem_ta' => 'மரகதம் (Emerald)',
            'gem_hi' => 'पन्ना (Emerald)',
            'uparatna_en' => 'Green Tourmaline / Peridot',
            'uparatna_ml' => 'ഗ്രീൻ ടൂർമാലിൻ / പെരിഡോട്ട്',
            'carat' => '3 to 5 Carats',
            'metal_en' => 'Gold or Silver',
            'metal_ml' => 'സ്വർണ്ണം അല്ലെങ്കിൽ വെള്ളി',
            'finger_en' => 'Little finger (Kanishtika)',
            'finger_ml' => 'ചെറുവിരൽ (കനിഷ്ഠിക)',
            'hora_day_en' => 'Wednesday morning during Mercury Hora (6:00 AM - 7:00 AM)',
            'hora_day_ml' => 'ബുധനാഴ്ച പ്രഭാതത്തിൽ ബുധ ഹോരയിൽ (രാവിലെ 6:00 - 7:00)',
            'group' => 'asura',
        ],
        'Ju' => [
            'planet_en' => 'Jupiter (Guru)',
            'planet_ml' => 'വ്യാഴം (Guru)',
            'gem_en' => 'Yellow Sapphire (Pushparagam)',
            'gem_ml' => 'മഞ്ഞ പുഷ്യരാഗം (Yellow Sapphire)',
            'gem_ta' => 'மஞ்சள் புஷ்பராகம் (Yellow Sapphire)',
            'gem_hi' => 'पुखराज (Yellow Sapphire)',
            'uparatna_en' => 'Yellow Topaz / Citrine',
            'uparatna_ml' => 'യെല്ലോ ടോപ്പാസ് / സിട്രീൻ',
            'carat' => '3.5 to 6 Carats',
            'metal_en' => 'Pure Gold',
            'metal_ml' => 'ശുദ്ധമായ സ്വർണ്ണം',
            'finger_en' => 'Index finger (Tarjani)',
            'finger_ml' => 'ചൂണ്ടുവിരൽ (തർജ്ജനി)',
            'hora_day_en' => 'Thursday morning during Jupiter Hora (6:00 AM - 7:00 AM)',
            'hora_day_ml' => 'വ്യാഴാഴ്ച പ്രഭാതത്തിൽ വ്യാഴ ഹോരയിൽ (രാവിലെ 6:00 - 7:00)',
            'group' => 'deva',
        ],
        'Ve' => [
            'planet_en' => 'Venus (Shukra)',
            'planet_ml' => 'ശുക്രൻ (Shukra)',
            'gem_en' => 'Diamond (Vairam)',
            'gem_ml' => 'വജ്രം (Diamond)',
            'gem_ta' => 'வைரம் (Diamond)',
            'gem_hi' => 'हीरा (Diamond)',
            'uparatna_en' => 'White Zircon / White Sapphire',
            'uparatna_ml' => 'വൈറ്റ് സിർക്കോൺ / വെളുത്ത പുഷ്യരാഗം',
            'carat' => '0.5 to 1.5 Carats (Diamond) or 3-5 Carats (Zircon)',
            'metal_en' => 'Platinum or White Gold / Silver',
            'metal_ml' => 'പ്ലാറ്റിനം അല്ലെങ്കിൽ വെള്ളി',
            'finger_en' => 'Middle finger or Little finger',
            'finger_ml' => 'നടുവിരൽ അല്ലെങ്കിൽ ചെറുവിരൽ',
            'hora_day_en' => 'Friday morning during Venus Hora (6:00 AM - 7:00 AM)',
            'hora_day_ml' => 'വെള്ളിയാഴ്ച പ്രഭാതത്തിൽ ശുക്ര ഹോരയിൽ (രാവിലെ 6:00 - 7:00)',
            'group' => 'asura',
        ],
        'Sa' => [
            'planet_en' => 'Saturn (Shani)',
            'planet_ml' => 'ശനി (Shani)',
            'gem_en' => 'Blue Sapphire (Indraneelam)',
            'gem_ml' => 'ഇന്ദ്രനീലം (Blue Sapphire)',
            'gem_ta' => 'நீலமணி (Blue Sapphire)',
            'gem_hi' => 'नीलम (Blue Sapphire)',
            'uparatna_en' => 'Amethyst / Blue Topaz / Iolite',
            'uparatna_ml' => 'അമേത്തിസ്റ്റ് / ബ്ലൂ ടോപ്പാസ്',
            'carat' => '3 to 5 Carats',
            'metal_en' => 'Panchaloha, White Gold or Silver',
            'metal_ml' => 'പഞ്ചലോഹം അല്ലെങ്കിൽ വെള്ളി',
            'finger_en' => 'Middle finger (Madhyama)',
            'finger_ml' => 'നടുവിരൽ (മധ്യസ്ഥ വിരൽ)',
            'hora_day_en' => 'Saturday morning during Saturn Hora (6:00 AM - 7:00 AM)',
            'hora_day_ml' => 'ശനിയാഴ്ച പ്രഭാതത്തിൽ ശനി ഹോരയിൽ (രാവിലെ 6:00 - 7:00)',
            'group' => 'asura',
        ],
    ];

    /**
     * Compute Gemstone Recommendation based on Trine Lords (1, 5, 9) and Gender rules.
     *
     * @param int $lagnaRasi
     * @param string $gender 'male' or 'female'
     * @param array $dignities
     * @return array
     */
    public function computeGemstoneRecommendation(int $lagnaRasi, string $gender = 'male', array $dignities = []): array
    {
        // Trine Lords: Lagna (1), 5th House, 9th House
        $l1 = self::RASI_LORDS[$lagnaRasi] ?? 'Su';
        $h5Rasi = (($lagnaRasi - 1 + 4) % 12) + 1;
        $l5 = self::RASI_LORDS[$h5Rasi] ?? 'Ju';
        $h9Rasi = (($lagnaRasi - 1 + 8) % 12) + 1;
        $l9 = self::RASI_LORDS[$h9Rasi] ?? 'Ma';

        // Select primary gemstone planet: prioritize Lagna lord if not severely debilitated
        $primaryKey = $l1;
        if (($dignities[$l1]['status'] ?? '') === 'debilitated') {
            // If Lagna lord is debilitated, support with 9th lord or 5th lord
            $primaryKey = ($dignities[$l9]['status'] ?? '') !== 'debilitated' ? $l9 : $l5;
        }

        $gemData = self::GEMSTONE_DATA[$primaryKey] ?? self::GEMSTONE_DATA['Su'];

        // Gender-specific hand rule per Vedanga Jyothisham Page 94
        $handEn = ($gender === 'female') ? 'Left Hand' : 'Right Hand';
        $handMl = ($gender === 'female') ? 'ഇടതുകൈ' : 'വലതുകൈ';
        $handTa = ($gender === 'female') ? 'இடது கை' : 'வலது கை';
        $handHi = ($gender === 'female') ? 'बाएं हाथ' : 'दाहिने हाथ';

        $wearingRuleEn = "Wear in {$gemData['metal_en']} on the {$gemData['finger_en']} of {$handEn} on {$gemData['hora_day_en']}.";
        $wearingRuleMl = "{$gemData['metal_ml']} നിർമ്മിതമായ മോതിരത്തിൽ പതിപ്പിച്ച്, {$gemData['hora_day_ml']}, {$handMl} {$gemData['finger_ml']} അണിയുക.";
        $wearingRuleTa = "{$gemData['metal_en']} மோதிரத்தில், {$handTa} {$gemData['finger_en']} விரலில், {$gemData['hora_day_en']} அணியவும்.";
        $wearingRuleHi = "{$gemData['metal_en']} की अंगूठी में, {$handHi} की {$gemData['finger_en']} में, {$gemData['hora_day_en']} धारण करें।";

        return [
            'prescribed_planet' => $primaryKey,
            'planet_name_en' => $gemData['planet_en'],
            'planet_name_ml' => $gemData['planet_ml'],
            'gemstone_en' => $gemData['gem_en'],
            'gemstone_ml' => $gemData['gem_ml'],
            'gemstone_ta' => $gemData['gem_ta'],
            'gemstone_hi' => $gemData['gem_hi'],
            'uparatna_en' => $gemData['uparatna_en'],
            'uparatna_ml' => $gemData['uparatna_ml'],
            'carat_weight' => $gemData['carat'],
            'metal_en' => $gemData['metal_en'],
            'metal_ml' => $gemData['metal_ml'],
            'finger_en' => $gemData['finger_en'],
            'finger_ml' => $gemData['finger_ml'],
            'hand_en' => $handEn,
            'hand_ml' => $handMl,
            'wearing_rule' => [
                'en' => $wearingRuleEn,
                'ml' => $wearingRuleMl,
                'ta' => $wearingRuleTa,
                'hi' => $wearingRuleHi,
            ],
            'trine_lords' => [
                'l1' => $l1,
                'l5' => $l5,
                'l9' => $l9,
            ],
        ];
    }
}


<?php

namespace App\Services\Astrology;

use App\Models\VedangaRule;
use Carbon\Carbon;

class VedangaPredictionService
{
    protected ChitrapakshaEphemerisService $ephemeris;

    public function __construct(?ChitrapakshaEphemerisService $ephemeris = null)
    {
        $this->ephemeris = $ephemeris ?? new ChitrapakshaEphemerisService();
    }

    /**
     * Dual (Ubhaya), Fixed (Sthira), Movable (Chara) Rasi classifications.
     */
    public const CHARA_RASIS = [1, 4, 7, 10];
    public const STHIRA_RASIS = [2, 5, 8, 11];
    public const UBHAYA_RASIS = [3, 6, 9, 12];

    /**
     * Transit favorable houses and their corresponding Vedha houses (Page 82).
     */
    public const GOCHARA_RULES = [
        'Su' => [
            'favorable' => [3, 6, 10, 11],
            'vedha' => [3 => 9, 6 => 12, 10 => 4, 11 => 5],
            'exempt_planets' => ['Sa'], // No Vedha between Sun and Saturn
        ],
        'Mo' => [
            'favorable' => [1, 3, 6, 7, 10, 11],
            'vedha' => [1 => 5, 3 => 9, 6 => 2, 7 => 4, 10 => 12, 11 => 8],
            'exempt_planets' => ['Me'], // No Vedha between Moon and Mercury
        ],
        'Ma' => [
            'favorable' => [3, 6, 11],
            'vedha' => [3 => 12, 6 => 9, 11 => 5],
            'exempt_planets' => [],
        ],
        'Me' => [
            'favorable' => [2, 4, 6, 8, 10, 11],
            'vedha' => [2 => 5, 4 => 3, 6 => 9, 8 => 1, 10 => 8, 11 => 12],
            'exempt_planets' => ['Mo'], // No Vedha with Moon
        ],
        'Ju' => [
            'favorable' => [2, 5, 7, 9, 11],
            'vedha' => [2 => 12, 5 => 4, 7 => 3, 9 => 10, 11 => 8],
            'exempt_planets' => [],
        ],
        'Ve' => [
            'favorable' => [1, 2, 3, 4, 5, 8, 9, 11, 12],
            'vedha' => [1 => 8, 2 => 7, 3 => 1, 4 => 10, 5 => 9, 8 => 5, 9 => 11, 11 => 3, 12 => 6],
            'exempt_planets' => [],
        ],
        'Sa' => [
            'favorable' => [3, 6, 11],
            'vedha' => [3 => 12, 6 => 9, 11 => 5],
            'exempt_planets' => ['Su'], // No Vedha between Saturn and Sun
        ],
    ];

    /**
     * Run the complete Vedanga Jyothisham evaluation on calculated chart data.
     */
    public function evaluateChart(array $chartData, string $lang = 'en'): array
    {
        $gender = strtolower(trim($chartData['gender'] ?? 'male'));
        $natalMoonRasi = (int)($chartData['moon_sign']['rasi_index'] ?? $chartData['moon_sign']['number'] ?? 1);

        $gulikaAnalysis = $this->evaluateGulika($chartData, $lang);
        $yogas = $this->evaluateYogas($chartData, $gender, $lang);
        $gochara = $this->evaluateGocharaphala($natalMoonRasi, Carbon::now(), $lang);
        $bhavaAnalysis = $this->evaluate12BhavasAndLords($chartData, $lang);

        return [
            'gulika' => $gulikaAnalysis,
            'yogas' => $yogas,
            'gocharaphala' => $gochara,
            'bhava_analysis' => $bhavaAnalysis,
            'bhavas' => $bhavaAnalysis['bhavas'] ?? [],
            'wealth_sources' => $bhavaAnalysis['wealth_sources'] ?? [],
            'health_advice' => $bhavaAnalysis['health_advice'] ?? [],
        ];
    }

    /**
     * Chapter 5 & 17: Gulika Evaluation.
     */
    public function evaluateGulika(array $chartData, string $lang = 'en'): array
    {
        $gulikaBhava = (int)($chartData['planet_bhavas']['Md']['bhava'] ?? 1);
        $lagnaRasi = (int)($chartData['lagna']['rasi_index'] ?? 1);
        $gulikaLong = (float)($chartData['gulika']['longitude'] ?? 0.0);
        $gulikaRasi = (int)floor(fmod($gulikaLong + 360.0, 360.0) / 30.0) + 1;

        // Check if solitary in Lagna
        $isSolitaryInLagna = false;
        if ($gulikaBhava === 1) {
            $otherLagnaPlanets = 0;
            foreach ($chartData['planets'] ?? [] as $k => $p) {
                if (($chartData['planet_bhavas'][$k]['bhava'] ?? 0) === 1) {
                    $otherLagnaPlanets++;
                }
            }
            $isSolitaryInLagna = ($otherLagnaPlanets === 0);
        }

        // Fetch Rule from database or fallback
        $ruleKey = "gulika_H{$gulikaBhava}";
        $rule = VedangaRule::where('category', 'gulika_house')->where('rule_key', $ruleKey)->first();

        $contentField = 'content_' . $lang;
        $phalaText = $rule ? ($rule->$contentField ?? $rule->content_en) : "Gulika occupies Bhava {$gulikaBhava}.";

        $extra = [
            'en' => ' (Chapter 17, Page 100 Special Rule: Solitary Gulika in Lagna confers Rajayoga, vehicle ownership, and worldly authority).',
            'ml' => ' (അധ്യായം 17, പേജ് 100 വിശേഷാൽ വിധി: ലഗ്നത്തിൽ ഗുളികൻ തനിച്ചു നിന്നാൽ രാജയോഗവും വാഹനാദി സൗഭാഗ്യങ്ങളും മാന്യതയും നൽകുന്നു).',
            'ta' => ' (குளிகன் லக்னத்தில் தனித்து நின்றால் ராஜயோகம் மற்றும் வாகன பாக்கியம் தரும்).',
            'hi' => ' (लग्न में अकेला गुलिक राजयोग, वाहन सुख एवं प्रतिष्ठा प्रदान करता है)।',
        ];
        if ($isSolitaryInLagna) {
            $phalaText .= $extra[$lang] ?? $extra['en'];
        }

        $phalaTranslations = [
            'en' => ($rule ? ($rule->content_en ?? "Gulika occupies Bhava {$gulikaBhava}.") : "Gulika occupies Bhava {$gulikaBhava}.") . ($isSolitaryInLagna ? $extra['en'] : ''),
            'ml' => ($rule ? ($rule->content_ml ?? $rule->content_en ?? "Gulika occupies Bhava {$gulikaBhava}.") : "Gulika occupies Bhava {$gulikaBhava}.") . ($isSolitaryInLagna ? $extra['ml'] : ''),
            'ta' => ($rule ? ($rule->content_ta ?? $rule->content_en ?? "Gulika occupies Bhava {$gulikaBhava}.") : "Gulika occupies Bhava {$gulikaBhava}.") . ($isSolitaryInLagna ? $extra['ta'] : ''),
            'hi' => ($rule ? ($rule->content_hi ?? $rule->content_en ?? "Gulika occupies Bhava {$gulikaBhava}.") : "Gulika occupies Bhava {$gulikaBhava}.") . ($isSolitaryInLagna ? $extra['hi'] : ''),
        ];

        // Conjunctions with planets in same sign (within ±12°)
        $conjunctions = [];
        foreach ($chartData['planets'] ?? [] as $pk => $pData) {
            $pLong = (float)($pData['longitude'] ?? 0.0);
            $pDiff = abs($this->ephemeris->signedAngleDiff($pLong, $gulikaLong));
            if ($pDiff <= 12.0) {
                $conjKey = "gulika_conj_{$pk}";
                $cRule = VedangaRule::where('category', 'gulika_conjunction')->where('rule_key', $conjKey)->first();
                $cText = $cRule ? ($cRule->$contentField ?? $cRule->content_en) : "Gulika conjunct {$pk}.";
                $phEn = $cRule->content_en ?? "Gulika conjunct {$pk}.";
                $phMl = $cRule->content_ml ?? $phEn;
                $phTa = $cRule->content_ta ?? $phEn;
                $phHi = $cRule->content_hi ?? $phEn;

                $conjunctions[] = [
                    'planet' => $pk,
                    'name_en' => $pData['name_en'] ?? $pk,
                    'name_ml' => $pData['name_ml'] ?? $pk,
                    'title' => 'Gulika conjunct ' . ($pData['name_en'] ?? $pk),
                    'title_en' => 'Gulika conjunct ' . ($pData['name_en'] ?? $pk),
                    'title_ml' => 'ഗുളികൻ ' . ($pData['name_ml'] ?? $pk) . ' സംയോഗം',
                    'angular_distance' => round($pDiff, 2),
                    'phala' => $cText,
                    'phalam_en' => $phEn,
                    'phalam_ml' => $phMl,
                    'phalam_ta' => $phTa,
                    'phalam_hi' => $phHi,
                    'phala_translations' => [
                        'en' => $phEn,
                        'ml' => $phMl,
                        'ta' => $phTa,
                        'hi' => $phHi,
                    ],
                ];
            }
        }

        return [
            'bhava' => $gulikaBhava,
            'house' => $gulikaBhava,
            'rasi' => $gulikaRasi,
            'is_solitary_in_lagna' => $isSolitaryInLagna,
            'phala' => $phalaText,
            'phala_translations' => $phalaTranslations,
            'house_result_en' => $phalaTranslations['en'] ?? '',
            'house_result_ml' => $phalaTranslations['ml'] ?? '',
            'house_result_ta' => $phalaTranslations['ta'] ?? '',
            'house_result_hi' => $phalaTranslations['hi'] ?? '',
            'conjunctions' => $conjunctions,
        ];
    }

    /**
     * Chapter 10 & 13: Classical Yogas Detection Engine.
     */
    public function evaluateYogas(array $chartData, string $gender = 'male', string $lang = 'en'): array
    {
        $allBodies = array_merge($chartData['planets'] ?? [], [
            'As' => $chartData['lagna'] ?? [],
            'Md' => $chartData['gulika'] ?? [],
        ]);

        $lagnaLong = (float)($chartData['lagna']['longitude'] ?? 0.0);
        $lagnaRasi = (int)floor(fmod($lagnaLong + 360.0, 360.0) / 30.0) + 1;
        $moonLong = (float)($chartData['planets']['Mo']['longitude'] ?? 0.0);
        $moonRasi = (int)floor(fmod($moonLong + 360.0, 360.0) / 30.0) + 1;
        $sunLong = (float)($chartData['planets']['Su']['longitude'] ?? 0.0);
        $sunRasi = (int)floor(fmod($sunLong + 360.0, 360.0) / 30.0) + 1;

        $contentField = 'content_' . $lang;
        $activeYogas = [];

        $houseFrom = function (int $targetRasi, int $refRasi): int {
            return (($targetRasi - $refRasi + 12) % 12) + 1;
        };

        $getRuleText = function (string $key) use ($contentField) {
            $rule = VedangaRule::where('category', 'yoga')->where('rule_key', $key)->first();
            return $rule ? ($rule->$contentField ?? $rule->content_en) : '';
        };

        // 1. PANCHAMAHAPURUSHA YOGAS (Pages 54–55)
        $kendraHouses = [1, 4, 7, 10];
        $mahaConfig = [
            'Ma' => ['key' => 'ruchaka_yoga', 'disallowed_lagna' => self::UBHAYA_RASIS, 'name_en' => 'Ruchaka Yoga', 'name_ml' => 'രുചക യോഗം'],
            'Me' => ['key' => 'bhadra_yoga', 'required_lagna' => self::UBHAYA_RASIS, 'name_en' => 'Bhadra Yoga', 'name_ml' => 'ഭദ്ര യോഗം'],
            'Ju' => ['key' => 'hamsa_yoga', 'disallowed_lagna' => self::STHIRA_RASIS, 'name_en' => 'Hamsa Yoga', 'name_ml' => 'ഹംസ യോഗം'],
            'Ve' => ['key' => 'malavya_yoga', 'name_en' => 'Malavya Yoga', 'name_ml' => 'മാളവ്യ യോഗം'],
            'Sa' => ['key' => 'shasha_yoga', 'disallowed_lagna' => self::UBHAYA_RASIS, 'name_en' => 'Shasha Yoga', 'name_ml' => 'ശശ യോഗം'],
        ];

        foreach ($mahaConfig as $pk => $cfg) {
            $pData = $chartData['planets'][$pk] ?? null;
            if (!$pData) continue;

            $pLong = (float)($pData['longitude'] ?? 0.0);
            $pRasi = (int)floor(fmod($pLong + 360.0, 360.0) / 30.0) + 1;
            $hLagna = $houseFrom($pRasi, $lagnaRasi);

            $dignity = $chartData['dignities'][$pk]['status'] ?? '';
            $isOwnOrExalted = in_array($dignity, ['exalted', 'own', 'moolatrikona'], true);

            if (in_array($hLagna, $kendraHouses, true) && $isOwnOrExalted) {
                // Check Lagna Sign Conditions
                $valid = true;
                if (!empty($cfg['disallowed_lagna']) && in_array($lagnaRasi, $cfg['disallowed_lagna'], true)) {
                    $valid = false;
                }
                if (!empty($cfg['required_lagna']) && !in_array($lagnaRasi, $cfg['required_lagna'], true)) {
                    $valid = false;
                }

                if ($valid) {
                    // Check Yoga Bhanga (conjunct Sun or Moon per Page 55)
                    $sunDist = abs($this->ephemeris->signedAngleDiff($pLong, $sunLong));
                    $moonDist = abs($this->ephemeris->signedAngleDiff($pLong, $moonLong));
                    $hasYogaBhanga = ($sunDist <= 10.0 || $moonDist <= 10.0);

                    $desc = $getRuleText($cfg['key']);
                    if ($hasYogaBhanga) {
                        $desc .= ($lang === 'ml')
                            ? ' (സൂര്യ/ചന്ദ്ര സംയോഗത്താൽ ഭാഗിക യോഗഭംഗം; ഡോ. രാജവർമ്മ നിർദ്ദേശിക്കുന്ന പ്രാർത്ഥനകളാൽ യോഗശക്തി പൂർണ്ണമാക്കാം).'
                            : ' (Partial Yoga Bhanga due to Sun/Moon conjunction; easily energized via Dr. E. K. Raja Varma\'s Vedic remedies).';
                    }

                    $activeYogas[] = [
                        'key' => $cfg['key'],
                        'name_en' => $cfg['name_en'],
                        'name_ml' => $cfg['name_ml'],
                        'planet' => $pk,
                        'is_yoga_bhanga' => $hasYogaBhanga,
                        'description' => $desc,
                    ];
                }
            }
        }

        // 2. LUNAR YOGAS (Page 55)
        // Gajakesari Yoga (Jupiter in Kendra from Moon)
        $jupLong = (float)($chartData['planets']['Ju']['longitude'] ?? 0.0);
        $jupRasi = (int)floor(fmod($jupLong + 360.0, 360.0) / 30.0) + 1;
        if (in_array($houseFrom($jupRasi, $moonRasi), [1, 4, 7, 10], true)) {
            $activeYogas[] = [
                'key' => 'gajakesari_yoga',
                'name_en' => 'Gajakesari Yoga',
                'name_ml' => 'ഗജകേസരി യോഗം',
                'description' => $getRuleText('gajakesari_yoga'),
            ];
        }

        // Sunabha, Anabha, Dhurudhura, Kemadruma Bhanga
        $p2 = [];
        $p12 = [];
        $pKendra = [];
        foreach (['Ma', 'Me', 'Ju', 'Ve', 'Sa'] as $pk) {
            $pLong = (float)($chartData['planets'][$pk]['longitude'] ?? 0.0);
            $pRasi = (int)floor(fmod($pLong + 360.0, 360.0) / 30.0) + 1;
            $hM = $houseFrom($pRasi, $moonRasi);
            if ($hM === 2) $p2[] = $pk;
            elseif ($hM === 12) $p12[] = $pk;
            elseif (in_array($hM, [1, 4, 7, 10], true)) $pKendra[] = $pk;
        }

        if (!empty($p2) && !empty($p12)) {
            $activeYogas[] = [
                'key' => 'dhurudhura_yoga',
                'name_en' => 'Dhurudhura Yoga',
                'name_ml' => 'ദുരുധുരാ യോഗം',
                'description' => $getRuleText('dhurudhura_yoga'),
            ];
        } elseif (!empty($p2)) {
            $activeYogas[] = [
                'key' => 'sunabha_yoga',
                'name_en' => 'Sunabha Yoga',
                'name_ml' => 'സുനഫാ യോഗം',
                'description' => $getRuleText('sunabha_yoga'),
            ];
        } elseif (!empty($p12)) {
            $activeYogas[] = [
                'key' => 'anabha_yoga',
                'name_en' => 'Anabha Yoga',
                'name_ml' => 'അനഫാ യോഗം',
                'description' => $getRuleText('anabha_yoga'),
            ];
        } elseif (empty($p2) && empty($p12) && !empty($pKendra)) {
            $activeYogas[] = [
                'key' => 'kemadruma_bhanga',
                'name_en' => 'Kemadruma Bhanga Rajayoga',
                'name_ml' => 'കേമദ്രുമ ഭംഗ രാജയോഗം',
                'description' => $getRuleText('kemadruma_bhanga'),
            ];
        }

        // Chandra-Mangala (Shashamangala) Yoga
        $marsLong = (float)($chartData['planets']['Ma']['longitude'] ?? 0.0);
        $marsRasi = (int)floor(fmod($marsLong + 360.0, 360.0) / 30.0) + 1;
        if ($marsRasi === $moonRasi) {
            $activeYogas[] = [
                'key' => 'chandra_mangala_yoga',
                'name_en' => 'Chandra-Mangala Yoga',
                'name_ml' => 'ചന്ദ്ര-മംഗള യോഗം',
                'description' => $getRuleText('chandra_mangala_yoga'),
            ];
        }

        // 3. SOLAR YOGAS (Pages 55–56)
        $mercLong = (float)($chartData['planets']['Me']['longitude'] ?? 0.0);
        $mercRasi = (int)floor(fmod($mercLong + 360.0, 360.0) / 30.0) + 1;
        if ($sunRasi === $mercRasi) {
            $activeYogas[] = [
                'key' => 'nipuna_yoga',
                'name_en' => 'Nipuna (Budhaditya) Yoga',
                'name_ml' => 'നിപുണ (ബുധാദിത്യ) യോഗം',
                'description' => $getRuleText('nipuna_yoga'),
            ];
        }

        // 4. NEECHABHANGA RAJA YOGA (Page 56)
        foreach ($chartData['dignities'] ?? [] as $pk => $dInfo) {
            if (($dInfo['status'] ?? '') === 'debilitated') {
                $debRasi = (int)($dInfo['rasi'] ?? 1);
                $dispositor = AshtakavargaAndDignityService::RASI_LORDS[$debRasi] ?? 'Ma';
                $dispRasi = (int)floor(fmod(($chartData['planets'][$dispositor]['longitude'] ?? 0.0) + 360.0, 360.0) / 30.0) + 1;

                if (in_array($houseFrom($dispRasi, $lagnaRasi), [1, 4, 7, 10], true) || in_array($houseFrom($dispRasi, $moonRasi), [1, 4, 7, 10], true)) {
                    $activeYogas[] = [
                        'key' => 'neechabhanga_raja_yoga',
                        'name_en' => "Neechabhanga Raja Yoga ({$pk})",
                        'name_ml' => "നീചഭംഗ രാജയോഗം ({$dInfo['name_ml']})",
                        'description' => $getRuleText('neechabhanga_raja_yoga'),
                    ];
                }
            }
        }

        // 5. PARIVARTANA YOGA (Page 56)
        $planetsList = ['Su', 'Mo', 'Ma', 'Me', 'Ju', 'Ve', 'Sa'];
        for ($i = 0; $i < count($planetsList); $i++) {
            for ($j = $i + 1; $j < count($planetsList); $j++) {
                $p1 = $planetsList[$i];
                $p2 = $planetsList[$j];

                $r1 = (int)floor(fmod(($chartData['planets'][$p1]['longitude'] ?? 0.0) + 360.0, 360.0) / 30.0) + 1;
                $r2 = (int)floor(fmod(($chartData['planets'][$p2]['longitude'] ?? 0.0) + 360.0, 360.0) / 30.0) + 1;

                $lordOfR1 = AshtakavargaAndDignityService::RASI_LORDS[$r1] ?? '';
                $lordOfR2 = AshtakavargaAndDignityService::RASI_LORDS[$r2] ?? '';

                if ($lordOfR1 === $p2 && $lordOfR2 === $p1 && $p1 !== $p2) {
                    $activeYogas[] = [
                        'key' => 'parivartana_yoga',
                        'name_en' => "Parivartana Yoga ({$p1} - {$p2})",
                        'name_ml' => "പരിവർത്തന യോഗം ({$p1} - {$p2})",
                        'description' => $getRuleText('parivartana_yoga'),
                    ];
                }
            }
        }

        // 6. STREE JATAKA YOGAS (For Females - Pages 70–71)
        if ($gender === 'female') {
            $h7Lagna = (($lagnaRasi - 1 + 6) % 12) + 1;
            $l7 = AshtakavargaAndDignityService::RASI_LORDS[$h7Lagna] ?? 'Ve';
            $l7Status = $chartData['dignities'][$l7]['status'] ?? '';

            if (in_array($l7Status, ['exalted', 'own', 'moolatrikona'], true)) {
                $activeYogas[] = [
                    'key' => 'saubhagya_yoga',
                    'name_en' => 'Saubhagya Yoga (Stree Jataka)',
                    'name_ml' => 'സൗഭാഗ്യ യോഗം (സ്ത്രീ ജാതകം)',
                    'description' => $getRuleText('saubhagya_yoga'),
                ];
            }
        }

        return $activeYogas;
    }

    /**
     * Chapter 14: Gocharaphala (Current Transit Engine from Natal Moon - Pages 79–82).
     */
    public function evaluateGocharaphala(int $natalMoonRasi, ?Carbon $transitDate = null, string $lang = 'en'): array
    {
        $transitDate = $transitDate ?? Carbon::now();
        $dateStr = $transitDate->format('Y-m-d');
        $timeStr = $transitDate->format('H:i:s');

        // Ephemeris for today
        $transitEphem = $this->ephemeris->calculateEphemeris($dateStr, $timeStr);
        $transitPlanets = $transitEphem['planets'];

        $results = [];
        $houseFrom = function (int $targetRasi, int $refRasi): int {
            return (($targetRasi - $refRasi + 12) % 12) + 1;
        };

        // Extract transit Rasi for each planet
        $transitRasis = [];
        foreach ($transitPlanets as $k => $p) {
            $transitRasis[$k] = (int)floor(fmod(($p['longitude'] ?? 0.0) + 360.0, 360.0) / 30.0) + 1;
        }

        foreach (self::GOCHARA_RULES as $pk => $rules) {
            $tRasi = $transitRasis[$pk] ?? 1;
            $hFromMoon = $houseFrom($tRasi, $natalMoonRasi);
            $isFavorable = in_array($hFromMoon, $rules['favorable'], true);

            $hasVedha = false;
            $vedhaObstaclePlanet = null;

            if ($isFavorable && isset($rules['vedha'][$hFromMoon])) {
                $vedhaHouse = $rules['vedha'][$hFromMoon];
                // Check if any non-exempt planet occupies the vedha house from Moon
                foreach ($transitRasis as $otherPk => $otherRasi) {
                    if ($otherPk === $pk || in_array($otherPk, $rules['exempt_planets'], true)) continue;
                    if ($houseFrom($otherRasi, $natalMoonRasi) === $vedhaHouse) {
                        $hasVedha = true;
                        $vedhaObstaclePlanet = $otherPk;
                        break;
                    }
                }
            }

            $effectiveFavorable = $isFavorable && !$hasVedha;

            $statusText = $effectiveFavorable
                ? ($lang === 'ml' ? 'അനുകൂലം (Auspicious)' : 'Favorable Transit')
                : ($hasVedha
                    ? ($lang === 'ml' ? 'വേധമുള്ളതിനാൽ മന്ദഗതി (Obstructed by Vedha)' : 'Favorable with Vedha Obstruction')
                    : ($lang === 'ml' ? 'ജാഗ്രത ആവശ്യമുള്ള കാലം (Caution / Remedial)' : 'Challenging / Remedial Period'));

            $results[$pk] = [
                'planet' => $pk,
                'name_en' => $transitPlanets[$pk]['name_en'] ?? $pk,
                'name_ml' => $transitPlanets[$pk]['name_ml'] ?? $pk,
                'current_rasi' => $tRasi,
                'house_from_moon' => $hFromMoon,
                'is_favorable' => $isFavorable,
                'has_vedha' => $hasVedha,
                'vedha_planet' => $vedhaObstaclePlanet,
                'effective_favorable' => $effectiveFavorable,
                'status_text' => $statusText,
            ];
        }

        // Special Saturn Transit Analysis (7½ Shani, Kantaka Shani, Ashtama Shani)
        $saturnHouse = $results['Sa']['house_from_moon'] ?? 1;
        $shaniSpecial = [
            'is_ezhara_shani' => in_array($saturnHouse, [12, 1, 2], true),
            'phase' => $saturnHouse === 12 ? 'Rising (12th House)' : ($saturnHouse === 1 ? 'Peak (Janma Shani)' : ($saturnHouse === 2 ? 'Setting / Relief (2nd House)' : 'None')),
            'is_kantaka_shani' => in_array($saturnHouse, [4, 7, 10], true),
            'kantaka_house' => in_array($saturnHouse, [4, 7, 10], true) ? $saturnHouse : null,
            'is_ashtama_shani' => ($saturnHouse === 8),
            'remedy_ml' => 'ശനിയാഴ്ചകളിൽ ശാസ്താ ക്ഷേത്ര ദർശനം, നീരാജനം കത്തിക്കൽ, കറുത്ത വസ്ത്രം ധരിക്കൽ, പാവപ്പെട്ടവർക്ക് അന്നദാനം എന്നിവ ദോഷശമനം നൽകും.',
            'remedy_en' => 'Saturday worship of Lord Ayyappa/Shasta, offering sesame oil lamp (Neerajanam), and charity to the needy mitigates Saturn afflictions.',
        ];

        // Jupiter Special Transit Alert (in 1st or 8th)
        $jupHouse = $results['Ju']['house_from_moon'] ?? 1;
        $guruSpecial = [
            'is_challenging' => in_array($jupHouse, [1, 8], true),
            'remedy_ml' => in_array($jupHouse, [1, 8], true) ? 'വ്യാഴാഴ്ചകളിൽ മഹാവിഷ്ണു ഭജനം, മഞ്ഞപ്പട്ട് സമർപ്പണം, വിഷ്ണുസഹസ്രനാമ ജപം എന്നിവ ശ്രേയസ്സ് നൽകും.' : 'അനുകൂല വ്യാഴ കടാക്ഷം.',
            'remedy_en' => in_array($jupHouse, [1, 8], true) ? 'Thursday Mahavishnu worship, chanting Vishnu Sahasranama, and yellow flowers bring peace and career stability.' : 'Favorable Jupiter transit.',
        ];

        return [
            'transit_date' => $dateStr,
            'natal_moon_rasi' => $natalMoonRasi,
            'planets' => $results,
            'saturn_special' => $shaniSpecial,
            'jupiter_special' => $guruSpecial,
        ];
    }

    /**
     * Chapter 17: 12-Bhava Synthesis (Planets in Houses, Lords in Houses, Diagnostics).
     */
    public function evaluate12BhavasAndLords(array $chartData, string $lang = 'en'): array
    {
        $lagnaLong = (float)($chartData['lagna']['longitude'] ?? 0.0);
        $lagnaRasi = (int)floor(fmod($lagnaLong + 360.0, 360.0) / 30.0) + 1;
        $contentField = 'content_' . $lang;

        $bhavaSynthesis = [];

        for ($h = 1; $h <= 12; $h++) {
            // Find Rasi corresponding to Bhava h
            $targetRasi = (($lagnaRasi - 1 + ($h - 1)) % 12) + 1;
            $bhavaLord = AshtakavargaAndDignityService::RASI_LORDS[$targetRasi] ?? 'Su';

            // Find where this Bhava lord is placed
            $lordLong = (float)($chartData['planets'][$bhavaLord]['longitude'] ?? 0.0);
            $lordRasi = (int)floor(fmod($lordLong + 360.0, 360.0) / 30.0) + 1;
            $lordBhava = (($lordRasi - $lagnaRasi + 12) % 12) + 1;

            // Query Lord in House rule
            $lordRuleKey = "L{$h}_H{$lordBhava}";
            $lRule = VedangaRule::where('category', 'lord_in_house')->where('rule_key', $lordRuleKey)->first();
            $lordText = $lRule ? ($lRule->$contentField ?? $lRule->content_en) : "Lord of House {$h} in House {$lordBhava}.";
            $lordTranslations = [
                'en' => $lRule ? ($lRule->content_en ?? "Lord of House {$h} in House {$lordBhava}.") : "Lord of House {$h} in House {$lordBhava}.",
                'ml' => $lRule ? ($lRule->content_ml ?? $lRule->content_en ?? "{$h}-ാം ഭാവാധിപൻ {$lordBhava}-ാം ഭാവത്തിൽ.") : "{$h}-ാം ഭാവാധിപൻ {$lordBhava}-ാം ഭാവത്തിൽ.",
                'ta' => $lRule ? ($lRule->content_ta ?? $lRule->content_en ?? "House {$h} Lord in {$lordBhava}.") : "House {$h} Lord in {$lordBhava}.",
                'hi' => $lRule ? ($lRule->content_hi ?? $lRule->content_en ?? "भाव {$h} के स्वामी भाव {$lordBhava} में।") : "भाव {$h} के स्वामी भाव {$lordBhava} में।",
            ];

            // Occupants
            $occupantsPhala = [];
            foreach ($chartData['planet_bhavas'] ?? [] as $pk => $pInfo) {
                if (($pInfo['bhava'] ?? 0) === $h) {
                    $pRuleKey = "{$pk}_H{$h}";
                    $pRule = VedangaRule::where('category', 'planet_in_house')->where('rule_key', $pRuleKey)->first();
                    $occupantsPhala[] = [
                        'planet' => $pk,
                        'name' => $pInfo['name_ml'] ?? $pk,
                        'phala' => $pRule ? ($pRule->$contentField ?? $pRule->content_en) : "{$pk} in Bhava {$h}.",
                    ];
                }
            }

            // Karaka Bhava Nasha Exception Check (Page 98)
            $karakaWarning = null;
            if ($h === 5) {
                $jupBhava = $chartData['planet_bhavas']['Ju']['bhava'] ?? 0;
                $jupDignity = $chartData['dignities']['Ju']['status'] ?? '';
                if ($jupBhava === 5 && $jupDignity !== 'own') {
                    $karakaWarning = ($lang === 'ml')
                        ? 'കാരക ഭാവ നാശം (വ്യാഴം അഞ്ചാം ഭാവത്തിൽ): സൽസന്താനങ്ങൾക്കായി വിഷ്ണുസഹസ്രനാമ ജപവും വ്യാഴാഴ്ച വ്രതവും നിർദ്ദേശിക്കുന്നു.'
                        : 'Karaka Bhava Nasha (Jupiter in 5th): Spiritual pariharams (Vishnu Sahasranama) recommended for child welfare.';
                }
            } elseif ($h === 7) {
                $venBhava = $chartData['planet_bhavas']['Ve']['bhava'] ?? 0;
                $venDignity = $chartData['dignities']['Ve']['status'] ?? '';
                if ($venBhava === 7 && $venDignity !== 'own') {
                    $karakaWarning = ($lang === 'ml')
                        ? 'കാരക ഭാവ നാശം (ശുക്രൻ ഏഴാം ഭാവത്തിൽ): ദാമ്പത്യ സൗഖ്യത്തിനായി മഹാലക്ഷ്മി പൂജയും പങ്കാളിയോട് പരസ്പര ബഹുമാനവും പുലർത്തുക.'
                        : 'Karaka Bhava Nasha (Venus in 7th): Devotion to Goddess Lakshmi recommended for enduring marital peace.';
                }
            }

            $bhavaSynthesis[$h] = [
                'bhava_number' => $h,
                'meta' => VargaAndBhavaService::BHAVA_METADATA[$h] ?? [],
                'rasi_index' => $targetRasi,
                'bhava_lord' => $bhavaLord,
                'lord_placed_in_bhava' => $lordBhava,
                'lord_phala' => $lordText,
                'lord_phala_translations' => $lordTranslations,
                'analysis_en' => VargaAndBhavaService::BHAVA_METADATA[$h]['significance_en'] ?? '',
                'analysis_ml' => VargaAndBhavaService::BHAVA_METADATA[$h]['significance_ml'] ?? '',
                'analysis_ta' => VargaAndBhavaService::BHAVA_METADATA[$h]['significance_ta'] ?? '',
                'analysis_hi' => VargaAndBhavaService::BHAVA_METADATA[$h]['significance_hi'] ?? '',
                'lord_placement_en' => $lordTranslations['en'] ?? '',
                'lord_placement_ml' => $lordTranslations['ml'] ?? '',
                'lord_placement_ta' => $lordTranslations['ta'] ?? '',
                'lord_placement_hi' => $lordTranslations['hi'] ?? '',
                'occupants' => $occupantsPhala,
                'karaka_exception' => $karakaWarning,
            ];
        }

        // Diagnostics: Wealth Sources (Page 103), Speech/Food, Marriage timing, Health
        $wealthSources = [];
        foreach (['Su', 'Mo', 'Ma', 'Me', 'Ju', 'Ve', 'Sa'] as $pk) {
            $pb = $chartData['planet_bhavas'][$pk]['bhava'] ?? 0;
            if (in_array($pb, [2, 10], true)) {
                $wRule = VedangaRule::where('category', 'wealth_source')->where('rule_key', "wealth_{$pk}")->first();
                if ($wRule) {
                    $wealthSources[] = [
                        'en' => $wRule->content_en,
                        'ml' => $wRule->content_ml ?? $wRule->content_en,
                        'ta' => $wRule->content_ta ?? $wRule->content_en,
                        'hi' => $wRule->content_hi ?? $wRule->content_en,
                    ];
                }
            }
        }

        $healthCareAdvice = [];
        foreach (['Su', 'Mo', 'Ma', 'Me', 'Ju', 'Ve', 'Sa'] as $pk) {
            $pb = $chartData['planet_bhavas'][$pk]['bhava'] ?? 0;
            if (in_array($pb, [6, 8, 12], true)) {
                $hRule = VedangaRule::where('category', 'health_care')->where('rule_key', "health_{$pk}")->first();
                if ($hRule) {
                    $healthCareAdvice[] = $hRule->$contentField ?? $hRule->content_en;
                }
            }
        }

        return [
            'bhavas' => $bhavaSynthesis,
            'wealth_sources' => $wealthSources,
            'health_advice' => $healthCareAdvice,
        ];
    }
}

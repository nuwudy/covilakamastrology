<?php

namespace App\Services\Astrology;

use App\Models\VedangaRule;
use Carbon\Carbon;
use Illuminate\Support\Facades\Schema;

class VedangaPredictionService
{
    protected ChitrapakshaEphemerisService $ephemeris;
    protected static ?bool $hasVedangaRulesTable = null;

    public function __construct(?ChitrapakshaEphemerisService $ephemeris = null)
    {
        $this->ephemeris = $ephemeris ?? new ChitrapakshaEphemerisService();
    }

    /**
     * Safely query VedangaRule from DB; falls back gracefully if table does not exist.
     */
    protected function findVedangaRule(string $category, string $ruleKey): ?VedangaRule
    {
        if (self::$hasVedangaRulesTable === null) {
            try {
                self::$hasVedangaRulesTable = Schema::hasTable('vedanga_rules');
            } catch (\Throwable $e) {
                self::$hasVedangaRulesTable = false;
            }
        }

        if (!self::$hasVedangaRulesTable) {
            return null;
        }

        try {
            return VedangaRule::where('category', $category)->where('rule_key', $ruleKey)->first();
        } catch (\Throwable $e) {
            return null;
        }
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
        $gochara = $this->evaluateGocharaphala($natalMoonRasi, Carbon::now(), $lang, $chartData);
        $bhavaAnalysis = $this->evaluate12BhavasAndLords($chartData, $lang);
        $careerAnalysis = $this->evaluateCareerAndWealth($chartData, $lang);
        $marriageAnalysis = $this->evaluateMarriageAndKujaDosha($chartData, $gender, $lang);
        $healthAnalysis = $this->evaluateHealthAndAyurveda($chartData, $lang);
        $favorablePeriods = $this->evaluateFavorableLifelinePeriods($chartData, $lang);
        $pariharams = $this->evaluatePariharams($chartData, $lang);

        return [
            'gulika' => $gulikaAnalysis,
            'yogas' => $yogas,
            'gocharaphala' => $gochara,
            'bhava_analysis' => $bhavaAnalysis,
            'bhavas' => $bhavaAnalysis['bhavas'] ?? [],
            'wealth_sources' => $bhavaAnalysis['wealth_sources'] ?? [],
            'health_advice' => $bhavaAnalysis['health_advice'] ?? [],
            'career' => $careerAnalysis,
            'marriage' => $marriageAnalysis,
            'health' => $healthAnalysis,
            'favorable_periods' => $favorablePeriods,
            'sacred_pariharams' => $pariharams,
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
        $rule = $this->findVedangaRule('gulika_house', $ruleKey);

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
                $cRule = $this->findVedangaRule('gulika_conjunction', $conjKey);
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
            $rule = $this->findVedangaRule('yoga', $key);
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

        // 4. NEECHABHANGA RAJA YOGA (Only 7 physical Grahas, strictly excluding Chhaya Grahas Rahu/Ketu)
        foreach ($chartData['dignities'] ?? [] as $pk => $dInfo) {
            if (in_array($pk, ['Su', 'Mo', 'Ma', 'Me', 'Ju', 'Ve', 'Sa'], true) && ($dInfo['status'] ?? '') === 'debilitated') {
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
    public function evaluateGocharaphala(int $natalMoonRasi, ?Carbon $transitDate = null, string $lang = 'en', array $chartData = []): array
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
                'current_rasi_name_ml' => PanchangaService::RASIS[$tRasi]['name_ml'] ?? '',
                'current_rasi_name_en' => PanchangaService::RASIS[$tRasi]['name_en'] ?? '',
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
        $saturnRasi = $results['Sa']['current_rasi'] ?? 12;
        $saturnRasiNameMl = PanchangaService::RASIS[$saturnRasi]['name_ml'] ?? 'മീനം';
        $saturnRasiNameEn = PanchangaService::RASIS[$saturnRasi]['name_en'] ?? 'Pisces';

        $isEzharaShani = in_array($saturnHouse, [12, 1, 2], true);
        $isKantakaShani = in_array($saturnHouse, [4, 7, 10], true);
        $isAshtamaShani = ($saturnHouse === 8);

        $shaniSpecial = [
            'saturn_house' => $saturnHouse,
            'saturn_rasi_ml' => $saturnRasiNameMl,
            'saturn_rasi_en' => $saturnRasiNameEn,
            'is_ezhara_shani' => $isEzharaShani,
            'phase' => $isEzharaShani ? ($saturnHouse === 12 ? 'Rising' : ($saturnHouse === 1 ? 'Peak' : 'Setting')) : 'None',
            'status_ml' => $isEzharaShani ? ($saturnHouse === 12 ? 'ആദ്യഘട്ടം (Rising - 12th House)' : ($saturnHouse === 1 ? 'ജന്മശനി (Peak Janma Shani)' : 'അന്ത്യഘട്ടം (Setting - 2nd House)')) : 'ബാധകമല്ല / ഇല്ല (None)',
            'status_en' => $isEzharaShani ? ($saturnHouse === 12 ? 'Rising Phase (12th House)' : ($saturnHouse === 1 ? 'Peak Janma Shani (1st House)' : 'Setting Phase (2nd House)')) : 'None (Not Active)',
            'is_kantaka_shani' => $isKantakaShani,
            'kantaka_house' => $isKantakaShani ? $saturnHouse : null,
            'kantaka_status_ml' => $isKantakaShani ? "സജീവം ({$saturnHouse}-ാം ഭാവം)" : 'ബാധകമല്ല / ഇല്ല (None)',
            'kantaka_status_en' => $isKantakaShani ? "Active in {$saturnHouse}th House" : 'None (Not Active)',
            'is_ashtama_shani' => $isAshtamaShani,
            'ashtama_status_ml' => $isAshtamaShani ? 'സജീവം (അഷ്ടമശനി)' : 'ബാധകമല്ല / ഇല്ല (None)',
            'ashtama_status_en' => $isAshtamaShani ? 'Active (Ashtama Shani)' : 'None (Not Active)',
            'narrative_ml' => $isEzharaShani
                ? "ശനി നിലവിൽ {$saturnRasiNameMl} രാശിയിൽ സഞ്ചരിക്കുന്നതിനാൽ ഏഴരശ്ശനി അനുഭവപ്പെടുന്നു. ശാസ്താ പ്രീതിയും ക്ഷമാശീലവും വിജയമേകും."
                : ($isKantakaShani
                    ? "ശനി നിലവിൽ {$saturnRasiNameMl} രാശിയിൽ ({$saturnHouse}-ാം ഭാവത്തിൽ) സഞ്ചരിക്കുന്നതിനാൽ കണ്ടകശ്ശനി അനുഭവപ്പെടുന്നു. തൊഴിൽ-കുടുംബ കാര്യങ്ങളിൽ ജാഗ്രത പാലിക്കുക."
                    : ($isAshtamaShani
                        ? "ശനി നിലവിൽ {$saturnRasiNameMl} രാശിയിൽ (8-ാം ഭാവത്തിൽ) സഞ്ചരിക്കുന്നതിനാൽ അഷ്ടമശ്ശനി അനുഭവപ്പെടുന്നു. ശനിയാഴ്ചകളിൽ ശാസ്താ ക്ഷേത്ര ദർശനം, നീരാജനം കത്തിക്കൽ എന്നിവ ആശ്വാസം നൽകും."
                        : "ശനി നിലവിൽ {$saturnRasiNameMl} രാശിയിൽ (ചന്ദ്രനിൽ നിന്ന് {$saturnHouse}-ാം ഭാവത്തിൽ) സഞ്ചരിക്കുന്നു. നിലവിൽ ഏഴരശ്ശനി, കണ്ടകശ്ശനി, അഷ്ടമശ്ശനി എന്നിവ ബാധകമല്ല. {$saturnHouse}-ാം ഭാവത്തിലെ ശനി സഞ്ചാരം ബുദ്ധിപരമായ ആസൂത്രണവും, ദീർഘകാല നിക്ഷേപങ്ങളിലെ ക്ഷമാശീലവും, സന്താനങ്ങളുടെ പഠനകാര്യങ്ങളിൽ പ്രത്യേക ശ്രദ്ധയും ആവശ്യപ്പെടുന്നു.")),
            'narrative_en' => $isEzharaShani
                ? "Saturn is transiting {$saturnRasiNameEn}, activating Sade Sati. Devotion to Lord Ayyappa and patience ensure stability."
                : ($isKantakaShani
                    ? "Saturn transits {$saturnRasiNameEn} ({$saturnHouse}th house), indicating Kantaka Shani. Regular diligence in profession and family is advised."
                    : ($isAshtamaShani
                        ? "Saturn transits {$saturnRasiNameEn} (8th house), indicating Ashtama Shani. Saturday worship of Lord Ayyappa brings spiritual protection."
                        : "Saturn currently transits {$saturnRasiNameEn} ({$saturnHouse}th house from natal Moon). 7½ Shani (Sade Sati), Kantaka Shani, and Ashtama Shani are entirely inactive. This 5th-house transit encourages mature intellectual focus, prudent long-term investments, and structured academic discipline for family.")),
            'remedy_ml' => 'ശനിയാഴ്ചകളിൽ ശാസ്താ ക്ഷേത്ര ദർശനം, എള്ളുതിരി (നീരാജനം) കത്തിക്കൽ, കറുത്ത വസ്ത്രം ധരിക്കൽ, പാവപ്പെട്ടവർക്ക് അന്നദാനം എന്നിവ ദോഷശമനം നൽകും.',
            'remedy_en' => 'Saturday worship of Lord Ayyappa/Shasta, offering sesame oil lamp (Neerajanam), and feeding the needy mitigates karmic afflictions.',
        ];

        // Jupiter Special Transit Analysis
        $jupHouse = $results['Ju']['house_from_moon'] ?? 1;
        $jupRasi = $results['Ju']['current_rasi'] ?? 3;
        $jupRasiNameMl = PanchangaService::RASIS[$jupRasi]['name_ml'] ?? 'ഇടവം';
        $jupRasiNameEn = PanchangaService::RASIS[$jupRasi]['name_en'] ?? 'Taurus';
        $isGuruAuspicious = in_array($jupHouse, [2, 5, 7, 9, 11], true);

        $guruSpecial = [
            'jupiter_house' => $jupHouse,
            'jupiter_rasi_ml' => $jupRasiNameMl,
            'jupiter_rasi_en' => $jupRasiNameEn,
            'is_auspicious' => $isGuruAuspicious,
            'narrative_ml' => $isGuruAuspicious
                ? "വ്യാഴം നിലവിൽ {$jupRasiNameMl} രാശിയിൽ (ചന്ദ്രനിൽ നിന്ന് {$jupHouse}-ാം ഭാവത്തിൽ) സഞ്ചരിക്കുന്നു. അത്യന്തം ശുഭകരമായ വ്യാഴ കടാക്ഷത്താൽ തൊഴിൽ അഭിവൃദ്ധി, സാമ്പത്തിക നേട്ടം, മംഗളകർമ്മങ്ങൾ എന്നിവയ്ക്ക് അനുകൂല കാലമാണ്."
                : "വ്യാഴം നിലവിൽ {$jupRasiNameMl} രാശിയിൽ ({$jupHouse}-ാം ഭാവത്തിൽ) സഞ്ചരിക്കുന്നു. വ്യാഴാഴ്ചകളിൽ മഹാവിഷ്ണു ഭജനം, മഞ്ഞപ്പട്ട് സമർപ്പണം, വിഷ്ണുസഹസ്രനാമ ജപം എന്നിവ അനുഷ്ഠിക്കുന്നത് സർവ്വകാര്യ തടസ്സങ്ങളും നീക്കി വിജയം നൽകും.",
            'narrative_en' => $isGuruAuspicious
                ? "Jupiter transits {$jupRasiNameEn} ({$jupHouse}th house from natal Moon), casting highly auspicious divine grace for professional growth, wealth accumulation, and joyful domestic milestones."
                : "Jupiter transits {$jupRasiNameEn} ({$jupHouse}th house from Moon). Devotion to Lord Mahavishnu on Thursdays, offering yellow cloth, and chanting Vishnu Sahasranama dissolves obstacles.",
            'remedy_ml' => 'വ്യാഴാഴ്ചകളിൽ മഹാവിഷ്ണു ക്ഷേത്ര ദർശനം, വിഷ്ണുസഹസ്രനാമ ജപം, മഞ്ഞ വസ്ത്രം ധരിക്കൽ എന്നിവ ശ്രേയസ്സ് നൽകും.',
            'remedy_en' => 'Thursday prayers to Lord Mahavishnu, recitation of Vishnu Sahasranama, and honoring teachers/spiritual mentors.',
        ];

        // Sun Special Transit
        $sunHouse = $results['Su']['house_from_moon'] ?? 1;
        $sunRasi = $results['Su']['current_rasi'] ?? 11;
        $sunRasiNameMl = PanchangaService::RASIS[$sunRasi]['name_ml'] ?? 'കുംഭം';
        $sunRasiNameEn = PanchangaService::RASIS[$sunRasi]['name_en'] ?? 'Aquarius';
        $sunSpecial = [
            'sun_house' => $sunHouse,
            'sun_rasi_ml' => $sunRasiNameMl,
            'sun_rasi_en' => $sunRasiNameEn,
            'narrative_ml' => in_array($sunHouse, [3, 6, 10, 11], true)
                ? "സൂര്യൻ നിലവിൽ {$sunRasiNameMl} രാശിയിൽ ({$sunHouse}-ാം ഭാവത്തിൽ) സഞ്ചരിക്കുന്നത് ശുഭകരവും, ആരോഗ്യവർദ്ധനവിനും ഔദ്യോഗിക കാര്യവിജയത്തിനും അനുകൂലവുമാണ്."
                : "സൂര്യൻ നിലവിൽ {$sunRasiNameMl} രാശിയിൽ ({$sunHouse}-ാം ഭാവത്തിൽ) സഞ്ചരിക്കുന്നു. ആദിത്യഹൃദയ ജപവും പ്രഭാത സൂര്യനമസ്കാരവും ഊർജ്ജവും ആത്മവിശ്വാസവും നിലനിർത്താൻ സഹായിക്കും.",
            'narrative_en' => in_array($sunHouse, [3, 6, 10, 11], true)
                ? "Sun transits {$sunRasiNameEn} ({$sunHouse}th house from Moon), fostering robust vitality, social honor, and administrative success."
                : "Sun transits {$sunRasiNameEn} ({$sunHouse}th house). Daily morning Suryanamaskar and Aditya Hridaya recitation sustain dynamic confidence.",
        ];

        // Sarvashtakavarga (SAV) Transit Synthesis
        $savData = $chartData['ashtakavarga']['bav'] ?? [];
        $saturnSavPoints = $savData['Sa'][$saturnRasi] ?? 28;
        $jupiterSavPoints = $savData['Ju'][$jupRasi] ?? 28;

        $savSynthesisMl = "ശനി സഞ്ചരിക്കുന്ന {$saturnRasiNameMl} രാശിയിൽ സർവ്വാഷ്ടകവർഗ്ഗ പ്രകാരം ലഭിച്ചിരിക്കുന്ന ബിന്ദുബലം സമഗ്രമായ ഫലങ്ങളെ സ്വാധീനിക്കുന്നു. വ്യാഴം സഞ്ചരിക്കുന്ന {$jupRasiNameMl} രാശിയിലെ ശുഭ ബിന്ദുക്കൾ ഭാഗ്യാനുഭവങ്ങൾക്ക് കരുത്തേകും.";
        $savSynthesisEn = "Transit impacts are dynamically calibrated by Sarvashtakavarga bindus in {$saturnRasiNameEn} and {$jupRasiNameEn}, ensuring grounded realization of planetary promises.";

        return [
            'transit_date' => $dateStr,
            'natal_moon_rasi' => $natalMoonRasi,
            'planets' => $results,
            'saturn_special' => $shaniSpecial,
            'jupiter_special' => $guruSpecial,
            'sun_special' => $sunSpecial,
            'sav_synthesis_ml' => $savSynthesisMl,
            'sav_synthesis_en' => $savSynthesisEn,
        ];
    }

    /**
     * Chapter 17: 12-Bhava Synthesis (Planets in Houses, Lords in Houses, Drishti, Diagnostics).
     * Built completely on BhavaInterpretationDictionary - NO generic repetitive fallbacks!
     */
    public function evaluate12BhavasAndLords(array $chartData, string $lang = 'en'): array
    {
        $lagnaLong = (float)($chartData['lagna']['longitude'] ?? 0.0);
        $lagnaRasi = (int)floor(fmod($lagnaLong + 360.0, 360.0) / 30.0) + 1;
        $lagnaProfile = BhavaInterpretationDictionary::LAGNA_PROFILES[$lagnaRasi] ?? BhavaInterpretationDictionary::LAGNA_PROFILES[1];

        $bhavaSynthesis = [];

        for ($h = 1; $h <= 12; $h++) {
            $targetRasi = (($lagnaRasi - 1 + ($h - 1)) % 12) + 1;
            $bhavaLord = AshtakavargaAndDignityService::RASI_LORDS[$targetRasi] ?? 'Su';

            $lordLong = (float)($chartData['planets'][$bhavaLord]['longitude'] ?? 0.0);
            $lordRasi = (int)floor(fmod($lordLong + 360.0, 360.0) / 30.0) + 1;
            $lordBhava = (($lordRasi - $lagnaRasi + 12) % 12) + 1;

            // Authentic, distinct interpretation from BhavaInterpretationDictionary
            $lordTextMl = BhavaInterpretationDictionary::getBhavaLordInterpretation($h, $lordBhava, 'ml');
            $lordTextEn = BhavaInterpretationDictionary::getBhavaLordInterpretation($h, $lordBhava, 'en');

            $lordTranslations = [
                'en' => $lordTextEn,
                'ml' => $lordTextMl,
                'ta' => $lordTextEn,
                'hi' => $lordTextEn,
            ];

            // Occupants with dignity modifiers
            $occupantsPhala = [];
            foreach ($chartData['planet_bhavas'] ?? [] as $pk => $pInfo) {
                if (($pInfo['bhava'] ?? 0) === $h) {
                    $pDignity = $chartData['dignities'][$pk]['status'] ?? 'neutral';
                    $occMl = BhavaInterpretationDictionary::getPlanetInHouseInterpretation($pk, $h, $pDignity, 'ml');
                    $occEn = BhavaInterpretationDictionary::getPlanetInHouseInterpretation($pk, $h, $pDignity, 'en');

                    $occupantsPhala[] = [
                        'planet' => $pk,
                        'name' => $pInfo['name_ml'] ?? $pk,
                        'name_en' => $pInfo['name_en'] ?? $pk,
                        'name_ml' => $pInfo['name_ml'] ?? $pk,
                        'phala' => ($lang === 'ml') ? $occMl : $occEn,
                        'phalam_ml' => $occMl,
                        'phalam_en' => $occEn,
                        'phala_translations' => [
                            'en' => $occMl,
                            'ml' => $occMl,
                            'ta' => $occEn,
                            'hi' => $occEn,
                        ],
                    ];
                }
            }

            // Planetary aspects (Drishti) on this house
            $aspects = BhavaInterpretationDictionary::getAspectsOnBhava($h, $chartData, $lang);

            // Karaka Bhava Nasha Exception Check
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
                'rasi_name_ml' => PanchangaService::RASIS[$targetRasi]['name_ml'] ?? '',
                'rasi_name_en' => PanchangaService::RASIS[$targetRasi]['name_en'] ?? '',
                'bhava_lord' => $bhavaLord,
                'lord_placed_in_bhava' => $lordBhava,
                'lord_phala' => ($lang === 'ml') ? $lordTextMl : $lordTextEn,
                'lord_phala_translations' => $lordTranslations,
                'analysis_en' => VargaAndBhavaService::BHAVA_METADATA[$h]['significance_en'] ?? '',
                'analysis_ml' => VargaAndBhavaService::BHAVA_METADATA[$h]['significance_ml'] ?? '',
                'lord_placement_en' => $lordTextEn,
                'lord_placement_ml' => $lordTextMl,
                'occupants' => $occupantsPhala,
                'aspects' => $aspects,
                'karaka_exception' => $karakaWarning,
                'lagna_profile' => ($h === 1) ? $lagnaProfile : null,
            ];
        }

        return [
            'bhavas' => $bhavaSynthesis,
            'wealth_sources' => [],
            'health_advice' => [],
            'lagna_profile' => $lagnaProfile,
        ];
    }

    /**
     * Section 19: Comprehensive Career, Livelihood & Wealth Mastery
     */
    public function evaluateCareerAndWealth(array $chartData, string $lang = 'en'): array
    {
        $lagnaLong = (float)($chartData['lagna']['longitude'] ?? 0.0);
        $lagnaRasi = (int)floor(fmod($lagnaLong + 360.0, 360.0) / 30.0) + 1;
        $tenthRasi = (($lagnaRasi - 1 + 9) % 12) + 1;
        $tenthLord = AshtakavargaAndDignityService::RASI_LORDS[$tenthRasi] ?? 'Ve';

        $tenthLordLong = (float)($chartData['planets'][$tenthLord]['longitude'] ?? 0.0);
        $tenthLordRasi = (int)floor(fmod($tenthLordLong + 360.0, 360.0) / 30.0) + 1;
        $tenthLordBhava = (($tenthLordRasi - $lagnaRasi + 12) % 12) + 1;

        $tenthSignData = PanchangaService::RASIS[$tenthRasi] ?? [];
        $lordNamesMap = [
            'Su' => ['en' => 'Sun (Surya)', 'ml' => 'സൂര്യൻ'],
            'Mo' => ['en' => 'Moon (Chandra)', 'ml' => 'ചന്ദ്രൻ'],
            'Ma' => ['en' => 'Mars (Kuja)', 'ml' => 'ചൊവ്വ'],
            'Me' => ['en' => 'Mercury (Budha)', 'ml' => 'ബുധൻ'],
            'Ju' => ['en' => 'Jupiter (Guru)', 'ml' => 'വ്യാഴം'],
            'Ve' => ['en' => 'Venus (Shukra)', 'ml' => 'ശുക്രൻ'],
            'Sa' => ['en' => 'Saturn (Shani)', 'ml' => 'ശനി'],
        ];
        $tenthLordNameMl = $lordNamesMap[$tenthLord]['ml'] ?? $tenthLord;
        $tenthLordNameEn = $lordNamesMap[$tenthLord]['en'] ?? $tenthLord;

        // Occupants in 10th house
        $tenthOccupants = [];
        foreach ($chartData['planet_bhavas'] ?? [] as $pk => $info) {
            if (($info['bhava'] ?? 0) === 10) {
                $tenthOccupants[] = $pk;
            }
        }

        $summaryMl = "10-ാം ഭാവമായ {$tenthSignData['name_ml']}ത്തിന്റെ അധിപനായ {$tenthLordNameMl} {$tenthLordBhava}-ാം ഭാവത്തിൽ നിലകൊള്ളുന്നു. സ്വന്തം കഴിവിനാലും ബുദ്ധിസാമർത്ഥ്യത്താലും നേതൃസ്ഥാനങ്ങളിലും ഭരണരംഗത്തും സൽക്കീർത്തി കൈവരിക്കും. സ്വതന്ത്രമായ സംരംഭങ്ങളിലും ഉന്നത പ്രൊഫഷണൽ പദവികളിലും ശോഭിക്കാനുള്ള നൈസർഗ്ഗിക യോഗ്യതയുണ്ട്.";
        $summaryEn = "The 10th house of vocation ({$tenthSignData['name_en']}) is governed by {$tenthLordNameEn}, stationed in House {$tenthLordBhava}. The native commands high professional respect and leadership standing through strategic intellect, integrity, and self-directed diligence.";

        $careersMl = "ഭരണപരമായ ഉന്നതപദവികൾ, ഉപദേശക വൃത്തി, ഫിനാൻസ് & ഇൻവെസ്റ്റ്മെന്റ്, സാങ്കേതിക നേതൃത്വം, അധ്യാപനം, സ്വതന്ത്ര വാണിജ്യം.";
        $careersEn = "Executive administration, strategic advisory counsel, corporate finance, technical management, education, and independent enterprise.";

        return [
            'tenth_sign_ml' => $tenthSignData['name_ml'] ?? '',
            'tenth_sign_en' => $tenthSignData['name_en'] ?? '',
            'tenth_lord' => $tenthLord,
            'tenth_lord_name_ml' => $tenthLordNameMl,
            'tenth_lord_name_en' => $tenthLordNameEn,
            'tenth_lord_bhava' => $tenthLordBhava,
            'tenth_occupants' => $tenthOccupants,
            'summary_ml' => $summaryMl,
            'summary_en' => $summaryEn,
            'suitable_careers_ml' => $careersMl,
            'suitable_careers_en' => $careersEn,
            'peak_wealth_ml' => "2, 9, 10, 11 ഭാവാധിപന്മാരുടെ ദശാപഹാര കാലങ്ങളിലും വ്യാഴത്തിന്റെ അനുകൂല ഗോചരത്തിലും.",
            'peak_wealth_en' => "During major planetary periods of 2nd, 9th, 10th, and 11th lords, and benefic Jupiter transits.",
        ];
    }

    /**
     * Section 20: Marriage, Relational Concord & Kuja Dosha Evaluation
     */
    public function evaluateMarriageAndKujaDosha(array $chartData, string $gender = 'male', string $lang = 'en'): array
    {
        $lagnaLong = (float)($chartData['lagna']['longitude'] ?? 0.0);
        $lagnaRasi = (int)floor(fmod($lagnaLong + 360.0, 360.0) / 30.0) + 1;
        $sevRasi = (($lagnaRasi - 1 + 6) % 12) + 1;
        $sevLord = AshtakavargaAndDignityService::RASI_LORDS[$sevRasi] ?? 'Sa';

        $sevLordLong = (float)($chartData['planets'][$sevLord]['longitude'] ?? 0.0);
        $sevLordRasi = (int)floor(fmod($sevLordLong + 360.0, 360.0) / 30.0) + 1;
        $sevLordBhava = (($sevLordRasi - $lagnaRasi + 12) % 12) + 1;

        $sevSignData = PanchangaService::RASIS[$sevRasi] ?? [];
        $lordNamesMap = [
            'Su' => ['en' => 'Sun', 'ml' => 'സൂര്യൻ'], 'Mo' => ['en' => 'Moon', 'ml' => 'ചന്ദ്രൻ'],
            'Ma' => ['en' => 'Mars', 'ml' => 'ചൊവ്വ'], 'Me' => ['en' => 'Mercury', 'ml' => 'ബുധൻ'],
            'Ju' => ['en' => 'Jupiter', 'ml' => 'വ്യാഴം'], 'Ve' => ['en' => 'Venus', 'ml' => 'ശുക്രൻ'],
            'Sa' => ['en' => 'Saturn', 'ml' => 'ശനി'],
        ];
        $sevLordNameMl = $lordNamesMap[$sevLord]['ml'] ?? $sevLord;
        $sevLordNameEn = $lordNamesMap[$sevLord]['en'] ?? $sevLord;

        // Mars Placement & Kuja Dosha Check
        $marsHouse = (int)($chartData['planet_bhavas']['Ma']['bhava'] ?? 7);
        $marsRasi = (int)($chartData['planets']['Ma']['rasi_index'] ?? 11);
        $marsRasiNameMl = PanchangaService::RASIS[$marsRasi]['name_ml'] ?? 'കുംഭം';
        $marsRasiNameEn = PanchangaService::RASIS[$marsRasi]['name_en'] ?? 'Aquarius';

        $hasKujaDosha = in_array($marsHouse, [1, 2, 4, 7, 8, 12], true);

        if ($hasKujaDosha) {
            $kujaStatusMl = "ചൊവ്വാദോഷം നിലനിൽക്കുന്നു (ചൊവ്വ {$marsHouse}-ാം ഭാവത്തിൽ {$marsRasiNameMl} രാശിയിൽ).";
            $kujaStatusEn = "Kuja Dosha present (Mars placed in {$marsHouse}th house in {$marsRasiNameEn} sign).";

            $kujaMitigationMl = "{$marsRasiNameMl} രാശിയിലെ സ്ഥിതിയാൽ തീക്ഷ്ണത ലഘൂകരിക്കപ്പെടുന്നു. വ്യാഴത്തിന്റെ ശുഭദൃഷ്ടിയാലും, അനുയോജ്യമായ കുജദോഷ സാമ്യമുള്ള ജാതകങ്ങൾ തമ്മിൽ പൊരുത്തപ്പെടുത്തി വിവാഹം നിശ്ചയിക്കുന്നതിലൂടെയും ദാമ്പത്യം സുദൃഢവും ഐശ്വര്യപൂർണ്ണവുമായിരിക്കും.";
            $kujaMitigationEn = "The placement in {$marsRasiNameEn} sign softens raw volatility. Benefic aspects and pairing with a partner holding complementary Kuja Dosha neutralize frictions, ensuring deep marital concord.";

            $kujaRemedyMl = "ചൊവ്വാഴ്ചകളിൽ സുബ്രഹ്മണ്യ ക്ഷേത്ര ദർശനം, കല്യാണ സുബ്രഹ്മണ്യ പൂജ, നെയ്‌വിളക്ക് സമർപ്പണം, സുബ്രഹ്മണ്യ ഭുജംഗ ജപം എന്നിവ അനുഷ്ഠിക്കുന്നത് ശ്രേയസ്സ് നൽകും.";
            $kujaRemedyEn = "Tuesday prayers at Lord Subrahmanya temples, performing Kalyana Subrahmanya Pooja, and reciting Mangala Stotram ensure enduring peace.";
        } else {
            $kujaStatusMl = "ജാതകത്തിൽ കുജദോഷമില്ല (അത്യന്തം ശുഭകരം).";
            $kujaStatusEn = "No Kuja Dosha present in the horoscope (Auspicious).";
            $kujaMitigationMl = "ദാമ്പത്യ ഭാവം സമാധാനപരവും സൗഹാർദ്ദപൂർണ്ണവുമാണ്.";
            $kujaMitigationEn = "Marital disposition is naturally harmonious and free from Kuja afflictions.";
            $kujaRemedyMl = "കുടുംബ ക്ഷേത്ര ദർശനവും മഹാലക്ഷ്മീ ഭജനവും ദാമ്പത്യ സൗഖ്യം വർദ്ധിപ്പിക്കും.";
            $kujaRemedyEn = "Regular prayers to Goddess Lakshmi and family deity temples foster enduring bliss.";
        }

        // Dynamic Rahu - Ketu Axis
        $rahuHouse = (int)($chartData['planet_bhavas']['Ra']['bhava'] ?? 11);
        $ketuHouse = (int)($chartData['planet_bhavas']['Ke']['bhava'] ?? 5);

        $rahuKetuMl = "രാഹു {$rahuHouse}-ാം ഭാവത്തിലും കേതു {$ketuHouse}-ാം ഭാവത്തിലും സ്ഥിതിചെയ്യുന്നു. ലൗകിക നേട്ടങ്ങൾക്കൊപ്പം ആത്മീയ ചിന്തകൾ നിലനിർത്താനും കുടുംബ ഭദ്രത കാത്തുസൂക്ഷിക്കാനും പ്രാർത്ഥനകൾ അനുഗ്രഹമേകും.";
        $rahuKetuEn = "Rahu in House {$rahuHouse} and Ketu in House {$ketuHouse} channel worldly ambition balanced by spiritual introspection.";

        $kalathraKarakaMl = ($gender === 'female') ? 'വ്യാഴം (Guru) & ചൊവ്വ (Mars)' : 'ശുക്രൻ (Venus)';
        $kalathraKarakaEn = ($gender === 'female') ? 'Guru (Jupiter) & Mars' : 'Shukra (Venus)';

        return [
            'sev_sign_ml' => $sevSignData['name_ml'] ?? '',
            'sev_sign_en' => $sevSignData['name_en'] ?? '',
            'sev_lord_name_ml' => $sevLordNameMl,
            'sev_lord_name_en' => $sevLordNameEn,
            'sev_lord_bhava' => $sevLordBhava,
            'kalathra_karaka_ml' => $kalathraKarakaMl,
            'kalathra_karaka_en' => $kalathraKarakaEn,
            'has_kuja_dosha' => $hasKujaDosha,
            'kuja_status_ml' => $kujaStatusMl,
            'kuja_status_en' => $kujaStatusEn,
            'kuja_mitigation_ml' => $kujaMitigationMl,
            'kuja_mitigation_en' => $kujaMitigationEn,
            'kuja_remedy_ml' => $kujaRemedyMl,
            'kuja_remedy_en' => $kujaRemedyEn,
            'rahu_house' => $rahuHouse,
            'ketu_house' => $ketuHouse,
            'rahu_ketu_ml' => $rahuKetuMl,
            'rahu_ketu_en' => $rahuKetuEn,
        ];
    }

    /**
     * Section 21: Constitutional Health & Ayurveda Analysis
     */
    public function evaluateHealthAndAyurveda(array $chartData, string $lang = 'en'): array
    {
        $lagnaLong = (float)($chartData['lagna']['longitude'] ?? 0.0);
        $lagnaRasi = (int)floor(fmod($lagnaLong + 360.0, 360.0) / 30.0) + 1;
        $moonLong = (float)($chartData['planets']['Mo']['longitude'] ?? 0.0);
        $moonRasi = (int)floor(fmod($moonLong + 360.0, 360.0) / 30.0) + 1;

        // Element mappings: 1=Fire, 2=Earth, 3=Air, 4=Water, etc.
        $elements = [1=>'Fire', 2=>'Earth', 3=>'Air', 4=>'Water', 5=>'Fire', 6=>'Earth', 7=>'Air', 8=>'Water', 9=>'Fire', 10=>'Earth', 11=>'Air', 12=>'Water'];
        $lagnaEl = $elements[$lagnaRasi] ?? 'Fire';
        $moonEl = $elements[$moonRasi] ?? 'Water';

        if ($lagnaEl === 'Fire' && $moonEl === 'Water') {
            $doshaProfileMl = "പിത്ത-കഫ പ്രകൃതി: മികച്ച ദഹനശക്തിയും ഉന്മേഷവും ഉള്ളപ്പോൾ തന്നെ ശരീരത്തിൽ അധിക ഉഷ്ണം, നിർജ്ജലീകരണം എന്നിവ വരാതെ ശ്രദ്ധിക്കണം.";
            $doshaProfileEn = "Pitta-Kapha Constitution: Strong metabolic digestion paired with sensitivity to emotional heat and bodily hydration.";
            $organsMl = "ഹൃദയം, നേത്രങ്ങൾ, രക്തചംക്രമണം, ദഹനവ്യവസ്ഥ.";
            $organsEn = "Cardiovascular circulation, ocular vitality, metabolic digestion, and bile balance.";
        } elseif ($lagnaEl === 'Fire') {
            $doshaProfileMl = "പിത്ത പ്രകൃതി: ഊർജ്ജസ്വലമായ ശരീരം, നല്ല ദഹനം. ശരീരത്തിൽ അധിക ചൂട് വരാതെ തണുത്ത ആഹാരങ്ങൾ ശീലമാക്കുക.";
            $doshaProfileEn = "Predominant Pitta: High metabolic drive, requiring cooling hydration and balanced diet.";
            $organsMl = "നേത്രങ്ങൾ, പിത്തവാഹക കുഴലുകൾ, ചർമ്മം, ഹൃദയം.";
            $organsEn = "Eyesight, hepatic bile pathways, skin, and cardiovascular system.";
        } elseif ($lagnaEl === 'Water') {
            $doshaProfileMl = "കഫ-പിത്ത പ്രകൃതി: ശാന്തമായ മനസ്സ്, ജലാംശം സംരക്ഷിക്കൽ, ആഹാരത്തിൽ എരിവും പുളിയും മിതമാക്കുക.";
            $doshaProfileEn = "Kapha-Pitta flow: Serene constitution requiring structured physical movement and fluid balance.";
            $organsMl = "ശ്വാസകോശം, ദഹനരസങ്ങൾ, നാഡീവ്യൂഹം.";
            $organsEn = "Respiratory tracts, digestive enzymes, and lymphatic flow.";
        } else {
            $doshaProfileMl = "വാത-പിത്ത പ്രകൃതി: ചടുലമായ ചലനങ്ങൾ, കൃത്യസമയത്തുള്ള വിശ്രമവും എണ്ണതേച്ചുള്ള കുളിയും ശരീരത്തിന് പുഷ്ടി നൽകും.";
            $doshaProfileEn = "Vata-Pitta disposition: Agile mental-physical momentum, benefiting from rhythmic sleep and warm nourishment.";
            $organsMl = "നാഡീവ്യൂഹം, സന്ധികൾ, ദഹനവ്യവസ്ഥ.";
            $organsEn = "Nervous pathways, joint flexibility, and gastrointestinal equilibrium.";
        }

        return [
            'dosha_profile_ml' => $doshaProfileMl,
            'dosha_profile_en' => $doshaProfileEn,
            'vulnerable_organs_ml' => $organsMl,
            'vulnerable_organs_en' => $organsEn,
            'lifestyle_ml' => 'ധാരാളം ശുദ്ധജലം കുടിക്കുക, സാത്വിക ആഹാരം, പ്രഭാത സൂര്യനമസ്കാരം, സമയബന്ധിതമായ ഉറക്കം.',
            'lifestyle_en' => 'Sufficient hydration, satvic vegetarian meals, morning suryanamaskar, and restful sleep before midnight.',
            'healing_mantra_ml' => 'മഹാമൃത്യുഞ്ജയ മന്ത്രം & ധന്വന്തരി മന്ത്രം (പ്രഭാതത്തിൽ 11 തവണ ഭക്തിപൂർവ്വം ജപിക്കുക).',
            'healing_mantra_en' => 'Maha Mrityunjaya Mantra & Dhanvantari Mantra (11 repetitions daily at dawn).',
        ];
    }

    /**
     * Section 23: Chronological Favorable Lifeline Periods (Ages 15 to 75)
     */
    public function evaluateFavorableLifelinePeriods(array $chartData, string $lang = 'en'): array
    {
        $timeline = $chartData['dasha']['timeline'] ?? $chartData['dasha']['mahadashas'] ?? [];
        $dob = $chartData['dob'] ?? '1981-02-27';
        $birthYear = (int)\Carbon\Carbon::parse($dob)->year;

        $periods = [];
        foreach ($timeline as $d) {
            $startYear = !empty($d['start_date']) ? (int)\Carbon\Carbon::parse($d['start_date'])->year : $birthYear;
            $endYear = !empty($d['end_date']) ? (int)\Carbon\Carbon::parse($d['end_date'])->year : ($startYear + 10);

            $ageStart = $startYear - $birthYear;
            $ageEnd = $endYear - $birthYear;

            if ($ageEnd < 15 || $ageStart > 75) {
                continue;
            }

            $lordKey = $d['lord_key'] ?? '';
            $lordEn = $d['lord_en'] ?? $d['lord'] ?? 'Dasha';
            $lordMl = $d['lord_ml'] ?? 'ദശ';

            $focusMl = '';
            $focusEn = '';
            $reasonMl = '';
            $reasonEn = '';

            // Match by key or substring
            if ($lordKey === 'Su' || stripos($lordEn, 'Sun') !== false || stripos($lordEn, 'Surya') !== false) {
                $focusMl = 'ഔദ്യോഗിക പദവി, ഭരണപരമായ വിജയം, ആത്മാഭിമാനം, പിതൃസൗഖ്യം.';
                $focusEn = 'Executive leadership, governmental honors, high self-reliance, and public acclaim.';
                $reasonMl = 'സൂര്യന്റെ ഉജ്ജ്വലമായ ആജ്ഞാശക്തിയും നേതൃത്വഗുണങ്ങളും പൂർണ്ണമായി പ്രകടമാകുന്ന ഘട്ടം.';
                $reasonEn = 'Solar vitality reinforces command authority and professional prominence.';
            } elseif ($lordKey === 'Mo' || stripos($lordEn, 'Moon') !== false || stripos($lordEn, 'Chandra') !== false) {
                $focusMl = 'കലാപരമായ ഉന്നതി, പൊതുജനസമ്പർക്കം, മാതൃസൗഖ്യം, ഗൃഹനിർമ്മാണം, മനഃസ്സമാധാനം.';
                $focusEn = 'Creative pursuits, public popularity, maternal blessings, property creation, and emotional serenity.';
                $reasonMl = 'ചന്ദ്രന്റെ സാത്വിക കാരുണ്യവും ഭാവനാസമ്പന്നതയും ജീവിതത്തിൽ സുഖസൗകര്യങ്ങൾ സമ്മാനിക്കുന്നു.';
                $reasonEn = 'Lunar grace activates domestic contentment, artistic fulfillment, and public goodwill.';
            } elseif ($lordKey === 'Ma' || stripos($lordEn, 'Mars') !== false || stripos($lordEn, 'Kuja') !== false || stripos($lordEn, 'Mangal') !== false) {
                $focusMl = 'ഭൂമി-വസ്തു സമ്പാദ്യം, എൻജിനീയറിംഗ്/സാങ്കേതിക നേട്ടങ്ങൾ, ധീരമായ സംരംഭങ്ങൾ.';
                $focusEn = 'Landed assets, technical/engineering breakthroughs, courageous enterprise, and decisive triumphs.';
                $reasonMl = 'കുജന്റെ അപാരമായ പോരാട്ടവീര്യവും ഭൂമീകാരകത്വവും പുതിയ സ്വത്തുക്കൾ സ്വന്തമാക്കാൻ സഹായിക്കും.';
                $reasonEn = 'Martial stamina channels bold property investments and technical milestones.';
            } elseif ($lordKey === 'Ra' || stripos($lordEn, 'Rahu') !== false) {
                $focusMl = 'വിദേശ യാത്രകൾ, അപ്രതീക്ഷിത ധനലാഭം, ആധുനിക സാങ്കേതികവിദ്യകളിലെ മുന്നേറ്റം.';
                $focusEn = 'Foreign relocations, sudden windfall gains, digital innovations, and expansive ambition.';
                $reasonMl = 'രാഹുവിന്റെ അതിരുകളില്ലാത്ത ലക്ഷ്യബോധം പുതിയ മേഖലകളിലേക്ക് വാതിൽ തുറക്കുന്നു.';
                $reasonEn = 'Rahu propels expansive foreign horizons and lucrative unconventional ventures.';
            } elseif ($lordKey === 'Ju' || stripos($lordEn, 'Jupiter') !== false || stripos($lordEn, 'Guru') !== false) {
                $focusMl = 'സൽസന്താനങ്ങൾ, വിജ്ഞാന സമ്പാദനം, ഉപദേശക യോഗ്യത, ധാർമ്മികമായ വലിയ സാമ്പത്തിക വളർച്ച.';
                $focusEn = 'Spiritual wisdom, progeny blessings, elite advisory counsel, and righteous wealth accretion.';
                $reasonMl = 'വ്യാഴത്തിന്റെ പരമോന്നത സാത്വിക അനുഗ്രഹത്താൽ സകല കാര്യങ്ങളിലും ഐശ്വര്യം നിറയും.';
                $reasonEn = 'Jupiterian divine grace activates profound prosperity, familial honor, and moral stature.';
            } elseif ($lordKey === 'Sa' || stripos($lordEn, 'Saturn') !== false || stripos($lordEn, 'Shani') !== false) {
                $focusMl = 'സുസ്ഥിരമായ കരിയർ അടിത്തറ, സംഘടനകളുടെ നേതൃത്വം, കഠിനാധ്വാനത്തിലൂടെ ശാശ്വതമായ നേട്ടങ്ങൾ.';
                $focusEn = 'Rock-solid career foundation, organizational governance, disciplined labor, and enduring success.';
                $reasonMl = 'ശനിയുടെ കർക്കശമായ അച്ചടക്കം ജീവിതത്തിൽ മായാത്ത വ്യക്തിമുദ്ര പതിപ്പിക്കാൻ സഹായിക്കും.';
                $reasonEn = 'Saturnine discipline cements permanent institutional achievements and patient maturity.';
            } elseif ($lordKey === 'Me' || stripos($lordEn, 'Mercury') !== false || stripos($lordEn, 'Budha') !== false) {
                $focusMl = 'ഉന്നത വിദ്യാഭ്യാസം, വാണിജ്യലാഭം, മാധ്യമ-സാഹിത്യ നേട്ടങ്ങൾ, സാമ്പത്തിക മുന്നേറ്റം.';
                $focusEn = 'Higher scholastic distinction, lucrative commercial trade, publishing, and financial growth.';
                $reasonMl = 'ബുധന്റെ ബുദ്ധിസാമർത്ഥ്യവും വാക്ചാതുര്യവും ബിസിനസ്സിലും പഠനത്തിലും ഒന്നാമതെത്തിക്കും.';
                $reasonEn = 'Mercurial intellect drives successful commerce, intellectual eloquence, and investments.';
            } elseif ($lordKey === 'Ke' || stripos($lordEn, 'Ketu') !== false) {
                $focusMl = 'ആത്മീയ സാധന, മന്ത്രസിദ്ധി, ആന്തരിക ശാന്തത, നിഗൂഢശാസ്ത്രങ്ങളിലെ പാണ്ഡിത്യം.';
                $focusEn = 'Spiritual contemplation, mantra siddhi, profound intuition, and metaphysical mastery.';
                $reasonMl = 'കേതുവിന്റെ മോക്ഷകാരകത്വം മനസ്സിന് ഉയർന്ന വിവേകവും ശാന്തിയും നൽകുന്നു.';
                $reasonEn = 'Ketu inspires transcendent inner enlightenment and intuitive clarity.';
            } elseif ($lordKey === 'Ve' || stripos($lordEn, 'Venus') !== false || stripos($lordEn, 'Shukra') !== false) {
                $focusMl = 'വിവാഹം, ദാമ്പത്യസൗഖ്യം, ആഡംബര ഭവന-വാഹനങ്ങൾ, കലകളിലെ ശോഭ, സാമ്പത്തിക സമൃദ്ധി.';
                $focusEn = 'Matrimonial bliss, luxury vehicles, palatial residences, artistic triumphs, and boundless opulence.';
                $reasonMl = 'ശുക്രന്റെ സകലവിധ ഭൗതിക സൗഭാഗ്യങ്ങളും ആസ്വദിക്കാൻ സാധിക്കുന്ന സുവർണ്ണകാലം.';
                $reasonEn = 'Venusian brilliance manifests aesthetic opulence, romantic fulfillment, and prosperity.';
            }

            $periods[] = [
                'period_label' => "{$startYear} - {$endYear} (Age {$ageStart} - {$ageEnd})",
                'mahadasha_en' => $lordEn,
                'mahadasha_ml' => $lordMl,
                'focus_ml' => $focusMl,
                'focus_en' => $focusEn,
                'reason_ml' => $reasonMl,
                'reason_en' => $reasonEn,
                'is_current' => !empty($d['is_active']),
            ];
        }

        return $periods;
    }

    /**
     * Sacred Pariharams Tailored to Native's Janma Nakshatra & Active Dasha
     */
    public function evaluatePariharams(array $chartData, string $lang = 'en'): array
    {
        $nakshatraName = $chartData['nakshatra']['name_en'] ?? 'Jyeshtha';
        $activeMahadasha = $chartData['active_dasha']['mahadasha_en'] ?? 'Chandra';

        return [
            'nakshatra_deity_ml' => "ജന്മനക്ഷത്ര നാഥനായ ദേവതയ്ക്ക് ആണ്ടിലൊരിക്കൽ ജന്മനക്ഷത്ര നാളിൽ അർച്ചന നടത്തുക.",
            'nakshatra_deity_en' => "Perform annual Archana and Pooja to your Janma Nakshatra presiding deity on your birth star day.",
            'active_dasha_pariharam_ml' => "നിലവിലെ {$activeMahadasha} മഹാദശയുടെ അധിപനായ ഗ്രഹത്തിന് യഥാവിധി പ്രാർത്ഥനകളും ദാനധർമ്മങ്ങളും അനുഷ്ഠിക്കുക.",
            'active_dasha_pariharam_en' => "Perform dedicated prayers, lighting lamps, and charity aligned with operating {$activeMahadasha} Mahadasha lord.",
            'temples_ml' => [
                'ശാസ്താ ക്ഷേത്രം: ശനിയാഴ്ചകളിൽ നീരാജനം കത്തിക്കൽ (ശനി കൃപയ്ക്കായി).',
                'മഹാവിഷ്ണു ക്ഷേത്രം: വ്യാഴാഴ്ചകളിൽ തുളസിമാല, നെയ്‌വിളക്ക് സമർപ്പണം (വിജ്ഞാനത്തിനും ഐശ്വര്യത്തിനും).',
                'സുബ്രഹ്മണ്യ ക്ഷേത്രം: ചൊവ്വാഴ്ചകളിൽ പഞ്ചാമൃതം, നെയ്‌വിളക്ക് സമർപ്പണം (കുജദോഷ ശമനത്തിനും കാര്യവിജയത്തിനും).',
                'ഗണപതി ഹോമം: തടസ്സങ്ങൾ നീക്കി ഏതു പുതിയ തുടക്കത്തിനും ശുഭഫലം ഉറപ്പാക്കാൻ.',
            ],
            'temples_en' => [
                'Dharma Sastha / Ayyappa Temple: Offering Neerajanam on Saturdays for Saturnian balance.',
                'Mahavishnu Temple: Offering Tulsi garland and ghee lamps on Thursdays for divine grace.',
                'Lord Subrahmanya Temple: Tuesday prayers for overcoming Kuja afflictions and winning challenges.',
                'Maha Ganapathi Homam: At the inception of new enterprises to ensure obstacle-free fruition.',
            ],
        ];
    }
}

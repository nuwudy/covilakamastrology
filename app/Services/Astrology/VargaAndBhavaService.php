<?php

namespace App\Services\Astrology;

class VargaAndBhavaService
{
    /**
     * Bhava significations in 4 languages.
     */
    public const BHAVA_METADATA = [
        1 => [
            'name_en' => 'Tanu Bhava (Lagna / Self)',
            'name_ml' => 'തനു ഭാവം (ലഗ്നം / ദേഹം)',
            'name_ta' => 'தனு பாவம் (லக்னம் / உடல்)',
            'name_hi' => 'तनु भाव (लग्न / देह)',
            'significance_en' => 'Physical constitution, vitality, personality, self-realization, and life journey.',
            'significance_ml' => 'ശരീര പ്രകൃതി, ആയുസ്സ്, വ്യക്തിത്വം, തേജസ്സ്, ജീവിത ഗതി എന്നിവ.',
            'significance_ta' => 'உடல் நிலை, ஆயுள், குணநலன்கள் மற்றும் வாழ்க்கை பயணம்.',
            'significance_hi' => 'शारीरिक गठन, स्वास्थ्य, व्यक्तित्व एवं जीवन यात्रा।',
        ],
        2 => [
            'name_en' => 'Dhana Bhava (Wealth / Speech)',
            'name_ml' => 'ധന ഭാവം (ധനം / കുടുംബം / വാക്ക്)',
            'name_ta' => 'தன பாவம் (செல்வம் / பேச்சு)',
            'name_hi' => 'धन भाव (धन / कुटुंब / वाणी)',
            'significance_en' => 'Accumulated wealth, family heritage, speech, eloquence, and primary assets.',
            'significance_ml' => 'സമ്പാദ്യ ധനം, കുടുംബ ബന്ധങ്ങൾ, മധുരമായ സംസാരം, നേത്രങ്ങൾ എന്നിവ.',
            'significance_ta' => 'சேமித்த செல்வம், குடும்பம், பேச்சு வன்மை மற்றும் கல்வி.',
            'significance_hi' => 'संचित धन, पारिवारिक सुख, वाणी एवं प्रारंभिक शिक्षा।',
        ],
        3 => [
            'name_en' => 'Sahaja Bhava (Courage / Siblings)',
            'name_ml' => 'സഹജ ഭാവം (ധൈര്യം / സഹോദരങ്ങൾ / പ്രയത്നം)',
            'name_ta' => 'சகஜ பாவம் (தைரியம் / உடன்பிறப்பு)',
            'name_hi' => 'सहज भाव (साहस / अनुज / पराक्रम)',
            'significance_en' => 'Valour, initiative, younger siblings, artistic talents, and short travels.',
            'significance_ml' => 'പരാക്രമം, ഇളയ സഹോദരങ്ങൾ, കലാപരമായ കഴിവുകൾ, ഹ്രസ്വ യാത്രകൾ എന്നിവ.',
            'significance_ta' => 'வீரம், உடன்பிறப்புகள், முயற்சி மற்றும் குறுகிய பயணம்.',
            'significance_hi' => 'पराक्रम, छोटे भाई-बहन, कलात्मक क्षमता एवं लघु यात्राएं।',
        ],
        4 => [
            'name_en' => 'Sukha Bhava (Happiness / Mother)',
            'name_ml' => 'സുഖ ഭാവം (മാതൃ / ഗൃഹം / വാഹനം)',
            'name_ta' => 'சுக பாவம் (தாய் / வீடு / வாகனம்)',
            'name_hi' => 'सुख भाव (माता / गृह / वाहन)',
            'significance_en' => 'Mother, landed property, conveyances, domestic happiness, and heart.',
            'significance_ml' => 'അമ്മ, ഭൂമി, ഗൃഹം, വാഹനം, മനസ്സമാധാനം, മാതൃബന്ധം എന്നിവ.',
            'significance_ta' => 'தாய் அன்பு, பூமி, வீடு, வாகனம் மற்றும் மன அமைதி.',
            'significance_hi' => 'माता, भूमि, भवन, वाहन एवं मानसिक शांति।',
        ],
        5 => [
            'name_en' => 'Putra Bhava (Children / Intellect)',
            'name_ml' => 'പുത്ര ഭാവം (ബുദ്ധി / സന്താനം / പൂർവ്വപുണ്യം)',
            'name_ta' => 'புத்திர பாவம் (குழந்தைகள் / புத்தி)',
            'name_hi' => 'पुत्र भाव (संतान / बुद्धि / पूर्वपुण्य)',
            'significance_en' => 'Progeny, higher intellect, creative speculation, intuition, and Poorva Punya.',
            'significance_ml' => 'സന്താന സൗഭാഗ്യം, സൂക്ഷ്മ ബുദ്ധി, മന്ത്രസിദ്ധി, പൂർവ്വപുണ്യം എന്നിവ.',
            'significance_ta' => 'சந்தான பாக்கியம், ஆழ்ந்த அறிவு மற்றும் பூர்வ புண்ணியம்.',
            'significance_hi' => 'संतान सुख, तीक्ष्ण बुद्धि, मंत्र विद्या एवं पूर्व जन्म का पुण्य।',
        ],
        6 => [
            'name_en' => 'Ripu/Roga Bhava (Debts / Disease / Enemies)',
            'name_ml' => 'ശത്രു-രോഗ ഭാവം (രോഗം / കടം / എതിർപ്പുകൾ)',
            'name_ta' => 'சத்ரு-ரோக பாவம் (நோய் / கடன் / பகை)',
            'name_hi' => 'रिपु-रोग भाव (शत्रु / ऋण / रोग)',
            'significance_en' => 'Resistance to illness, debts, legal disputes, daily service, and triumph over foes.',
            'significance_ml' => 'ശത്രുജയം, ആരോഗ്യ തടസ്സങ്ങൾ, കടബാധ്യതകൾ, സേവന മനസ്സ് എന്നിവ.',
            'significance_ta' => 'பகை வெற்றி, கடன் சுமை, உடல் நலம் மற்றும் சேவை.',
            'significance_hi' => 'रोग प्रतिरोधक क्षमता, ऋण निवारण, शत्रु विजय एवं सेवा कार्य।',
        ],
        7 => [
            'name_en' => 'Kalatra Bhava (Spouse / Partnership)',
            'name_ml' => 'കളത്ര ഭാവം (ഭാര്യ/ഭർത്താവ് / പങ്കാളിത്തം)',
            'name_ta' => 'களத்திர பாவம் (வாழ்க்கைத் துணை / கூட்டு)',
            'name_hi' => 'कलत्र भाव (जीवनसाथी / साझेदारी)',
            'significance_en' => 'Spouse, marital harmony, business partnerships, and foreign residence.',
            'significance_ml' => 'ദാമ്പത്യ സുഖം, പങ്കാളിത്തം, വിദേശ ബന്ധങ്ങൾ, സാമൂഹിക ഇടപെടലുകൾ എന്നിവ.',
            'significance_ta' => 'திருமண வாழ்க்கை, கூட்டுத் தொழில் மற்றும் சமூகம்.',
            'significance_hi' => 'वैवाहिक सुख, साझेदारी, विदेश गमन एवं सामाजिक प्रतिष्ठा।',
        ],
        8 => [
            'name_en' => 'Ayur/Randhra Bhava (Longevity / Mysticism)',
            'name_ml' => 'ആയുർ ഭാവം (ആയുസ്സ് / നിഗൂഢത / മാറ്റങ്ങൾ)',
            'name_ta' => 'ஆயுள் பாவம் (ஆயுள் / மறைமுக செல்வம்)',
            'name_hi' => 'आयुर् भाव (आयु / गूढ़ विद्या / परिवर्तन)',
            'significance_en' => 'Longevity, unforeseen transformations, hidden wealth, inheritance, and occult knowledge.',
            'significance_ml' => 'ദീർഘായുസ്സ്, അവിചാരിത മാറ്റങ്ങൾ, നിഗൂഢ ശാസ്ത്രം, പൈതൃക സ്വത്ത് എന്നിവ.',
            'significance_ta' => 'நீண்ட ஆயுள், திடீர் பண வரவு மற்றும் ஆன்மீக ரகசியங்கள்.',
            'significance_hi' => 'दीर्घायु, गुप्त धन, आकस्मिक परिवर्तन एवं गूढ़ विद्या।',
        ],
        9 => [
            'name_en' => 'Bhagya Bhava (Fortune / Dharma)',
            'name_ml' => 'ഭാഗ്യ ഭാവം (ഭാഗ്യം / ധർമ്മം / ഗുരു)',
            'name_ta' => 'பாக்ய பாவம் (பாக்கியம் / தர்மம் / குரு)',
            'name_hi' => 'भाग्य भाव (भाग्य / धर्म / गुरु)',
            'significance_en' => 'Divine grace, righteous living (Dharma), father, spiritual guides, and pilgrimages.',
            'significance_ml' => 'ദൈവാനുഗ്രഹം, ധർമ്മ ചിന്ത, പിതാവ്, ഉന്നത വിദ്യാഭ്യാസം, തീർത്ഥയാത്ര എന്നിവ.',
            'significance_ta' => 'இறை அருள், தந்தை ஆசி, தர்ம நெறி மற்றும் உயர்கல்வி.',
            'significance_hi' => 'ईश्वर कृपा, धर्म, पिता का सुख, उच्च शिक्षा एवं तीर्थ यात्रा।',
        ],
        10 => [
            'name_en' => 'Karma Bhava (Career / Prestige)',
            'name_ml' => 'കർമ്മ ഭാവം (തൊഴിൽ / പദവി / യശസ്സ്)',
            'name_ta' => 'கர்ம பாவம் (தொழில் / பதவி / புகழ்)',
            'name_hi' => 'कर्म भाव (आजीविका / पद / यश)',
            'significance_en' => 'Profession, social standing, leadership authority, governance, and worldly renown.',
            'significance_ml' => 'ഉന്നത തൊഴിൽ, സാമൂഹിക പദവി, നേതൃത്വ ഗുണം, കീർത്തി എന്നിവ.',
            'significance_ta' => 'தொழில் வளர்ச்சி, அந்தஸ்து, தலைமைப் பண்பு மற்றும் புகழ்.',
            'significance_hi' => 'कार्यक्षेत्र, उच्च पद, राजकीय सम्मान एवं सामाजिक प्रतिष्ठा।',
        ],
        11 => [
            'name_en' => 'Labha Bhava (Gains / Fulfillment)',
            'name_ml' => 'ലാഭ ഭാവം (ഐശ്വര്യം / അഭിലാഷ സാഫല്യം)',
            'name_ta' => 'லாப பாவம் (வருமானம் / விருப்ப நிறைவு)',
            'name_hi' => 'लाभ भाव (आय / मनोकामना पूर्ति)',
            'significance_en' => 'Substantial gains, fulfillment of desires, elder siblings, and elite networks.',
            'significance_ml' => 'സാമ്പത്തിക നേട്ടങ്ങൾ, ആഗ്രഹ പൂർത്തീകരണം, മൂത്ത സഹോദരങ്ങൾ എന്നിവ.',
            'significance_ta' => 'அனைத்து லாபங்கள், மூத்த சகோதரர் மற்றும் ஆசை நிறைவேறல்.',
            'significance_hi' => 'आर्थिक लाभ, मनोकामना पूर्ति, बड़े भाई-बहन एवं मित्रों का सहयोग।',
        ],
        12 => [
            'name_en' => 'Vyaya Bhava (Expenditure / Liberation)',
            'name_ml' => 'വ്യയ ഭാവം (മോക്ഷം / വിദേശ വാസം / ദാനം)',
            'name_ta' => 'விரய பாவம் (மோட்சம் / வெளிநாடு)',
            'name_hi' => 'व्यय भाव (मोक्ष / विदेश यात्रा / व्यय)',
            'significance_en' => 'Charitable expenditure, foreign settlement, spiritual liberation (Moksha), and sound sleep.',
            'significance_ml' => 'ധർമ്മ വ്യയം, വിദേശ വാസം, നിദ്രാ സുഖം, ആത്മീയ മോക്ഷം എന്നിവ.',
            'significance_ta' => 'புண்ணிய விரயம், வெளிநாட்டு யோகம் மற்றும் மோட்ச நிலை.',
            'significance_hi' => 'शुभ व्यय, विदेश प्रवास, आत्मिक शांति एवं मोक्ष की प्राप्ति।',
        ],
    ];

    /**
     * Compute 12 Bhavas using Lagna as midpoint (±15°) per Vedanga Jyothisham.
     *
     * @param float $lagnaDeg Nirayana Lagna longitude (0..360)
     * @param array $planets Array of calculated planets with 'longitude' and 'key'
     * @return array
     */
    public function computeBhavas(float $lagnaDeg, array $planets): array
    {
        $lagnaDeg = fmod($lagnaDeg, 360.0);
        if ($lagnaDeg < 0) {
            $lagnaDeg += 360.0;
        }

        $bhavas = [];

        for ($h = 1; $h <= 12; $h++) {
            // Midpoint of Bhava h
            $midpoint = fmod($lagnaDeg + (($h - 1) * 30.0), 360.0);
            if ($midpoint < 0) {
                $midpoint += 360.0;
            }

            // Start cusp (Arambha Sandhi) = Midpoint - 15°
            $startCusp = fmod($midpoint - 15.0 + 360.0, 360.0);
            // End cusp (Virama Sandhi) = Midpoint + 15°
            $endCusp = fmod($midpoint + 15.0, 360.0);

            $bhavas[$h] = [
                'bhava_number' => $h,
                'midpoint_deg' => round($midpoint, 4),
                'start_cusp_deg' => round($startCusp, 4),
                'end_cusp_deg' => round($endCusp, 4),
                'meta' => self::BHAVA_METADATA[$h] ?? [],
                'occupants' => [],
            ];
        }

        // Determine which Bhava each planet occupies
        $planetPositions = [];
        foreach ($planets as $planetKey => $pData) {
            $pDeg = (float)($pData['longitude'] ?? 0.0);
            $pDeg = fmod($pDeg, 360.0);
            if ($pDeg < 0) {
                $pDeg += 360.0;
            }

            // Bhava offset from Bhava 1 start cusp
            $bhava1Start = fmod($lagnaDeg - 15.0 + 360.0, 360.0);
            $offset = fmod($pDeg - $bhava1Start + 360.0, 360.0);
            $bhavaNum = (int)floor($offset / 30.0) + 1;
            if ($bhavaNum > 12) {
                $bhavaNum = 12;
            }
            if ($bhavaNum < 1) {
                $bhavaNum = 1;
            }

            // Check if planet is within ±1° of any cusp (Bhavasandhi)
            $distToStart = fmod($offset, 30.0);
            $distToEnd = 30.0 - $distToStart;
            $isSandhi = ($distToStart <= 1.0 || $distToEnd <= 1.0);

            $occupantInfo = [
                'key' => $planetKey,
                'name_en' => $pData['name_en'] ?? $planetKey,
                'name_ml' => $pData['name_ml'] ?? $planetKey,
                'longitude' => round($pDeg, 4),
                'bhava' => $bhavaNum,
                'is_bhavasandhi' => $isSandhi,
                'retrograde' => !empty($pData['is_retrograde']),
                'combust' => !empty($pData['is_combust']),
            ];

            $bhavas[$bhavaNum]['occupants'][] = $occupantInfo;
            $planetPositions[$planetKey] = $occupantInfo;
        }

        return [
            'lagna_deg' => round($lagnaDeg, 4),
            'bhavas' => $bhavas,
            'planet_bhavas' => $planetPositions,
        ];
    }

    /**
     * Compute Shadvarga (D1, D2, D3, D9, D12, D30) for a given sidereal longitude.
     * Rules per Vedanga Jyothisham Pages 57–60.
     *
     * @param float $deg Nirayana Sidereal longitude (0..360)
     * @return array
     */
    public function computeShadvargaForDegree(float $deg): array
    {
        $deg = fmod($deg, 360.0);
        if ($deg < 0) {
            $deg += 360.0;
        }

        $d1Rasi = (int)floor($deg / 30.0) + 1;
        $degInRasi = fmod($deg, 30.0);
        $isOddRasi = ($d1Rasi % 2 === 1);

        // --- D2: HORA (Page 57) ---
        // Odd Rasi: 0°-15° Sun (Leo = 5); 15°-30° Moon (Cancer = 4)
        // Even Rasi: 0°-15° Moon (Cancer = 4); 15°-30° Sun (Leo = 5)
        if ($isOddRasi) {
            $d2Hora = ($degInRasi < 15.0) ? 5 : 4;
        } else {
            $d2Hora = ($degInRasi < 15.0) ? 4 : 5;
        }

        // --- D3: DREKKANA (Page 58) ---
        // 0°-10°: Same Rasi (R)
        // 10°-20°: 5th from R
        // 20°-30°: 9th from R
        if ($degInRasi < 10.0) {
            $d3Drekkana = $d1Rasi;
        } elseif ($degInRasi < 20.0) {
            $d3Drekkana = (($d1Rasi - 1 + 4) % 12) + 1;
        } else {
            $d3Drekkana = (($d1Rasi - 1 + 8) % 12) + 1;
        }

        // --- D9: NAVAMSHA (Pages 58-59) ---
        // 9 equal parts of 3°20' (3.3333333°)
        $navPart = (int)floor($degInRasi / (30.0 / 9.0)); // 0..8
        if ($navPart > 8) {
            $navPart = 8;
        }

        // Fiery signs (1, 5, 9): start from Aries (1)
        // Earthy signs (2, 6, 10): start from Capricorn (10)
        // Airy signs (3, 7, 11): start from Libra (7)
        // Watery signs (4, 8, 12): start from Cancer (4)
        $fierySigns = [1, 5, 9];
        $earthySigns = [2, 6, 10];
        $airySigns = [3, 7, 11];

        if (in_array($d1Rasi, $fierySigns, true)) {
            $d9Start = 1;
        } elseif (in_array($d1Rasi, $earthySigns, true)) {
            $d9Start = 10;
        } elseif (in_array($d1Rasi, $airySigns, true)) {
            $d9Start = 7;
        } else {
            $d9Start = 4;
        }

        $d9Navamsha = (($d9Start - 1 + $navPart) % 12) + 1;
        $isVargottama = ($d1Rasi === $d9Navamsha);

        // --- D12: DVADASHAMSHA (Page 59) ---
        // 12 equal parts of 2°30' (2.5°), starting from same Rasi
        $d12Part = (int)floor($degInRasi / 2.5); // 0..11
        if ($d12Part > 11) {
            $d12Part = 11;
        }
        $d12Dvadashamsha = (($d1Rasi - 1 + $d12Part) % 12) + 1;

        // --- D30: TRIMSHAMSHA (Page 60) ---
        // Unequal divisions:
        // Odd signs:
        //   0°-5°: Mars (Aries = 1)
        //   5°-10°: Saturn (Aquarius = 11)
        //   10°-18°: Jupiter (Sagittarius = 9)
        //   18°-25°: Mercury (Gemini = 3)
        //   25°-30°: Venus (Libra = 7)
        // Even signs:
        //   0°-5°: Venus (Taurus = 2)
        //   5°-12°: Mercury (Virgo = 6)
        //   12°-20°: Jupiter (Pisces = 12)
        //   20°-25°: Saturn (Capricorn = 10)
        //   25°-30°: Mars (Scorpio = 8)
        if ($isOddRasi) {
            if ($degInRasi < 5.0) {
                $d30Trimshamsha = 1;
            } elseif ($degInRasi < 10.0) {
                $d30Trimshamsha = 11;
            } elseif ($degInRasi < 18.0) {
                $d30Trimshamsha = 9;
            } elseif ($degInRasi < 25.0) {
                $d30Trimshamsha = 3;
            } else {
                $d30Trimshamsha = 7;
            }
        } else {
            if ($degInRasi < 5.0) {
                $d30Trimshamsha = 2;
            } elseif ($degInRasi < 12.0) {
                $d30Trimshamsha = 6;
            } elseif ($degInRasi < 20.0) {
                $d30Trimshamsha = 12;
            } elseif ($degInRasi < 25.0) {
                $d30Trimshamsha = 10;
            } else {
                $d30Trimshamsha = 8;
            }
        }

        return [
            'd1_rasi' => $d1Rasi,
            'deg_in_rasi' => round($degInRasi, 4),
            'd2_hora' => $d2Hora,
            'd3_drekkana' => $d3Drekkana,
            'd9_navamsha' => $d9Navamsha,
            'is_vargottama' => $isVargottama,
            'd12_dvadashamsha' => $d12Dvadashamsha,
            'd30_trimshamsha' => $d30Trimshamsha,
        ];
    }

    /**
     * Compute Shadvargas for all planets + Lagna + Gulika.
     *
     * @param array $allBodies Keyed array of bodies with 'longitude'
     * @return array
     */
    public function computeAllShadvargas(array $allBodies): array
    {
        $vargas = [];
        foreach ($allBodies as $key => $body) {
            $long = (float)($body['longitude'] ?? 0.0);
            $vargas[$key] = array_merge(
                ['key' => $key, 'name' => $body['name_en'] ?? $key],
                $this->computeShadvargaForDegree($long)
            );
        }

        return $vargas;
    }
}

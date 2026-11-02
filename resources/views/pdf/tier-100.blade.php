<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Covilakam Astrology - Certified DOB Profile</title>
    <style>
        @page {
            header: page-header;
            footer: page-footer;
            margin-top: 28mm;
            margin-bottom: 22mm;
            margin-left: 15mm;
            margin-right: 15mm;
        }
        body {
            font-family: 'dejavusans', sans-serif;
            font-size: 10pt;
            color: #1a1a1a;
            line-height: 1.5;
        }
        .header-table {
            width: 100%;
            border-bottom: 2px solid #b45309;
            padding-bottom: 4px;
        }
        .footer-table {
            width: 100%;
            border-top: 1px solid #d97706;
            padding-top: 4px;
            font-size: 8pt;
            color: #555555;
        }
        .cover-box {
            border: 3px double #b45309;
            padding: 20px;
            text-align: center;
            background-color: #fefce8;
            margin-bottom: 20px;
        }
        .gold-title {
            color: #78350f;
            font-size: 18pt;
            font-weight: bold;
            margin: 0;
            text-transform: uppercase;
            letter-spacing: 1px;
        }
        .gold-subtitle {
            color: #b45309;
            font-size: 11pt;
            font-weight: bold;
            margin-top: 4px;
        }
        .badge {
            background-color: #f59e0b;
            color: #ffffff;
            font-weight: bold;
            padding: 3px 8px;
            border-radius: 4px;
            font-size: 8pt;
            display: inline-block;
        }
        .section-title {
            color: #78350f;
            font-size: 12pt;
            font-weight: bold;
            border-bottom: 1.5px solid #d97706;
            padding-bottom: 3px;
            margin-top: 16px;
            margin-bottom: 8px;
        }
        .table-data {
            width: 100%;
            border-collapse: collapse;
            margin-top: 8px;
            margin-bottom: 12px;
        }
        .table-data th {
            background-color: #fef3c7;
            color: #78350f;
            border: 1px solid #d97706;
            padding: 6px;
            font-size: 9pt;
            text-align: left;
        }
        .table-data td {
            border: 1px solid #e5e7eb;
            padding: 6px;
            font-size: 9pt;
        }
        .chart-grid {
            width: 100%;
            max-width: 440px;
            margin: 0 auto;
            border-collapse: collapse;
        }
        .chart-cell {
            width: 25%;
            height: 65px;
            border: 1px solid #78350f;
            vertical-align: top;
            padding: 4px;
            font-size: 8pt;
            background-color: #ffffff;
        }
        .chart-center {
            background-color: #fef3c7;
            text-align: center;
            vertical-align: middle;
            font-weight: bold;
            color: #78350f;
            border: 2px solid #b45309;
        }
        .lagna-cell {
            background-color: #fef9c3;
            border: 2px solid #f59e0b;
        }
        .highlight-box {
            background-color: #fefce8;
            border-left: 4px solid #b45309;
            padding: 10px;
            margin-top: 10px;
            margin-bottom: 10px;
        }
        .cta-box {
            background-color: #ecfdf5;
            border: 2px solid #10b981;
            padding: 14px;
            text-align: center;
            margin-top: 20px;
            border-radius: 8px;
        }
        .page-break {
            page-break-after: always;
        }
    </style>
</head>
<body>

    <!-- REUSABLE HEADER -->
    <htmlpageheader name="page-header">
        <table class="header-table">
            <tr>
                <td style="width: 70%;">
                    <strong style="color: #78350f; font-size: 11pt;">COVILAKAM ASTROLOGY</strong><br>
                    <span style="font-size: 8.5pt; color: #92400e;">Dr. E. K. Raja Varma (Vidya Vachaspathi in Vedic Astrology) | Ph.D. | IVAF #11009</span>
                </td>
                <td style="width: 30%; text-align: right;">
                    <span class="badge">Certified DOB Profile</span>
                </td>
            </tr>
        </table>
    </htmlpageheader>

    <!-- REUSABLE FOOTER -->
    <htmlpagefooter name="page-footer">
        <table class="footer-table">
            <tr>
                <td style="width: 70%;">
                    www.covilakamastrology.com | WhatsApp: +91 7907052160 | GPay: +91 94473 27450<br>
                    Chitrapaksha Ayanamsa (Lahiri) &bull; Vedanga Jyothisham Mathematical System
                </td>
                <td style="width: 30%; text-align: right;">
                    Page {PAGENO} of {nbpg}
                </td>
            </tr>
        </table>
    </htmlpagefooter>

    <!-- ================= PAGE 1: COVER & PANCHANGA ================= -->
    <div class="cover-box">
        <h1 class="gold-title">COVILAKAM ASTROLOGY</h1>
        <div class="gold-subtitle">CERTIFIED VEDIC BIRTH PROFILE &amp; HOROSCOPE PORTFOLIO</div>
        <p style="margin-top: 8px; font-size: 9pt; color: #555;">
            Authored &amp; Certified by <strong>Dr. E. K. Raja Varma</strong> (Vidya Vachaspathi in Vedic Astrology, Gold Medalist &amp; Ph.D.)<br>
            Lifetime Member #11009, International Vedic Astrology Federation (IVAF)
        </p>
    </div>

    <div class="section-title">1. Jathaka Birth Particulars &amp; Panchanga</div>
    <table class="table-data">
        <tr>
            <th style="width: 25%;">Full Name</th>
            <td style="width: 25%; font-weight: bold;">{{ $reading->full_name }}</td>
            <th style="width: 25%;">Gender</th>
            <td style="width: 25%;">{{ ucfirst($reading->gender) }} ({{ $reading->gender === 'female' ? 'Left Hand' : 'Right Hand' }})</td>
        </tr>
        <tr>
            <th>Date of Birth</th>
            <td><strong>{{ \Carbon\Carbon::parse($reading->dob)->format('d-m-Y') }}</strong> (DD-MM-YYYY)</td>
            <th>Birth Time</th>
            <td>{{ \Carbon\Carbon::parse($reading->birth_time)->format('h:i A') }} {{ $reading->is_approximate_time ? '(Approximate)' : '(Exact)' }}</td>
        </tr>
        <tr>
            <th>Birth Place</th>
            <td>{{ $reading->birth_place }}</td>
            <th>Coordinates</th>
            <td>{{ round($reading->latitude, 2) }}°N, {{ round($reading->longitude, 2) }}°E</td>
        </tr>
        <tr>
            <th>Chitrapaksha Ayanamsa</th>
            <td><strong>{{ $chartData['ayanamsa_deg'] ?? '23.85' }}°</strong></td>
            <th>Vedic Weekday (Vara)</th>
            <td>{{ $chartData['vara']['name_en'] ?? 'Auspicious' }}</td>
        </tr>
        <tr>
            <th>Lagna (Ascendant)</th>
            <td><strong>{{ $chartData['lagna']['name_en'] ?? '' }}</strong> ({{ $chartData['lagna']['name_ml'] ?? '' }})</td>
            <th>Janma Rasi (Moon)</th>
            <td><strong>{{ $chartData['moon_sign']['name_en'] ?? '' }}</strong> ({{ $chartData['moon_sign']['name_ml'] ?? '' }})</td>
        </tr>
        <tr>
            <th>Janma Nakshatra</th>
            <td><strong>{{ $chartData['nakshatra']['name_en'] ?? '' }}</strong> (Pada {{ $chartData['nakshatra']['pada'] ?? '1' }})</td>
            <th>Surya Rasi (Sun)</th>
            <td><strong>{{ $chartData['solar_sign']['name_en'] ?? '' }}</strong> ({{ $chartData['solar_sign']['name_ml'] ?? '' }})</td>
        </tr>
        <tr>
            <th>Birth Tithi</th>
            <td>{{ $chartData['tithi']['name_en'] ?? '' }} ({{ $chartData['tithi']['name_ml'] ?? '' }})</td>
            <th>Nityayoga &amp; Karana</th>
            <td>{{ $chartData['nityayoga']['name_en'] ?? '' }} / {{ $chartData['karana']['name_en'] ?? '' }}</td>
        </tr>
        <tr>
            <th>Mulank (Birth No.)</th>
            <td><strong>{{ $chartData['mulank'] ?? '' }}</strong></td>
            <th>Bhagyank (Destiny No.)</th>
            <td><strong>{{ $chartData['bhagyank'] ?? '' }}</strong></td>
        </tr>
    </table>

    <div class="highlight-box">
        <strong>Nakshatra Archetype &amp; Divine Significations:</strong><br>
        &bull; <strong>Presiding Deity:</strong> {{ $chartData['nakshatra']['deity'] ?? 'Divine Grace' }}<br>
        &bull; <strong>Symbol:</strong> {{ $chartData['nakshatra']['symbol'] ?? 'Cosmic Light' }}<br>
        &bull; <strong>Archetype Overview:</strong> {{ $chartData['nakshatra']['archetype_en'] ?? 'Noble, intuitive, and courageous.' }}
    </div>

    <div class="page-break"></div>

    <!-- ================= PAGE 2: SOUTH INDIAN RASI CHAKRA & DASHA ================= -->
    <div class="section-title">2. South Indian Sidereal Rasi Chakra (D1)</div>
    <p style="font-size: 8.5pt; color: #555; margin-top: 0;">
        Constructed strictly according to the fixed-Rasi South Indian format using Chitrapaksha (Lahiri) Ayanamsa.
    </p>

    @php
        $rasiNames = [
            12 => 'Pisces / മീനം', 1 => 'Aries / മേടം', 2 => 'Taurus / ഇടവം', 3 => 'Gemini / മിഥുനം',
            11 => 'Aquarius / കുംഭം', 4 => 'Cancer / കർക്കി',
            10 => 'Capricorn / മകരം', 5 => 'Leo / ചിങ്ങം',
            9 => 'Sagittarius / ധനു', 8 => 'Scorpio / വൃശ്ചികം', 7 => 'Libra / തുലാം', 6 => 'Virgo / കന്നി'
        ];
        $lagnaRasiIdx = (int)($chartData['lagna']['rasi_index'] ?? 1);
    @endphp

    <table class="chart-grid">
        <tr>
            <td class="chart-cell {{ $lagnaRasiIdx === 12 ? 'lagna-cell' : '' }}">
                <strong>{{ $rasiNames[12] }}</strong><br>
                @foreach($chartData['chart_grid_d1'][12] ?? [] as $pl)
                    <span style="color:#b45309; font-weight:bold;">{{ $pl['label'] }}</span><br>
                @endforeach
            </td>
            <td class="chart-cell {{ $lagnaRasiIdx === 1 ? 'lagna-cell' : '' }}">
                <strong>{{ $rasiNames[1] }}</strong><br>
                @foreach($chartData['chart_grid_d1'][1] ?? [] as $pl)
                    <span style="color:#b45309; font-weight:bold;">{{ $pl['label'] }}</span><br>
                @endforeach
            </td>
            <td class="chart-cell {{ $lagnaRasiIdx === 2 ? 'lagna-cell' : '' }}">
                <strong>{{ $rasiNames[2] }}</strong><br>
                @foreach($chartData['chart_grid_d1'][2] ?? [] as $pl)
                    <span style="color:#b45309; font-weight:bold;">{{ $pl['label'] }}</span><br>
                @endforeach
            </td>
            <td class="chart-cell {{ $lagnaRasiIdx === 3 ? 'lagna-cell' : '' }}">
                <strong>{{ $rasiNames[3] }}</strong><br>
                @foreach($chartData['chart_grid_d1'][3] ?? [] as $pl)
                    <span style="color:#b45309; font-weight:bold;">{{ $pl['label'] }}</span><br>
                @endforeach
            </td>
        </tr>
        <tr>
            <td class="chart-cell {{ $lagnaRasiIdx === 11 ? 'lagna-cell' : '' }}">
                <strong>{{ $rasiNames[11] }}</strong><br>
                @foreach($chartData['chart_grid_d1'][11] ?? [] as $pl)
                    <span style="color:#b45309; font-weight:bold;">{{ $pl['label'] }}</span><br>
                @endforeach
            </td>
            <td class="chart-cell chart-center" colspan="2" rowspan="2">
                <span style="font-size: 13pt; color: #78350f;">രാശി ചക്രം (D1)</span><br>
                <span style="font-size: 9pt; color: #92400e;">RASI KUNDALI</span><br>
                <span style="font-size: 8pt; color: #555;">{{ $reading->full_name }}</span><br>
                <span style="font-size: 8pt; color: #b45309;">Lagna: {{ $chartData['lagna']['name_en'] ?? '' }}</span>
            </td>
            <td class="chart-cell {{ $lagnaRasiIdx === 4 ? 'lagna-cell' : '' }}">
                <strong>{{ $rasiNames[4] }}</strong><br>
                @foreach($chartData['chart_grid_d1'][4] ?? [] as $pl)
                    <span style="color:#b45309; font-weight:bold;">{{ $pl['label'] }}</span><br>
                @endforeach
            </td>
        </tr>
        <tr>
            <td class="chart-cell {{ $lagnaRasiIdx === 10 ? 'lagna-cell' : '' }}">
                <strong>{{ $rasiNames[10] }}</strong><br>
                @foreach($chartData['chart_grid_d1'][10] ?? [] as $pl)
                    <span style="color:#b45309; font-weight:bold;">{{ $pl['label'] }}</span><br>
                @endforeach
            </td>
            <td class="chart-cell {{ $lagnaRasiIdx === 5 ? 'lagna-cell' : '' }}">
                <strong>{{ $rasiNames[5] }}</strong><br>
                @foreach($chartData['chart_grid_d1'][5] ?? [] as $pl)
                    <span style="color:#b45309; font-weight:bold;">{{ $pl['label'] }}</span><br>
                @endforeach
            </td>
        </tr>
        <tr>
            <td class="chart-cell {{ $lagnaRasiIdx === 9 ? 'lagna-cell' : '' }}">
                <strong>{{ $rasiNames[9] }}</strong><br>
                @foreach($chartData['chart_grid_d1'][9] ?? [] as $pl)
                    <span style="color:#b45309; font-weight:bold;">{{ $pl['label'] }}</span><br>
                @endforeach
            </td>
            <td class="chart-cell {{ $lagnaRasiIdx === 8 ? 'lagna-cell' : '' }}">
                <strong>{{ $rasiNames[8] }}</strong><br>
                @foreach($chartData['chart_grid_d1'][8] ?? [] as $pl)
                    <span style="color:#b45309; font-weight:bold;">{{ $pl['label'] }}</span><br>
                @endforeach
            </td>
            <td class="chart-cell {{ $lagnaRasiIdx === 7 ? 'lagna-cell' : '' }}">
                <strong>{{ $rasiNames[7] }}</strong><br>
                @foreach($chartData['chart_grid_d1'][7] ?? [] as $pl)
                    <span style="color:#b45309; font-weight:bold;">{{ $pl['label'] }}</span><br>
                @endforeach
            </td>
            <td class="chart-cell {{ $lagnaRasiIdx === 6 ? 'lagna-cell' : '' }}">
                <strong>{{ $rasiNames[6] }}</strong><br>
                @foreach($chartData['chart_grid_d1'][6] ?? [] as $pl)
                    <span style="color:#b45309; font-weight:bold;">{{ $pl['label'] }}</span><br>
                @endforeach
            </td>
        </tr>
    </table>

    <div class="section-title">3. Vimshottari Dasha Balance &amp; Current Timeline</div>
    <div class="highlight-box">
        <strong>Opening Balance of Dasha at Birth (Garbhashishta Dasha):</strong><br>
        {{ $chartData['garbhashishta']['summary_en'] ?? '' }}<br>
        <em style="color:#78350f;">{{ $chartData['garbhashishta']['summary_ml'] ?? '' }}</em>
    </div>

    <table class="table-data">
        <tr>
            <th style="width: 35%;">Active Mahadasha</th>
            <td><strong>{{ $chartData['active_dasha']['mahadasha'] ?? '' }}</strong> ({{ $chartData['active_dasha']['mahadasha_ml'] ?? '' }})</td>
        </tr>
        <tr>
            <th>Active Apahara (Antardasha)</th>
            <td><strong>{{ $chartData['active_dasha']['apahara'] ?? '' }}</strong> ({{ $chartData['active_dasha']['apahara_ml'] ?? '' }})</td>
        </tr>
        <tr>
            <th>Active Period Range</th>
            <td>{{ $chartData['active_dasha']['start_date'] ?? '' }} to {{ $chartData['active_dasha']['end_date'] ?? '' }}</td>
        </tr>
    </table>

    <div class="page-break"></div>

    <!-- ================= PAGE 3: PERSONALITY & BHAVAS ================= -->
    <div class="section-title">4. Core Personality &amp; 1st House (Lagna) Analysis</div>
    <p>
        Governed by <strong>{{ $chartData['lagna']['name_en'] ?? '' }}</strong> Ascendant and Janma Nakshatra <strong>{{ $chartData['nakshatra']['name_en'] ?? '' }}</strong>, you possess an innate vitality, noble bearing, and determined will. Your soul purpose is driven by ethical perseverance and independent initiative.
    </p>

    <div class="section-title">5. 2nd House: Wealth, Speech &amp; Family Heritage</div>
    <p>
        The 2nd Bhava signifies accumulated assets, eloquence, and culinary habits.
        @if(!empty($chartData['vedanga_predictions']['bhava_analysis']['wealth_sources']))
            <br><strong>Key Sources of Wealth Growth:</strong>
            <ul>
                @foreach($chartData['vedanga_predictions']['bhava_analysis']['wealth_sources'] as $ws)
                    <li>{{ $ws }}</li>
                @endforeach
            </ul>
        @else
            Your financial path thrives through disciplined investment, professional self-reliance, and diplomatic communication.
        @endif
    </p>

    <div class="section-title">6. 10th House: Karma &amp; Professional Prominence</div>
    <p>
        The 10th house governs public reputation, career authority, and executive leadership. Your professional horizon favors leadership responsibilities where independent planning and visionary execution are recognized.
    </p>

    <div class="page-break"></div>

    <!-- ================= PAGE 4: TRANSITS (GOCHARA) ================= -->
    <div class="section-title">7. Current Planetary Transits (Gocharaphala)</div>
    <p style="font-size: 8.5pt; color: #555;">
        Calculated from natal Chandra Rasi ({{ $chartData['moon_sign']['name_en'] ?? '' }}) per Chapter 14 of *Vedanga Jyothisham*.
    </p>

    <table class="table-data">
        <tr>
            <th>Planet</th>
            <th>House from Moon</th>
            <th>Transit Status</th>
        </tr>
        @foreach($chartData['vedanga_predictions']['gocharaphala']['planets'] ?? [] as $gP)
            <tr>
                <td><strong>{{ $gP['name_en'] }}</strong> ({{ $gP['name_ml'] }})</td>
                <td>{{ $gP['house_from_moon'] }}th House</td>
                <td style="color: {{ $gP['effective_favorable'] ? '#059669' : '#d97706' }}; font-weight: bold;">
                    {{ $gP['status_text'] }}
                </td>
            </tr>
        @endforeach
    </table>

    <div class="highlight-box">
        <strong>Saturn Transit Alert (Shani Gochara):</strong><br>
        &bull; <strong>7½ Shani (Sade Sati):</strong> {{ ($chartData['vedanga_predictions']['gocharaphala']['saturn_special']['is_ezhara_shani'] ?? false) ? 'Active (' . $chartData['vedanga_predictions']['gocharaphala']['saturn_special']['phase'] . ')' : 'Not Active' }}<br>
        &bull; <strong>Kantaka Shani:</strong> {{ ($chartData['vedanga_predictions']['gocharaphala']['saturn_special']['is_kantaka_shani'] ?? false) ? 'Active (' . $chartData['vedanga_predictions']['gocharaphala']['saturn_special']['kantaka_house'] . 'th House)' : 'None' }}<br>
        &bull; <strong>Ashtama Shani:</strong> {{ ($chartData['vedanga_predictions']['gocharaphala']['saturn_special']['is_ashtama_shani'] ?? false) ? 'Active' : 'None' }}<br>
        &bull; <strong>Shasta / Ayyappa Remedy:</strong> {{ $chartData['vedanga_predictions']['gocharaphala']['saturn_special']['remedy_en'] ?? '' }}
    </div>

    <div class="page-break"></div>

    <!-- ================= PAGE 5: GEMSTONE & REMEDIES ================= -->
    <div class="section-title">8. Scientific Gemstone Prescription &amp; Wearing Rules</div>
    <p>
        Prescribed according to Trine Lordship (Houses 1, 5, 9) and Gender rules from Chapter 16 of *Vedanga Jyothisham*:
    </p>

    <table class="table-data">
        <tr>
            <th style="width: 35%;">Primary Ratna (Gemstone)</th>
            <td><strong style="color: #b45309; font-size: 11pt;">{{ $chartData['gemstone_en'] ?? '' }}</strong> ({{ $chartData['gemstone_ml'] ?? '' }})</td>
        </tr>
        <tr>
            <th>Uparatna (Alternative)</th>
            <td>{{ $chartData['gemstone']['uparatna_en'] ?? 'Natural Semi-precious Stone' }}</td>
        </tr>
        <tr>
            <th>Recommended Weight</th>
            <td>{{ $chartData['gemstone']['carat_weight'] ?? '3 to 5 Carats' }}</td>
        </tr>
        <tr>
            <th>Prescribed Metal</th>
            <td>{{ $chartData['gemstone']['metal_en'] ?? 'Gold or Silver' }}</td>
        </tr>
        <tr>
            <th>Hand &amp; Finger Rule</th>
            <td><strong>{{ $chartData['gemstone']['hand_en'] ?? 'Right Hand' }}</strong> &mdash; {{ $chartData['gemstone']['finger_en'] ?? 'Ring finger' }}</td>
        </tr>
        <tr>
            <th>Consecration &amp; Hora</th>
            <td>{{ $chartData['wearing_rule']['en'] ?? '' }}</td>
        </tr>
    </table>

    <div class="cta-box">
        <h3 style="color: #065f46; margin: 0; font-size: 13pt;">Direct Consultation with Dr. E. K. Raja Varma</h3>
        <p style="font-size: 9pt; color: #047857; margin: 4px 0 10px 0;">
            Vidya Vachaspathi in Vedic Astrology &bull; Gold Medalist &bull; Ph.D. (Online Astro Counselling)
        </p>
        <p style="font-size: 9.5pt; color: #1f2937;">
            For in-depth horoscope analysis, marital matchmaking, life pariharams, and customized gem guidance:
        </p>
        <div style="font-size: 12pt; font-weight: bold; color: #065f46; margin-top: 6px;">
            WhatsApp: +91 7907052160 &bull; Phone / GPay: +91 94473 27450
        </div>
        <p style="font-size: 8pt; color: #6b7280; margin-top: 4px;">
            Reading Reference UUID: {{ $reading->uuid }} &bull; www.covilakamastrology.com
        </p>
    </div>

</body>
</html>


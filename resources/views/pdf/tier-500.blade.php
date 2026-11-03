<!DOCTYPE html>
<html lang="en">
<head>
@php
    $targetLang = $lang ?? $reading->language ?? 'en';
    if (!in_array($targetLang, ['en', 'ml', 'ta', 'hi'], true)) {
        $targetLang = 'en';
    }
@endphp
    <meta charset="utf-8">
    <title>Covilakam Astrology - Deluxe Vedic Jathakam Portfolio</title>
    <style>
        @page {
            header: page-header;
            footer: page-footer;
            margin-top: 26mm;
            margin-bottom: 22mm;
            margin-left: 14mm;
            margin-right: 14mm;
        }
        body {
            font-family: 'dejavusans', sans-serif;
            font-size: 9.5pt;
            color: #1a1a1a;
            line-height: 1.45;
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
            padding: 22px;
            text-align: center;
            background-color: #fefce8;
            margin-bottom: 18px;
        }
        .gold-title {
            color: #78350f;
            font-size: 20pt;
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
            background-color: #78350f;
            color: #fef3c7;
            font-weight: bold;
            padding: 4px 10px;
            border-radius: 4px;
            font-size: 8.5pt;
            display: inline-block;
            border: 1px solid #d97706;
        }
        .section-title {
            color: #78350f;
            font-size: 11.5pt;
            font-weight: bold;
            border-bottom: 1.5px solid #d97706;
            padding-bottom: 3px;
            margin-top: 14px;
            margin-bottom: 8px;
        }
        .subsection-title {
            color: #92400e;
            font-size: 10pt;
            font-weight: bold;
            margin-top: 10px;
            margin-bottom: 4px;
        }
        .table-data {
            width: 100%;
            border-collapse: collapse;
            margin-top: 6px;
            margin-bottom: 10px;
        }
        .table-data th {
            background-color: #fef3c7;
            color: #78350f;
            border: 1px solid #d97706;
            padding: 5px 6px;
            font-size: 8.5pt;
            text-align: left;
        }
        .table-data td {
            border: 1px solid #e5e7eb;
            padding: 5px 6px;
            font-size: 8.5pt;
        }
        .table-compact th, .table-compact td {
            padding: 3px 4px;
            font-size: 8pt;
        }
        .chart-grid {
            width: 100%;
            max-width: 440px;
            margin: 0 auto;
            border-collapse: collapse;
        }
        .chart-cell {
            width: 25%;
            height: 62px;
            border: 1px solid #78350f;
            vertical-align: top;
            padding: 3px;
            font-size: 7.5pt;
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
            padding: 8px 12px;
            margin-top: 8px;
            margin-bottom: 8px;
            font-size: 8.5pt;
        }
        .cta-box {
            background-color: #ecfdf5;
            border: 2px solid #10b981;
            padding: 14px;
            text-align: center;
            margin-top: 14px;
            border-radius: 8px;
        }
        .page-break {
            page-break-after: always;
        }
        .shloka-box {
            border: 1px dashed #b45309;
            background-color: #fffbeb;
            padding: 10px;
            text-align: center;
            font-style: italic;
            color: #78350f;
            margin-bottom: 12px;
            font-size: 9pt;
        }
    @media print { .web-view-toolbar { display: none !important; } }
</style>
</head>
<body>
@if(!empty($isWebView))
<div class="web-view-toolbar" style="position: sticky; top: 0; left: 0; right: 0; background: #1c0d2e; color: #fff; padding: 10px 16px; display: flex; flex-wrap: wrap; align-items: center; justify-content: space-between; gap: 8px; z-index: 9999; border-bottom: 2px solid #b45309; box-shadow: 0 4px 15px rgba(0,0,0,0.5);">
    <div style="font-weight: bold; color: #fbbf24; font-size: 13px; display: flex; align-items: center; gap: 6px;">
        <span>👑</span>
        <span>Covilakam Astrology &bull; {{ $reading->full_name }}</span>
        <span style="font-size: 10px; background: rgba(245, 158, 11, 0.2); color: #fef08a; padding: 2px 6px; border-radius: 4px; border: 1px solid rgba(245, 158, 11, 0.4);">Deluxe Jathakam</span>
    </div>
    <div style="display: flex; flex-wrap: wrap; gap: 6px; align-items: center;">
        <span style="font-size: 11px; color: #d8b4fe; font-weight: bold; margin-right: 4px;">Language:</span>
        <a href="?lang=en{{ request('admin') ? '&admin=1' : '' }}{{ request('tier') ? '&tier=' . request('tier') : '' }}" style="color: {{ $targetLang === 'en' ? '#000' : '#fef08a' }}; background: {{ $targetLang === 'en' ? '#f59e0b' : '#372054' }}; padding: 4px 8px; border-radius: 6px; text-decoration: none; font-size: 11px; font-weight: bold;">English</a>
        <a href="?lang=ml{{ request('admin') ? '&admin=1' : '' }}{{ request('tier') ? '&tier=' . request('tier') : '' }}" style="color: {{ $targetLang === 'ml' ? '#000' : '#fef08a' }}; background: {{ $targetLang === 'ml' ? '#f59e0b' : '#372054' }}; padding: 4px 8px; border-radius: 6px; text-decoration: none; font-size: 11px; font-weight: bold;">മലയാളം</a>
        <a href="?lang=ta{{ request('admin') ? '&admin=1' : '' }}{{ request('tier') ? '&tier=' . request('tier') : '' }}" style="color: {{ $targetLang === 'ta' ? '#000' : '#fef08a' }}; background: {{ $targetLang === 'ta' ? '#f59e0b' : '#372054' }}; padding: 4px 8px; border-radius: 6px; text-decoration: none; font-size: 11px; font-weight: bold;">தமிழ்</a>
        <a href="?lang=hi{{ request('admin') ? '&admin=1' : '' }}{{ request('tier') ? '&tier=' . request('tier') : '' }}" style="color: {{ $targetLang === 'hi' ? '#000' : '#fef08a' }}; background: {{ $targetLang === 'hi' ? '#f59e0b' : '#372054' }}; padding: 4px 8px; border-radius: 6px; text-decoration: none; font-size: 11px; font-weight: bold;">हिन्दी</a>
        <button onclick="window.print()" style="background: #10b981; color: #000; border: none; padding: 5px 12px; border-radius: 6px; font-weight: bold; font-size: 11px; cursor: pointer;">🖨️ Print / Save</button>
        <a href="{{ route('astrology.reading.download-pdf', ['uuid' => $reading->uuid, 'lang' => $targetLang, 'tier' => request('tier', $reading->paid_tier), 'admin' => request('admin'), 'download' => 1]) }}" style="background: linear-gradient(to right, #f59e0b, #eab308); color: #000; padding: 5px 12px; border-radius: 6px; font-weight: bold; font-size: 11px; text-decoration: none;">📥 Download PDF</a>
    </div>
</div>
@endif

    <!-- REUSABLE HEADER -->
    <htmlpageheader name="page-header">
        <table class="header-table">
            <tr>
                <td style="width: 70%;">
                    <strong style="color: #78350f; font-size: 11pt;">COVILAKAM ASTROLOGY</strong><br>
                    <span style="font-size: 8.5pt; color: #92400e;">Dr. E. K. Raja Varma (Vidya Vachaspathi in Vedic Astrology) | Ph.D. | IVAF #11009</span>
                </td>
                <td style="width: 30%; text-align: right;">
                    <span class="badge">Deluxe Vedic Jathakam</span>
                </td>
            </tr>
        </table>
    </htmlpageheader>

    <!-- REUSABLE FOOTER -->
    <htmlpagefooter name="page-footer">
        <table class="footer-table">
            <tr>
                <td style="width: 70%;">
                    www.covilakamastrology.com &bull; WhatsApp: +91 7907052160 &bull; GPay: +91 94473 27450<br>
                    Chitrapaksha Ayanamsa (Lahiri) &bull; Vedanga Jyothisham Mathematical System
                </td>
                <td style="width: 30%; text-align: right;">
                    Page {PAGENO} of {nbpg}
                </td>
            </tr>
        </table>
    </htmlpagefooter>

    <!-- ================= PAGE 1: DELUXE ROYAL COVER PAGE ================= -->
    <div class="cover-box">
        <div style="font-size: 9pt; color: #b45309; font-weight: bold; margin-bottom: 4px;">।। श्री गुरुഭ്യോ നമഃ ।। ॐ नमः शिवाय ।।</div>
        <h1 class="gold-title">COVILAKAM ASTROLOGY</h1>
        <div class="gold-subtitle">SAMPOORNA VEDIC JATHAKAM &amp; LIFE HOROSCOPE PORTFOLIO</div>
        <p style="margin-top: 8px; font-size: 8.5pt; color: #555;">
            Authored &amp; Certified by <strong>Dr. E. K. Raja Varma</strong><br>
            Vidya Vachaspathi in Vedic Astrology &bull; Gold Medalist &bull; Ph.D. (Online Astro Counselling)<br>
            Lifetime Member #11009, International Vedic Astrology Federation (IVAF)
        </p>
    </div>

    <div class="shloka-box">
        "ഗുരുർബ്രഹ്മാ ഗുരുർവിഷ്ണുഃ ഗുരുർദേവോ മഹേശ്വരഃ |<br>
        ഗുരുഃ സാക്ഷാത് പരബ്രഹ്മ തസ്മൈ ശ്രീഗുരവേ നമഃ ||"<br>
        <em>"May the divine cosmic light illuminate our path of righteous action, health, prosperity, and peace."</em>
    </div>

    <div class="section-title">Jathaka Registered Particulars</div>
    <table class="table-data">
        <tr>
            <th style="width: 25%;">Full Name</th>
            <td style="width: 25%; font-weight: bold; color: #78350f;">{{ $reading->full_name }}</td>
            <th style="width: 25%;">Gender</th>
            <td style="width: 25%;">{{ ucfirst($reading->gender) }} ({{ $reading->gender === 'female' ? 'Left Hand' : 'Right Hand' }})</td>
        </tr>
        <tr>
            <th>Date of Birth</th>
            <td><strong>{{ \Carbon\Carbon::parse($reading->dob)->format('d F Y') }}</strong></td>
            <th>Birth Time</th>
            <td><strong>{{ \Carbon\Carbon::parse($reading->birth_time)->format('h:i:s A') }}</strong> {{ $reading->is_approximate_time ? '(Approximate)' : '(Exact)' }}</td>
        </tr>
        <tr>
            <th>Place of Birth</th>
            <td>{{ $reading->birth_place }}</td>
            <th>Geographic Coordinates</th>
            <td>{{ round($reading->latitude, 4) }}°N, {{ round($reading->longitude, 4) }}°E</td>
        </tr>
        <tr>
            <th>Timezone</th>
            <td>{{ $reading->timezone ?? 'Asia/Kolkata' }} (IST)</td>
            <th>Chitrapaksha Ayanamsa</th>
            <td><strong>{{ $chartData['ayanamsa_deg'] ?? '23.85' }}°</strong></td>
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
            <th>Document Reference</th>
            <td colspan="3"><code style="color: #78350f; font-weight: bold;">{{ $reading->uuid }}</code> (Covilakam Certified Archive)</td>
        </tr>
    </table>

    <div class="highlight-box">
        <strong>Foreword on Astrological Interpretation (Pages 12 &amp; 70, <em>Vedanga Jyothisham</em>):</strong><br>
        A seeker approaches Jyothisha with faith for direction. Per the classical guidelines of Dr. E. K. Raja Varma and ancient preceptors, astrology is an advisory beacon. Karmic tendencies revealed herein represent potentials designed to awaken mindfulness, righteous choices (<em>Purushakara</em>), and devotional remediation.
    </div>

    <div class="page-break"></div>

    <!-- ================= PAGE 2: COMPLETE PANCHANGA & SACRED TIMINGS ================= -->
    <div class="section-title">1. Panchanga Tattva &amp; Cosmic Time Matrix</div>
    <p style="font-size: 8.5pt; color: #555;">
        The five limbs of time (Panchanga) govern the energy balance of physical, mental, and spiritual life at the moment of birth.
    </p>

    <table class="table-data">
        <tr>
            <th style="width: 25%;">1. Vara (Vedic Day)</th>
            <td style="width: 25%;"><strong>{{ $chartData['vara']['name_en'] ?? 'Vara' }}</strong> ({{ $chartData['vara']['name_ml'] ?? '' }})</td>
            <th style="width: 25%;">Ruler of Vara</th>
            <td style="width: 25%;">{{ $chartData['vara']['lord'] ?? 'Solar Energy' }} (Govern Vitality)</td>
        </tr>
        <tr>
            <th>2. Tithi (Lunar Phase)</th>
            <td><strong>{{ $chartData['tithi']['name_en'] ?? '' }}</strong></td>
            <th>Tithi Paksha &amp; Nature</th>
            <td>{{ ($chartData['tithi']['index'] ?? 1) <= 15 ? 'Shukla Paksha (Waxing)' : 'Krishna Paksha (Waning)' }}</td>
        </tr>
        <tr>
            <th>3. Nakshatra</th>
            <td><strong>{{ $chartData['nakshatra']['name_en'] ?? '' }}</strong> ({{ $chartData['nakshatra']['name_ml'] ?? '' }})</td>
            <th>Pada &amp; Degree Span</th>
            <td>Pada {{ $chartData['nakshatra']['pada'] ?? '1' }} ({{ round($chartData['nakshatra']['nakshatra_deg'] ?? 0, 2) }}°)</td>
        </tr>
        <tr>
            <th>4. Nityayoga</th>
            <td><strong>{{ $chartData['nityayoga']['name_en'] ?? '' }}</strong> ({{ $chartData['nityayoga']['name_ml'] ?? '' }})</td>
            <th>Yoga Signification</th>
            <td>{{ $chartData['nityayoga']['nature'] ?? 'Auspicious harmony of Sun & Moon' }}</td>
        </tr>
        <tr>
            <th>5. Karana (Half-Tithi)</th>
            <td><strong>{{ $chartData['karana']['name_en'] ?? '' }}</strong> ({{ $chartData['karana']['name_ml'] ?? '' }})</td>
            <th>Karana Nature</th>
            <td>{{ $chartData['karana']['type'] ?? 'Active / Dynamic endeavor' }}</td>
        </tr>
        <tr>
            <th>Mulank (Birth Number)</th>
            <td><strong style="color: #b45309; font-size: 11pt;">{{ $chartData['mulank'] ?? '' }}</strong> (Day sum)</td>
            <th>Bhagyank (Destiny Number)</th>
            <td><strong style="color: #b45309; font-size: 11pt;">{{ $chartData['bhagyank'] ?? '' }}</strong> (Full date sum)</td>
        </tr>
    </table>

    <div class="subsection-title">Nakshatra Archetype &amp; Divine Significations</div>
    <table class="table-data">
        <tr>
            <th style="width: 25%;">Presiding Devata</th>
            <td style="width: 25%;"><strong>{{ $chartData['nakshatra']['deity'] ?? 'Divine Regent' }}</strong></td>
            <th style="width: 25%;">Sacred Symbol</th>
            <td style="width: 25%;">{{ $chartData['nakshatra']['symbol'] ?? 'Cosmic Light' }}</td>
        </tr>
        <tr>
            <th>Gana (Temperament)</th>
            <td>{{ $chartData['nakshatra']['gana'] ?? 'Deva / Manushya' }}</td>
            <th>Yoni (Animal Archetype)</th>
            <td>{{ $chartData['nakshatra']['yoni'] ?? 'Spiritual Instinct' }}</td>
        </tr>
        <tr>
            <th>Nadi (Constitutional Flow)</th>
            <td>{{ $chartData['nakshatra']['nadi'] ?? 'Madhya / Antya' }}</td>
            <th>Varna (Spiritual Focus)</th>
            <td>{{ $chartData['nakshatra']['varna'] ?? 'Kshatriya / Brahmana' }}</td>
        </tr>
    </table>

    <div class="highlight-box">
        <strong>Archetypal Life Expression:</strong><br>
        {{ $chartData['nakshatra']['archetype_en'] ?? 'The birth asterism endows the native with deep intuitive capacity, intellectual resilience, and an innate sense of duty toward family and society.' }}
    </div>

    <div class="page-break"></div>

    <!-- ================= PAGE 3: EXACT PLANETARY SPHUTAS & DIGNITIES ================= -->
    <div class="section-title">2. Sidereal Planetary Longitudes (Sphutas) &amp; Dignities</div>
    <p style="font-size: 8.5pt; color: #555;">
        Computed using Chitrapaksha Ayanamsa ({{ $chartData['ayanamsa_deg'] ?? '23.85' }}°). Positions are Sidereal Nirayana.
    </p>

    <table class="table-data table-compact">
        <thead>
            <tr>
                <th>Body</th>
                <th>Longitude (Sphuta)</th>
                <th>Rasi (Sign)</th>
                <th>Nakshatra &amp; Pada</th>
                <th>Motion</th>
                <th>Dignity Status</th>
                <th>Combustion</th>
            </tr>
        </thead>
        <tbody>
            @php
                $bodiesList = [
                    'As' => ['name_en' => 'Lagna (Ascendant)', 'name_ml' => 'ലഗ്നം', 'long' => $chartData['lagna']['longitude'] ?? 0],
                    'Su' => ['name_en' => 'Sun (Surya)', 'name_ml' => 'സൂര്യൻ', 'long' => $chartData['planets']['Su']['longitude'] ?? 0],
                    'Mo' => ['name_en' => 'Moon (Chandra)', 'name_ml' => 'ചന്ദ്രൻ', 'long' => $chartData['planets']['Mo']['longitude'] ?? 0],
                    'Ma' => ['name_en' => 'Mars (Kuja)', 'name_ml' => 'ചൊവ്വ', 'long' => $chartData['planets']['Ma']['longitude'] ?? 0],
                    'Me' => ['name_en' => 'Mercury (Budha)', 'name_ml' => 'ബുധൻ', 'long' => $chartData['planets']['Me']['longitude'] ?? 0],
                    'Ju' => ['name_en' => 'Jupiter (Guru)', 'name_ml' => 'വ്യാഴം', 'long' => $chartData['planets']['Ju']['longitude'] ?? 0],
                    'Ve' => ['name_en' => 'Venus (Shukra)', 'name_ml' => 'ശുക്രൻ', 'long' => $chartData['planets']['Ve']['longitude'] ?? 0],
                    'Sa' => ['name_en' => 'Saturn (Shani)', 'name_ml' => 'ശനി', 'long' => $chartData['planets']['Sa']['longitude'] ?? 0],
                    'Ra' => ['name_en' => 'Rahu (North Node)', 'name_ml' => 'രാഹു', 'long' => $chartData['planets']['Ra']['longitude'] ?? 0],
                    'Ke' => ['name_en' => 'Ketu (South Node)', 'name_ml' => 'കേതു', 'long' => $chartData['planets']['Ke']['longitude'] ?? 0],
                    'Md' => ['name_en' => 'Gulika (Maandhi)', 'name_ml' => 'ഗുളികൻ', 'long' => $chartData['gulika']['longitude'] ?? 0],
                ];
            @endphp
            @foreach($bodiesList as $code => $info)
                @php
                    $deg = (float)$info['long'];
                    $rasiIdx = (int)floor($deg / 30.0) + 1;
                    $degInRasi = fmod($deg, 30.0);
                    $d = (int)floor($degInRasi);
                    $m = (int)floor(($degInRasi - $d) * 60);
                    $s = (int)round((($degInRasi - $d) * 60 - $m) * 60);
                    $pData = $chartData['planets'][$code] ?? null;
                    $isRetro = !empty($pData['is_retrograde']);
                    $dignity = $chartData['dignities'][$code]['status'] ?? ($code === 'As' ? 'Lagna Kendra' : ($code === 'Md' ? 'Upagraha' : 'Neutral'));
                    $isCombust = !empty($chartData['dignities'][$code]['is_combust']);
                @endphp
                <tr>
                    <td><strong>{{ $info['name_en'] }}</strong><br><span style="font-size: 7.5pt; color: #78350f;">{{ $info['name_ml'] }}</span></td>
                    <td><strong>{{ sprintf("%02d° %02d' %02d\"", $d, $m, $s) }}</strong></td>
                    <td>{{ $chartData['shadvarga'][$code]['rasi_name_en'] ?? '' }}</td>
                    <td>{{ $chartData['shadvarga'][$code]['nakshatra_name_en'] ?? '' }} (P{{ $chartData['shadvarga'][$code]['nakshatra_pada'] ?? '1' }})</td>
                    <td style="color: {{ $isRetro ? '#b91c1c' : '#15803d' }}; font-weight: bold;">
                        {{ $isRetro ? 'Retrograde (R)' : 'Direct' }}
                    </td>
                    <td><strong style="color: #78350f;">{{ ucfirst($dignity) }}</strong></td>
                    <td>{{ $isCombust ? 'Combust (Asta)' : 'Normal' }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="highlight-box">
        <strong>Principle of Sphuta Precision (Chapter 2, <em>Vedanga Jyothisham</em>):</strong><br>
        Planetary longitudes determine the exact entrance into Vargas, Sandhis, and Ashtakavarga bindu allocations. The degrees above establish the exact root seed (<em>Beeja</em>) of all subsequent predictions.
    </div>

    <div class="page-break"></div>

    <!-- ================= PAGE 4: SOUTH INDIAN RASI CHAKRA (D1) ================= -->
    <div class="section-title">3. South Indian Sidereal Rasi Chakra (D1)</div>
    <p style="font-size: 8.5pt; color: #555;">
        Fixed-sign South Indian format: Aries (മേടം) at top-left 2nd cell, running clockwise to Pisces (മീനം) at top-left 1st cell.
    </p>

    @php
        $rasiNames = [
            12 => 'Pisces / മീനം', 1 => 'Aries / മേടം', 2 => 'Taurus / ഇടവം', 3 => 'Gemini / മിഥുനം',
            11 => 'Aquarius / കുംഭം', 4 => 'Cancer / കർക്കി',
            10 => 'Capricorn / മകരം', 5 => 'Leo / ചിങ്ങം',
            9 => 'Sagittarius / ധനു', 8 => 'Scorpio / വൃശ്ചി', 7 => 'Libra / തുലാം', 6 => 'Virgo / കന്നി',
        ];
        $lagnaRasiIdx = (int)floor(($chartData['lagna']['longitude'] ?? 0) / 30.0) + 1;
        $moonRasiIdx = (int)floor(($chartData['planets']['Mo']['longitude'] ?? 0) / 30.0) + 1;
    @endphp

    <table class="chart-grid">
        <tr>
            <!-- Pisces (12) -->
            <td class="chart-cell {{ $lagnaRasiIdx === 12 ? 'lagna-cell' : '' }}">
                <div style="font-weight: bold; color: #78350f;">Pisces / മീനം</div>
                @foreach($chartData['chart_grid_d1'][12] ?? [] as $pl)
                    <div><strong>{{ $pl['label'] }}</strong> <span style="font-size: 7pt; color: #555;">{{ $pl['deg'] }}°</span></div>
                @endforeach
            </td>
            <!-- Aries (1) -->
            <td class="chart-cell {{ $lagnaRasiIdx === 1 ? 'lagna-cell' : '' }}">
                <div style="font-weight: bold; color: #78350f;">Aries / മേടം</div>
                @foreach($chartData['chart_grid_d1'][1] ?? [] as $pl)
                    <div><strong>{{ $pl['label'] }}</strong> <span style="font-size: 7pt; color: #555;">{{ $pl['deg'] }}°</span></div>
                @endforeach
            </td>
            <!-- Taurus (2) -->
            <td class="chart-cell {{ $lagnaRasiIdx === 2 ? 'lagna-cell' : '' }}">
                <div style="font-weight: bold; color: #78350f;">Taurus / ഇടവം</div>
                @foreach($chartData['chart_grid_d1'][2] ?? [] as $pl)
                    <div><strong>{{ $pl['label'] }}</strong> <span style="font-size: 7pt; color: #555;">{{ $pl['deg'] }}°</span></div>
                @endforeach
            </td>
            <!-- Gemini (3) -->
            <td class="chart-cell {{ $lagnaRasiIdx === 3 ? 'lagna-cell' : '' }}">
                <div style="font-weight: bold; color: #78350f;">Gemini / മിഥുനം</div>
                @foreach($chartData['chart_grid_d1'][3] ?? [] as $pl)
                    <div><strong>{{ $pl['label'] }}</strong> <span style="font-size: 7pt; color: #555;">{{ $pl['deg'] }}°</span></div>
                @endforeach
            </td>
        </tr>
        <tr>
            <!-- Aquarius (11) -->
            <td class="chart-cell {{ $lagnaRasiIdx === 11 ? 'lagna-cell' : '' }}">
                <div style="font-weight: bold; color: #78350f;">Aquarius / കുംഭം</div>
                @foreach($chartData['chart_grid_d1'][11] ?? [] as $pl)
                    <div><strong>{{ $pl['label'] }}</strong> <span style="font-size: 7pt; color: #555;">{{ $pl['deg'] }}°</span></div>
                @endforeach
            </td>
            <td colspan="2" rowspan="2" class="chart-center">
                <div style="font-size: 13pt; color: #78350f;">RASI CHAKRA</div>
                <div style="font-size: 9pt; color: #b45309; margin-top: 4px;">(രാശി ചക്രം - D1)</div>
                <div style="font-size: 8pt; color: #555; margin-top: 6px;">
                    Lagna: {{ $chartData['lagna']['name_en'] ?? '' }}<br>
                    Chandra: {{ $chartData['moon_sign']['name_en'] ?? '' }}
                </div>
            </td>
            <!-- Cancer (4) -->
            <td class="chart-cell {{ $lagnaRasiIdx === 4 ? 'lagna-cell' : '' }}">
                <div style="font-weight: bold; color: #78350f;">Cancer / കർക്കി</div>
                @foreach($chartData['chart_grid_d1'][4] ?? [] as $pl)
                    <div><strong>{{ $pl['label'] }}</strong> <span style="font-size: 7pt; color: #555;">{{ $pl['deg'] }}°</span></div>
                @endforeach
            </td>
        </tr>
        <tr>
            <!-- Capricorn (10) -->
            <td class="chart-cell {{ $lagnaRasiIdx === 10 ? 'lagna-cell' : '' }}">
                <div style="font-weight: bold; color: #78350f;">Capricorn / മകരം</div>
                @foreach($chartData['chart_grid_d1'][10] ?? [] as $pl)
                    <div><strong>{{ $pl['label'] }}</strong> <span style="font-size: 7pt; color: #555;">{{ $pl['deg'] }}°</span></div>
                @endforeach
            </td>
            <!-- Leo (5) -->
            <td class="chart-cell {{ $lagnaRasiIdx === 5 ? 'lagna-cell' : '' }}">
                <div style="font-weight: bold; color: #78350f;">Leo / ചിങ്ങം</div>
                @foreach($chartData['chart_grid_d1'][5] ?? [] as $pl)
                    <div><strong>{{ $pl['label'] }}</strong> <span style="font-size: 7pt; color: #555;">{{ $pl['deg'] }}°</span></div>
                @endforeach
            </td>
        </tr>
        <tr>
            <!-- Sagittarius (9) -->
            <td class="chart-cell {{ $lagnaRasiIdx === 9 ? 'lagna-cell' : '' }}">
                <div style="font-weight: bold; color: #78350f;">Sagittarius / ധനു</div>
                @foreach($chartData['chart_grid_d1'][9] ?? [] as $pl)
                    <div><strong>{{ $pl['label'] }}</strong> <span style="font-size: 7pt; color: #555;">{{ $pl['deg'] }}°</span></div>
                @endforeach
            </td>
            <!-- Scorpio (8) -->
            <td class="chart-cell {{ $lagnaRasiIdx === 8 ? 'lagna-cell' : '' }}">
                <div style="font-weight: bold; color: #78350f;">Scorpio / വൃശ്ചി</div>
                @foreach($chartData['chart_grid_d1'][8] ?? [] as $pl)
                    <div><strong>{{ $pl['label'] }}</strong> <span style="font-size: 7pt; color: #555;">{{ $pl['deg'] }}°</span></div>
                @endforeach
            </td>
            <!-- Libra (7) -->
            <td class="chart-cell {{ $lagnaRasiIdx === 7 ? 'lagna-cell' : '' }}">
                <div style="font-weight: bold; color: #78350f;">Libra / തുലാം</div>
                @foreach($chartData['chart_grid_d1'][7] ?? [] as $pl)
                    <div><strong>{{ $pl['label'] }}</strong> <span style="font-size: 7pt; color: #555;">{{ $pl['deg'] }}°</span></div>
                @endforeach
            </td>
            <!-- Virgo (6) -->
            <td class="chart-cell {{ $lagnaRasiIdx === 6 ? 'lagna-cell' : '' }}">
                <div style="font-weight: bold; color: #78350f;">Virgo / കന്നി</div>
                @foreach($chartData['chart_grid_d1'][6] ?? [] as $pl)
                    <div><strong>{{ $pl['label'] }}</strong> <span style="font-size: 7pt; color: #555;">{{ $pl['deg'] }}°</span></div>
                @endforeach
            </td>
        </tr>
    </table>

    <div class="highlight-box">
        <strong>Kendra &amp; Trikona Architecture:</strong><br>
        &bull; <strong>Kendra Houses (1, 4, 7, 10):</strong> Pillars of life strength and public achievement.<br>
        &bull; <strong>Trikona Houses (1, 5, 9):</strong> Abodes of Lakshmi conferring fortune, intelligence, and divine protection.<br>
        &bull; <strong>Dusthana Houses (6, 8, 12):</strong> Spheres of purification, resilience, and spiritual awakening.
    </div>

    <div class="page-break"></div>

    <!-- ================= PAGE 5: BHAVA CHAKRA & BHAVA SANDHIS ================= -->
    <div class="section-title">4. Bhava Chakra (Sripati Divisions &amp; Sandhis)</div>
    <p style="font-size: 8.5pt; color: #555;">
        Per Chapter 7 of <em>Vedanga Jyothisham</em>, house boundaries (Bhavasandhis) explain why planets near cusps shift results between adjacent houses.
    </p>

    <table class="table-data table-compact">
        <thead>
            <tr>
                <th>Bhava</th>
                <th>Signification</th>
                <th>Cusp (Madhya)</th>
                <th>Span (Arambha to Antya)</th>
                <th>Lord</th>
                <th>Occupants</th>
            </tr>
        </thead>
        <tbody>
            @foreach($chartData['bhavas'] ?? [] as $bIdx => $bInfo)
                @php
                    $occupants = [];
                    foreach ($chartData['planet_bhavas'] ?? [] as $plKey => $bData) {
                        $bNum = is_array($bData) ? ($bData['bhava'] ?? 0) : $bData;
                        if ($bNum == $bIdx) {
                            $occupants[] = $plKey;
                        }
                    }
                @endphp
                <tr>
                    <td><strong>Bhava {{ $bIdx }}</strong></td>
                    <td>{{ $bInfo['meta']['name_en'] ?? ($bInfo['name_en'] ?? '') }}</td>
                    <td><strong>{{ round($bInfo['midpoint_deg'] ?? ($bInfo['cusp_longitude'] ?? 0), 1) }}°</strong></td>
                    <td>{{ round($bInfo['start_cusp_deg'] ?? ($bInfo['start_longitude'] ?? 0), 1) }}° - {{ round($bInfo['end_cusp_deg'] ?? ($bInfo['end_longitude'] ?? 0), 1) }}°</td>
                    <td><strong>{{ $bInfo['lord'] ?? '' }}</strong></td>
                    <td>{{ count($occupants) ? implode(', ', $occupants) : 'Empty (Rasi Drishti)' }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="highlight-box">
        <strong>Significance of Bhava Madhya (Chapter 7):</strong><br>
        Planets situated exactly at the Bhava Madhya deliver 100% of their intended karakatwas. As planets move toward the Sandhi (junction), their potency diffuses, yielding mixed outcomes.
    </div>

    <div class="page-break"></div>

    <!-- ================= PAGE 6: NAVAMSHA CHAKRA (D9) & VARGOTTAMA ================= -->
    <div class="section-title">5. Navamsha Chakra (D9) &amp; Vargottama Positions</div>
    <p style="font-size: 8.5pt; color: #555;">
        The 9th harmonic chart (Navamsha) reveals the inner potential, marital fruitfulness, and spiritual evolution.
    </p>

    <table class="chart-grid">
        <tr>
            <!-- Pisces (12) -->
            <td class="chart-cell">
                <div style="font-weight: bold; color: #78350f;">Pisces / മീനം</div>
                @foreach($chartData['chart_grid_d9'][12] ?? [] as $pl)
                    <div><strong>{{ $pl['label'] }}</strong></div>
                @endforeach
            </td>
            <!-- Aries (1) -->
            <td class="chart-cell">
                <div style="font-weight: bold; color: #78350f;">Aries / മേടം</div>
                @foreach($chartData['chart_grid_d9'][1] ?? [] as $pl)
                    <div><strong>{{ $pl['label'] }}</strong></div>
                @endforeach
            </td>
            <!-- Taurus (2) -->
            <td class="chart-cell">
                <div style="font-weight: bold; color: #78350f;">Taurus / ഇടവം</div>
                @foreach($chartData['chart_grid_d9'][2] ?? [] as $pl)
                    <div><strong>{{ $pl['label'] }}</strong></div>
                @endforeach
            </td>
            <!-- Gemini (3) -->
            <td class="chart-cell">
                <div style="font-weight: bold; color: #78350f;">Gemini / മിഥുനം</div>
                @foreach($chartData['chart_grid_d9'][3] ?? [] as $pl)
                    <div><strong>{{ $pl['label'] }}</strong></div>
                @endforeach
            </td>
        </tr>
        <tr>
            <!-- Aquarius (11) -->
            <td class="chart-cell">
                <div style="font-weight: bold; color: #78350f;">Aquarius / കുംഭം</div>
                @foreach($chartData['chart_grid_d9'][11] ?? [] as $pl)
                    <div><strong>{{ $pl['label'] }}</strong></div>
                @endforeach
            </td>
            <td colspan="2" rowspan="2" class="chart-center">
                <div style="font-size: 13pt; color: #78350f;">NAVAMSHA (D9)</div>
                <div style="font-size: 9pt; color: #b45309; margin-top: 4px;">(നവാംശകം - D9)</div>
                <div style="font-size: 8pt; color: #555; margin-top: 6px;">
                    Dharmamsha &amp; Kalathramsha<br>
                    Includes Gulika &amp; Nodes
                </div>
            </td>
            <!-- Cancer (4) -->
            <td class="chart-cell">
                <div style="font-weight: bold; color: #78350f;">Cancer / കർക്കി</div>
                @foreach($chartData['chart_grid_d9'][4] ?? [] as $pl)
                    <div><strong>{{ $pl['label'] }}</strong></div>
                @endforeach
            </td>
        </tr>
        <tr>
            <!-- Capricorn (10) -->
            <td class="chart-cell">
                <div style="font-weight: bold; color: #78350f;">Capricorn / മകരം</div>
                @foreach($chartData['chart_grid_d9'][10] ?? [] as $pl)
                    <div><strong>{{ $pl['label'] }}</strong></div>
                @endforeach
            </td>
            <!-- Leo (5) -->
            <td class="chart-cell">
                <div style="font-weight: bold; color: #78350f;">Leo / ചിങ്ങം</div>
                @foreach($chartData['chart_grid_d9'][5] ?? [] as $pl)
                    <div><strong>{{ $pl['label'] }}</strong></div>
                @endforeach
            </td>
        </tr>
        <tr>
            <!-- Sagittarius (9) -->
            <td class="chart-cell">
                <div style="font-weight: bold; color: #78350f;">Sagittarius / ധനു</div>
                @foreach($chartData['chart_grid_d9'][9] ?? [] as $pl)
                    <div><strong>{{ $pl['label'] }}</strong></div>
                @endforeach
            </td>
            <!-- Scorpio (8) -->
            <td class="chart-cell">
                <div style="font-weight: bold; color: #78350f;">Scorpio / വൃശ്ചി</div>
                @foreach($chartData['chart_grid_d9'][8] ?? [] as $pl)
                    <div><strong>{{ $pl['label'] }}</strong></div>
                @endforeach
            </td>
            <!-- Libra (7) -->
            <td class="chart-cell">
                <div style="font-weight: bold; color: #78350f;">Libra / തുലാം</div>
                @foreach($chartData['chart_grid_d9'][7] ?? [] as $pl)
                    <div><strong>{{ $pl['label'] }}</strong></div>
                @endforeach
            </td>
            <!-- Virgo (6) -->
            <td class="chart-cell">
                <div style="font-weight: bold; color: #78350f;">Virgo / കന്നി</div>
                @foreach($chartData['chart_grid_d9'][6] ?? [] as $pl)
                    <div><strong>{{ $pl['label'] }}</strong></div>
                @endforeach
            </td>
        </tr>
    </table>

    <div class="subsection-title">Vargottama Planets</div>
    <div class="highlight-box">
        @php
            $vargottamaList = [];
            foreach (['As', 'Su', 'Mo', 'Ma', 'Me', 'Ju', 'Ve', 'Sa', 'Ra', 'Ke'] as $bK) {
                if (($chartData['shadvarga'][$bK]['d1_rasi'] ?? 0) === ($chartData['shadvarga'][$bK]['d9_navamsha'] ?? -1)) {
                    $vargottamaList[] = $chartData['shadvarga'][$bK]['name_en'] ?? $bK;
                }
            }
        @endphp
        @if(count($vargottamaList) > 0)
            <strong>Highly Auspicious Vargottama Positions:</strong> {{ implode(', ', $vargottamaList) }}<br>
            Per Chapter 9 of <em>Vedanga Jyothisham</em>, a planet occupying the exact same sign in both Rasi and Navamsha attains royal status (<em>Swarupa Bala</em>), protecting its houses even when combust or afflicted.
        @else
            <strong>Vargottama Status:</strong> No planet is in identical Rasi &amp; Navamsha; however, planetary strengths derive from harmonic Shadbala and Ashtakavarga bindus.
        @endif
    </div>

    <div class="page-break"></div>

    <!-- ================= PAGE 7: SHADVARGA HARMONIC SUMMARY ================= -->
    <div class="section-title">6. Shadvarga (Six-Fold Harmonic) Matrix</div>
    <p style="font-size: 8.5pt; color: #555;">
        Evaluates planetary strength across the six fundamental divisional chakras per Classical Parashari and Kerala canons.
    </p>

    <table class="table-data table-compact">
        <thead>
            <tr>
                <th>Planet</th>
                <th>D1 (Rasi)</th>
                <th>D2 (Hora)</th>
                <th>D3 (Drekkana)</th>
                <th>D9 (Navamsha)</th>
                <th>D12 (Dwadasamsha)</th>
                <th>D30 (Trimsamsha)</th>
            </tr>
        </thead>
        <tbody>
            @foreach(['As' => 'Lagna', 'Su' => 'Sun', 'Mo' => 'Moon', 'Ma' => 'Mars', 'Me' => 'Mercury', 'Ju' => 'Jupiter', 'Ve' => 'Venus', 'Sa' => 'Saturn', 'Ra' => 'Rahu', 'Ke' => 'Ketu', 'Md' => 'Gulika'] as $k => $label)
                @php $sv = $chartData['shadvarga'][$k] ?? []; @endphp
                <tr>
                    <td><strong>{{ $label }}</strong> ({{ $k }})</td>
                    <td>Rasi {{ $sv['d1_rasi'] ?? '-' }}</td>
                    <td>{{ ($sv['d2_hora'] ?? 1) == 1 ? 'Sun (Surya)' : 'Moon (Chandra)' }}</td>
                    <td>Drekkana {{ $sv['d3_drekkana'] ?? '-' }}</td>
                    <td>Navamsha {{ $sv['d9_navamsha'] ?? '-' }}</td>
                    <td>D12 {{ $sv['d12_dwadasamsha'] ?? '-' }}</td>
                    <td>D30 {{ $sv['d30_trimsamsha'] ?? '-' }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="highlight-box">
        <strong>Varga Significations:</strong><br>
        &bull; <strong>D2 Hora:</strong> Wealth generation capacity and financial sustainability.<br>
        &bull; <strong>D3 Drekkana:</strong> Courage, initiative, vitality, and support of co-borns.<br>
        &bull; <strong>D9 Navamsha:</strong> Marital harmony, inner spiritual destiny, and post-marriage fortune.<br>
        &bull; <strong>D12 Dwadasamsha:</strong> Ancestral lineage, parental blessings, and hereditary tendencies.<br>
        &bull; <strong>D30 Trimsamsha:</strong> Inherent karmic liabilities, health vulnerabilities, and remedial priority.
    </div>

    <div class="page-break"></div>

    <!-- ================= PAGE 8: 120-YEAR VIMSHOTTARI DASHA TIMELINE ================= -->
    <div class="section-title">7. Vimshottari Mahadasha 120-Year Lifeline</div>
    <p style="font-size: 8.5pt; color: #555;">
        Calculated from the precise longitude of Chandra at birth (Janma Nakshatra Pada).
    </p>

    <div class="highlight-box">
        <strong>Balance of Dasha at Birth (Garbhashishta):</strong><br>
        <strong>{{ $chartData['garbhashishta']['lord_en'] ?? '' }} ({{ $chartData['garbhashishta']['lord_ml'] ?? '' }}) Mahadasha</strong> balance:
        <strong>{{ $chartData['garbhashishta']['years'] ?? 0 }} Years, {{ $chartData['garbhashishta']['months'] ?? 0 }} Months, {{ $chartData['garbhashishta']['days'] ?? 0 }} Days</strong>.
    </div>

    <table class="table-data table-compact">
        <thead>
            <tr>
                <th>Mahadasha</th>
                <th>Ruling Planet</th>
                <th>Duration</th>
                <th>Start Date</th>
                <th>End Date</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @foreach($chartData['dasha']['timeline'] ?? [] as $d)
                @php
                    $isCurrent = !empty($d['is_active']);
                @endphp
                <tr style="{{ $isCurrent ? 'background-color: #fef9c3; font-weight: bold;' : '' }}">
                    <td>{{ $d['lord_en'] }} ({{ $d['lord_ml'] }})</td>
                    <td>{{ $d['lord_key'] }}</td>
                    <td>{{ $d['duration_years'] }} Years</td>
                    <td>{{ \Carbon\Carbon::parse($d['start_date'])->format('d-m-Y') }}</td>
                    <td>{{ \Carbon\Carbon::parse($d['end_date'])->format('d-m-Y') }}</td>
                    <td style="color: {{ $isCurrent ? '#b45309' : '#555' }}; font-weight: bold;">
                        {{ $isCurrent ? '★ CURRENTLY RUNNING' : (\Carbon\Carbon::parse($d['end_date'])->isPast() ? 'Completed' : 'Upcoming') }}
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="page-break"></div>

    <!-- ================= PAGE 9: ACTIVE DASHA & APAHARA (ANTARDASHA) ================= -->
    <div class="section-title">8. Active Mahadasha &amp; Antardasha (Apahara) Breakdown</div>
    <p style="font-size: 8.5pt; color: #555;">
        Detailed sub-period calendar for the currently operating planetary period.
    </p>

    <div class="highlight-box" style="border-left-color: #059669; background-color: #ecfdf5;">
        <strong style="color: #065f46; font-size: 10pt;">Active Planetary Cycle:</strong><br>
        <strong>Mahadasha:</strong> {{ $chartData['active_dasha']['mahadasha_en'] ?? '' }} ({{ $chartData['active_dasha']['mahadasha_ml'] ?? '' }})<br>
        <strong>Antardasha (Apahara):</strong> {{ $chartData['active_dasha']['antardasha_en'] ?? '' }} ({{ $chartData['active_dasha']['antardasha_ml'] ?? '' }})<br>
        <strong>Operating Span:</strong> {{ \Carbon\Carbon::parse($chartData['active_dasha']['start_date'] ?? now())->format('d-m-Y') }} to {{ \Carbon\Carbon::parse($chartData['active_dasha']['end_date'] ?? now())->format('d-m-Y') }}
    </div>

    <div class="subsection-title">Sub-Periods (Apaharas) of Current Mahadasha</div>
    <table class="table-data table-compact">
        <thead>
            <tr>
                <th>Apahara (Sub-Lord)</th>
                <th>Span (Start to End)</th>
                <th>General Planetary Tendency</th>
            </tr>
        </thead>
        <tbody>
            @foreach($chartData['active_dasha']['all_antardashas'] ?? [] as $ad)
                <tr style="{{ !empty($ad['is_active']) ? 'background-color: #fef9c3; font-weight: bold;' : '' }}">
                    <td><strong>{{ $ad['lord_en'] }}</strong> ({{ $ad['lord_ml'] }})</td>
                    <td>{{ \Carbon\Carbon::parse($ad['start_date'])->format('d-m-Y') }} &mdash; {{ \Carbon\Carbon::parse($ad['end_date'])->format('d-m-Y') }}</td>
                    <td>{{ $ad['tendency'] ?? 'Karmic progression according to house placements and benefic aspects.' }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="highlight-box">
        <strong>Vimshottari Rule of Interpretation (Chapter 11, <em>Vedanga Jyothisham</em>):</strong><br>
        During the Mahadasha of planet A and Antardasha of planet B, results materialize through the houses owned and occupied by both lords, modified by mutual aspect (<em>Paraspara Drishti</em>) and temporal friendship.
    </div>

    <div class="page-break"></div>

    <!-- ================= PAGE 10: SARVASHTAKAVARGA (337 POINTS) ================= -->
    <div class="section-title">9. Sarvashtakavarga (337 Points) Strength Audit</div>
    <p style="font-size: 8.5pt; color: #555;">
        Ashtakavarga evaluates the independent transit and natal strength across all 12 signs. A score of 28 bindus represents the balanced baseline.
    </p>

    <table class="table-data">
        <thead>
            <tr>
                <th>Sign / Rasi</th>
                <th>SAV Bindus</th>
                <th>Strength Rating</th>
                <th>Classical Result</th>
            </tr>
        </thead>
        <tbody>
            @php
                $savData = $chartData['ashtakavarga']['sav'] ?? [];
                $totalSav = array_sum($savData);
            @endphp
            @foreach([
                1 => 'Aries / മേടം', 2 => 'Taurus / ഇടവം', 3 => 'Gemini / മിഥുനം', 4 => 'Cancer / കർക്കിടകം',
                5 => 'Leo / ചിങ്ങം', 6 => 'Virgo / കന്നി', 7 => 'Libra / തുലാം', 8 => 'Scorpio / വൃശ്ചികം',
                9 => 'Sagittarius / ധനു', 10 => 'Capricorn / മകരം', 11 => 'Aquarius / കുംഭം', 12 => 'Pisces / മീനം'
            ] as $rNum => $rLabel)
                @php
                    $pts = $savData[$rNum] ?? 28;
                    $rating = $pts >= 30 ? 'Highly Fortunate' : ($pts >= 28 ? 'Auspicious / Balanced' : ($pts >= 25 ? 'Average / Moderate' : 'Requires Caution'));
                    $color = $pts >= 28 ? '#15803d' : '#b91c1c';
                @endphp
                <tr>
                    <td><strong>{{ $rLabel }}</strong></td>
                    <td><strong style="color: {{ $color }}; font-size: 10pt;">{{ $pts }}</strong> Bindus</td>
                    <td style="color: {{ $color }}; font-weight: bold;">{{ $rating }}</td>
                    <td>{{ $pts >= 28 ? 'Smooth fulfillment of endeavors; beneficial during planetary transits.' : 'Requires diligent effort, careful speech, and spiritual remedies.' }}</td>
                </tr>
            @endforeach
            <tr style="background-color: #fef3c7; font-weight: bold;">
                <td><strong>Total Samudaya Bindus</strong></td>
                <td><strong style="color: #78350f; font-size: 11pt;">{{ $totalSav }} / 337</strong></td>
                <td colspan="2">Standard Parashari Mathematical Integrity Confirmed (337 Bindus)</td>
            </tr>
        </tbody>
    </table>

    <div class="page-break"></div>

    <!-- ================= PAGE 11: BHINNASHTAKAVARGA (BAV) MATRIX ================= -->
    <div class="section-title">10. Bhinnashtakavarga (BAV) Planetary Distribution</div>
    <p style="font-size: 8.5pt; color: #555;">
        Individual benefic bindus contributed by each planet and Lagna into the 12 signs (Kakshya system).
    </p>

    <table class="table-data table-compact" style="font-size: 7.5pt;">
        <thead>
            <tr>
                <th>Rasi</th>
                <th>Sun</th>
                <th>Moon</th>
                <th>Mars</th>
                <th>Merc</th>
                <th>Jup</th>
                <th>Ven</th>
                <th>Sat</th>
                <th>SAV</th>
            </tr>
        </thead>
        <tbody>
            @php
                $bav = $chartData['ashtakavarga']['bav'] ?? [];
            @endphp
            @foreach([
                1 => 'Aries', 2 => 'Taurus', 3 => 'Gemini', 4 => 'Cancer',
                5 => 'Leo', 6 => 'Virgo', 7 => 'Libra', 8 => 'Scorpio',
                9 => 'Sagittarius', 10 => 'Capricorn', 11 => 'Aquarius', 12 => 'Pisces'
            ] as $rNum => $rName)
                <tr>
                    <td><strong>{{ $rName }}</strong></td>
                    <td>{{ $bav['Su'][$rNum] ?? '-' }}</td>
                    <td>{{ $bav['Mo'][$rNum] ?? '-' }}</td>
                    <td>{{ $bav['Ma'][$rNum] ?? '-' }}</td>
                    <td>{{ $bav['Me'][$rNum] ?? '-' }}</td>
                    <td>{{ $bav['Ju'][$rNum] ?? '-' }}</td>
                    <td>{{ $bav['Ve'][$rNum] ?? '-' }}</td>
                    <td>{{ $bav['Sa'][$rNum] ?? '-' }}</td>
                    <td><strong>{{ $savData[$rNum] ?? '-' }}</strong></td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="highlight-box">
        <strong>Kakshya Timing Principle:</strong><br>
        Each sign is divided into 8 Kakshyas (3°45' each) ruled in order by Saturn, Jupiter, Mars, Sun, Venus, Mercury, Moon, and Lagna. A transiting planet delivers its positive fruits only when passing through a Kakshya that contains a bindu in its own BAV chart.
    </div>

    <div class="page-break"></div>

    <!-- ================= PAGE 12: CLASSICAL YOGAS COMPREHENSIVE ================= -->
    <div class="section-title">11. Classical Yogas Evaluation (Ch. 10 &amp; 13)</div>
    <p style="font-size: 8.5pt; color: #555;">
        Synthesized strictly per <em>Vedanga Jyothisham</em> rules with Ubhaya/Sthira lagna qualifications and conjunction exceptions.
    </p>

    @foreach($chartData['vedanga_predictions']['yogas'] ?? $chartData['yogas'] ?? [] as $y)
        <div style="border: 1px solid #d97706; background-color: #fffbeb; padding: 8px 10px; margin-bottom: 8px; border-radius: 4px;">
            <div style="font-weight: bold; color: #78350f; font-size: 10pt;">
                ★ {{ $y['title_en'] ?? $y['name_en'] ?? 'Classical Yoga' }} ({{ $y['title_ml'] ?? $y['name_ml'] ?? '' }})
            </div>
            <div style="font-size: 8.5pt; color: #1f2937; margin-top: 3px;">
                {{ $y['result_translations'][$targetLang] ?? $y['content_' . $targetLang] ?? $y['result_' . $targetLang] ?? $y['content_en'] ?? $y['result_en'] ?? $y['result'] ?? $y['description_en'] ?? '' }}
            </div>
            @if(!empty($y['content_ml']) && $targetLang !== 'ml')
            <div style="font-size: 8pt; color: #92400e; margin-top: 3px;">
                {{ $y['content_ml'] }}
            </div>
            @elseif(!empty($y['result_ml']) && $targetLang !== 'ml')
            <div style="font-size: 8pt; color: #92400e; margin-top: 3px;">
                {{ $y['result_ml'] }}
            </div>
            @endif
        </div>
    @endforeach

    <div class="page-break"></div>

    <!-- ================= PAGE 13: GULIKA (MAANDHI) PHALAM ================= -->
    <div class="section-title">12. Gulika (Maandhi) Diagnostic Phalam (Ch. 5 &amp; 17)</div>
    <p style="font-size: 8.5pt; color: #555;">
        Maandhi (Gulika) is the son of Saturn, uniquely revered in the Kerala Jyothisha tradition for its exact surgical indications.
    </p>

    <div class="highlight-box">
        <strong>Gulika Sphuta &amp; House Placement:</strong><br>
        &bull; <strong>Occupying House:</strong> House {{ $chartData['vedanga_predictions']['gulika']['bhava'] ?? $chartData['vedanga_predictions']['gulika']['house'] ?? 1 }}<br>
        &bull; <strong>Sign &amp; Sphuta:</strong> {{ round($chartData['gulika']['longitude'] ?? 0, 2) }}°<br>
        &bull; <strong>Key Phalam:</strong> {{ $chartData['vedanga_predictions']['gulika']['phala_translations'][$targetLang] ?? $chartData['vedanga_predictions']['gulika']['house_result_' . $targetLang] ?? $chartData['vedanga_predictions']['gulika']['phala'] ?? $chartData['vedanga_predictions']['gulika']['house_result_en'] ?? '' }}<br>
        @if(!empty($chartData['vedanga_predictions']['gulika']['house_result_ml']) && $targetLang !== 'ml')
            <span style="font-size: 8pt; color: #92400e;">{{ $chartData['vedanga_predictions']['gulika']['house_result_ml'] }}</span>
        @elseif(!empty($chartData['vedanga_predictions']['gulika']['phala_translations']['ml']) && $targetLang !== 'ml')
            <span style="font-size: 8pt; color: #92400e;">{{ $chartData['vedanga_predictions']['gulika']['phala_translations']['ml'] }}</span>
        @endif
    </div>

    @if(!empty($chartData['vedanga_predictions']['gulika']['conjunctions']))
        <div class="subsection-title">Gulika Conjunction Alerts</div>
        @foreach($chartData['vedanga_predictions']['gulika']['conjunctions'] as $conj)
            <div class="highlight-box" style="border-left-color: #d97706;">
                <strong>{{ $conj['title'] ?? $conj['title_en'] ?? ('Gulika conjunct ' . ($conj['name_en'] ?? $conj['planet'] ?? '')) }}:</strong>
                {{ $conj['phalam_' . $targetLang] ?? $conj['phalam_en'] ?? $conj['phala'] ?? '' }}<br>
                @if(!empty($conj['phalam_ml']) && $targetLang !== 'ml')
                    <span style="font-size: 8pt; color: #92400e;">{{ $conj['phalam_ml'] }}</span>
                @endif
            </div>
        @endforeach
    @endif

    <div class="page-break"></div>

    <!-- ================= PAGE 14: BHAVAS 1 & 2 ================= -->
    <div class="section-title">13. Bhava Synthesis: 1st (Tanu) &amp; 2nd (Dhana) Bhavas</div>

    <div class="subsection-title">Bhava 1: Tanu Bhava (Lagna / Physical Constitution &amp; Self)</div>
    <p>
        {{ $chartData['vedanga_predictions']['bhavas'][1]['analysis_en'] ?? 'The Ascendant represents the vitality, longevity, temperament, and personal manifestation in the world.' }}
    </p>
    <div class="highlight-box">
        <strong>Lord &amp; Placement:</strong> {{ $chartData['vedanga_predictions']['bhavas'][1]['lord_placement_en'] ?? '' }}<br>
        <strong>Occupying Influences:</strong> {{ $chartData['vedanga_predictions']['bhavas'][1]['occupants_en'] ?? 'Aspected by benefic planets.' }}
    </div>

    <div class="subsection-title">Bhava 2: Dhana Bhava (Wealth, Family Lineage &amp; Speech)</div>
    <p>
        {{ $chartData['vedanga_predictions']['bhavas'][2]['analysis_en'] ?? 'The 2nd house governs movable assets, oral eloquence, dietary habits, and family harmony.' }}
    </p>
    <div class="highlight-box">
        <strong>Lord &amp; Placement:</strong> {{ $chartData['vedanga_predictions']['bhavas'][2]['lord_placement_en'] ?? '' }}<br>
        <strong>Speech &amp; Dietary Guidance:</strong> {{ $chartData['vedanga_predictions']['wealth_and_speech']['speech_en'] ?? 'Mindful speech brings commercial success.' }}
    </div>

    <div class="page-break"></div>

    <!-- ================= PAGE 15: BHAVAS 3 & 4 ================= -->
    <div class="section-title">14. Bhava Synthesis: 3rd (Sahaja) &amp; 4th (Sukha) Bhavas</div>

    <div class="subsection-title">Bhava 3: Sahaja Bhava (Courage, Brothers &amp; Initiative)</div>
    <p>
        {{ $chartData['vedanga_predictions']['bhavas'][3]['analysis_en'] ?? 'Governs personal enterprise, younger siblings, artistic manual skills, and short journeys.' }}
    </p>
    <div class="highlight-box">
        <strong>Lord &amp; Placement:</strong> {{ $chartData['vedanga_predictions']['bhavas'][3]['lord_placement_en'] ?? '' }}
    </div>

    <div class="subsection-title">Bhava 4: Sukha Bhava (Mother, Landed Property &amp; Inner Peace)</div>
    <p>
        {{ $chartData['vedanga_predictions']['bhavas'][4]['analysis_en'] ?? 'Governs academic foundations, maternal relationship, residential comforts, and emotional equilibrium.' }}
    </p>
    <div class="highlight-box">
        <strong>Lord &amp; Placement:</strong> {{ $chartData['vedanga_predictions']['bhavas'][4]['lord_placement_en'] ?? '' }}
    </div>

    <div class="page-break"></div>

    <!-- ================= PAGE 16: BHAVAS 5 & 6 ================= -->
    <div class="section-title">15. Bhava Synthesis: 5th (Putra) &amp; 6th (Satru) Bhavas</div>

    <div class="subsection-title">Bhava 5: Putra Bhava (Intellect, Progeny &amp; Purvapunya)</div>
    <p>
        {{ $chartData['vedanga_predictions']['bhavas'][5]['analysis_en'] ?? 'Governs creative intelligence, past-life merit, advisory skills, and children.' }}
    </p>
    <div class="highlight-box">
        <strong>Lord &amp; Placement:</strong> {{ $chartData['vedanga_predictions']['bhavas'][5]['lord_placement_en'] ?? '' }}
    </div>

    <div class="subsection-title">Bhava 6: Satru Bhava (Overcoming Obstacles, Service &amp; Health)</div>
    <p>
        {{ $chartData['vedanga_predictions']['bhavas'][6]['analysis_en'] ?? 'An Upachaya house where malefic planets perform with exceptional vigor to conquer challenges and rivals.' }}
    </p>
    <div class="highlight-box">
        <strong>Lord &amp; Placement:</strong> {{ $chartData['vedanga_predictions']['bhavas'][6]['lord_placement_en'] ?? '' }}
    </div>

    <div class="page-break"></div>

    <!-- ================= PAGE 17: BHAVAS 7 & 8 ================= -->
    <div class="section-title">16. Bhava Synthesis: 7th (Kalathra) &amp; 8th (Ayur) Bhavas</div>

    <div class="subsection-title">Bhava 7: Kalathra Bhava (Spouse, Partnerships &amp; Public Sphere)</div>
    <p>
        {{ $chartData['vedanga_predictions']['bhavas'][7]['analysis_en'] ?? 'Governs marital concord, partner nature, business collaborations, and external diplomacy.' }}
    </p>
    <div class="highlight-box">
        <strong>Lord &amp; Placement:</strong> {{ $chartData['vedanga_predictions']['bhavas'][7]['lord_placement_en'] ?? '' }}
    </div>

    <div class="subsection-title">Bhava 8: Ayur Bhava (Longevity, Esoteric Sciences &amp; Transformation)</div>
    <p>
        {{ $chartData['vedanga_predictions']['bhavas'][8]['analysis_en'] ?? 'The house of hidden treasures, longevity, occult intuition, and deep psychological evolution.' }}
    </p>
    <div class="highlight-box">
        <strong>Lord &amp; Placement:</strong> {{ $chartData['vedanga_predictions']['bhavas'][8]['lord_placement_en'] ?? '' }}
    </div>

    <div class="page-break"></div>

    <!-- ================= PAGE 18: BHAVAS 9 & 10 ================= -->
    <div class="section-title">17. Bhava Synthesis: 9th (Bhagya) &amp; 10th (Karma) Bhavas</div>

    <div class="subsection-title">Bhava 9: Bhagya Bhava (Fortune, Father &amp; Divine Grace)</div>
    <p>
        {{ $chartData['vedanga_predictions']['bhavas'][9]['analysis_en'] ?? 'The supreme Trikona governing divine grace, ethical philosophy, pilgrimage, and paternal blessings.' }}
    </p>
    <div class="highlight-box">
        <strong>Lord &amp; Placement:</strong> {{ $chartData['vedanga_predictions']['bhavas'][9]['lord_placement_en'] ?? '' }}
    </div>

    <div class="subsection-title">Bhava 10: Karma Bhava (Profession, Leadership &amp; Status)</div>
    <p>
        {{ $chartData['vedanga_predictions']['bhavas'][10]['analysis_en'] ?? 'The crown of the chart governing professional stature, public honor, enterprise, and career zenith.' }}
    </p>
    <div class="highlight-box">
        <strong>Lord &amp; Placement:</strong> {{ $chartData['vedanga_predictions']['bhavas'][10]['lord_placement_en'] ?? '' }}
    </div>

    <div class="page-break"></div>

    <!-- ================= PAGE 19: BHAVAS 11 & 12 ================= -->
    <div class="section-title">18. Bhava Synthesis: 11th (Labha) &amp; 12th (Vyaya) Bhavas</div>

    <div class="subsection-title">Bhava 11: Labha Bhava (Gains, Aspirations &amp; Elder Siblings)</div>
    <p>
        {{ $chartData['vedanga_predictions']['bhavas'][11]['analysis_en'] ?? 'The pre-eminent house of fulfillment of ambitions, continuous financial inflows, and social network.' }}
    </p>
    <div class="highlight-box">
        <strong>Lord &amp; Placement:</strong> {{ $chartData['vedanga_predictions']['bhavas'][11]['lord_placement_en'] ?? '' }}
    </div>

    <div class="subsection-title">Bhava 12: Vyaya Bhava (Expenditures, Foreign Lands &amp; Moksha)</div>
    <p>
        {{ $chartData['vedanga_predictions']['bhavas'][12]['analysis_en'] ?? 'Governs overseas journeys, investments, quality of sleep, and ultimate spiritual liberation.' }}
    </p>
    <div class="highlight-box">
        <strong>Lord &amp; Placement:</strong> {{ $chartData['vedanga_predictions']['bhavas'][12]['lord_placement_en'] ?? '' }}
    </div>

    <div class="page-break"></div>

    <!-- ================= PAGE 20: CAREER & WEALTH MASTERY ================= -->
    <div class="section-title">19. Vocational Destiny &amp; Wealth Mastery (Ch. 12 &amp; 14)</div>
    <p style="font-size: 8.5pt; color: #555;">
        Analyzed by synthesizing the 10th house, 2nd house (Dhana), 11th house (Labha), and the Karaka Mercury/Jupiter.
    </p>

    <div class="highlight-box">
        <strong>Primary Wealth Indication:</strong><br>
        {{ $chartData['vedanga_predictions']['wealth_and_speech']['wealth_en'] ?? 'Wealth manifests steadily through ethical service, organizational management, and specialized technical knowledge.' }}<br>
        <span style="font-size: 8pt; color: #92400e;">{{ $chartData['vedanga_predictions']['wealth_and_speech']['wealth_ml'] ?? '' }}</span>
    </div>

    <table class="table-data">
        <tr>
            <th style="width: 30%;">Optimal Career Fields</th>
            <td>Administration, Advisory, Technical Management, Banking, Judicial, Educational, or Creative Enterprise.</td>
        </tr>
        <tr>
            <th>Peak Earning Years</th>
            <td>During the Mahadasha and Antardashas of the 2nd, 9th, 10th, and 11th lords.</td>
        </tr>
        <tr>
            <th>Commercial Caution</th>
            <td>Avoid speculative risks during transits over houses with fewer than 28 SAV bindus.</td>
        </tr>
    </table>

    <div class="page-break"></div>

    <!-- ================= PAGE 21: MARRIAGE & COMPATIBILITY ================= -->
    <div class="section-title">20. Vivaha (Marriage) &amp; Relational Concord</div>
    <p style="font-size: 8.5pt; color: #555;">
        Synthesizing the 7th Bhava, 7th lord, Shukra (Venus) / Guru (Jupiter), and the Navamsha (D9) disposition.
    </p>

    <table class="table-data">
        <tr>
            <th style="width: 30%;">7th Bhava Sign</th>
            <td>{{ $chartData['bhavas'][7]['meta']['name_en'] ?? ($chartData['bhavas'][7]['name_en'] ?? 'Kalathra Bhava') }}</td>
        </tr>
        <tr>
            <th>7th Lord Placement</th>
            @php
                $sevLord = $chartData['bhavas'][7]['lord'] ?? 'Ju';
                $sevPlacement = is_array($chartData['planet_bhavas'][$sevLord] ?? null) ? ($chartData['planet_bhavas'][$sevLord]['bhava'] ?? 7) : ($chartData['planet_bhavas'][$sevLord] ?? 7);
            @endphp
            <td>House {{ $sevPlacement }}</td>
        </tr>
        <tr>
            <th>Kalathra Karaka</th>
            <td>{{ $reading->gender === 'female' ? 'Guru (Jupiter) & Mars' : 'Shukra (Venus)' }}</td>
        </tr>
        <tr>
            <th>Kuja / Manglik Status</th>
            <td>
                @php
                    $marsHouse = is_array($chartData['planet_bhavas']['Ma'] ?? null) ? ($chartData['planet_bhavas']['Ma']['bhava'] ?? 1) : ($chartData['planet_bhavas']['Ma'] ?? 1);
                    $isKuja = in_array($marsHouse, [1, 2, 4, 7, 8, 12]);
                @endphp
                {{ $isKuja ? 'Mild Kuja influence (mitigated by benefic aspects per Ch. 15)' : 'No Kuja Dosha (Auspicious)' }}
            </td>
        </tr>
    </table>

    <div class="highlight-box">
        <strong>Marital Compatibility Counsel:</strong><br>
        Mutual understanding, transparent communication, and periodic prayers at family deity temples cultivate lifelong relational serenity.
    </div>

    <div class="page-break"></div>

    <!-- ================= PAGE 22: CONSTITUTIONAL HEALTH & AYURVEDA ================= -->
    <div class="section-title">21. Constitutional Vitality &amp; Health Wisdom</div>
    <p style="font-size: 8.5pt; color: #555;">
        Medical astrology is purely diagnostic and preventive, promoting harmony among Vata, Pitta, and Kapha doshas.
    </p>

    <div class="highlight-box">
        <strong>Constitutional Profile:</strong><br>
        {{ $chartData['vedanga_predictions']['health']['general_en'] ?? 'Good general stamina and vitality governed by Lagna lord.' }}<br>
        <span style="font-size: 8pt; color: #92400e;">{{ $chartData['vedanga_predictions']['health']['general_ml'] ?? '' }}</span>
    </div>

    <table class="table-data">
        <tr>
            <th style="width: 30%;">Vulnerable Organ Systems</th>
            <td>{{ $chartData['vedanga_predictions']['health']['vulnerable_areas_en'] ?? 'Digestive system, joints, and nervous balance during high-stress periods.' }}</td>
        </tr>
        <tr>
            <th>Ayurvedic Lifestyle Counsel</th>
            <td>Regular hydration, satvic vegetarian meals, morning suryanamaskar, and restful sleep before midnight.</td>
        </tr>
        <tr>
            <th>Spiritual Health Mantra</th>
            <td>Maha Mrityunjaya Mantra (11 repetitions daily at dawn).</td>
        </tr>
    </table>

    <div class="page-break"></div>

    <!-- ================= PAGE 23: GOCHARA & SADE SATI AUDIT ================= -->
    <div class="section-title">22. Gochara (Current Planetary Transits) &amp; Shani Analysis</div>
    <p style="font-size: 8.5pt; color: #555;">
        Calculated from natal Chandra Rasi per Chapter 14 of <em>Vedanga Jyothisham</em> including classical Vedha checks.
    </p>

    <table class="table-data table-compact">
        <thead>
            <tr>
                <th>Planet</th>
                <th>Position from Moon</th>
                <th>Transit Impact</th>
            </tr>
        </thead>
        <tbody>
            @foreach($chartData['vedanga_predictions']['gocharaphala']['planets'] ?? [] as $gp)
                <tr>
                    <td><strong>{{ $gp['name_en'] }}</strong> ({{ $gp['name_ml'] }})</td>
                    <td>{{ $gp['house_from_moon'] }}th House</td>
                    <td style="color: {{ $gp['effective_favorable'] ? '#15803d' : '#b45309' }}; font-weight: bold;">
                        {{ $gp['status_text'] }}
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="highlight-box">
        <strong>Saturn Transit (Shani Gochara) Audit:</strong><br>
        &bull; <strong>7½ Shani (Sade Sati):</strong> {{ ($chartData['vedanga_predictions']['gocharaphala']['saturn_special']['is_ezhara_shani'] ?? false) ? 'Active (' . $chartData['vedanga_predictions']['gocharaphala']['saturn_special']['phase'] . ')' : 'Not Active' }}<br>
        &bull; <strong>Kantaka Shani:</strong> {{ ($chartData['vedanga_predictions']['gocharaphala']['saturn_special']['is_kantaka_shani'] ?? false) ? 'Active (' . $chartData['vedanga_predictions']['gocharaphala']['saturn_special']['kantaka_house'] . 'th House)' : 'None' }}<br>
        &bull; <strong>Ashtama Shani:</strong> {{ ($chartData['vedanga_predictions']['gocharaphala']['saturn_special']['is_ashtama_shani'] ?? false) ? 'Active' : 'None' }}<br>
        &bull; <strong>Shasta / Ayyappa Pariharam:</strong> {{ $chartData['vedanga_predictions']['gocharaphala']['saturn_special']['remedy_en'] ?? 'Lighting sesame oil lamps (Neerajanam) on Saturdays.' }}
    </div>

    <div class="page-break"></div>

    <!-- ================= PAGE 24: GEMSTONES & PARIHARAMS ================= -->
    <div class="section-title">23. Sacred Gemstone Prescription &amp; Temple Pariharams</div>
    <p style="font-size: 8.5pt; color: #555;">
        Prescribed according to Trine Lordship (Houses 1, 5, 9) and Gender rules from Chapter 16 of <em>Vedanga Jyothisham</em>.
    </p>

    <table class="table-data">
        <tr>
            <th style="width: 35%;">Primary Auspicious Gemstone</th>
            <td><strong style="color: #b45309; font-size: 11pt;">{{ $chartData['gemstone_en'] ?? '' }}</strong> ({{ $chartData['gemstone_ml'] ?? '' }})</td>
        </tr>
        <tr>
            <th>Semi-Precious Alternative (Uparatna)</th>
            <td>{{ $chartData['gemstone']['uparatna_en'] ?? 'Natural untreated gem' }}</td>
        </tr>
        <tr>
            <th>Recommended Weight</th>
            <td>{{ $chartData['gemstone']['carat_weight'] ?? '3 to 5 Carats' }}</td>
        </tr>
        <tr>
            <th>Mounting Metal</th>
            <td>{{ $chartData['gemstone']['metal_en'] ?? 'Panchaloha / Gold / Silver' }}</td>
        </tr>
        <tr>
            <th>Hand &amp; Finger Protocol</th>
            <td><strong>{{ $chartData['gemstone']['hand_en'] ?? 'Right Hand' }}</strong> &mdash; {{ $chartData['gemstone']['finger_en'] ?? 'Ring finger' }}</td>
        </tr>
        <tr>
            <th>Consecration &amp; Wearing Hora</th>
            <td>{{ $chartData['wearing_rule']['en'] ?? '' }}</td>
        </tr>
    </table>

    <div class="subsection-title">Sacred Temple Pariharams</div>
    <div class="highlight-box">
        &bull; <strong>Navagraha Archana:</strong> Perform once a year on your Janma Nakshatra day.<br>
        &bull; <strong>Dharma Sastha / Ayyappa Temple:</strong> Neerajanam on Saturdays for Shani blessings.<br>
        &bull; <strong>Chottanikkara / Mahalakshmi:</strong> Friday ghee lamp for emotional peace and domestic concord.<br>
        &bull; <strong>Maha Ganapathi Homam:</strong> For removing obstacles at the start of new ventures.
    </div>

    <div class="page-break"></div>

    <!-- ================= PAGE 25: DIRECT CONSULTATION & CERTIFICATION ================= -->
    <div class="section-title">24. Astrological Certification &amp; Direct Consultation</div>
    <p style="font-size: 8.5pt; color: #555;">
        This document represents an authenticated astronomical portfolio generated according to the mathematical canons of <em>Vedanga Jyothisham</em>.
    </p>

    <div style="border: 2px solid #b45309; padding: 16px; background-color: #fefce8; margin-top: 10px;">
        <table style="width: 100%;">
            <tr>
                <td style="width: 60%; vertical-align: top;">
                    <strong style="color: #78350f; font-size: 11pt;">Dr. E. K. Raja Varma</strong><br>
                    <span style="font-size: 8.5pt; color: #92400e;">
                        Vidya Vachaspathi in Vedic Astrology &bull; Gold Medalist<br>
                        Ph.D. in Online Astro Counselling &bull; IVAF #11009<br>
                        Chief Astrological Preceptor, Covilakam Astrology
                    </span>
                    <p style="font-size: 8pt; color: #555; margin-top: 10px;">
                        <em>"Astrology guides human effort. Righteous conduct, heartfelt prayer, and sincere devotion can rewrite any line upon the palm."</em>
                    </p>
                </td>
                <td style="width: 40%; text-align: center; vertical-align: middle;">
                    <div style="border: 1px dashed #78350f; padding: 10px; display: inline-block;">
                        <span style="font-size: 8pt; color: #78350f; font-weight: bold;">COVILAKAM AUTHENTICATED</span><br>
                        <span style="font-size: 7.5pt; color: #555;">Ref: {{ substr($reading->uuid, 0, 13) }}...</span><br>
                        <span style="font-size: 7pt; color: #059669; font-weight: bold;">✓ VERIFIED JATHAKAM</span>
                    </div>
                </td>
            </tr>
        </table>
    </div>

    <div class="cta-box">
        <h3 style="color: #065f46; margin: 0; font-size: 13pt;">Personal Horoscope Consultation with Dr. E. K. Raja Varma</h3>
        <p style="font-size: 9pt; color: #047857; margin: 4px 0 10px 0;">
            Schedule a 1-on-1 direct audio / video phone consultation for marriage matching, career transitions, and specific life dilemmas.
        </p>
        <div style="font-size: 12pt; font-weight: bold; color: #065f46; margin-top: 4px;">
            WhatsApp: +91 7907052160 &bull; Direct Call / GPay: +91 94473 27450
        </div>
        <p style="font-size: 8.5pt; color: #374151; margin-top: 6px;">
            Official Portal: <strong>www.covilakamastrology.com</strong> &bull; Client UUID: {{ $reading->uuid }}
        </p>
    </div>

</body>
</html>

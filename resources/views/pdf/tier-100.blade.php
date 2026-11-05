<!DOCTYPE html>
<html lang="en">
<head>
@php
    $targetLang = $lang ?? $reading->language ?? 'en';
    if (!in_array($targetLang, ['en', 'ml', 'ta', 'hi'], true)) {
        $targetLang = 'en';
    }

    $lagnaLong = (float)($chartData['lagna']['longitude'] ?? 0.0);
    $lagnaRasiIdx = (int)($chartData['lagna']['rasi_index'] ?? floor(fmod($lagnaLong + 360.0, 360.0) / 30.0) + 1);
    $lagnaRasiData = \App\Services\Astrology\PanchangaService::RASIS[$lagnaRasiIdx] ?? \App\Services\Astrology\PanchangaService::RASIS[1];
    $lagnaNameEn = $chartData['lagna']['name_en'] ?? $lagnaRasiData['name_en'];
    $lagnaNameMl = $chartData['lagna']['name_ml'] ?? $lagnaRasiData['name_ml'];
    $lagnaNameTa = $chartData['lagna']['name_ta'] ?? $lagnaRasiData['name_ta'];
    $lagnaNameHi = $chartData['lagna']['name_hi'] ?? $lagnaRasiData['name_hi'];
    $lagnaLocalized = match($targetLang) {
        'ml' => $lagnaNameMl,
        'ta' => $lagnaNameTa,
        'hi' => $lagnaNameHi,
        default => $lagnaNameEn,
    };

    $formatRasiHeader = function($idx) use ($targetLang) {
        $data = \App\Services\Astrology\PanchangaService::RASIS[$idx] ?? [];
        if ($targetLang === 'ml') {
            return $data['name_ml'] ?? $data['name_en'] ?? '';
        } elseif ($targetLang === 'ta') {
            return $data['name_ta'] ?? $data['name_en'] ?? '';
        } elseif ($targetLang === 'hi') {
            return $data['name_hi'] ?? $data['name_en'] ?? '';
        } else {
            return $data['name_en'] ?? '';
        }
    };
@endphp
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
            font-family: 'kartika', 'nirmala', 'dejavusans', sans-serif;
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
    @media print { .web-view-toolbar { display: none !important; } }
</style>
</head>
<body>
@if(!empty($isWebView))
<div class="web-view-toolbar" style="position: sticky; top: 0; left: 0; right: 0; background: #1c0d2e; color: #fff; padding: 10px 16px; display: flex; flex-wrap: wrap; align-items: center; justify-content: space-between; gap: 8px; z-index: 9999; border-bottom: 2px solid #b45309; box-shadow: 0 4px 15px rgba(0,0,0,0.5);">
    <div style="font-weight: bold; color: #fbbf24; font-size: 13px; display: flex; align-items: center; gap: 6px;">
        <span>📄</span>
        <span>Covilakam Astrology &bull; {{ $reading->full_name }}</span>
        <span style="font-size: 10px; background: rgba(245, 158, 11, 0.2); color: #fef08a; padding: 2px 6px; border-radius: 4px; border: 1px solid rgba(245, 158, 11, 0.4);">Certified Profile</span>
    </div>
    <div style="display: flex; flex-wrap: wrap; gap: 6px; align-items: center;">
        <span style="font-size: 11px; color: #d8b4fe; font-weight: bold; margin-right: 4px;">Language:</span>
        <a href="?lang=en{{ request('admin') ? '&admin=1' : '' }}{{ request('tier') ? '&tier=' . request('tier') : '' }}" style="color: {{ $targetLang === 'en' ? '#000' : '#fef08a' }}; background: {{ $targetLang === 'en' ? '#f59e0b' : '#372054' }}; padding: 4px 8px; border-radius: 6px; text-decoration: none; font-size: 11px; font-weight: bold;">English</a>
        <a href="?lang=ml{{ request('admin') ? '&admin=1' : '' }}{{ request('tier') ? '&tier=' . request('tier') : '' }}" style="color: {{ $targetLang === 'ml' ? '#000' : '#fef08a' }}; background: {{ $targetLang === 'ml' ? '#f59e0b' : '#372054' }}; padding: 4px 8px; border-radius: 6px; text-decoration: none; font-size: 11px; font-weight: bold;">മലയാളം</a>
        <a href="?lang=ta{{ request('admin') ? '&admin=1' : '' }}{{ request('tier') ? '&tier=' . request('tier') : '' }}" style="color: {{ $targetLang === 'ta' ? '#000' : '#fef08a' }}; background: {{ $targetLang === 'ta' ? '#f59e0b' : '#372054' }}; padding: 4px 8px; border-radius: 6px; text-decoration: none; font-size: 11px; font-weight: bold;">தமிழ்</a>
        <a href="?lang=hi{{ request('admin') ? '&admin=1' : '' }}{{ request('tier') ? '&tier=' . request('tier') : '' }}" style="color: {{ $targetLang === 'hi' ? '#000' : '#fef08a' }}; background: {{ $targetLang === 'hi' ? '#f59e0b' : '#372054' }}; padding: 4px 8px; border-radius: 6px; text-decoration: none; font-size: 11px; font-weight: bold;">हिन्दी</a>
        <button onclick="window.print()" style="background: #10b981; color: #000; border: none; padding: 5px 12px; border-radius: 6px; font-weight: bold; font-size: 11px; cursor: pointer;">🖨️ Print / Save</button>
        @php
            $safePdfName = trim(preg_replace('/[^A-Za-z0-9_\-]/', '_', $reading->full_name), '_');
            $safePdfName = preg_replace('/_+/', '_', $safePdfName) ?: 'Client';
        @endphp
        <a href="{{ route('astrology.reading.download-pdf', ['uuid' => $reading->uuid, 'lang' => $targetLang, 'tier' => request('tier', $reading->paid_tier), 'admin' => request('admin'), 'download' => 1]) }}" download="Covilakam_Certified_Profile_{{ $safePdfName }}_{{ strtoupper($targetLang) }}.pdf" style="background: linear-gradient(to right, #f59e0b, #eab308); color: #000; padding: 5px 12px; border-radius: 6px; font-weight: bold; font-size: 11px; text-decoration: none;">📥 Download PDF</a>
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
        <div style="font-size: 8.5pt; color: #b45309; font-weight: bold; margin-bottom: 4px;">
            @if($targetLang === 'ml')
                || ശ്രീ ഗുരുഭ്യോ നമഃ || ഓം നമഃ ശിവായ ||
            @elseif($targetLang === 'ta')
                || ஸ்ரீ குருப்யோ நமஹ || ஓம் நம சிவாய ||
            @elseif($targetLang === 'hi')
                || श्री गुरुभ्यो नमः || ॐ नमः शिवाय ||
            @else
                || Om Sri Gurubhyo Namah || Om Namah Shivaya ||
            @endif
        </div>
        <h1 class="gold-title">{{ $targetLang === 'ml' ? 'കോവിലകം ജ്യോതിഷം' : ($targetLang === 'ta' ? 'கோவிலகம் ஜோதிடம்' : ($targetLang === 'hi' ? 'कोविलकम ज्योतिष' : 'COVILAKAM ASTROLOGY')) }}</h1>
        <div class="gold-subtitle">{{ $targetLang === 'ml' ? 'സാക്ഷ്യപ്പെടുത്തിയ വേദാംഗ ജാതക കുറിപ്പും വിശകലനവും' : ($targetLang === 'ta' ? 'சான்றளிக்கப்பட்ட வேத ஜாதக விவரம்' : ($targetLang === 'hi' ? 'प्रमाणित वैदिक जन्म कुंडली विवरण' : 'CERTIFIED VEDIC BIRTH PROFILE & HOROSCOPE PORTFOLIO')) }}</div>
        <p style="margin-top: 8px; font-size: 9pt; color: #555;">
            {{ $targetLang === 'ml' ? 'ആചാര്യ സാക്ഷ്യപത്രം: ' : 'Authored & Certified by ' }}<strong>Dr. E. K. Raja Varma</strong> (Vidya Vachaspathi in Vedic Astrology, Gold Medalist &amp; Ph.D.)<br>
            Lifetime Member #11009, International Vedic Astrology Federation (IVAF)
        </p>
    </div>

    <div class="section-title">{{ $targetLang === 'ml' ? '1. ജാതക വിവരങ്ങളും പഞ്ചാംഗ തത്ത്വവും' : ($targetLang === 'ta' ? '1. ஜாதக விபரங்கள் மற்றும் பஞ்சாங்கம்' : ($targetLang === 'hi' ? '1. जातक विवरण एवं पंचांग तत्त्व' : '1. Jathaka Birth Particulars & Panchanga')) }}</div>
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
            <td><strong>{{ \Carbon\Carbon::parse($reading->birth_time)->format('h:i:s A') }}</strong> {{ $reading->is_approximate_time ? '(Approximate)' : '(Exact)' }}</td>
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
            <td>{{ $chartData['vara']['name_' . $targetLang] ?? $chartData['vara']['name_ml'] ?? $chartData['vara']['name_en'] ?? 'Auspicious' }}</td>
        </tr>
        <tr>
            <th>{{ $targetLang === 'ml' ? 'ലഗ്നം (Lagna)' : ($targetLang === 'ta' ? 'லக்னம் (Lagna)' : ($targetLang === 'hi' ? 'लग्न (Lagna)' : 'Lagna (Ascendant)')) }}</th>
            <td>
                <strong>{{ $lagnaLocalized }}</strong>
                @if($targetLang !== 'en')
                    <span style="font-size: 8pt; color: #78350f;">({{ $lagnaNameEn }})</span>
                @else
                    <span style="font-size: 8pt; color: #78350f;">({{ $lagnaNameMl }})</span>
                @endif
            </td>
            <th>Janma Rasi (Moon)</th>
            <td><strong>{{ $chartData['moon_sign']['name_' . $targetLang] ?? $chartData['moon_sign']['name_en'] ?? '' }}</strong>@if($targetLang !== 'ml') ({{ $chartData['moon_sign']['name_ml'] ?? '' }})@endif</td>
        </tr>
        <tr>
            <th>Janma Nakshatra</th>
            <td><strong>{{ $chartData['nakshatra']['name_' . $targetLang] ?? $chartData['nakshatra']['name_en'] ?? '' }}</strong> (Pada {{ $chartData['nakshatra']['pada'] ?? '1' }})</td>
            <th>Surya Rasi (Sun)</th>
            <td><strong>{{ $chartData['solar_sign']['name_' . $targetLang] ?? $chartData['solar_sign']['name_en'] ?? '' }}</strong>@if($targetLang !== 'ml') ({{ $chartData['solar_sign']['name_ml'] ?? '' }})@endif</td>
        </tr>
        <tr>
            <th>Birth Tithi</th>
            <td>{{ $chartData['tithi']['name_' . $targetLang] ?? $chartData['tithi']['name_ml'] ?? $chartData['tithi']['name_en'] ?? '' }}</td>
            <th>Nityayoga &amp; Karana</th>
            <td>{{ $targetLang === 'ml' ? 'ധൃതി (Dhruti)' : ($chartData['nityayoga']['name_' . $targetLang] ?? $chartData['nityayoga']['name_en'] ?? 'Dhriti') }} / {{ $chartData['karana']['name_' . $targetLang] ?? $chartData['karana']['name_ml'] ?? $chartData['karana']['name_en'] ?? '' }}</td>
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
    <div class="section-title">{{ $targetLang === 'ml' ? '2. രാശി ചക്രം - ദക്ഷിണേന്ത്യൻ രീതി (D1 Rasi Chakra)' : ($targetLang === 'ta' ? '2. ராசி சக்கரம் (D1)' : ($targetLang === 'hi' ? '2. राशि चक्र (D1)' : '2. South Indian Sidereal Rasi Chakra (D1)')) }}</div>
    <p style="font-size: 8.5pt; color: #555; margin-top: 0;">
        Constructed strictly according to the fixed-Rasi South Indian format using Chitrapaksha (Lahiri) Ayanamsa.
    </p>

    <table class="chart-grid">
        <tr>
            <td class="chart-cell {{ $lagnaRasiIdx === 12 ? 'lagna-cell' : '' }}">
                <strong>{{ $formatRasiHeader(12) }}</strong><br>
                @foreach($chartData['chart_grid_d1'][12] ?? [] as $pl)
                    <span style="color:#b45309; font-weight:bold;">{{ $pl['label'] }}</span><br>
                @endforeach
            </td>
            <td class="chart-cell {{ $lagnaRasiIdx === 1 ? 'lagna-cell' : '' }}">
                <strong>{{ $formatRasiHeader(1) }}</strong><br>
                @foreach($chartData['chart_grid_d1'][1] ?? [] as $pl)
                    <span style="color:#b45309; font-weight:bold;">{{ $pl['label'] }}</span><br>
                @endforeach
            </td>
            <td class="chart-cell {{ $lagnaRasiIdx === 2 ? 'lagna-cell' : '' }}">
                <strong>{{ $formatRasiHeader(2) }}</strong><br>
                @foreach($chartData['chart_grid_d1'][2] ?? [] as $pl)
                    <span style="color:#b45309; font-weight:bold;">{{ $pl['label'] }}</span><br>
                @endforeach
            </td>
            <td class="chart-cell {{ $lagnaRasiIdx === 3 ? 'lagna-cell' : '' }}">
                <strong>{{ $formatRasiHeader(3) }}</strong><br>
                @foreach($chartData['chart_grid_d1'][3] ?? [] as $pl)
                    <span style="color:#b45309; font-weight:bold;">{{ $pl['label'] }}</span><br>
                @endforeach
            </td>
        </tr>
        <tr>
            <td class="chart-cell {{ $lagnaRasiIdx === 11 ? 'lagna-cell' : '' }}">
                <strong>{{ $formatRasiHeader(11) }}</strong><br>
                @foreach($chartData['chart_grid_d1'][11] ?? [] as $pl)
                    <span style="color:#b45309; font-weight:bold;">{{ $pl['label'] }}</span><br>
                @endforeach
            </td>
            <td class="chart-cell chart-center" colspan="2" rowspan="2">
                <span style="font-size: 13pt; color: #78350f;">
                    @if($targetLang === 'ml') രാശി ചക്രം (D1) @elseif($targetLang === 'ta') ராசி சக்கரம் (D1) @elseif($targetLang === 'hi') राशि चक्र (D1) @else RASI CHAKRA (D1) @endif
                </span><br>
                <span style="font-size: 9pt; color: #92400e;">RASI KUNDALI</span><br>
                <span style="font-size: 8pt; color: #555;">{{ $reading->full_name }}</span><br>
                <span style="font-size: 8pt; color: #b45309;">
                    <strong>{{ $targetLang === 'ml' ? 'ലഗ്നം' : ($targetLang === 'ta' ? 'லக்னம்' : ($targetLang === 'hi' ? 'लग्न' : 'Lagna')) }}:</strong> {{ $lagnaLocalized }}
                </span>
            </td>
            <td class="chart-cell {{ $lagnaRasiIdx === 4 ? 'lagna-cell' : '' }}">
                <strong>{{ $formatRasiHeader(4) }}</strong><br>
                @foreach($chartData['chart_grid_d1'][4] ?? [] as $pl)
                    <span style="color:#b45309; font-weight:bold;">{{ $pl['label'] }}</span><br>
                @endforeach
            </td>
        </tr>
        <tr>
            <td class="chart-cell {{ $lagnaRasiIdx === 10 ? 'lagna-cell' : '' }}">
                <strong>{{ $formatRasiHeader(10) }}</strong><br>
                @foreach($chartData['chart_grid_d1'][10] ?? [] as $pl)
                    <span style="color:#b45309; font-weight:bold;">{{ $pl['label'] }}</span><br>
                @endforeach
            </td>
            <td class="chart-cell {{ $lagnaRasiIdx === 5 ? 'lagna-cell' : '' }}">
                <strong>{{ $formatRasiHeader(5) }}</strong><br>
                @foreach($chartData['chart_grid_d1'][5] ?? [] as $pl)
                    <span style="color:#b45309; font-weight:bold;">{{ $pl['label'] }}</span><br>
                @endforeach
            </td>
        </tr>
        <tr>
            <td class="chart-cell {{ $lagnaRasiIdx === 9 ? 'lagna-cell' : '' }}">
                <strong>{{ $formatRasiHeader(9) }}</strong><br>
                @foreach($chartData['chart_grid_d1'][9] ?? [] as $pl)
                    <span style="color:#b45309; font-weight:bold;">{{ $pl['label'] }}</span><br>
                @endforeach
            </td>
            <td class="chart-cell {{ $lagnaRasiIdx === 8 ? 'lagna-cell' : '' }}">
                <strong>{{ $formatRasiHeader(8) }}</strong><br>
                @foreach($chartData['chart_grid_d1'][8] ?? [] as $pl)
                    <span style="color:#b45309; font-weight:bold;">{{ $pl['label'] }}</span><br>
                @endforeach
            </td>
            <td class="chart-cell {{ $lagnaRasiIdx === 7 ? 'lagna-cell' : '' }}">
                <strong>{{ $formatRasiHeader(7) }}</strong><br>
                @foreach($chartData['chart_grid_d1'][7] ?? [] as $pl)
                    <span style="color:#b45309; font-weight:bold;">{{ $pl['label'] }}</span><br>
                @endforeach
            </td>
            <td class="chart-cell {{ $lagnaRasiIdx === 6 ? 'lagna-cell' : '' }}">
                <strong>{{ $formatRasiHeader(6) }}</strong><br>
                @foreach($chartData['chart_grid_d1'][6] ?? [] as $pl)
                    <span style="color:#b45309; font-weight:bold;">{{ $pl['label'] }}</span><br>
                @endforeach
            </td>
        </tr>
    </table>

    <div class="section-title">{{ $targetLang === 'ml' ? '3. വിംശോത്തരി ദശാപഹാര ക്രമവും നിലവിലെ കാലഘട്ടവും' : ($targetLang === 'ta' ? '3. விம்சொத்தரி தசா-புத்தி கால கணிதம்' : ($targetLang === 'hi' ? '3. विंशोत्तरी दशा चक्र एवं वर्तमान काल' : '3. Vimshottari Dasha Balance & Current Timeline')) }}</div>
    <div class="highlight-box">
        <strong>{{ $targetLang === 'ml' ? 'ജനന സമയത്തെ ദശാശിഷ്ടം (ഗർഭശിഷ്ട ദശ):' : ($targetLang === 'ta' ? 'கர்ப்பசிஷ்ட தசா இருப்பு:' : ($targetLang === 'hi' ? 'जन्म कालीन दशा शेष (गर्भशिष्ट दशा):' : 'Opening Balance of Dasha at Birth (Garbhashishta Dasha):')) }}</strong><br>
        @if($targetLang === 'ml')
            {{ $chartData['garbhashishta']['summary_ml'] ?? $chartData['garbhashishta']['summary_en'] ?? '' }}
        @elseif($targetLang === 'ta')
            {{ $chartData['garbhashishta']['summary_ta'] ?? $chartData['garbhashishta']['summary_en'] ?? '' }}
        @elseif($targetLang === 'hi')
            {{ $chartData['garbhashishta']['summary_hi'] ?? $chartData['garbhashishta']['summary_en'] ?? '' }}
        @else
            {{ $chartData['garbhashishta']['summary_en'] ?? '' }}
        @endif
    </div>

    <table class="table-data">
        <tr>
            <th style="width: 35%;">{{ $targetLang === 'ml' ? 'നിലവിലെ മഹാദശ' : 'Active Mahadasha' }}</th>
            <td><strong>{{ $chartData['active_dasha']['mahadasha_' . $targetLang] ?? $chartData['active_dasha']['mahadasha'] ?? '' }}</strong> @if($targetLang !== 'en' && !empty($chartData['active_dasha']['mahadasha'])) ({{ $chartData['active_dasha']['mahadasha'] }}) @endif</td>
        </tr>
        <tr>
            <th>{{ $targetLang === 'ml' ? 'നിലവിലെ അപഹാരം (അന്തർദശ)' : 'Active Apahara (Antardasha)' }}</th>
            <td><strong>{{ $chartData['active_dasha']['apahara_' . $targetLang] ?? $chartData['active_dasha']['apahara'] ?? '' }}</strong> @if($targetLang !== 'en' && !empty($chartData['active_dasha']['apahara'])) ({{ $chartData['active_dasha']['apahara'] }}) @endif</td>
        </tr>
        <tr>
            <th>{{ $targetLang === 'ml' ? 'കാലഘട്ടം' : 'Active Period Range' }}</th>
            <td>{{ $chartData['active_dasha']['start_date'] ?? '' }} to {{ $chartData['active_dasha']['end_date'] ?? '' }}</td>
        </tr>
    </table>

    <div class="page-break"></div>

    <!-- ================= PAGE 3: PERSONALITY & BHAVAS ================= -->
    <div class="section-title">
        {{ $targetLang === 'ml' ? '4. വ്യക്തിത്വവും ഒന്നാം ഭാവവും (ലഗ്ന വിചാരം)' : ($targetLang === 'ta' ? '4. லக்ன பலன் மற்றும் ஆளுமை' : ($targetLang === 'hi' ? '4. लग्न विचार एवं व्यक्तित्व' : '4. Core Personality & 1st House (Lagna) Analysis')) }}
    </div>
    <p>
        @if($targetLang === 'ml')
            ലഗ്നമായ <strong>{{ $lagnaLocalized }}</strong> കൊണ്ടും ജന്മനക്ഷത്രമായ <strong>{{ $chartData['nakshatra']['name_ml'] ?? $chartData['nakshatra']['name_en'] ?? '' }}</strong> കൊണ്ടും ഉദാത്തമായ വ്യക്തിത്വവും നിശ്ചയദാർഢ്യവും ആത്മവിശ്വാസവുമുള്ള പ്രകൃതമാണ്. ധാർമ്മികമായ കർമ്മങ്ങളിലൂടെയും സ്വന്തം പരിശ്രമത്തിലൂടെയും ജീവിതത്തിൽ ഉയർന്ന വിജയം കൈവരിക്കും.
        @elseif($targetLang === 'ta')
            லக்னம் <strong>{{ $lagnaLocalized }}</strong> மற்றும் ஜென்ம நட்சத்திரம் <strong>{{ $chartData['nakshatra']['name_ta'] ?? $chartData['nakshatra']['name_en'] ?? '' }}</strong> அமைப்பால் உறுதியான மனோதிடமும் நற்பண்புகளும் கொண்டவர். விடாமுயற்சியால் வாழ்வில் வெற்றி பெறுவீர்கள்.
        @elseif($targetLang === 'hi')
            लग्न <strong>{{ $lagnaLocalized }}</strong> एवं जन्म नक्षत्र <strong>{{ $chartData['nakshatra']['name_hi'] ?? $chartData['nakshatra']['name_en'] ?? '' }}</strong> के प्रभाव से आपका व्यक्तित्व ओजस्वी, दृढ़संकल्प एवं स्वाभिमानी है। नैतिक आचरण एवं सतत परिश्रम से जीवन में सफलता प्राप्त होगी।
        @else
            Governed by <strong>{{ $lagnaLocalized }}</strong> Ascendant and Janma Nakshatra <strong>{{ $chartData['nakshatra']['name_en'] ?? '' }}</strong>, you possess an innate vitality, noble bearing, and determined will. Your soul purpose is driven by ethical perseverance and independent initiative.
        @endif
    </p>

    <div class="section-title">
        {{ $targetLang === 'ml' ? '5. ധന ഭാവം: സാമ്പത്തിക വളർച്ച, വാക്ക് & കുടുംബം' : ($targetLang === 'ta' ? '5. இரண்டாம் பாவம்: தனம், வாக்கு, குடும்பம்' : ($targetLang === 'hi' ? '5. द्वितीय भाव: धन, वाणी एवं पारिवारिक सुख' : '5. 2nd House: Wealth, Speech & Family Heritage')) }}
    </div>
    <p>
        @if($targetLang === 'ml')
            രണ്ടാം ഭാവം സമ്പത്ത്, വാക്ചാതുര്യം, കുടുംബ പാരമ്പര്യം എന്നിവയെ സൂചിപ്പിക്കുന്നു. ചിട്ടയായ സാമ്പത്തിക ആസൂത്രണത്തിലൂടെയും സത്യസന്ധവും വിവേകപൂർണ്ണവുമായ വാക്കുകളിലൂടെയും ധനാഭിവൃദ്ധിയും കുടുംബസമാധാനവും കൈവരിക്കാൻ സാധിക്കും.
        @else
            The 2nd Bhava signifies accumulated assets, eloquence, and culinary habits.
            @if(!empty($chartData['vedanga_predictions']['bhava_analysis']['wealth_sources']))
                <br><strong>Key Sources of Wealth Growth:</strong>
                <ul>
                    @foreach($chartData['vedanga_predictions']['bhava_analysis']['wealth_sources'] as $ws)
                        <li>{{ is_array($ws) ? ($ws[$targetLang] ?? $ws['en'] ?? reset($ws)) : $ws }}</li>
                    @endforeach
                </ul>
            @else
                Your financial path thrives through disciplined investment, professional self-reliance, and diplomatic communication.
            @endif
        @endif
    </p>

    <div class="section-title">
        {{ $targetLang === 'ml' ? '6. കർമ്മ ഭാവം: തൊഴിൽ, ഔദ്യോഗിക പദവി & നേതൃത്വം' : ($targetLang === 'ta' ? '6. பத்தாம் பாவம்: தொழில் மற்றும் தலைமை யோகம்' : ($targetLang === 'hi' ? '6. दशम भाव: आजीविका, पद प्रतिष्ठा एवं नेतृत्व' : '6. 10th House: Karma & Professional Prominence')) }}
    </div>
    <p>
        @if($targetLang === 'ml')
            പത്താം ഭാവം സാമൂഹിക പ്രശസ്തി, ഉദ്യോഗ നേതൃത്വം, കർമ്മവിജയം എന്നിവയെ പ്രതിനിധാനം ചെയ്യുന്നു. ഭരണപരമായ മേൽനോട്ടം, സ്വന്തം തീരുമാനങ്ങളെടുക്കാനുള്ള സ്വാതന്ത്ര്യം, ഉത്തരവാദിത്തമുള്ള സ്ഥാനങ്ങൾ എന്നിവയിൽ പ്രാഗത്ഭ്യം തെളിയിക്കും.
        @else
            The 10th house governs public reputation, career authority, and executive leadership. Your professional horizon favors leadership responsibilities where independent planning and visionary execution are recognized.
        @endif
    </p>

    <div class="page-break"></div>

    <!-- ================= PAGE 4: TRANSITS (GOCHARA) ================= -->
    <div class="section-title">{{ $targetLang === 'ml' ? '7. നിലവിലെ ഗോചര ഫലങ്ങളും ശനി ചിന്തയും' : ($targetLang === 'ta' ? '7. நடப்பு கோசார பலன்கள் மற்றும் சனி ஆய்வு' : ($targetLang === 'hi' ? '7. वर्तमान गोचर फलादेश एवं शनि शांति' : '7. Current Planetary Transits (Gocharaphala)')) }}</div>
    <p style="font-size: 8.5pt; color: #555;">
        {{ $targetLang === 'ml' ? 'ജനനസമയത്തെ ചന്ദ്രരാശിയെ അടിസ്ഥാനമാക്കി നിലവിലെ പ്രധാന ഗ്രഹങ്ങളുടെ ഗോചര സഞ്ചാരഫലങ്ങൾ.' : 'Calculated from natal Chandra Rasi including classical Gochara &amp; Vedha checks.' }}
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
    <div class="section-title">{{ $targetLang === 'ml' ? '8. ശാസ്ത്രീയ ഭാഗ്യരത്ന നിർണ്ണയവും ധാരണ വിധിയും' : ($targetLang === 'ta' ? '8. அதிர்ஷ்ட ரத்தினம் மற்றும் அணியும் முறை' : ($targetLang === 'hi' ? '8. वैज्ञानिक भाग्य रत्न चयन एवं धारण विधि' : '8. Scientific Gemstone Prescription & Wearing Rules')) }}</div>
    <p>
        {{ $targetLang === 'ml' ? 'ത്രികോണാധിപന്മാരുടെയും (1, 5, 9 ഭാവങ്ങൾ) ഗ്രഹബലത്തിന്റെയും അടിസ്ഥാനത്തിൽ നിശ്ചയിച്ച ഭാഗ്യരത്നം:' : 'Prescribed according to Trine Lordship (Houses 1, 5, 9) and Classical Vedic rules:' }}
    </p>

    <table class="table-data">
        <tr>
            <th style="width: 35%;">Primary Ratna (Gemstone)</th>
            <td><strong style="color: #b45309; font-size: 11pt;">{{ $chartData['gemstone_en'] ?? '' }}</strong>@if($targetLang !== 'ml') ({{ $chartData['gemstone_ml'] ?? '' }})@endif</td>
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
        <h3 style="color: #065f46; margin: 0; font-size: 13pt;">
            {{ $targetLang === 'ml' ? 'ഡോ. ഇ. കെ. രാജവർമ്മയുമായി നേരിട്ടുള്ള കൂടിയാലോചന' : ($targetLang === 'ta' ? 'டாக்டர் ஈ. கே. ராஜ வர்மாவுடன் நேரடி ஆலோசனை' : ($targetLang === 'hi' ? 'डॉ. ई. के. राजा वर्मा से प्रत्यक्ष परामर्श' : 'Direct Consultation with Dr. E. K. Raja Varma')) }}
        </h3>
        <p style="font-size: 9pt; color: #047857; margin: 4px 0 10px 0;">
            {{ $targetLang === 'ml' ? 'വേദ ജ്യോതിഷത്തിൽ വിദ്യാവാചസ്പതി • ഗോൾഡ് മെഡലിസ്റ്റ് • പി.എച്ച്.ഡി (ഓൺലൈൻ ആസ്ട്രോ കൗൺസിലിംഗ്)' : 'Vidya Vachaspathi in Vedic Astrology • Gold Medalist • Ph.D. (Online Astro Counselling)' }}
        </p>
        <p style="font-size: 9.5pt; color: #1f2937;">
            {{ $targetLang === 'ml' ? 'സമ്പൂർണ്ണ ജാതക നിരൂപണം, വിവാഹപ്പൊരുത്തം, ദോഷപരിഹാരങ്ങൾ, രത്നധാരണ നിർദ്ദേശങ്ങൾ എന്നിവയ്ക്കായി ബന്ധപ്പെടുക:' : 'For in-depth horoscope analysis, marital matchmaking, life pariharams, and customized gem guidance:' }}
        </p>
        <div style="font-size: 12pt; font-weight: bold; color: #065f46; margin-top: 6px;">
            WhatsApp: +91 7907052160 &bull; Phone / GPay: +91 94473 27450
        </div>
        <p style="font-size: 8pt; color: #6b7280; margin-top: 4px;">
            Reading Reference UUID: {{ $reading->uuid }} &bull; www.covilakamastrology.com
        </p>
    </div>

@if(request('print'))
<script>
    window.addEventListener('load', function() {
        setTimeout(function() { window.print(); }, 400);
    });
</script>
@endif

</body>
</html>


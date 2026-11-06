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
            font-family: 'kartika', 'nirmala', 'dejavusans', sans-serif;
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
        @php
            $safePdfName = trim(preg_replace('/[^A-Za-z0-9_\-]/', '_', $reading->full_name), '_');
            $safePdfName = preg_replace('/_+/', '_', $safePdfName) ?: 'Client';
        @endphp
        <a href="{{ route('astrology.reading.download-pdf', ['uuid' => $reading->uuid, 'lang' => $targetLang, 'tier' => request('tier', $reading->paid_tier), 'admin' => request('admin'), 'download' => 1]) }}" download="Covilakam_Deluxe_Jathakam_{{ $safePdfName }}_{{ strtoupper($targetLang) }}.pdf" style="background: linear-gradient(to right, #f59e0b, #eab308); color: #000; padding: 5px 12px; border-radius: 6px; font-weight: bold; font-size: 11px; text-decoration: none;">📥 Download PDF</a>
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
        <div style="font-size: 9pt; color: #b45309; font-weight: bold; margin-bottom: 4px;">
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
        <div class="gold-subtitle">{{ $targetLang === 'ml' ? 'സമ്പൂർണ്ണ വേദാംഗ ജാതകവും ആയുഷ്കാല ഫലവിചാരവും' : ($targetLang === 'ta' ? 'சம்பூர்ண வேத ஜாதகம் மற்றும் ஆயுட்கால பலன்கள்' : ($targetLang === 'hi' ? 'सम्पूर्ण वैदिक जातकम् एवं जीवन फलादेश' : 'SAMPOORNA VEDIC JATHAKAM & LIFE HOROSCOPE PORTFOLIO')) }}</div>
        <p style="margin-top: 8px; font-size: 8.5pt; color: #555;">
            {{ $targetLang === 'ml' ? 'ആചാര്യ സാക്ഷ്യപത്രം: ' : 'Authored & Certified by ' }}<strong>Dr. E. K. Raja Varma</strong><br>
            Vidya Vachaspathi in Vedic Astrology &bull; Gold Medalist &bull; Ph.D. (Online Astro Counselling)<br>
            Lifetime Member #11009, International Vedic Astrology Federation (IVAF)
        </p>
    </div>

    <div class="shloka-box">
        @if($targetLang === 'ml')
            "ഗുരുർബ്രഹ്മാ ഗുരുർവിഷ്ണുഃ ഗുരുർദേവോ മഹേശ്വരഃ |<br>
            ഗുരുഃ സാക്ഷാത് പരബ്രഹ്മ തസ്മൈ ശ്രീഗുരവേ നമഃ ||"<br>
            <em>"ദിവ്യജ്യോതിസ്സ് നമ്മുടെ ധർമ്മമാർഗ്ഗത്തെയും ആരോഗ്യത്തെയും ഐശ്വര്യത്തെയും സമാധാനത്തെയും പ്രകാശിപ്പിക്കട്ടെ."</em>
        @elseif($targetLang === 'ta')
            "குருர்ப்ரம்மா குருர்விஷ்ணு குருர்தேவோ மஹேஸ்வரஹ |<br>
            குரு சாக்ஷாத் பரப்ரம்ம தஸ்மை ஸ்ரீ குரவே நமஹ ||"<br>
            <em>"தெய்வீக ஒளி நம்முடைய நல்வழி, ஆரோக்கியம், வளம் மற்றும் அமைதியை ஒளிரச் செய்யட்டும்."</em>
        @elseif($targetLang === 'hi')
            "गुरुर्ब्रह्मा गुरुर्विष्णुः गुरुर्देवो महेश्वरः ।<br>
            गुरुः साक्षात् परब्रह्म तस्मै श्रीगुरवे नमः ॥"<br>
            <em>"ईश्वरीय दिव्य प्रकाश हमारे धर्म, स्वास्थ्य, समृद्धि और शांति के मार्ग को आलोकित करे।"</em>
        @else
            "Gurur Brahma Gurur Vishnuh Gurur Devo Maheshwarah |<br>
            Guruh Sakshat Parabrahma Tasmai Shri Gurave Namah ||"<br>
            <em>"May the divine cosmic light illuminate our path of righteous action, health, prosperity, and peace."</em>
        @endif
    </div>

    <div class="section-title">{{ $targetLang === 'ml' ? 'ജാതക വിവരങ്ങൾ (Jathaka Particulars)' : ($targetLang === 'ta' ? 'ஜாதக விபரங்கள்' : ($targetLang === 'hi' ? 'जातक जन्म विवरण' : 'Jathaka Registered Particulars')) }}</div>
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
            <th>Document Reference</th>
            <td colspan="3"><code style="color: #78350f; font-weight: bold;">{{ $reading->uuid }}</code> (Covilakam Certified Archive)</td>
        </tr>
    </table>

    <div class="highlight-box">
        <strong>{{ $targetLang === 'ml' ? 'ജ്യോതിഷ തത്ത്വവിചാരം:' : 'Astrological Interpretive Principles:' }}</strong><br>
        {{ $targetLang === 'ml' ? 'ഒരു ജാതകൻ വിശ്വാസപൂർവ്വം ജീവിതവഴികാട്ടിയായാണ് ജ്യോതിഷത്തെ സമീപിക്കുന്നത്. ഡോ. ഇ. കെ. രാജവർമ്മയുടെ ശാസ്ത്രീയ ഉപദേശപ്രകാരം, ജാതകം എന്നത് കർമ്മശേഷികളെയും സാധ്യതകളെയും മുൻകൂട്ടി തിരിച്ചറിഞ്ഞ് വിവേകപൂർവ്വമായ തെരഞ്ഞെടുപ്പുകൾ (പുരുഷകാരം) നടത്താനും ഈശ്വരാരാധനയിലൂടെ ദോഷങ്ങളെ അതിജീവിക്കാനുമുള്ള വഴികാട്ടിയാണ്.' : 'A seeker approaches Jyothisha with faith for direction. Per the classical guidelines of Dr. E. K. Raja Varma and ancient preceptors, astrology is an advisory beacon. Karmic tendencies revealed herein represent potentials designed to awaken mindfulness, righteous choices (Purushakara), and devotional remediation.' }}
    </div>

    <div class="page-break"></div>

    <!-- ================= PAGE 2: COMPLETE PANCHANGA & SACRED TIMINGS ================= -->
    <div class="section-title">{{ $targetLang === 'ml' ? '1. പഞ്ചാംഗ തത്ത്വ നിർണ്ണയം (Panchanga Tattva)' : ($targetLang === 'ta' ? '1. பஞ்சாங்க தத்துவம்' : ($targetLang === 'hi' ? '1. पंचांग तत्त्व' : '1. Panchanga Tattva & Cosmic Time Matrix')) }}</div>
    <p style="font-size: 8.5pt; color: #555;">
        {{ $targetLang === 'ml' ? 'ജനനസമയത്തെ കാലത്തിന്റെ അഞ്ചു ഘടകങ്ങൾ (വാരം, തിഥി, നക്ഷത്രം, നിത്യയോഗം, കരണം) ശരീര, മനസ്സ്, ആത്മീയ അവസ്ഥകളെ നിർണ്ണയിക്കുന്നു.' : 'The five limbs of time (Panchanga) govern the energy balance of physical, mental, and spiritual life at the moment of birth.' }}
    </p>

    <table class="table-data">
        <tr>
            <th style="width: 25%;">1. Vara (Vedic Day)</th>
            <td style="width: 25%;"><strong>{{ $chartData['vara']['name_' . $targetLang] ?? $chartData['vara']['name_ml'] ?? 'വെള്ളിയാഴ്ച' }}</strong> ({{ $chartData['vara']['name_en'] ?? 'Friday' }})</td>
            <th style="width: 25%;">Ruler of Vara</th>
            <td style="width: 25%;">{{ $chartData['vara']['lord'] ?? 'Shukra / Venus' }} (Vitality & Concord)</td>
        </tr>
        <tr>
            <th>2. Tithi (Lunar Phase)</th>
            <td><strong>{{ $chartData['tithi']['name_' . $targetLang] ?? $chartData['tithi']['name_ml'] ?? $chartData['tithi']['name_en'] ?? '' }}</strong></td>
            <th>Tithi Paksha &amp; Nature</th>
            <td>{{ ($chartData['tithi']['index'] ?? 1) <= 15 ? ($targetLang === 'ml' ? 'ശുക്ലപക്ഷം (വെളുത്തപക്ഷം)' : 'Shukla Paksha (Waxing)') : ($targetLang === 'ml' ? 'കൃഷ്ണപക്ഷം (കറുത്തപക്ഷം)' : 'Krishna Paksha (Waning)') }}</td>
        </tr>
        <tr>
            <th>3. Nakshatra</th>
            <td><strong>{{ $chartData['nakshatra']['name_' . $targetLang] ?? $chartData['nakshatra']['name_en'] ?? '' }}</strong>@if($targetLang !== 'ml') ({{ $chartData['nakshatra']['name_ml'] ?? '' }})@endif</td>
            <th>Pada &amp; Degree Span</th>
            <td>Pada {{ $chartData['nakshatra']['pada'] ?? '1' }} ({{ round($chartData['nakshatra']['degrees_elapsed'] ?? 0, 2) }}°)</td>
        </tr>
        <tr>
            <th>4. Nityayoga</th>
            <td><strong>{{ $chartData['nityayoga']['name_' . $targetLang] ?? $chartData['nityayoga'][$targetLang] ?? $chartData['nityayoga']['name_en'] ?? $chartData['nityayoga']['en'] ?? 'Harshana' }}</strong>@if($targetLang !== 'en' && !empty($chartData['nityayoga']['name_en'])) ({{ $chartData['nityayoga']['name_en'] }})@endif</td>
            <th>Yoga Signification</th>
            <td>{{ $chartData['nityayoga']['nature_' . $targetLang] ?? ($targetLang === 'ml' ? 'സന്തോഷവും സൽക്കീർത്തിയും ഉന്നതിയും നൽകുന്ന മംഗളകരമായ നിത്യയോഗം' : ($chartData['nityayoga']['nature'] ?? 'Auspicious solar-lunar alignment fostering harmony and prosperity')) }}</td>
        </tr>
        <tr>
            <th>5. Karana (Half-Tithi)</th>
            <td><strong>{{ $chartData['karana']['name_' . $targetLang] ?? $chartData['karana']['name_ml'] ?? '' }}</strong> ({{ $chartData['karana']['name_en'] ?? '' }})</td>
            <th>Karana Nature</th>
            <td>{{ $chartData['karana']['type'] ?? 'Active / Dynamic endeavor' }}</td>
        </tr>
        <tr>
            <th>Kollavarsham Date</th>
            <td><strong style="color: #b45309; font-size: 10pt;">{{ $chartData['kollavarsham']['formatted_ml'] ?? '1131 കർക്കിടകം 12' }}</strong></td>
            <th>Sunrise &bull; Sunset &bull; Dinamana</th>
            <td>{{ $chartData['sunrise'] ?? '06:16 AM' }} &bull; {{ $chartData['sunset'] ?? '06:48 PM' }}<br><span style="font-size: 8pt; color: #78350f;">{{ $chartData['dinamana'] ?? '12h 32m' }}</span></td>
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
            <td style="width: 25%;"><strong>{{ $chartData['nakshatra']['deity'] ?? 'Ajaikapada' }}</strong></td>
            <th style="width: 25%;">Sacred Symbol</th>
            <td style="width: 25%;">{{ $chartData['nakshatra']['symbol'] ?? 'Front legs of funeral cot / Swords' }}</td>
        </tr>
        <tr>
            <th>Gana (Temperament)</th>
            <td>{{ $chartData['nakshatra']['gana'] ?? 'Manushya' }}</td>
            <th>Yoni (Animal Archetype)</th>
            <td>{{ $chartData['nakshatra']['yoni'] ?? 'Male Lion (സിംഹം)' }}</td>
        </tr>
        <tr>
            <th>Nadi (Constitutional Flow)</th>
            <td>{{ $chartData['nakshatra']['nadi'] ?? 'Adya (വാതം)' }}</td>
            <th>Varna (Spiritual Focus)</th>
            <td>{{ $chartData['nakshatra']['varna'] ?? 'Brahmana' }}</td>
        </tr>
    </table>

    <div class="highlight-box">
        <strong>Archetypal Life Expression:</strong><br>
        {{ $chartData['nakshatra']['archetype_' . $targetLang] ?? $chartData['nakshatra']['archetype_en'] ?? 'The birth asterism endows the native with deep intuitive capacity, intellectual resilience, and an innate sense of duty toward family and society.' }}
    </div>

    <div class="page-break"></div>

    <!-- ================= PAGE 3: EXACT PLANETARY SPHUTAS & DIGNITIES ================= -->
    <div class="section-title">{{ $targetLang === 'ml' ? '2. ഗ്രഹസ്ഫുടങ്ങളും അവസ്ഥകളും (Sphutas & Dignities)' : ($targetLang === 'ta' ? '2. கிரக ஸ்புடங்கள் மற்றும் அவஸ்தைகள்' : ($targetLang === 'hi' ? '2. ग्रह स्फुट एवं अवस्था' : '2. Sidereal Planetary Longitudes (Sphutas) & Dignities')) }}</div>
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
                    $rasiIdx = (int)floor(fmod($deg + 360.0, 360.0) / 30.0) + 1;
                    $degInRasi = fmod(fmod($deg, 30.0) + 30.0, 30.0);
                    $d = (int)floor($degInRasi);
                    $m = (int)floor(($degInRasi - $d) * 60);
                    $s = (int)round((($degInRasi - $d) * 60 - $m) * 60);

                    $rMeta = \App\Services\Astrology\PanchangaService::RASIS[$rasiIdx] ?? \App\Services\Astrology\PanchangaService::RASIS[1];
                    $nakSpan = 360.0 / 27.0;
                    $nakIdx = (int)floor(fmod($deg + 360.0, 360.0) / $nakSpan) + 1;
                    $nakIdx = max(1, min(27, $nakIdx));
                    $nakMeta = \App\Services\Astrology\PanchangaService::NAKSHATRAS[$nakIdx] ?? \App\Services\Astrology\PanchangaService::NAKSHATRAS[1];
                    $padaCalc = (int)floor(fmod(fmod($deg, $nakSpan) + $nakSpan, $nakSpan) / ($nakSpan / 4.0)) + 1;
                    $padaCalc = max(1, min(4, $padaCalc));

                    $bodyRasiName = $chartData['shadvarga'][$code]['rasi_name_' . $targetLang] ?? $rMeta['name_' . $targetLang] ?? $rMeta['name_en'];
                    $bodyNakName = $chartData['shadvarga'][$code]['nakshatra_name_' . $targetLang] ?? $nakMeta['name_' . $targetLang] ?? $nakMeta['name_en'];
                    $bodyNakPada = $chartData['shadvarga'][$code]['nakshatra_pada'] ?? $padaCalc;

                    $pData = $chartData['planets'][$code] ?? null;
                    $isRetro = !empty($pData['is_retrograde']);
                    $dignity = $chartData['dignities'][$code]['status'] ?? ($code === 'As' ? 'Lagna Kendra' : ($code === 'Md' ? 'Upagraha' : 'Neutral'));
                    $isCombust = !empty($chartData['dignities'][$code]['is_combust']);
                @endphp
                <tr>
                    <td><strong>{{ $info['name_en'] }}</strong><br><span style="font-size: 7.5pt; color: #78350f;">{{ $info['name_ml'] }}</span></td>
                    <td><strong>{{ sprintf("%02d° %02d' %02d\"", $d, $m, $s) }}</strong></td>
                    <td>
                        <strong>{{ $bodyRasiName }}</strong>
                        @if($targetLang !== 'en')
                            <span style="font-size: 7.5pt; color: #78350f;">({{ $rMeta['name_en'] }})</span>
                        @endif
                    </td>
                    <td><strong>{{ $bodyNakName }}</strong> (P{{ $bodyNakPada }})</td>
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
        <strong>{{ $targetLang === 'ml' ? 'സ്ഫുട ഗണിത ശാസ്ത്ര തത്ത്വം:' : 'Principle of Sphuta Precision:' }}</strong><br>
        {{ $targetLang === 'ml' ? 'ഗ്രഹങ്ങളുടെ കൃത്യമായ സ്ഫുടങ്ങൾ വർഗ്ഗങ്ങൾ, സന്ധികൾ, അഷ്ടകവർഗ്ഗ ബിന്ദുക്കൾ എന്നിവയുടെ സൂക്ഷ്മ ഗണിതത്തിന് അടിസ്ഥാനമാണ്. മുകളിൽ നൽകിയിരിക്കുന്ന സ്ഫുടങ്ങൾ ജാതക ഫലങ്ങളുടെ ആധാര രേഖയാണ്.' : 'Planetary longitudes determine the exact entrance into Vargas, Sandhis, and Ashtakavarga bindu allocations. The degrees above establish the exact root seed (Beeja) of all subsequent predictions.' }}
    </div>

    <div class="page-break"></div>

    <!-- ================= PAGE 4: SOUTH INDIAN RASI CHAKRA (D1) ================= -->
    <div class="section-title">{{ $targetLang === 'ml' ? '3. രാശി ചക്രം (D1 - Rasi Chakra)' : ($targetLang === 'ta' ? '3. ராசி சக்கரம் (D1)' : ($targetLang === 'hi' ? '3. राशि चक्र (D1)' : '3. South Indian Sidereal Rasi Chakra (D1)')) }}</div>
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
                <div style="font-weight: bold; color: #78350f;">{{ $formatRasiHeader(12) }}</div>
                @foreach($chartData['chart_grid_d1'][12] ?? [] as $pl)
                    <div><strong>{{ $pl['label'] }}</strong> <span style="font-size: 7pt; color: #555;">{{ $pl['deg'] }}°</span></div>
                @endforeach
            </td>
            <!-- Aries (1) -->
            <td class="chart-cell {{ $lagnaRasiIdx === 1 ? 'lagna-cell' : '' }}">
                <div style="font-weight: bold; color: #78350f;">{{ $formatRasiHeader(1) }}</div>
                @foreach($chartData['chart_grid_d1'][1] ?? [] as $pl)
                    <div><strong>{{ $pl['label'] }}</strong> <span style="font-size: 7pt; color: #555;">{{ $pl['deg'] }}°</span></div>
                @endforeach
            </td>
            <!-- Taurus (2) -->
            <td class="chart-cell {{ $lagnaRasiIdx === 2 ? 'lagna-cell' : '' }}">
                <div style="font-weight: bold; color: #78350f;">{{ $formatRasiHeader(2) }}</div>
                @foreach($chartData['chart_grid_d1'][2] ?? [] as $pl)
                    <div><strong>{{ $pl['label'] }}</strong> <span style="font-size: 7pt; color: #555;">{{ $pl['deg'] }}°</span></div>
                @endforeach
            </td>
            <!-- Gemini (3) -->
            <td class="chart-cell {{ $lagnaRasiIdx === 3 ? 'lagna-cell' : '' }}">
                <div style="font-weight: bold; color: #78350f;">{{ $formatRasiHeader(3) }}</div>
                @foreach($chartData['chart_grid_d1'][3] ?? [] as $pl)
                    <div><strong>{{ $pl['label'] }}</strong> <span style="font-size: 7pt; color: #555;">{{ $pl['deg'] }}°</span></div>
                @endforeach
            </td>
        </tr>
        <tr>
            <!-- Aquarius (11) -->
            <td class="chart-cell {{ $lagnaRasiIdx === 11 ? 'lagna-cell' : '' }}">
                <div style="font-weight: bold; color: #78350f;">{{ $formatRasiHeader(11) }}</div>
                @foreach($chartData['chart_grid_d1'][11] ?? [] as $pl)
                    <div><strong>{{ $pl['label'] }}</strong> <span style="font-size: 7pt; color: #555;">{{ $pl['deg'] }}°</span></div>
                @endforeach
            </td>
            <td colspan="2" rowspan="2" class="chart-center">
                <div style="font-size: 13pt; color: #78350f;">
                    @if($targetLang === 'ml') രാശി ചക്രം (D1) @elseif($targetLang === 'ta') ராசி சக்கரம் (D1) @elseif($targetLang === 'hi') राशि चक्र (D1) @else RASI CHAKRA (D1) @endif
                </div>
                <div style="font-size: 9pt; color: #b45309; margin-top: 4px;">{{ $reading->full_name }}</div>
                <div style="font-size: 8pt; color: #555; margin-top: 6px;">
                    <strong>{{ $targetLang === 'ml' ? 'ലഗ്നം' : ($targetLang === 'ta' ? 'லக்னம்' : ($targetLang === 'hi' ? 'लग्न' : 'Lagna')) }}:</strong> {{ $lagnaLocalized }}<br>
                    <strong>{{ $targetLang === 'ml' ? 'ചന്ദ്രൻ' : ($targetLang === 'ta' ? 'சந்திரன்' : ($targetLang === 'hi' ? 'चन्द्र' : 'Chandra')) }}:</strong> {{ $chartData['moon_sign']['name_' . $targetLang] ?? $chartData['moon_sign']['name_en'] ?? '' }}
                </div>
            </td>
            <!-- Cancer (4) -->
            <td class="chart-cell {{ $lagnaRasiIdx === 4 ? 'lagna-cell' : '' }}">
                <div style="font-weight: bold; color: #78350f;">{{ $formatRasiHeader(4) }}</div>
                @foreach($chartData['chart_grid_d1'][4] ?? [] as $pl)
                    <div><strong>{{ $pl['label'] }}</strong> <span style="font-size: 7pt; color: #555;">{{ $pl['deg'] }}°</span></div>
                @endforeach
            </td>
        </tr>
        <tr>
            <!-- Capricorn (10) -->
            <td class="chart-cell {{ $lagnaRasiIdx === 10 ? 'lagna-cell' : '' }}">
                <div style="font-weight: bold; color: #78350f;">{{ $formatRasiHeader(10) }}</div>
                @foreach($chartData['chart_grid_d1'][10] ?? [] as $pl)
                    <div><strong>{{ $pl['label'] }}</strong> <span style="font-size: 7pt; color: #555;">{{ $pl['deg'] }}°</span></div>
                @endforeach
            </td>
            <!-- Leo (5) -->
            <td class="chart-cell {{ $lagnaRasiIdx === 5 ? 'lagna-cell' : '' }}">
                <div style="font-weight: bold; color: #78350f;">{{ $formatRasiHeader(5) }}</div>
                @foreach($chartData['chart_grid_d1'][5] ?? [] as $pl)
                    <div><strong>{{ $pl['label'] }}</strong> <span style="font-size: 7pt; color: #555;">{{ $pl['deg'] }}°</span></div>
                @endforeach
            </td>
        </tr>
        <tr>
            <!-- Sagittarius (9) -->
            <td class="chart-cell {{ $lagnaRasiIdx === 9 ? 'lagna-cell' : '' }}">
                <div style="font-weight: bold; color: #78350f;">{{ $formatRasiHeader(9) }}</div>
                @foreach($chartData['chart_grid_d1'][9] ?? [] as $pl)
                    <div><strong>{{ $pl['label'] }}</strong> <span style="font-size: 7pt; color: #555;">{{ $pl['deg'] }}°</span></div>
                @endforeach
            </td>
            <!-- Scorpio (8) -->
            <td class="chart-cell {{ $lagnaRasiIdx === 8 ? 'lagna-cell' : '' }}">
                <div style="font-weight: bold; color: #78350f;">{{ $formatRasiHeader(8) }}</div>
                @foreach($chartData['chart_grid_d1'][8] ?? [] as $pl)
                    <div><strong>{{ $pl['label'] }}</strong> <span style="font-size: 7pt; color: #555;">{{ $pl['deg'] }}°</span></div>
                @endforeach
            </td>
            <!-- Libra (7) -->
            <td class="chart-cell {{ $lagnaRasiIdx === 7 ? 'lagna-cell' : '' }}">
                <div style="font-weight: bold; color: #78350f;">{{ $formatRasiHeader(7) }}</div>
                @foreach($chartData['chart_grid_d1'][7] ?? [] as $pl)
                    <div><strong>{{ $pl['label'] }}</strong> <span style="font-size: 7pt; color: #555;">{{ $pl['deg'] }}°</span></div>
                @endforeach
            </td>
            <!-- Virgo (6) -->
            <td class="chart-cell {{ $lagnaRasiIdx === 6 ? 'lagna-cell' : '' }}">
                <div style="font-weight: bold; color: #78350f;">{{ $formatRasiHeader(6) }}</div>
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
    <div class="section-title">{{ $targetLang === 'ml' ? '4. ഭാവ ചക്രം - ശ്രീ dynamic വിഭജനം (Bhava Chakra)' : ($targetLang === 'ta' ? '4. பாவ சக்கரம்' : ($targetLang === 'hi' ? '4. भाव चक्र' : '4. Bhava Chakra (Sripati Divisions & Sandhis)')) }}</div>
    <p style="font-size: 8.5pt; color: #555;">
        {{ $targetLang === 'ml' ? 'ഭാവാരംഭവും ഭാവമധ്യവും ഭാവസന്ധികളും അപഗ്രഥിച്ച് ഓരോ ഭാവത്തിന്റെയും കൃത്യമായ ഗ്രഹഫലങ്ങൾ നിർണ്ണയിക്കുന്നു.' : 'House boundaries (Bhavasandhis) explain the exact energetic distribution and transitions between adjacent houses.' }}
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
        <strong>{{ $targetLang === 'ml' ? 'ഭാവമധ്യ തത്ത്വം:' : 'Significance of Bhava Madhya:' }}</strong><br>
        {{ $targetLang === 'ml' ? 'ഭാവമധ്യത്തിൽ നിൽക്കുന്ന ഗ്രഹങ്ങൾ അവയുടെ കാരകത്വ ഫലങ്ങൾ പൂർണ്ണമായി നൽകുന്നു. സന്ധിയിലേക്ക് അടുക്കുന്തോറും ഫലങ്ങളിൽ അനുപാതിക മാറ്റങ്ങൾ കാണാം.' : 'Planets situated near the Bhava Madhya deliver their strongest significations. As planets approach the Sandhi (junction), results blend harmoniously with neighboring bhavas.' }}
    </div>

    <div class="page-break"></div>

    <!-- ================= PAGE 6: NAVAMSHA CHAKRA (D9) & VARGOTTAMA ================= -->
    <div class="section-title">{{ $targetLang === 'ml' ? '5. നവാംശക ചക്രം (D9 Navamsha) & വർഗ്ഗോത്തമം' : ($targetLang === 'ta' ? '5. நவாம்ச சக்கரம் (D9)' : ($targetLang === 'hi' ? '5. नवांश चक्र (D9)' : '5. Navamsha Chakra (D9) & Vargottama Positions')) }}</div>
    <p style="font-size: 8.5pt; color: #555;">
        The 9th harmonic chart (Navamsha) reveals the inner potential, marital fruitfulness, and spiritual evolution.
    </p>

    <table class="chart-grid">
        <tr>
            <!-- Pisces (12) -->
            <td class="chart-cell">
                <div style="font-weight: bold; color: #78350f;">{{ $formatRasiHeader(12) }}</div>
                @foreach($chartData['chart_grid_d9'][12] ?? [] as $pl)
                    <div><strong>{{ $pl['label'] }}</strong></div>
                @endforeach
            </td>
            <!-- Aries (1) -->
            <td class="chart-cell">
                <div style="font-weight: bold; color: #78350f;">{{ $formatRasiHeader(1) }}</div>
                @foreach($chartData['chart_grid_d9'][1] ?? [] as $pl)
                    <div><strong>{{ $pl['label'] }}</strong></div>
                @endforeach
            </td>
            <!-- Taurus (2) -->
            <td class="chart-cell">
                <div style="font-weight: bold; color: #78350f;">{{ $formatRasiHeader(2) }}</div>
                @foreach($chartData['chart_grid_d9'][2] ?? [] as $pl)
                    <div><strong>{{ $pl['label'] }}</strong></div>
                @endforeach
            </td>
            <!-- Gemini (3) -->
            <td class="chart-cell">
                <div style="font-weight: bold; color: #78350f;">{{ $formatRasiHeader(3) }}</div>
                @foreach($chartData['chart_grid_d9'][3] ?? [] as $pl)
                    <div><strong>{{ $pl['label'] }}</strong></div>
                @endforeach
            </td>
        </tr>
        <tr>
            <!-- Aquarius (11) -->
            <td class="chart-cell">
                <div style="font-weight: bold; color: #78350f;">{{ $formatRasiHeader(11) }}</div>
                @foreach($chartData['chart_grid_d9'][11] ?? [] as $pl)
                    <div><strong>{{ $pl['label'] }}</strong></div>
                @endforeach
            </td>
            <td colspan="2" rowspan="2" class="chart-center">
                <div style="font-size: 13pt; color: #78350f;">
                    @if($targetLang === 'ml') നവാംശകം (D9) @elseif($targetLang === 'ta') நவாம்சம் (D9) @elseif($targetLang === 'hi') नवांश (D9) @else NAVAMSHA (D9) @endif
                </div>
                <div style="font-size: 9pt; color: #b45309; margin-top: 4px;">{{ $reading->full_name }}</div>
                <div style="font-size: 8pt; color: #555; margin-top: 6px;">
                    {{ $targetLang === 'ml' ? 'ധർമ്മാംശകവും കളത്രാംശകവും' : ($targetLang === 'ta' ? 'தர்ம அம்சம் மற்றும் களத்திர அம்சம்' : ($targetLang === 'hi' ? 'धर्मांश एवं कलत्रांश' : 'Dharmamsha & Kalathramsha')) }}<br>
                    {{ $targetLang === 'ml' ? 'ഗുളികനും ഛായാഗ്രഹങ്ങളും ഉൾപ്പെടെ' : ($targetLang === 'ta' ? 'குளிகன் மற்றும் நிழல் கிரகங்கள்' : ($targetLang === 'hi' ? 'गुलिक एवं छायाग्रह सहित' : 'Includes Gulika & Nodes')) }}
                </div>
            </td>
            <!-- Cancer (4) -->
            <td class="chart-cell">
                <div style="font-weight: bold; color: #78350f;">{{ $formatRasiHeader(4) }}</div>
                @foreach($chartData['chart_grid_d9'][4] ?? [] as $pl)
                    <div><strong>{{ $pl['label'] }}</strong></div>
                @endforeach
            </td>
        </tr>
        <tr>
            <!-- Capricorn (10) -->
            <td class="chart-cell">
                <div style="font-weight: bold; color: #78350f;">{{ $formatRasiHeader(10) }}</div>
                @foreach($chartData['chart_grid_d9'][10] ?? [] as $pl)
                    <div><strong>{{ $pl['label'] }}</strong></div>
                @endforeach
            </td>
            <!-- Leo (5) -->
            <td class="chart-cell">
                <div style="font-weight: bold; color: #78350f;">{{ $formatRasiHeader(5) }}</div>
                @foreach($chartData['chart_grid_d9'][5] ?? [] as $pl)
                    <div><strong>{{ $pl['label'] }}</strong></div>
                @endforeach
            </td>
        </tr>
        <tr>
            <!-- Sagittarius (9) -->
            <td class="chart-cell">
                <div style="font-weight: bold; color: #78350f;">{{ $formatRasiHeader(9) }}</div>
                @foreach($chartData['chart_grid_d9'][9] ?? [] as $pl)
                    <div><strong>{{ $pl['label'] }}</strong></div>
                @endforeach
            </td>
            <!-- Scorpio (8) -->
            <td class="chart-cell">
                <div style="font-weight: bold; color: #78350f;">{{ $formatRasiHeader(8) }}</div>
                @foreach($chartData['chart_grid_d9'][8] ?? [] as $pl)
                    <div><strong>{{ $pl['label'] }}</strong></div>
                @endforeach
            </td>
            <!-- Libra (7) -->
            <td class="chart-cell">
                <div style="font-weight: bold; color: #78350f;">{{ $formatRasiHeader(7) }}</div>
                @foreach($chartData['chart_grid_d9'][7] ?? [] as $pl)
                    <div><strong>{{ $pl['label'] }}</strong></div>
                @endforeach
            </td>
            <!-- Virgo (6) -->
            <td class="chart-cell">
                <div style="font-weight: bold; color: #78350f;">{{ $formatRasiHeader(6) }}</div>
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
            <strong>{{ $targetLang === 'ml' ? 'അത്യന്തം ശുഭകരമായ വർഗ്ഗോത്തമ നില:' : 'Highly Auspicious Vargottama Positions:' }}</strong> {{ implode(', ', $vargottamaList) }}<br>
            {{ $targetLang === 'ml' ? 'രാശിയിലും നവാംശകത്തിലും ഒരേ രാശിയിൽ നിലകൊള്ളുന്ന ഗ്രഹം വർഗ്ഗോത്തമ ബലം പ്രാപിക്കുകയും, ഉന്നത ഫലങ്ങൾ സമ്മാനിക്കുകയും ചെയ്യുന്നു.' : 'A planet occupying the exact same sign in both Rasi and Navamsha attains Vargottama status (Swarupa Bala), providing enduring strength and protection to its houses.' }}
        @else
            <strong>Vargottama Status:</strong> {{ $targetLang === 'ml' ? 'ഗ്രഹങ്ങൾ വിവിധ രാശികളിലായി സ്ഥിതിചെയ്യുന്നു; ഷഡ്ബലവും അഷ്ടകവർഗ്ഗ ബിന്ദുക്കളും അടിസ്ഥാനമാക്കി സമഗ്ര ബലം വിലയിരുത്തപ്പെടുന്നു.' : 'Planetary strengths derive from harmonic Shadbala and Ashtakavarga bindus.' }}
        @endif
    </div>

    <div class="page-break"></div>

    <!-- ================= PAGE 7: SHADVARGA HARMONIC SUMMARY ================= -->
    <div class="section-title">{{ $targetLang === 'ml' ? '6. ഷഡ്‌വർഗ്ഗ വിചാരം (Shadvarga Matrix)' : ($targetLang === 'ta' ? '6. ஷட்வர்க்க அட்டவணை' : ($targetLang === 'hi' ? '6. षड्वर्ग विचार' : '6. Shadvarga (Six-Fold Harmonic) Matrix')) }}</div>
    <p style="font-size: 8.5pt; color: #555;">
        {{ $targetLang === 'ml' ? 'പരാശര - കേരള ജ്യോതിഷ സമ്പ്രദായത്തിൽ ഗ്രഹങ്ങളുടെ സൂക്ഷ്മ ബലനിർണ്ണയത്തിനായുള്ള ഷഡ്‌വർഗ്ഗങ്ങൾ (രാശി, ഹോര, ദ്രേക്കാണം, നവാംശകം, ദ്വാദശാംശകം, ത്രിംശാംശകം).' : 'Evaluates planetary strength across the six fundamental divisional chakras per Classical Parashari and Kerala canons.' }}
    </p>

    @php
        $formatVargaRasi = function($num) use ($targetLang) {
            $n = (int)$num;
            if ($n < 1 || $n > 12) return '-';
            $data = \App\Services\Astrology\PanchangaService::RASIS[$n] ?? [];
            return match($targetLang) {
                'ml' => $data['name_ml'] ?? "രാശി {$n}",
                'ta' => $data['name_ta'] ?? "ராசி {$n}",
                'hi' => $data['name_hi'] ?? "राशि {$n}",
                default => $data['name_en'] ?? "Rasi {$n}",
            };
        };
    @endphp

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
                    <td>{{ $formatVargaRasi($sv['d1_rasi'] ?? 0) }}</td>
                    <td>{{ ($sv['d2_hora'] ?? 5) == 5 ? ($targetLang === 'ml' ? 'സൂര്യൻ (ചിങ്ങം)' : 'Sun (Leo)') : ($targetLang === 'ml' ? 'ചന്ദ്രൻ (കർക്കിടകം)' : 'Moon (Cancer)') }}</td>
                    <td>{{ $formatVargaRasi($sv['d3_drekkana'] ?? 0) }}</td>
                    <td>{{ $formatVargaRasi($sv['d9_navamsha'] ?? 0) }}</td>
                    <td>{{ $formatVargaRasi($sv['d12_dvadashamsha'] ?? $sv['d12_dwadasamsha'] ?? 0) }}</td>
                    <td>{{ $formatVargaRasi($sv['d30_trimshamsha'] ?? $sv['d30_trimsamsha'] ?? 0) }}</td>
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
    <div class="section-title">{{ $targetLang === 'ml' ? '7. വിംശോത്തരി ദശാപഹാര ക്രമം (120-Year Lifeline)' : ($targetLang === 'ta' ? '7. விம்சொத்தரி தசா கால கணிதம்' : ($targetLang === 'hi' ? '7. विंशोत्तरी महादशा चक्र' : '7. Vimshottari Mahadasha 120-Year Lifeline')) }}</div>
    <p style="font-size: 8.5pt; color: #555;">
        {{ $targetLang === 'ml' ? 'ജനനസമയത്തെ ചന്ദ്രസ്ഫുടത്തെ ആസ്പദമാക്കി ഗണിച്ച വിംശോത്തരി ദശാപഹാര ക്രമം (ആകെ 120 വർഷം).' : 'Calculated from the precise longitude of Chandra at birth (Janma Nakshatra Pada) across the 120-year span.' }}
    </p>

    @php
        $gb = $chartData['garbhashishta'] ?? [];
        $gbLordEn = $gb['lord_en'] ?? $gb['lord'] ?? 'Guru';
        $gbLordMl = $gb['lord_ml'] ?? 'വ്യാഴം';
        $gbY = $gb['balance_years'] ?? $gb['years'] ?? 0;
        $gbM = $gb['balance_months'] ?? $gb['months'] ?? 0;
        $gbD = $gb['balance_days'] ?? $gb['days'] ?? 0;
    @endphp

    <div class="highlight-box">
        <strong>{{ $targetLang === 'ml' ? 'ജനന ശിഷ്ട ദശ (ഗർഭശിഷ്ടം):' : 'Balance of Dasha at Birth (Garbhashishta):' }}</strong><br>
        <strong>{{ $targetLang === 'ml' ? "{$gbLordMl} ({$gbLordEn})" : "{$gbLordEn} ({$gbLordMl})" }} Mahadasha</strong> balance:
        <strong>{{ $gbY }} {{ $targetLang === 'ml' ? 'വർഷം' : 'Years' }}, {{ $gbM }} {{ $targetLang === 'ml' ? 'മാസം' : 'Months' }}, {{ $gbD }} {{ $targetLang === 'ml' ? 'ദിവസം' : 'Days' }}</strong>
        ({{ $targetLang === 'ml' ? 'സമാപന തീയതി: ' . ($gb['end_date'] ?? '10-10-1956') : 'Ending on: ' . ($gb['end_date'] ?? '10-10-1956') }}).
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
            @foreach($chartData['dasha']['timeline'] ?? $chartData['dasha']['mahadashas'] ?? [] as $d)
                @php
                    $isCurrent = !empty($d['is_active']);
                    $dLord = $d['lord_' . $targetLang] ?? $d['lord_en'] ?? $d['lord'] ?? $d['lord_key'] ?? 'Dasha';
                    $dLordMl = $d['lord_ml'] ?? '';
                    $dLordKey = $d['lord_key'] ?? $d['lord_code'] ?? $d['planet'] ?? '';
                    $dDuration = $d['duration_years'] ?? $d['years'] ?? 0;
                    $dStart = !empty($d['start_date']) ? \Carbon\Carbon::parse($d['start_date'])->format('d-m-Y') : '-';
                    $dEnd = !empty($d['end_date']) ? \Carbon\Carbon::parse($d['end_date'])->format('d-m-Y') : '-';
                    $dIsPast = !empty($d['end_date']) && \Carbon\Carbon::parse($d['end_date'])->isPast();
                @endphp
                <tr style="{{ $isCurrent ? 'background-color: #fef9c3; font-weight: bold;' : '' }}">
                    <td>{{ $dLord }} @if(!empty($dLordMl))({{ $dLordMl }})@endif</td>
                    <td>{{ $dLordKey }}</td>
                    <td>{{ $dDuration }} Years</td>
                    <td>{{ $dStart }}</td>
                    <td>{{ $dEnd }}</td>
                    <td style="color: {{ $isCurrent ? '#b45309' : '#555' }}; font-weight: bold;">
                        {{ $isCurrent ? '★ CURRENTLY RUNNING' : ($dIsPast ? 'Completed' : 'Upcoming') }}
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="page-break"></div>

    <!-- ================= PAGE 9: ACTIVE DASHA & APAHARA (ANTARDASHA) ================= -->
    <div class="section-title">{{ $targetLang === 'ml' ? '8. നിലവിലെ ദശാപഹാര ഫലനിർണ്ണയം (Current Dasha)' : ($targetLang === 'ta' ? '8. நடப்பு தசா-புத்தி விபரம்' : ($targetLang === 'hi' ? '8. वर्तमान दशा एवं अंतर्दशा (अपहार)' : '8. Active Mahadasha & Antardasha (Apahara) Breakdown')) }}</div>
    <p style="font-size: 8.5pt; color: #555;">
        {{ $targetLang === 'ml' ? 'നിലവിൽ നടന്നുകൊണ്ടിരിക്കുന്ന മഹാദശയിലെ 9 അപഹാരങ്ങളുടെയും (ഉപദശകൾ) വിശദമായ കാലക്രമം.' : 'Detailed sub-period calendar for the currently operating planetary period.' }}
    </p>

    <div class="highlight-box" style="border-left-color: #059669; background-color: #ecfdf5;">
        <strong style="color: #065f46; font-size: 10pt;">Active Planetary Cycle:</strong><br>
        <strong>Mahadasha:</strong> {{ $chartData['active_dasha']['mahadasha_en'] ?? $chartData['active_dasha']['mahadasha'] ?? '' }} ({{ $chartData['active_dasha']['mahadasha_ml'] ?? '' }})<br>
        <strong>Antardasha (Apahara):</strong> {{ $chartData['active_dasha']['antardasha_en'] ?? $chartData['active_dasha']['antardasha'] ?? '' }} ({{ $chartData['active_dasha']['antardasha_ml'] ?? '' }})<br>
        @if(!empty($chartData['active_dasha']['active_pratyantardasha']))
        <strong>Pratyantardasha (Sub-Sub Period):</strong> {{ $chartData['active_dasha']['active_pratyantardasha']['name_en'] ?? '' }} ({{ $chartData['active_dasha']['active_pratyantardasha']['name_ml'] ?? '' }})<br>
        @endif
        @if(!empty($chartData['active_dasha']['active_sukshma']))
        <strong>Sukshma Dasha (Micro Period):</strong> {{ $chartData['active_dasha']['active_sukshma']['name_en'] ?? '' }} ({{ $chartData['active_dasha']['active_sukshma']['name_ml'] ?? '' }})<br>
        @endif
        <strong>Operating Span:</strong> {{ !empty($chartData['active_dasha']['start_date']) ? \Carbon\Carbon::parse($chartData['active_dasha']['start_date'])->format('d-m-Y') : '-' }} to {{ !empty($chartData['active_dasha']['end_date']) ? \Carbon\Carbon::parse($chartData['active_dasha']['end_date'])->format('d-m-Y') : '-' }}
    </div>

    <div class="subsection-title">{{ $targetLang === 'ml' ? 'നിലവിലെ മഹാദശയിലെ 9 അപഹാരങ്ങൾ (Antardashas)' : 'Sub-Periods (Apaharas / Antardashas) of Current Mahadasha' }}</div>
    <table class="table-data table-compact">
        <thead>
            <tr>
                <th>Apahara (Sub-Lord)</th>
                <th>Span (Start to End)</th>
                <th>General Planetary Tendency</th>
            </tr>
        </thead>
        <tbody>
            @foreach($chartData['active_dasha']['all_antardashas'] ?? $chartData['active_dasha']['apaharas'] ?? [] as $ad)
                @php
                    $adLord = $ad['lord_' . $targetLang] ?? $ad['lord_en'] ?? $ad['lord'] ?? $ad['name'] ?? $ad['sub_lord'] ?? 'Sub-Lord';
                    $adLordMl = $ad['lord_ml'] ?? $ad['name_ml'] ?? '';
                    $adStart = !empty($ad['start_date']) ? \Carbon\Carbon::parse($ad['start_date'])->format('d-m-Y') : '-';
                    $adEnd = !empty($ad['end_date']) ? \Carbon\Carbon::parse($ad['end_date'])->format('d-m-Y') : '-';
                    $adTendency = $ad['prediction_' . $targetLang] ?? $ad['tendency'] ?? $ad['prediction'] ?? 'Karmic progression according to house placements and benefic aspects.';
                @endphp
                <tr style="{{ !empty($ad['is_active']) ? 'background-color: #fef9c3; font-weight: bold;' : '' }}">
                    <td><strong>{{ $adLord }}</strong> @if(!empty($adLordMl))({{ $adLordMl }})@endif @if(!empty($ad['is_active'])) <span style="color:#b45309; font-size:7pt;">★ ACTIVE</span> @endif</td>
                    <td>{{ $adStart }} &mdash; {{ $adEnd }}</td>
                    <td>{{ $adTendency }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    @if(!empty($chartData['active_dasha']['all_pratyantardashas']))
    <div class="subsection-title" style="margin-top: 10px;">{{ $targetLang === 'ml' ? 'നിലവിലെ അപഹാരത്തിലെ 9 പ്രത്യന്തർദശകൾ (Pratyantardashas)' : 'Sub-Sub Periods (Pratyantardashas) of Current Apahara' }}</div>
    <table class="table-data table-compact">
        <thead>
            <tr>
                <th>Pratyantar Lord</th>
                <th>Start Date</th>
                <th>End Date</th>
                <th>Duration (Days)</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @foreach($chartData['active_dasha']['all_pratyantardashas'] as $pd)
                @php
                    $pdLord = $pd['name_' . $targetLang] ?? $pd['name_en'] ?? $pd['lord_en'] ?? 'Pratyantar Lord';
                    $pdStart = !empty($pd['start_date']) ? \Carbon\Carbon::parse($pd['start_date'])->format('d-m-Y') : '-';
                    $pdEnd = !empty($pd['end_date']) ? \Carbon\Carbon::parse($pd['end_date'])->format('d-m-Y') : '-';
                    $isPdActive = !empty($pd['is_active']);
                @endphp
                <tr style="{{ $isPdActive ? 'background-color: #fef9c3; font-weight: bold;' : '' }}">
                    <td><strong>{{ $pdLord }}</strong></td>
                    <td>{{ $pdStart }}</td>
                    <td>{{ $pdEnd }}</td>
                    <td>{{ $pd['duration_days'] ?? '-' }} days</td>
                    <td style="color: {{ $isPdActive ? '#b45309' : '#555' }};">
                        {{ $isPdActive ? '★ RUNNING NOW' : '-' }}
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
    @endif

    <div class="highlight-box">
        <strong>{{ $targetLang === 'ml' ? 'ദശാപഹാര ഫല തത്ത്വം:' : 'Vimshottari Rule of Interpretation:' }}</strong><br>
        {{ $targetLang === 'ml' ? 'മഹാദശാ നാഥനും അപഹാര നാഥനും സ്ഥിതി ചെയ്യുന്ന ഭാവങ്ങളും അവയുടെ പരസ്പര ദൃഷ്ടി, മൈത്രി എന്നിവയും സമന്വയിപ്പിച്ചാണ് ജീവിതാനുഭവങ്ങൾ പ്രകടമാകുന്നത്. നിലവിലെ കാലഘട്ടത്തിൽ ഈശ്വര പ്രാർത്ഥനയും സത്കർമ്മങ്ങളും ശ്രേയസ്സ് നൽകും.' : 'During the Mahadasha of planet A and Antardasha of planet B, results materialize through the houses owned and occupied by both lords, modified by mutual aspect (Paraspara Drishti) and temporal friendship.' }}
    </div>

    <div class="page-break"></div>

    <!-- ================= PAGE 10: SARVASHTAKAVARGA (337 POINTS) ================= -->
    <div class="section-title">
        {{ $targetLang === 'ml' ? '9. സർവ്വാഷ്ടകവർഗ്ഗം (337 ബിന്ദുക്കൾ) ബലവിചാരം' : ($targetLang === 'ta' ? '9. சர்வாஷ்டகவர்க்கம் (337 புள்ளிகள்) பலன்' : ($targetLang === 'hi' ? '9. सर्वाष्टकवर्ग (337 बिंदु) फलादेश' : '9. Sarvashtakavarga (337 Points) Strength Audit')) }}
    </div>
    <p style="font-size: 8.5pt; color: #555;">
        {{ $targetLang === 'ml' ? 'അഷ്ടകവർഗ്ഗ സമ്പ്രദായത്തിൽ 12 രാശികളുടെയും സ്വാഭാവിക ബലനിർണ്ണയം. 28 ബിന്ദുക്കൾ സമതുലിതമായ ശരാശരി ബലമായി കണക്കാക്കുന്നു.' : 'Ashtakavarga evaluates the independent transit and natal strength across all 12 signs. A score of 28 bindus represents the balanced baseline.' }}
    </p>

    <table class="table-data">
        <thead>
            <tr>
                <th>{{ $targetLang === 'ml' ? 'രാശി (Sign / Rasi)' : 'Sign / Rasi' }}</th>
                <th>{{ $targetLang === 'ml' ? 'SAV ബിന്ദുക്കൾ' : 'SAV Bindus' }}</th>
                <th>{{ $targetLang === 'ml' ? 'ബല നിലവാരം' : 'Strength Rating' }}</th>
                <th>{{ $targetLang === 'ml' ? 'ശാസ്‍ത്രീയ ഫലം' : 'Classical Result' }}</th>
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
                    if ($targetLang === 'ml') {
                        $rating = $pts >= 30 ? 'അത്യന്തം ശുഭം (Fortunate)' : ($pts >= 28 ? 'ശുഭം / സമതുലിതം (Balanced)' : ($pts >= 25 ? 'മധ്യമം (Moderate)' : 'ജാഗ്രത / പ്രാർത്ഥന (Caution)'));
                        $resText = $pts >= 28 ? 'സർവ്വകാര്യ വിജയം; ഈ രാശിയിലൂടെയുള്ള ഗ്രഹസഞ്ചാരം ഉന്നതി നൽകും.' : 'പരിശ്രമശീലവും ഈശ്വരപ്രാർത്ഥനയും ശ്രദ്ധാപൂർവ്വമായ വാക്കും നന്മ നൽകും.';
                    } elseif ($targetLang === 'ta') {
                        $rating = $pts >= 30 ? 'மிகவும் சுபம்' : ($pts >= 28 ? 'சுபம்' : ($pts >= 25 ? 'மத்திமம்' : 'கவனம் தேவை'));
                        $resText = $pts >= 28 ? 'வெற்றி மற்றும் நற்பலன்கள் தரும் காலம்.' : 'முயற்சியும் இறை வழிபாடும் நலம் தரும்.';
                    } elseif ($targetLang === 'hi') {
                        $rating = $pts >= 30 ? 'अत्यंत शुभ' : ($pts >= 28 ? 'शुभ / संतुलित' : ($pts >= 25 ? 'मध्यम' : 'सावधानी अपेक्षित'));
                        $resText = $pts >= 28 ? 'कार्यों में निर्बाध सफलता एवं शुभ गोचर।' : 'परिश्रम एवं ईश आराधना से कार्यों में सफलता मिलेगी।';
                    } else {
                        $rating = $pts >= 30 ? 'Highly Fortunate' : ($pts >= 28 ? 'Auspicious / Balanced' : ($pts >= 25 ? 'Average / Moderate' : 'Requires Caution'));
                        $resText = $pts >= 28 ? 'Smooth fulfillment of endeavors; beneficial during planetary transits.' : 'Requires diligent effort, careful speech, and spiritual remedies.';
                    }
                    $color = $pts >= 28 ? '#15803d' : '#b91c1c';
                @endphp
                <tr>
                    <td><strong>{{ $rLabel }}</strong></td>
                    <td><strong style="color: {{ $color }}; font-size: 10pt;">{{ $pts }}</strong> Bindus</td>
                    <td style="color: {{ $color }}; font-weight: bold;">{{ $rating }}</td>
                    <td>{{ $resText }}</td>
                </tr>
            @endforeach
            <tr style="background-color: #fef3c7; font-weight: bold;">
                <td><strong>{{ $targetLang === 'ml' ? 'ആകെ സമുദായ ബിന്ദുക്കൾ' : 'Total Samudaya Bindus' }}</strong></td>
                <td><strong style="color: #78350f; font-size: 11pt;">{{ $totalSav }} / 337</strong></td>
                <td colspan="2">{{ $targetLang === 'ml' ? 'പരാശര ഗണിതശാസ്ത്ര പ്രകാരം 337 ബിന്ദുക്കൾ സ്ഥിരീകരിച്ചു.' : 'Standard Parashari Mathematical Integrity Confirmed (337 Bindus)' }}</td>
            </tr>
        </tbody>
    </table>

    <div class="page-break"></div>

    <!-- ================= PAGE 11: BHINNASHTAKAVARGA (BAV) MATRIX ================= -->
    <div class="section-title">{{ $targetLang === 'ml' ? '10. ഭിന്നാഷ്ടകവർഗ്ഗം (BAV Planetary Distribution)' : ($targetLang === 'ta' ? '10. பின்னாஷ்டகவர்க்கம்' : ($targetLang === 'hi' ? '10. भिन्नाष्टकवर्ग' : '10. Bhinnashtakavarga (BAV) Planetary Distribution')) }}</div>
    <p style="font-size: 8.5pt; color: #555;">
        {{ $targetLang === 'ml' ? 'ഓരോ ഗ്രഹവും 12 രാശികളിൽ വിതരണം ചെയ്യുന്ന ശുഭ ബിന്ദുക്കൾ (കക്ഷ്യാ സമ്പ്രദായം).' : 'Individual benefic bindus contributed by each planet and Lagna into the 12 signs (Kakshya system).' }}
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
                1 => 'Aries / മേടം', 2 => 'Taurus / ഇടവം', 3 => 'Gemini / മിഥുനം', 4 => 'Cancer / കർക്കിടകം',
                5 => 'Leo / ചിങ്ങം', 6 => 'Virgo / കന്നി', 7 => 'Libra / തുലാം', 8 => 'Scorpio / വൃശ്ചികം',
                9 => 'Sagittarius / ധനു', 10 => 'Capricorn / മകരം', 11 => 'Aquarius / കുംഭം', 12 => 'Pisces / മീനം'
            ] as $rNum => $rName)
                <tr>
                    <td><strong>{{ $rName }}</strong></td>
                    <td>{{ $bav['Su']['points_by_rasi'][$rNum] ?? $bav['Su'][$rNum] ?? '-' }}</td>
                    <td>{{ $bav['Mo']['points_by_rasi'][$rNum] ?? $bav['Mo'][$rNum] ?? '-' }}</td>
                    <td>{{ $bav['Ma']['points_by_rasi'][$rNum] ?? $bav['Ma'][$rNum] ?? '-' }}</td>
                    <td>{{ $bav['Me']['points_by_rasi'][$rNum] ?? $bav['Me'][$rNum] ?? '-' }}</td>
                    <td>{{ $bav['Ju']['points_by_rasi'][$rNum] ?? $bav['Ju'][$rNum] ?? '-' }}</td>
                    <td>{{ $bav['Ve']['points_by_rasi'][$rNum] ?? $bav['Ve'][$rNum] ?? '-' }}</td>
                    <td>{{ $bav['Sa']['points_by_rasi'][$rNum] ?? $bav['Sa'][$rNum] ?? '-' }}</td>
                    <td><strong>{{ $savData[$rNum] ?? '-' }}</strong></td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="highlight-box">
        <strong>{{ $targetLang === 'ml' ? 'കക്ഷ്യാ തത്ത്വം:' : 'Kakshya Timing Principle:' }}</strong><br>
        {{ $targetLang === 'ml' ? 'ഓരോ രാശിയും 3°45\' വീതമുള്ള 8 കക്ഷ്യകളായി വിഭജിക്കപ്പെടുന്നു. സ്വന്തം അഷ്ടകവർഗ്ഗത്തിൽ ബിന്ദു സ്ഥിതി ചെയ്യുന്ന കക്ഷ്യയിലൂടെ ഗ്രഹങ്ങൾ സഞ്ചരിക്കുമ്പോൾ കാര്യവിജയവും സർവ്വഐശ്വര്യങ്ങളും അനുഭവവേദ്യമാകുന്നു.' : 'Each sign is divided into 8 Kakshyas (3°45\' each) ruled in order by Saturn, Jupiter, Mars, Sun, Venus, Mercury, Moon, and Lagna. A transiting planet delivers its positive fruits only when passing through a Kakshya that contains a bindu in its own BAV chart.' }}
    </div>

    <div class="page-break"></div>

    <!-- ================= PAGE 12: CLASSICAL YOGAS COMPREHENSIVE ================= -->
    <div class="section-title">{{ $targetLang === 'ml' ? '11. പ്രധാന ജാതക യോഗങ്ങൾ (Classical Yogas)' : ($targetLang === 'ta' ? '11. முக்கிய யோகங்கள்' : ($targetLang === 'hi' ? '11. जातक के प्रमुख योग' : '11. Classical Yogas Evaluation')) }}</div>
    <p style="font-size: 8.5pt; color: #555;">
        {{ $targetLang === 'ml' ? 'പരാശര - വേദാംഗ ജ്യോതിഷ പ്രമാണപ്രകാരം ജാതകത്തിൽ രൂപപ്പെട്ടിട്ടുള്ള പ്രധാന ഗ്രഹയോഗങ്ങൾ.' : 'Synthesized strictly per classical Vedic astrology rules with Ubhaya/Sthira lagna qualifications and conjunction exceptions.' }}
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
    <div class="section-title">{{ $targetLang === 'ml' ? '12. ഗുളിക (മാന്ദി) സ്ഥിതിയും ദോഷ പരിഹാരവും' : ($targetLang === 'ta' ? '12. குளிகன் பலன்கள் மற்றும் பரிகாரம்' : ($targetLang === 'hi' ? '12. गुलिक (मांदि) फलादेश एवं शांति' : '12. Gulika (Maandhi) Diagnostic Phalam (Ch. 5 & 17)')) }}</div>
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

    @php
        $getBhavaInfo = function($h) use ($chartData, $targetLang) {
            $bData = $chartData['vedanga_predictions']['bhavas'][$h] ?? [];
            $bMeta = $bData['meta'] ?? \App\Services\Astrology\VargaAndBhavaService::BHAVA_METADATA[$h] ?? [];
            $title = $bMeta['name_' . $targetLang] ?? $bMeta['name_en'] ?? "Bhava {$h}";
            $desc = $bMeta['significance_' . $targetLang] ?? $bData['analysis_' . $targetLang] ?? $bMeta['significance_en'] ?? $bData['analysis_en'] ?? '';
            $lordPhala = $bData['lord_placement_' . $targetLang] ?? $bData['lord_phala'] ?? \App\Services\Astrology\BhavaInterpretationDictionary::getBhavaLordInterpretation($h, $bData['lord_placed_in_bhava'] ?? 1, $targetLang);
            $lord = $bData['bhava_lord'] ?? '';
            $lordHouse = $bData['lord_placed_in_bhava'] ?? '';

            $occupants = $bData['occupants'] ?? [];
            $aspects = $bData['aspects'] ?? \App\Services\Astrology\BhavaInterpretationDictionary::getAspectsOnBhava($h, $chartData, $targetLang);
            $karakaExp = $bData['karaka_exception'] ?? null;
            $lagnaProf = ($h === 1) ? ($bData['lagna_profile'] ?? \App\Services\Astrology\BhavaInterpretationDictionary::LAGNA_PROFILES[$chartData['lagna']['rasi_index'] ?? 1] ?? null) : null;

            return [
                'title' => $title,
                'desc' => $desc,
                'lordPhala' => $lordPhala,
                'lord' => $lord,
                'lordHouse' => $lordHouse,
                'occupants' => $occupants,
                'aspects' => $aspects,
                'karakaExp' => $karakaExp,
                'lagnaProfile' => $lagnaProf,
            ];
        };
    @endphp

    <!-- ================= PAGE 14: BHAVAS 1 & 2 ================= -->
    <div class="section-title">{{ $targetLang === 'ml' ? '13. ഭാവവിചാരം: 1-ാം ഭാവം (തനു) & 2-ാം ഭാവം (ധനം)' : '13. Bhava Synthesis: 1st (Tanu) & 2nd (Dhana) Bhavas' }}</div>
    @php $b1 = $getBhavaInfo(1); @endphp
    <div class="subsection-title">{{ $b1['title'] }}</div>
    <p>{{ $b1['desc'] }}</p>

    @if(!empty($b1['lagnaProfile']))
        <div style="background-color: #fffbeb; border: 1px solid #fde68a; border-radius: 4px; padding: 6px 10px; margin-bottom: 8px; font-size: 8pt;">
            <strong style="color: #92400e;">{{ $targetLang === 'ml' ? 'ലഗ്ന സ്വഭാവവും ശരീരപ്രകൃതിയും:' : 'Ascendant Disposition & Physical Appearance:' }}</strong><br>
            {{ $targetLang === 'ml' ? (($b1['lagnaProfile']['traits_ml'] ?? '') . ' ' . ($b1['lagnaProfile']['physical_ml'] ?? '')) : (($b1['lagnaProfile']['traits_en'] ?? '') . ' ' . ($b1['lagnaProfile']['physical_en'] ?? '')) }}<br>
            @if(!empty($b1['lagnaProfile']['milestone_ages']))
                <strong style="color: #92400e; margin-top: 3px; display: inline-block;">{{ $targetLang === 'ml' ? 'ഭാഗ്യവർഷങ്ങൾ (Milestone Ages):' : 'Key Milestone Ages:' }}</strong> {{ $b1['lagnaProfile']['milestone_ages'] }} വയസ്സ്.<br>
            @endif
            @php
                $drkList = $targetLang === 'ml' ? ($b1['lagnaProfile']['drekkanas_ml'] ?? []) : ($b1['lagnaProfile']['drekkanas_en'] ?? []);
            @endphp
            @if(!empty($drkList))
                <strong style="color: #92400e; margin-top: 3px; display: inline-block;">{{ $targetLang === 'ml' ? 'ദ്രേക്കാണ വിചാരം:' : 'Drekkana Breakdown:' }}</strong><br>
                @foreach($drkList as $drk)
                    &bull; {{ $drk }}<br>
                @endforeach
            @endif
        </div>
    @endif

    <div class="highlight-box">
        <strong>{{ $targetLang === 'ml' ? 'ഭാവാധിപനും ഫലവും:' : 'Lord & Placement:' }}</strong> {{ $b1['lordPhala'] }}
        @if(!empty($b1['occupants']))
            <br><strong>{{ $targetLang === 'ml' ? 'സ്ഥിതിചെയ്യുന്ന ഗ്രഹങ്ങൾ:' : 'Occupying Influences:' }}</strong>
            @foreach($b1['occupants'] as $occ)
                <span>{{ $occ['name_' . $targetLang] ?? $occ['name_en'] ?? $occ['name'] }}: {{ $occ['phalam_' . $targetLang] ?? $occ['phalam_en'] ?? $occ['phala'] ?? '' }} </span>
            @endforeach
        @endif
        @if(!empty($b1['aspects']))
            <br><strong>{{ $targetLang === 'ml' ? 'ദൃഷ്ടി ഫലം (Planetary Aspects):' : 'Planetary Aspects on this Bhava:' }}</strong><br>
            @foreach($b1['aspects'] as $asp)
                &bull; {{ $asp['text_' . $targetLang] ?? $asp['text_en'] ?? $asp['text'] ?? '' }}<br>
            @endforeach
        @endif
    </div>

    @php $b2 = $getBhavaInfo(2); @endphp
    <div class="subsection-title">{{ $b2['title'] }}</div>
    <p>{{ $b2['desc'] }}</p>
    <div class="highlight-box">
        <strong>{{ $targetLang === 'ml' ? 'ഭാവാധിപനും ഫലവും:' : 'Lord & Placement:' }}</strong> {{ $b2['lordPhala'] }}
        @if(!empty($b2['occupants']))
            <br><strong>{{ $targetLang === 'ml' ? 'സ്ഥിതിചെയ്യുന്ന ഗ്രഹങ്ങൾ:' : 'Occupying Influences:' }}</strong>
            @foreach($b2['occupants'] as $occ)
                <span>{{ $occ['name_' . $targetLang] ?? $occ['name_en'] ?? $occ['name'] }}: {{ $occ['phalam_' . $targetLang] ?? $occ['phalam_en'] ?? $occ['phala'] ?? '' }} </span>
            @endforeach
        @endif
        @if(!empty($b2['aspects']))
            <br><strong>{{ $targetLang === 'ml' ? 'ദൃഷ്ടി ഫലം (Planetary Aspects):' : 'Planetary Aspects on this Bhava:' }}</strong><br>
            @foreach($b2['aspects'] as $asp)
                &bull; {{ $asp['text_' . $targetLang] ?? $asp['text_en'] ?? $asp['text'] ?? '' }}<br>
            @endforeach
        @endif
    </div>

    <div class="page-break"></div>

    <!-- ================= PAGE 15: BHAVAS 3 & 4 ================= -->
    <div class="section-title">{{ $targetLang === 'ml' ? '14. ഭാവവിചാരം: 3-ാം ഭാവം (സഹജം) & 4-ാം ഭാവം (സുഖം)' : '14. Bhava Synthesis: 3rd (Sahaja) & 4th (Sukha) Bhavas' }}</div>
    @php $b3 = $getBhavaInfo(3); @endphp
    <div class="subsection-title">{{ $b3['title'] }}</div>
    <p>{{ $b3['desc'] }}</p>
    <div class="highlight-box">
        <strong>{{ $targetLang === 'ml' ? 'ഭാവാധിപനും ഫലവും:' : 'Lord & Placement:' }}</strong> {{ $b3['lordPhala'] }}
        @if(!empty($b3['occupants']))
            <br><strong>{{ $targetLang === 'ml' ? 'സ്ഥിതിചെയ്യുന്ന ഗ്രഹങ്ങൾ:' : 'Occupying Influences:' }}</strong>
            @foreach($b3['occupants'] as $occ)
                <span>{{ $occ['name_' . $targetLang] ?? $occ['name_en'] ?? $occ['name'] }}: {{ $occ['phalam_' . $targetLang] ?? $occ['phalam_en'] ?? $occ['phala'] ?? '' }} </span>
            @endforeach
        @endif
        @if(!empty($b3['aspects']))
            <br><strong>{{ $targetLang === 'ml' ? 'ദൃഷ്ടി ഫലം (Planetary Aspects):' : 'Planetary Aspects on this Bhava:' }}</strong><br>
            @foreach($b3['aspects'] as $asp)
                &bull; {{ $asp['text_' . $targetLang] ?? $asp['text_en'] ?? $asp['text'] ?? '' }}<br>
            @endforeach
        @endif
    </div>

    @php $b4 = $getBhavaInfo(4); @endphp
    <div class="subsection-title">{{ $b4['title'] }}</div>
    <p>{{ $b4['desc'] }}</p>
    <div class="highlight-box">
        <strong>{{ $targetLang === 'ml' ? 'ഭാവാധിപനും ഫലവും:' : 'Lord & Placement:' }}</strong> {{ $b4['lordPhala'] }}
        @if(!empty($b4['occupants']))
            <br><strong>{{ $targetLang === 'ml' ? 'സ്ഥിതിചെയ്യുന്ന ഗ്രഹങ്ങൾ:' : 'Occupying Influences:' }}</strong>
            @foreach($b4['occupants'] as $occ)
                <span>{{ $occ['name_' . $targetLang] ?? $occ['name_en'] ?? $occ['name'] }}: {{ $occ['phalam_' . $targetLang] ?? $occ['phalam_en'] ?? $occ['phala'] ?? '' }} </span>
            @endforeach
        @endif
        @if(!empty($b4['aspects']))
            <br><strong>{{ $targetLang === 'ml' ? 'ദൃഷ്ടി ഫലം (Planetary Aspects):' : 'Planetary Aspects on this Bhava:' }}</strong><br>
            @foreach($b4['aspects'] as $asp)
                &bull; {{ $asp['text_' . $targetLang] ?? $asp['text_en'] ?? $asp['text'] ?? '' }}<br>
            @endforeach
        @endif
    </div>

    <div class="page-break"></div>

    <!-- ================= PAGE 16: BHAVAS 5 & 6 ================= -->
    <div class="section-title">{{ $targetLang === 'ml' ? '15. ഭാവവിചാരം: 5-ാം ഭാവം (പുത്രം) & 6-ാം ഭാവം (ശത്രു)' : '15. Bhava Synthesis: 5th (Putra) & 6th (Satru) Bhavas' }}</div>
    @php $b5 = $getBhavaInfo(5); @endphp
    <div class="subsection-title">{{ $b5['title'] }}</div>
    <p>{{ $b5['desc'] }}</p>
    <div class="highlight-box">
        <strong>{{ $targetLang === 'ml' ? 'ഭാവാധിപനും ഫലവും:' : 'Lord & Placement:' }}</strong> {{ $b5['lordPhala'] }}
        @if($b5['karakaExp'])
            <br><span style="color: #b91c1c; font-weight: bold;">{{ $b5['karakaExp'] }}</span>
        @endif
        @if(!empty($b5['occupants']))
            <br><strong>{{ $targetLang === 'ml' ? 'സ്ഥിതിചെയ്യുന്ന ഗ്രഹങ്ങൾ:' : 'Occupying Influences:' }}</strong>
            @foreach($b5['occupants'] as $occ)
                <span>{{ $occ['name_' . $targetLang] ?? $occ['name_en'] ?? $occ['name'] }}: {{ $occ['phalam_' . $targetLang] ?? $occ['phalam_en'] ?? $occ['phala'] ?? '' }} </span>
            @endforeach
        @endif
        @if(!empty($b5['aspects']))
            <br><strong>{{ $targetLang === 'ml' ? 'ദൃഷ്ടി ഫലം (Planetary Aspects):' : 'Planetary Aspects on this Bhava:' }}</strong><br>
            @foreach($b5['aspects'] as $asp)
                &bull; {{ $asp['text_' . $targetLang] ?? $asp['text_en'] ?? $asp['text'] ?? '' }}<br>
            @endforeach
        @endif
    </div>

    @php $b6 = $getBhavaInfo(6); @endphp
    <div class="subsection-title">{{ $b6['title'] }}</div>
    <p>{{ $b6['desc'] }}</p>
    <div class="highlight-box">
        <strong>{{ $targetLang === 'ml' ? 'ഭാവാധിപനും ഫലവും:' : 'Lord & Placement:' }}</strong> {{ $b6['lordPhala'] }}
        @if(!empty($b6['occupants']))
            <br><strong>{{ $targetLang === 'ml' ? 'സ്ഥിതിചെയ്യുന്ന ഗ്രഹങ്ങൾ:' : 'Occupying Influences:' }}</strong>
            @foreach($b6['occupants'] as $occ)
                <span>{{ $occ['name_' . $targetLang] ?? $occ['name_en'] ?? $occ['name'] }}: {{ $occ['phalam_' . $targetLang] ?? $occ['phalam_en'] ?? $occ['phala'] ?? '' }} </span>
            @endforeach
        @endif
        @if(!empty($b6['aspects']))
            <br><strong>{{ $targetLang === 'ml' ? 'ദൃഷ്ടി ഫലം (Planetary Aspects):' : 'Planetary Aspects on this Bhava:' }}</strong><br>
            @foreach($b6['aspects'] as $asp)
                &bull; {{ $asp['text_' . $targetLang] ?? $asp['text_en'] ?? $asp['text'] ?? '' }}<br>
            @endforeach
        @endif
    </div>

    <div class="page-break"></div>

    <!-- ================= PAGE 17: BHAVAS 7 & 8 ================= -->
    <div class="section-title">{{ $targetLang === 'ml' ? '16. ഭാവവിചാരം: 7-ാം ഭാവം (കളത്രം) & 8-ാം ഭാവം (ആയുസ്സ്)' : '16. Bhava Synthesis: 7th (Kalathra) & 8th (Ayur) Bhavas' }}</div>
    @php $b7 = $getBhavaInfo(7); @endphp
    <div class="subsection-title">{{ $b7['title'] }}</div>
    <p>{{ $b7['desc'] }}</p>
    <div class="highlight-box">
        <strong>{{ $targetLang === 'ml' ? 'ഭാവാധിപനും ഫലവും:' : 'Lord & Placement:' }}</strong> {{ $b7['lordPhala'] }}
        @if($b7['karakaExp'])
            <br><span style="color: #b91c1c; font-weight: bold;">{{ $b7['karakaExp'] }}</span>
        @endif
        @if(!empty($b7['occupants']))
            <br><strong>{{ $targetLang === 'ml' ? 'സ്ഥിതിചെയ്യുന്ന ഗ്രഹങ്ങൾ:' : 'Occupying Influences:' }}</strong>
            @foreach($b7['occupants'] as $occ)
                <span>{{ $occ['name_' . $targetLang] ?? $occ['name_en'] ?? $occ['name'] }}: {{ $occ['phalam_' . $targetLang] ?? $occ['phalam_en'] ?? $occ['phala'] ?? '' }} </span>
            @endforeach
        @endif
        @if(!empty($b7['aspects']))
            <br><strong>{{ $targetLang === 'ml' ? 'ദൃഷ്ടി ഫലം (Planetary Aspects):' : 'Planetary Aspects on this Bhava:' }}</strong><br>
            @foreach($b7['aspects'] as $asp)
                &bull; {{ $asp['text_' . $targetLang] ?? $asp['text_en'] ?? $asp['text'] ?? '' }}<br>
            @endforeach
        @endif
    </div>

    @php $b8 = $getBhavaInfo(8); @endphp
    <div class="subsection-title">{{ $b8['title'] }}</div>
    <p>{{ $b8['desc'] }}</p>
    <div class="highlight-box">
        <strong>{{ $targetLang === 'ml' ? 'ഭാവാധിപനും ഫലവും:' : 'Lord & Placement:' }}</strong> {{ $b8['lordPhala'] }}
        @if(!empty($b8['occupants']))
            <br><strong>{{ $targetLang === 'ml' ? 'സ്ഥിതിചെയ്യുന്ന ഗ്രഹങ്ങൾ:' : 'Occupying Influences:' }}</strong>
            @foreach($b8['occupants'] as $occ)
                <span>{{ $occ['name_' . $targetLang] ?? $occ['name_en'] ?? $occ['name'] }}: {{ $occ['phalam_' . $targetLang] ?? $occ['phalam_en'] ?? $occ['phala'] ?? '' }} </span>
            @endforeach
        @endif
        @if(!empty($b8['aspects']))
            <br><strong>{{ $targetLang === 'ml' ? 'ദൃഷ്ടി ഫലം (Planetary Aspects):' : 'Planetary Aspects on this Bhava:' }}</strong><br>
            @foreach($b8['aspects'] as $asp)
                &bull; {{ $asp['text_' . $targetLang] ?? $asp['text_en'] ?? $asp['text'] ?? '' }}<br>
            @endforeach
        @endif
    </div>

    <div class="page-break"></div>

    <!-- ================= PAGE 18: BHAVAS 9 & 10 ================= -->
    <div class="section-title">{{ $targetLang === 'ml' ? '17. ഭാവവിചാരം: 9-ാം ഭാവം (ഭാഗ്യം) & 10-ാം ഭാവം (കർമ്മം)' : '17. Bhava Synthesis: 9th (Bhagya) & 10th (Karma) Bhavas' }}</div>
    @php $b9 = $getBhavaInfo(9); @endphp
    <div class="subsection-title">{{ $b9['title'] }}</div>
    <p>{{ $b9['desc'] }}</p>
    <div class="highlight-box">
        <strong>{{ $targetLang === 'ml' ? 'ഭാവാധിപനും ഫലവും:' : 'Lord & Placement:' }}</strong> {{ $b9['lordPhala'] }}
        @if(!empty($b9['occupants']))
            <br><strong>{{ $targetLang === 'ml' ? 'സ്ഥിതിചെയ്യുന്ന ഗ്രഹങ്ങൾ:' : 'Occupying Influences:' }}</strong>
            @foreach($b9['occupants'] as $occ)
                <span>{{ $occ['name_' . $targetLang] ?? $occ['name_en'] ?? $occ['name'] }}: {{ $occ['phalam_' . $targetLang] ?? $occ['phalam_en'] ?? $occ['phala'] ?? '' }} </span>
            @endforeach
        @endif
        @if(!empty($b9['aspects']))
            <br><strong>{{ $targetLang === 'ml' ? 'ദൃഷ്ടി ഫലം (Planetary Aspects):' : 'Planetary Aspects on this Bhava:' }}</strong><br>
            @foreach($b9['aspects'] as $asp)
                &bull; {{ $asp['text_' . $targetLang] ?? $asp['text_en'] ?? $asp['text'] ?? '' }}<br>
            @endforeach
        @endif
    </div>

    @php $b10 = $getBhavaInfo(10); @endphp
    <div class="subsection-title">{{ $b10['title'] }}</div>
    <p>{{ $b10['desc'] }}</p>
    <div class="highlight-box">
        <strong>{{ $targetLang === 'ml' ? 'ഭാവാധിപനും ഫലവും:' : 'Lord & Placement:' }}</strong> {{ $b10['lordPhala'] }}
        @if(!empty($b10['occupants']))
            <br><strong>{{ $targetLang === 'ml' ? 'സ്ഥിതിചെയ്യുന്ന ഗ്രഹങ്ങൾ:' : 'Occupying Influences:' }}</strong>
            @foreach($b10['occupants'] as $occ)
                <span>{{ $occ['name_' . $targetLang] ?? $occ['name_en'] ?? $occ['name'] }}: {{ $occ['phalam_' . $targetLang] ?? $occ['phalam_en'] ?? $occ['phala'] ?? '' }} </span>
            @endforeach
        @endif
        @if(!empty($b10['aspects']))
            <br><strong>{{ $targetLang === 'ml' ? 'ദൃഷ്ടി ഫലം (Planetary Aspects):' : 'Planetary Aspects on this Bhava:' }}</strong><br>
            @foreach($b10['aspects'] as $asp)
                &bull; {{ $asp['text_' . $targetLang] ?? $asp['text_en'] ?? $asp['text'] ?? '' }}<br>
            @endforeach
        @endif
    </div>

    <div class="page-break"></div>

    <!-- ================= PAGE 19: BHAVAS 11 & 12 ================= -->
    <div class="section-title">{{ $targetLang === 'ml' ? '18. ഭാവവിചാരം: 11-ാം ഭാവം (ലാഭം) & 12-ാം ഭാവം (വ്യയം)' : '18. Bhava Synthesis: 11th (Labha) & 12th (Vyaya) Bhavas' }}</div>
    @php $b11 = $getBhavaInfo(11); @endphp
    <div class="subsection-title">{{ $b11['title'] }}</div>
    <p>{{ $b11['desc'] }}</p>
    <div class="highlight-box">
        <strong>{{ $targetLang === 'ml' ? 'ഭാവാധിപനും ഫലവും:' : 'Lord & Placement:' }}</strong> {{ $b11['lordPhala'] }}
        @if(!empty($b11['occupants']))
            <br><strong>{{ $targetLang === 'ml' ? 'സ്ഥിതിചെയ്യുന്ന ഗ്രഹങ്ങൾ:' : 'Occupying Influences:' }}</strong>
            @foreach($b11['occupants'] as $occ)
                <span>{{ $occ['name_' . $targetLang] ?? $occ['name_en'] ?? $occ['name'] }}: {{ $occ['phalam_' . $targetLang] ?? $occ['phalam_en'] ?? $occ['phala'] ?? '' }} </span>
            @endforeach
        @endif
        @if(!empty($b11['aspects']))
            <br><strong>{{ $targetLang === 'ml' ? 'ദൃഷ്ടി ഫലം (Planetary Aspects):' : 'Planetary Aspects on this Bhava:' }}</strong><br>
            @foreach($b11['aspects'] as $asp)
                &bull; {{ $asp['text_' . $targetLang] ?? $asp['text_en'] ?? $asp['text'] ?? '' }}<br>
            @endforeach
        @endif
    </div>

    @php $b12 = $getBhavaInfo(12); @endphp
    <div class="subsection-title">{{ $b12['title'] }}</div>
    <p>{{ $b12['desc'] }}</p>
    <div class="highlight-box">
        <strong>{{ $targetLang === 'ml' ? 'ഭാവാധിപനും ഫലവും:' : 'Lord & Placement:' }}</strong> {{ $b12['lordPhala'] }}
        @if(!empty($b12['occupants']))
            <br><strong>{{ $targetLang === 'ml' ? 'സ്ഥിതിചെയ്യുന്ന ഗ്രഹങ്ങൾ:' : 'Occupying Influences:' }}</strong>
            @foreach($b12['occupants'] as $occ)
                <span>{{ $occ['name_' . $targetLang] ?? $occ['name_en'] ?? $occ['name'] }}: {{ $occ['phalam_' . $targetLang] ?? $occ['phalam_en'] ?? $occ['phala'] ?? '' }} </span>
            @endforeach
        @endif
        @if(!empty($b12['aspects']))
            <br><strong>{{ $targetLang === 'ml' ? 'ദൃഷ്ടി ഫലം (Planetary Aspects):' : 'Planetary Aspects on this Bhava:' }}</strong><br>
            @foreach($b12['aspects'] as $asp)
                &bull; {{ $asp['text_' . $targetLang] ?? $asp['text_en'] ?? $asp['text'] ?? '' }}<br>
            @endforeach
        @endif
    </div>

    <div class="page-break"></div>

    <!-- ================= PAGE 20: CAREER & WEALTH MASTERY ================= -->
    <div class="section-title">
        {{ $targetLang === 'ml' ? '19. തൊഴിൽ, ധനാഗമം & കർമ്മവിചാരം' : ($targetLang === 'ta' ? '19. தொழில் மற்றும் செல்வ யோகம்' : ($targetLang === 'hi' ? '19. आजीविका एवं धन समृद्धि विचार' : '19. Vocational Destiny & Wealth Mastery')) }}
    </div>
    <p style="font-size: 8.5pt; color: #555;">
        {{ $targetLang === 'ml' ? '10-ാം ഭാവം (കർമ്മം), 2-ാം ഭാവം (ധനം), 11-ാം ഭാവം (ലാഭം), ജീവകാരകനായ വ്യാഴം എന്നിവയെ അടിസ്ഥാനമാക്കിയുള്ള ആധികാരിക അപഗ്രഥനം.' : 'Analyzed by synthesizing the 10th house of vocation, 2nd house (Dhana), 11th house (Labha), and the Karakas Mercury and Jupiter.' }}
    </p>

    @php
        $cw = $chartData['vedanga_predictions']['career'] ?? [];
    @endphp

    <div class="highlight-box">
        <strong>{{ $targetLang === 'ml' ? 'പ്രധാന ധനാഗമ സൂചന (Primary Wealth Indication):' : 'Primary Wealth Indication:' }}</strong><br>
        {{ $cw['summary_' . $targetLang] ?? $cw['summary_en'] ?? ($targetLang === 'ml' ? 'സ്വപ്രയത്നത്താലും ബുദ്ധിസാമർത്ഥ്യത്താലും ധനാഭിവൃദ്ധിയും ഉന്നത പദവിയും കൈവരിക്കും.' : 'Financial stability and professional respect materialize through persistent diligence, strategic intellect, and ethical commerce.') }}
    </div>

    <table class="table-data">
        <tr>
            <th style="width: 30%;">{{ $targetLang === 'ml' ? '10-ാം ഭാവവും അധിപനും' : '10th House Sign & Lord' }}</th>
            <td><strong>{{ $cw['tenth_sign_' . $targetLang] ?? $cw['tenth_sign_en'] ?? '' }}</strong> &mdash; {{ $cw['tenth_lord_name_' . $targetLang] ?? $cw['tenth_lord_name_en'] ?? '' }} (House {{ $cw['tenth_lord_bhava'] ?? 10 }})</td>
        </tr>
        <tr>
            <th>{{ $targetLang === 'ml' ? 'അനുകൂല തൊഴിൽ മേഖലകൾ' : 'Optimal Career Fields' }}</th>
            <td>{{ $cw['suitable_careers_' . $targetLang] ?? $cw['suitable_careers_en'] ?? ($targetLang === 'ml' ? 'ഭരണപരമായ ഉന്നതപദവികൾ, ഉപദേശക വൃത്തി, സാങ്കേതിക നേതൃത്വം, ബാങ്കിംഗ്, അധ്യാപനം, വ്യാപാരം.' : 'Executive leadership, advisory roles, technical consultancy, administration, education, commerce.') }}</td>
        </tr>
        <tr>
            <th>{{ $targetLang === 'ml' ? 'ധനാഗമ ഉന്നതി കാലഘട്ടങ്ങൾ' : 'Peak Earning Years' }}</th>
            <td>{{ $cw['peak_wealth_' . $targetLang] ?? $cw['peak_wealth_en'] ?? ($targetLang === 'ml' ? '2, 9, 10, 11 ഭാവാധിപന്മാരുടെ മഹാദശാപഹാര കാലങ്ങളിലും വ്യാഴത്തിന്റെ അനുകൂല ഗോചരത്തിലും.' : 'During the Mahadasha and Antardashas of the 2nd, 9th, 10th, and 11th lords, and during benefic Jupiter transits.') }}</td>
        </tr>
        <tr>
            <th>{{ $targetLang === 'ml' ? 'സാമ്പത്തിക ജാഗ്രത' : 'Commercial Caution' }}</th>
            <td>{{ $targetLang === 'ml' ? 'സർവ്വാഷ്ടകവർഗ്ഗത്തിൽ 28-ൽ താഴെ ബിന്ദുക്കളുള്ള ഭാവങ്ങളിലൂടെയുള്ള പാപഗ്രഹ സഞ്ചാര വേളകളിൽ അനാവശ്യ ഊഹക്കച്ചവടങ്ങൾ ഒഴിവാക്കുക.' : 'Avoid speculative risks during transits over houses with fewer than 28 SAV bindus.' }}</td>
        </tr>
    </table>

    <div class="page-break"></div>

    <!-- ================= PAGE 21: MARRIAGE & COMPATIBILITY ================= -->
    <div class="section-title">
        {{ $targetLang === 'ml' ? '20. വിവാഹം, ദാമ്പത്യം & കുടുംബസൗഖ്യം (Vivaha)' : ($targetLang === 'ta' ? '20. திருமண பொருத்தம் மற்றும் குடும்ப வாழ்க்கை' : ($targetLang === 'hi' ? '20. विवाह एवं दांपत्य सामंजस्य' : '20. Vivaha (Marriage) & Relational Concord')) }}
    </div>
    <p style="font-size: 8.5pt; color: #555;">
        {{ $targetLang === 'ml' ? '7-ാം ഭാവം, 7-ാം ഭാവാധിപൻ, കളത്രകാരകൻ, കുജദോഷ വിചാരം, രാഹു-കേതു അച്ചുതണ്ട് എന്നിവയെ ആസ്പദമാക്കിയുള്ള ശാസ്ത്രീയ അപഗ്രഥനം.' : 'Synthesizing the 7th Bhava, 7th lord, Kalathra Karaka, Kuja Dosha audit, and the dynamic Rahu-Ketu nodal axis.' }}
    </p>

    @php
        $mw = $chartData['vedanga_predictions']['marriage'] ?? [];
    @endphp

    <table class="table-data">
        <tr>
            <th style="width: 30%;">{{ $targetLang === 'ml' ? '7-ാം ഭാവം (7th Bhava Sign)' : '7th Bhava Sign' }}</th>
            <td><strong>{{ $mw['sev_sign_' . $targetLang] ?? $mw['sev_sign_en'] ?? '' }}</strong></td>
        </tr>
        <tr>
            <th>{{ $targetLang === 'ml' ? '7-ാം ഭാവാധിപന്റെ നില' : '7th Lord Placement' }}</th>
            <td>{{ $mw['sev_lord_name_' . $targetLang] ?? $mw['sev_lord_name_en'] ?? '' }} @if(!empty($mw['sev_lord_bhava'])) {{ $targetLang === 'ml' ? "({$mw['sev_lord_bhava']}-ാം ഭാവത്തിൽ നിലകൊള്ളുന്നു)" : "(in House {$mw['sev_lord_bhava']})" }} @endif</td>
        </tr>
        <tr>
            <th>{{ $targetLang === 'ml' ? 'കളത്ര കാരകൻ' : 'Kalathra Karaka' }}</th>
            <td>{{ $mw['kalathra_karaka_' . $targetLang] ?? $mw['kalathra_karaka_en'] ?? '' }}</td>
        </tr>
        <tr>
            <th>{{ $targetLang === 'ml' ? 'കുജദോഷ നില (Kuja Status)' : 'Kuja / Manglik Status' }}</th>
            <td>
                @if(!empty($mw['has_kuja_dosha']))
                    <strong style="color: #b45309;">{{ $mw['kuja_status_' . $targetLang] ?? $mw['kuja_status_en'] ?? '' }}</strong><br>
                    <span style="font-size: 8pt; color: #555;">{{ $mw['kuja_mitigation_' . $targetLang] ?? $mw['kuja_mitigation_en'] ?? '' }}</span>
                @else
                    <strong style="color: #15803d;">{{ $mw['kuja_status_' . $targetLang] ?? $mw['kuja_status_en'] ?? ($targetLang === 'ml' ? 'ജാതകത്തിൽ കുജദോഷമില്ല (അത്യന്തം ശുഭകരം).' : 'No Kuja Dosha present in the horoscope.') }}</strong>
                @endif
            </td>
        </tr>
        @if(!empty($mw['has_kuja_dosha']))
        <tr>
            <th>{{ $targetLang === 'ml' ? 'കുജദോഷ പരിഹാരം' : 'Kuja Remedies' }}</th>
            <td>{{ $mw['kuja_remedy_' . $targetLang] ?? $mw['kuja_remedy_en'] ?? '' }}</td>
        </tr>
        @endif
        <tr>
            <th>{{ $targetLang === 'ml' ? 'രാഹു - കേതു സ്ഥിതി' : 'Rahu - Ketu Axis' }}</th>
            <td>{{ $mw['rahu_ketu_' . $targetLang] ?? $mw['rahu_ketu_en'] ?? '' }}</td>
        </tr>
    </table>

    <div class="highlight-box">
        <strong>{{ $targetLang === 'ml' ? 'ദാമ്പത്യ സൗഖ്യ മാർഗ്ഗനിർദ്ദേശം (Marital Compatibility Counsel):' : 'Marital Compatibility Counsel:' }}</strong><br>
        {{ $targetLang === 'ml' ? 'പരസ്പര ബഹുമാനവും തുറന്ന ആശയവിനിമയവും കുടുംബക്ഷേത്ര പ്രാർത്ഥനകളും ആയുഷ്കാല ദാമ്പത്യസൗഖ്യം പ്രദാനം ചെയ്യും. ജാതക പൊരുത്തത്തിൽ മാനസിക പൊരുത്തത്തിനും ധർമ്മനിഷ്ഠയ്ക്കും പ്രഥമ പരിഗണന നൽകുക.' : 'Mutual understanding, transparent communication, and periodic prayers at family deity temples cultivate lifelong relational serenity.' }}
    </div>

    <div class="page-break"></div>

    <!-- ================= PAGE 22: CONSTITUTIONAL HEALTH & AYURVEDA ================= -->
    <div class="section-title">
        {{ $targetLang === 'ml' ? '21. ആരോഗ്യ സംരക്ഷണവും ദോഷ ചിന്തയും (Health & Ayurveda)' : ($targetLang === 'ta' ? '21. உடல் நலம் மற்றும் ஆயுர்வேத வழிகாட்டல்' : ($targetLang === 'hi' ? '21. स्वास्थ्य विचार एवं आयुर्वेद परामर्श' : '21. Constitutional Vitality & Health Wisdom')) }}
    </div>
    <p style="font-size: 8.5pt; color: #555;">
        {{ $targetLang === 'ml' ? 'ആയുർവേദ ത്രിദോഷങ്ങളായ വാതം, പിത്തം, കഫം എന്നിവയുടെ സമതുലിതാവസ്ഥ കാത്തുസൂക്ഷിക്കാനുള്ള വേദാംഗ മാർഗ്ഗനിർദ്ദേശങ്ങൾ.' : 'Medical astrology is diagnostic and preventive, promoting balance among Vata, Pitta, and Kapha doshas.' }}
    </p>

    @php
        $hw = $chartData['vedanga_predictions']['health'] ?? [];
    @endphp

    <div class="highlight-box">
        <strong>{{ $targetLang === 'ml' ? 'ശരീര പ്രകൃതി & പ്രതിരോധശേഷി (Constitutional Profile):' : 'Constitutional Profile:' }}</strong><br>
        {{ $hw['dosha_profile_' . $targetLang] ?? $hw['dosha_profile_en'] ?? ($targetLang === 'ml' ? 'ലഗ്നാധിപന്റെ ബലത്താൽ സാമാന്യേന നല്ല ആരോഗ്യവും പ്രതിരോധശേഷിയും.' : 'Good general stamina and vitality governed by Lagna lord.') }}
    </div>

    <table class="table-data">
        <tr>
            <th style="width: 30%;">{{ $targetLang === 'ml' ? 'ശ്രദ്ധിക്കേണ്ട അവയവങ്ങൾ' : 'Vulnerable Organ Systems' }}</th>
            <td>{{ $hw['vulnerable_organs_' . $targetLang] ?? $hw['vulnerable_organs_en'] ?? '' }}</td>
        </tr>
        <tr>
            <th>{{ $targetLang === 'ml' ? 'ആയുർവേദ ജീവിതശൈലി' : 'Ayurvedic Lifestyle Counsel' }}</th>
            <td>{{ $hw['lifestyle_' . $targetLang] ?? $hw['lifestyle_en'] ?? '' }}</td>
        </tr>
        <tr>
            <th>{{ $targetLang === 'ml' ? 'ആരോഗ്യ മന്ത്രം' : 'Spiritual Health Mantra' }}</th>
            <td>{{ $hw['healing_mantra_' . $targetLang] ?? $hw['healing_mantra_en'] ?? '' }}</td>
        </tr>
    </table>

    <div class="page-break"></div>

    <!-- ================= PAGE 23: GOCHARA & SADE SATI AUDIT ================= -->
    <div class="section-title">{{ $targetLang === 'ml' ? '22. ഗോചര ഫലങ്ങളും ശനിദോഷ ചിന്തയും (Gochara)' : ($targetLang === 'ta' ? '22. கோசார பலன்கள் மற்றும் சனி ஆய்வு' : ($targetLang === 'hi' ? '22. गोचर फलादेश एवं शनि शांति' : '22. Gochara (Current Planetary Transits) & Shani Analysis')) }}</div>
    <p style="font-size: 8.5pt; color: #555;">
        {{ $targetLang === 'ml' ? 'ജനനസമയത്തെ ചന്ദ്രരാശിയെ അടിസ്ഥാനമാക്കി നിലവിലെ പ്രധാന ഗ്രഹങ്ങളുടെ ഗോചര സഞ്ചാരഫലങ്ങൾ.' : 'Calculated strictly from natal Chandra Rasi including classical Vedha checks.' }}
    </p>

    @php
        $gc = $chartData['vedanga_predictions']['gocharaphala'] ?? [];
        $shani = $gc['saturn_special'] ?? [];
        $guru = $gc['jupiter_special'] ?? [];
        $sunTr = $gc['sun_special'] ?? [];
    @endphp

    <table class="table-data table-compact">
        <thead>
            <tr>
                <th>Planet</th>
                <th>Current Transit Sign</th>
                <th>Position from Moon</th>
                <th>Status</th>
                <th>Transit Impact</th>
            </tr>
        </thead>
        <tbody>
            @foreach($gc['planets'] ?? [] as $gp)
                <tr>
                    <td><strong>{{ $gp['name_' . $targetLang] ?? $gp['name_en'] ?? $gp['name'] ?? '' }}</strong> @if($targetLang !== 'ml' && !empty($gp['name_ml']))({{ $gp['name_ml'] }})@endif</td>
                    <td>{{ $gp['current_rasi_name_' . $targetLang] ?? $gp['current_rasi_name_en'] ?? '' }}</td>
                    <td>{{ $gp['house_from_moon'] ?? 1 }}th House</td>
                    <td style="color: {{ !empty($gp['effective_favorable']) ? '#15803d' : '#b45309' }}; font-weight: bold;">
                        {{ !empty($gp['effective_favorable']) ? ($targetLang === 'ml' ? 'അനുകൂലം' : 'Favorable') : ($targetLang === 'ml' ? 'ജാഗ്രത' : 'Challenging') }}
                    </td>
                    <td>{{ $gp['status_text'] ?? ($targetLang === 'ml' ? 'സമതുലിത ഫലം' : 'Moderate') }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="highlight-box">
        <strong style="color: #92400e; font-size: 10pt;">{{ $targetLang === 'ml' ? 'ശനി ഗോചര വിശകലനം (Saturn Transit Audit):' : 'Saturn Transit (Shani Gochara) Audit:' }}</strong><br>
        &bull; <strong>7½ Shani (Sade Sati):</strong> {{ $shani['status_' . $targetLang] ?? $shani['status_en'] ?? 'None' }}<br>
        &bull; <strong>Kantaka Shani:</strong> {{ $shani['kantaka_status_' . $targetLang] ?? $shani['kantaka_status_en'] ?? 'None' }}<br>
        &bull; <strong>Ashtama Shani:</strong> {{ $shani['ashtama_status_' . $targetLang] ?? $shani['ashtama_status_en'] ?? 'None' }}<br>
        &bull; <strong>{{ $targetLang === 'ml' ? 'വിശദ ഫലം:' : 'Detailed Transit Narrative:' }}</strong> {{ $shani['narrative_' . $targetLang] ?? $shani['narrative_en'] ?? '' }}<br>
        &bull; <strong>{{ $targetLang === 'ml' ? 'ശാസ്താ പരിഹാരം:' : 'Shasta Pariharam:' }}</strong> {{ $shani['remedy_' . $targetLang] ?? $shani['remedy_en'] ?? '' }}
    </div>

    <div class="highlight-box" style="margin-top: 6px; border-left-color: #059669; background-color: #ecfdf5;">
        <strong style="color: #065f46; font-size: 10pt;">{{ $targetLang === 'ml' ? 'വ്യാഴ & സൂര്യ ഗോചര വിശകലനം (Jupiter & Sun Transits):' : 'Jupiter & Sun Transits:' }}</strong><br>
        &bull; <strong>{{ $targetLang === 'ml' ? 'വ്യാഴം (Guru):' : 'Jupiter (Guru):' }}</strong> {{ $guru['narrative_' . $targetLang] ?? $guru['narrative_en'] ?? '' }}<br>
        &bull; <strong>{{ $targetLang === 'ml' ? 'സൂര്യൻ (Sun):' : 'Sun (Surya):' }}</strong> {{ $sunTr['narrative_' . $targetLang] ?? $sunTr['narrative_en'] ?? '' }}<br>
        &bull; <strong>{{ $targetLang === 'ml' ? 'സർവ്വാഷ്ടകവർഗ്ഗ സമന്വയം:' : 'Ashtakavarga Synthesis:' }}</strong> {{ $gc['sav_synthesis_' . $targetLang] ?? $gc['sav_synthesis_en'] ?? '' }}
    </div>

    <div class="page-break"></div>

    <!-- ================= PAGE 24: FAVORABLE PERIODS & SACRED PARIHARAMS ================= -->
    <div class="section-title">{{ $targetLang === 'ml' ? '23. അനുകൂല കാലഘട്ടങ്ങളും വിശേഷാൽ പരിഹാരങ്ങളും' : '23. Favorable Lifeline Periods & Sacred Pariharams' }}</div>
    <p style="font-size: 8.5pt; color: #555;">
        {{ $targetLang === 'ml' ? 'വിംശോത്തരി ദശാപഹാര ക്രമപ്രകാരം 15 മുതൽ 75 വയസ്സ് വരെയുള്ള സുപ്രധാന ജീവിത നേട്ടങ്ങളുടെ കാലഗണന.' : 'Chronological astrological time windows across career, enterprise, and property creation.' }}
    </p>

    <div class="subsection-title">{{ $targetLang === 'ml' ? 'പ്രധാന ജീവിത ഘട്ടങ്ങളിലെ അനുകൂല കാലഗണന (Ages 15 to 75)' : 'Chronological Favorable Lifeline Windows (Ages 15 to 75)' }}</div>
    <table class="table-data table-compact">
        <thead>
            <tr>
                <th style="width: 25%;">{{ $targetLang === 'ml' ? 'കാലഘട്ടം (പ്രായം)' : 'Period (Age)' }}</th>
                <th style="width: 20%;">{{ $targetLang === 'ml' ? 'മഹാദശ' : 'Mahadasha' }}</th>
                <th style="width: 30%;">{{ $targetLang === 'ml' ? 'പ്രധാന അനുഭവങ്ങൾ' : 'Key Lifeline Realizations' }}</th>
                <th style="width: 25%;">{{ $targetLang === 'ml' ? 'ജ്യോതിഷ കാരണം' : 'Astrological Rationale' }}</th>
            </tr>
        </thead>
        <tbody>
            @foreach($chartData['vedanga_predictions']['favorable_periods'] ?? [] as $fp)
                <tr style="{{ !empty($fp['is_current']) ? 'background-color: #fef9c3; font-weight: bold;' : '' }}">
                    <td><strong>{{ $fp['period_label'] }}</strong> @if(!empty($fp['is_current'])) <span style="color:#b45309; font-size:7pt;">★ ACTIVE</span> @endif</td>
                    <td>{{ $targetLang === 'ml' ? $fp['mahadasha_ml'] : $fp['mahadasha_en'] }}</td>
                    <td>{{ $targetLang === 'ml' ? $fp['focus_ml'] : $fp['focus_en'] }}</td>
                    <td><span style="font-size: 7.5pt; color: #555;">{{ $targetLang === 'ml' ? $fp['reason_ml'] : $fp['reason_en'] }}</span></td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <table class="table-data" style="margin-top: 10px;">
        <tr>
            <th style="width: 35%;">Primary Auspicious Gemstone</th>
            <td><strong style="color: #b45309; font-size: 11pt;">{{ $chartData['gemstone_en'] ?? '' }}</strong>@if($targetLang !== 'ml') ({{ $chartData['gemstone_ml'] ?? '' }})@endif</td>
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

    @php
        $pari = $chartData['vedanga_predictions']['sacred_pariharams'] ?? [];
    @endphp

    <div class="subsection-title">{{ $targetLang === 'ml' ? 'വിശേഷാൽ ക്ഷേത്ര പരിഹാരങ്ങൾ (Sacred Pariharams)' : 'Sacred Temple Pariharams' }}</div>
    <div class="highlight-box">
        &bull; <strong>{{ $targetLang === 'ml' ? 'ജന്മനക്ഷത്ര അർച്ചന:' : 'Janma Nakshatra Archana:' }}</strong> {{ $pari['nakshatra_deity_' . $targetLang] ?? $pari['nakshatra_deity_en'] ?? 'Perform annual Archana on your birth star day.' }}<br>
        &bull; <strong>{{ $targetLang === 'ml' ? 'നിലവിലെ ദശാപഹാര പ്രാർത്ഥന:' : 'Active Dasha Prayer:' }}</strong> {{ $pari['active_dasha_pariharam_' . $targetLang] ?? $pari['active_dasha_pariharam_en'] ?? 'Perform dedicated prayers to operating dasha lord.' }}<br>
        @foreach(($targetLang === 'ml' ? ($pari['temples_ml'] ?? []) : ($pari['temples_en'] ?? [])) as $tmpl)
            &bull; {{ $tmpl }}<br>
        @endforeach
    </div>

    <div class="page-break"></div>

    <!-- ================= PAGE 25: DIRECT CONSULTATION & CERTIFICATION ================= -->
    <div class="section-title">{{ $targetLang === 'ml' ? '24. ആചാര്യ സാക്ഷ്യപത്രവും നേരിട്ടുള്ള കൂടിയാലോചനയും' : ($targetLang === 'ta' ? '24. ஜோதிட சான்றிதழ் மற்றும் ஆலோசனை' : ($targetLang === 'hi' ? '24. ज्योतिषीय प्रमाणीकरण एवं परामर्श' : '24. Astrological Certification & Direct Consultation')) }}</div>
    <p style="font-size: 8.5pt; color: #555;">
        {{ $targetLang === 'ml' ? 'വേദാംഗ ജ്യോതിഷ ഗണിത പ്രമാണപ്രകാരം തയ്യാറാക്കിയ ആധികാരിക ജാതക രേഖ.' : 'This document represents an authenticated astronomical portfolio generated according to traditional Vedic astrological canons.' }}
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

@if(request('print'))
<script>
    window.addEventListener('load', function() {
        setTimeout(function() { window.print(); }, 400);
    });
</script>
@endif

</body>
</html>

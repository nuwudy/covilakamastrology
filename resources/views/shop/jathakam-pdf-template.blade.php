<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Deluxe Vedic Jathakam - {{ $customerName }} | Covilakam Astrology</title>
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cinzel:wght@600;700;800;900&family=Playfair+Display:ital,wght@0,600;0,700;1,400&family=Plus+Jakarta+Sans:wght@300;400;500;600;700&family=Noto+Sans+Malayalam:wght@400;500;600;700&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        @media print {
            body { background: #fff !important; color: #000 !important; }
            .no-print { display: none !important; }
            .page-break { page-break-before: always; }
            .print-border { border: 2px solid #b45309 !important; }
        }
        .south-indian-chart {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            grid-template-rows: repeat(4, 1fr);
            aspect-ratio: 1 / 1;
            border: 2px solid #b45309;
        }
        .chart-cell {
            border: 1px solid #b45309;
            padding: 4px;
            font-size: 10px;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            min-height: 55px;
        }
        .chart-center {
            grid-column: 2 / span 2;
            grid-row: 2 / span 2;
            border: 1px solid #b45309;
            display: flex;
            align-items: center;
            justify-content: center;
            text-align: center;
            background: rgba(217, 119, 6, 0.08);
            font-weight: bold;
            font-family: 'Cinzel', serif;
        }
    </style>
</head>
<body class="bg-[#12081f] text-amber-100 font-sans print:bg-white print:text-gray-900 min-h-screen py-8">

    <!-- Action Bar (Hidden in Print) -->
    <div class="no-print max-w-4xl mx-auto px-4 mb-6 flex flex-wrap items-center justify-between gap-4">
        <a href="{{ route('shop.confirmation', $order->order_number) }}"
           class="text-xs text-amber-300 hover:text-amber-100 flex items-center space-x-1">
            <span>← Back to Order Summary</span>
        </a>

        <div class="flex items-center space-x-3">
            <button onclick="window.print()"
                    class="px-5 py-2.5 rounded-xl font-cinzel font-bold text-xs uppercase tracking-wider text-[#1a1128] bg-gradient-to-r from-amber-300 via-yellow-400 to-amber-500 hover:from-amber-200 hover:to-yellow-300 shadow-xl transition-all flex items-center space-x-2">
                <span>🖨️</span>
                <span>Print / Save as PDF</span>
            </button>
        </div>
    </div>

    <!-- Main Printable Jathakam Document Sheet -->
    <div class="max-w-4xl mx-auto bg-[#1a1128] print:bg-white border-2 border-amber-500/40 print:border-amber-700 shadow-2xl rounded-3xl p-6 sm:p-12 relative overflow-hidden">

        <!-- Top Ornamental Seal & Header -->
        <div class="text-center border-b-2 border-amber-500/30 print:border-amber-700 pb-8 mb-8 space-y-2">
            <div class="w-20 h-20 mx-auto rounded-full p-1 bg-gradient-to-tr from-amber-600 via-amber-300 to-yellow-500 shadow-xl mb-3">
                <img src="{{ asset('images/og-covilakam-512x512.png') }}"
                     alt="Covilakam Astrology Emblem"
                     class="w-full h-full rounded-full object-cover">
            </div>

            <p class="font-cinzel text-xs tracking-[0.3em] uppercase text-amber-400 print:text-amber-800 font-bold">
                ॐ ശ്രീ ഗണേശായ നമഃ • Om Sri Ganeshaya Namaha
            </p>

            <h1 class="font-cinzel text-2xl sm:text-4xl font-extrabold text-amber-300 print:text-amber-900 tracking-wider">
                COVILAKAM ASTROLOGY
            </h1>

            <p class="font-cinzel text-xs sm:text-sm font-bold text-amber-200 print:text-amber-800">
                DR. E. K. RAJA VARMA
            </p>
            <p class="text-[11px] text-amber-300/80 print:text-gray-700 italic">
                (Vidya Vachaspathi in Vedic Astrology • IAF Fellow #11009 • Ph.D. & 2026 Gold Medalist)
            </p>

            <div class="pt-2">
                <span class="inline-block px-4 py-1 rounded-full border border-amber-500/40 bg-amber-500/10 text-amber-300 print:text-amber-900 text-xs font-cinzel font-bold uppercase tracking-widest">
                    DELUXE VEDIC JATHAKAM REPORT (സമ്പൂർണ്ണ ജാതകം)
                </span>
            </div>
        </div>

        <!-- Jathakam Custody & Birth Metadata -->
        <div class="bg-[#12081f] print:bg-amber-50/50 p-5 rounded-2xl border border-amber-500/20 print:border-amber-300 mb-8 grid grid-cols-2 sm:grid-cols-4 gap-4 text-xs">
            <div>
                <span class="text-[10px] text-amber-400 print:text-amber-800 uppercase font-bold block">Native Name (ജാതകൻ):</span>
                <strong class="text-amber-200 print:text-gray-900 text-sm">{{ $customerName }}</strong>
            </div>
            <div>
                <span class="text-[10px] text-amber-400 print:text-amber-800 uppercase font-bold block">Date of Birth (ജനന തീയതി):</span>
                <span class="text-amber-100 print:text-gray-800 font-medium">{{ \Carbon\Carbon::parse($birthDate)->format('d F Y') }}</span>
            </div>
            <div>
                <span class="text-[10px] text-amber-400 print:text-amber-800 uppercase font-bold block">Time of Birth (ജനന സമയം):</span>
                <span class="text-amber-100 print:text-gray-800 font-medium">{{ $birthTime }}</span>
            </div>
            <div>
                <span class="text-[10px] text-amber-400 print:text-amber-800 uppercase font-bold block">Place of Birth (ജനന സ്ഥലം):</span>
                <span class="text-amber-100 print:text-gray-800 font-medium">{{ $birthPlace }}</span>
            </div>
        </div>

        <!-- Astrological Charts Section (Traditional South Indian Format) -->
        <div class="mb-10">
            <h2 class="font-cinzel text-lg font-bold text-amber-300 print:text-amber-900 mb-4 pb-1 border-b border-amber-500/20 flex items-center justify-between">
                <span>Vedic Birth Kundali (രാശി & നവാംശ ചക്രങ്ങൾ)</span>
                <span class="text-xs text-amber-400 print:text-amber-800 font-normal">South Indian Square Format</span>
            </h2>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 items-center">
                <!-- Rasi Chart (South Indian) -->
                <div class="bg-[#12081f] print:bg-white p-4 rounded-2xl border border-amber-500/25">
                    <h3 class="text-xs font-cinzel font-bold text-center text-amber-300 print:text-amber-900 mb-2 uppercase tracking-wider">
                        Rasi Chakra (രാശി ചക്രം)
                    </h3>
                    <div class="south-indian-chart text-[9px] text-amber-200 print:text-gray-800">
                        <!-- Row 1 -->
                        <div class="chart-cell"><span class="text-[8px] text-amber-400">12. മീനം (Pisces)</span><span>ഗുരു (Jup)</span></div>
                        <div class="chart-cell"><span class="text-[8px] text-amber-400">1. മേടം (Aries)</span><span class="font-bold text-amber-300">ലഗ്നം (Lagna)</span></div>
                        <div class="chart-cell"><span class="text-[8px] text-amber-400">2. ഇടവം (Taurus)</span><span>ചന്ദ്രൻ (Moon)</span></div>
                        <div class="chart-cell"><span class="text-[8px] text-amber-400">3. മിഥുനം (Gemini)</span><span>ബുധൻ (Merc)</span></div>
                        <!-- Row 2 -->
                        <div class="chart-cell"><span class="text-[8px] text-amber-400">11. കുംഭം (Aquarius)</span><span>ശനി (Sat)</span></div>
                        <div class="chart-center">
                            <div>
                                <span class="text-xs text-amber-300 print:text-amber-900 block font-bold">RASI</span>
                                <span class="text-[9px] text-amber-400/80">{{ $customerName }}</span>
                            </div>
                        </div>
                        <div class="chart-cell"><span class="text-[8px] text-amber-400">4. കർക്കടകം (Cancer)</span><span>കുജൻ (Mars)</span></div>
                        <!-- Row 3 -->
                        <div class="chart-cell"><span class="text-[8px] text-amber-400">10. മകരം (Capricorn)</span><span>കേതു (Ketu)</span></div>
                        <div class="chart-cell"><span class="text-[8px] text-amber-400">5. ചിങ്ങം (Leo)</span><span>സൂര്യൻ (Sun)</span></div>
                        <!-- Row 4 -->
                        <div class="chart-cell"><span class="text-[8px] text-amber-400">9. ധനു (Sagittarius)</span><span>രാഹു (Rahu)</span></div>
                        <div class="chart-cell"><span class="text-[8px] text-amber-400">8. വൃശ്ചികം (Scorpio)</span><span>-</span></div>
                        <div class="chart-cell"><span class="text-[8px] text-amber-400">7. തുലാം (Libra)</span><span>ശുക്രൻ (Venus)</span></div>
                        <div class="chart-cell"><span class="text-[8px] text-amber-400">6. കന്നി (Virgo)</span><span>-</span></div>
                    </div>
                </div>

                <!-- Navamsha Chart -->
                <div class="bg-[#12081f] print:bg-white p-4 rounded-2xl border border-amber-500/25">
                    <h3 class="text-xs font-cinzel font-bold text-center text-amber-300 print:text-amber-900 mb-2 uppercase tracking-wider">
                        Navamsha Chakra (നവാംശകം D-9)
                    </h3>
                    <div class="south-indian-chart text-[9px] text-amber-200 print:text-gray-800">
                        <!-- Row 1 -->
                        <div class="chart-cell"><span class="text-[8px] text-amber-400">12. മീനം</span><span>ശുക്രൻ (Ven)</span></div>
                        <div class="chart-cell"><span class="text-[8px] text-amber-400">1. മേടം</span><span>സൂര്യൻ (Sun)</span></div>
                        <div class="chart-cell"><span class="text-[8px] text-amber-400">2. ഇടവം</span><span>-</span></div>
                        <div class="chart-cell"><span class="text-[8px] text-amber-400">3. മിഥുനം</span><span>കുജൻ (Mars)</span></div>
                        <!-- Row 2 -->
                        <div class="chart-cell"><span class="text-[8px] text-amber-400">11. കുംഭം</span><span>-</span></div>
                        <div class="chart-center">
                            <div>
                                <span class="text-xs text-amber-300 print:text-amber-900 block font-bold">NAVAMSHA</span>
                                <span class="text-[9px] text-amber-400/80">D-9 Chart</span>
                            </div>
                        </div>
                        <div class="chart-cell"><span class="text-[8px] text-amber-400">4. കർക്കടകം</span><span class="font-bold text-amber-300">ലഗ്നം</span></div>
                        <!-- Row 3 -->
                        <div class="chart-cell"><span class="text-[8px] text-amber-400">10. മകരം</span><span>ശനി (Sat)</span></div>
                        <div class="chart-cell"><span class="text-[8px] text-amber-400">5. ചിങ്ങം</span><span>ഗുരു (Jup)</span></div>
                        <!-- Row 4 -->
                        <div class="chart-cell"><span class="text-[8px] text-amber-400">9. ധനു</span><span>കേതു (Ketu)</span></div>
                        <div class="chart-cell"><span class="text-[8px] text-amber-400">8. വൃശ്ചികം</span><span>ബുധൻ (Merc)</span></div>
                        <div class="chart-cell"><span class="text-[8px] text-amber-400">7. തുലാം</span><span>ചന്ദ്രൻ (Moon)</span></div>
                        <div class="chart-cell"><span class="text-[8px] text-amber-400">6. കന്നി</span><span>രാഹു (Rahu)</span></div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Calculated Vedic Astrological Pillars -->
        <div class="mb-10 space-y-6">
            <h2 class="font-cinzel text-lg font-bold text-amber-300 print:text-amber-900 pb-1 border-b border-amber-500/20">
                Planetary Dominance & Core Astrological Profile
            </h2>

            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 text-xs">
                <div class="bg-[#12081f] print:bg-amber-50 p-4 rounded-xl border border-amber-500/20">
                    <span class="text-[10px] text-amber-400 print:text-amber-800 uppercase font-bold block mb-1">Ruling Cosmic Planet (അധിപ ഗ്രഹം):</span>
                    <strong class="text-amber-200 print:text-gray-900 text-sm block">{{ $jathakamData['ruling_planet']['en'] ?? '' }}</strong>
                    <span class="text-[11px] text-amber-300/80 print:text-gray-700">{{ $jathakamData['ruling_planet']['ml'] ?? '' }}</span>
                </div>

                <div class="bg-[#12081f] print:bg-amber-50 p-4 rounded-xl border border-amber-500/20">
                    <span class="text-[10px] text-amber-400 print:text-amber-800 uppercase font-bold block mb-1">Astrological Archetype:</span>
                    <strong class="text-amber-200 print:text-gray-900 text-sm block">{{ $jathakamData['archetype']['en'] ?? '' }}</strong>
                    <span class="text-[11px] text-amber-300/80 print:text-gray-700">{{ $jathakamData['archetype']['ml'] ?? '' }}</span>
                </div>

                <div class="bg-[#12081f] print:bg-amber-50 p-4 rounded-xl border border-amber-500/20">
                    <span class="text-[10px] text-amber-400 print:text-amber-800 uppercase font-bold block mb-1">Presiding Deva Deity:</span>
                    <strong class="text-amber-200 print:text-gray-900 text-sm block">{{ $jathakamData['ruling_planet']['deity']['en'] ?? '' }}</strong>
                    <span class="text-[11px] text-amber-300/80 print:text-gray-700">{{ $jathakamData['ruling_planet']['deity']['ml'] ?? '' }}</span>
                </div>
            </div>

            <!-- Personality & Traits -->
            <div class="bg-[#12081f] print:bg-white p-5 rounded-2xl border border-amber-500/20 space-y-2">
                <h3 class="font-cinzel text-xs font-bold text-amber-300 print:text-amber-900 uppercase">
                    Core Personality Traits (സ്വഭാവ ഗുണങ്ങൾ)
                </h3>
                <p class="text-xs text-amber-100/90 print:text-gray-800 leading-relaxed">
                    {{ $jathakamData['traits']['en'] ?? '' }}
                </p>
                <p class="text-xs text-amber-300/90 print:text-gray-700 leading-relaxed pt-1">
                    {{ $jathakamData['traits']['ml'] ?? '' }}
                </p>
            </div>

            <!-- Life Forecasts: Career, Relationships, Spirituality -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 text-xs">
                <div class="bg-[#12081f] print:bg-amber-50/50 p-4 rounded-xl border border-amber-500/20 space-y-1.5">
                    <h4 class="font-cinzel text-xs font-bold text-amber-300 print:text-amber-900 uppercase">💼 Career & Wealth (തൊഴിൽ & ധനം)</h4>
                    <p class="text-[11px] text-amber-100/80 print:text-gray-800 leading-relaxed">{{ $jathakamData['career_prediction']['en'] ?? '' }}</p>
                </div>
                <div class="bg-[#12081f] print:bg-amber-50/50 p-4 rounded-xl border border-amber-500/20 space-y-1.5">
                    <h4 class="font-cinzel text-xs font-bold text-amber-300 print:text-amber-900 uppercase">❤️ Marriage & Bonds (ദാമ്പത്യം)</h4>
                    <p class="text-[11px] text-amber-100/80 print:text-gray-800 leading-relaxed">{{ $jathakamData['relationship_prediction']['en'] ?? '' }}</p>
                </div>
                <div class="bg-[#12081f] print:bg-amber-50/50 p-4 rounded-xl border border-amber-500/20 space-y-1.5">
                    <h4 class="font-cinzel text-xs font-bold text-amber-300 print:text-amber-900 uppercase">🕉️ Spiritual Guidance (ആത്മീയത)</h4>
                    <p class="text-[11px] text-amber-100/80 print:text-gray-800 leading-relaxed">{{ $jathakamData['doctor_remedy']['en'] ?? '' }}</p>
                </div>
            </div>

            <!-- Vimshottari Dasa-Bhukthi Calculations -->
            <div class="bg-[#12081f] print:bg-white p-5 rounded-2xl border border-amber-500/20 space-y-3">
                <h3 class="font-cinzel text-xs font-bold text-amber-300 print:text-amber-900 uppercase tracking-wider flex items-center justify-between">
                    <span>Vimshottari Dasa-Bhukthi Timeline (ദശാപഹാര കാലഘട്ടം)</span>
                    <span class="text-[10px] text-emerald-400 print:text-emerald-800 font-semibold">Active Life Periods</span>
                </h3>
                <div class="overflow-x-auto">
                    <table class="w-full text-left text-xs">
                        <thead>
                            <tr class="border-b border-amber-500/20 text-amber-400 print:text-amber-900 text-[10px] uppercase">
                                <th class="py-2">Major Planetary Dasa</th>
                                <th class="py-2">Sub-Period (Bhukthi)</th>
                                <th class="py-2">Duration</th>
                                <th class="py-2">Astrological Forecast & Recommendations</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-amber-500/10 text-amber-100/90 print:text-gray-800 text-[11px]">
                            <tr>
                                <td class="py-2.5 font-bold text-amber-300 print:text-amber-900">Current Mahadasa</td>
                                <td class="py-2.5 font-medium">{{ $jathakamData['ruling_planet']['en'] ?? '' }} ({{ $jathakamData['ruling_planet']['ml'] ?? '' }})</td>
                                <td class="py-2.5">Present – Next 7 Years</td>
                                <td class="py-2.5">Pivotal period for personal leadership, career recognition, and auspicious beginnings.</td>
                            </tr>
                            <tr>
                                <td class="py-2.5 font-bold text-amber-300 print:text-amber-900">Upcoming Antardasa</td>
                                <td class="py-2.5 font-medium">Brihaspathi (Jupiter Bhukthi)</td>
                                <td class="py-2.5">Follow-up 3 Years</td>
                                <td class="py-2.5">Spiritual expansion, academic attainment, financial stability and harmony in domestic life.</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Gemstone & Vedic Remedies Section -->
            <div class="bg-gradient-to-r from-amber-950/40 via-[#1a1128] to-purple-950/40 print:bg-amber-50 p-6 rounded-2xl border border-amber-500/30 print:border-amber-400 space-y-4">
                <h3 class="font-cinzel text-sm font-bold text-amber-300 print:text-amber-900 uppercase tracking-wider flex items-center space-x-2">
                    <span>💎</span>
                    <span>Auspicious Gemstone & Sacred Remedies (ഭാഗ്യ രത്നവും പരിഹാരങ്ങളും)</span>
                </h3>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 text-xs">
                    <div class="space-y-1">
                        <span class="text-[10px] text-amber-400 print:text-amber-800 uppercase font-semibold">Prescribed Gemstone:</span>
                        <p class="text-base font-bold text-amber-200 print:text-gray-900">{{ $jathakamData['gemstone_en'] ?? '' }}</p>
                        <p class="text-[11px] text-amber-300/80 print:text-gray-700">{{ $jathakamData['gemstone_ml'] ?? '' }}</p>
                    </div>

                    <div class="space-y-1">
                        <span class="text-[10px] text-amber-400 print:text-amber-800 uppercase font-semibold">Wearing Instructions:</span>
                        <p class="text-xs text-amber-100/90 print:text-gray-800 leading-relaxed">{{ $jathakamData['wearing_rule']['en'] ?? '' }}</p>
                    </div>
                </div>

                <div class="pt-2 border-t border-amber-500/20 grid grid-cols-2 sm:grid-cols-3 gap-3 text-xs">
                    <div>
                        <span class="text-[10px] text-amber-400 print:text-amber-800 uppercase font-semibold block">Auspicious Day:</span>
                        <span class="text-amber-100 print:text-gray-800 font-medium">{{ $jathakamData['lucky_day']['en'] ?? '' }}</span>
                    </div>
                    <div>
                        <span class="text-[10px] text-amber-400 print:text-amber-800 uppercase font-semibold block">Lucky Colors:</span>
                        <span class="text-amber-100 print:text-gray-800 font-medium">{{ $jathakamData['lucky_color']['en'] ?? '' }}</span>
                    </div>
                    <div>
                        <span class="text-[10px] text-amber-400 print:text-amber-800 uppercase font-semibold block">Sacred Vedic Mantra:</span>
                        <span class="font-bold text-amber-300 print:text-amber-900">{{ $jathakamData['mantra_sanskrit'] ?? '' }}</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Astrologer Official Signature & Seal (Print Stamp) -->
        <div class="pt-8 border-t-2 border-amber-500/30 print:border-amber-700 flex flex-col sm:flex-row items-center justify-between gap-6 text-center sm:text-left">
            <div class="space-y-1">
                <p class="font-cinzel text-xs font-bold text-amber-300 print:text-gray-900">
                    COVILAKAM ASTROLOGY (കോവിലകം ജ്യോതിഷം)
                </p>
                <p class="text-[11px] text-amber-200/70 print:text-gray-600">
                    Kerala, India • Official Verification Ref: {{ $order->order_number }}
                </p>
                <p class="text-[10px] text-amber-400 print:text-gray-500">
                    Web: www.covilakamastrology.com • WhatsApp: +91 7907052160
                </p>
            </div>

            <div class="text-center sm:text-right space-y-1">
                <div class="font-serif italic text-amber-300 print:text-gray-900 font-bold text-base">
                    DR. E. K. Raja Varma
                </div>
                <div class="w-36 h-0.5 bg-amber-500/50 print:bg-gray-400 mx-auto sm:ml-auto"></div>
                <p class="font-cinzel text-[10px] uppercase font-bold text-amber-400 print:text-gray-700">
                    Vidya Vachaspathi in Vedic Astrology
                </p>
                <p class="text-[9px] text-amber-200/60 print:text-gray-500">
                    Ph.D. & 2026 Gold Medalist (IAF #11009)
                </p>
            </div>
        </div>
    </div>

    <!-- Print Footer Notice -->
    <div class="max-w-4xl mx-auto text-center mt-6 text-[11px] text-amber-200/50 print:text-gray-500">
        © {{ date('Y') }} Covilakam Astrology. All Rights Reserved. Prepared for {{ $customerName }}.
    </div>

</body>
</html>

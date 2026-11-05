@extends('layouts.app')

@section('title', 'Vedic Astrology Prediction Report for ' . ($reading['name'] ?? 'Seeker') . ' | Covilakam Astrology')
@section('meta_description', 'Full Vedic Horoscope and DOB analysis by Dr. E. K. Raja Varma (Vidya Vachaspathi in Vedic Astrology).')

@php
    $currLang = request('lang', 'en');
    if (!in_array($currLang, ['en', 'ml', 'ta', 'hi'])) {
        $currLang = 'en';
    }

    $getText = function($item) use ($currLang) {
        if (is_array($item)) {
            return $item[$currLang] ?? $item['en'] ?? reset($item) ?? '';
        }
        return (string)$item;
    };
@endphp

@section('content')
<div class="pt-28 pb-24 bg-[#0d0716] min-h-screen"
     x-data="{ 
         activeTab: 'overview',
         readingLang: new URLSearchParams(window.location.search).get('lang') || '{{ $currLang }}',
         reading: {{ json_encode($reading) }},
         expandedMaha: null,
         expandedAntar: null,
         expandedPraty: null,
         toggleMaha(idx) {
             this.expandedMaha = (this.expandedMaha === idx ? null : idx);
         },
         toggleAntar(key) {
             this.expandedAntar = (this.expandedAntar === key ? null : key);
         },
         togglePraty(key) {
             this.expandedPraty = (this.expandedPraty === key ? null : key);
         },
         dashaOrderList: [
             { key: 'Ke', name_en: 'Ketu', name_ml: 'കേതു (Ketu)', name_ta: 'கேது', name_hi: 'केतु', y: 7 },
             { key: 'Ve', name_en: 'Venus (Shukra)', name_ml: 'ശുക്രൻ (Shukra)', name_ta: 'சுக்கிரன்', name_hi: 'शुक्र', y: 20 },
             { key: 'Su', name_en: 'Sun (Surya)', name_ml: 'സൂര്യൻ (Surya)', name_ta: 'சூரியன்', name_hi: 'सूर्य', y: 6 },
             { key: 'Mo', name_en: 'Moon (Chandra)', name_ml: 'ചന്ദ്രൻ (Chandra)', name_ta: 'சந்திரன்', name_hi: 'चन्द्र', y: 10 },
             { key: 'Ma', name_en: 'Mars (Kuja)', name_ml: 'ചൊവ്വ (Kuja)', name_ta: 'செவ்வாய்', name_hi: 'मंगल', y: 7 },
             { key: 'Ra', name_en: 'Rahu', name_ml: 'രാഹു (Rahu)', name_ta: 'ராகு', name_hi: 'राहु', y: 18 },
             { key: 'Ju', name_en: 'Jupiter (Guru)', name_ml: 'വ്യാഴം (Guru)', name_ta: 'குரு', name_hi: 'गुरु', y: 16 },
             { key: 'Sa', name_en: 'Saturn (Shani)', name_ml: 'ശനി (Shani)', name_ta: 'சனி', name_hi: 'शनि', y: 19 },
             { key: 'Me', name_en: 'Mercury (Budha)', name_ml: 'ബുധൻ (Budha)', name_ta: 'புதன்', name_hi: 'बुध', y: 17 }
         ],
         getPratyantardashas(antar) {
             if (antar.pratyantardashas && antar.pratyantardashas.length === 9) {
                 return antar.pratyantardashas;
             }
             let startIdx = this.dashaOrderList.findIndex(p => p.key === antar.sub_lord_key || p.name_en === (antar.name_en || antar.lord_en));
             if (startIdx < 0) startIdx = 0;
             const aStart = new Date(antar.start_date);
             const aEnd = new Date(antar.end_date);
             const totalMs = Math.max(1000, aEnd.getTime() - aStart.getTime());
             let cursor = new Date(aStart.getTime());
             const now = new Date();
             const result = [];
             for (let k = 0; k < 9; k++) {
                 const lord = this.dashaOrderList[(startIdx + k) % 9];
                 const spanMs = Math.round(totalMs * (lord.y / 120.0));
                 const pStart = new Date(cursor.getTime());
                 const pEnd = (k === 8) ? new Date(aEnd.getTime()) : new Date(pStart.getTime() + spanMs);
                 cursor = new Date(pEnd.getTime());
                 result.push({
                     lord_key: lord.key,
                     sub_sub_lord_key: lord.key,
                     name_en: lord.name_en,
                     name_ml: lord.name_ml,
                     name_ta: lord.name_ta,
                     name_hi: lord.name_hi,
                     start_date: pStart.toISOString().split('T')[0],
                     end_date: pEnd.toISOString().split('T')[0],
                     duration_days: Math.max(1, Math.round((pEnd.getTime() - pStart.getTime()) / (1000 * 3600 * 24))),
                     is_active: (now >= pStart && now <= pEnd)
                 });
             }
             antar.pratyantardashas = result;
             return result;
         },
         getSukshmas(praty) {
             if (praty.sukshma_dashas && praty.sukshma_dashas.length === 9) {
                 return praty.sukshma_dashas;
             }
             let startIdx = this.dashaOrderList.findIndex(p => p.key === praty.sub_sub_lord_key || p.key === praty.lord_key || p.name_en === praty.name_en);
             if (startIdx < 0) startIdx = 0;
             const pStart = new Date(praty.start_date);
             const pEnd = new Date(praty.end_date);
             const totalMs = Math.max(1000, pEnd.getTime() - pStart.getTime());
             let cursor = new Date(pStart.getTime());
             const now = new Date();
             const result = [];
             for (let l = 0; l < 9; l++) {
                 const lord = this.dashaOrderList[(startIdx + l) % 9];
                 const spanMs = Math.round(totalMs * (lord.y / 120.0));
                 const sStart = new Date(cursor.getTime());
                 const sEnd = (l === 8) ? new Date(pEnd.getTime()) : new Date(sStart.getTime() + spanMs);
                 cursor = new Date(sEnd.getTime());
                 result.push({
                     lord_key: lord.key,
                     name_en: lord.name_en,
                     name_ml: lord.name_ml,
                     name_ta: lord.name_ta,
                     name_hi: lord.name_hi,
                     start_date: sStart.toISOString().split('T')[0],
                     end_date: sEnd.toISOString().split('T')[0],
                     duration_days: Math.max(1, Math.round((sEnd.getTime() - sStart.getTime()) / (1000 * 3600 * 24))),
                     is_active: (now >= sStart && now <= sEnd)
                 });
             }
             praty.sukshma_dashas = result;
             return result;
         },
         t(field) {
             if (!field) return '';
             if (typeof field === 'object') {
                 return field[this.readingLang] || field['en'] || Object.values(field)[0] || '';
             }
             return field;
         },
         gemstone() {
             if (this.readingLang === 'ta') return this.reading?.gemstone_ta || this.reading?.gemstone_en || '';
             if (this.readingLang === 'hi') return this.reading?.gemstone_hi || this.reading?.gemstone_en || '';
             if (this.readingLang === 'ml') return this.reading?.gemstone_ml || this.reading?.gemstone_en || '';
             return this.reading?.gemstone_en || '';
         },
         solarSignName() {
             if (this.readingLang === 'ta') return this.reading?.solar_sign?.name_ta || this.reading?.solar_sign?.name_en || '';
             if (this.readingLang === 'hi') return this.reading?.solar_sign?.name_hi || this.reading?.solar_sign?.name_en || '';
             if (this.readingLang === 'ml') return this.reading?.solar_sign?.name_ml || this.reading?.solar_sign?.name_en || '';
             return this.reading?.solar_sign?.name_en || '';
         }
     }">
    <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <!-- Top Breadcrumb & Actions -->
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-8">
            <nav class="flex items-center space-x-2 text-xs text-amber-300/70">
                <a href="{{ route('home') }}" class="hover:text-amber-200">Home</a>
                <span>/</span>
                <span class="text-amber-100/60">Vedic Prediction Report</span>
            </nav>

            <div class="flex items-center flex-wrap gap-2.5">
                <button onclick="window.print()"
                        class="px-4 py-2 rounded-xl text-xs font-bold text-[#1a1128] bg-gradient-to-r from-amber-300 to-yellow-400 hover:from-amber-200 hover:to-yellow-300 shadow-md flex items-center space-x-1.5 transition-all">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/>
                    </svg>
                    <span>Print / Save PDF</span>
                </button>

                @php
                    $shareMsg = "🔮 *My Vedic Astrology Prediction Report by Dr. E. K. Raja Varma* (Covilakam Astrology)\n\n"
                        . "👤 *Name:* " . ($reading['name'] ?? 'Seeker') . "\n"
                        . "📅 *DOB:* " . ($reading['birth_date'] ?? '') . "\n"
                        . "🪐 *Birth Number (Mulank):* " . ($reading['mulank'] ?? '') . "\n"
                        . "🌟 *Destiny Number (Bhagyank):* " . ($reading['bhagyank'] ?? '') . "\n"
                        . "💎 *Lucky Gemstone:* " . ($reading['gemstone_en'] ?? '') . "\n\n"
                        . "📜 *View complete horoscope & remedies:*\n" . url()->full() . "\n\n"
                        . "🙏 *Consult Dr. E. K. Raja Varma:*\nhttps://www.covilakamastrology.com";
                    $shareUrl = "https://api.whatsapp.com/send?text=" . rawurlencode($shareMsg);
                @endphp

                <a href="{{ $shareUrl }}" target="_blank"
                   class="px-4 py-2 rounded-xl text-xs font-bold text-emerald-200 bg-[#14261f] hover:bg-[#1a332a] border border-emerald-500/40 shadow-md flex items-center space-x-1.5 transition-all">
                    <span>📲 Share on WhatsApp</span>
                </a>

                <a href="{{ $reading['whatsapp_url'] ?? '#' }}" target="_blank"
                   class="px-4 py-2 rounded-xl text-xs font-bold text-white bg-emerald-600 hover:bg-emerald-500 shadow-md flex items-center space-x-1.5 transition-all">
                    <span>Chat on WhatsApp</span>
                </a>
            </div>
        </div>

        <!-- Main Prediction Document Card -->
        <div class="rounded-3xl bg-[#150d24] border-2 border-amber-500/40 shadow-2xl p-6 sm:p-10 relative overflow-hidden text-amber-50">
            
            <!-- Top Branding Header -->
            <div class="border-b-2 border-amber-500/30 pb-6 mb-8 flex flex-col md:flex-row items-center justify-between gap-6">
                <div class="flex items-center space-x-4">
                    <div class="w-14 h-14 rounded-2xl bg-gradient-to-tr from-amber-500 via-yellow-400 to-amber-600 p-0.5 shadow-lg">
                        <div class="w-full h-full rounded-2xl bg-[#1a1128] flex items-center justify-center text-amber-300 font-serif text-2xl font-bold">
                            ॐ
                        </div>
                    </div>
                    <div>
                        <span class="font-cinzel text-xl sm:text-2xl font-black text-amber-300 tracking-wider block">
                            COVILAKAM ASTROLOGY
                        </span>
                        <p class="text-xs text-amber-200/80">
                            Dr. E. K. Raja Varma <span class="text-amber-400 font-semibold">(Vidya Vachaspathi in Vedic Astrology)</span>
                        </p>
                    </div>
                </div>

                <!-- Client Badge -->
                <div class="text-center md:text-right bg-[#231538] px-5 py-3 rounded-2xl border border-amber-500/30">
                    <span class="text-[10px] uppercase tracking-widest text-amber-400 font-bold block">Horoscope Analysis For</span>
                    <h2 class="font-cinzel text-lg sm:text-xl font-bold text-white">{{ $reading['name'] }}</h2>
                    <span class="text-xs text-amber-200/70 font-mono">DOB: {{ $reading['birth_date'] }} (Indian Standard)</span>
                </div>
            </div>

            <!-- Celestial Coordinates Summary Grid -->
            <div class="grid grid-cols-2 sm:grid-cols-4 gap-3 sm:gap-4 mb-8">
                <!-- Mulank -->
                <div class="p-4 rounded-2xl bg-gradient-to-br from-[#27153f] to-[#1c102e] border border-amber-500/30">
                    <span class="text-[10px] text-amber-300 uppercase tracking-wider block font-bold">Birth No. (Mulank)</span>
                    <div class="flex items-baseline space-x-2 mt-1">
                        <span class="font-cinzel text-3xl font-black text-amber-300">{{ $reading['mulank'] }}</span>
                        <span class="text-xs text-amber-200/80" x-text="t(reading.ruling_planet)">{{ $getText($reading['ruling_planet']) }}</span>
                    </div>
                </div>

                <!-- Bhagyank -->
                <div class="p-4 rounded-2xl bg-gradient-to-br from-[#27153f] to-[#1c102e] border border-amber-500/30">
                    <span class="text-[10px] text-amber-300 uppercase tracking-wider block font-bold">Destiny (Bhagyank)</span>
                    <div class="flex items-baseline space-x-2 mt-1">
                        <span class="font-cinzel text-3xl font-black text-yellow-300">{{ $reading['bhagyank'] }}</span>
                        <span class="text-xs text-amber-200/80" x-text="t(reading.destiny_planet)">{{ $getText($reading['destiny_planet']) }}</span>
                    </div>
                </div>

                <!-- Surya Rasi -->
                <div class="p-4 rounded-2xl bg-gradient-to-br from-[#27153f] to-[#1c102e] border border-amber-500/30">
                    <span class="text-[10px] text-amber-300 uppercase tracking-wider block font-bold">Malayalam Surya Rasi</span>
                    <p class="font-semibold text-white text-sm mt-1" x-text="solarSignName()">
                        {{ $reading['solar_sign']['name_' . $currLang] ?? $reading['solar_sign']['name_ml'] ?? $reading['solar_sign']['name_en'] }}
                    </p>
                    <span class="text-[11px] text-amber-200/60 block">{{ $reading['solar_sign']['name_en'] }}</span>
                </div>

                <!-- Lucky Gemstone -->
                <div class="p-4 rounded-2xl bg-gradient-to-br from-[#27153f] to-[#1c102e] border border-amber-500/30">
                    <span class="text-[10px] text-amber-300 uppercase tracking-wider block font-bold">Beneficial Gemstone</span>
                    <p class="font-semibold text-amber-300 text-sm mt-1" x-text="gemstone()">
                        {{ $reading['gemstone_' . $currLang] ?? $reading['gemstone_ml'] ?? $reading['gemstone_en'] }}
                    </p>
                    <span class="text-[11px] text-amber-200/60 block">{{ $reading['gemstone_en'] }}</span>
                </div>
            </div>

            <!-- Multilingual Reading Selector (English, Malayalam, Tamil, Hindi) -->
            <div class="p-3 mb-6 rounded-2xl bg-[#190e2b] border border-amber-500/30 flex flex-col sm:flex-row items-center justify-between gap-3">
                <div class="flex items-center space-x-2 text-xs">
                    <span class="text-amber-400 font-bold uppercase tracking-wider text-[11px]">Choose Reading Language:</span>
                    <span class="text-amber-200/60 font-mono text-[10px]">4 Languages Available</span>
                </div>
                <div class="grid grid-cols-4 gap-1.5 w-full sm:w-auto">
                    <button type="button" @click="readingLang = 'en'"
                            :class="readingLang === 'en' ? 'bg-amber-400 text-black font-extrabold shadow-md' : 'bg-[#25153c] text-amber-200/80 hover:text-white border border-amber-500/20'"
                            class="py-1.5 px-3 rounded-xl text-xs text-center transition-all">
                        🇬🇧 English
                    </button>
                    <button type="button" @click="readingLang = 'ml'"
                            :class="readingLang === 'ml' ? 'bg-amber-400 text-black font-extrabold shadow-md' : 'bg-[#25153c] text-amber-200/80 hover:text-white border border-amber-500/20'"
                            class="py-1.5 px-3 rounded-xl text-xs text-center transition-all font-malayalam">
                        മലയാളം
                    </button>
                    <button type="button" @click="readingLang = 'ta'"
                            :class="readingLang === 'ta' ? 'bg-amber-400 text-black font-extrabold shadow-md' : 'bg-[#25153c] text-amber-200/80 hover:text-white border border-amber-500/20'"
                            class="py-1.5 px-3 rounded-xl text-xs text-center transition-all font-tamil">
                        தமிழ்
                    </button>
                    <button type="button" @click="readingLang = 'hi'"
                            :class="readingLang === 'hi' ? 'bg-amber-400 text-black font-extrabold shadow-md' : 'bg-[#25153c] text-amber-200/80 hover:text-white border border-amber-500/20'"
                            class="py-1.5 px-3 rounded-xl text-xs text-center transition-all font-hindi">
                        हिन्दी
                    </button>
                </div>
            </div>

            <!-- Reading Section Navigation Tabs -->
            <div class="flex flex-wrap gap-2 border-b border-amber-500/20 pb-4 mb-8">
                <button @click="activeTab = 'overview'"
                        :class="activeTab === 'overview' ? 'bg-amber-400 text-black font-bold shadow-md' : 'text-amber-200/80 bg-[#221338] hover:text-white'"
                        class="px-4 py-2 rounded-xl text-xs sm:text-sm transition-all flex items-center space-x-1.5">
                    <span>🕉️</span>
                    <span x-show="readingLang === 'en'">Life Path & Soul Nature</span>
                    <span x-show="readingLang === 'ml'">ജീവിതപാത & പ്രകൃതി</span>
                    <span x-show="readingLang === 'ta'">வாழ்க்கைப் பாதை & சுபாவம்</span>
                    <span x-show="readingLang === 'hi'">जीवन पथ एवं मूल स्वभाव</span>
                </button>
                <button @click="activeTab = 'dasha'"
                        :class="activeTab === 'dasha' ? 'bg-amber-400 text-black font-bold shadow-md' : 'text-amber-200/80 bg-[#221338] hover:text-white'"
                        class="px-4 py-2 rounded-xl text-xs sm:text-sm transition-all flex items-center space-x-1.5">
                    <span>☸️</span>
                    <span x-show="readingLang === 'en'">7 & 8: Dasa & Anthar Dasa</span>
                    <span x-show="readingLang === 'ml'">7 & 8: ദശാപഹാര ക്രമം & സൂക്ഷ്മ ദശകൾ</span>
                    <span x-show="readingLang === 'ta'">7 & 8: தசா-புத்தி & அந்தர விபரம்</span>
                    <span x-show="readingLang === 'hi'">7 & 8: विंशोत्तरी दशा-अंतर्दशा</span>
                </button>
                <button @click="activeTab = 'career'"
                        :class="activeTab === 'career' ? 'bg-amber-400 text-black font-bold shadow-md' : 'text-amber-200/80 bg-[#221338] hover:text-white'"
                        class="px-4 py-2 rounded-xl text-xs sm:text-sm transition-all flex items-center space-x-1.5">
                    <span>💼</span>
                    <span x-show="readingLang === 'en'">Career & Wealth</span>
                    <span x-show="readingLang === 'ml'">തൊഴിൽ & സാമ്പത്തികം</span>
                    <span x-show="readingLang === 'ta'">தொழில் & செல்வம்</span>
                    <span x-show="readingLang === 'hi'">करियर एवं धन समृद्धि</span>
                </button>
                <button @click="activeTab = 'relationships'"
                        :class="activeTab === 'relationships' ? 'bg-amber-400 text-black font-bold shadow-md' : 'text-amber-200/80 bg-[#221338] hover:text-white'"
                        class="px-4 py-2 rounded-xl text-xs sm:text-sm transition-all flex items-center space-x-1.5">
                    <span>❤️</span>
                    <span x-show="readingLang === 'en'">Love & Family</span>
                    <span x-show="readingLang === 'ml'">ദാമ്പത്യം & കുടുംബം</span>
                    <span x-show="readingLang === 'ta'">குடும்பம் & உறவுகள்</span>
                    <span x-show="readingLang === 'hi'">प्रेम एवं पारिवारिक सुख</span>
                </button>
                <button @click="activeTab = 'health'"
                        :class="activeTab === 'health' ? 'bg-amber-400 text-black font-bold shadow-md' : 'text-amber-200/80 bg-[#221338] hover:text-white'"
                        class="px-4 py-2 rounded-xl text-xs sm:text-sm transition-all flex items-center space-x-1.5">
                    <span>🌿</span>
                    <span x-show="readingLang === 'en'">Health & Vitality</span>
                    <span x-show="readingLang === 'ml'">ആരോഗ്യം & ഊർജ്ജം</span>
                    <span x-show="readingLang === 'ta'">ஆரோக்கியம்</span>
                    <span x-show="readingLang === 'hi'">स्वास्थ्य एवं ऊर्जा</span>
                </button>
                <button @click="activeTab = 'remedies'"
                        :class="activeTab === 'remedies' ? 'bg-amber-400 text-black font-bold shadow-md' : 'text-amber-200/80 bg-[#221338] hover:text-white'"
                        class="px-4 py-2 rounded-xl text-xs sm:text-sm transition-all flex items-center space-x-1.5">
                    <span>💎</span>
                    <span x-show="readingLang === 'en'">Sacred Remedies & Mantras</span>
                    <span x-show="readingLang === 'ml'">പരിഹാരങ്ങൾ & മന്ത്രങ്ങൾ</span>
                    <span x-show="readingLang === 'ta'">பரிகாரங்கள் & மந்திரங்கள்</span>
                    <span x-show="readingLang === 'hi'">वैदिक उपाय एवं मंत्र</span>
                </button>
            </div>

            <!-- Tab 1: Overview & Personality -->
            <div x-show="activeTab === 'overview'" class="space-y-6 text-sm leading-relaxed">
                <div class="p-4 rounded-2xl bg-amber-500/10 border border-amber-500/30 flex items-center space-x-3">
                    <span class="text-2xl">⚡</span>
                    <div>
                        <h3 class="font-cinzel text-base font-bold text-amber-300">
                            <span x-text="'Archetype: ' + t(reading.archetype)">Archetype: {{ $getText($reading['archetype']) }}</span>
                        </h3>
                        <p class="text-xs text-amber-200/80">
                            Ruling Deity: <strong><span x-text="t(reading.ruling_planet?.deity)">{{ $getText($reading['ruling_planet']['deity'] ?? 'Navagraha Lord') }}</span></strong> • Element: <strong><span x-text="t(reading.ruling_planet?.element)">{{ $getText($reading['ruling_planet']['element'] ?? 'Cosmic Light') }}</span></strong>
                        </p>
                    </div>
                </div>

                <div class="space-y-4">
                    <h4 class="font-cinzel text-lg font-bold text-amber-200 border-b border-amber-500/20 pb-1">
                        <span x-show="readingLang === 'en'">Innate Strengths & Psychological Constitution</span>
                        <span x-show="readingLang === 'ml'">ജന്മസിദ്ധമായ കഴിവുകളും വ്യക്തിത്വ സ്വഭാവങ്ങളും</span>
                        <span x-show="readingLang === 'ta'">பிறவி பலங்கள் மற்றும் ஆளுமைப் பண்புகள்</span>
                        <span x-show="readingLang === 'hi'">जन्मजात शक्तियां एवं स्वाभाविक व्यक्तित्व</span>
                    </h4>
                    <p class="text-amber-50/90 text-sm sm:text-base leading-relaxed"
                       x-text="t(reading.personality_prediction) || t(reading.traits)">
                        {{ $getText($reading['personality_prediction'] ?? $reading['traits']) }}
                    </p>

                    <div class="mt-4 p-4 rounded-2xl bg-[#201334] border border-amber-500/20">
                        <h5 class="font-bold text-xs text-amber-300 uppercase tracking-wider mb-1">
                            <span x-show="readingLang === 'en'">Solar Influence Overview:</span>
                            <span x-show="readingLang === 'ml'">സൂര്യ രാശി സ്വാധീനം:</span>
                            <span x-show="readingLang === 'ta'">சூரிய ராசி தாக்கம்:</span>
                            <span x-show="readingLang === 'hi'">सूर्य राशि का विशेष प्रभाव:</span>
                        </h5>
                        <p class="text-xs text-amber-100/80 leading-relaxed"
                           x-text="t(reading.solar_sign?.sign_overview)">
                            {{ $getText($reading['solar_sign']['sign_overview'] ?? '') }}
                        </p>
                    </div>
                </div>
            </div>

            <!-- Tab 2: Career & Wealth -->
            <div x-show="activeTab === 'career'" x-cloak class="space-y-6 text-sm leading-relaxed">
                <div class="p-4 rounded-2xl bg-blue-950/40 border border-blue-500/30 flex items-center space-x-3">
                    <span class="text-2xl">💼</span>
                    <div>
                        <h3 class="font-cinzel text-base font-bold text-blue-200">
                            <span x-show="readingLang === 'en'">Professional Trajectory & Prosperity Blueprint</span>
                            <span x-show="readingLang === 'ml'">തൊഴിൽ മേഖലയും സാമ്പത്തിക ഐശ്വര്യവും</span>
                            <span x-show="readingLang === 'ta'">தொழில் வாய்ப்புகள் & நிதி வளர்ச்சி</span>
                            <span x-show="readingLang === 'hi'">व्यावसायिक उन्नति एवं धन समृद्धि</span>
                        </h3>
                        <p class="text-xs text-blue-300/80">
                            Governed by <span x-text="t(reading.ruling_planet)">{{ $getText($reading['ruling_planet']) }}</span> & Destiny Number {{ $reading['bhagyank'] }}
                        </p>
                    </div>
                </div>

                <div class="space-y-4">
                    <h4 class="font-cinzel text-lg font-bold text-amber-200 border-b border-amber-500/20 pb-1">
                        <span x-show="readingLang === 'en'">Best Suitable Professions & Financial Timing</span>
                        <span x-show="readingLang === 'ml'">അനുയോജ്യമായ തൊഴിലുകൾ & സാമ്പത്തിക ഉയർച്ച</span>
                        <span x-show="readingLang === 'ta'">பொருத்தமான தொழில் துறைகள்</span>
                        <span x-show="readingLang === 'hi'">उत्तम आजीविका क्षेत्र एवं आर्थिक योग</span>
                    </h4>
                    <p class="text-amber-50/90 text-sm sm:text-base leading-relaxed"
                       x-text="t(reading.career_prediction)">
                        {{ $getText($reading['career_prediction']) }}
                    </p>
                </div>
            </div>

            <!-- Tab 3: Love & Family -->
            <div x-show="activeTab === 'relationships'" x-cloak class="space-y-6 text-sm leading-relaxed">
                <div class="p-4 rounded-2xl bg-rose-950/40 border border-rose-500/30 flex items-center space-x-3">
                    <span class="text-2xl">❤️</span>
                    <div>
                        <h3 class="font-cinzel text-base font-bold text-rose-200">
                            <span x-show="readingLang === 'en'">Emotional Alignment & Marital Harmony</span>
                            <span x-show="readingLang === 'ml'">ദാമ്പത്യ ഐക്യവും കുടുംബ സമാധാനവും</span>
                            <span x-show="readingLang === 'ta'">குடும்ப அமைதி மற்றும் தாம்பத்திய இணக்கம்</span>
                            <span x-show="readingLang === 'hi'">प्रेम, वैवाहिक सुख एवं पारिवारिक सामंजस्य</span>
                        </h3>
                        <p class="text-xs text-rose-300/80">
                            Navigating personal relationships and family prosperity
                        </p>
                    </div>
                </div>

                <div class="space-y-4">
                    <h4 class="font-cinzel text-lg font-bold text-amber-200 border-b border-amber-500/20 pb-1">
                        <span x-show="readingLang === 'en'">Compatibility Dynamics</span>
                        <span x-show="readingLang === 'ml'">പൊരുത്തവും പരസ്പര ധാരണയും</span>
                        <span x-show="readingLang === 'ta'">பொருத்தம் மற்றும் அன்பின் பிணைப்பு</span>
                        <span x-show="readingLang === 'hi'">संबंधों में अनुकूलता एवं आपसी तालमेल</span>
                    </h4>
                    <p class="text-amber-50/90 text-sm sm:text-base leading-relaxed"
                       x-text="t(reading.relationship_prediction)">
                        {{ $getText($reading['relationship_prediction']) }}
                    </p>
                </div>
            </div>

            <!-- Tab 4: Health & Vitality -->
            <div x-show="activeTab === 'health'" x-cloak class="space-y-6 text-sm leading-relaxed">
                <div class="p-4 rounded-2xl bg-emerald-950/40 border border-emerald-500/30 flex items-center space-x-3">
                    <span class="text-2xl">🌿</span>
                    <div>
                        <h3 class="font-cinzel text-base font-bold text-emerald-200">
                            <span x-show="readingLang === 'en'">Vedic Lifestyle & Vital Energy</span>
                            <span x-show="readingLang === 'ml'">ആയുർവേദ ജീവിതരീതിയും പ്രാണോർജ്ജവും</span>
                            <span x-show="readingLang === 'ta'">ஆரோக்கிய வாழ்க்கை முறை</span>
                            <span x-show="readingLang === 'hi'">आयुर्वेदिक जीवनशैली एवं प्राण ऊर्जा</span>
                        </h3>
                        <p class="text-xs text-emerald-300/80">
                            Maintaining harmonious Prana and Dosha balance
                        </p>
                    </div>
                </div>

                <div class="space-y-4">
                    <h4 class="font-cinzel text-lg font-bold text-amber-200 border-b border-amber-500/20 pb-1">
                        <span x-show="readingLang === 'en'">Vital Health Guidelines</span>
                        <span x-show="readingLang === 'ml'">ആരോഗ്യ സംരക്ഷണ നിർദ്ദേശങ്ങൾ</span>
                        <span x-show="readingLang === 'ta'">முக்கிய ஆரோக்கிய ஆலோசனைகள்</span>
                        <span x-show="readingLang === 'hi'">महत्वपूर्ण स्वास्थ्य परामर्श</span>
                    </h4>
                    <p class="text-amber-50/90 text-sm sm:text-base leading-relaxed"
                       x-text="t(reading.health_prediction)">
                        {{ $getText($reading['health_prediction']) }}
                    </p>
                </div>
            </div>

            <!-- Tab 5: Sacred Remedies & Mantras -->
            <div x-show="activeTab === 'remedies'" x-cloak class="space-y-6 text-sm leading-relaxed">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <!-- Gemstone Card -->
                    <div class="p-5 rounded-2xl bg-[#231538] border border-amber-500/30 space-y-2">
                        <span class="text-xs text-amber-400 font-bold uppercase tracking-wider block">
                            <span x-show="readingLang === 'en'">Recommended Gemstone</span>
                            <span x-show="readingLang === 'ml'">നിർദ്ദേശിക്കുന്ന രത്നം</span>
                            <span x-show="readingLang === 'ta'">பரிந்துரைக்கப்பட்ட நவரத்தினம்</span>
                            <span x-show="readingLang === 'hi'">शुभ रत्न</span>
                        </span>
                        <h4 class="font-cinzel text-lg font-bold text-white" x-text="gemstone()">{{ $reading['gemstone_en'] }}</h4>
                        <p class="text-xs text-amber-300 font-medium font-malayalam">{{ $reading['gemstone_ml'] }}</p>
                        <p class="text-xs text-amber-100/70 pt-2 border-t border-amber-500/20 leading-relaxed">
                            <strong>Wearing Instruction:</strong> 
                            <span x-text="t(reading.wearing_rule)">{{ $getText($reading['wearing_rule']) }}</span>
                        </p>
                    </div>

                    <!-- Favorable Alignments -->
                    <div class="p-5 rounded-2xl bg-[#231538] border border-amber-500/30 space-y-2">
                        <span class="text-xs text-amber-400 font-bold uppercase tracking-wider block">Cosmic Alignments</span>
                        <div class="space-y-1 text-xs">
                            <p><strong class="text-amber-300">Favorable Colors:</strong> <span x-text="t(reading.lucky_color)">{{ $getText($reading['lucky_color']) }}</span></p>
                            <p><strong class="text-amber-300">Auspicious Day:</strong> <span x-text="t(reading.lucky_day)">{{ $getText($reading['lucky_day']) }}</span></p>
                            <p><strong class="text-amber-300">Lucky Numbers:</strong> <span x-text="reading.lucky_numbers">{{ $reading['lucky_numbers'] ?? '' }}</span></p>
                            <p><strong class="text-amber-300">Vastu Direction:</strong> <span x-text="t(reading.favorable_direction)">{{ $getText($reading['favorable_direction']) }}</span></p>
                        </div>
                    </div>
                </div>

                <!-- Navagraha Beej Mantra -->
                @if(!empty($reading['mantra_sanskrit']))
                <div class="p-6 rounded-2xl bg-gradient-to-r from-[#321325] to-[#211233] border-2 border-amber-400/50 text-center space-y-2">
                    <span class="text-xs uppercase tracking-widest text-amber-300 font-bold block">Sacred Navagraha Beej Mantra</span>
                    <p class="font-serif text-xl sm:text-2xl text-amber-200 tracking-wide">
                        {{ $reading['mantra_sanskrit'] }}
                    </p>
                    <p class="text-xs italic text-amber-300/80 font-mono">
                        "{{ $reading['mantra_translit'] }}"
                    </p>
                    <p class="text-[11px] text-amber-200/60 pt-1">
                        Chant 108 times daily in the morning for planetary grace and removal of obstacles.
                    </p>
                </div>
                @endif

                <!-- Doctor's Personal Remedy Guidance -->
                @if(!empty($reading['doctor_remedy']))
                <div class="p-5 rounded-2xl bg-[#1c112e] border border-amber-500/30">
                    <h5 class="font-cinzel text-sm font-bold text-amber-300 mb-1">
                        <span x-show="readingLang === 'en'">Vedic Remedy Prescribed by Dr. E. K. Raja Varma:</span>
                        <span x-show="readingLang === 'ml'">ഡോ. ഇ. കെ. രാജവർമ്മ നിർദ്ദേശിക്കുന്ന പരിഹാരം:</span>
                        <span x-show="readingLang === 'ta'">டாக்டர் இ. கே. ராஜ வர்மா பரிந்துரைக்கும் பரிகாரம்:</span>
                        <span x-show="readingLang === 'hi'">डॉ. ई. के. राजा वर्मा द्वारा अनुशंसित उपाय:</span>
                    </h5>
                    <p class="text-xs sm:text-sm text-amber-100/85 leading-relaxed"
                       x-text="t(reading.doctor_remedy)">
                        {{ $getText($reading['doctor_remedy']) }}
                    </p>
                </div>
                @endif
            </div>

            <!-- Tab 6: 7 & 8 Dasa & Anthar Dasa (120-Year Lifeline & Micro Sub-Periods) -->
            <div x-show="activeTab === 'dasha'" x-cloak class="space-y-6 text-sm leading-relaxed">
                <!-- Section Header -->
                <div class="border-b border-amber-500/20 pb-3 flex flex-col sm:flex-row sm:items-center justify-between gap-2">
                    <div>
                        <h3 class="font-cinzel text-lg sm:text-xl font-bold text-amber-300">
                            <span x-show="readingLang === 'en'">7 & 8: Vimshottari Dasa & Anthar Dasa Hierarchy</span>
                            <span x-show="readingLang === 'ml'">7 & 8: വിംശോത്തരി ദശാപഹാര ക്രമവും സൂക്ഷ്മ ദശകളും</span>
                            <span x-show="readingLang === 'ta'">7 & 8: விம்சொத்தரி தசா-புத்தி மற்றும் அந்தர விபரம்</span>
                            <span x-show="readingLang === 'hi'">7 & 8: विंशोत्तरी महादशा, अंतर्दशा एवं सूक्ष्म दशा</span>
                        </h3>
                        <p class="text-xs text-amber-200/70 mt-0.5">
                            <span x-show="readingLang === 'en'">Click any Mahadasha to view all 9 Antardashas. Click any Antardasha to view its Pratyantardashas, and click further to view short Sukshma periods down to days.</span>
                            <span x-show="readingLang === 'ml'">ഏതൊരു മഹാദശയിലും ക്ലിക്ക് ചെയ്താൽ 9 അപഹാരങ്ങൾ കാണാം. അപഹാരത്തിൽ ക്ലിക്ക് ചെയ്താൽ പ്രത്യന്തർദശകളും, അതിൽ ക്ലിക്ക് ചെയ്താൽ ദിവസങ്ങൾ വരെയുള്ള സൂക്ഷ്മ ദശകളും ക്രമമായി പരിശോധിക്കാം.</span>
                            <span x-show="readingLang === 'ta'">தசாவை கிளிக் செய்து 9 புத்தி மற்றும் அந்தரங்களை விரிவாக பார்க்கலாம்.</span>
                            <span x-show="readingLang === 'hi'">किसी भी महादशा पर क्लिक करके अंतर्दशा, प्रत्यंतर्दशा एवं सूक्ष्म दशा देखें।</span>
                        </p>
                    </div>
                </div>

                <!-- ITEM 8: ACTIVE DASHA & APAHARA SPOTLIGHT -->
                <div class="p-5 rounded-2xl bg-gradient-to-br from-[#1b2a22] to-[#141d24] border-2 border-emerald-500/40 shadow-xl space-y-3">
                    <div class="flex items-center justify-between">
                        <span class="text-xs uppercase tracking-widest font-bold text-emerald-300 flex items-center gap-1.5">
                            <span class="inline-block w-2.5 h-2.5 rounded-full bg-emerald-400 animate-pulse"></span>
                            <span x-show="readingLang === 'en'">8. Current Operating Planetary Cycle (Live Dasha)</span>
                            <span x-show="readingLang === 'ml'">8. നിലവിലെ ദശാപഹാര കാലഘട്ടം</span>
                            <span x-show="readingLang === 'ta'">8. தற்போதைய தசா-புத்தி விபரம்</span>
                            <span x-show="readingLang === 'hi'">8. वर्तमान दशा एवं अंतर्दशा</span>
                        </span>
                        <span class="text-[11px] font-mono text-emerald-200 bg-emerald-950/80 px-2.5 py-0.5 rounded-full border border-emerald-500/40"
                              x-text="(reading.active_dasha?.start_date || '') + ' to ' + (reading.active_dasha?.end_date || '')"></span>
                    </div>

                    <div class="grid grid-cols-2 sm:grid-cols-4 gap-2.5 text-xs">
                        <div class="p-2.5 rounded-xl bg-black/40 border border-emerald-500/30">
                            <span class="text-[10px] text-emerald-300/80 block uppercase font-bold">1. Mahadasha (മഹാദശ)</span>
                            <p class="font-bold text-white text-sm mt-0.5"
                               x-text="reading.active_dasha?.[('mahadasha_' + readingLang)] || reading.active_dasha?.mahadasha_en || reading.active_dasha?.mahadasha || 'Active Dasha'"></p>
                        </div>
                        <div class="p-2.5 rounded-xl bg-black/40 border border-emerald-500/30">
                            <span class="text-[10px] text-emerald-300/80 block uppercase font-bold">2. Antardasha (അപഹാരം)</span>
                            <p class="font-bold text-amber-300 text-sm mt-0.5"
                               x-text="reading.active_dasha?.[('antardasha_' + readingLang)] || reading.active_dasha?.antardasha_en || reading.active_dasha?.apahara || 'Active Apahara'"></p>
                        </div>
                        <div class="p-2.5 rounded-xl bg-black/40 border border-emerald-500/30">
                            <span class="text-[10px] text-emerald-300/80 block uppercase font-bold">3. Pratyantardasha (പ്രത്യന്തർ)</span>
                            <p class="font-bold text-teal-300 text-xs sm:text-sm mt-0.5"
                               x-text="reading.active_dasha?.active_pratyantardasha?.[('name_' + readingLang)] || reading.active_dasha?.active_pratyantardasha?.name_en || 'Active Pratyantar'"></p>
                        </div>
                        <div class="p-2.5 rounded-xl bg-black/40 border border-emerald-500/30">
                            <span class="text-[10px] text-emerald-300/80 block uppercase font-bold">4. Sukshma Dasha (സൂക്ഷ്മ ദശ)</span>
                            <p class="font-bold text-sky-300 text-xs sm:text-sm mt-0.5"
                               x-text="reading.active_dasha?.active_sukshma?.[('name_' + readingLang)] || reading.active_dasha?.active_sukshma?.name_en || 'Active Sukshma'"></p>
                        </div>
                    </div>

                    <!-- Astrological Interpretation of Current Dasha -->
                    <div class="pt-2 border-t border-emerald-500/20 text-xs sm:text-sm text-emerald-100/90 leading-relaxed">
                        <p x-text="reading.active_dasha?.[('prediction_' + readingLang)] || reading.active_dasha?.prediction_en || ''"></p>
                    </div>
                </div>

                <!-- GARBHASHISHTA (BALANCE AT BIRTH) -->
                <div class="p-4 rounded-2xl bg-amber-950/30 border border-amber-500/30 flex flex-col sm:flex-row sm:items-center justify-between gap-3 text-xs">
                    <div>
                        <span class="text-[10px] uppercase font-bold text-amber-300 block">
                            <span x-show="readingLang === 'en'">Balance of Dasha at Birth (Garbhashishta):</span>
                            <span x-show="readingLang === 'ml'">ജനന ശിഷ്ട ദശ (ഗർഭശിഷ്ടം):</span>
                            <span x-show="readingLang === 'ta'">பிறப்பு இருப்பு திசை:</span>
                            <span x-show="readingLang === 'hi'">जन्म कालीन भुक्त/शिष्ट दशा:</span>
                        </span>
                        <p class="font-semibold text-white mt-0.5"
                           x-text="reading.garbhashishta?.[('summary_' + readingLang)] || reading.garbhashishta?.summary_en || reading.garbhashishta?.summary_ml || 'Computed from Janma Nakshatra Pada'"></p>
                    </div>
                    <template x-if="reading.garbhashishta?.end_date">
                        <span class="text-[11px] font-mono text-amber-300 bg-amber-500/15 px-3 py-1 rounded-xl border border-amber-500/30 shrink-0"
                              x-text="'Ending: ' + reading.garbhashishta.end_date"></span>
                    </template>
                </div>

                <!-- ITEM 7: 120-YEAR VIMSHOTTARI DASHA HIERARCHY ACCORDION -->
                <div class="space-y-3">
                    <div class="flex items-center justify-between">
                        <h4 class="font-cinzel text-base font-bold text-amber-200">
                            <span x-show="readingLang === 'en'">7. 120-Year Vimshottari Mahadasha Timeline (Click to Expand)</span>
                            <span x-show="readingLang === 'ml'">7. സമ്പൂർണ്ണ വിംശോത്തരി ദശാവൃന്ദം (120 വർഷം)</span>
                            <span x-show="readingLang === 'ta'">7. 120 வருட விம்சொத்தரி மகாதிசை கால அட்டவணை</span>
                            <span x-show="readingLang === 'hi'">7. 120 वर्षीय विंशोत्तरी महादशा चक्र</span>
                        </h4>
                        <span class="text-[10px] text-amber-300/70 font-mono">9 Planetary Cycles</span>
                    </div>

                    <div class="space-y-2">
                        <template x-for="(maha, mIdx) in (reading.dasha?.timeline || reading.dasha?.mahadashas || reading.timeline || [])" :key="mIdx">
                            <div class="rounded-2xl border transition-all overflow-hidden"
                                 :class="maha.is_active ? 'bg-[#1e1333] border-amber-400/60 shadow-lg shadow-amber-950/40' : 'bg-[#150d24] border-amber-500/25'">
                                
                                <!-- Level 1: Mahadasha Header (Clickable) -->
                                <button type="button" @click="toggleMaha(mIdx)"
                                        class="w-full p-3.5 sm:p-4 text-left flex items-center justify-between gap-3 hover:bg-amber-500/5 transition-colors cursor-pointer">
                                    <div class="flex items-center space-x-3">
                                        <span class="w-7 h-7 rounded-xl flex items-center justify-center font-bold text-xs"
                                              :class="maha.is_active ? 'bg-amber-400 text-stone-950 shadow' : 'bg-[#25153c] text-amber-300 border border-amber-500/30'"
                                              x-text="maha.lord_key || maha.planet || (mIdx + 1)"></span>
                                        <div>
                                            <div class="flex items-center gap-2">
                                                <h5 class="font-bold text-sm text-white"
                                                    x-text="maha[('lord_' + readingLang)] || maha.lord_en || maha.lord_name_en || maha.lord || 'Mahadasha'"></h5>
                                                <span class="text-xs text-amber-300/80 font-mono"
                                                      x-text="'(' + (maha.duration_years || maha.years) + ' Years)'"></span>
                                                <template x-if="maha.is_active">
                                                    <span class="px-2 py-0.5 rounded-full text-[9px] font-bold uppercase bg-amber-400 text-stone-950 shadow-sm animate-pulse">
                                                        ★ Running Now
                                                    </span>
                                                </template>
                                            </div>
                                            <p class="text-[11px] text-amber-200/60 font-mono mt-0.5">
                                                <span x-text="maha.start_date"></span> &rarr; <span x-text="maha.end_date"></span>
                                            </p>
                                        </div>
                                    </div>

                                    <div class="flex items-center space-x-2">
                                        <span class="text-[10px] text-amber-300 underline hidden sm:inline"
                                              x-text="expandedMaha === mIdx ? 'Hide Apaharas ▲' : 'View 9 Apaharas ▼'"></span>
                                        <span class="text-amber-400 font-bold text-sm" x-text="expandedMaha === mIdx ? '▲' : '▼'"></span>
                                    </div>
                                </button>

                                <!-- Level 2: Antardashas (Apaharas) -->
                                <div x-show="expandedMaha === mIdx" x-collapse class="border-t border-amber-500/20 bg-[#0f0819] p-3 sm:p-4 space-y-2">
                                    <div class="flex items-center justify-between text-[11px] text-amber-300 font-bold uppercase tracking-wider pb-1 border-b border-amber-500/15">
                                        <span>Apaharas (അപഹാരങ്ങൾ) under this Mahadasha</span>
                                        <span class="text-[10px] text-amber-400/70 font-normal lowercase">Click any Apahara for Pratyantardashas</span>
                                    </div>

                                    <div class="space-y-1.5 pt-1">
                                        <template x-for="(antar, aIdx) in (maha.apaharas || maha.antardashas || [])" :key="aIdx">
                                            <div class="rounded-xl border transition-all overflow-hidden"
                                                 :class="antar.is_active ? 'bg-[#231538] border-amber-400/50' : 'bg-[#170e26] border-amber-500/20'">
                                                
                                                <!-- Level 2 Row (Clickable) -->
                                                <button type="button" @click="toggleAntar(mIdx + '-' + aIdx)"
                                                        class="w-full p-2.5 text-left flex items-center justify-between gap-2 hover:bg-amber-500/5 transition-colors cursor-pointer text-xs">
                                                    <div class="flex items-center space-x-2">
                                                        <span class="text-[10px] font-bold text-amber-400" x-text="(aIdx + 1) + '.'"></span>
                                                        <span class="font-semibold text-white"
                                                              x-text="antar[('sub_lord_' + readingLang)] || antar[('name_' + readingLang)] || antar.name_en || antar.sub_lord_en || 'Apahara'"></span>
                                                        <template x-if="antar.is_active">
                                                            <span class="px-1.5 py-0.2 rounded text-[8px] font-bold uppercase bg-emerald-500/20 text-emerald-300 border border-emerald-500/40">
                                                                ● Active Apahara
                                                            </span>
                                                        </template>
                                                    </div>

                                                    <div class="flex items-center space-x-3 text-[11px] font-mono text-amber-200/80">
                                                        <span><span x-text="antar.start_date"></span> &rarr; <span x-text="antar.end_date"></span></span>
                                                        <span class="text-amber-400/70 font-sans" x-text="expandedAntar === (mIdx + '-' + aIdx) ? '▲' : '▶'"></span>
                                                    </div>
                                                </button>

                                                <!-- Level 3: Pratyantardashas (Sub-sub periods) -->
                                                <div x-show="expandedAntar === (mIdx + '-' + aIdx)" x-collapse class="border-t border-amber-500/15 bg-[#0b0512] p-2.5 sm:p-3 space-y-1.5">
                                                    <div class="text-[10px] uppercase font-bold text-teal-300 pb-1 border-b border-teal-500/20 flex justify-between">
                                                        <span>9 Pratyantardashas (പ്രത്യന്തർദശകൾ)</span>
                                                        <span class="text-teal-200/60 font-normal lowercase">Click for Sukshma (micro-period)</span>
                                                    </div>

                                                    <div class="space-y-1 pt-1">
                                                        <template x-for="(praty, pIdx) in getPratyantardashas(antar)" :key="pIdx">
                                                            <div class="rounded-lg border text-[11px]"
                                                                 :class="praty.is_active ? 'bg-[#1c242e] border-teal-400/60' : 'bg-[#120a1f] border-amber-500/15'">
                                                                
                                                                <!-- Level 3 Row (Clickable) -->
                                                                <button type="button" @click="togglePraty(mIdx + '-' + aIdx + '-' + pIdx)"
                                                                        class="w-full p-2 text-left flex items-center justify-between gap-2 hover:bg-teal-500/10 transition-colors cursor-pointer">
                                                                    <div class="flex items-center space-x-2">
                                                                        <span class="text-[9px] text-teal-400 font-bold" x-text="(pIdx + 1) + '.'"></span>
                                                                        <span class="font-medium text-amber-100"
                                                                              x-text="praty[('name_' + readingLang)] || praty.name_en || 'Pratyantar'"></span>
                                                                        <template x-if="praty.is_active">
                                                                            <span class="px-1 py-0.2 rounded text-[7.5px] font-bold uppercase bg-teal-500/30 text-teal-200 border border-teal-400/50">
                                                                                ★ Active Pratyantar
                                                                            </span>
                                                                        </template>
                                                                    </div>

                                                                    <div class="flex items-center space-x-2 text-[10px] font-mono text-amber-200/70">
                                                                        <span x-text="praty.start_date + ' → ' + praty.end_date"></span>
                                                                        <span class="text-[9px] text-teal-300 bg-teal-950/60 px-1 py-0.2 rounded border border-teal-500/30"
                                                                              x-text="(praty.duration_days || '') + 'd'"></span>
                                                                        <span class="text-teal-400 font-bold" x-text="expandedPraty === (mIdx + '-' + aIdx + '-' + pIdx) ? '▲' : '▶'"></span>
                                                                    </div>
                                                                </button>

                                                                <!-- Level 4: Sukshma Dashas (Micro-periods down to days) -->
                                                                <div x-show="expandedPraty === (mIdx + '-' + aIdx + '-' + pIdx)" x-collapse class="border-t border-teal-500/20 bg-black/60 p-2 space-y-1">
                                                                    <span class="text-[9px] uppercase font-bold text-sky-300 block pb-0.5 border-b border-sky-500/20">
                                                                        9 Sukshma Dashas (സൂക്ഷ്മ ദശകൾ - Short Periods)
                                                                    </span>

                                                                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-1 pt-1">
                                                                        <template x-for="(sukshma, sIdx) in getSukshmas(praty)" :key="sIdx">
                                                                            <div class="p-1.5 rounded bg-[#131124] border text-[10px]"
                                                                                 :class="sukshma.is_active ? 'border-sky-400 bg-sky-950/40 text-sky-200 font-bold' : 'border-amber-500/10 text-amber-200/70'">
                                                                                <div class="flex items-center justify-between">
                                                                                    <span class="font-medium" x-text="sukshma[('name_' + readingLang)] || sukshma.name_en"></span>
                                                                                    <span class="text-[8.5px] font-mono text-amber-300/80" x-text="(sukshma.duration_days || 1) + 'd'"></span>
                                                                                </div>
                                                                                <div class="text-[9px] font-mono text-amber-100/60 mt-0.5">
                                                                                    <span x-text="sukshma.start_date"></span> &rarr; <span x-text="sukshma.end_date"></span>
                                                                                </div>
                                                                            </div>
                                                                        </template>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </template>
                                                    </div>
                                                </div>
                                            </div>
                                        </template>
                                    </div>
                                </div>
                            </div>
                        </template>
                    </div>
                </div>
            </div>

            <!-- Deep Consultation CTA Footer -->
            <div class="mt-10 pt-8 border-t-2 border-amber-500/30 flex flex-col md:flex-row items-center justify-between gap-6 bg-[#1a0f28] -mx-6 sm:-mx-10 -mb-6 sm:-mb-10 p-6 sm:p-10 rounded-b-3xl">
                <div class="space-y-1 text-center md:text-left">
                    <h4 class="font-cinzel text-lg font-bold text-white">
                        Need In-Depth Jathakam Analysis with Exact Birth Time?
                    </h4>
                    <p class="text-xs text-amber-200/70 max-w-xl">
                        This DOB reading computes your fundamental cosmic numbers. For complete Dasha-Bhukti timelines, Kuja Dosha, and personalized remedies, consult Dr. E. K. Raja Varma directly.
                    </p>
                </div>

                <div class="flex flex-col sm:flex-row items-center gap-3 shrink-0">
                    <a href="{{ $reading['whatsapp_url'] ?? '#' }}" target="_blank"
                       class="px-6 py-3 rounded-xl font-bold text-xs sm:text-sm text-white bg-emerald-600 hover:bg-emerald-500 shadow-xl flex items-center space-x-2 transition-all">
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M12.031 6.172c-3.181 0-5.767 2.586-5.768 5.766-.001 1.298.38 2.27 1.019 3.287l-.711 2.598 2.664-.698c.969.585 1.961.947 2.796.947 3.179 0 5.766-2.587 5.767-5.766.001-3.181-2.586-5.767-5.767-5.767zm0 10.373c-.768 0-1.637-.251-2.327-.661l-.167-.099-1.58.414.422-1.539-.109-.174c-.453-.722-.693-1.564-.693-2.55 0-2.539 2.066-4.605 4.606-4.605 2.54 0 4.606 2.066 4.606 4.606 0 2.54-2.066 4.608-4.755 4.608z"/>
                        </svg>
                        <span>Send to WhatsApp (+91 7907052160)</span>
                    </a>
                    <button onclick="window.print()"
                            class="px-4 py-3 rounded-xl font-bold text-xs sm:text-sm text-amber-200 border border-amber-500/40 hover:bg-amber-500/10 transition-all">
                        Print Report
                    </button>
                </div>
            </div>

        </div>

    </div>
</div>
@endsection

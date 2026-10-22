@extends('layouts.app')

@section('title', 'DR. E. K. Raja Varma (Vidya Vachaspathi in Vedic Astrology) | Covilakam Astrology')

@section('content')
<div x-data="{
    // Free DOB Calculator Alpine State
    calcLoading: false,
    calcName: '{{ old('name', '') }}',
    calcDay: '{{ old('dob_day', '') }}',
    calcMonth: '{{ old('dob_month', '') }}',
    calcYear: '{{ old('dob_year', '') }}',
    calcDob: '{{ old('birth_date', '') }}',
    calcPhone: '{{ old('phone', '') }}',
    calcService: '{{ old('service_requested', 'Accurate Predictions') }}',
    calcResult: @json(session('dob_result')),
    hasResult: {{ session('dob_result') ? 'true' : 'false' }},
    readingLang: 'en', // 'en', 'ml', 'ta', 'hi'
    daysInMonth: 31,
    gpayModalOpen: false,

    updateDays() {
        if (!this.calcMonth || !this.calcYear) {
            this.daysInMonth = 31;
            return;
        }
        let m = parseInt(this.calcMonth, 10);
        let y = parseInt(this.calcYear, 10);
        this.daysInMonth = new Date(y, m, 0).getDate();
        if (this.calcDay && parseInt(this.calcDay, 10) > this.daysInMonth) {
            this.calcDay = String(this.daysInMonth).padStart(2, '0');
        }
        this.syncDob();
    },

    syncDob() {
        if (this.calcDay && this.calcMonth && this.calcYear) {
            let d = String(this.calcDay).padStart(2, '0');
            let m = String(this.calcMonth).padStart(2, '0');
            this.calcDob = `${this.calcYear}-${m}-${d}`;
        } else {
            this.calcDob = '';
        }
    },

    async submitDobForm() {
        this.syncDob();
        if (!this.calcName) {
            alert('Please enter your Full Name.');
            return;
        }
        if (!this.calcDay || !this.calcMonth || !this.calcYear || !this.calcDob) {
            alert('Please select your Date of Birth in DD / MM / YYYY format.');
            return;
        }
        this.calcLoading = true;
        try {
            let response = await fetch('{{ route('consultations.calculate-dob') }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({
                    name: this.calcName,
                    birth_date: this.calcDob,
                    phone: this.calcPhone,
                    service_requested: this.calcService
                })
            });
            let data = await response.json();
            if (data.success) {
                this.calcResult = data.data;
                this.hasResult = true;
                // smooth scroll into reading view
                setTimeout(() => {
                    document.getElementById('dob-result-card')?.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
                }, 100);
            } else {
                alert('Calculation error. Please verify your inputs.');
            }
        } catch (e) {
            console.error(e);
            // Fallback submit traditional
            document.getElementById('dob-traditional-form').submit();
        } finally {
            this.calcLoading = false;
        }
    },

    resetCalculator() {
        this.hasResult = false;
        this.calcResult = null;
    }
}">

    <!-- ========================================================================= -->
    <!-- SECTION 1: Top Attractive Hero Banner + Instant Free DOB Prediction Funnel -->
    <!-- ========================================================================= -->
    <section id="hero" class="relative pt-28 pb-20 lg:pt-36 lg:pb-28 overflow-hidden min-h-[92vh] flex items-center bg-[#0e0717]">
        <!-- Cosmic Background Image & Overlays -->
        <div class="absolute inset-0 z-0 opacity-25 mix-blend-screen pointer-events-none">
            <img src="{{ asset('images/vedic-cosmic-bg.jpg') }}" alt="Vedic Cosmic Background" class="w-full h-full object-cover">
        </div>
        <div class="absolute inset-0 bg-radial from-[#380e22]/50 via-[#140a20]/90 to-[#0d0716] z-0 pointer-events-none"></div>

        <!-- Sacred Geometry Star Dust Glow -->
        <div class="absolute top-1/4 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[700px] h-[700px] bg-amber-500/10 rounded-full blur-[140px] pointer-events-none"></div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10 w-full">
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-10 lg:gap-8 items-start">
                
                <!-- Left Column (Branding & Authority) -->
                <div class="lg:col-span-7 space-y-6">
                    
                    <!-- Gold Medal & Ph.D. Highlight Badge -->
                    <div class="inline-flex items-center space-x-2.5 px-4 py-2 rounded-full border border-amber-400/50 bg-gradient-to-r from-amber-500/20 via-yellow-400/10 to-amber-950/40 backdrop-blur-md shadow-lg shadow-amber-500/10">
                        <span class="flex h-3 w-3 relative">
                            <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-amber-400 opacity-75"></span>
                            <span class="relative inline-flex rounded-full h-3 w-3 bg-gradient-to-r from-amber-400 to-yellow-300"></span>
                        </span>
                        <span class="text-xs sm:text-sm font-semibold tracking-wide text-amber-200">
                            🏅 2026 Gold Medalist & Ph.D. in Online Astro Counselling
                        </span>
                    </div>

                    <!-- Main Heading & Astrologer Identity -->
                    <div class="space-y-2">
                        <h1 class="font-cinzel text-3xl sm:text-5xl lg:text-6xl font-black tracking-tight text-white leading-tight">
                            <span class="gold-gradient-text block">DR. E. K. Raja Varma</span>
                        </h1>
                        <p class="font-cinzel text-lg sm:text-2xl font-bold text-amber-300/90 tracking-wide">
                            (Vidya Vachaspathi in Vedic Astrology)
                        </p>
                    </div>

                    <!-- Mobile-Exclusive Instant Jump to Free DOB Prediction Form -->
                    <div class="lg:hidden p-3.5 rounded-2xl bg-gradient-to-r from-amber-500/20 via-yellow-400/15 to-[#261238] border-2 border-amber-400/50 shadow-xl flex items-center justify-between gap-3">
                        <div class="space-y-0.5">
                            <div class="flex items-center space-x-1.5">
                                <span class="animate-pulse text-sm">✨</span>
                                <span class="font-cinzel text-xs font-bold text-amber-300 uppercase tracking-wide">Free DOB Horoscope</span>
                                <span class="text-[9px] px-1.5 py-0.5 rounded-full bg-amber-400 text-black font-extrabold uppercase">100% Free</span>
                            </div>
                            <p class="text-[11px] text-amber-100/75 leading-tight">Instant Vedic Mulank, Rasi & Gemstone reading</p>
                        </div>
                        <a href="#dob-calculator"
                           class="shrink-0 px-3.5 py-2 rounded-xl text-xs font-bold text-[#1a1128] bg-gradient-to-r from-amber-300 via-yellow-400 to-amber-500 shadow-lg flex items-center space-x-1 hover:from-amber-200 hover:to-yellow-300 transition-all transform active:scale-95">
                            <span>Get Reading</span>
                            <span class="text-sm">↓</span>
                        </a>
                    </div>

                    <!-- Astrologer Featured Portrait Card -->
                    <div class="flex flex-col sm:flex-row items-center sm:items-start gap-5 p-4 sm:p-5 rounded-2xl bg-gradient-to-r from-[#201133]/90 via-[#2f1020]/80 to-[#190e28]/90 border border-amber-500/40 shadow-xl backdrop-blur-md">
                        <!-- Royal Gold Ornate Frame -->
                        <div class="relative shrink-0">
                            <div class="w-36 h-36 sm:w-44 sm:h-44 rounded-2xl p-1.5 bg-gradient-to-tr from-amber-600 via-amber-300 to-yellow-500 shadow-2xl gold-glow transform rotate-1 hover:rotate-0 transition-transform duration-300">
                                <img src="{{ asset('storage/media/images/covilakam-4bcJQK.webp') }}?v={{ time() }}"
                                     alt="DR. E. K. Raja Varma (Vidya Vachaspathi in Vedic Astrology)"
                                     onerror="this.onerror=null; this.src='{{ asset('images/covilakam-hero.webp') }}';"
                                     class="w-full h-full object-cover object-top rounded-xl border border-amber-300/60 shadow-inner">
                            </div>
                            <span class="absolute -bottom-2 -right-2 px-2.5 py-0.5 rounded-full bg-amber-400 text-[10px] font-extrabold text-[#1a1128] uppercase shadow-lg border border-amber-200">
                                Verified
                            </span>
                        </div>

                        <!-- Bio Snippet & Tagline -->
                        <div class="space-y-2 text-center sm:text-left">
                            <p class="font-cinzel text-xs text-amber-300 uppercase tracking-widest font-bold">
                                Covilakam Astrology • <span class="italic font-playfair lowercase">Explore. Discover. Transform.</span>
                            </p>
                            <p class="text-xs sm:text-sm text-amber-100/80 leading-relaxed">
                                Conferred Ph.D. in Vedic Astrology (Specialisation in Online Astro Counselling) by IAMA Open University, Florida, and Gold Medalist at Shree Maharshi College of Vedic Astrology. Dedicated to helping you align with cosmic harmony since 2022.
                            </p>
                            <div class="text-[11px] text-amber-200/90 font-medium pt-0.5">
                                <span class="text-amber-400 font-bold">IAF Life Member ID:</span> 11009
                            </div>
                        </div>
                    </div>

                    <!-- Quick Consultation Checklist -->
                    <div class="pt-1">
                        <p class="text-xs uppercase tracking-wider text-amber-300/90 font-cinzel font-bold mb-2">
                            Quick Consultation Checklist:
                        </p>
                        <div class="grid grid-cols-2 sm:grid-cols-3 gap-2 text-xs">
                            <div class="flex items-center space-x-2 text-amber-100/90 bg-[#1e1330]/60 px-3 py-1.5 rounded-lg border border-amber-500/20">
                                <span class="text-amber-400">✦</span>
                                <span>Accurate Predictions</span>
                            </div>
                            <div class="flex items-center space-x-2 text-amber-100/90 bg-[#1e1330]/60 px-3 py-1.5 rounded-lg border border-amber-500/20">
                                <span class="text-amber-400">✦</span>
                                <span>Jathakam Reports</span>
                            </div>
                            <div class="flex items-center space-x-2 text-amber-100/90 bg-[#1e1330]/60 px-3 py-1.5 rounded-lg border border-amber-500/20">
                                <span class="text-amber-400">✦</span>
                                <span>Marriage Match</span>
                            </div>
                            <div class="flex items-center space-x-2 text-amber-100/90 bg-[#1e1330]/60 px-3 py-1.5 rounded-lg border border-amber-500/20">
                                <span class="text-amber-400">✦</span>
                                <span>Gem Prediction</span>
                            </div>
                            <div class="flex items-center space-x-2 text-amber-100/90 bg-[#1e1330]/60 px-3 py-1.5 rounded-lg border border-amber-500/20">
                                <span class="text-amber-400">✦</span>
                                <span>Muhoorthams</span>
                            </div>
                            <div class="flex items-center space-x-2 text-amber-100/90 bg-[#1e1330]/60 px-3 py-1.5 rounded-lg border border-amber-500/20">
                                <span class="text-amber-400">✦</span>
                                <span>Astro Counselling</span>
                            </div>
                        </div>
                    </div>

                    <!-- Primary CTAs -->
                    <div class="pt-2 flex flex-col sm:flex-row items-stretch sm:items-center gap-4">
                        <!-- CTA 1: Book Online Consultation -->
                        <button @click="$dispatch('open-booking-modal', { service: 'Accurate Predictions' })"
                                class="flex items-center justify-center space-x-2.5 px-6 py-3.5 rounded-xl text-sm font-bold text-[#1a1128] bg-gradient-to-r from-amber-300 via-yellow-400 to-amber-500 hover:from-amber-200 hover:to-yellow-300 shadow-xl hover:shadow-amber-500/40 transition-all duration-200 transform hover:-translate-y-0.5">
                            <svg class="w-5 h-5 text-[#1a1128]" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                            </svg>
                            <span>Book Online Consultation</span>
                        </button>

                        <!-- CTA 2: Chat on WhatsApp (7907052160) -->
                        <a href="https://wa.me/917907052160?text={{ rawurlencode('Namaskaram DR. E. K. Raja Varma (Vidya Vachaspathi in Vedic Astrology), I would like to book an online astrological consultation.') }}"
                           target="_blank"
                           class="flex items-center justify-center space-x-2.5 px-6 py-3.5 rounded-xl text-sm font-bold text-white bg-emerald-600 hover:bg-emerald-500 border border-emerald-400/40 shadow-xl hover:shadow-emerald-500/30 transition-all duration-200 transform hover:-translate-y-0.5">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M12.031 6.172c-3.181 0-5.767 2.586-5.768 5.766-.001 1.298.38 2.27 1.019 3.287l-.711 2.598 2.664-.698c.969.585 1.961.947 2.796.947 3.179 0 5.766-2.587 5.767-5.766.001-3.181-2.586-5.767-5.767-5.767zm0 10.373c-.768 0-1.637-.251-2.327-.661l-.167-.099-1.58.414.422-1.539-.109-.174c-.453-.722-.693-1.564-.693-2.55 0-2.539 2.066-4.605 4.606-4.605 2.54 0 4.606 2.066 4.606 4.606 0 2.54-2.066 4.608-4.755 4.608z"/>
                            </svg>
                            <span>Chat on WhatsApp (7907052160)</span>
                        </a>
                    </div>

                    <!-- Official Google Pay & UPI Quick Scan Card in Hero Section -->
                    <div class="mt-4 p-3.5 sm:p-4 rounded-2xl bg-gradient-to-r from-[#201032]/95 via-[#2b0e22]/90 to-[#180c28]/95 border-2 border-amber-500/40 shadow-2xl backdrop-blur-md flex flex-col sm:flex-row items-center justify-between gap-4">
                        <div class="flex items-center space-x-3.5 w-full sm:w-auto">
                            <!-- Clickable GPay QR Thumbnail with Gold Frame -->
                            <div class="relative shrink-0 cursor-pointer group" @click="gpayModalOpen = true" title="Click to enlarge QR Code">
                                <div class="w-16 h-16 sm:w-20 sm:h-20 rounded-xl p-1 bg-white shadow-xl border-2 border-amber-400 group-hover:scale-105 transition-transform duration-200">
                                    <img src="{{ asset('images/gpay-qr-code.jpg') }}" alt="Google Pay QR Code - DR. E. K. Raja Varma" class="w-full h-full object-contain">
                                </div>
                                <span class="absolute -bottom-1 -right-1 px-1.5 py-0.5 rounded-full bg-emerald-500 text-[9px] font-black text-white uppercase shadow-md border border-[#160d24]">
                                    Pay
                                </span>
                            </div>

                            <div class="space-y-0.5">
                                <div class="flex items-center space-x-2">
                                    <span class="font-cinzel text-xs font-bold text-amber-300">Google Pay • UPI Dakshina</span>
                                    <span class="text-[9px] px-1.5 py-0.2 rounded-full bg-amber-400/20 text-amber-300 font-bold border border-amber-400/40">Verified UPI</span>
                                </div>
                                <p class="text-xs text-amber-100 font-semibold">
                                    UPI ID: <span class="font-mono text-amber-300 font-bold tracking-wide select-all">ekrvarma-1@oksbi</span>
                                </p>
                                <p class="text-[11px] text-amber-200/80">
                                    GPay / Phone: <strong class="text-amber-300">094473 27450</strong> (Raja Varma)
                                </p>
                            </div>
                        </div>

                        <!-- Scan QR Button -->
                        <div class="shrink-0 w-full sm:w-auto text-right">
                            <button type="button" @click="gpayModalOpen = true"
                                    class="w-full sm:w-auto px-4 py-2.5 rounded-xl text-xs font-bold text-[#1a1128] bg-gradient-to-r from-amber-300 via-yellow-400 to-amber-500 hover:from-amber-200 hover:to-yellow-300 shadow-lg flex items-center justify-center space-x-1.5 transition-all">
                                <svg class="w-4 h-4 text-[#1a1128]" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm12 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z"/>
                                </svg>
                                <span>Scan GPay QR</span>
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Right Column (Interactive "Free DOB Instant Astro Reading" Card) -->
                <div id="dob-calculator" class="lg:col-span-5 scroll-mt-24 sm:scroll-mt-28">
                    <div class="relative rounded-3xl p-6 sm:p-7 bg-[#170e26]/95 border-2 border-amber-500/40 shadow-2xl gold-glow backdrop-blur-xl">
                        
                        <!-- Header with Golden Accent -->
                        <div class="flex items-center justify-between border-b border-amber-500/20 pb-4 mb-5">
                            <div>
                                <span class="inline-block text-[10px] font-bold tracking-widest uppercase text-amber-300 bg-amber-500/10 px-2 py-0.5 rounded-full border border-amber-400/30 mb-1">
                                    Instant Pure Vedic Algorithm
                                </span>
                                <h3 class="font-cinzel text-xl sm:text-2xl font-bold text-white flex items-center gap-2">
                                    <span>Free DOB Astro Reading</span>
                                    <span class="text-amber-400 text-lg">✨</span>
                                </h3>
                            </div>
                            <div class="text-right">
                                <span class="text-xs text-amber-300/80 font-mono">100% Free</span>
                            </div>
                        </div>

                        <!-- INPUT FORM VIEW -->
                        <div x-show="!hasResult">
                            <p class="text-xs text-amber-100/70 mb-5 leading-relaxed">
                                Enter your Date of Birth in the standard Indian format <strong>(DD/MM/YYYY)</strong> to instantly reveal your <strong>Vedic Birth Number (Mulank)</strong>, <strong>Destiny Number (Bhagyank)</strong>, <strong>Navagraha Ruling Planet</strong>, <strong>Malayalam Surya Rasi</strong>, and <strong>Lucky Gemstone</strong>.
                            </p>

                            <form @submit.prevent="submitDobForm" id="dob-traditional-form" action="{{ route('consultations.calculate-dob') }}" method="POST" class="space-y-4 text-xs">
                                @csrf
                                <input type="hidden" name="birth_date" :value="calcDob">

                                <div>
                                    <label class="block font-semibold text-amber-200 mb-1">Your Full Name *</label>
                                    <input type="text" x-model="calcName" name="name" required placeholder="e.g., Rajesh Sharma"
                                           class="w-full px-3.5 py-2.5 rounded-xl bg-[#231538] border border-amber-500/30 text-white placeholder-amber-200/40 focus:outline-none focus:border-amber-400 transition-colors">
                                </div>

                                <!-- INDIAN FORMAT (DD / MM / YYYY) DOB PICKER WITH EASY YEAR SELECTION -->
                                <div>
                                    <div class="flex items-center justify-between mb-1.5">
                                        <label class="block font-semibold text-amber-200">
                                            Date of Birth (DOB) *
                                        </label>
                                        <span class="text-[10px] text-amber-300 font-mono font-bold bg-amber-500/15 px-2 py-0.5 rounded border border-amber-500/30">
                                            Indian Format: DD / MM / YYYY
                                        </span>
                                    </div>

                                    <div class="grid grid-cols-3 gap-2">
                                        <!-- Day Select (DD: 01 to 31) -->
                                        <div>
                                            <label class="block text-[10px] text-amber-200/60 mb-0.5">Day (DD)</label>
                                            <select x-model="calcDay" @change="syncDob" required
                                                    class="w-full px-2.5 py-2.5 rounded-xl bg-[#231538] border border-amber-500/30 text-white font-mono text-xs focus:outline-none focus:border-amber-400 transition-colors">
                                                <option value="" disabled selected>DD</option>
                                                <template x-for="d in daysInMonth" :key="d">
                                                    <option :value="String(d).padStart(2, '0')" x-text="String(d).padStart(2, '0')"></option>
                                                </template>
                                            </select>
                                        </div>

                                        <!-- Month Select (MM: Jan to Dec) -->
                                        <div>
                                            <label class="block text-[10px] text-amber-200/60 mb-0.5">Month (MM)</label>
                                            <select x-model="calcMonth" @change="updateDays" required
                                                    class="w-full px-2 py-2.5 rounded-xl bg-[#231538] border border-amber-500/30 text-white font-mono text-xs focus:outline-none focus:border-amber-400 transition-colors">
                                                <option value="" disabled selected>MM</option>
                                                <option value="01">01 - Jan</option>
                                                <option value="02">02 - Feb</option>
                                                <option value="03">03 - Mar</option>
                                                <option value="04">04 - Apr</option>
                                                <option value="05">05 - May</option>
                                                <option value="06">06 - Jun</option>
                                                <option value="07">07 - Jul</option>
                                                <option value="08">08 - Aug</option>
                                                <option value="09">09 - Sep</option>
                                                <option value="10">10 - Oct</option>
                                                <option value="11">11 - Nov</option>
                                                <option value="12">12 - Dec</option>
                                            </select>
                                        </div>

                                        <!-- Year Select (YYYY: 2026 down to 1920 - Super Easy Dropdown) -->
                                        <div>
                                            <label class="block text-[10px] text-amber-200/60 mb-0.5">Year (YYYY)</label>
                                            <select x-model="calcYear" @change="updateDays" required
                                                    class="w-full px-2 py-2.5 rounded-xl bg-[#231538] border border-amber-500/30 text-white font-mono text-xs focus:outline-none focus:border-amber-400 transition-colors">
                                                <option value="" disabled selected>YYYY</option>
                                                @for($y = 2026; $y >= 1920; $y--)
                                                    <option value="{{ $y }}">{{ $y }}</option>
                                                @endfor
                                            </select>
                                        </div>
                                    </div>

                                    <!-- Selected DOB Indian Preview -->
                                    <div x-show="calcDay && calcMonth && calcYear" class="mt-1.5 flex items-center justify-between text-[11px] text-amber-300 font-mono bg-[#1c112e] px-2.5 py-1 rounded-lg border border-amber-500/20">
                                        <span>Selected DOB:</span>
                                        <span class="font-bold text-amber-200" x-text="calcDay + '-' + calcMonth + '-' + calcYear + ' (DD-MM-YYYY)'"></span>
                                    </div>
                                </div>

                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                                    <div>
                                        <label class="block font-semibold text-amber-200 mb-1">WhatsApp / Phone (Optional)</label>
                                        <input type="tel" x-model="calcPhone" name="phone" placeholder="+91 98765 43210"
                                               class="w-full px-3.5 py-2.5 rounded-xl bg-[#231538] border border-amber-500/30 text-white placeholder-amber-200/40 focus:outline-none focus:border-amber-400 transition-colors">
                                    </div>
                                    <div>
                                        <label class="block font-semibold text-amber-200 mb-1">Service Needed</label>
                                        <select x-model="calcService" name="service_requested"
                                                class="w-full px-3.5 py-2.5 rounded-xl bg-[#231538] border border-amber-500/30 text-white focus:outline-none focus:border-amber-400 transition-colors">
                                            <option value="Accurate Predictions">Accurate Predictions</option>
                                            <option value="Jathakam Reports">Jathakam Reports</option>
                                            <option value="Marriage Match Reports">Marriage Match Reports</option>
                                            <option value="Gem Prediction Reports">Gem Prediction Reports</option>
                                            <option value="Muhoorthams">Muhoorthams</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="pt-2">
                                    <button type="submit"
                                            :disabled="calcLoading"
                                            class="w-full py-3.5 px-4 rounded-xl font-bold text-sm text-[#1a1128] bg-gradient-to-r from-amber-300 via-yellow-400 to-amber-500 hover:from-amber-200 hover:to-yellow-300 shadow-xl hover:shadow-amber-500/40 transition-all duration-200 flex items-center justify-center space-x-2">
                                        <template x-if="calcLoading">
                                            <svg class="animate-spin h-5 w-5 text-[#1a1128]" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                            </svg>
                                        </template>
                                        <template x-if="!calcLoading">
                                            <span>✨ Reveal My Vedic Reading Now</span>
                                        </template>
                                    </button>
                                </div>
                            </form>
                        </div>

                        <!-- RESULT TEASER VIEW WITH 4-LANGUAGE SWITCHER (English, Malayalam, Tamil, Hindi) -->
                        <div x-show="hasResult" x-cloak id="dob-result-card" class="space-y-4">
                            
                            <!-- Header Bar with Name and Indian Formatted DOB -->
                            <div class="bg-gradient-to-r from-amber-950/60 to-purple-950/60 border border-amber-500/30 p-4 rounded-2xl">
                                <div class="flex items-center justify-between mb-1.5">
                                    <span class="text-xs text-amber-300 font-bold">Vedic Reading for:</span>
                                    <span class="text-sm font-bold text-white" x-text="calcResult?.name"></span>
                                </div>
                                <div class="flex items-center justify-between text-[11px] text-amber-200/80 font-mono">
                                    <span>DOB: <strong class="text-amber-300" x-text="calcResult?.birth_date"></strong> (DD-MM-YYYY)</span>
                                    <span class="text-amber-400/80" x-text="calcResult?.birth_date_display"></span>
                                </div>
                            </div>

                            <!-- 4-LANGUAGE SWITCHER BUTTON BAR -->
                            <div class="p-2 rounded-2xl bg-[#130922] border border-amber-500/30">
                                <div class="flex items-center justify-between mb-1 px-1">
                                    <span class="text-[10px] uppercase font-bold tracking-wider text-amber-300">Choose Reading Language:</span>
                                    <span class="text-[9px] text-amber-400/70 font-mono">4 Languages</span>
                                </div>
                                <div class="grid grid-cols-4 gap-1.5">
                                    <button type="button" @click="readingLang = 'en'"
                                            :class="readingLang === 'en' ? 'bg-gradient-to-r from-amber-400 to-yellow-400 text-black font-extrabold shadow-md' : 'bg-[#221338] text-amber-200/80 hover:text-white border border-amber-500/20'"
                                            class="py-1.5 px-1 rounded-xl text-xs text-center transition-all">
                                        🇬🇧 English
                                    </button>
                                    <button type="button" @click="readingLang = 'ml'"
                                            :class="readingLang === 'ml' ? 'bg-gradient-to-r from-amber-400 to-yellow-400 text-black font-extrabold shadow-md' : 'bg-[#221338] text-amber-200/80 hover:text-white border border-amber-500/20'"
                                            class="py-1.5 px-1 rounded-xl text-xs text-center transition-all font-malayalam">
                                        മലയാളം
                                    </button>
                                    <button type="button" @click="readingLang = 'ta'"
                                            :class="readingLang === 'ta' ? 'bg-gradient-to-r from-amber-400 to-yellow-400 text-black font-extrabold shadow-md' : 'bg-[#221338] text-amber-200/80 hover:text-white border border-amber-500/20'"
                                            class="py-1.5 px-1 rounded-xl text-xs text-center transition-all font-tamil">
                                        தமிழ்
                                    </button>
                                    <button type="button" @click="readingLang = 'hi'"
                                            :class="readingLang === 'hi' ? 'bg-gradient-to-r from-amber-400 to-yellow-400 text-black font-extrabold shadow-md' : 'bg-[#221338] text-amber-200/80 hover:text-white border border-amber-500/20'"
                                            class="py-1.5 px-1 rounded-xl text-xs text-center transition-all font-hindi">
                                        हिन्दी
                                    </button>
                                </div>
                            </div>

                            <!-- Metrics Grid (Dynamic based on selected language) -->
                            <div class="grid grid-cols-2 gap-2.5 text-xs">
                                <!-- Mulank -->
                                <div class="p-3 rounded-xl bg-[#231538] border border-amber-500/20">
                                    <span class="text-[10px] text-amber-300/80 block uppercase">Birth No. (Mulank)</span>
                                    <div class="flex items-baseline space-x-1.5 mt-0.5">
                                        <span class="font-cinzel text-2xl font-bold text-amber-300" x-text="calcResult?.mulank"></span>
                                        <span class="text-[11px] text-amber-200/80 truncate font-semibold"
                                              x-text="calcResult?.ruling_planet?.[readingLang] || calcResult?.ruling_planet?.en"></span>
                                    </div>
                                </div>

                                <!-- Bhagyank -->
                                <div class="p-3 rounded-xl bg-[#231538] border border-amber-500/20">
                                    <span class="text-[10px] text-amber-300/80 block uppercase">Destiny (Bhagyank)</span>
                                    <div class="flex items-baseline space-x-1.5 mt-0.5">
                                        <span class="font-cinzel text-2xl font-bold text-yellow-300" x-text="calcResult?.bhagyank"></span>
                                        <span class="text-[11px] text-amber-200/80 truncate font-semibold"
                                              x-text="calcResult?.destiny_planet?.[readingLang] || calcResult?.destiny_planet?.en"></span>
                                    </div>
                                </div>

                                <!-- Malayalam Surya Rasi -->
                                <div class="col-span-2 p-3 rounded-xl bg-[#231538] border border-amber-500/20">
                                    <span class="text-[10px] text-amber-300/80 block uppercase">Surya Rasi (സൗര രാശി)</span>
                                    <p class="font-semibold text-white text-xs mt-0.5">
                                        <span class="text-amber-300 font-bold"
                                              x-text="readingLang === 'ta' ? (calcResult?.solar_sign?.name_ta || calcResult?.solar_sign?.name_ml) : (readingLang === 'hi' ? (calcResult?.solar_sign?.name_hi || calcResult?.solar_sign?.name_ml) : (readingLang === 'ml' ? calcResult?.solar_sign?.name_ml : calcResult?.solar_sign?.name_en))"></span>
                                        <span class="text-amber-200/70 ml-1" x-text="'(' + calcResult?.solar_sign?.name_ml + ')'"></span>
                                    </p>
                                </div>

                                <!-- Ruling Navagraha & Gemstone -->
                                <div class="col-span-2 p-3 rounded-xl bg-[#231538] border border-amber-500/20">
                                    <div class="grid grid-cols-2 gap-2">
                                        <div>
                                            <span class="text-[10px] text-amber-300/80 block uppercase">Navagraha Lord</span>
                                            <span class="font-semibold text-amber-200 block text-xs"
                                                  x-text="calcResult?.ruling_planet?.[readingLang] || calcResult?.ruling_planet?.en"></span>
                                        </div>
                                        <div>
                                            <span class="text-[10px] text-amber-300/80 block uppercase">Recommended Gemstone</span>
                                            <span class="font-semibold text-amber-300 block text-xs"
                                                  x-text="readingLang === 'ta' ? (calcResult?.gemstone_ta || calcResult?.gemstone_en) : (readingLang === 'hi' ? (calcResult?.gemstone_hi || calcResult?.gemstone_en) : (readingLang === 'ml' ? calcResult?.gemstone_ml : calcResult?.gemstone_en))"></span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- FULL ON-SITE PREDICTION READER ACCORDION/TABS -->
                            <div class="mt-4 pt-4 border-t border-amber-500/30 text-xs"
                                 x-data="{ readTab: 'life' }">
                                <div class="flex items-center justify-between mb-2">
                                    <span class="font-bold text-amber-300 text-xs flex items-center space-x-1">
                                        <span>📜 Read Your Full Vedic Prediction on Site:</span>
                                    </span>
                                    <span class="text-[10px] text-amber-400/80 bg-amber-500/10 px-2 py-0.5 rounded border border-amber-500/20">Free Reading</span>
                                </div>

                                <!-- Tabs for on-site prediction reading -->
                                <div class="grid grid-cols-4 gap-1 p-1 bg-[#190d28] rounded-xl border border-amber-500/20 mb-3">
                                    <button type="button" @click="readTab = 'life'"
                                            :class="readTab === 'life' ? 'bg-amber-400 text-black font-bold' : 'text-amber-200/70 hover:text-white'"
                                            class="py-1 px-1 text-[10px] rounded-lg text-center transition-all">
                                        🌟 Life Path
                                    </button>
                                    <button type="button" @click="readTab = 'career'"
                                            :class="readTab === 'career' ? 'bg-amber-400 text-black font-bold' : 'text-amber-200/70 hover:text-white'"
                                            class="py-1 px-1 text-[10px] rounded-lg text-center transition-all">
                                        💼 Career
                                    </button>
                                    <button type="button" @click="readTab = 'love'"
                                            :class="readTab === 'love' ? 'bg-amber-400 text-black font-bold' : 'text-amber-200/70 hover:text-white'"
                                            class="py-1 px-1 text-[10px] rounded-lg text-center transition-all">
                                        💖 Love
                                    </button>
                                    <button type="button" @click="readTab = 'mantra'"
                                            :class="readTab === 'mantra' ? 'bg-amber-400 text-black font-bold' : 'text-amber-200/70 hover:text-white'"
                                            class="py-1 px-1 text-[10px] rounded-lg text-center transition-all">
                                        💎 Remedies
                                    </button>
                                </div>

                                <!-- Tab Content Card (Display in selected language) -->
                                <div class="p-3.5 rounded-xl bg-[#231538] border border-amber-500/25 text-[11px] leading-relaxed max-h-56 overflow-y-auto space-y-2 text-amber-100/90">
                                    <!-- Life Path Tab -->
                                    <div x-show="readTab === 'life'">
                                        <p class="font-bold text-amber-300 mb-1"
                                           x-text="calcResult?.archetype?.[readingLang] || calcResult?.archetype?.en || calcResult?.archetype"></p>
                                        <p class="leading-relaxed"
                                           x-text="calcResult?.personality_prediction?.[readingLang] || calcResult?.personality_prediction?.en || calcResult?.traits?.[readingLang] || calcResult?.traits"></p>
                                    </div>

                                    <!-- Career Tab -->
                                    <div x-show="readTab === 'career'" x-cloak>
                                        <p class="font-bold text-amber-300 mb-1">
                                            <span x-show="readingLang === 'en'">Career &amp; Wealth Horizon:</span>
                                            <span x-show="readingLang === 'ml'">തൊഴിൽ &amp; സാമ്പത്തിക ഭാവിലക്ഷണങ്ങൾ:</span>
                                            <span x-show="readingLang === 'ta'">தொழில் மற்றும் நிதி முன்னேற்றம்:</span>
                                            <span x-show="readingLang === 'hi'">आजीविका एवं धन समृद्धि:</span>
                                        </p>
                                        <p class="leading-relaxed"
                                           x-text="calcResult?.career_prediction?.[readingLang] || calcResult?.career_prediction?.en || calcResult?.career_prediction"></p>
                                    </div>

                                    <!-- Love Tab -->
                                    <div x-show="readTab === 'love'" x-cloak>
                                        <p class="font-bold text-amber-300 mb-1">
                                            <span x-show="readingLang === 'en'">Relationship &amp; Family Harmony:</span>
                                            <span x-show="readingLang === 'ml'">ദാമ്പത്യം &amp; കുടുംബസമാധാനം:</span>
                                            <span x-show="readingLang === 'ta'">குடும்பம் மற்றும் தாம்பத்திய ஒற்றுமை:</span>
                                            <span x-show="readingLang === 'hi'">पारिवारिक सुख एवं दांपत्य सामंजस्य:</span>
                                        </p>
                                        <p class="leading-relaxed"
                                           x-text="calcResult?.relationship_prediction?.[readingLang] || calcResult?.relationship_prediction?.en || calcResult?.relationship_prediction"></p>
                                    </div>

                                    <!-- Remedies Tab -->
                                    <div x-show="readTab === 'mantra'" x-cloak class="space-y-2.5">
                                        <div>
                                            <span class="font-bold text-amber-300">
                                                <span x-show="readingLang === 'en'">Prescribed Gemstone:</span>
                                                <span x-show="readingLang === 'ml'">നിർദ്ദേശിക്കുന്ന രത്നം:</span>
                                                <span x-show="readingLang === 'ta'">பரிந்துரைக்கப்படும் ரத்தினம்:</span>
                                                <span x-show="readingLang === 'hi'">अनुशंसित रत्न:</span>
                                            </span>
                                            <span class="font-semibold text-white ml-1"
                                                  x-text="(readingLang === 'ta' ? (calcResult?.gemstone_ta || calcResult?.gemstone_en) : (readingLang === 'hi' ? (calcResult?.gemstone_hi || calcResult?.gemstone_en) : (readingLang === 'ml' ? calcResult?.gemstone_ml : calcResult?.gemstone_en)))"></span>
                                            <p class="text-[10px] text-amber-200/70 mt-0.5"
                                               x-text="'Wearing Rule: ' + (calcResult?.wearing_rule?.[readingLang] || calcResult?.wearing_rule?.en || calcResult?.wearing_rule)"></p>
                                        </div>

                                        <!-- Doctor Remedy Guidance -->
                                        <div class="p-2.5 rounded-lg bg-amber-950/40 border border-amber-500/25">
                                            <span class="text-[10px] uppercase font-bold text-amber-300 block mb-0.5">
                                                <span x-show="readingLang === 'en'">Spiritual Remedy by DR. E. K. Raja Varma:</span>
                                                <span x-show="readingLang === 'ml'">ഡോ. രാജവർമ്മ നിർദ്ദേശിക്കുന്ന പരിഹാരം:</span>
                                                <span x-show="readingLang === 'ta'">டாக்டர் ராஜா வர்மாவின் ஆன்மீக பரிகாரம்:</span>
                                                <span x-show="readingLang === 'hi'">डॉ. राजा वर्मा द्वारा अनुशंसित उपाय:</span>
                                            </span>
                                            <p class="text-[10.5px] text-amber-100/90 leading-relaxed"
                                               x-text="calcResult?.doctor_remedy?.[readingLang] || calcResult?.doctor_remedy?.en || calcResult?.doctor_remedy"></p>
                                        </div>

                                        <template x-if="calcResult?.mantra_sanskrit">
                                            <div class="p-2 rounded-lg bg-amber-950/60 border border-amber-500/30 text-center">
                                                <span class="text-[9px] uppercase tracking-wider text-amber-400 block font-bold">Navagraha Beej Mantra</span>
                                                <p class="font-serif text-xs text-amber-200 mt-0.5" x-text="calcResult?.mantra_sanskrit"></p>
                                                <p class="text-[9.5px] italic text-amber-300/80 font-mono" x-text="calcResult?.mantra_translit"></p>
                                            </div>
                                        </template>
                                    </div>
                                </div>
                            </div>

                            <!-- Dual Actions: Read Full Report on Site & WhatsApp -->
                            <div class="pt-2 space-y-2">
                                <!-- Open Full Dedicated Prediction Page -->
                                <a :href="(calcResult?.report_url || ('{{ url('/prediction') }}/' + calcResult?.consultation_id)) + '?lang=' + readingLang"
                                   class="w-full py-2.5 px-3 rounded-xl font-bold text-xs text-[#1a1128] bg-gradient-to-r from-amber-300 to-yellow-400 hover:from-amber-200 hover:to-yellow-300 shadow-md flex items-center justify-center space-x-2 transition-all">
                                    <span>📜 Read &amp; Print Full Dedicated Report on Site</span>
                                </a>

                                <!-- 1-Click WhatsApp Consultation Button -->
                                <a :href="calcResult?.whatsapp_url"
                                   target="_blank"
                                   class="w-full py-2.5 px-3 rounded-xl font-bold text-xs text-white bg-emerald-600 hover:bg-emerald-500 shadow-lg flex items-center justify-center space-x-2 transition-all">
                                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
                                        <path d="M12.031 6.172c-3.181 0-5.767 2.586-5.768 5.766-.001 1.298.38 2.27 1.019 3.287l-.711 2.598 2.664-.698c.969.585 1.961.947 2.796.947 3.179 0 5.766-2.587 5.767-5.766.001-3.181-2.586-5.767-5.767-5.767zm0 10.373c-.768 0-1.637-.251-2.327-.661l-.167-.099-1.58.414.422-1.539-.109-.174c-.453-.722-.693-1.564-.693-2.55 0-2.539 2.066-4.605 4.606-4.605 2.54 0 4.606 2.066 4.606 4.606 0 2.54-2.066 4.608-4.755 4.608z"/>
                                    </svg>
                                    <span>Discuss with DR. E. K. Raja Varma on WhatsApp</span>
                                </a>
                            </div>

                            <!-- Recalculate Button -->
                            <button @click="resetCalculator" class="w-full text-center text-xs text-amber-300/70 hover:text-amber-200 underline pt-1">
                                🔄 Calculate for another Date of Birth
                            </button>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section>

    <!-- ========================================================================= -->
    <!-- SECTION 2: Achievement Announcement / Credential Banner                   -->
    <!-- ========================================================================= -->
    <!-- SECTION 2: Academic Honor & Convocation Record Showcase                   -->
    <!-- ========================================================================= -->
    <section id="academic-honors" class="relative py-16 bg-gradient-to-b from-[#180a1c] via-[#240b1a] to-[#120a1c] border-y-2 border-amber-500/40 shadow-2xl overflow-hidden">
        <!-- Subtle sacred background accents -->
        <div class="absolute inset-0 bg-radial from-amber-500/5 via-transparent to-transparent pointer-events-none"></div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
            <!-- Section Header -->
            <div class="text-center max-w-3xl mx-auto mb-12 space-y-3">
                <div class="inline-flex items-center space-x-2 text-xs uppercase tracking-widest text-amber-300 font-bold bg-amber-500/20 px-4 py-1.5 rounded-full border border-amber-400/40 shadow-md">
                    <span class="animate-pulse">🥇</span>
                    <span>Academic Honor & Convocation Record</span>
                    <span>•</span>
                    <span>27th September 2026</span>
                </div>
                <h2 class="font-cinzel text-2xl sm:text-4xl font-extrabold text-white leading-tight">
                    Vidya Vachaspathi Gold Medalist & Ph.D. in Vedic Astrology
                </h2>
                <div class="w-24 h-1 bg-gradient-to-r from-transparent via-amber-400 to-transparent mx-auto"></div>
                <p class="text-xs sm:text-sm text-amber-100/80 leading-relaxed max-w-2xl mx-auto">
                    Awarded the prestigious <strong>Gold Medal in Vidya Vachaspathi</strong> examination at <em>Shree Maharshi College of Vedic Astrology, Udaipur, Rajasthan</em>, and conferred <strong>Doctorate of Philosophy (Ph.D.)</strong> with specialisation in <strong>Online Astro Counselling</strong> by <em>IAMA Open University, Florida</em>.
                </p>
            </div>

            <!-- Two Convocation Document Cards Displayed Compactly Without Cropping -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 max-w-4xl mx-auto items-stretch mb-8">
                
                <!-- Document 1: Convocation Felicitation & Certificate -->
                <div class="card-gold-frame rounded-2xl p-4 sm:p-5 flex flex-col justify-between bg-gradient-to-b from-[#1f112c]/90 to-[#12081d]/95 backdrop-blur-md hover:border-amber-400/80 transition-all duration-300 group shadow-xl">
                    <div class="space-y-3">
                        <div class="flex items-center justify-between pb-2.5 border-b border-amber-500/20">
                            <div class="flex items-center space-x-2">
                                <span class="text-lg">📜</span>
                                <span class="font-cinzel text-xs sm:text-sm font-bold text-amber-200">Convocation Record & Honor</span>
                            </div>
                            <span class="text-[10px] font-semibold text-amber-400/90 bg-amber-400/10 px-2 py-0.5 rounded-full border border-amber-400/30">
                                27 Sep 2026
                            </span>
                        </div>

                        <!-- Compact Uncropped Image Container -->
                        <div class="relative w-full rounded-xl bg-[#0b0412] p-2 border border-amber-500/20 flex items-center justify-center h-48 sm:h-56 overflow-hidden group-hover:border-amber-400/50 transition-colors">
                            <a href="{{ asset('storage/media/images/screenshot-2026-10-22-084835-yzdRy8.webp') }}" target="_blank" class="block h-full w-full flex items-center justify-center group/img">
                                <img src="{{ asset('storage/media/images/screenshot-2026-10-22-084835-yzdRy8.webp') }}"
                                     alt="Academic Honor & Convocation Record - DR. E. K. Raja Varma"
                                     onerror="this.onerror=null; this.src='{{ asset('images/convocation-record-1.webp') }}';"
                                     class="max-h-full max-w-full h-auto w-auto object-contain mx-auto rounded-lg shadow-md transition-transform duration-300 group-hover/img:scale-105">
                            </a>
                        </div>

                        <p class="text-[11px] text-amber-100/75 leading-relaxed text-center sm:text-left">
                            Official convocation felicitation credential confirming Vidya Vachaspathi distinction and university recognition.
                        </p>
                    </div>

                    <div class="pt-3 mt-3 border-t border-amber-500/20 flex items-center justify-between">
                        <span class="text-[10px] text-amber-300/75">Click image to expand</span>
                        <a href="{{ asset('storage/media/images/screenshot-2026-10-22-084835-yzdRy8.webp') }}" target="_blank"
                           class="text-xs font-bold text-amber-300 hover:text-amber-100 flex items-center space-x-1 transition-colors">
                            <span>Open Full Record</span>
                            <span>↗</span>
                        </a>
                    </div>
                </div>

                <!-- Document 2: Examination Merit & Degree Credential -->
                <div class="card-gold-frame rounded-2xl p-4 sm:p-5 flex flex-col justify-between bg-gradient-to-b from-[#1f112c]/90 to-[#12081d]/95 backdrop-blur-md hover:border-amber-400/80 transition-all duration-300 group shadow-xl">
                    <div class="space-y-3">
                        <div class="flex items-center justify-between pb-2.5 border-b border-amber-500/20">
                            <div class="flex items-center space-x-2">
                                <span class="text-lg">🏅</span>
                                <span class="font-cinzel text-xs sm:text-sm font-bold text-amber-200">Vidya Vachaspathi Merit Credential</span>
                            </div>
                            <span class="text-[10px] font-semibold text-amber-400/90 bg-amber-400/10 px-2 py-0.5 rounded-full border border-amber-400/30">
                                Gold Medalist
                            </span>
                        </div>

                        <!-- Compact Uncropped Image Container -->
                        <div class="relative w-full rounded-xl bg-[#0b0412] p-2 border border-amber-500/20 flex items-center justify-center h-48 sm:h-56 overflow-hidden group-hover:border-amber-400/50 transition-colors">
                            <a href="{{ asset('storage/media/images/vidya-vachaspathi-examination-gm9NIB.webp') }}" target="_blank" class="block h-full w-full flex items-center justify-center group/img">
                                <img src="{{ asset('storage/media/images/vidya-vachaspathi-examination-gm9NIB.webp') }}"
                                     alt="Vidya Vachaspathi Examination Gold Medal Merit - DR. E. K. Raja Varma"
                                     onerror="this.onerror=null; this.src='{{ asset('images/convocation-record-2.webp') }}';"
                                     class="max-h-full max-w-full h-auto w-auto object-contain mx-auto rounded-lg shadow-md transition-transform duration-300 group-hover/img:scale-105">
                            </a>
                        </div>

                        <p class="text-[11px] text-amber-100/75 leading-relaxed text-center sm:text-left">
                            Shree Maharshi College of Vedic Astrology Vidya Vachaspathi examination record highlighting first-rank academic excellence.
                        </p>
                    </div>

                    <div class="pt-3 mt-3 border-t border-amber-500/20 flex items-center justify-between">
                        <span class="text-[10px] text-amber-300/75">Click image to expand</span>
                        <a href="{{ asset('storage/media/images/vidya-vachaspathi-examination-gm9NIB.webp') }}" target="_blank"
                           class="text-xs font-bold text-amber-300 hover:text-amber-100 flex items-center space-x-1 transition-colors">
                            <span>Open Full Record</span>
                            <span>↗</span>
                        </a>
                    </div>
                </div>

            </div>

            <!-- Bottom Direct Consultation Bar -->
            <div class="p-4 sm:p-6 rounded-2xl bg-gradient-to-r from-amber-500/15 via-yellow-400/10 to-amber-950/40 border border-amber-400/40 flex flex-col sm:flex-row items-center justify-between gap-4 text-center sm:text-left">
                <div class="space-y-1">
                    <h3 class="font-cinzel text-base sm:text-lg font-bold text-amber-200">
                        Consult with Vidya Vachaspathi Gold Medalist DR. E. K. Raja Varma
                    </h3>
                    <p class="text-xs text-amber-100/75">
                        Experience authentic traditional Vedic predictive astrology and personal counseling via phone or WhatsApp worldwide.
                    </p>
                </div>
                <a href="https://wa.me/917907052160?text={{ rawurlencode('Namaskaram DR. E. K. Raja Varma (Vidya Vachaspathi in Vedic Astrology), I saw your Academic Honor and Convocation Gold Medal credentials. I would like to book a consultation.') }}"
                   target="_blank"
                   class="shrink-0 px-6 py-3 rounded-xl font-bold text-xs sm:text-sm text-[#1a1128] bg-gradient-to-r from-amber-300 to-yellow-400 hover:from-amber-200 hover:to-yellow-300 shadow-lg hover:shadow-amber-400/30 transition-all flex items-center space-x-2">
                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M12.031 6.172c-3.181 0-5.767 2.586-5.768 5.766-.001 1.298.38 2.27 1.019 3.287l-.711 2.598 2.664-.698c.969.585 1.961.947 2.796.947 3.179 0 5.766-2.587 5.767-5.766.001-3.181-2.586-5.767-5.767-5.767zm0 10.373c-.768 0-1.637-.251-2.327-.661l-.167-.099-1.58.414.422-1.539-.109-.174c-.453-.722-.693-1.564-.693-2.55 0-2.539 2.066-4.605 4.606-4.605 2.54 0 4.606 2.066 4.606 4.606 0 2.54-2.066 4.608-4.755 4.608z"/>
                    </svg>
                    <span>Consult on WhatsApp (7907052160)</span>
                </a>
            </div>
        </div>
    </section>

    <!-- ========================================================================= -->
    <!-- SECTION 3: Our Core Services Section                                      -->
    <!-- ========================================================================= -->
    <section id="services" class="py-24 bg-[#120a1c] relative">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
            <!-- Section Header -->
            <div class="text-center max-w-3xl mx-auto mb-16 space-y-3">
                <span class="text-xs font-bold uppercase tracking-widest text-amber-400 bg-amber-500/10 px-3 py-1 rounded-full border border-amber-500/30">
                    Prophetic Vedic Offerings
                </span>
                <h2 class="font-cinzel text-3xl sm:text-4xl font-extrabold text-white">
                    Our Core Astrological Services
                </h2>
                <div class="w-24 h-1 bg-gradient-to-r from-transparent via-amber-400 to-transparent mx-auto"></div>
                <p class="text-xs sm:text-sm text-amber-100/70 leading-relaxed">
                    Personalized consultations crafted through deep computational Parashara astrology and compassionate psychological counselling by <strong>DR. E. K. Raja Varma (Vidya Vachaspathi in Vedic Astrology)</strong>.
                </p>
            </div>

            <!-- 5 Core Services Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                @foreach($services as $service)
                <div class="card-gold-frame rounded-3xl p-7 flex flex-col justify-between group">
                    <div class="space-y-4">
                        <div class="flex items-center justify-between">
                            <div class="w-14 h-14 rounded-2xl bg-gradient-to-tr from-amber-600 via-amber-400 to-yellow-300 p-0.5 shadow-lg group-hover:scale-110 transition-transform">
                                <div class="w-full h-full rounded-2xl bg-[#1c122c] flex items-center justify-center text-amber-300 text-2xl font-bold">
                                    @if($loop->iteration == 1) 🔮
                                    @elseif($loop->iteration == 2) 📜
                                    @elseif($loop->iteration == 3) 💍
                                    @elseif($loop->iteration == 4) 💎
                                    @else ⏳
                                    @endif
                                </div>
                            </div>
                            <span class="font-cinzel text-xs font-bold text-amber-400/50 group-hover:text-amber-300 transition-colors">
                                #0{{ $loop->iteration }}
                            </span>
                        </div>

                        <h3 class="font-cinzel text-xl font-bold text-white group-hover:text-amber-300 transition-colors">
                            {{ $service->title }}
                        </h3>

                        <p class="text-xs sm:text-sm text-amber-100/75 leading-relaxed">
                            {{ $service->description }}
                        </p>
                    </div>

                    <!-- Direct Pre-filled WhatsApp CTA -->
                    <div class="pt-6 mt-6 border-t border-amber-500/20">
                        <a href="https://wa.me/917907052160?text={{ rawurlencode($service->whatsapp_prefill ?: 'Namaskaram DR. E. K. Raja Varma (Vidya Vachaspathi in Vedic Astrology), I would like to consult regarding ' . $service->title) }}"
                           target="_blank"
                           class="w-full py-2.5 px-4 rounded-xl text-xs font-bold text-white bg-gradient-to-r from-emerald-600 to-teal-600 hover:from-emerald-500 hover:to-teal-500 shadow-md flex items-center justify-center space-x-2 transition-all">
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M12.031 6.172c-3.181 0-5.767 2.586-5.768 5.766-.001 1.298.38 2.27 1.019 3.287l-.711 2.598 2.664-.698c.969.585 1.961.947 2.796.947 3.179 0 5.766-2.587 5.767-5.766.001-3.181-2.586-5.767-5.767-5.767zm0 10.373c-.768 0-1.637-.251-2.327-.661l-.167-.099-1.58.414.422-1.539-.109-.174c-.453-.722-.693-1.564-.693-2.55 0-2.539 2.066-4.605 4.606-4.605 2.54 0 4.606 2.066 4.606 4.606 0 2.54-2.066 4.608-4.755 4.608z"/>
                            </svg>
                            <span>Consult on WhatsApp</span>
                        </a>
                    </div>
                </div>
                @endforeach

                <!-- 6th Card: Online Astro Counselling Specialization Card -->
                <div class="card-gold-frame rounded-3xl p-7 flex flex-col justify-between group bg-gradient-to-b from-[#2a133d]/70 to-[#1c0f2a]/90">
                    <div class="space-y-4">
                        <div class="flex items-center justify-between">
                            <div class="w-14 h-14 rounded-2xl bg-gradient-to-tr from-amber-600 via-amber-400 to-yellow-300 p-0.5 shadow-lg group-hover:scale-110 transition-transform">
                                <div class="w-full h-full rounded-2xl bg-[#1c122c] flex items-center justify-center text-amber-300 text-2xl font-bold">
                                    🎓
                                </div>
                            </div>
                            <span class="font-cinzel text-xs font-bold text-amber-400/50">#Ph.D.</span>
                        </div>

                        <h3 class="font-cinzel text-xl font-bold text-white group-hover:text-amber-300 transition-colors">
                            Online Astro Counselling
                        </h3>

                        <p class="text-xs sm:text-sm text-amber-100/75 leading-relaxed">
                            Specialized doctoral thesis domain of DR. E. K. Raja Varma. Holistic psychological support, career re-orientation, anxiety reduction, and confidential life path navigation via voice/video.
                        </p>
                    </div>

                    <div class="pt-6 mt-6 border-t border-amber-500/20">
                        <button @click="$dispatch('open-booking-modal', { service: 'Online Astro Counselling' })"
                                class="w-full py-2.5 px-4 rounded-xl text-xs font-bold text-[#1a1128] bg-gradient-to-r from-amber-300 to-yellow-400 hover:from-amber-200 hover:to-yellow-300 shadow-md flex items-center justify-center space-x-2 transition-all">
                            <span>Book Counselling Slot</span>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- ========================================================================= -->
    <!-- SECTION 4: "Why Covilakam Astrology" Section                             -->
    <!-- ========================================================================= -->
    <section id="why-covilakam" class="py-24 bg-[#0d0716] relative border-t border-amber-500/20 overflow-hidden">
        <!-- Background subtle glow -->
        <div class="absolute -left-40 top-1/2 -translate-y-1/2 w-96 h-96 bg-amber-600/10 rounded-full blur-[120px] pointer-events-none"></div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-12 items-center">
                
                <!-- Left: Authority Highlights -->
                <div class="lg:col-span-5 space-y-6">
                    <span class="text-xs font-bold uppercase tracking-widest text-amber-400 bg-amber-500/10 px-3 py-1 rounded-full border border-amber-500/30">
                        Pillars of Excellence
                    </span>
                    <h2 class="font-cinzel text-3xl sm:text-4xl font-extrabold text-white leading-tight">
                        Why Choose <br><span class="gold-gradient-text">Covilakam Astrology?</span>
                    </h2>
                    <p class="text-xs sm:text-sm text-amber-100/80 leading-relaxed">
                        At Covilakam Astrology, you are guided personally by <strong>DR. E. K. Raja Varma (Vidya Vachaspathi in Vedic Astrology)</strong>. Unlike automated computer horoscopes, each chart is calculated and contemplated manually with pure devotion and academic exactitude.
                    </p>

                    <!-- Core Credential Badges -->
                    <div class="space-y-3 pt-2">
                        <div class="flex items-start space-x-3 p-3 rounded-2xl bg-[#1b102c]/80 border border-amber-500/30">
                            <span class="text-amber-400 text-lg">🥇</span>
                            <div>
                                <h4 class="font-bold text-xs sm:text-sm text-white">Vidya Vachaspathi Gold Medalist</h4>
                                <p class="text-[11px] text-amber-200/70">Shree Maharshi College of Vedic Astrology, Udaipur, Rajasthan (27th Sept 2026).</p>
                            </div>
                        </div>

                        <div class="flex items-start space-x-3 p-3 rounded-2xl bg-[#1b102c]/80 border border-amber-500/30">
                            <span class="text-amber-400 text-lg">🎓</span>
                            <div>
                                <h4 class="font-bold text-xs sm:text-sm text-white">Ph.D. in Vedic Astrology (Online Astro Counselling)</h4>
                                <p class="text-[11px] text-amber-200/70">Conferred by Indian Astrology and Maharshi Academics (IAMA) Open University, Florida.</p>
                            </div>
                        </div>

                        <div class="flex items-start space-x-3 p-3 rounded-2xl bg-[#1b102c]/80 border border-amber-500/30">
                            <span class="text-amber-400 text-lg">🌐</span>
                            <div>
                                <h4 class="font-bold text-xs sm:text-sm text-white">IAF Life Member (ID: 11009) & Practitioner Since 2022</h4>
                                <p class="text-[11px] text-amber-200/70">International Astrology Federation fellowship adhering to highest ethical privacy standards.</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Right: Detailed Qualifications Matrix -->
                <div class="lg:col-span-7">
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        @foreach($qualifications as $qual)
                        <div class="p-5 rounded-2xl bg-[#160d24] border border-amber-500/30 hover:border-amber-400/80 transition-all hover:-translate-y-1 shadow-lg">
                            <div class="flex items-center justify-between mb-2">
                                <span class="px-2 py-0.5 rounded text-[10px] font-bold uppercase bg-amber-500/20 text-amber-300 border border-amber-500/30">
                                    {{ $qual->badge_text ?? 'Credential' }}
                                </span>
                                <span class="text-[11px] text-amber-400 font-mono">{{ $qual->year }}</span>
                            </div>
                            <h3 class="font-cinzel text-sm sm:text-base font-bold text-white mb-1">
                                {{ $qual->title }}
                            </h3>
                            <p class="text-xs text-amber-300/80 font-medium mb-2">
                                {{ $qual->institution }}
                            </p>
                            <p class="text-xs text-amber-100/70 leading-relaxed">
                                {{ $qual->highlights }}
                            </p>
                        </div>
                        @endforeach
                    </div>
                </div>

            </div>
        </div>
    </section>

    <!-- ========================================================================= -->
    <!-- SECTION 5: Unified YouTube Video Gallery (STRICT PLACEMENT RULE)          -->
    <!-- MUST appear IMMEDIATELY after "Why Covilakam Astrology"                  -->
    <!-- Video 1: "ഓൺലൈൻ അസ്ട്രോളജി"                                             -->
    <!-- Video 2: "ഇവ ചെയ്തില്ലെങ്കിൽ സ്ത്രീകൾക്ക് ദോഷം ആണോ ?"                  -->
    <!-- ========================================================================= -->
    <!-- ========================================================================= -->
    <!-- SECTION 5: Unified YouTube Video Gallery (STRICT PLACEMENT RULE)          -->
    <!-- MUST appear IMMEDIATELY after "Why Covilakam Astrology"                  -->
    <!-- Video 1: "ഓൺലൈൻ അസ്ട്രോളജി : ഗുണങ്ങളും ദോഷങ്ങളും" (Featured Hero)        -->
    <!-- Video 2: "ഇവ ചെയ്തില്ലെങ്കിൽ സ്ത്രീകൾക്ക് ദോഷം ആണോ ?"                  -->
    <!-- Videos 3-7: Authentic Malayalam Vedic Astrology Discourses               -->
    <!-- ========================================================================= -->
    <section id="videos" class="py-24 bg-[#12091c] relative border-t border-amber-500/20 overflow-hidden"
             x-data="{
                 activeVideoModal: false,
                 currentVideo: {
                     id: '',
                     title: '',
                     youtube_id: '',
                     description: '',
                     duration: '',
                     sort_order: 1
                 },
                 openVideo(video) {
                     this.currentVideo = video;
                     this.activeVideoModal = true;
                     document.body.style.overflow = 'hidden';
                 },
                 closeVideo() {
                     this.activeVideoModal = false;
                     document.body.style.overflow = 'auto';
                     setTimeout(() => {
                         this.currentVideo = { id: '', title: '', youtube_id: '', description: '', duration: '', sort_order: 1 };
                     }, 200);
                 }
             }"
             @keydown.escape.window="closeVideo()">

        <!-- Ambient Cosmic Background Glows -->
        <div class="absolute -top-32 right-0 w-[500px] h-[500px] bg-amber-500/10 rounded-full blur-[140px] pointer-events-none"></div>
        <div class="absolute -bottom-32 left-0 w-[500px] h-[500px] bg-purple-700/10 rounded-full blur-[140px] pointer-events-none"></div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
            <!-- Section Header -->
            <div class="text-center max-w-3xl mx-auto mb-16 space-y-3">
                <div class="inline-flex items-center space-x-2 text-xs font-bold uppercase tracking-widest text-amber-300 bg-amber-500/10 px-4 py-1.5 rounded-full border border-amber-500/30 shadow-lg shadow-amber-500/5">
                    <span class="w-2 h-2 rounded-full bg-red-500 animate-pulse"></span>
                    <span>Official YouTube Discourses</span>
                    <span>•</span>
                    <span>DR. E. K. Raja Varma</span>
                </div>
                <h2 class="font-cinzel text-3xl sm:text-4xl lg:text-5xl font-black text-white leading-tight">
                    Vedic Astrology <span class="gold-gradient-text">Video Gallery</span>
                </h2>
                <div class="w-28 h-1 bg-gradient-to-r from-transparent via-amber-400 to-transparent mx-auto"></div>
                <p class="text-xs sm:text-sm text-amber-100/80 leading-relaxed font-sans">
                    Watch illuminating Malayalam video discourses by <strong>DR. E. K. Raja Varma (Vidya Vachaspathi in Vedic Astrology)</strong> covering online astro-counselling, remedies, Kaalapurusha Vaastu, marriage compatibility, and Raja Yogas.
                </p>
            </div>

            @php
                $featuredVideo = $videos->firstWhere('sort_order', 1) ?? $videos->first();
                $gridVideos = $videos->filter(function($v) use ($featuredVideo) {
                    return $v->id !== ($featuredVideo->id ?? null);
                });
            @endphp

            @if($featuredVideo)
            <!-- FEATURED HERO VIDEO CARD (Video 1 - STRICTLY FIRST) -->
            <div class="mb-14">
                <div class="relative rounded-3xl p-1 bg-gradient-to-r from-amber-500/40 via-yellow-400/50 to-amber-600/30 shadow-2xl shadow-amber-950/40">
                    <div class="rounded-[22px] bg-[#160d26] overflow-hidden border border-amber-500/40">
                        <div class="grid grid-cols-1 lg:grid-cols-12 gap-0 items-center">
                            
                            <!-- Thumbnail with Glowing Play Overlay (Left / Top) -->
                            <div class="lg:col-span-7 relative group cursor-pointer overflow-hidden bg-black aspect-video"
                                 @click="openVideo({
                                     id: '{{ $featuredVideo->id }}',
                                     title: '{{ addslashes($featuredVideo->title) }}',
                                     youtube_id: '{{ $featuredVideo->youtube_id }}',
                                     description: '{{ addslashes($featuredVideo->description) }}',
                                     duration: '{{ $featuredVideo->duration ?? 'Discourse' }}',
                                     sort_order: {{ $featuredVideo->sort_order }}
                                 })">
                                <img src="https://img.youtube.com/vi/{{ $featuredVideo->youtube_id }}/hqdefault.jpg"
                                     alt="{{ $featuredVideo->title }}"
                                     class="w-full h-full object-cover transform group-hover:scale-105 transition-transform duration-500 opacity-90 group-hover:opacity-100">
                                <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/30 to-transparent"></div>
                                
                                <!-- Glowing Play Button -->
                                <div class="absolute inset-0 flex items-center justify-center">
                                    <div class="w-20 h-20 rounded-full bg-gradient-to-tr from-amber-500 to-yellow-400 p-1 shadow-2xl group-hover:scale-110 transition-transform duration-300 shadow-amber-500/50">
                                        <div class="w-full h-full rounded-full bg-[#1a1128] flex items-center justify-center text-amber-300 pl-1">
                                            <svg class="w-8 h-8 fill-current drop-shadow" viewBox="0 0 24 24">
                                                <path d="M8 5v14l11-7z"/>
                                            </svg>
                                        </div>
                                    </div>
                                </div>

                                <!-- Duration Badge -->
                                @if($featuredVideo->duration)
                                <div class="absolute bottom-4 right-4 px-2.5 py-1 rounded-md bg-black/80 backdrop-blur-sm border border-white/20 text-white font-mono text-[11px] font-bold">
                                    {{ $featuredVideo->duration }}
                                </div>
                                @endif

                                <!-- Click to Play Hint -->
                                <div class="absolute bottom-4 left-4 flex items-center space-x-2 text-xs font-semibold text-amber-300 bg-[#160d26]/80 px-3 py-1 rounded-full border border-amber-500/40">
                                    <span>▶ Click to Watch Discourse</span>
                                </div>
                            </div>

                            <!-- Content Info (Right / Bottom) -->
                            <div class="lg:col-span-5 p-8 sm:p-10 space-y-5">
                                <div class="flex items-center space-x-2">
                                    <span class="px-3.5 py-1 rounded-full text-xs font-black uppercase tracking-wider bg-gradient-to-r from-amber-400 to-yellow-500 text-[#1a1128] shadow-md shadow-amber-500/30">
                                        ★ Featured Insight • Online Astro Counselling
                                    </span>
                                </div>

                                <h3 class="font-['Noto_Sans_Malayalam',sans-serif] text-xl sm:text-2xl font-bold text-white leading-relaxed">
                                    {{ $featuredVideo->title }}
                                </h3>

                                <p class="font-['Noto_Sans_Malayalam',sans-serif] text-xs sm:text-sm text-amber-100/80 leading-loose">
                                    {{ $featuredVideo->description }}
                                </p>

                                <div class="pt-3 flex flex-wrap gap-3">
                                    <button type="button"
                                            @click="openVideo({
                                                id: '{{ $featuredVideo->id }}',
                                                title: '{{ addslashes($featuredVideo->title) }}',
                                                youtube_id: '{{ $featuredVideo->youtube_id }}',
                                                description: '{{ addslashes($featuredVideo->description) }}',
                                                duration: '{{ $featuredVideo->duration ?? 'Discourse' }}',
                                                sort_order: {{ $featuredVideo->sort_order }}
                                            })"
                                            class="px-5 py-3 rounded-xl font-bold text-xs text-[#1a1128] bg-gradient-to-r from-amber-300 via-yellow-400 to-amber-500 hover:from-amber-200 hover:to-yellow-300 shadow-xl hover:shadow-amber-500/30 transition-all flex items-center space-x-2">
                                        <svg class="w-4 h-4 fill-current" viewBox="0 0 24 24"><path d="M8 5v14l11-7z"/></svg>
                                        <span>Play Video in Modal</span>
                                    </button>

                                    <a href="https://wa.me/917907052160?text={{ rawurlencode('Namaskaram DR. E. K. Raja Varma (Vidya Vachaspathi in Vedic Astrology), I watched your YouTube video: "' . $featuredVideo->title . '" and would like to ask a question.') }}"
                                       target="_blank"
                                       class="px-4 py-3 rounded-xl text-xs font-semibold text-amber-200 bg-[#201335] border border-amber-500/40 hover:border-amber-300 hover:text-white transition-all flex items-center space-x-2">
                                        <span class="text-emerald-400">💬</span>
                                        <span>Consult DR. E. K. Raja Varma</span>
                                    </a>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
            @endif

            <!-- UNIFIED GRID FOR ALL VIDEOS -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                @foreach($gridVideos as $video)
                <div class="rounded-3xl p-0.5 bg-gradient-to-b from-amber-500/30 via-amber-500/10 to-purple-900/20 hover:from-amber-400/60 hover:to-amber-600/30 transition-all duration-300 group shadow-xl">
                    <div class="rounded-[22px] bg-[#160d26] h-full flex flex-col justify-between overflow-hidden border border-amber-500/20 group-hover:border-amber-400/50 transition-colors">
                        
                        <div>
                            <!-- Thumbnail with Play Overlay -->
                            <div class="relative aspect-video bg-black cursor-pointer overflow-hidden"
                                 @click="openVideo({
                                     id: '{{ $video->id }}',
                                     title: '{{ addslashes($video->title) }}',
                                     youtube_id: '{{ $video->youtube_id }}',
                                     description: '{{ addslashes($video->description) }}',
                                     duration: '{{ $video->duration ?? 'Discourse' }}',
                                     sort_order: {{ $video->sort_order }}
                                 })">
                                <img src="https://img.youtube.com/vi/{{ $video->youtube_id }}/hqdefault.jpg"
                                     alt="{{ $video->title }}"
                                     loading="lazy"
                                     class="w-full h-full object-cover transform group-hover:scale-108 transition-transform duration-500 opacity-90 group-hover:opacity-100">
                                
                                <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/20 to-transparent"></div>

                                <!-- Play Button Overlay -->
                                <div class="absolute inset-0 flex items-center justify-center">
                                    <div class="w-14 h-14 rounded-full bg-gradient-to-tr from-amber-500 to-yellow-400 p-0.5 shadow-xl group-hover:scale-115 transition-transform duration-300">
                                        <div class="w-full h-full rounded-full bg-[#1a1128]/90 flex items-center justify-center text-amber-300 pl-0.5">
                                            <svg class="w-6 h-6 fill-current" viewBox="0 0 24 24"><path d="M8 5v14l11-7z"/></svg>
                                        </div>
                                    </div>
                                </div>

                                <!-- Order Badge & Duration -->
                                <div class="absolute top-3 left-3">
                                    <span class="px-2.5 py-0.5 rounded-full text-[10px] font-bold uppercase tracking-wider {{ $video->sort_order == 2 ? 'bg-amber-400 text-black font-extrabold' : 'bg-[#160d26]/90 border border-amber-500/40 text-amber-300' }}">
                                        {{ $video->sort_order == 2 ? 'Key Insight #2' : 'Video #' . $video->sort_order }}
                                    </span>
                                </div>

                                @if($video->duration)
                                <div class="absolute bottom-3 right-3 px-2 py-0.5 rounded bg-black/80 text-[10px] font-mono text-white/90 border border-white/20">
                                    {{ $video->duration }}
                                </div>
                                @endif
                            </div>

                            <!-- Card Body -->
                            <div class="p-6 space-y-3">
                                <h3 class="font-['Noto_Sans_Malayalam',sans-serif] text-base font-bold text-white group-hover:text-amber-300 transition-colors leading-snug line-clamp-2">
                                    {{ $video->title }}
                                </h3>

                                <p class="font-['Noto_Sans_Malayalam',sans-serif] text-xs text-amber-100/70 line-clamp-3 leading-relaxed">
                                    {{ $video->description }}
                                </p>
                            </div>
                        </div>

                        <!-- Card Footer -->
                        <div class="px-6 pb-6 pt-2 space-y-2.5 border-t border-amber-500/10">
                            <div class="flex items-center justify-between text-[11px]">
                                <button type="button"
                                        @click="openVideo({
                                            id: '{{ $video->id }}',
                                            title: '{{ addslashes($video->title) }}',
                                            youtube_id: '{{ $video->youtube_id }}',
                                            description: '{{ addslashes($video->description) }}',
                                            duration: '{{ $video->duration ?? 'Discourse' }}',
                                            sort_order: {{ $video->sort_order }}
                                        })"
                                        class="text-amber-400 hover:text-amber-200 font-semibold flex items-center space-x-1 transition-colors">
                                    <svg class="w-3.5 h-3.5 fill-current" viewBox="0 0 24 24"><path d="M8 5v14l11-7z"/></svg>
                                    <span>Play Video</span>
                                </button>

                                <a href="https://youtu.be/{{ $video->youtube_id }}"
                                   target="_blank"
                                   class="text-red-400 hover:text-red-300 flex items-center space-x-1 transition-colors">
                                    <svg class="w-3.5 h-3.5 fill-current" viewBox="0 0 24 24"><path d="M19.615 3.184c-3.604-.246-11.631-.245-15.23 0-3.897.266-4.356 2.62-4.385 8.816.029 6.185.484 8.549 4.385 8.816 3.6.245 11.626.246 15.23 0 3.897-.266 4.356-2.62 4.385-8.816-.029-6.185-.484-8.549-4.385-8.816zm-10.615 12.816v-8l8 3.993-8 4.007z"/></svg>
                                    <span>YouTube</span>
                                </a>
                            </div>

                            <a href="https://wa.me/917907052160?text={{ rawurlencode('Namaskaram DR. E. K. Raja Varma (Vidya Vachaspathi in Vedic Astrology), I watched your YouTube video: "' . $video->title . '" and would like to ask a question.') }}"
                               target="_blank"
                               class="w-full py-2 px-3 rounded-xl text-[11px] font-semibold text-amber-200/90 bg-[#211335] border border-amber-500/30 hover:border-amber-400 hover:text-white flex items-center justify-center space-x-1.5 transition-all">
                                <span class="text-emerald-400">💬</span>
                                <span>Ask DR. E. K. Raja Varma</span>
                            </a>
                        </div>

                    </div>
                </div>
                @endforeach
            </div>

            <!-- YouTube Channel Link Button -->
            <div class="mt-16 text-center">
                <a href="https://www.youtube.com/@CovilakamAstrology"
                   target="_blank"
                   class="inline-flex items-center space-x-3 px-8 py-4 rounded-2xl bg-[#160d26] border-2 border-red-500/50 hover:border-red-400 text-white font-bold text-xs uppercase tracking-wider shadow-xl hover:shadow-red-500/20 transition-all">
                    <span class="w-7 h-7 rounded-full bg-red-600 flex items-center justify-center text-white">
                        <svg class="w-4 h-4 fill-current" viewBox="0 0 24 24"><path d="M19.615 3.184c-3.604-.246-11.631-.245-15.23 0-3.897.266-4.356 2.62-4.385 8.816.029 6.185.484 8.549 4.385 8.816 3.6.245 11.626.246 15.23 0 3.897-.266 4.356-2.62 4.385-8.816-.029-6.185-.484-8.549-4.385-8.816zm-10.615 12.816v-8l8 3.993-8 4.007z"/></svg>
                    </span>
                    <span>Subscribe to DR. E. K. Raja Varma Official YouTube Channel</span>
                    <span class="text-amber-400">→</span>
                </a>
            </div>
        </div>

        <!-- ========================================================================= -->
        <!-- INTERACTIVE ALPINE.JS LIGHTBOX VIDEO PLAYER MODAL                         -->
        <!-- Plays video embedded directly on the website with autoplay                -->
        <!-- ========================================================================= -->
        <div x-show="activeVideoModal"
             x-cloak
             class="fixed inset-0 z-50 overflow-y-auto"
             role="dialog" aria-modal="true">
            
            <!-- Backdrop -->
            <div x-show="activeVideoModal"
                 x-transition:enter="ease-out duration-300"
                 x-transition:enter-start="opacity-0"
                 x-transition:enter-end="opacity-100"
                 x-transition:leave="ease-in duration-200"
                 x-transition:leave-start="opacity-100"
                 x-transition:leave-end="opacity-0"
                 @click="closeVideo()"
                 class="fixed inset-0 bg-black/85 backdrop-blur-md transition-opacity"></div>

            <div class="flex min-h-full items-center justify-center p-3 sm:p-6 text-center">
                <div x-show="activeVideoModal"
                     x-transition:enter="ease-out duration-300"
                     x-transition:enter-start="opacity-0 translate-y-4 sm:scale-95"
                     x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
                     x-transition:leave="ease-in duration-200"
                     x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
                     x-transition:leave-end="opacity-0 translate-y-4 sm:scale-95"
                     @click.stop
                     class="relative transform overflow-hidden rounded-3xl bg-[#160d26] border-2 border-amber-500/50 text-left shadow-2xl transition-all w-full max-w-4xl p-4 sm:p-6 my-8">
                    
                    <!-- Modal Header Bar -->
                    <div class="flex items-center justify-between pb-3 mb-3 border-b border-amber-500/20">
                        <div class="flex items-center space-x-2">
                            <span class="w-3 h-3 rounded-full bg-red-500 animate-pulse"></span>
                            <span class="font-cinzel text-xs font-bold uppercase tracking-wider text-amber-300">
                                Covilakam Astrology Video Player
                            </span>
                        </div>

                        <!-- Close Button -->
                        <button type="button"
                                @click="closeVideo()"
                                class="w-8 h-8 rounded-full bg-[#201335] border border-amber-500/30 text-amber-300 hover:text-white hover:bg-amber-500/20 flex items-center justify-center text-sm font-bold transition-colors">
                            ✕
                        </button>
                    </div>

                    <!-- 16:9 Video Embed Player -->
                    <div class="relative pb-[56.25%] h-0 bg-black rounded-2xl overflow-hidden border border-amber-500/30 shadow-2xl">
                        <template x-if="activeVideoModal && currentVideo.youtube_id">
                            <iframe class="absolute top-0 left-0 w-full h-full"
                                    :src="'https://www.youtube-nocookie.com/embed/' + currentVideo.youtube_id + '?autoplay=1&rel=0'"
                                    :title="currentVideo.title"
                                    allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                                    allowfullscreen>
                            </iframe>
                        </template>
                    </div>

                    <!-- Video Details & Actions -->
                    <div class="mt-4 space-y-3">
                        <h3 class="font-['Noto_Sans_Malayalam',sans-serif] text-lg sm:text-xl font-bold text-white leading-snug"
                            x-text="currentVideo.title">
                        </h3>

                        <p class="font-['Noto_Sans_Malayalam',sans-serif] text-xs sm:text-sm text-amber-100/80 leading-relaxed max-h-36 overflow-y-auto pr-2"
                           x-text="currentVideo.description">
                        </p>

                        <!-- Action Buttons -->
                        <div class="pt-3 border-t border-amber-500/20 flex flex-col sm:flex-row items-center justify-between gap-3">
                            <a :href="'https://www.youtube.com/watch?v=' + currentVideo.youtube_id"
                               target="_blank"
                               class="text-xs text-red-400 hover:text-red-300 flex items-center space-x-1.5 font-semibold">
                                <svg class="w-4 h-4 fill-current" viewBox="0 0 24 24"><path d="M19.615 3.184c-3.604-.246-11.631-.245-15.23 0-3.897.266-4.356 2.62-4.385 8.816.029 6.185.484 8.549 4.385 8.816 3.6.245 11.626.246 15.23 0 3.897-.266 4.356-2.62 4.385-8.816-.029-6.185-.484-8.549-4.385-8.816zm-10.615 12.816v-8l8 3.993-8 4.007z"/></svg>
                                <span>Watch Directly on YouTube Channel</span>
                            </a>

                            <div class="flex items-center space-x-2 w-full sm:w-auto">
                                <a :href="'https://wa.me/917907052160?text=' + encodeURIComponent('Namaskaram DR. E. K. Raja Varma (Vidya Vachaspathi in Vedic Astrology), I watched your YouTube video: &quot;' + currentVideo.title + '&quot; and would like to ask a question.')"
                                   target="_blank"
                                   class="w-full sm:w-auto px-5 py-2.5 rounded-xl font-bold text-xs text-[#1a1128] bg-gradient-to-r from-emerald-400 to-green-500 hover:from-emerald-300 hover:to-green-400 shadow-lg flex items-center justify-center space-x-2 transition-all">
                                    <span>💬 Consult DR. E. K. Raja Varma on WhatsApp</span>
                                </a>

                                <button type="button"
                                        @click="closeVideo()"
                                        class="px-4 py-2.5 rounded-xl text-xs font-semibold text-amber-200 bg-[#201335] border border-amber-500/30 hover:border-amber-400 transition-colors">
                                    Close
                                </button>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </section>

    <!-- ========================================================================= -->
    <!-- SECTION 6: Multi-Language Astrology Text Section (4-Language Alpine.js)  -->
    <!-- Malayalam, English, Hindi, Tamil                                         -->
    <!-- ========================================================================= -->
    <section id="philosophy" class="py-24 bg-[#0e0717] relative border-t border-amber-500/20"
             x-data="{ activeLang: 'ml' }">
        <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Section Header -->
            <div class="text-center max-w-3xl mx-auto mb-12 space-y-3">
                <span class="text-xs font-bold uppercase tracking-widest text-amber-400 bg-amber-500/10 px-3 py-1 rounded-full border border-amber-500/30">
                    Sacred Vedic Philosophy
                </span>
                <h2 class="font-cinzel text-3xl sm:text-4xl font-extrabold text-white">
                    Explore. Discover. Transform.
                </h2>
                <p class="text-xs sm:text-sm text-amber-100/70">
                    Read the cosmic message of Covilakam Astrology in your preferred language:
                </p>

                <!-- 4-Language Alpine.js Tab Switcher -->
                <div class="inline-flex p-1.5 rounded-2xl bg-[#1c122c] border border-amber-500/30 shadow-xl mt-4">
                    <button @click="activeLang = 'ml'"
                            :class="activeLang === 'ml' ? 'bg-gradient-to-r from-amber-400 to-yellow-500 text-black font-bold shadow-md' : 'text-amber-200/80 hover:text-white'"
                            class="px-4 py-2 rounded-xl text-xs sm:text-sm transition-all font-malayalam">
                        മലയാളം
                    </button>
                    <button @click="activeLang = 'en'"
                            :class="activeLang === 'en' ? 'bg-gradient-to-r from-amber-400 to-yellow-500 text-black font-bold shadow-md' : 'text-amber-200/80 hover:text-white'"
                            class="px-4 py-2 rounded-xl text-xs sm:text-sm transition-all font-medium">
                        English
                    </button>
                    <button @click="activeLang = 'hi'"
                            :class="activeLang === 'hi' ? 'bg-gradient-to-r from-amber-400 to-yellow-500 text-black font-bold shadow-md' : 'text-amber-200/80 hover:text-white'"
                            class="px-4 py-2 rounded-xl text-xs sm:text-sm transition-all font-medium">
                        हिन्दी
                    </button>
                    <button @click="activeLang = 'ta'"
                            :class="activeLang === 'ta' ? 'bg-gradient-to-r from-amber-400 to-yellow-500 text-black font-bold shadow-md' : 'text-amber-200/80 hover:text-white'"
                            class="px-4 py-2 rounded-xl text-xs sm:text-sm transition-all font-medium">
                        தமிழ்
                    </button>
                </div>
            </div>

            <!-- Content Card -->
            <div class="card-gold-frame rounded-3xl p-8 sm:p-12 shadow-2xl relative overflow-hidden">
                <div class="absolute -right-10 -bottom-10 opacity-5 text-amber-300 font-serif text-[180px] pointer-events-none select-none">
                    ॐ
                </div>

                <!-- Malayalam Content -->
                <div x-show="activeLang === 'ml'"
                     x-transition:enter="transition ease-out duration-300"
                     x-transition:enter-start="opacity-0 translate-y-2"
                     x-transition:enter-end="opacity-100 translate-y-0"
                     class="space-y-6 font-malayalam">
                    <div>
                        <h3 class="text-2xl sm:text-3xl font-bold text-amber-300 mb-2">
                            {{ $translations['ml']->heading ?? 'ജ്യോതിഷം: പ്രപഞ്ച സത്യവും ജീവിത മാർഗ്ഗദർശനവും' }}
                        </h3>
                        <p class="text-xs sm:text-sm text-amber-200/70 italic">
                            {{ $translations['ml']->subheading ?? 'Explore. Discover. Transform. - കോവിലകം അസ്ട്രോളജി' }}
                        </p>
                    </div>
                    <div class="text-sm sm:text-base text-amber-50/90 leading-relaxed space-y-4">
                        {!! $translations['ml']->content ?? '' !!}
                    </div>
                </div>

                <!-- English Content -->
                <div x-show="activeLang === 'en'"
                     x-cloak
                     x-transition:enter="transition ease-out duration-300"
                     x-transition:enter-start="opacity-0 translate-y-2"
                     x-transition:enter-end="opacity-100 translate-y-0"
                     class="space-y-6">
                    <div>
                        <h3 class="font-cinzel text-2xl sm:text-3xl font-bold text-amber-300 mb-2">
                            {{ $translations['en']->heading ?? 'Vedic Astrology: The Eternal Cosmic Beacon of Self-Discovery' }}
                        </h3>
                        <p class="text-xs sm:text-sm text-amber-200/70 italic font-playfair">
                            {{ $translations['en']->subheading ?? 'Explore. Discover. Transform. - Covilakam Astrology' }}
                        </p>
                    </div>
                    <div class="text-sm sm:text-base text-amber-50/90 leading-relaxed space-y-4 font-sans">
                        {!! $translations['en']->content ?? '' !!}
                    </div>
                </div>

                <!-- Hindi Content -->
                <div x-show="activeLang === 'hi'"
                     x-cloak
                     x-transition:enter="transition ease-out duration-300"
                     x-transition:enter-start="opacity-0 translate-y-2"
                     x-transition:enter-end="opacity-100 translate-y-0"
                     class="space-y-6">
                    <div>
                        <h3 class="text-2xl sm:text-3xl font-bold text-amber-300 mb-2">
                            {{ $translations['hi']->heading ?? 'वैदिक ज्योतिष: जीवन और भाग्य का दिव्य मार्गदर्शन' }}
                        </h3>
                        <p class="text-xs sm:text-sm text-amber-200/70 italic">
                            {{ $translations['hi']->subheading ?? 'Explore. Discover. Transform. - कोविलकम एस्ट्रोलॉजी' }}
                        </p>
                    </div>
                    <div class="text-sm sm:text-base text-amber-50/90 leading-relaxed space-y-4">
                        {!! $translations['hi']->content ?? '' !!}
                    </div>
                </div>

                <!-- Tamil Content -->
                <div x-show="activeLang === 'ta'"
                     x-cloak
                     x-transition:enter="transition ease-out duration-300"
                     x-transition:enter-start="opacity-0 translate-y-2"
                     x-transition:enter-end="opacity-100 translate-y-0"
                     class="space-y-6">
                    <div>
                        <h3 class="text-2xl sm:text-3xl font-bold text-amber-300 mb-2">
                            {{ $translations['ta']->heading ?? 'வேத ஜோதிடம்: பிரபஞ்ச ஒளியும் வாழ்வின் நல்வழியும்' }}
                        </h3>
                        <p class="text-xs sm:text-sm text-amber-200/70 italic">
                            {{ $translations['ta']->subheading ?? 'Explore. Discover. Transform. - கோவில்அகம் அஸ்ட்ராலஜி' }}
                        </p>
                    </div>
                    <div class="text-sm sm:text-base text-amber-50/90 leading-relaxed space-y-4">
                        {!! $translations['ta']->content ?? '' !!}
                    </div>
                </div>

                <!-- Bottom CTA -->
                <div class="mt-8 pt-6 border-t border-amber-500/20 flex flex-col sm:flex-row items-center justify-between gap-4">
                    <p class="text-xs text-amber-200/70 italic">
                        Guidance provided by DR. E. K. Raja Varma (Vidya Vachaspathi in Vedic Astrology)
                    </p>
                    <a href="https://wa.me/917907052160?text={{ rawurlencode('Namaskaram DR. E. K. Raja Varma (Vidya Vachaspathi in Vedic Astrology), I read the Covilakam Astrology Vedic Philosophy and would like to consult with you.') }}"
                       target="_blank"
                       class="px-5 py-2.5 rounded-xl text-xs font-bold text-[#1a1128] bg-gradient-to-r from-amber-300 to-yellow-400 hover:from-amber-200 hover:to-yellow-300 shadow-md transition-all">
                        Discuss Your Life Path on WhatsApp
                    </a>
                </div>
            </div>
        </div>
    </section>

    <!-- ========================================================================= -->
    <!-- SECTION 7: Attractive Astrology Blogs Section                            -->
    <!-- First Post: "ജ്യോതിഷവും ജീവിതസരണിയും" (Astrology and the Path of Life)     -->
    <!-- Author: DR. E. K. Raja Varma (Vidya Vachaspathi in Vedic Astrology)       -->
    <!-- ========================================================================= -->
    <section id="blogs" class="py-24 bg-[#120a1c] relative border-t border-amber-500/20">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Header -->
            <div class="flex flex-col md:flex-row md:items-end justify-between mb-16 gap-6">
                <div class="space-y-3">
                    <span class="text-xs font-bold uppercase tracking-widest text-amber-400 bg-amber-500/10 px-3 py-1 rounded-full border border-amber-500/30">
                        Vedic Wisdom Repository
                    </span>
                    <h2 class="font-cinzel text-3xl sm:text-4xl font-extrabold text-white">
                        Astrology Insights & Articles
                    </h2>
                    <p class="text-xs sm:text-sm text-amber-100/70 max-w-xl">
                        Authored by <strong>DR. E. K. Raja Varma (Vidya Vachaspathi in Vedic Astrology)</strong> to demystify celestial influences on human life.
                    </p>
                </div>
                <div>
                    <a href="{{ route('blog.index') }}"
                       class="inline-flex items-center space-x-2 text-xs sm:text-sm font-bold text-amber-300 hover:text-amber-200 border-b border-amber-400 pb-1 hover:border-amber-200 transition-colors">
                        <span>View All Articles</span>
                        <span>→</span>
                    </a>
                </div>
            </div>

            <!-- Blog Cards Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                @foreach($posts as $post)
                <article class="card-gold-frame rounded-3xl overflow-hidden flex flex-col justify-between group">
                    <div>
                        <!-- Featured Image with Fallback -->
                        <a href="{{ route('blog.show', $post->slug) }}" class="block relative aspect-video overflow-hidden border-b border-amber-500/30">
                            <img src="{{ asset($post->featured_image) }}"
                                 alt="{{ $post->title }}"
                                 onerror="this.onerror=null; this.src='data:image/svg+xml;utf8,<svg xmlns=\'http://www.w3.org/2000/svg\' width=\'400\' height=\'250\' viewBox=\'0 0 400 250\'><rect width=\'100%\' height=\'100%\' fill=\'%231a1128\'/><circle cx=\'200\' cy=\'125\' r=\'60\' fill=\'%23d4af37\' opacity=\'0.2\'/><text x=\'50%\' y=\'55%\' font-size=\'40\' fill=\'%23f3e5ab\' font-family=\'serif\' dominant-baseline=\'middle\' text-anchor=\'middle\'>ॐ</text></svg>';"
                                 class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                            <span class="absolute top-3 left-3 px-2.5 py-1 rounded-full text-[10px] font-bold bg-[#1a1128]/90 text-amber-300 border border-amber-500/40 backdrop-blur-md">
                                {{ $post->category }}
                            </span>
                        </a>

                        <!-- Card Body -->
                        <div class="p-6 space-y-3">
                            <div class="flex items-center justify-between text-[11px] text-amber-300/70">
                                <span>{{ $post->reading_time }}</span>
                                <span>{{ $post->published_at ? $post->published_at->format('d M Y') : 'Recent' }}</span>
                            </div>

                            <h3 class="font-cinzel text-lg font-bold text-white group-hover:text-amber-300 transition-colors leading-snug">
                                <a href="{{ route('blog.show', $post->slug) }}">
                                    {{ $post->title }}
                                </a>
                            </h3>

                            <p class="text-xs text-amber-100/75 line-clamp-3 leading-relaxed">
                                {{ $post->excerpt }}
                            </p>
                        </div>
                    </div>

                    <!-- Author Attribution & Action -->
                    <div class="px-6 pb-6 pt-3 border-t border-amber-500/20">
                        <div class="flex items-center justify-between">
                            <div class="text-[11px] text-amber-200/80">
                                <span class="block text-amber-400 font-semibold truncate max-w-[200px]">
                                    {{ $post->author_name }}
                                </span>
                            </div>
                            <a href="{{ route('blog.show', $post->slug) }}"
                               class="text-xs font-bold text-amber-300 hover:text-white transition-colors">
                                Read →
                            </a>
                        </div>
                    </div>
                </article>
                @endforeach
            </div>
        </div>
    </section>

    <!-- ========================================================================= -->
    <!-- SECTION 8: Digital & Printable Visiting Card Section + Contact / GPay Info -->
    <!-- ========================================================================= -->
    <section id="visiting-card-section" class="py-24 bg-gradient-to-b from-[#0d0716] via-[#1a0f28] to-[#0a0512] relative border-t border-amber-500/30">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Header -->
            <div class="text-center max-w-3xl mx-auto mb-16 space-y-3">
                <span class="text-xs font-bold uppercase tracking-widest text-amber-400 bg-amber-500/10 px-3 py-1 rounded-full border border-amber-500/30">
                    Official Identity
                </span>
                <h2 class="font-cinzel text-3xl sm:text-4xl font-extrabold text-white">
                    Digital & Printable Visiting Card
                </h2>
                <div class="w-24 h-1 bg-gradient-to-r from-transparent via-amber-400 to-transparent mx-auto"></div>
                <p class="text-xs sm:text-sm text-amber-100/70">
                    Save, print, or share the official digital credential card of <strong>DR. E. K. Raja Varma (Vidya Vachaspathi in Vedic Astrology)</strong>.
                </p>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-12 gap-12 items-center">
                <!-- Visual Visiting Card Column -->
                <div class="lg:col-span-7 flex flex-col items-center">
                    
                    <!-- THE DIGITAL VISITING CARD CONTAINER (Printable) -->
                    <div id="printable-visiting-card"
                         class="w-full max-w-xl rounded-3xl p-7 sm:p-9 bg-gradient-to-br from-[#260e1d] via-[#1a1128] to-[#3a1020] border-2 border-amber-400 shadow-2xl gold-glow-lg relative overflow-hidden text-amber-50 select-text">
                        
                        <!-- Background Yantra Watermark -->
                        <div class="absolute -right-8 -top-8 opacity-10 text-amber-300 font-serif text-[180px] pointer-events-none select-none">
                            ॐ
                        </div>

                        <!-- Card Top Header -->
                        <div class="flex items-center justify-between border-b border-amber-400/40 pb-4 mb-5">
                            <div class="flex items-center space-x-2.5">
                                <div class="w-8 h-8 rounded-full bg-amber-400 text-black flex items-center justify-center font-bold text-sm">
                                    ॐ
                                </div>
                                <div>
                                    <h4 class="font-cinzel text-base sm:text-lg font-bold tracking-widest text-amber-300">
                                        COVILAKAM ASTROLOGY
                                    </h4>
                                    <span class="text-[10px] italic text-amber-200/80 tracking-wider">Explore. Discover. Transform.</span>
                                </div>
                            </div>
                            <div class="text-right">
                                <span class="px-2 py-0.5 rounded bg-amber-500/20 border border-amber-400/50 text-[10px] font-bold text-amber-300">
                                    IAF #11009
                                </span>
                            </div>
                        </div>

                        <!-- Card Center Profile & Title -->
                        <div class="flex flex-col sm:flex-row items-center sm:items-start gap-5 mb-5">
                            <div class="w-24 h-24 shrink-0 rounded-2xl p-0.5 bg-gradient-to-tr from-amber-600 via-amber-300 to-yellow-500 shadow-lg">
                                <img src="{{ asset('storage/media/images/covilakam-4bcJQK.webp') }}"
                                     alt="DR. E. K. Raja Varma"
                                     onerror="this.onerror=null; this.src='{{ asset('images/covilakam-hero.webp') }}';"
                                     class="w-full h-full object-cover rounded-2xl">
                            </div>

                            <div class="space-y-1 text-center sm:text-left">
                                <h3 class="font-cinzel text-xl sm:text-2xl font-black text-amber-200">
                                    DR. E. K. Raja Varma
                                </h3>
                                <p class="font-cinzel text-xs sm:text-sm font-bold text-amber-400">
                                    (Vidya Vachaspathi in Vedic Astrology)
                                </p>
                                <ul class="text-[11px] text-amber-100/80 pt-1 space-y-0.5">
                                    <li>• Ph.D. in Vedic Astrology (Online Astro Counselling)</li>
                                    <li>• Vidya Vachaspathi (Gold Medalist - 2026)</li>
                                    <li>• P. G. Diploma in Vedic Astrology | Jothisha Bhooshanam</li>
                                </ul>
                            </div>
                        </div>

                        <!-- Card Contact Details Grid -->
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-2.5 pt-4 border-t border-amber-400/30 text-xs">
                            <div class="flex items-center space-x-2">
                                <span class="text-emerald-400 font-bold">WhatsApp:</span>
                                <span class="font-mono text-amber-100">+91 7907052160</span>
                            </div>
                            <div class="flex items-center space-x-2">
                                <span class="text-amber-400 font-bold">Phone/GPay:</span>
                                <span class="font-mono text-amber-100">094473 27450</span>
                            </div>
                            <div class="flex items-center space-x-2">
                                <span class="text-amber-400 font-bold">Email:</span>
                                <span class="truncate text-amber-100">varmaji@covilakamastrology.com</span>
                            </div>
                            <div class="flex items-center space-x-2">
                                <span class="text-amber-400 font-bold">Alt:</span>
                                <span class="truncate text-amber-100">ekrvarma@gmail.com</span>
                            </div>
                            <div class="col-span-1 sm:col-span-2 flex items-center justify-between pt-1">
                                <div class="flex items-center space-x-2">
                                    <span class="text-amber-400 font-bold">Web:</span>
                                    <span class="text-amber-100">www.covilakamastrology.com</span>
                                </div>
                                <span class="text-[10px] text-amber-300/70 italic">Consultations since 2022</span>
                            </div>
                        </div>
                    </div>

                    <!-- Print Action Button -->
                    <div class="mt-6 flex flex-wrap gap-4 justify-center">
                        <button onclick="window.print()"
                                class="inline-flex items-center space-x-2 px-6 py-3 rounded-xl font-bold text-xs sm:text-sm text-[#1a1128] bg-gradient-to-r from-amber-300 to-yellow-400 hover:from-amber-200 hover:to-yellow-300 shadow-xl transition-all">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/>
                            </svg>
                            <span>Download / Print Visiting Card</span>
                        </button>
                        <a href="{{ route('visiting-card') }}"
                           class="inline-flex items-center space-x-2 px-6 py-3 rounded-xl font-bold text-xs sm:text-sm text-amber-200 border border-amber-500/40 hover:bg-amber-500/10 transition-all">
                            <span>Open Dedicated Visiting Card Page</span>
                        </a>
                    </div>
                </div>

                <!-- Right Column: Official Payments & Consultation Procedure -->
                <div class="lg:col-span-5 space-y-6">
                    <div class="p-7 rounded-3xl bg-[#1c112e] border border-amber-500/30 shadow-xl space-y-5">
                        <div class="flex items-center space-x-3">
                            <div class="w-12 h-12 rounded-xl bg-gradient-to-tr from-amber-600 to-yellow-400 p-0.5">
                                <div class="w-full h-full rounded-xl bg-[#1c112e] flex items-center justify-center text-xl font-bold text-amber-300">
                                    💳
                                </div>
                            </div>
                            <div>
                                <h3 class="font-cinzel text-lg font-bold text-white">Payment & Booking Info</h3>
                                <p class="text-xs text-amber-200/70">Google Pay (GPay) & UPI Dakshina</p>
                            </div>
                        </div>

                        <!-- GPay QR Code Card in Payment Section -->
                        <div class="p-4 rounded-2xl bg-gradient-to-br from-[#24133b] to-[#180b29] border border-amber-500/30 flex flex-col sm:flex-row items-center gap-4">
                            <div class="w-28 h-28 sm:w-32 sm:h-32 shrink-0 bg-white p-2 rounded-2xl shadow-xl border-2 border-amber-400/80 cursor-pointer group"
                                 @click="gpayModalOpen = true" title="Click to enlarge QR Code">
                                <img src="{{ asset('images/gpay-qr-code.jpg') }}" alt="Google Pay QR Code - DR. E. K. Raja Varma" class="w-full h-full object-contain group-hover:scale-105 transition-transform duration-200">
                            </div>
                            <div class="space-y-1.5 text-center sm:text-left">
                                <div class="inline-flex items-center space-x-1.5 px-2.5 py-0.5 rounded-full bg-emerald-500/20 text-emerald-300 text-[10px] font-bold border border-emerald-400/30">
                                    <span>● Verified Google Pay Account</span>
                                </div>
                                <p class="text-sm font-bold text-white">DR. E. K. Raja Varma</p>
                                <p class="text-xs text-amber-200 font-medium">UPI ID: <span class="font-mono text-amber-300 font-bold select-all">ekrvarma-1@oksbi</span></p>
                                <p class="text-xs text-amber-100">GPay: <span class="font-mono font-bold text-amber-300">094473 27450</span></p>
                                <button type="button" @click="gpayModalOpen = true" class="mt-1 inline-flex items-center space-x-1 text-xs text-amber-300 hover:text-amber-200 font-semibold underline underline-offset-4">
                                    <span>🔍 Click to Enlarge QR Code</span>
                                </button>
                            </div>
                        </div>

                        <div class="p-4 rounded-2xl bg-[#26163e] border border-amber-500/20 space-y-2">
                            <div class="flex items-center justify-between text-xs">
                                <span class="text-amber-200">Google Pay (GPay) Number:</span>
                                <span class="font-mono font-bold text-amber-300 text-sm">094473 27450</span>
                            </div>
                            <div class="flex items-center justify-between text-xs">
                                <span class="text-amber-200">UPI ID:</span>
                                <span class="font-mono text-amber-300 font-bold select-all">ekrvarma-1@oksbi</span>
                            </div>
                            <div class="flex items-center justify-between text-xs">
                                <span class="text-amber-200">International / Phone:</span>
                                <span class="font-mono text-amber-300">+91 94473 27450</span>
                            </div>
                            <div class="flex items-center justify-between text-xs">
                                <span class="text-amber-200">WhatsApp Business:</span>
                                <span class="font-mono text-emerald-400">+91 7907052160</span>
                            </div>
                        </div>

                        <div class="space-y-2.5 text-xs text-amber-100/80">
                            <h4 class="font-bold text-amber-300 uppercase tracking-wider text-[11px]">How Online Consultation Works:</h4>
                            <div class="flex items-start space-x-2">
                                <span class="text-amber-400 font-bold">1.</span>
                                <span>Send your Birth Details (Date, Time, Place of Birth) and specific questions on WhatsApp.</span>
                            </div>
                            <div class="flex items-start space-x-2">
                                <span class="text-amber-400 font-bold">2.</span>
                                <span>Complete payment via Google Pay (094473 27450 / ekrvarma-1@oksbi) and share confirmation.</span>
                            </div>
                            <div class="flex items-start space-x-2">
                                <span class="text-amber-400 font-bold">3.</span>
                                <span>DR. E. K. Raja Varma personally reviews your Jathakam and conducts in-depth consultation with detailed remedies.</span>
                            </div>
                        </div>

                        <a href="https://wa.me/917907052160?text={{ rawurlencode('Namaskaram DR. E. K. Raja Varma (Vidya Vachaspathi in Vedic Astrology), I would like to book a consultation and pay via GPay (094473 27450 / ekrvarma-1@oksbi).') }}"
                           target="_blank"
                           class="w-full py-3 rounded-xl font-bold text-xs sm:text-sm text-white bg-emerald-600 hover:bg-emerald-500 shadow-lg flex items-center justify-center space-x-2 transition-all">
                            <span>Connect on WhatsApp for Payment Confirmation</span>
                        </a>
                    </div>
                </div>

            </div>
        </div>
    </section>

    <!-- Google Pay & UPI QR Code Lightbox Modal -->
    <div x-show="gpayModalOpen"
         x-cloak
         @keydown.escape.window="gpayModalOpen = false"
         class="fixed inset-0 z-50 overflow-y-auto bg-black/85 backdrop-blur-md flex items-center justify-center p-4"
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0">

        <!-- Modal Dialog Box -->
        <div @click.away="gpayModalOpen = false"
             class="relative w-full max-w-sm sm:max-w-md rounded-3xl bg-gradient-to-b from-[#1f1133] via-[#160c26] to-[#0f071a] border-2 border-amber-400/60 p-6 sm:p-7 shadow-2xl text-center space-y-4"
             x-transition:enter="transition ease-out duration-300 transform"
             x-transition:enter-start="opacity-0 scale-95"
             x-transition:enter-end="opacity-100 scale-100"
             x-transition:leave="transition ease-in duration-200 transform"
             x-transition:leave-start="opacity-100 scale-100"
             x-transition:leave-end="opacity-0 scale-95">

            <!-- Close Button -->
            <button type="button"
                    @click="gpayModalOpen = false"
                    class="absolute top-4 right-4 w-9 h-9 rounded-full bg-white/10 hover:bg-white/20 text-white flex items-center justify-center transition-colors">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>

            <!-- Modal Header -->
            <div class="space-y-1">
                <div class="inline-flex items-center space-x-1.5 px-3 py-1 rounded-full bg-amber-400/15 border border-amber-400/40 text-amber-300 text-[11px] font-bold uppercase tracking-wider">
                    <span>👑 Official Astro Dakshina / Consultation Fee</span>
                </div>
                <h3 class="font-cinzel text-xl sm:text-2xl font-bold text-white pt-1">
                    DR. E. K. Raja Varma
                </h3>
                <p class="text-xs text-amber-200/80">Vidya Vachaspathi & Vedic Astrologer • Covilakam</p>
            </div>

            <!-- Crisp QR Image Container -->
            <div class="p-3 bg-white rounded-2xl shadow-2xl border-4 border-amber-400/50 max-w-[270px] sm:max-w-[300px] mx-auto">
                <img src="{{ asset('images/gpay-qr-code.jpg') }}"
                     alt="Google Pay QR Code - DR. E. K. Raja Varma"
                     class="w-full h-auto object-contain rounded-xl">
            </div>

            <!-- Verified Details Box -->
            <div class="p-3.5 rounded-xl bg-[#25153d]/90 border border-amber-500/30 text-xs text-left space-y-2">
                <div class="flex items-center justify-between">
                    <span class="text-amber-200/80">Google Pay Phone:</span>
                    <span class="font-mono font-bold text-amber-300">094473 27450</span>
                </div>
                <div class="flex items-center justify-between">
                    <span class="text-amber-200/80">UPI ID:</span>
                    <span class="font-mono font-bold text-amber-300 select-all">ekrvarma-1@oksbi</span>
                </div>
                <div class="flex items-center justify-between">
                    <span class="text-amber-200/80">Accepted Apps:</span>
                    <span class="text-amber-100 font-semibold">Google Pay, PhonePe, Paytm, Any UPI</span>
                </div>
            </div>

            <p class="text-[11px] text-amber-200/70 leading-relaxed">
                Scan with Google Pay or any UPI app to complete dakshina, then share screenshot via WhatsApp at <strong>+91 7907052160</strong>.
            </p>

            <!-- Actions -->
            <div class="pt-1 flex flex-col sm:flex-row gap-2">
                <a href="https://wa.me/917907052160?text={{ rawurlencode('Namaskaram DR. E. K. Raja Varma (Vidya Vachaspathi in Vedic Astrology), I have made payment via Google Pay (ekrvarma-1@oksbi / 094473 27450). Here is my confirmation.') }}"
                   target="_blank"
                   class="flex-1 py-2.5 px-4 rounded-xl font-bold text-xs text-white bg-emerald-600 hover:bg-emerald-500 shadow-lg flex items-center justify-center space-x-1.5 transition-all">
                    <span>Share Receipt on WhatsApp</span>
                </a>
                <button type="button"
                        @click="gpayModalOpen = false"
                        class="py-2.5 px-4 rounded-xl text-xs font-semibold text-amber-200 bg-white/10 hover:bg-white/20 transition-all">
                    Close
                </button>
            </div>
        </div>
    </div>

</div>
@endsection

@extends('layouts.app')

@section('title', 'About Us | Covilakam Astrology - DR. E. K. Raja Varma')
@section('meta_description', 'About Covilakam Astrology, established in Kerala by DR. E. K. Raja Varma (Vidya Vachaspathi in Vedic Astrology, 2026 Gold Medalist & Ph.D.). Blending classical Parashara principles with modern compassionate Astro Counselling.')

@section('content')
<div class="pt-32 pb-24 bg-[#0d0716] min-h-screen text-amber-100/90 relative overflow-hidden">
    <!-- Subtle Golden Background Glow -->
    <div class="absolute inset-0 bg-radial from-amber-600/5 via-transparent to-transparent pointer-events-none"></div>

    <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
        <!-- Breadcrumb -->
        <nav class="flex items-center space-x-2 text-xs text-amber-300/70 mb-6">
            <a href="{{ route('home') }}" class="hover:text-amber-200">Home</a>
            <span>/</span>
            <span class="text-amber-300">About Us</span>
        </nav>

        <!-- Page Header -->
        <div class="border-b border-amber-500/20 pb-8 mb-10 text-center sm:text-left">
            <div class="inline-flex items-center space-x-2 px-3 py-1 rounded-full border border-amber-500/30 bg-amber-500/10 text-amber-300 text-xs font-semibold mb-4">
                <span>🏛️ Heritage & Vedic Scholarship</span>
            </div>
            <h1 class="font-cinzel text-3xl sm:text-4xl font-bold text-amber-300 tracking-wide">
                About Covilakam Astrology
            </h1>
            <p class="text-sm text-amber-200/70 mt-2 max-w-3xl leading-relaxed">
                A sanctuary of authentic Vedic wisdom, classical Kerala Prasnam, and transformative psychological Astro Counselling, led by <strong>DR. E. K. Raja Varma (Vidya Vachaspathi in Vedic Astrology)</strong>.
            </p>
        </div>

        <!-- Astrologer Profile Section -->
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-center mb-12">
            <div class="lg:col-span-5 text-center">
                <div class="relative inline-block">
                    <div class="w-64 h-64 sm:w-72 sm:h-72 mx-auto rounded-3xl p-1 bg-gradient-to-tr from-amber-600 via-amber-300 to-yellow-500 shadow-2xl overflow-hidden">
                        <img src="{{ asset('images/og-covilakam-512x512.png') }}"
                             alt="DR. E. K. Raja Varma"
                             class="w-full h-full object-cover rounded-[22px]">
                    </div>
                    <div class="absolute -bottom-3 left-1/2 transform -translate-x-1/2 px-4 py-1.5 rounded-full bg-[#1a1128] border border-amber-500/50 shadow-lg text-[11px] font-bold text-amber-300 whitespace-nowrap">
                        🏆 2026 Gold Medalist & Ph.D.
                    </div>
                </div>
            </div>

            <div class="lg:col-span-7 space-y-4">
                <h2 class="font-cinzel text-2xl font-bold text-amber-300">
                    DR. E. K. Raja Varma
                </h2>
                <p class="text-xs text-amber-400 font-semibold tracking-wider uppercase">
                    (Vidya Vachaspathi in Vedic Astrology • IAF Fellow #11009)
                </p>
                <p class="text-sm text-amber-100/80 leading-relaxed">
                    With decades of disciplined astrological study, classical Sanskrit scholarship, and thousands of accurate horoscope readings across Kerala, India, and the global Malayali diaspora, <strong>DR. E. K. Raja Varma</strong> is revered for his ethical, compassionate approach to Jyothisha Shastra.
                </p>
                <p class="text-sm text-amber-100/80 leading-relaxed">
                    Rather than promoting fatalism or fear-inducing doshas, DR. E. K. Raja Varma combines traditional Kerala Parashara calculations with modern psychological counselling—empowering clients to understand their planetary cycles, harness auspicious timing, and navigate career, marriage, health, and spiritual growth with clarity and poise.
                </p>

                <!-- Credentials Badges -->
                <div class="pt-2 flex flex-wrap gap-2 text-xs">
                    <span class="px-3 py-1 rounded-full border border-amber-500/40 bg-amber-500/10 text-amber-200">🎓 Ph.D. in Vedic Astrology</span>
                    <span class="px-3 py-1 rounded-full border border-amber-500/40 bg-amber-500/10 text-amber-200">🥇 Gold Medalist (2026)</span>
                    <span class="px-3 py-1 rounded-full border border-amber-500/40 bg-amber-500/10 text-amber-200">📜 IAF Life Member #11009</span>
                    <span class="px-3 py-1 rounded-full border border-amber-500/40 bg-amber-500/10 text-amber-200">✍️ Renowned Author & Scholar</span>
                </div>
            </div>
        </div>

        <!-- 3 Pillars Grid -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-12">
            <div class="bg-[#1a1128] p-6 rounded-2xl border border-amber-500/25">
                <span class="text-3xl block mb-3">🔍</span>
                <h3 class="font-cinzel text-base font-bold text-amber-300 mb-2">Mathematical Precision</h3>
                <p class="text-xs text-amber-100/70 leading-relaxed">
                    Calculations follow exact Ayanamsa and Bhava Sphutam algorithms verified against traditional Kerala Panchangams for unparalleled predictive accuracy.
                </p>
            </div>

            <div class="bg-[#1a1128] p-6 rounded-2xl border border-amber-500/25">
                <span class="text-3xl block mb-3">🤝</span>
                <h3 class="font-cinzel text-base font-bold text-amber-300 mb-2">Empathetic Astro Counselling</h3>
                <p class="text-xs text-amber-100/70 leading-relaxed">
                    Astrology serves as a guiding light, not a rigid constraint. Consultations are structured as constructive sessions designed to relieve mental anxiety.
                </p>
            </div>

            <div class="bg-[#1a1128] p-6 rounded-2xl border border-amber-500/25">
                <span class="text-3xl block mb-3">📖</span>
                <h3 class="font-cinzel text-base font-bold text-amber-300 mb-2">Authentic Publications</h3>
                <p class="text-xs text-amber-100/70 leading-relaxed">
                    Our Bookstore offers authoritative published Vedic treatises authored by DR. E. K. Raja Varma, bringing classical Sanskrit knowledge to every home.
                </p>
            </div>
        </div>

        <!-- Official Registration & Payment Trust -->
        <div class="bg-gradient-to-r from-amber-950/40 via-[#1a1128] to-purple-950/40 p-6 sm:p-8 rounded-2xl border border-amber-500/30 text-center sm:text-left flex flex-col sm:flex-row items-center justify-between gap-6">
            <div>
                <h4 class="font-cinzel text-lg font-bold text-amber-300 mb-1">Razorpay Verified Merchant</h4>
                <p class="text-xs text-amber-200/70 max-w-xl">
                    Covilakam Astrology accepts secure payments for books, consultations, and digital Jathakam downloads via Razorpay, supporting UPI, Cards, NetBanking, and Google Pay.
                </p>
            </div>
            <a href="{{ route('shop.index') }}"
               class="px-6 py-3 rounded-xl font-cinzel font-bold text-xs uppercase tracking-wider text-[#1a1128] bg-gradient-to-r from-amber-300 via-yellow-400 to-amber-500 shadow-lg hover:from-amber-200 hover:to-yellow-300 transition-all shrink-0">
                Explore Bookstore & Services
            </a>
        </div>
    </div>
</div>
@endsection

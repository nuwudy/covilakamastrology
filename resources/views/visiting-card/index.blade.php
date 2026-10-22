@extends('layouts.app')

@section('title', 'Digital Visiting Card | Dr. E. K. Raja Varma (Vidya Vachaspathi in Vedic Astrology)')
@section('meta_description', 'Official Digital Visiting Card of Dr. E. K. Raja Varma (Vidya Vachaspathi in Vedic Astrology), Covilakam Astrology. Connect via WhatsApp +91 7907052160 or GPay 094473 27450.')

@section('content')
<div class="pt-32 pb-24 bg-[#0d0716] min-h-screen">
    <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <!-- Header -->
        <div class="text-center max-w-2xl mx-auto mb-14 space-y-3">
            <span class="text-xs font-bold uppercase tracking-widest text-amber-400 bg-amber-500/10 px-3.5 py-1 rounded-full border border-amber-500/30">
                Official Digital Identity
            </span>
            <h1 class="font-cinzel text-3xl sm:text-5xl font-black text-white">
                Digital Visiting Card
            </h1>
            <div class="w-24 h-1 bg-gradient-to-r from-transparent via-amber-400 to-transparent mx-auto"></div>
            <p class="text-xs sm:text-sm text-amber-100/70">
                Official credential card of <strong>Dr. E. K. Raja Varma</strong> (Vidya Vachaspathi in Vedic Astrology).
            </p>
        </div>

        <!-- The Visiting Card Presentation -->
        <div class="flex flex-col items-center">
            
            <div id="printable-visiting-card"
                 class="w-full max-w-xl rounded-3xl p-8 sm:p-10 bg-gradient-to-br from-[#2a0e1c] via-[#1a1128] to-[#380e22] border-2 border-amber-400 shadow-2xl gold-glow-lg relative overflow-hidden text-amber-50 select-text">
                
                <!-- Watermark -->
                <div class="absolute -right-8 -top-8 opacity-10 text-amber-300 font-serif text-[200px] pointer-events-none select-none">
                    ॐ
                </div>

                <!-- Card Header -->
                <div class="flex items-center justify-between border-b border-amber-400/40 pb-4 mb-6">
                    <div class="flex items-center space-x-3">
                        <div class="w-10 h-10 rounded-full bg-gradient-to-tr from-amber-500 to-yellow-300 text-[#1a1128] flex items-center justify-center font-bold text-lg shadow">
                            ॐ
                        </div>
                        <div>
                            <h2 class="font-cinzel text-lg sm:text-xl font-bold tracking-widest text-amber-300">
                                COVILAKAM ASTROLOGY
                            </h2>
                            <span class="text-xs italic text-amber-200/80 tracking-wider">Explore. Discover. Transform.</span>
                        </div>
                    </div>
                    <div>
                        <span class="px-2.5 py-1 rounded-full bg-amber-500/20 border border-amber-400/50 text-[10px] font-bold text-amber-300">
                            IAF Life Member #11009
                        </span>
                    </div>
                </div>

                <!-- Profile Section -->
                <div class="flex flex-col sm:flex-row items-center sm:items-start gap-6 mb-6">
                    <div class="w-28 h-28 shrink-0 rounded-2xl p-0.5 bg-gradient-to-tr from-amber-600 via-amber-300 to-yellow-500 shadow-xl">
                        <img src="{{ asset('storage/media/images/covilakam-4bcJQK.webp') }}"
                             alt="Dr. E. K. Raja Varma"
                             onerror="this.onerror=null; this.src='{{ asset('images/covilakam-hero.webp') }}';"
                             class="w-full h-full object-cover rounded-2xl">
                    </div>

                    <div class="space-y-1.5 text-center sm:text-left">
                        <h3 class="font-cinzel text-2xl font-black text-amber-200">
                            Dr. E. K. Raja Varma
                        </h3>
                        <p class="font-cinzel text-sm font-bold text-amber-400">
                            (Vidya Vachaspathi in Vedic Astrology)
                        </p>
                        
                        <div class="text-xs text-amber-100/90 pt-1 space-y-1">
                            <p class="font-semibold text-amber-300">
                                • Ph.D. in Vedic Astrology (Specialisation in Online Astro Counselling)
                            </p>
                            <p>
                                • Vidya Vachaspathi in Vedic Astrology (Gold Medalist - Sept 2026)
                            </p>
                            <p class="text-[11px] text-amber-200/75">
                                • P. G. Diploma in Vedic Astrology | Jothisha Bhooshanam
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Contact & Payment Section -->
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 pt-5 border-t border-amber-400/40 text-xs">
                    <div class="flex items-center space-x-2">
                        <span class="text-emerald-400 font-bold">WhatsApp:</span>
                        <a href="https://wa.me/917907052160" target="_blank" class="font-mono text-amber-100 hover:text-emerald-300 underline">+91 7907052160</a>
                    </div>
                    <div class="flex items-center space-x-2">
                        <span class="text-amber-400 font-bold">Phone / GPay:</span>
                        <a href="tel:+919447327450" class="font-mono text-amber-100 hover:text-amber-300">094473 27450</a>
                    </div>
                    <div class="flex items-center space-x-2">
                        <span class="text-amber-400 font-bold">Primary Email:</span>
                        <span class="text-amber-100 truncate">varmaji@covilakamastrology.com</span>
                    </div>
                    <div class="flex items-center space-x-2">
                        <span class="text-amber-400 font-bold">Secondary Email:</span>
                        <span class="text-amber-100 truncate">ekrvarma@gmail.com</span>
                    </div>
                    <div class="col-span-1 sm:col-span-2 flex items-center justify-between pt-2">
                        <div class="flex items-center space-x-2">
                            <span class="text-amber-400 font-bold">Portal Website:</span>
                            <span class="text-amber-100">www.covilakamastrology.com</span>
                        </div>
                        <span class="text-[11px] text-amber-300/80 italic">Providing Consultations Since 2022</span>
                    </div>
                </div>

            </div>

            <!-- Action Buttons -->
            <div class="mt-8 flex flex-wrap items-center justify-center gap-4">
                <button onclick="window.print()"
                        class="px-6 py-3.5 rounded-xl font-bold text-xs sm:text-sm text-[#1a1128] bg-gradient-to-r from-amber-300 via-yellow-400 to-amber-500 hover:from-amber-200 hover:to-yellow-300 shadow-xl flex items-center space-x-2 transition-all">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/>
                    </svg>
                    <span>Print / Save as PDF</span>
                </button>

                <a href="https://wa.me/917907052160?text={{ rawurlencode('Namaskaram Dr. E. K. Raja Varma (Vidya Vachaspathi in Vedic Astrology), I saved your Digital Visiting Card from Covilakam Astrology and would like to consult with you.') }}"
                   target="_blank"
                   class="px-6 py-3.5 rounded-xl font-bold text-xs sm:text-sm text-white bg-emerald-600 hover:bg-emerald-500 shadow-xl flex items-center space-x-2 transition-all">
                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M12.031 6.172c-3.181 0-5.767 2.586-5.768 5.766-.001 1.298.38 2.27 1.019 3.287l-.711 2.598 2.664-.698c.969.585 1.961.947 2.796.947 3.179 0 5.766-2.587 5.767-5.766.001-3.181-2.586-5.767-5.767-5.767zm0 10.373c-.768 0-1.637-.251-2.327-.661l-.167-.099-1.58.414.422-1.539-.109-.174c-.453-.722-.693-1.564-.693-2.55 0-2.539 2.066-4.605 4.606-4.605 2.54 0 4.606 2.066 4.606 4.606 0 2.54-2.066 4.608-4.755 4.608z"/>
                    </svg>
                    <span>Save Contact on WhatsApp</span>
                </a>

                <a href="{{ route('visiting-card.print') }}" target="_blank"
                   class="px-6 py-3.5 rounded-xl font-medium text-xs sm:text-sm text-amber-200 border border-amber-500/40 hover:bg-amber-500/10 transition-all">
                    Standalone Clean Print Window
                </a>
            </div>

        </div>

    </div>
</div>
@endsection

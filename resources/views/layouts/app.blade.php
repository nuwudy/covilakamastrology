<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'DR. E. K. Raja Varma (Vidya Vachaspathi in Vedic Astrology) | Covilakam Astrology')</title>
    <meta name="description" content="@yield('meta_description', 'Covilakam Astrology - Official portal of DR. E. K. Raja Varma (Vidya Vachaspathi in Vedic Astrology). Explore. Discover. Transform. Accurate Predictions, Jathakam, Marriage Matching, Gem Predictions, and Muhoorthams.')">
    <meta name="keywords" content="DR E K Raja Varma, Vidya Vachaspathi in Vedic Astrology, Covilakam Astrology, Kerala Astrology, Online Astro Counselling, Jathakam, Porutham, Malayalam Astrology">

    <!-- Canonical -->
    <link rel="canonical" href="{{ url()->current() }}">

    <!-- Favicon & Touch Icons -->
    <link rel="icon" type="image/png" href="{{ asset('favicon.png') }}?v={{ time() }}">
    <link rel="shortcut icon" href="{{ asset('favicon.ico') }}?v={{ time() }}">
    <link rel="apple-touch-icon" href="{{ asset('apple-touch-icon.png') }}?v={{ time() }}">
    <link rel="manifest" href="{{ asset('site.webmanifest') }}">
    <meta name="theme-color" content="#1a1128">

    <!-- Open Graph / Facebook / WhatsApp (1200x630) -->
    <meta property="og:type" content="website">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:title" content="@yield('title', 'DR. E. K. Raja Varma (Vidya Vachaspathi in Vedic Astrology) | Covilakam Astrology')">
    <meta property="og:description" content="@yield('meta_description', 'Covilakam Astrology - Official portal of DR. E. K. Raja Varma (Vidya Vachaspathi in Vedic Astrology). Accurate Predictions, Jathakam, Marriage Matching, Gem Predictions, and Online Astro Counselling.')">
    <meta property="og:image" content="@yield('og_image', asset('images/og-covilakam-1200x630.png'))">
    <meta property="og:image:secure_url" content="@yield('og_image', asset('images/og-covilakam-1200x630.png'))">
    <meta property="og:image:width" content="1200">
    <meta property="og:image:height" content="630">
    <meta property="og:image:type" content="image/png">
    <meta property="og:image:alt" content="DR. E. K. Raja Varma (Vidya Vachaspathi in Vedic Astrology) - Covilakam Astrology">
    <meta property="og:site_name" content="Covilakam Astrology">
    <meta property="og:locale" content="en_US">

    <!-- Twitter / X Cards (1200x630 summary_large_image) -->
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:url" content="{{ url()->current() }}">
    <meta name="twitter:title" content="@yield('title', 'DR. E. K. Raja Varma (Vidya Vachaspathi in Vedic Astrology) | Covilakam Astrology')">
    <meta name="twitter:description" content="@yield('meta_description', 'Covilakam Astrology - Official portal of DR. E. K. Raja Varma (Vidya Vachaspathi in Vedic Astrology). Accurate Predictions, Jathakam, Marriage Matching, Gem Predictions, and Online Astro Counselling.')">
    <meta name="twitter:image" content="@yield('og_image', asset('images/og-covilakam-1200x630.png'))">
    <meta name="twitter:image:alt" content="DR. E. K. Raja Varma (Vidya Vachaspathi in Vedic Astrology) - Covilakam Astrology">

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cinzel:wght@500;600;700;800;900&family=Playfair+Display:ital,wght@0,500;0,600;0,700;1,400&family=Plus+Jakarta+Sans:wght@300;400;500;600;700&family=Noto+Sans+Malayalam:wght@400;500;600;700&family=Noto+Sans+Devanagari:wght@400;500;600;700&family=Noto+Sans+Tamil:wght@400;500;600;700&display=swap" rel="stylesheet">

    <!-- Styles & Scripts via Vite -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- Global Styling Defaults -->
    <style>
        body {
            font-family: 'Plus Jakarta Sans', system-ui, sans-serif;
            background-color: #0d0716;
            color: #fdfbf7;
        }
        [x-cloak] { display: none !important; }
    </style>
</head>
<body class="bg-[#0d0716] text-[#fdfbf7] antialiased selection:bg-amber-500 selection:text-black overflow-x-hidden"
      x-data="{ bookingModalOpen: false, modalService: 'Accurate Predictions' }"
      @open-booking-modal.window="bookingModalOpen = true; if($event.detail && $event.detail.service) { modalService = $event.detail.service }">

    <!-- Navbar -->
    @include('partials.navbar')

    <!-- Main Content -->
    <main class="min-h-screen">
        @yield('content')
    </main>

    <!-- Global Consultation Booking Modal -->
    <div x-show="bookingModalOpen"
         x-cloak
         class="fixed inset-0 z-50 overflow-y-auto"
         aria-labelledby="modal-title" role="dialog" aria-modal="true">
        <!-- Backdrop -->
        <div x-show="bookingModalOpen"
             x-transition:enter="ease-out duration-300"
             x-transition:enter-start="opacity-0"
             x-transition:enter-end="opacity-100"
             x-transition:leave="ease-in duration-200"
             x-transition:leave-start="opacity-100"
             x-transition:leave-end="opacity-0"
             @click="bookingModalOpen = false"
             class="fixed inset-0 bg-black/80 backdrop-blur-sm transition-opacity"></div>

        <div class="flex min-h-full items-center justify-center p-4 text-center sm:p-0">
            <div x-show="bookingModalOpen"
                 x-transition:enter="ease-out duration-300"
                 x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                 x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
                 x-transition:leave="ease-in duration-200"
                 x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
                 x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                 @click.stop
                 class="relative transform overflow-hidden rounded-3xl bg-[#160d24] border-2 border-amber-500/40 text-left shadow-2xl transition-all sm:my-8 sm:w-full sm:max-w-lg p-6 sm:p-8">
                
                <!-- Close Button -->
                <button @click="bookingModalOpen = false"
                        class="absolute top-5 right-5 text-amber-300/70 hover:text-white rounded-full p-1 hover:bg-white/10 transition-colors">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>

                <div class="mb-5 text-center">
                    <div class="inline-flex p-2 rounded-2xl bg-gradient-to-tr from-amber-600 via-amber-400 to-yellow-300 text-[#1a1128] mb-3">
                        <svg class="w-7 h-7" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                        </svg>
                    </div>
                    <h3 class="font-cinzel text-xl sm:text-2xl font-bold text-amber-300" id="modal-title">
                        Book Consultation
                    </h3>
                    <p class="text-xs text-amber-200/80 mt-1">
                        With <strong>DR. E. K. Raja Varma</strong> (Vidya Vachaspathi in Vedic Astrology)
                    </p>
                </div>

                <form action="{{ route('consultations.store') }}" method="POST" class="space-y-4 text-xs">
                    @csrf
                    <div>
                        <label class="block font-medium text-amber-200 mb-1">Your Full Name *</label>
                        <input type="text" name="name" required placeholder="Enter your full name"
                               class="w-full px-3.5 py-2.5 rounded-xl bg-[#201335] border border-amber-500/30 text-white placeholder-amber-200/40 focus:outline-none focus:border-amber-400">
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                        <div>
                            <label class="block font-medium text-amber-200 mb-1">Phone / WhatsApp *</label>
                            <input type="tel" name="phone" required placeholder="+91 9876543210"
                                   class="w-full px-3.5 py-2.5 rounded-xl bg-[#201335] border border-amber-500/30 text-white placeholder-amber-200/40 focus:outline-none focus:border-amber-400">
                        </div>
                        <div>
                            <label class="block font-medium text-amber-200 mb-1">Service Needed *</label>
                            <select name="service_requested" x-model="modalService"
                                    class="w-full px-3.5 py-2.5 rounded-xl bg-[#201335] border border-amber-500/30 text-white focus:outline-none focus:border-amber-400">
                                <option value="Accurate Predictions">Accurate Predictions</option>
                                <option value="Jathakam Reports">Jathakam Reports</option>
                                <option value="Marriage Match Reports">Marriage Match Reports</option>
                                <option value="Gem Prediction Reports">Gem Prediction Reports</option>
                                <option value="Muhoorthams">Muhoorthams</option>
                                <option value="Comprehensive Astro Counselling">Comprehensive Astro Counselling</option>
                            </select>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-3">
                        <div>
                            <label class="block font-medium text-amber-200 mb-1">Date of Birth</label>
                            <input type="date" name="birth_date"
                                   class="w-full px-3.5 py-2.5 rounded-xl bg-[#201335] border border-amber-500/30 text-white focus:outline-none focus:border-amber-400">
                        </div>
                        <div>
                            <label class="block font-medium text-amber-200 mb-1">Birth Time</label>
                            <input type="time" name="birth_time"
                                   class="w-full px-3.5 py-2.5 rounded-xl bg-[#201335] border border-amber-500/30 text-white focus:outline-none focus:border-amber-400">
                        </div>
                        <div>
                            <label class="block font-medium text-amber-200 mb-1">Place of Birth</label>
                            <input type="text" name="birth_place" placeholder="City, State"
                                   class="w-full px-3.5 py-2.5 rounded-xl bg-[#201335] border border-amber-500/30 text-white placeholder-amber-200/40 focus:outline-none focus:border-amber-400">
                        </div>
                    </div>

                    <div>
                        <label class="block font-medium text-amber-200 mb-1">Specific Questions / Concerns</label>
                        <textarea name="message" rows="3" placeholder="Briefly describe your questions regarding career, marriage, health, business..."
                                  class="w-full px-3.5 py-2.5 rounded-xl bg-[#201335] border border-amber-500/30 text-white placeholder-amber-200/40 focus:outline-none focus:border-amber-400"></textarea>
                    </div>

                    <div class="pt-2">
                        <button type="submit"
                                class="w-full py-3.5 rounded-xl font-bold text-sm text-[#1a1128] bg-gradient-to-r from-amber-300 via-yellow-400 to-amber-500 hover:from-amber-200 hover:to-yellow-300 shadow-xl hover:shadow-amber-500/30 transition-all duration-200">
                            Submit & Connect on WhatsApp (+91 7907052160)
                        </button>
                    </div>

                    <div class="text-center pt-1 text-[11px] text-amber-200/60">
                        <span>Direct GPay: <strong>094473 27450</strong></span> • <span>Strict Client Confidentiality Guaranteed</span>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Floating WhatsApp Widget -->
    @include('partials.floating-whatsapp')

    <!-- Footer -->
    @include('partials.footer')

    @stack('scripts')
</body>
</html>

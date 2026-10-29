<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'Dr. E. K. Raja Varma | Covilakam Astrology (Kovilakam Astrology - കോവിലകം ജ്യോതിഷം)')</title>
    <meta name="description" content="@yield('meta_description', 'Covilakam Astrology (also searched as Kovilakam Astrology / കോവിലകം ജ്യോതിഷം) - Official portal of Dr. E. K. Raja Varma (Vidya Vachaspathi in Vedic Astrology, Gold Medalist & Ph.D.). Accurate Predictions, Jathakam, Marriage Matching (Porutham), Gem Predictions, and Online Astro Counselling for Kerala & Global Malayalees.')">
    <meta name="keywords" content="Covilakam Astrology, Kovilakam Astrology, കോവിലകം ജ്യോതിഷം, Kovilakam Jyothisham, Covilakam Jyothisham, Dr. E. K. Raja Varma, Dr E K Raja Varma, Vidya Vachaspathi in Vedic Astrology, IVAF, International Vedic Astrology Federation, Indian Vedic Astrology Federation, Kerala Astrology, Malayalam Astrology Online, ജാതക പരിശോധന, വിവാഹ പൊരുത്തം, മുഹൂർത്തം, Malayali Astrologer, Kerala Astrologer in Dubai UAE, Best Astrologer in Kerala, Online Astro Counselling">

    <!-- Canonical -->
    <link rel="canonical" href="{{ url()->current() }}">

    <!-- Favicon & Touch Icons (Google Search & Multi-device compliant) -->
    <link rel="icon" href="{{ asset('favicon.ico') }}" sizes="48x48">
    <link rel="icon" type="image/png" sizes="48x48" href="{{ asset('favicon-48x48.png') }}">
    <link rel="icon" type="image/png" sizes="96x96" href="{{ asset('favicon-96x96.png') }}">
    <link rel="icon" type="image/png" sizes="192x192" href="{{ asset('favicon-192x192.png') }}">
    <link rel="shortcut icon" href="{{ asset('favicon.ico') }}">
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('apple-touch-icon.png') }}">
    <link rel="manifest" href="{{ asset('site.webmanifest') }}">
    <meta name="theme-color" content="#1a1128">

    <!-- Open Graph / Facebook / WhatsApp (1200x630, optimized JPEG <300KB for instant WhatsApp previews) -->
    <meta property="og:type" content="website">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:title" content="@yield('title', 'Dr. E. K. Raja Varma | Covilakam Astrology (Kovilakam Astrology - കോവിലകം ജ്യോതിഷം)')">
    <meta property="og:description" content="@yield('meta_description', 'Covilakam Astrology (Kovilakam Astrology / കോവിലകം ജ്യോതിഷം) - Official portal of Dr. E. K. Raja Varma (Vidya Vachaspathi in Vedic Astrology). Accurate Predictions, Jathakam, Marriage Matching, Gem Predictions, and Online Astro Counselling.')">
    <meta property="og:image" content="@yield('og_image', asset('images/og-covilakam-1200x630.jpg'))">
    <meta property="og:image:secure_url" content="@yield('og_image', asset('images/og-covilakam-1200x630.jpg'))">
    <meta property="og:image:width" content="1200">
    <meta property="og:image:height" content="630">
    <meta property="og:image:type" content="image/jpeg">
    <meta property="og:image:alt" content="Dr. E. K. Raja Varma (Vidya Vachaspathi in Vedic Astrology) - Covilakam Astrology">
    <meta property="og:site_name" content="Covilakam Astrology (Kovilakam Astrology)">
    <meta property="og:locale" content="en_US">
    <meta property="og:locale:alternate" content="ml_IN">
    <link rel="image_src" href="@yield('og_image', asset('images/og-covilakam-1200x630.jpg'))">

    <!-- Twitter / X Cards (1200x630 summary_large_image) -->
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:url" content="{{ url()->current() }}">
    <meta name="twitter:title" content="@yield('title', 'Dr. E. K. Raja Varma | Covilakam Astrology (Kovilakam Astrology)')">
    <meta name="twitter:description" content="@yield('meta_description', 'Covilakam Astrology (Kovilakam Astrology / കോവിലകം ജ്യോതിഷം) - Official portal of Dr. E. K. Raja Varma (Vidya Vachaspathi in Vedic Astrology). Accurate Predictions, Jathakam, Marriage Matching, Gem Predictions, and Online Astro Counselling.')">
    <meta name="twitter:image" content="@yield('og_image', asset('images/og-covilakam-1200x630.jpg'))">
    <meta name="twitter:image:alt" content="Dr. E. K. Raja Varma (Vidya Vachaspathi in Vedic Astrology) - Covilakam Astrology">

    <!-- Structured JSON-LD Schema: Organization, ProfessionalService, Person & FAQ for High Search Visibility -->
    @php
        $schemaGraph = [
            '@context' => 'https://schema.org',
            '@graph' => [
                [
                    '@type' => 'ProfessionalService',
                    '@id' => url('/') . '#organization',
                    'name' => 'Covilakam Astrology',
                    'alternateName' => [
                        'Kovilakam Astrology',
                        'കോവിലകം ജ്യോതിഷം',
                        'Covilakam Jyothisham',
                        'Kovilakam Jyothisham',
                        'Covilakam Vedic Astrology',
                        'Kovilakam Vedic Astrology'
                    ],
                    'url' => url('/'),
                    'logo' => asset('images/logo.png'),
                    'image' => asset('images/og-covilakam-1200x630.jpg'),
                    'description' => 'Covilakam Astrology (also known as Kovilakam Astrology / കോവിലകം ജ്യോതിഷം) is the official Vedic astrology practice of Dr. E. K. Raja Varma (Vidya Vachaspathi in Vedic Astrology, 2026 Gold Medalist & Ph.D.). Specialising in accurate horoscope predictions, Jathakam analysis, marriage compatibility (Porutham), and online consultations for Kerala and global Malayalis.',
                    'telephone' => '+917907052160',
                    'email' => 'varmaji@covilakamastrology.com',
                    'priceRange' => '$$',
                    'address' => [
                        '@type' => 'PostalAddress',
                        'addressRegion' => 'Kerala',
                        'addressCountry' => 'IN'
                    ],
                    'areaServed' => [
                        ['@type' => 'AdministrativeArea', 'name' => 'Kerala'],
                        ['@type' => 'Country', 'name' => 'India'],
                        ['@type' => 'Country', 'name' => 'United Arab Emirates'],
                        ['@type' => 'Country', 'name' => 'Qatar'],
                        ['@type' => 'Country', 'name' => 'Saudi Arabia'],
                        ['@type' => 'Country', 'name' => 'Oman'],
                        ['@type' => 'Country', 'name' => 'Kuwait'],
                        ['@type' => 'Country', 'name' => 'United States'],
                        ['@type' => 'Country', 'name' => 'United Kingdom']
                    ],
                    'knowsLanguage' => ['ml', 'en', 'ta', 'hi'],
                    'founder' => [
                        '@type' => 'Person',
                        'name' => 'Dr. E. K. Raja Varma',
                        'honorificPrefix' => 'Dr.',
                        'jobTitle' => 'Vidya Vachaspathi in Vedic Astrology & Gold Medalist',
                        'sameAs' => [
                            'https://www.youtube.com/@CovilakamAstrology'
                        ]
                    ]
                ],
                [
                    '@type' => 'FAQPage',
                    '@id' => url('/') . '#faq',
                    'mainEntity' => [
                        [
                            '@type' => 'Question',
                            'name' => 'Is it Covilakam Astrology or Kovilakam Astrology?',
                            'acceptedAnswer' => [
                                '@type' => 'Answer',
                                'text' => 'Both Covilakam Astrology and Kovilakam Astrology (കോവിലകം ജ്യോതിഷം) refer to the same authentic Vedic astrology practice established by Dr. E. K. Raja Varma (Vidya Vachaspathi in Vedic Astrology). In Malayalam it is written as കോവിലകം ജ്യോതിഷം, and it is commonly searched in English as both Covilakam and Kovilakam.'
                            ]
                        ],
                        [
                            '@type' => 'Question',
                            'name' => 'Can Malayalis (Mallus) get an online astrology consultation in Malayalam?',
                            'acceptedAnswer' => [
                                '@type' => 'Answer',
                                'text' => 'Yes! Dr. E. K. Raja Varma provides authentic online Vedic astrology consultations, Jathakam readings, marriage matching (Porutham), and remedies directly in Malayalam (മലയാളം), as well as English, Tamil, and Hindi for clients in Kerala, the Gulf (UAE, Oman, Qatar, Saudi Arabia), and across the world via WhatsApp.'
                            ]
                        ]
                    ]
                ]
            ]
        ];
    @endphp
    <script type="application/ld+json">
    {!! json_encode($schemaGraph, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT) !!}
    </script>

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
      x-data="{
          bookingModalOpen: false,
          bookingStep: 1,
          modalService: 'Accurate Predictions',
          consultationFee: 500,
          paymentMethodUsed: 'Razorpay',
          paymentReference: '',
          upiCopiedModal: false,
          payingOnline: false,
          payError: '',
          async payConsultationRazorpay() {
              this.payingOnline = true;
              this.payError = '';
              try {
                  if (typeof Razorpay === 'undefined') {
                      await new Promise((resolve, reject) => {
                          const s = document.createElement('script');
                          s.src = 'https://checkout.razorpay.com/v1/checkout.js';
                          s.onload = resolve;
                          s.onerror = reject;
                          document.head.appendChild(s);
                      });
                  }
                  const csrf = document.querySelector('meta[name=csrf-token]')?.getAttribute('content') || '';
                  const amountPaise = Math.max(100, Math.round((Number(this.consultationFee) || 500) * 100));
                  const res = await fetch('/api/create-order', {
                      method: 'POST',
                      headers: {
                          'Content-Type': 'application/json',
                          'Accept': 'application/json',
                          'X-CSRF-TOKEN': csrf
                      },
                      body: JSON.stringify({ amount: amountPaise, currency: 'INR' })
                  });
                  const data = await res.json();
                  if (!res.ok || !data.order_id) {
                      throw new Error(data.error || 'Could not initialize online gateway. Please use the direct Razorpay link or GPay below.');
                  }
                  const self = this;
                  const rzp = new Razorpay({
                      key: data.key,
                      amount: data.amount,
                      currency: data.currency || 'INR',
                      name: 'Covilakam Astrology',
                      description: 'Consultation: ' + self.modalService,
                      order_id: data.order_id,
                      theme: { color: '#f59e0b' },
                      handler: async function (response) {
                          self.paymentMethodUsed = 'Razorpay Checkout';
                          self.paymentReference = response.razorpay_payment_id || '';
                          self.payingOnline = false;
                          self.bookingStep = 2;
                      },
                      modal: {
                          ondismiss: function () {
                              self.payingOnline = false;
                          }
                      }
                  });
                  rzp.open();
              } catch (e) {
                  this.payingOnline = false;
                  this.payError = e.message || 'Unable to launch checkout popup. Please use Razorpay.me link or GPay below.';
              }
          }
      }"
      @open-booking-modal.window="bookingModalOpen = true; bookingStep = 1; payError = ''; if($event.detail && $event.detail.service) { modalService = $event.detail.service }">

    <!-- Navbar -->
    @include('partials.navbar')

    <!-- Main Content -->
    <main class="min-h-screen">
        @yield('content')
    </main>

    <!-- Global 2-Step Consultation Modal: Step 1 (Payment Option First) -> Step 2 (Consultation Window) -->
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
                 class="relative transform overflow-hidden rounded-3xl bg-[#160d24] border-2 border-amber-500/40 text-left shadow-2xl transition-all sm:my-8 sm:w-full sm:max-w-xl p-6 sm:p-8">
                
                <!-- Close Button -->
                <button @click="bookingModalOpen = false"
                        class="absolute top-5 right-5 text-amber-300/70 hover:text-white rounded-full p-1 hover:bg-white/10 transition-colors">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>

                <div class="mb-4 text-center">
                    <div class="inline-flex p-2 rounded-2xl bg-gradient-to-tr from-amber-600 via-amber-400 to-yellow-300 text-[#1a1128] mb-2">
                        <svg class="w-7 h-7" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                        </svg>
                    </div>
                    <h3 class="font-cinzel text-xl sm:text-2xl font-bold text-amber-300" id="modal-title">
                        Book Consultation
                    </h3>
                    <p class="text-xs text-amber-200/80 mt-1">
                        With <strong>Dr. E. K. Raja Varma</strong> (Vidya Vachaspathi in Vedic Astrology)
                    </p>

                    <!-- 2-Step Indicator: Step 1 Payment Option -> Step 2 Consultation Window -->
                    <div class="mt-4 flex items-center justify-center gap-2 text-xs font-bold">
                        <button type="button"
                                @click="bookingStep = 1"
                                :class="bookingStep === 1 ? 'bg-amber-400 text-[#1a1128] shadow-md' : 'bg-emerald-500/20 text-emerald-300 border border-emerald-500/40'"
                                class="px-3.5 py-1.5 rounded-full transition-all flex items-center gap-1.5">
                            <span>1. Payment Option</span>
                            <span x-show="bookingStep === 2">✓</span>
                        </button>
                        <span class="text-amber-500/50">→</span>
                        <button type="button"
                                @click="bookingStep = 2"
                                :class="bookingStep === 2 ? 'bg-amber-400 text-[#1a1128] shadow-md' : 'bg-[#201335] text-amber-200/60 border border-amber-500/20'"
                                class="px-3.5 py-1.5 rounded-full transition-all">
                            <span>2. Consultation Window</span>
                        </button>
                    </div>
                </div>

                <!-- STEP 1: PAYMENT OPTION FIRST -->
                <div x-show="bookingStep === 1" class="space-y-4 text-xs">
                    <div class="p-3.5 rounded-2xl bg-[#201335]/90 border border-amber-500/30">
                        <label class="block font-semibold text-amber-200 mb-1.5">Select Service for Consultation:</label>
                        <select x-model="modalService"
                                class="w-full px-3.5 py-2.5 rounded-xl bg-[#140b22] border border-amber-500/30 text-white focus:outline-none focus:border-amber-400">
                            <option value="Accurate Predictions">Accurate Predictions</option>
                            <option value="Jathakam Reports">Jathakam Reports</option>
                            <option value="Marriage Match Reports">Marriage Match Reports</option>
                            <option value="Gem Prediction Reports">Gem Prediction Reports</option>
                            <option value="Muhoorthams">Muhoorthams</option>
                            <option value="Comprehensive Astro Counselling">Comprehensive Astro Counselling</option>
                        </select>

                        <div class="mt-3 flex flex-wrap items-center justify-between gap-2">
                            <span class="text-amber-200/80 font-medium">Consultation Fee (₹):</span>
                            <div class="flex items-center gap-1.5">
                                <button type="button" @click="consultationFee = 500" :class="consultationFee == 500 ? 'bg-amber-400 text-[#1a1128]' : 'bg-[#140b22] text-amber-200 border border-amber-500/30'" class="px-2.5 py-1 rounded-lg font-bold">₹500</button>
                                <button type="button" @click="consultationFee = 999" :class="consultationFee == 999 ? 'bg-amber-400 text-[#1a1128]' : 'bg-[#140b22] text-amber-200 border border-amber-500/30'" class="px-2.5 py-1 rounded-lg font-bold">₹999</button>
                                <button type="button" @click="consultationFee = 1500" :class="consultationFee == 1500 ? 'bg-amber-400 text-[#1a1128]' : 'bg-[#140b22] text-amber-200 border border-amber-500/30'" class="px-2.5 py-1 rounded-lg font-bold">₹1500</button>
                                <input type="number" x-model="consultationFee" min="100" class="w-20 px-2 py-1 rounded-lg bg-[#140b22] border border-amber-500/40 text-amber-300 font-bold text-center" placeholder="₹">
                            </div>
                        </div>
                    </div>

                    <!-- Option 1: Razorpay Direct Link & On-Website Checkout -->
                    <div class="p-4 rounded-2xl bg-gradient-to-br from-blue-950/60 via-[#1d1230] to-indigo-950/60 border border-blue-400/40 space-y-2.5">
                        <div class="flex items-center justify-between">
                            <span class="font-bold text-blue-200 text-xs sm:text-sm flex items-center gap-1.5">
                                <span>💳</span>
                                <span>Option 1: Pay Online via Razorpay</span>
                            </span>
                            <span class="px-2 py-0.5 rounded-full bg-blue-500/20 text-blue-300 border border-blue-400/30 text-[10px] font-bold">Recommended</span>
                        </div>
                        <p class="text-[11px] text-amber-100/75">
                            Pay securely using UPI, GPay, PhonePe, Debit/Credit Cards, or NetBanking via our official Razorpay portal:
                        </p>
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-2.5 pt-1">
                            <a href="https://razorpay.me/@covilakamastrology"
                               target="_blank"
                               rel="noopener noreferrer"
                               @click="paymentMethodUsed = 'Razorpay (razorpay.me/@covilakamastrology)'"
                               class="w-full py-2.5 px-3 rounded-xl font-bold text-xs text-white bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-500 hover:to-indigo-500 text-center shadow-lg transition-all flex items-center justify-center gap-1.5">
                                <span>🔗 Pay on Razorpay.me</span>
                            </a>
                            <button type="button"
                                    @click="payConsultationRazorpay()"
                                    :disabled="payingOnline"
                                    class="w-full py-2.5 px-3 rounded-xl font-bold text-xs text-[#1a1128] bg-gradient-to-r from-amber-300 via-yellow-400 to-amber-500 hover:from-amber-200 hover:to-yellow-300 text-center shadow-lg transition-all flex items-center justify-center gap-1.5 disabled:opacity-50">
                                <span x-show="!payingOnline">⚡ Instant Checkout (₹<span x-text="consultationFee"></span>)</span>
                                <span x-show="payingOnline">Opening Razorpay...</span>
                            </button>
                        </div>
                        <p x-show="payError" x-text="payError" class="text-[11px] text-rose-300 pt-1"></p>
                    </div>

                    <!-- Option 2: Google Pay (GPay) / Direct UPI -->
                    <div class="p-4 rounded-2xl bg-[#201335]/90 border border-emerald-500/30 space-y-2">
                        <div class="flex items-center justify-between">
                            <span class="font-bold text-emerald-300 text-xs sm:text-sm flex items-center gap-1.5">
                                <span>📲</span>
                                <span>Option 2: Google Pay (GPay) / UPI</span>
                            </span>
                            <span class="text-[11px] text-emerald-200 font-bold">094473 27450</span>
                        </div>
                        <div class="flex flex-wrap items-center justify-between gap-2 bg-[#140b22] px-3 py-2 rounded-xl border border-amber-500/20">
                            <div>
                                <span class="text-[10px] text-amber-200/60 block">Official UPI ID:</span>
                                <span class="font-mono text-xs font-bold text-amber-300 select-all">ekrvarma-1@oksbi</span>
                            </div>
                            <button type="button"
                                    @click="navigator.clipboard.writeText('ekrvarma-1@oksbi'); upiCopiedModal = true; paymentMethodUsed = 'GPay / UPI (ekrvarma-1@oksbi)'; setTimeout(() => upiCopiedModal = false, 2500)"
                                    class="px-3 py-1.5 rounded-lg bg-emerald-500/20 hover:bg-emerald-500/30 text-emerald-200 border border-emerald-500/40 font-bold text-[11px] transition-all">
                                <span x-show="!upiCopiedModal">📋 Copy UPI ID</span>
                                <span x-show="upiCopiedModal" class="text-emerald-300">✓ Copied!</span>
                            </button>
                        </div>
                    </div>

                    <!-- Proceed to Step 2 Button -->
                    <div class="pt-1">
                        <button type="button"
                                @click="bookingStep = 2"
                                class="w-full py-3.5 rounded-xl font-bold text-xs sm:text-sm text-[#1a1128] bg-gradient-to-r from-emerald-400 via-teal-300 to-emerald-500 hover:from-emerald-300 hover:to-teal-200 shadow-xl transition-all flex items-center justify-center gap-2">
                            <span>✅ Proceed to Step 2: Consultation Window</span>
                            <span>→</span>
                        </button>
                    </div>
                </div>

                <!-- STEP 2: CONSULTATION WINDOW (Form & Birth Details) -->
                <form x-show="bookingStep === 2" action="{{ route('consultations.store') }}" method="POST" class="space-y-3.5 text-xs">
                    @csrf
                    <div class="flex items-center justify-between px-3.5 py-2 rounded-xl bg-emerald-950/60 border border-emerald-500/40 text-emerald-200">
                        <span class="font-semibold">✓ Step 1 Payment Option Selected (<span x-text="paymentMethodUsed"></span>)</span>
                        <button type="button" @click="bookingStep = 1" class="text-amber-300 underline hover:text-amber-200 font-bold">← Back to Payment</button>
                    </div>

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
                        <label class="block font-medium text-amber-200 mb-1">Specific Questions / Payment Reference (Optional)</label>
                        <textarea name="message" rows="3"
                                  :placeholder="paymentReference ? 'Payment ID: ' + paymentReference + ' - Describe your questions...' : 'Mention your payment reference (if any) and describe your questions regarding career, marriage, health, business...'"
                                  class="w-full px-3.5 py-2.5 rounded-xl bg-[#201335] border border-amber-500/30 text-white placeholder-amber-200/40 focus:outline-none focus:border-amber-400"></textarea>
                    </div>

                    <div class="pt-2">
                        <button type="submit"
                                class="w-full py-3.5 rounded-xl font-bold text-sm text-[#1a1128] bg-gradient-to-r from-amber-300 via-yellow-400 to-amber-500 hover:from-amber-200 hover:to-yellow-300 shadow-xl hover:shadow-amber-500/30 transition-all duration-200">
                            Submit & Open Consultation Window (+91 7907052160)
                        </button>
                    </div>

                    <div class="text-center pt-1 text-[11px] text-amber-200/60">
                        <span>Razorpay: <strong>razorpay.me/@covilakamastrology</strong></span> • <span>GPay: <strong>094473 27450</strong></span>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Floating Free DOB Reading Widget -->
    @include('partials.floating-dob')

    <!-- Floating WhatsApp Widget -->
    @include('partials.floating-whatsapp')

    <!-- Footer -->
    @include('partials.footer')

    <script>
        window.shareCovilakamBlog = async function(options, btnElement) {
            const title = options.title || 'Covilakam Astrology';
            const excerpt = options.excerpt || '';
            const url = options.url || window.location.href;
            const imageUrl = options.imageUrl || '';
            const shareText = `✨ *${title}*\n${excerpt ? excerpt + '\n\n' : ''}✍️ Dr. E. K. Raja Varma (Covilakam Astrology)\n📖 Read Full Article: ${url}`;

            let originalHtml = '';
            if (btnElement) {
                originalHtml = btnElement.innerHTML;
                btnElement.disabled = true;
            }

            try {
                if (navigator.share) {
                    let sharedWithFile = false;
                    if (imageUrl && navigator.canShare) {
                        try {
                            const response = await fetch(imageUrl, { cache: 'force-cache' });
                            if (response.ok) {
                                const blob = await response.blob();
                                const ext = (blob.type && blob.type.includes('png')) ? 'png' : 'jpg';
                                const file = new File([blob], `covilakam-astrology-blog.${ext}`, { type: blob.type || 'image/jpeg' });
                                const shareDataWithFile = {
                                    title: title,
                                    text: shareText,
                                    url: url,
                                    files: [file]
                                };
                                if (navigator.canShare(shareDataWithFile)) {
                                    await navigator.share(shareDataWithFile);
                                    sharedWithFile = true;
                                }
                            }
                        } catch (imgErr) {
                            // Fallback to standard URL share if image fetch or file share is blocked
                        }
                    }

                    if (!sharedWithFile) {
                        await navigator.share({
                            title: title,
                            text: shareText,
                            url: url
                        });
                    }
                    return;
                }
            } catch (err) {
                if (err && err.name === 'AbortError') {
                    return;
                }
            } finally {
                if (btnElement) {
                    btnElement.disabled = false;
                    btnElement.innerHTML = originalHtml;
                }
            }

            // Desktop / Non-WebShare fallback: Open WhatsApp share (which renders the 1200x630 og:image preview card)
            const waShareUrl = 'https://api.whatsapp.com/send?text=' + encodeURIComponent(shareText);
            window.open(waShareUrl, '_blank', 'noopener,noreferrer');
        };

        window.copyCovilakamBlogLink = function(url, btnElement) {
            const targetUrl = url || window.location.href;
            if (navigator.clipboard && navigator.clipboard.writeText) {
                navigator.clipboard.writeText(targetUrl).then(() => {
                    if (btnElement) {
                        const prev = btnElement.innerHTML;
                        btnElement.innerHTML = '<span>✓ Link Copied!</span>';
                        setTimeout(() => { btnElement.innerHTML = prev; }, 2000);
                    }
                });
            } else {
                const input = document.createElement('input');
                input.value = targetUrl;
                document.body.appendChild(input);
                input.select();
                document.execCommand('copy');
                document.body.removeChild(input);
                if (btnElement) {
                    const prev = btnElement.innerHTML;
                    btnElement.innerHTML = '<span>✓ Link Copied!</span>';
                    setTimeout(() => { btnElement.innerHTML = prev; }, 2000);
                }
            }
        };
    </script>

    @stack('scripts')
</body>
</html>

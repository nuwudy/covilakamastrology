@extends('layouts.app')

@section('title', 'Dr. E. K. Raja Varma\'s Books, Literary Works & Astrology Services | Covilakam Astrology')
@section('meta_description', 'Official Bookstore & Services Shop of DR. E. K. Raja Varma (Vidya Vachaspathi in Vedic Astrology). Explore authentic Malayalam literary books, philosophy, short stories, audio album, and certified Vedic astrology services.')

@section('content')
<div class="pt-32 pb-24 bg-[#0d0716] min-h-screen text-amber-100/90 relative overflow-hidden"
     x-data="{
        activeTab: '{{ $type ?? 'all' }}',
        checkoutModalOpen: false,
        flipbookModalOpen: false,
        selectedProduct: null,
        customerName: '',
        customerPhone: '',
        customerEmail: '',
        shippingAddress: '',
        birthDate: '',
        birthTime: '',
        birthPlace: '',
        notes: '',
        loading: false,
        errorMessage: '',

        openCheckout(product) {
            this.selectedProduct = product;
            this.checkoutModalOpen = true;
            this.errorMessage = '';
        },

        closeCheckout() {
            this.checkoutModalOpen = false;
            this.selectedProduct = null;
            this.errorMessage = '';
        },

        async submitOrder() {
            if (!this.customerName || !this.customerPhone) {
                this.errorMessage = 'Please provide your Full Name and WhatsApp Phone Number.';
                return;
            }

            if (this.selectedProduct.type === 'book' && !this.shippingAddress) {
                this.errorMessage = 'Please provide your complete shipping delivery address for book dispatch.';
                return;
            }

            this.loading = true;
            this.errorMessage = '';

            try {
                const response = await fetch('{{ route('shop.create-order') }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name=csrf-token]').content,
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify({
                        product_id: this.selectedProduct.id,
                        customer_name: this.customerName,
                        customer_phone: this.customerPhone,
                        customer_email: this.customerEmail,
                        shipping_address: this.shippingAddress,
                        birth_date: this.birthDate,
                        birth_time: this.birthTime,
                        birth_place: this.birthPlace,
                        notes: this.notes
                    })
                });

                const data = await response.json();

                if (!response.ok || !data.success) {
                    throw new Error(data.message || 'Failed to initialize order.');
                }

                // Check if Razorpay script is ready and key is available
                if (typeof Razorpay !== 'undefined' && data.key_id && !data.key_id.includes('sampleKey')) {
                    const options = {
                        key: data.key_id,
                        amount: data.amount,
                        currency: 'INR',
                        name: 'Covilakam Astrology',
                        description: data.product_title,
                        image: '{{ asset('images/og-covilakam-512x512.png') }}',
                        order_id: data.razorpay_order_id,
                        prefill: {
                            name: data.customer_name,
                            contact: data.customer_phone,
                            email: data.customer_email || ''
                        },
                        theme: {
                            color: '#d97706'
                        },
                        handler: async function (response) {
                            // Verify Payment
                            const verifyRes = await fetch('{{ route('shop.verify-payment') }}', {
                                method: 'POST',
                                headers: {
                                    'Content-Type': 'application/json',
                                    'X-CSRF-TOKEN': document.querySelector('meta[name=csrf-token]').content,
                                    'Accept': 'application/json'
                                },
                                body: JSON.stringify({
                                    order_number: data.order_number,
                                    razorpay_payment_id: response.razorpay_payment_id,
                                    razorpay_order_id: response.razorpay_order_id,
                                    razorpay_signature: response.razorpay_signature
                                })
                            });

                            const verifyData = await verifyRes.json();
                            if (verifyData.success) {
                                window.location.href = verifyData.redirect_url;
                            } else {
                                alert('Payment verification failed: ' + verifyData.message);
                            }
                        },
                        modal: {
                            ondismiss: function() {
                                alert('Payment was cancelled. You can retry at any time.');
                            }
                        }
                    };
                    const rzp = new Razorpay(options);
                    rzp.open();
                } else {
                    // Demo Mode / Instant Verification Fallback
                    const verifyRes = await fetch('{{ route('shop.verify-payment') }}', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name=csrf-token]').content,
                            'Accept': 'application/json'
                        },
                        body: JSON.stringify({
                            order_number: data.order_number,
                            razorpay_payment_id: 'pay_demo_' + Date.now(),
                            razorpay_order_id: data.razorpay_order_id,
                            razorpay_signature: 'demo_sig'
                        })
                    });

                    const verifyData = await verifyRes.json();
                    if (verifyData.success) {
                        window.location.href = verifyData.redirect_url;
                    }
                }
            } catch (err) {
                this.errorMessage = err.message || 'An error occurred during checkout.';
            } finally {
                this.loading = false;
            }
        }
     }">

    <!-- Subtle Golden Background Glow -->
    <div class="absolute inset-0 bg-radial from-amber-600/5 via-transparent to-transparent pointer-events-none"></div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
        <!-- Hero Header -->
        <div class="text-center max-w-3xl mx-auto mb-12">
            <div class="inline-flex items-center space-x-2 px-4 py-1.5 rounded-full border border-amber-500/30 bg-amber-500/10 text-amber-300 text-xs font-semibold mb-4">
                <span>📚 ഡോ. ഇ. കെ. രാജ വർമ്മയുടെ ഗ്രന്ഥങ്ങളും സാഹിത്യ രചനകളും</span>
            </div>
            <h1 class="font-cinzel text-3xl sm:text-5xl font-extrabold text-amber-300 tracking-wide">
                ഗ്രന്ഥങ്ങളും സാഹിത്യ രചനകളും
            </h1>
            <div class="font-cinzel text-xl sm:text-2xl font-bold text-amber-200 mt-2">
                Dr. E. K. Raja Varma's Books, Creative Works & Services
            </div>
            <p class="text-xs sm:text-sm text-amber-200/70 mt-3 leading-relaxed">
                വേദിക് ജ്യോതിഷാചാര്യൻ <strong>ഡോ. ഇ. കെ. രാജ വർമ്മ (വിദ്യാ വാചസ്പതി)</strong> രചിച്ച സാഹിത്യ കൃതികൾ, അനുഭവക്കുറിപ്പുകൾ, ചിന്താശകലങ്ങൾ, ചെറുകഥകൾ, സംഗീത ആൽബം എന്നിവയോടൊപ്പം കോവിലകം വേദിക് ജ്യോതിഷ സേവനങ്ങളും. താങ്കൾക്ക് ആവശ്യമായ പുസ്തകങ്ങൾ വാട്സാപ്പ് വഴി നേരിട്ട് ഓർഡർ ചെയ്യാവുന്നതാണ്.
            </p>
            <p class="text-[11px] text-amber-300/70 mt-1">
                Authentic Malayalam literary works, philosophy, short stories & audio album authored by Dr. E. K. Raja Varma, alongside certified Covilakam horoscope consultations & Deluxe Jathakam PDFs.
            </p>

            <!-- Trust Bar -->
            <div class="mt-6 flex flex-wrap items-center justify-center gap-3 sm:gap-6 text-[11px] text-amber-200/80">
                <span class="flex items-center space-x-1.5 bg-[#1a1128] px-3 py-1.5 rounded-full border border-amber-500/20">
                    <span class="text-emerald-400">✓</span>
                    <span>Direct Author Signed Copies</span>
                </span>
                <span class="flex items-center space-x-1.5 bg-[#1a1128] px-3 py-1.5 rounded-full border border-amber-500/20">
                    <span class="text-amber-400">⚡</span>
                    <span>WhatsApp / GPay Order + Razorpay</span>
                </span>
                <span class="flex items-center space-x-1.5 bg-[#1a1128] px-3 py-1.5 rounded-full border border-amber-500/20">
                    <span class="text-emerald-400">📦</span>
                    <span>Speed Post Courier Across Kerala & Abroad</span>
                </span>
            </div>
        </div>

        <!-- Filter Category Tabs -->
        <div class="flex items-center justify-center mb-10 overflow-x-auto pb-2">
            <div class="inline-flex p-1.5 rounded-2xl bg-[#140b22] border border-amber-500/20 space-x-1 sm:space-x-2">
                <a href="{{ route('shop.index', ['type' => 'all']) }}"
                   class="px-4 py-2 rounded-xl text-xs sm:text-sm font-semibold transition-all whitespace-nowrap {{ ($type ?? 'all') === 'all' ? 'bg-gradient-to-r from-amber-400 to-yellow-500 text-[#1a1128] shadow-md font-bold' : 'text-amber-200/70 hover:text-amber-100 hover:bg-amber-500/10' }}">
                    All Items ({{ $books->count() + $services->count() }})
                </a>
                <a href="{{ route('shop.index', ['type' => 'book']) }}"
                   class="px-4 py-2 rounded-xl text-xs sm:text-sm font-semibold transition-all whitespace-nowrap {{ ($type ?? '') === 'book' ? 'bg-gradient-to-r from-amber-400 to-yellow-500 text-[#1a1128] shadow-md font-bold' : 'text-amber-200/70 hover:text-amber-100 hover:bg-amber-500/10' }}">
                    📚 Dr. Raja Varma's Books (സാഹിത്യ കൃതികൾ) ({{ $books->count() }})
                </a>
                <a href="{{ route('shop.index', ['type' => 'digital_pdf']) }}"
                   class="px-4 py-2 rounded-xl text-xs sm:text-sm font-semibold transition-all whitespace-nowrap {{ ($type ?? '') === 'digital_pdf' ? 'bg-gradient-to-r from-amber-400 to-yellow-500 text-[#1a1128] shadow-md font-bold' : 'text-amber-200/70 hover:text-amber-100 hover:bg-amber-500/10' }}">
                    📱 Deluxe Jathakam (PDF)
                </a>
                <a href="{{ route('shop.index', ['type' => 'consultation']) }}"
                   class="px-4 py-2 rounded-xl text-xs sm:text-sm font-semibold transition-all whitespace-nowrap {{ ($type ?? '') === 'consultation' ? 'bg-gradient-to-r from-amber-400 to-yellow-500 text-[#1a1128] shadow-md font-bold' : 'text-amber-200/70 hover:text-amber-100 hover:bg-amber-500/10' }}">
                    🔮 Consultations & Porutham
                </a>
                <a href="#flipbook-reader"
                   @click.prevent="document.getElementById('flipbook-reader').scrollIntoView({behavior: 'smooth'})"
                   class="px-4 py-2 rounded-xl text-xs sm:text-sm font-semibold transition-all whitespace-nowrap text-amber-300 hover:text-white bg-amber-500/20 hover:bg-amber-500/30 border border-amber-500/40 flex items-center space-x-1.5">
                    <span>📖</span>
                    <span>Read Flipbook (ഷഷ്ടാംഗം)</span>
                </a>
            </div>
        </div>

        <!-- Multi-Column Grid Displaying Real Books & Digital Services -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6 sm:gap-7">
            {{-- Dr. E. K. Raja Varma's Real Books from books table --}}
            @if(($type ?? 'all') === 'all' || ($type ?? '') === 'book')
                @foreach($books as $book)
                    <div class="bg-[#140b22] rounded-3xl p-5 flex flex-col justify-between transition-all duration-300 shadow-xl group hover:shadow-2xl hover:shadow-amber-500/10 border border-amber-500/25 hover:border-amber-400/60">
                        <div>
                            <!-- Book Cover Artwork Box -->
                            <div class="relative rounded-2xl overflow-hidden bg-gradient-to-b from-[#211339] to-[#0d0716] border border-amber-500/20 aspect-[2/3] max-h-80 mb-4 flex items-center justify-center p-3">
                                <img src="{{ asset($book->cover_image) }}"
                                     alt="{{ $book->title }}"
                                     loading="lazy"
                                     class="w-full h-full object-contain rounded-xl transform group-hover:scale-105 transition-transform duration-300 shadow-xl">

                                <!-- Royal Gold Price Tag Badge -->
                                <div class="absolute top-3 right-3 z-10">
                                    <div class="px-3 py-1 rounded-full text-xs font-black text-[#1a1128] bg-gradient-to-r from-amber-300 via-yellow-400 to-amber-500 shadow-lg border border-amber-200/60 flex items-center space-x-1 tracking-wide">
                                        <span>₹{{ number_format($book->price ?? 0, 0) }}</span>
                                    </div>
                                </div>

                                <!-- Publisher Tag -->
                                @if($book->publisher)
                                    <span class="absolute top-3 left-3 px-2.5 py-0.5 rounded text-[10px] font-semibold bg-[#1a1128]/95 text-amber-200 border border-amber-500/40 uppercase tracking-wider shadow">
                                        {{ Str::limit($book->publisher, 20) }}
                                    </span>
                                @endif
                            </div>

                            <!-- Titles -->
                            <div class="space-y-1 mb-2">
                                <div class="flex items-center space-x-1.5 text-[11px] text-amber-400/80 font-mono">
                                    <span>Work #{{ $book->sort_order }}</span>
                                    <span>•</span>
                                    <span class="text-amber-200/70">ഡോ. ഇ. കെ. രാജ വർമ്മ</span>
                                </div>
                                <h3 class="font-cinzel text-base sm:text-lg font-bold text-amber-200 group-hover:text-amber-300 transition-colors line-clamp-1">
                                    {{ $book->title }}
                                </h3>
                                @if($book->malayalam_title && $book->malayalam_title !== $book->title)
                                    <p class="text-xs text-amber-400 font-medium">
                                        {{ $book->malayalam_title }}
                                    </p>
                                @endif
                            </div>

                            <!-- Subtitle -->
                            @if($book->subtitle)
                                <p class="text-xs text-amber-300/80 font-medium line-clamp-1 mb-2">
                                    {{ $book->subtitle }}
                                </p>
                            @endif

                            <!-- Description -->
                            <p class="text-xs text-amber-100/75 line-clamp-3 leading-relaxed mb-4">
                                {{ $book->description }}
                            </p>
                        </div>

                        <!-- Card Actions -->
                        <div class="pt-3 border-t border-amber-500/20 space-y-2">
                            <!-- WhatsApp Buy Button -->
                            @php
                                $waPrice = $book->price ? number_format($book->price, 0) : '100';
                                $waText = "Namaskaram Dr. E. K. Raja Varma Sir, I would like to order a copy of your book '" . $book->title . "' (Price: ₹" . $waPrice . "). Please share the GPay/delivery details.";
                                $waUrl = "https://wa.me/917907052160?text=" . rawurlencode($waText);
                            @endphp
                            <a href="{{ $waUrl }}"
                               target="_blank"
                               rel="noopener noreferrer"
                               class="w-full py-2.5 px-3 rounded-xl font-cinzel font-bold text-xs uppercase tracking-wider text-[#1a1128] bg-gradient-to-r from-amber-300 via-yellow-400 to-amber-500 hover:from-amber-200 hover:to-yellow-300 shadow-md transition-all text-center flex items-center justify-center space-x-1.5">
                                <span>🛒</span>
                                <span>വാങ്ങുക / Order on WhatsApp (₹{{ number_format($book->price ?? 0, 0) }})</span>
                            </a>

                            <!-- Preview / Flipbook -->
                            @if($book->ebook_url)
                                @php
                                    $isFlipbook = Str::contains($book->ebook_url, ['fliphtml5', 'flipbook']);
                                    $isAudio = Str::contains(strtolower($book->title), ['audio', 'cd', 'rajageetham']);
                                    $btnLabel = $isFlipbook ? '📖 Read Flipbook Below' : ($isAudio ? '🎵 Listen Tracks' : '🔍 Preview Details');
                                @endphp
                                @if($isFlipbook)
                                    <button type="button"
                                            @click="document.getElementById('flipbook-reader').scrollIntoView({behavior: 'smooth'})"
                                            class="w-full py-2 px-3 rounded-xl text-xs font-bold text-[#1a1128] bg-gradient-to-r from-amber-300 via-yellow-400 to-amber-500 hover:from-amber-200 hover:to-yellow-300 shadow-md flex items-center justify-center space-x-1.5 transition-all text-center">
                                        <span>📖 Read Flipbook Directly Here</span>
                                        <span class="text-xs">↓</span>
                                    </button>
                                @else
                                    <a href="{{ $book->ebook_url }}"
                                       target="_blank"
                                       rel="noopener noreferrer"
                                       class="w-full py-2 px-3 rounded-xl text-xs font-semibold text-amber-200 bg-[#211335] border border-amber-500/30 hover:border-amber-400 hover:bg-[#2b1945] hover:text-white flex items-center justify-center space-x-1 transition-all text-center">
                                        <span>{{ $btnLabel }}</span>
                                        <span class="text-[10px] opacity-75">↗</span>
                                    </a>
                                @endif
                            @endif
                        </div>
                    </div>
                @endforeach
            @endif

            {{-- Digital Astrology Services (PDF & Consultations) --}}
            @if(($type ?? 'all') === 'all' || ($type ?? '') === 'digital_pdf' || ($type ?? '') === 'consultation')
                @foreach($services as $product)
                    <div class="bg-[#140b22] rounded-3xl p-5 flex flex-col justify-between transition-all duration-300 shadow-xl group hover:shadow-2xl hover:shadow-amber-500/10 border border-amber-500/25 hover:border-amber-400/60">
                        <div>
                            <div class="relative rounded-2xl overflow-hidden bg-[#0d0716] border border-amber-500/20 aspect-[3/4] max-h-80 mb-4 flex items-center justify-center p-3">
                                <img src="{{ asset($product->image_path) }}"
                                     alt="{{ $product->title }}"
                                     class="w-full h-full object-contain rounded-xl transform group-hover:scale-105 transition-transform duration-300">

                                @if($product->badge)
                                    <span class="absolute top-3 left-3 px-2.5 py-1 rounded-full text-[10px] font-bold bg-amber-400 text-[#1a1128] shadow-md">
                                        {{ $product->badge }}
                                    </span>
                                @endif

                                <span class="absolute top-3 right-3 px-2.5 py-0.5 rounded text-[10px] font-semibold bg-[#1a1128]/95 text-amber-200 border border-amber-500/40 uppercase tracking-wider shadow">
                                    {{ $product->type === 'digital_pdf' ? '📱 Instant PDF' : '🔮 Consultation' }}
                                </span>
                            </div>

                            <div class="space-y-1 mb-2">
                                <h3 class="font-cinzel text-base sm:text-lg font-bold text-amber-200 group-hover:text-amber-300 transition-colors line-clamp-1">
                                    {{ $product->title }}
                                </h3>
                                @if($product->title_ml)
                                    <p class="text-xs text-amber-400 font-medium">
                                        {{ $product->title_ml }}
                                    </p>
                                @endif
                            </div>

                            <p class="text-[11px] text-amber-300/80 font-medium mb-2 flex items-center space-x-1">
                                <span>✍️</span>
                                <span>DR. E. K. Raja Varma (Vidya Vachaspathi)</span>
                            </p>

                            <p class="text-xs text-amber-100/75 line-clamp-2 leading-relaxed mb-4">
                                {{ $product->subtitle ?: Str::limit($product->description, 110) }}
                            </p>
                        </div>

                        <div class="pt-3 border-t border-amber-500/20 space-y-2.5">
                            <div class="flex items-baseline justify-between">
                                <div class="flex items-baseline space-x-2">
                                    <span class="font-cinzel text-xl sm:text-2xl font-extrabold text-amber-300">
                                        {{ $product->formatted_price }}
                                    </span>
                                    @if($product->formatted_original_price)
                                        <span class="text-xs line-through text-amber-300/50">
                                            {{ $product->formatted_original_price }}
                                        </span>
                                    @endif
                                </div>
                                <span class="text-[10px] text-amber-200/60 font-medium">Taxes Included</span>
                            </div>

                            <div class="grid grid-cols-2 gap-2">
                                <button @click="openCheckout({{ $product->toJson() }})"
                                        class="py-2.5 px-3 rounded-xl font-cinzel font-bold text-xs uppercase tracking-wider text-[#1a1128] bg-gradient-to-r from-amber-300 via-yellow-400 to-amber-500 hover:from-amber-200 hover:to-yellow-300 shadow-md transition-all text-center flex items-center justify-center space-x-1">
                                    <span>⚡</span>
                                    <span>Book / Buy</span>
                                </button>

                                <a href="{{ route('shop.show', $product->slug) }}"
                                   class="py-2.5 px-3 rounded-xl font-cinzel font-semibold text-xs tracking-wider text-amber-200 border border-amber-500/30 hover:bg-amber-500/10 transition-colors text-center flex items-center justify-center">
                                    Details →
                                </a>
                            </div>

                            <div class="text-center">
                                <a href="https://wa.me/917907052160?text={{ rawurlencode('Namaskaram DR. E. K. Raja Varma, I would like to order: ' . $product->title . ' (' . $product->formatted_price . '). Please share payment & delivery details.') }}"
                                   target="_blank"
                                   class="text-[11px] text-emerald-400 hover:text-emerald-300 inline-flex items-center space-x-1">
                                    <span>💬</span>
                                    <span>Or order via WhatsApp (+91 7907052160)</span>
                                </a>
                            </div>
                        </div>
                    </div>
                @endforeach
            @endif
        </div>

        <!-- ========================================================================= -->
        <!-- INTERACTIVE DIGITAL FLIPBOOK EMBED: ഷഷ്ടാംഗം (Shashtangam)               -->
        <!-- Readable directly on site via FlipHTML5 interactive 3D page-flip engine   -->
        <!-- ========================================================================= -->
        <div id="flipbook-reader" class="mt-16 bg-[#160d26] border-2 border-amber-500/40 rounded-3xl p-6 sm:p-8 lg:p-10 shadow-2xl relative overflow-hidden">
            <!-- Ambient Glow -->
            <div class="absolute -top-20 -right-20 w-80 h-80 bg-amber-500/10 rounded-full blur-[100px] pointer-events-none"></div>
            <div class="absolute -bottom-20 -left-20 w-80 h-80 bg-purple-700/10 rounded-full blur-[100px] pointer-events-none"></div>

            <div class="relative z-10 space-y-6">
                <!-- Header & Info -->
                <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 pb-6 border-b border-amber-500/20">
                    <div class="space-y-1.5">
                        <div class="inline-flex items-center space-x-2 px-3 py-1 rounded-full text-[11px] font-bold uppercase tracking-wider bg-amber-500/15 text-amber-300 border border-amber-500/30">
                            <span class="w-2 h-2 rounded-full bg-emerald-400 animate-pulse"></span>
                            <span>Live Interactive Flipbook • ഓൺലൈൻ വായനശാല</span>
                        </div>
                        <h2 class="font-cinzel text-2xl sm:text-3xl lg:text-4xl font-extrabold text-white">
                            ഷഷ്ടാംഗം (Shashtangam) <span class="gold-gradient-text">— Digital Reader</span>
                        </h2>
                        <p class="text-xs sm:text-sm text-amber-200/80 font-medium">
                            15 മലയാള ചെറുകഥകളുടെ സമാഹാരം • ഡോ. ഇ. കെ. രാജ വർമ്മ (വിദ്യാ വാചസ്പതി)
                        </p>
                        <p class="text-[11px] text-zinc-400 max-w-2xl leading-relaxed">
                            Turn pages interactively using mouse click or touch swipe. Zoom in to read comfortably. Hardcover printed copies are available via courier across India & abroad.
                        </p>
                    </div>

                    <!-- Toolbar Actions -->
                    <div class="flex flex-wrap items-center gap-2.5 shrink-0">
                        <button type="button"
                                @click="flipbookModalOpen = true"
                                class="px-4 py-2.5 rounded-xl text-xs font-bold text-amber-200 bg-[#211335] border border-amber-500/40 hover:border-amber-300 hover:text-white transition-all flex items-center space-x-1.5 shadow">
                            <span>⛶</span>
                            <span>Fullscreen Mode</span>
                        </button>

                        <a href="https://wa.me/917907052160?text={{ rawurlencode("Namaskaram Dr. E. K. Raja Varma Sir, I am reading your book 'ഷഷ്ടാംഗം (Shashtangam)' online and would like to order an author-signed printed hardcover copy (Price: ₹150). Please share GPay/courier details.") }}"
                           target="_blank"
                           rel="noopener noreferrer"
                           class="px-5 py-2.5 rounded-xl font-cinzel font-bold text-xs uppercase tracking-wider text-[#1a1128] bg-gradient-to-r from-amber-300 via-yellow-400 to-amber-500 hover:from-amber-200 hover:to-yellow-300 shadow-xl transition-all flex items-center space-x-1.5 transform hover:-translate-y-0.5">
                            <span>🛒</span>
                            <span>Buy Signed Hardcover (₹150)</span>
                        </a>

                        <a href="https://online.fliphtml5.com/kvuzr/xfdb/"
                           target="_blank"
                           rel="noopener noreferrer"
                           class="p-2.5 rounded-xl text-xs text-amber-300 hover:text-white bg-[#0f0819] border border-amber-500/30 hover:border-amber-400 transition-colors"
                           title="Open in FlipHTML5 window">
                            ↗
                        </a>
                    </div>
                </div>

                <!-- Embedded Flipbook Iframe Container -->
                <div class="relative w-full rounded-2xl overflow-hidden border-2 border-amber-500/30 bg-black shadow-2xl">
                    <iframe src="https://online.fliphtml5.com/kvuzr/xfdb/"
                            class="w-full h-[620px] sm:h-[750px] lg:h-[840px] rounded-2xl"
                            seamless="seamless"
                            scrolling="no"
                            frameborder="0"
                            allowtransparency="true"
                            allowfullscreen="true"
                            webkitallowfullscreen="true"
                            mozallowfullscreen="true"></iframe>
                </div>

                <!-- Reader Navigation Tips & Helpline -->
                <div class="flex flex-col sm:flex-row items-center justify-between text-xs text-amber-200/70 pt-2 gap-3">
                    <div class="flex items-center space-x-2">
                        <span class="text-amber-400">💡 Tip:</span>
                        <span>Click the corners or drag to flip pages • Press the fullscreen icon inside the viewer for an immersive book reading experience.</span>
                    </div>
                    <div class="shrink-0 text-amber-300/80">
                        Publisher: <strong class="text-amber-200 font-semibold">Covilakam Digital Edition</strong>
                    </div>
                </div>
            </div>
        </div>

        <!-- Bottom Razorpay Trust Banner -->
        <div class="mt-16 bg-[#140b22] border border-amber-500/30 rounded-3xl p-6 sm:p-8 flex flex-col md:flex-row items-center justify-between gap-6 shadow-xl">
            <div class="space-y-1 text-center md:text-left">
                <h4 class="font-cinzel text-lg font-bold text-amber-300 flex items-center justify-center md:justify-start space-x-2">
                    <span>🛡️</span>
                    <span>Razorpay Compliant Merchant Store</span>
                </h4>
                <p class="text-xs text-amber-100/70 max-w-2xl leading-relaxed">
                    Compliant with RBI digital payment standards & Consumer Protection (E-Commerce) Rules. Transparent returns, free domestic shipping across India, and guaranteed privacy for your birth data.
                </p>
            </div>
            <div class="flex items-center space-x-3 shrink-0">
                <a href="{{ route('policies.refund') }}" class="text-xs text-amber-300 underline hover:text-amber-200">Refund Policy</a>
                <span class="text-amber-500">•</span>
                <a href="{{ route('policies.shipping') }}" class="text-xs text-amber-300 underline hover:text-amber-200">Shipping Policy</a>
                <span class="text-amber-500">•</span>
                <a href="{{ route('policies.terms') }}" class="text-xs text-amber-300 underline hover:text-amber-200">Terms</a>
            </div>
        </div>
    </div>

    <!-- Razorpay Checkout Modal -->
    <div x-show="checkoutModalOpen"
         x-cloak
         class="fixed inset-0 z-50 overflow-y-auto bg-black/80 backdrop-blur-md flex items-center justify-center p-4">
        <div @click.away="closeCheckout()"
             class="bg-[#1a1128] border border-amber-500/40 rounded-3xl max-w-xl w-full p-6 sm:p-8 shadow-2xl relative">

            <!-- Close Button -->
            <button @click="closeCheckout()"
                    class="absolute top-4 right-4 p-2 text-amber-400 hover:text-amber-200 text-lg">
                ✕
            </button>

            <!-- Modal Header -->
            <div class="border-b border-amber-500/20 pb-4 mb-6">
                <span class="text-[10px] uppercase font-bold text-amber-400 tracking-wider">Checkout with Razorpay</span>
                <h3 class="font-cinzel text-xl font-bold text-amber-300 mt-0.5" x-text="selectedProduct?.title"></h3>
                <div class="flex items-center justify-between mt-2 text-xs">
                    <span class="text-amber-200/70" x-text="selectedProduct?.type === 'book' ? 'Physical Book Dispatch' : (selectedProduct?.type === 'digital_pdf' ? 'Instant Digital PDF Download' : 'Personal Consultation')"></span>
                    <span class="font-cinzel font-bold text-lg text-amber-300" x-text="selectedProduct?.formatted_price"></span>
                </div>
            </div>

            <!-- Error Banner -->
            <div x-show="errorMessage" class="mb-4 p-3 rounded-xl bg-red-500/20 border border-red-500/30 text-red-200 text-xs" x-text="errorMessage"></div>

            <!-- Checkout Form -->
            <div class="space-y-4 text-xs sm:text-sm">
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                    <div>
                        <label class="block text-xs font-semibold text-amber-300 uppercase mb-1">Full Name *</label>
                        <input type="text" x-model="customerName" placeholder="Your Name"
                               class="w-full px-3.5 py-2.5 rounded-xl bg-[#0f0819] border border-amber-500/30 text-amber-100 text-xs focus:border-amber-400 focus:outline-none">
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-amber-300 uppercase mb-1">WhatsApp Phone *</label>
                        <input type="tel" x-model="customerPhone" placeholder="+91 9876543210"
                               class="w-full px-3.5 py-2.5 rounded-xl bg-[#0f0819] border border-amber-500/30 text-amber-100 text-xs focus:border-amber-400 focus:outline-none">
                    </div>
                </div>

                <div>
                    <label class="block text-xs font-semibold text-amber-300 uppercase mb-1">Email Address (for Invoice & PDF Copy)</label>
                    <input type="email" x-model="customerEmail" placeholder="yourname@gmail.com"
                           class="w-full px-3.5 py-2.5 rounded-xl bg-[#0f0819] border border-amber-500/30 text-amber-100 text-xs focus:border-amber-400 focus:outline-none">
                </div>

                <!-- Shipping Address field (Only for Physical Books) -->
                <template x-if="selectedProduct?.type === 'book'">
                    <div>
                        <label class="block text-xs font-semibold text-amber-300 uppercase mb-1">Shipping Delivery Address (with PIN Code) *</label>
                        <textarea x-model="shippingAddress" rows="3" placeholder="House/Flat No, Street, City, State, PIN Code"
                                  class="w-full px-3.5 py-2.5 rounded-xl bg-[#0f0819] border border-amber-500/30 text-amber-100 text-xs focus:border-amber-400 focus:outline-none"></textarea>
                        <p class="text-[10px] text-emerald-400 mt-1">✓ Dispatched within 24-48 hours via India Post Speed Post (Free Shipping)</p>
                    </div>
                </template>

                <!-- Birth Details Fields (For Digital Jathakam PDF & Consultations) -->
                <template x-if="selectedProduct?.type === 'digital_pdf' || selectedProduct?.type === 'consultation'">
                    <div class="p-3.5 rounded-xl bg-[#0f0819] border border-amber-500/25 space-y-3">
                        <span class="text-xs font-bold text-amber-300 block">Horoscope Birth Details for Calculation:</span>
                        <div class="grid grid-cols-1 sm:grid-cols-3 gap-2.5">
                            <div>
                                <label class="block text-[10px] text-amber-200/80 mb-0.5">Date of Birth</label>
                                <input type="date" x-model="birthDate"
                                       class="w-full px-2.5 py-1.5 rounded-lg bg-[#1a1128] border border-amber-500/30 text-amber-100 text-xs">
                            </div>
                            <div>
                                <label class="block text-[10px] text-amber-200/80 mb-0.5">Time of Birth</label>
                                <input type="text" x-model="birthTime" placeholder="e.g. 10:45 AM"
                                       class="w-full px-2.5 py-1.5 rounded-lg bg-[#1a1128] border border-amber-500/30 text-amber-100 text-xs">
                            </div>
                            <div>
                                <label class="block text-[10px] text-amber-200/80 mb-0.5">Place of Birth</label>
                                <input type="text" x-model="birthPlace" placeholder="City / Kerala"
                                       class="w-full px-2.5 py-1.5 rounded-lg bg-[#1a1128] border border-amber-500/30 text-amber-100 text-xs">
                            </div>
                        </div>
                    </div>
                </template>

                <!-- Proceed to Razorpay Button -->
                <button @click="submitOrder()"
                        :disabled="loading"
                        class="w-full mt-4 py-3.5 rounded-xl font-cinzel font-bold text-sm tracking-wider uppercase text-[#1a1128] bg-gradient-to-r from-amber-300 via-yellow-400 to-amber-500 hover:from-amber-200 hover:to-yellow-300 shadow-xl transition-all flex items-center justify-center space-x-2 disabled:opacity-50">
                    <span x-show="!loading">Proceed to Razorpay Secure Pay (<span x-text="selectedProduct?.formatted_price"></span>)</span>
                    <span x-show="loading" class="flex items-center space-x-2">
                        <svg class="animate-spin h-4 w-4 text-[#1a1128]" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8H4z"></path>
                        </svg>
                        <span>Opening Razorpay...</span>
                    </span>
                </button>

                <!-- Security Trust Footer inside Modal -->
                <div class="text-center pt-2 text-[10px] text-amber-200/60">
                    🔒 256-Bit SSL Encrypted • Powered by Razorpay • UPI, Cards & NetBanking
                </div>
            </div>
        </div>
    </div>

    <!-- ========================================================================= -->
    <!-- FULLSCREEN DISTRACTION-FREE DIGITAL FLIPBOOK LIGHTBOX MODAL               -->
    <!-- ========================================================================= -->
    <div x-show="flipbookModalOpen"
         x-cloak
         class="fixed inset-0 z-50 bg-black/95 backdrop-blur-xl flex flex-col p-2 sm:p-4"
         role="dialog" aria-modal="true">
        <!-- Top bar -->
        <div class="flex items-center justify-between px-3 sm:px-6 py-3 border-b border-amber-500/30 bg-[#140b22] rounded-t-2xl">
            <div class="flex items-center space-x-3">
                <span class="w-2.5 h-2.5 rounded-full bg-emerald-400 animate-pulse"></span>
                <div>
                    <h3 class="text-amber-300 font-cinzel font-bold text-sm sm:text-base">
                        ഷഷ്ടാംഗം (Shashtangam) — Fullscreen Reading Lounge
                    </h3>
                    <p class="text-[11px] text-amber-200/60 hidden sm:block">
                        15 ചെറുകഥകളുടെ സമാഹാരം • ഡോ. ഇ. കെ. രാജ വർമ്മ (വിദ്യാ വാചസ്പതി)
                    </p>
                </div>
            </div>

            <div class="flex items-center space-x-2 sm:space-x-3">
                <a href="https://wa.me/917907052160?text={{ rawurlencode("Namaskaram Dr. E. K. Raja Varma Sir, I am reading 'ഷഷ്ടാംഗം (Shashtangam)' online and would like to order an author-signed printed copy (Price: ₹150). Please share GPay/delivery details.") }}"
                   target="_blank"
                   rel="noopener noreferrer"
                   class="px-3 sm:px-4 py-1.5 rounded-xl font-cinzel font-bold text-xs uppercase tracking-wider text-[#1a1128] bg-gradient-to-r from-amber-300 via-yellow-400 to-amber-500 hover:from-amber-200 hover:to-yellow-300 shadow transition-all">
                    🛒 Buy Copy (₹150)
                </a>

                <button type="button"
                        @click="flipbookModalOpen = false"
                        class="px-3 py-1.5 rounded-xl text-xs font-semibold text-amber-200 bg-white/10 hover:bg-white/20 hover:text-white transition-colors">
                    ✕ Close
                </button>
            </div>
        </div>

        <!-- Fullscreen Frame -->
        <div class="flex-1 w-full h-full p-1 bg-black rounded-b-2xl overflow-hidden border border-amber-500/20">
            <iframe src="https://online.fliphtml5.com/kvuzr/xfdb/"
                    class="w-full h-full rounded-xl"
                    seamless="seamless"
                    scrolling="no"
                    frameborder="0"
                    allowtransparency="true"
                    allowfullscreen="true"></iframe>
        </div>
    </div>
</div>

<!-- Load Razorpay Checkout Script -->
<script src="https://checkout.razorpay.com/v1/checkout.js"></script>
@endsection

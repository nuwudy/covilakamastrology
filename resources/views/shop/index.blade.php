@extends('layouts.app')

@section('title', 'Vedic Bookstore & Astrology Services | Covilakam Astrology')
@section('meta_description', 'Official Bookstore & Services Shop of DR. E. K. Raja Varma (Vidya Vachaspathi in Vedic Astrology). Buy authoritative Kerala Vedic astrology books, download Deluxe 30-Page Jathakam PDFs, and book consultations via secure Razorpay checkout.')

@section('content')
<div class="pt-32 pb-24 bg-[#0d0716] min-h-screen text-amber-100/90 relative overflow-hidden"
     x-data="{
        activeTab: '{{ $type ?? 'all' }}',
        checkoutModalOpen: false,
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
                <span>📚 Covilakam Vedic Bookstore & Digital Services</span>
            </div>
            <h1 class="font-cinzel text-3xl sm:text-5xl font-extrabold text-amber-300 tracking-wide">
                Authentic Vedic Astrology Books & Services
            </h1>
            <p class="text-xs sm:text-sm text-amber-200/70 mt-3 leading-relaxed">
                Directly published and authorized by <strong>DR. E. K. Raja Varma (Vidya Vachaspathi in Vedic Astrology, 2026 Gold Medalist & Ph.D.)</strong>. Free shipping across India on physical books, instant downloads for Deluxe Jathakam PDFs, and certified matrimonial match reports.
            </p>

            <!-- Razorpay Compliance Trust Bar -->
            <div class="mt-6 flex flex-wrap items-center justify-center gap-3 sm:gap-6 text-[11px] text-amber-200/80">
                <span class="flex items-center space-x-1.5 bg-[#1a1128] px-3 py-1.5 rounded-full border border-amber-500/20">
                    <span class="text-emerald-400">✓</span>
                    <span>100% Razorpay Secure Payments</span>
                </span>
                <span class="flex items-center space-x-1.5 bg-[#1a1128] px-3 py-1.5 rounded-full border border-amber-500/20">
                    <span class="text-amber-400">⚡</span>
                    <span>UPI • GPay • Cards • NetBanking</span>
                </span>
                <span class="flex items-center space-x-1.5 bg-[#1a1128] px-3 py-1.5 rounded-full border border-amber-500/20">
                    <span class="text-emerald-400">📦</span>
                    <span>Free Speed Post Delivery in India</span>
                </span>
            </div>
        </div>

        <!-- Filter Category Tabs -->
        <div class="flex items-center justify-center mb-10 overflow-x-auto pb-2">
            <div class="inline-flex p-1.5 rounded-2xl bg-[#140b22] border border-amber-500/20 space-x-1 sm:space-x-2">
                <a href="{{ route('shop.index', ['type' => 'all']) }}"
                   class="px-4 py-2 rounded-xl text-xs sm:text-sm font-semibold transition-all whitespace-nowrap {{ ($type ?? 'all') === 'all' ? 'bg-gradient-to-r from-amber-400 to-yellow-500 text-[#1a1128] shadow-md font-bold' : 'text-amber-200/70 hover:text-amber-100 hover:bg-amber-500/10' }}">
                    All Items ({{ $products->count() }})
                </a>
                <a href="{{ route('shop.index', ['type' => 'book']) }}"
                   class="px-4 py-2 rounded-xl text-xs sm:text-sm font-semibold transition-all whitespace-nowrap {{ ($type ?? '') === 'book' ? 'bg-gradient-to-r from-amber-400 to-yellow-500 text-[#1a1128] shadow-md font-bold' : 'text-amber-200/70 hover:text-amber-100 hover:bg-amber-500/10' }}">
                    📖 Vedic Books (Physical)
                </a>
                <a href="{{ route('shop.index', ['type' => 'digital_pdf']) }}"
                   class="px-4 py-2 rounded-xl text-xs sm:text-sm font-semibold transition-all whitespace-nowrap {{ ($type ?? '') === 'digital_pdf' ? 'bg-gradient-to-r from-amber-400 to-yellow-500 text-[#1a1128] shadow-md font-bold' : 'text-amber-200/70 hover:text-amber-100 hover:bg-amber-500/10' }}">
                    📱 Deluxe Jathakam (PDF)
                </a>
                <a href="{{ route('shop.index', ['type' => 'consultation']) }}"
                   class="px-4 py-2 rounded-xl text-xs sm:text-sm font-semibold transition-all whitespace-nowrap {{ ($type ?? '') === 'consultation' ? 'bg-gradient-to-r from-amber-400 to-yellow-500 text-[#1a1128] shadow-md font-bold' : 'text-amber-200/70 hover:text-amber-100 hover:bg-amber-500/10' }}">
                    🔮 Consultations & Porutham
                </a>
            </div>
        </div>

        <!-- Products Multi-Column Grid (No awkward single column banner) -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 sm:gap-8">
            @forelse($products as $product)
                @php
                    $isFeatured = ($product->slug === 'kerala-jyothisha-deepika');
                @endphp
                <div class="bg-[#140b22] rounded-3xl p-5 sm:p-6 flex flex-col justify-between transition-all duration-300 shadow-xl group hover:shadow-2xl hover:shadow-amber-500/10 {{ $isFeatured ? 'border-2 border-amber-400 ring-1 ring-amber-400/50 shadow-amber-500/15 relative' : 'border border-amber-500/25 hover:border-amber-400/60' }}">

                    @if($isFeatured)
                        <div class="absolute -top-3 left-6 px-3 py-1 rounded-full text-[10px] font-extrabold uppercase tracking-wider bg-gradient-to-r from-amber-400 via-yellow-300 to-amber-500 text-[#1a1128] shadow-lg flex items-center space-x-1 z-20">
                            <span>★</span>
                            <span>FLAGSHIP BESTSELLER</span>
                        </div>
                    @endif

                    <div>
                        <!-- Product Image Box (Authentic Portrait Frame) -->
                        <div class="relative rounded-2xl overflow-hidden bg-[#0d0716] border border-amber-500/20 aspect-[3/4] max-h-80 mb-5 flex items-center justify-center p-3">
                            <img src="{{ asset($product->image_path) }}"
                                 alt="{{ $product->title }}"
                                 class="w-full h-full object-contain rounded-xl transform group-hover:scale-105 transition-transform duration-300">

                            @if($product->badge)
                                <span class="absolute top-3 left-3 px-2.5 py-1 rounded-full text-[10px] font-bold bg-amber-400 text-[#1a1128] shadow-md">
                                    {{ $product->badge }}
                                </span>
                            @endif

                            <span class="absolute top-3 right-3 px-2.5 py-0.5 rounded text-[10px] font-semibold bg-[#1a1128]/95 text-amber-200 border border-amber-500/40 uppercase tracking-wider shadow">
                                {{ $product->type === 'book' ? '📖 Hardcover' : ($product->type === 'digital_pdf' ? '📱 Instant PDF' : '🔮 Consultation') }}
                            </span>
                        </div>

                        <!-- Product Titles -->
                        <div class="space-y-1 mb-2.5">
                            <h3 class="font-cinzel text-lg sm:text-xl font-bold text-amber-200 group-hover:text-amber-300 transition-colors line-clamp-1">
                                {{ $product->title }}
                            </h3>
                            @if($product->title_ml)
                                <p class="text-xs text-amber-400 font-medium">
                                    {{ $product->title_ml }}
                                </p>
                            @endif
                        </div>

                        <!-- Author attribution -->
                        <p class="text-[11px] text-amber-300/80 font-medium mb-3 flex items-center space-x-1">
                            <span>✍️</span>
                            <span>DR. E. K. Raja Varma (Vidya Vachaspathi)</span>
                        </p>

                        <!-- Subtitle / Short description -->
                        <p class="text-xs text-amber-100/75 line-clamp-2 leading-relaxed mb-4">
                            {{ $product->subtitle ?: Str::limit($product->description, 110) }}
                        </p>

                        <!-- Key Specs list -->
                        @if(!empty($product->details))
                            <div class="bg-[#1a1128] p-3 rounded-xl border border-amber-500/15 text-[11px] text-amber-200/80 space-y-1.5 mb-4">
                                @if(isset($product->details['delivery_time']))
                                    <div class="flex items-center justify-between">
                                        <span class="text-amber-400 font-medium">Delivery:</span>
                                        <span class="text-emerald-400 font-semibold">{{ $product->details['delivery_time'] }}</span>
                                    </div>
                                @endif
                                @if(isset($product->details['format']))
                                    <div class="flex items-center justify-between">
                                        <span class="text-amber-400 font-medium">Format:</span>
                                        <span>{{ $product->details['format'] }}</span>
                                    </div>
                                @endif
                                @if(isset($product->details['pages']))
                                    <div class="flex items-center justify-between">
                                        <span class="text-amber-400 font-medium">Pages:</span>
                                        <span>{{ $product->details['pages'] }}</span>
                                    </div>
                                @endif
                            </div>
                        @endif
                    </div>

                    <!-- Price & Actions Footer -->
                    <div class="pt-4 border-t border-amber-500/20 space-y-3">
                        <div class="flex items-baseline justify-between">
                            <div class="flex items-baseline space-x-2">
                                <span class="font-cinzel text-2xl sm:text-3xl font-extrabold text-amber-300">
                                    {{ $product->formatted_price }}
                                </span>
                                @if($product->formatted_original_price)
                                    <span class="text-xs line-through text-amber-300/50">
                                        {{ $product->formatted_original_price }}
                                    </span>
                                    <span class="text-[10px] font-bold text-emerald-400 px-1.5 py-0.5 rounded bg-emerald-500/10 border border-emerald-500/20">
                                        {{ $product->discount_percentage }}% OFF
                                    </span>
                                @endif
                            </div>
                            <span class="text-[10px] text-amber-200/60 font-medium">Taxes Included</span>
                        </div>

                        <!-- Action Buttons -->
                        <div class="grid grid-cols-2 gap-2.5">
                            <button @click="openCheckout({{ $product->toJson() }})"
                                    class="py-2.5 px-3 rounded-xl font-cinzel font-bold text-xs uppercase tracking-wider text-[#1a1128] bg-gradient-to-r from-amber-300 via-yellow-400 to-amber-500 hover:from-amber-200 hover:to-yellow-300 shadow-md transition-all text-center flex items-center justify-center space-x-1">
                                <span>⚡</span>
                                <span>Buy Now</span>
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
            @empty
                <div class="col-span-1 sm:col-span-2 lg:col-span-3 text-center py-16 bg-[#140b22] rounded-3xl border border-amber-500/20">
                    <p class="text-base text-amber-200/70">No items found in this category.</p>
                    <a href="{{ route('shop.index') }}" class="inline-block mt-3 px-4 py-2 rounded-xl text-xs font-bold text-[#1a1128] bg-amber-400 hover:bg-amber-300">
                        View All Items
                    </a>
                </div>
            @endforelse
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
</div>

<!-- Load Razorpay Checkout Script -->
<script src="https://checkout.razorpay.com/v1/checkout.js"></script>
@endsection

@extends('layouts.app')

@section('title', $product->title . ' | Covilakam Astrology Bookstore')
@section('meta_description', Str::limit($product->description, 155))

@section('content')
<div class="pt-32 pb-24 bg-[#0d0716] min-h-screen text-amber-100/90 relative overflow-hidden"
     x-data="{
        checkoutModalOpen: false,
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

        openCheckout() {
            this.checkoutModalOpen = true;
            this.errorMessage = '';
        },

        closeCheckout() {
            this.checkoutModalOpen = false;
            this.errorMessage = '';
        },

        async submitOrder() {
            if (!this.customerName || !this.customerPhone) {
                this.errorMessage = 'Please provide your Full Name and WhatsApp Phone Number.';
                return;
            }

            if ('{{ $product->type }}' === 'book' && !this.shippingAddress) {
                this.errorMessage = 'Please provide your shipping delivery address.';
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
                        product_id: {{ $product->id }},
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
                    throw new Error(data.message || data.error || 'Failed to initialize order.');
                }

                if (!data.key_id) {
                    throw new Error('Razorpay Key ID is not loaded. Please run php artisan optimize:clear on the server.');
                }

                const self = this;
                if (typeof Razorpay !== 'undefined') {
                    const options = {
                        key: data.key_id,
                        amount: data.amount,
                        currency: data.currency || 'INR',
                        name: 'Covilakam Astrology',
                        description: '{{ $product->title }}',
                        image: '{{ asset('images/og-covilakam-512x512.png') }}',
                        order_id: data.order_id || data.razorpay_order_id,
                        prefill: {
                            name: data.customer_name,
                            contact: data.customer_phone,
                            email: data.customer_email || ''
                        },
                        theme: {
                            color: '#d97706'
                        },
                        modal: {
                            ondismiss: function () {
                                self.loading = false;
                                self.errorMessage = 'Payment was cancelled. You can try again whenever you are ready.';
                            }
                        },
                        handler: async function (response) {
                            try {
                                self.loading = true;
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
                                if (verifyRes.ok && verifyData.success) {
                                    window.location.href = verifyData.redirect_url;
                                } else {
                                    self.errorMessage = 'Verification Error: ' + (verifyData.message || verifyData.error || 'Payment signature mismatch.');
                                }
                            } catch (vErr) {
                                self.errorMessage = 'Network error verifying payment: ' + vErr.message;
                            } finally {
                                self.loading = false;
                            }
                        }
                    };

                    const rzp = new Razorpay(options);

                    rzp.on('payment.failed', function (resp) {
                        self.loading = false;
                        const errorReason = resp.error?.description || resp.error?.reason || 'Payment failed.';
                        self.errorMessage = 'Payment Failed: ' + errorReason;
                    });

                    rzp.open();
                } else {
                    throw new Error('Razorpay checkout SDK could not be loaded.');
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

    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
        <!-- Breadcrumb -->
        <nav class="flex items-center space-x-2 text-xs text-amber-300/70 mb-6">
            <a href="{{ route('home') }}" class="hover:text-amber-200">Home</a>
            <span>/</span>
            <a href="{{ route('shop.index') }}" class="hover:text-amber-200">Bookstore & Services</a>
            <span>/</span>
            <span class="text-amber-300 truncate">{{ $product->title }}</span>
        </nav>

        <!-- Product Hero Card -->
        <div class="bg-[#140b22] border border-amber-500/30 rounded-3xl p-6 sm:p-10 shadow-2xl mb-12">
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 lg:gap-12 items-start">
                <!-- Left: Product Image Box -->
                <div class="lg:col-span-5 text-center">
                    <div class="relative inline-block max-w-sm mx-auto">
                        <div class="rounded-2xl overflow-hidden shadow-2xl border border-amber-500/40 bg-[#0d0716] p-2">
                            <img src="{{ asset($product->image_path) }}"
                                 alt="{{ $product->title }}"
                                 class="w-full h-auto object-cover rounded-xl">
                        </div>

                        @if($product->badge)
                            <div class="absolute top-4 left-4 px-3 py-1 rounded-full text-xs font-bold bg-amber-400 text-[#1a1128] shadow-lg">
                                {{ $product->badge }}
                            </div>
                        @endif
                    </div>

                    <!-- Payment Badges below image -->
                    <div class="mt-6 p-4 rounded-xl bg-[#1a1128] border border-amber-500/20 text-[11px] text-amber-200/70 text-center space-y-1">
                        <p class="font-semibold text-amber-300">🛡️ 100% Razorpay Buyer Protection</p>
                        <p>UPI • Google Pay • PhonePe • Paytm • Cards • NetBanking</p>
                    </div>
                </div>

                <!-- Right: Product Information & Purchase Form -->
                <div class="lg:col-span-7 space-y-6">
                    <div>
                        <div class="flex items-center space-x-2 mb-2">
                            <span class="px-2.5 py-0.5 rounded-full text-[11px] font-semibold bg-amber-500/15 text-amber-300 border border-amber-500/30 uppercase">
                                {{ $product->type === 'book' ? 'Physical Hardcover Book' : ($product->type === 'digital_pdf' ? 'Instant Digital Download' : 'Astrological Service') }}
                            </span>
                            @if($product->type === 'book')
                                <span class="text-xs text-emerald-400 font-medium">Free Speed Post in India</span>
                            @endif
                        </div>

                        <h1 class="font-cinzel text-2xl sm:text-4xl font-extrabold text-amber-300">
                            {{ $product->title }}
                        </h1>
                        @if($product->title_ml)
                            <p class="text-base text-amber-400/90 font-medium mt-1">
                                {{ $product->title_ml }}
                            </p>
                        @endif

                        <p class="text-xs text-amber-200/70 mt-1 font-sans">
                            Author: <strong>DR. E. K. Raja Varma</strong> (Vidya Vachaspathi in Vedic Astrology)
                        </p>
                    </div>

                    <!-- Pricing Display -->
                    <div class="p-4 rounded-2xl bg-[#1a1128] border border-amber-500/25 flex flex-wrap items-baseline justify-between gap-2">
                        <div class="flex items-baseline space-x-3">
                            <span class="font-cinzel text-3xl font-extrabold text-amber-300">
                                {{ $product->formatted_price }}
                            </span>
                            @if($product->formatted_original_price)
                                <span class="text-sm line-through text-amber-300/50">
                                    {{ $product->formatted_original_price }}
                                </span>
                                <span class="text-xs font-bold text-emerald-400 px-2 py-0.5 rounded bg-emerald-500/10 border border-emerald-500/20">
                                    Save {{ $product->discount_percentage }}%
                                </span>
                            @endif
                        </div>
                        <span class="text-xs text-amber-200/60 font-medium">Inclusive of all taxes</span>
                    </div>

                    <!-- Description -->
                    <div class="space-y-3 text-xs sm:text-sm text-amber-100/85 leading-relaxed">
                        <p>{{ $product->description }}</p>
                    </div>

                    <!-- Product Specifications / Key Inclusions -->
                    @if(!empty($product->details))
                        <div class="bg-[#1a1128] p-5 rounded-2xl border border-amber-500/20 space-y-3">
                            <h3 class="font-cinzel text-sm font-bold text-amber-300 uppercase tracking-wider">
                                Specifications & Details
                            </h3>
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-2.5 text-xs">
                                @foreach($product->details as $key => $val)
                                    @if(is_string($val))
                                        <div class="flex flex-col">
                                            <span class="text-[10px] text-amber-400 uppercase font-semibold">{{ str_replace('_', ' ', $key) }}</span>
                                            <span class="text-amber-100/90">{{ $val }}</span>
                                        </div>
                                    @endif
                                @endforeach
                            </div>

                            @if(isset($product->details['key_topics']) || isset($product->details['key_inclusions']))
                                <div class="pt-3 border-t border-amber-500/15">
                                    <span class="text-xs font-bold text-amber-300 block mb-2">Key Highlights:</span>
                                    <ul class="space-y-1.5 text-xs text-amber-100/80">
                                        @foreach(($product->details['key_topics'] ?? $product->details['key_inclusions']) as $item)
                                            <li class="flex items-start space-x-2">
                                                <span class="text-amber-400 mt-0.5">✦</span>
                                                <span>{{ $item }}</span>
                                            </li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif
                        </div>
                    @endif

                    <!-- Purchase Actions -->
                    <div class="space-y-3 pt-2">
                        <button @click="openCheckout()"
                                class="w-full py-4 px-6 rounded-xl font-cinzel font-bold text-sm tracking-wider uppercase text-[#1a1128] bg-gradient-to-r from-amber-300 via-yellow-400 to-amber-500 hover:from-amber-200 hover:to-yellow-300 shadow-xl transition-all transform hover:-translate-y-0.5 flex items-center justify-center space-x-2">
                            <span>⚡</span>
                            <span>Order Now via Razorpay ({{ $product->formatted_price }})</span>
                        </button>

                        <a href="https://wa.me/917907052160?text={{ rawurlencode('Namaskaram DR. E. K. Raja Varma, I would like to order: ' . $product->title . ' (' . $product->formatted_price . '). Please guide me.') }}"
                           target="_blank"
                           class="w-full py-3 px-6 rounded-xl text-xs font-medium text-emerald-300 border border-emerald-500/30 hover:bg-emerald-500/10 transition-colors flex items-center justify-center space-x-2">
                            <span>💬</span>
                            <span>Order / Inquire via WhatsApp (+91 7907052160)</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Related Recommendations -->
        @if($relatedProducts->count() > 0)
            <div class="mt-16">
                <h3 class="font-cinzel text-xl font-bold text-amber-300 mb-6 text-center sm:text-left">
                    You May Also Like
                </h3>
                <div class="grid grid-cols-1 sm:grid-cols-3 gap-6">
                    @foreach($relatedProducts as $rel)
                        <a href="{{ route('shop.show', $rel->slug) }}"
                           class="bg-[#140b22] p-4 rounded-2xl border border-amber-500/20 hover:border-amber-400/50 transition-all group block shadow-lg">
                            <div class="aspect-[4/3] rounded-xl overflow-hidden bg-[#0d0716] p-2 mb-3">
                                <img src="{{ asset($rel->image_path) }}"
                                     alt="{{ $rel->title }}"
                                     class="w-full h-full object-contain group-hover:scale-105 transition-transform duration-300">
                            </div>
                            <h4 class="font-cinzel text-sm font-bold text-amber-200 group-hover:text-amber-300 truncate">
                                {{ $rel->title }}
                            </h4>
                            <div class="flex items-center justify-between mt-2">
                                <span class="font-cinzel font-bold text-amber-300 text-sm">{{ $rel->formatted_price }}</span>
                                <span class="text-[10px] text-amber-400">View →</span>
                            </div>
                        </a>
                    @endforeach
                </div>
            </div>
        @endif
    </div>

    <!-- Razorpay Checkout Modal -->
    <div x-show="checkoutModalOpen"
         x-cloak
         class="fixed inset-0 z-50 overflow-y-auto bg-black/80 backdrop-blur-md flex items-center justify-center p-4">
        <div @click.away="closeCheckout()"
             class="bg-[#1a1128] border border-amber-500/40 rounded-3xl max-w-xl w-full p-6 sm:p-8 shadow-2xl relative">

            <button @click="closeCheckout()"
                    class="absolute top-4 right-4 p-2 text-amber-400 hover:text-amber-200 text-lg">
                ✕
            </button>

            <div class="border-b border-amber-500/20 pb-4 mb-6">
                <span class="text-[10px] uppercase font-bold text-amber-400 tracking-wider">Razorpay Secure Checkout</span>
                <h3 class="font-cinzel text-xl font-bold text-amber-300 mt-0.5">{{ $product->title }}</h3>
                <div class="flex items-center justify-between mt-2 text-xs">
                    <span class="text-amber-200/70">{{ $product->type === 'book' ? 'Physical Hardcover Dispatch' : ($product->type === 'digital_pdf' ? 'Instant Digital PDF Download' : 'Consultation Booking') }}</span>
                    <span class="font-cinzel font-bold text-lg text-amber-300">{{ $product->formatted_price }}</span>
                </div>
            </div>

            <div x-show="errorMessage" class="mb-4 p-3 rounded-xl bg-red-500/20 border border-red-500/30 text-red-200 text-xs" x-text="errorMessage"></div>

            <div class="space-y-4 text-xs sm:text-sm">
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                    <div>
                        <label class="block text-xs font-semibold text-amber-300 uppercase mb-1">Full Name *</label>
                        <input type="text" x-model="customerName" placeholder="Your Full Name"
                               class="w-full px-3.5 py-2.5 rounded-xl bg-[#0f0819] border border-amber-500/30 text-amber-100 text-xs focus:border-amber-400 focus:outline-none">
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-amber-300 uppercase mb-1">WhatsApp Phone *</label>
                        <input type="tel" x-model="customerPhone" placeholder="+91 9876543210"
                               class="w-full px-3.5 py-2.5 rounded-xl bg-[#0f0819] border border-amber-500/30 text-amber-100 text-xs focus:border-amber-400 focus:outline-none">
                    </div>
                </div>

                <div>
                    <label class="block text-xs font-semibold text-amber-300 uppercase mb-1">Email Address</label>
                    <input type="email" x-model="customerEmail" placeholder="yourname@gmail.com"
                           class="w-full px-3.5 py-2.5 rounded-xl bg-[#0f0819] border border-amber-500/30 text-amber-100 text-xs focus:border-amber-400 focus:outline-none">
                </div>

                @if($product->type === 'book')
                    <div>
                        <label class="block text-xs font-semibold text-amber-300 uppercase mb-1">Shipping Delivery Address (with PIN Code) *</label>
                        <textarea x-model="shippingAddress" rows="3" placeholder="House/Flat No, Street, City, State, PIN Code"
                                  class="w-full px-3.5 py-2.5 rounded-xl bg-[#0f0819] border border-amber-500/30 text-amber-100 text-xs focus:border-amber-400 focus:outline-none"></textarea>
                        <p class="text-[10px] text-emerald-400 mt-1">✓ Dispatched within 24-48 hours via India Post Speed Post (Free Delivery)</p>
                    </div>
                @endif

                @if($product->type === 'digital_pdf' || $product->type === 'consultation')
                    <div class="p-3.5 rounded-xl bg-[#0f0819] border border-amber-500/25 space-y-3">
                        <span class="text-xs font-bold text-amber-300 block">Horoscope Birth Details:</span>
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
                @endif

                <button @click="submitOrder()"
                        :disabled="loading"
                        class="w-full mt-4 py-3.5 rounded-xl font-cinzel font-bold text-sm tracking-wider uppercase text-[#1a1128] bg-gradient-to-r from-amber-300 via-yellow-400 to-amber-500 hover:from-amber-200 hover:to-yellow-300 shadow-xl transition-all flex items-center justify-center space-x-2 disabled:opacity-50">
                    <span x-show="!loading">Pay with Razorpay ({{ $product->formatted_price }})</span>
                    <span x-show="loading" class="flex items-center space-x-2">
                        <svg class="animate-spin h-4 w-4 text-[#1a1128]" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8H4z"></path>
                        </svg>
                        <span>Opening Razorpay...</span>
                    </span>
                </button>

                <div class="text-center pt-2 text-[10px] text-amber-200/60">
                    🔒 256-Bit SSL Encrypted • Powered by Razorpay • UPI, Cards & NetBanking
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://checkout.razorpay.com/v1/checkout.js"></script>
@endsection

@extends('layouts.app')

@section('title', 'Razorpay Standard Checkout • Covilakam Astrology')

@section('content')
<div class="min-h-screen bg-[#070502] text-[#fbf6ea] py-12 px-4 sm:px-6 lg:px-8 relative overflow-hidden"
     x-data="razorpayCheckout({
         keyId: '{{ $keyId }}',
         merchantName: '{{ $merchantName }}'
     })">

    <!-- Ambient Glow Effects -->
    <div class="absolute -top-32 left-1/2 -translate-x-1/2 w-[650px] h-[380px] bg-gradient-to-b from-amber-500/10 via-amber-700/5 to-transparent blur-3xl pointer-events-none rounded-full"></div>
    <div class="absolute bottom-10 right-10 w-96 h-96 bg-amber-600/5 blur-3xl pointer-events-none rounded-full"></div>

    <div class="max-w-2xl mx-auto relative z-10">

        <!-- Top Breadcrumb & Badge -->
        <div class="text-center mb-8">
            <span class="inline-flex items-center gap-2 px-3 py-1 rounded-full text-xs font-semibold uppercase tracking-wider bg-amber-500/10 border border-amber-500/20 text-amber-300 mb-3">
                <svg class="w-3.5 h-3.5 text-amber-400" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 1.944A11.954 11.954 0 012.166 5C2.056 5.649 2 6.319 2 7c0 5.225 3.34 9.67 8 11.317C14.66 16.67 18 12.225 18 7c0-.682-.057-1.35-.166-2.001A11.954 11.954 0 0110 1.944zM11 14a1 1 0 11-2 0 1 1 0 012 0zm0-7a1 1 0 10-2 0v3a1 1 0 102 0V7z" clip-rule="evenodd"/>
                </svg>
                Razorpay Standard Checkout (UPI • Cards • NetBanking)
            </span>
            <h1 class="text-3xl sm:text-4xl font-cinzel font-bold text-transparent bg-clip-text bg-gradient-to-r from-amber-200 via-amber-400 to-amber-100 tracking-wide">
                Secure Payment Gateway
            </h1>
            <p class="mt-2 text-sm text-stone-400 max-w-lg mx-auto">
                Official Razorpay Standard Checkout integration with backend order creation and cryptographic HMAC-SHA256 signature verification.
            </p>
        </div>

        <!-- Checkout Card -->
        <div class="bg-[#120d06]/90 border border-amber-500/25 rounded-2xl shadow-2xl p-6 sm:p-8 backdrop-blur-md relative">

            <!-- Notification Messages -->
            <!-- Error Banner -->
            <div x-show="errorMessage"
                 x-cloak
                 x-transition
                 class="mb-6 p-4 rounded-xl bg-red-950/70 border border-red-500/40 text-red-200 flex items-start gap-3">
                <svg class="w-5 h-5 text-red-400 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                </svg>
                <div class="text-sm">
                    <p class="font-semibold text-red-300">Checkout Error</p>
                    <p x-text="errorMessage" class="mt-0.5 leading-relaxed"></p>
                </div>
            </div>

            <!-- Success Banner -->
            <div x-show="successMessage"
                 x-cloak
                 x-transition
                 class="mb-6 p-4 rounded-xl bg-emerald-950/70 border border-emerald-500/40 text-emerald-200 flex items-start gap-3">
                <svg class="w-5 h-5 text-emerald-400 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                <div class="text-sm">
                    <p class="font-semibold text-emerald-300">Payment Verified Successfully!</p>
                    <p x-text="successMessage" class="mt-0.5 leading-relaxed"></p>
                    <template x-if="verifiedPayment">
                        <div class="mt-2 text-xs font-mono bg-black/40 p-2.5 rounded border border-emerald-500/20 space-y-1 text-emerald-100">
                            <div><strong>Payment ID:</strong> <span x-text="verifiedPayment.payment_id"></span></div>
                            <div><strong>Order ID:</strong> <span x-text="verifiedPayment.order_id"></span></div>
                            <div><strong>Status:</strong> <span class="text-emerald-400 font-bold uppercase">Signature Verified (HMAC-SHA256)</span></div>
                        </div>
                    </template>
                </div>
            </div>

            <form @submit.prevent="initiatePayment" class="space-y-6">

                <!-- Amount Selection Section -->
                <div>
                    <label class="block text-xs uppercase tracking-wider font-semibold text-amber-300 mb-2">
                        Select / Enter Amount (INR ₹)
                    </label>

                    <!-- Quick Preset Buttons -->
                    <div class="grid grid-cols-4 gap-2 mb-3">
                        <button type="button"
                                @click="amountInRupees = 1; updatePaise()"
                                :class="amountInRupees === 1 ? 'border-amber-400 bg-amber-500/20 text-amber-200' : 'border-stone-800 bg-stone-900/60 text-stone-300 hover:border-amber-500/40'"
                                class="py-2 px-3 text-xs font-medium rounded-lg border transition text-center">
                            ₹1 <span class="text-[10px] opacity-75 block font-normal">(Test 100p)</span>
                        </button>
                        <button type="button"
                                @click="amountInRupees = 100; updatePaise()"
                                :class="amountInRupees === 100 ? 'border-amber-400 bg-amber-500/20 text-amber-200' : 'border-stone-800 bg-stone-900/60 text-stone-300 hover:border-amber-500/40'"
                                class="py-2 px-3 text-xs font-medium rounded-lg border transition text-center">
                            ₹100 <span class="text-[10px] opacity-75 block font-normal">(Dakshina)</span>
                        </button>
                        <button type="button"
                                @click="amountInRupees = 500; updatePaise()"
                                :class="amountInRupees === 500 ? 'border-amber-400 bg-amber-500/20 text-amber-200' : 'border-stone-800 bg-stone-900/60 text-stone-300 hover:border-amber-500/40'"
                                class="py-2 px-3 text-xs font-medium rounded-lg border transition text-center">
                            ₹500 <span class="text-[10px] opacity-75 block font-normal">(Book/Service)</span>
                        </button>
                        <button type="button"
                                @click="amountInRupees = 1500; updatePaise()"
                                :class="amountInRupees === 1500 ? 'border-amber-400 bg-amber-500/20 text-amber-200' : 'border-stone-800 bg-stone-900/60 text-stone-300 hover:border-amber-500/40'"
                                class="py-2 px-3 text-xs font-medium rounded-lg border transition text-center">
                            ₹1,500 <span class="text-[10px] opacity-75 block font-normal">(Consultation)</span>
                        </button>
                    </div>

                    <!-- Custom Amount Input -->
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-amber-400 font-semibold">₹</span>
                        <input type="number"
                               min="1"
                               step="1"
                               x-model.number="amountInRupees"
                               @input="updatePaise()"
                               class="w-full bg-[#181108] border border-amber-500/30 rounded-xl pl-9 pr-24 py-3 text-white font-mono text-lg focus:outline-none focus:ring-2 focus:ring-amber-400 focus:border-amber-400 transition"
                               placeholder="100"
                               required>
                        <span class="absolute inset-y-0 right-0 pr-3.5 flex items-center pointer-events-none text-xs text-stone-400 font-mono">
                            <span x-text="amountInPaise"></span> paise
                        </span>
                    </div>
                    <p class="text-[11px] text-stone-500 mt-1">Minimum checkout amount is ₹1.00 (100 paise) as enforced by Razorpay API.</p>
                </div>

                <!-- Customer Details Grid -->
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs uppercase tracking-wider font-semibold text-stone-300 mb-1.5">
                            Customer Name <span class="text-amber-400">*</span>
                        </label>
                        <input type="text"
                               x-model="customer.name"
                               class="w-full bg-[#181108] border border-stone-800 rounded-xl px-3.5 py-2.5 text-sm text-stone-200 focus:outline-none focus:ring-2 focus:ring-amber-500/50 focus:border-amber-500"
                               placeholder="e.g. Ananthu Varma"
                               required>
                    </div>

                    <div>
                        <label class="block text-xs uppercase tracking-wider font-semibold text-stone-300 mb-1.5">
                            Phone Number <span class="text-amber-400">*</span>
                        </label>
                        <input type="tel"
                               x-model="customer.phone"
                               class="w-full bg-[#181108] border border-stone-800 rounded-xl px-3.5 py-2.5 text-sm text-stone-200 focus:outline-none focus:ring-2 focus:ring-amber-500/50 focus:border-amber-500"
                               placeholder="e.g. 9847000000"
                               required>
                    </div>

                    <div class="sm:col-span-2">
                        <label class="block text-xs uppercase tracking-wider font-semibold text-stone-300 mb-1.5">
                            Email Address <span class="text-stone-500">(Optional for receipt)</span>
                        </label>
                        <input type="email"
                               x-model="customer.email"
                               class="w-full bg-[#181108] border border-stone-800 rounded-xl px-3.5 py-2.5 text-sm text-stone-200 focus:outline-none focus:ring-2 focus:ring-amber-500/50 focus:border-amber-500"
                               placeholder="customer@example.com">
                    </div>
                </div>

                <!-- Checkout Summary Box -->
                <div class="bg-black/40 border border-amber-500/20 rounded-xl p-4 text-xs space-y-1.5 text-stone-300">
                    <div class="flex justify-between">
                        <span>Merchant:</span>
                        <span class="font-semibold text-amber-200" x-text="merchantName"></span>
                    </div>
                    <div class="flex justify-between">
                        <span>Gateway:</span>
                        <span class="text-stone-400">Razorpay Standard Checkout (v1)</span>
                    </div>
                    <div class="flex justify-between">
                        <span>Currency:</span>
                        <span class="text-stone-300 font-mono">INR (₹)</span>
                    </div>
                    <div class="flex justify-between pt-2 border-t border-amber-500/20 text-sm font-semibold">
                        <span class="text-amber-300">Total Payable:</span>
                        <span class="text-amber-300 font-mono" x-text="'₹' + amountInRupees.toFixed(2)"></span>
                    </div>
                </div>

                <!-- Action Button -->
                <button type="submit"
                        :disabled="loading"
                        class="w-full py-4 px-6 rounded-xl font-cinzel font-bold text-sm tracking-wider uppercase bg-gradient-to-r from-amber-500 via-amber-600 to-amber-700 hover:from-amber-400 hover:to-amber-600 text-stone-950 shadow-lg shadow-amber-900/40 hover:shadow-amber-700/50 transition-all flex items-center justify-center gap-3 disabled:opacity-60 disabled:cursor-not-allowed">
                    <!-- Loading Spinner -->
                    <template x-if="loading">
                        <svg class="animate-spin -ml-1 mr-2 h-5 w-5 text-stone-950" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                        </svg>
                    </template>
                    <span x-text="loading ? 'Processing with Razorpay...' : 'Pay with Razorpay (₹' + amountInRupees.toFixed(2) + ')'"></span>
                </button>

                <!-- Footer Trust Badges -->
                <div class="text-center pt-2">
                    <p class="text-[11px] text-stone-400 flex items-center justify-center gap-2">
                        <svg class="w-4 h-4 text-emerald-400" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z" clip-rule="evenodd"/>
                        </svg>
                        <span>256-Bit SSL Encrypted • Powered by Razorpay Standard Checkout</span>
                    </p>
                </div>
            </form>

        </div>

        <!-- Integration Specs Quick Box for Developers/Testing -->
        <div class="mt-8 p-4 rounded-xl bg-black/40 border border-stone-800 text-xs text-stone-400">
            <h3 class="text-xs uppercase font-bold text-amber-300 tracking-wider mb-2">Integration Specifications</h3>
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-2 text-[11px] font-mono">
                <div>• POST /api/create-order</div>
                <div>• POST /api/verify-payment</div>
                <div>• Algorithm: HMAC-SHA256</div>
                <div>• Script: checkout.razorpay.com/v1</div>
            </div>
        </div>

    </div>
</div>

<!-- STEP 2: Razorpay Standard Checkout JS Script -->
<script src="https://checkout.razorpay.com/v1/checkout.js"></script>

<script>
document.addEventListener('alpine:init', () => {
    Alpine.data('razorpayCheckout', (config) => ({
        keyId: config.keyId || '',
        merchantName: config.merchantName || 'Covilakam Astrology',
        amountInRupees: 100,
        amountInPaise: 10000,
        customer: {
            name: 'Ananthu Varma',
            phone: '9847123456',
            email: 'client@covilakamastrology.com'
        },
        loading: false,
        errorMessage: null,
        successMessage: null,
        verifiedPayment: null,

        updatePaise() {
            this.amountInPaise = Math.round(Number(this.amountInRupees) * 100);
        },

        async initiatePayment() {
            this.errorMessage = null;
            this.successMessage = null;
            this.verifiedPayment = null;

            if (this.amountInPaise < 100) {
                this.errorMessage = 'Minimum amount is 100 paise (₹1.00).';
                return;
            }

            this.loading = true;

            try {
                // STEP 1: Call Backend to Create Razorpay Order
                const createResponse = await fetch('/api/create-order', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                    },
                    body: JSON.stringify({
                        amount: this.amountInPaise,
                        currency: 'INR',
                        receipt: 'rcpt_' + Date.now(),
                        notes: {
                            customer_name: this.customer.name,
                            customer_phone: this.customer.phone,
                        }
                    })
                });

                const orderData = await createResponse.json();

                if (!createResponse.ok || !orderData.order_id) {
                    throw new Error(orderData.error || orderData.message || 'Failed to create order on server.');
                }

                const self = this;
                const activeKeyId = orderData.key_id || self.keyId;

                // STEP 2: Open Razorpay Modal with order_id
                const options = {
                    key: activeKeyId,
                    amount: orderData.amount,
                    currency: orderData.currency || 'INR',
                    name: self.merchantName,
                    description: 'Astrology Services / Consultation / Book Order',
                    image: '/images/og-covilakam-512x512.png',
                    order_id: orderData.order_id,
                    prefill: {
                        name: self.customer.name,
                        contact: self.customer.phone,
                        email: self.customer.email
                    },
                    theme: {
                        color: '#d97706'
                    },
                    modal: {
                        ondismiss: function () {
                            self.loading = false;
                            self.errorMessage = 'Payment was cancelled by the user. You can try again when ready.';
                        }
                    },
                    handler: async function (response) {
                        // On success: receive razorpay_payment_id, razorpay_order_id, razorpay_signature
                        await self.verifyPaymentSignature({
                            order_id: response.razorpay_order_id,
                            payment_id: response.razorpay_payment_id,
                            signature: response.razorpay_signature
                        });
                    }
                };

                const rzp = new Razorpay(options);

                // Handle payment.failed event
                rzp.on('payment.failed', function (failResp) {
                    self.loading = false;
                    const errDesc = failResp.error?.description || failResp.error?.reason || 'Transaction could not be completed.';
                    self.errorMessage = 'Payment Failed: ' + errDesc;
                });

                rzp.open();

            } catch (err) {
                this.loading = false;
                this.errorMessage = err.message || 'An unexpected error occurred during checkout.';
            }
        },

        // STEP 3: Call Backend to Verify Payment Signature
        async verifyPaymentSignature(paymentDetails) {
            try {
                this.loading = true;
                const verifyRes = await fetch('/api/verify-payment', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                    },
                    body: JSON.stringify(paymentDetails)
                });

                const verifyData = await verifyRes.json();

                if (verifyRes.ok && verifyData.success) {
                    this.successMessage = 'Your payment of ₹' + this.amountInRupees.toFixed(2) + ' was received and cryptographically verified.';
                    this.verifiedPayment = {
                        payment_id: paymentDetails.payment_id,
                        order_id: paymentDetails.order_id,
                    };
                } else {
                    this.errorMessage = 'Signature Verification Failed: ' + (verifyData.error || verifyData.message || 'Signature mismatch.');
                }
            } catch (vErr) {
                this.errorMessage = 'Error communicating with verification endpoint: ' + vErr.message;
            } finally {
                this.loading = false;
            }
        }
    }));
});
</script>
@endsection

@extends('layouts.app')

@section('title', 'Shipping & Delivery Policy | Covilakam Astrology')
@section('meta_description', 'Official Shipping and Delivery Policy for Covilakam Astrology. Dispatch timeframes for Vedic books across India, instant download delivery for digital Jathakam PDFs, and courier tracking information.')

@section('content')
<div class="pt-32 pb-24 bg-[#0d0716] min-h-screen text-amber-100/90 relative overflow-hidden">
    <!-- Subtle Golden Background Glow -->
    <div class="absolute inset-0 bg-radial from-amber-600/5 via-transparent to-transparent pointer-events-none"></div>

    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
        <!-- Breadcrumb -->
        <nav class="flex items-center space-x-2 text-xs text-amber-300/70 mb-6">
            <a href="{{ route('home') }}" class="hover:text-amber-200">Home</a>
            <span>/</span>
            <span class="text-amber-300">Shipping & Delivery Policy</span>
        </nav>

        <!-- Page Header -->
        <div class="border-b border-amber-500/20 pb-8 mb-10">
            <div class="inline-flex items-center space-x-2 px-3 py-1 rounded-full border border-amber-500/30 bg-amber-500/10 text-amber-300 text-xs font-semibold mb-4">
                <span>📦 Reliable Dispatch & Instant Digital Delivery</span>
            </div>
            <h1 class="font-cinzel text-3xl sm:text-4xl font-bold text-amber-300 tracking-wide">
                Shipping & Delivery Policy
            </h1>
            <p class="text-xs text-amber-200/60 mt-2">
                Last Updated: October 2026 • Covers Physical Vedic Books & Digital Jathakam Reports
            </p>
        </div>

        <!-- Content -->
        <div class="space-y-8 text-sm leading-relaxed text-amber-100/80">
            <!-- Part 1: Physical Books -->
            <section class="space-y-4">
                <div class="flex items-center space-x-2">
                    <span class="text-2xl">📚</span>
                    <h2 class="font-cinzel text-2xl font-bold text-amber-200">Part A: Physical Books (Vedic Astrology Publications)</h2>
                </div>
                <p>
                    All printed Vedic literature, hardcover compendiums, and matrimonial reference books authored by <strong>DR. E. K. Raja Varma (Vidya Vachaspathi in Vedic Astrology)</strong> are packed securely in moisture-proof, damage-resistant corrugated packaging to ensure they arrive in pristine condition.
                </p>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-4 pt-2">
                    <div class="bg-[#1a1128] p-4 rounded-xl border border-amber-500/20">
                        <span class="text-xs text-amber-400 font-semibold uppercase block mb-1">Dispatch Window</span>
                        <p class="text-lg font-bold text-amber-200">Within 24–48 Hours</p>
                        <p class="text-xs text-amber-100/70 mt-1">Orders are packed and handed over to the courier partner on working days (Mon–Sat).</p>
                    </div>

                    <div class="bg-[#1a1128] p-4 rounded-xl border border-amber-500/20">
                        <span class="text-xs text-amber-400 font-semibold uppercase block mb-1">Domestic Delivery Timeline</span>
                        <p class="text-lg font-bold text-amber-200">3 to 7 Business Days</p>
                        <p class="text-xs text-amber-100/70 mt-1">Kerala & South India: 2–4 days. Rest of India: 4–7 days depending on destination PIN code.</p>
                    </div>

                    <div class="bg-[#1a1128] p-4 rounded-xl border border-amber-500/20">
                        <span class="text-xs text-amber-400 font-semibold uppercase block mb-1">Shipping Charges</span>
                        <p class="text-lg font-bold text-emerald-400">FREE Shipping</p>
                        <p class="text-xs text-amber-100/70 mt-1">Complimentary free domestic courier across all serviceable PIN codes in India.</p>
                    </div>
                </div>

                <div class="space-y-2 text-xs sm:text-sm text-amber-100/80 pt-2">
                    <p><strong>Courier Partners:</strong> We ship primarily via <strong>India Post Speed Post</strong>, <strong>DTDC</strong>, and <strong>Professional Couriers</strong> to reach every town and village across India.</p>
                    <p><strong>Consignment Tracking:</strong> As soon as your parcel is dispatched, a consignment tracking number and real-time tracking link will be sent to your registered WhatsApp number and email address.</p>
                    <p><strong>International Shipping:</strong> For clients residing in UAE, Gulf countries, UK, USA, Singapore, and Europe, please contact us directly on WhatsApp (+91 7907052160) for international DHL/India Post International Airmail postage rates.</p>
                </div>
            </section>

            <!-- Part 2: Digital Downloads -->
            <section class="space-y-4 border-t border-amber-500/20 pt-8">
                <div class="flex items-center space-x-2">
                    <span class="text-2xl">📱</span>
                    <h2 class="font-cinzel text-2xl font-bold text-amber-200">Part B: Digital Jathakam PDF Reports & Online Services</h2>
                </div>
                <p>
                    For digital horoscope purchases, there are no physical goods or shipping delays:
                </p>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 pt-2">
                    <div class="bg-[#1a1128] p-4 rounded-xl border border-amber-500/20">
                        <span class="text-amber-300 font-bold block mb-1">1. Instant Browser Download:</span>
                        <p class="text-xs text-amber-100/70">
                            Upon successful payment completion via Razorpay, you will be automatically redirected to the Order Confirmation page where a high-resolution, printable PDF version of your personalized Deluxe Vedic Jathakam is available for immediate download.
                        </p>
                    </div>

                    <div class="bg-[#1a1128] p-4 rounded-xl border border-amber-500/20">
                        <span class="text-amber-300 font-bold block mb-1">2. WhatsApp & Email Copy:</span>
                        <p class="text-xs text-amber-100/70">
                            An encrypted copy of the Jathakam PDF document along with your order invoice is also dispatched directly to the WhatsApp number and email address provided during checkout within <strong>15 to 30 minutes</strong>.
                        </p>
                    </div>
                </div>

                <div class="bg-amber-500/10 border border-amber-500/25 p-4 rounded-xl text-xs sm:text-sm text-amber-200">
                    <p class="font-bold text-amber-300 mb-1">⏱️ Astrologer-Verified Handwritten / Bespoke Charts:</p>
                    <p>
                        If your order includes personalized astrologer verification or manual Porutham compatibility review by DR. E. K. Raja Varma, the finalized signed report will be delivered within <strong>12 to 24 hours</strong> of receiving complete birth data.
                    </p>
                </div>
            </section>

            <!-- Support -->
            <section class="space-y-3 border-t border-amber-500/20 pt-6">
                <h2 class="font-cinzel text-xl font-bold text-amber-200">Order & Shipping Support</h2>
                <p>If you experience any delay in courier transit or difficulty downloading your digital Jathakam PDF, our helpline is ready to assist you:</p>
                <div class="bg-[#1a1128] p-5 rounded-2xl border border-amber-500/20 text-xs sm:text-sm space-y-1.5">
                    <p><strong>WhatsApp Support:</strong> <a href="https://wa.me/917907052160" target="_blank" class="text-emerald-400 font-semibold">+91 7907052160</a> (Include your Order Number)</p>
                    <p><strong>Email:</strong> <a href="mailto:varmaji@covilakamastrology.com" class="text-amber-300">varmaji@covilakamastrology.com</a></p>
                    <p><strong>Customer Care:</strong> 094473 27450 / +91 9447327450</p>
                </div>
            </section>
        </div>
    </div>
</div>
@endsection

@extends('layouts.app')

@section('title', 'Cancellation & Refund Policy | Covilakam Astrology')
@section('meta_description', 'Official Cancellation, Return and Refund Policy for Covilakam Astrology. Clear terms for consultation cancellations, physical book returns, digital Jathakam PDF adjustments, and Razorpay refund timelines.')

@section('content')
<div class="pt-32 pb-24 bg-[#0d0716] min-h-screen text-amber-100/90 relative overflow-hidden">
    <!-- Subtle Golden Background Glow -->
    <div class="absolute inset-0 bg-radial from-amber-600/5 via-transparent to-transparent pointer-events-none"></div>

    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
        <!-- Breadcrumb -->
        <nav class="flex items-center space-x-2 text-xs text-amber-300/70 mb-6">
            <a href="{{ route('home') }}" class="hover:text-amber-200">Home</a>
            <span>/</span>
            <span class="text-amber-300">Cancellation & Refund Policy</span>
        </nav>

        <!-- Page Header -->
        <div class="border-b border-amber-500/20 pb-8 mb-10">
            <div class="inline-flex items-center space-x-2 px-3 py-1 rounded-full border border-amber-500/30 bg-amber-500/10 text-amber-300 text-xs font-semibold mb-4">
                <span>🔄 Fair & Transparent Return Guidelines</span>
            </div>
            <h1 class="font-cinzel text-3xl sm:text-4xl font-bold text-amber-300 tracking-wide">
                Cancellation & Refund Policy
            </h1>
            <p class="text-xs text-amber-200/60 mt-2">
                Last Updated: October 2026 • Razorpay Merchant Compliant Service Terms
            </p>
        </div>

        <!-- Content -->
        <div class="space-y-8 text-sm leading-relaxed text-amber-100/80">
            <div class="p-4 rounded-xl border border-amber-500/30 bg-amber-500/10 text-xs sm:text-sm">
                <p class="font-semibold text-amber-300 mb-1">Our Customer Satisfaction Commitment:</p>
                <p>
                    At <strong>Covilakam Astrology</strong>, directed by <strong>DR. E. K. Raja Varma (Vidya Vachaspathi in Vedic Astrology)</strong>, we take pride in authentic Vedic scholarship and fair merchant ethics. We have structured this policy to be completely transparent regarding how cancellations, returns, and refunds are handled across our physical books, personalized consultations, and digital Jathakam downloads.
                </p>
            </div>

            <!-- Section 1: Consultations -->
            <section class="space-y-3">
                <h2 class="font-cinzel text-xl font-bold text-amber-200">1. Astrological Consultations (Voice / WhatsApp / In-Person)</h2>
                <ul class="list-disc pl-5 space-y-2 text-xs sm:text-sm text-amber-100/80">
                    <li><strong>Advance Cancellation (Full Refund):</strong> If you wish to cancel a paid astrological consultation, you may do so up to <strong>24 hours prior</strong> to the scheduled appointment time. A <strong>100% full refund</strong> will be initiated without questions.</li>
                    <li><strong>Free Rescheduling:</strong> If an unforeseen circumstance arises, you may reschedule your appointment to another convenient date and time at no additional charge by notifying us via WhatsApp (+91 7907052160) at least 4 hours in advance.</li>
                    <li><strong>Post-Consultation:</strong> Once an astrological consultation session with DR. E. K. Raja Varma has been completed, the consultation fee is non-refundable as the astrologer's professional time, esoteric study, and personalized reading have been fully rendered. However, we offer 7 days of complimentary WhatsApp follow-up clarifications on the points discussed during your reading.</li>
                </ul>
            </section>

            <!-- Section 2: Physical Books -->
            <section class="space-y-3">
                <h2 class="font-cinzel text-xl font-bold text-amber-200">2. Vedic Astrology Books (Physical Bookstore Orders)</h2>
                <ul class="list-disc pl-5 space-y-2 text-xs sm:text-sm text-amber-100/80">
                    <li><strong>Order Cancellation Before Dispatch:</strong> You may cancel a physical book order at any time before it has been dispatched from our publishing unit (typically within 24 hours of placing the order) for a <strong>100% full refund</strong>.</li>
                    <li><strong>7-Day Damaged / Defective Replacement Guarantee:</strong> If a book delivered to you arrives with transit damage, torn binding, missing pages, or misprinting, notify us within <strong>7 days of delivery</strong> with photos via WhatsApp (+91 7907052160) or email. We will ship a brand new replacement copy immediately at zero extra cost, or issue a full refund if preferred.</li>
                    <li><strong>Return Shipping:</strong> In case of eligible returns due to transit defects, return courier pickup charges will be borne entirely by Covilakam Astrology.</li>
                </ul>
            </section>

            <!-- Section 3: Digital Jathakam PDF Reports -->
            <section class="space-y-3">
                <h2 class="font-cinzel text-xl font-bold text-amber-200">3. Digital Jathakam (Horoscope) PDF Reports</h2>
                <ul class="list-disc pl-5 space-y-2 text-xs sm:text-sm text-amber-100/80">
                    <li>Because personalized digital Jathakam PDFs are intangible intellectual products customized mathematically to individual birth details and delivered instantly or via WhatsApp/email, they are generally <strong>non-refundable once generated</strong>.</li>
                    <li><strong>Typographical Error Correction Guarantee:</strong> If you accidentally entered an incorrect birth time, date, or place when purchasing the report, contact us within <strong>7 days</strong> with the correct details. We will regenerate and deliver your corrected Deluxe Jathakam PDF report completely free of charge.</li>
                    <li><strong>Failed Generation / Duplicate Payment:</strong> If a technical issue occurs where you were charged twice or your digital report failed to generate, a full refund for the duplicate or failed charge will be processed immediately upon notice.</li>
                </ul>
            </section>

            <!-- Section 4: Refund Processing & Timelines -->
            <section class="space-y-3">
                <h2 class="font-cinzel text-xl font-bold text-amber-200">4. Refund Method & Processing Timelines via Razorpay</h2>
                <p>
                    All approved refunds are credited directly back to the <strong>original source of payment</strong> (Credit Card, Debit Card, NetBanking, or UPI VPA) through the Razorpay payment gateway network:
                </p>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 pt-2">
                    <div class="bg-[#1a1128] p-4 rounded-xl border border-amber-500/20">
                        <span class="text-amber-300 font-bold block mb-1">UPI & Google Pay / PhonePe:</span>
                        <p class="text-xs text-amber-100/70">Typically credited back to your linked bank account within <strong>24 to 48 hours</strong>.</p>
                    </div>
                    <div class="bg-[#1a1128] p-4 rounded-xl border border-amber-500/20">
                        <span class="text-amber-300 font-bold block mb-1">Debit & Credit Cards / NetBanking:</span>
                        <p class="text-xs text-amber-100/70">Processed by Razorpay and credited by your issuing bank within <strong>5 to 7 business days</strong>.</p>
                    </div>
                </div>
            </section>

            <!-- Section 5: How to Request a Refund -->
            <section class="space-y-3 border-t border-amber-500/20 pt-6">
                <h2 class="font-cinzel text-xl font-bold text-amber-200">5. How to Request Cancellation or Refund</h2>
                <p>To request a cancellation or refund, simply share your <strong>Order Number</strong> (e.g., <code>COV-ORD-XXXX</code>) or Razorpay Payment ID with us through any of the following channels:</p>
                <div class="bg-[#1a1128] p-5 rounded-2xl border border-amber-500/20 text-xs sm:text-sm space-y-2">
                    <p><strong>Primary WhatsApp Support:</strong> <a href="https://wa.me/917907052160" target="_blank" class="text-emerald-400 font-semibold">+91 7907052160</a> (Fastest response within 2-4 hours)</p>
                    <p><strong>Official Email:</strong> <a href="mailto:varmaji@covilakamastrology.com" class="text-amber-300">varmaji@covilakamastrology.com</a></p>
                    <p><strong>Phone Support:</strong> 094473 27450 / +91 9447327450 (Mon - Sat, 9:00 AM to 8:00 PM IST)</p>
                    <p><strong>Mailing Address:</strong> Covilakam Astrology, Kerala, India (PIN: 686574)</p>
                </div>
            </section>
        </div>
    </div>
</div>
@endsection

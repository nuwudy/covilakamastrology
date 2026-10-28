@extends('layouts.app')

@section('title', 'Terms and Conditions | Covilakam Astrology')
@section('meta_description', 'Official Terms and Conditions for Covilakam Astrology, directed by Dr. E. K. Raja Varma (Vidya Vachaspathi in Vedic Astrology). Covers consultation services, Vedic books, digital Jathakam downloads, and Razorpay secure payment terms.')

@section('content')
<div class="pt-32 pb-24 bg-[#0d0716] min-h-screen text-amber-100/90 relative overflow-hidden">
    <!-- Subtle Golden Background Glow -->
    <div class="absolute inset-0 bg-radial from-amber-600/5 via-transparent to-transparent pointer-events-none"></div>

    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
        <!-- Breadcrumb -->
        <nav class="flex items-center space-x-2 text-xs text-amber-300/70 mb-6">
            <a href="{{ route('home') }}" class="hover:text-amber-200">Home</a>
            <span>/</span>
            <span class="text-amber-300">Terms & Conditions</span>
        </nav>

        <!-- Page Header -->
        <div class="border-b border-amber-500/20 pb-8 mb-10">
            <div class="inline-flex items-center space-x-2 px-3 py-1 rounded-full border border-amber-500/30 bg-amber-500/10 text-amber-300 text-xs font-semibold mb-4">
                <span>⚖️ Legal & Service Agreement</span>
            </div>
            <h1 class="font-cinzel text-3xl sm:text-4xl font-bold text-amber-300 tracking-wide">
                Terms and Conditions
            </h1>
            <p class="text-xs text-amber-200/60 mt-2">
                Last Updated: October 2026 • Effective for Covilakam Astrology (Kovilakam Astrology)
            </p>
        </div>

        <!-- Content -->
        <div class="space-y-8 text-sm leading-relaxed text-amber-100/80">
            <section class="space-y-3">
                <h2 class="font-cinzel text-xl font-bold text-amber-200">1. Introduction & Acceptance of Terms</h2>
                <p>
                    Welcome to <strong>Covilakam Astrology</strong> (also known as <em>Kovilakam Astrology</em> / <em>കോവിലകം ജ്യോതിഷം</em>), accessible at <a href="{{ url('/') }}" class="text-amber-300 underline">{{ url('/') }}</a>. These Terms and Conditions govern your use of our portal, including the booking of personal Vedic astrological consultations, purchase and dispatch of Vedic astrology books, and digital ordering/download of personalized Jathakam (Horoscope) PDF reports directed by <strong>Dr. E. K. Raja Varma (Vidya Vachaspathi in Vedic Astrology, Gold Medalist & Ph.D.)</strong>.
                </p>
                <p>
                    By accessing our website, placing an order, or booking a consultation, you acknowledge that you have read, understood, and agree to be bound by these Terms and Conditions in full. If you do not agree with any part of these terms, please do not use our services.
                </p>
            </section>

            <section class="space-y-3">
                <h2 class="font-cinzel text-xl font-bold text-amber-200">2. Description of Services & Products</h2>
                <ul class="list-disc pl-5 space-y-1.5 text-xs sm:text-sm text-amber-100/80">
                    <li><strong>Personal Astrological Consultations:</strong> One-on-one astrological guidance conducted via WhatsApp, voice call, video call, or in-person sessions based on traditional Kerala Parashara and Ashtamangala Prasnam methodologies.</li>
                    <li><strong>Digital Jathakam PDF Reports:</strong> Bespoke horoscope calculation documents generated using ancient astronomical and algorithmic principles, containing Rasi, Navamsha, and 25-year Dasa-Bhukthi timelines.</li>
                    <li><strong>Vedic Astrology Books:</strong> Printed physical publications authored and published by Dr. E. K. Raja Varma and Covilakam Vedic Publications, dispatched via Indian postal/courier services.</li>
                </ul>
            </section>

            <section class="space-y-3">
                <h2 class="font-cinzel text-xl font-bold text-amber-200">3. Pricing & Currency</h2>
                <p>
                    All prices for consultations, physical books, and digital reports are clearly displayed on our website in <strong>Indian Rupees (INR - ₹)</strong> and are inclusive of all applicable statutory taxes. We reserve the right to revise our fee structure at any time without prior notice, provided that confirmed orders will be honored at the price quoted at the time of purchase.
                </p>
            </section>

            <section class="space-y-3">
                <h2 class="font-cinzel text-xl font-bold text-amber-200">4. Payment Processing via Razorpay</h2>
                <p>
                    We have partnered with <strong>Razorpay Software Private Limited</strong>, a PCI-DSS Level 1 compliant payment gateway, to provide secure, encrypted online payments. By initiating a payment, you agree to:
                </p>
                <ul class="list-disc pl-5 space-y-1.5 text-xs sm:text-sm text-amber-100/80">
                    <li>Pay using legitimate payment instruments (UPI, Google Pay, PhonePe, Debit Cards, Credit Cards, or NetBanking).</li>
                    <li>Ensure sufficient funds or credit balance at the time of transaction.</li>
                    <li>Acknowledge that Covilakam Astrology does not store, process, or view your sensitive card numbers, CVV codes, or UPI MPINs on our servers.</li>
                </ul>
            </section>

            <section class="space-y-3">
                <h2 class="font-cinzel text-xl font-bold text-amber-200">5. Nature of Astrological Guidance & Disclaimer</h2>
                <div class="p-4 rounded-xl border border-amber-500/30 bg-amber-500/10 text-xs sm:text-sm">
                    <p class="font-semibold text-amber-300 mb-1">⚠️ Important Advisory Notice:</p>
                    <p>
                        Vedic Astrology (Jyothisha Shastra) is a traditional, interpretive cosmic science offering probability trends and spiritual insights. Astrological readings, Jathakam reports, and counselling provided by Dr. E. K. Raja Varma are intended for guidance, spiritual upliftment, and self-reflection. They are not intended as a substitute for professional legal, medical, psychiatric, or financial counsel. Customers are advised to exercise their own discretion and free will when making important life decisions.
                    </p>
                </div>
            </section>

            <section class="space-y-3">
                <h2 class="font-cinzel text-xl font-bold text-amber-200">6. Accuracy of Birth Information Provided by Customer</h2>
                <p>
                    Accurate astrological calculations strictly depend on the correctness of the Date of Birth, Exact Time of Birth, and Place of Birth provided by the client. Covilakam Astrology is not responsible for predictive discrepancies arising from erroneous, estimated, or unverified birth data entered by the customer.
                </p>
            </section>

            <section class="space-y-3">
                <h2 class="font-cinzel text-xl font-bold text-amber-200">7. Intellectual Property Rights</h2>
                <p>
                    All content on this website, including book manuscripts, cover artwork, proprietary calculation scripts, Jathakam formats, articles, and brand logos, is the exclusive intellectual property of <strong>Dr. E. K. Raja Varma and Covilakam Astrology</strong>. Unauthorized reproduction, distribution, scanning, or commercial reselling is strictly prohibited under the Copyright Act, 1957.
                </p>
            </section>

            <section class="space-y-3">
                <h2 class="font-cinzel text-xl font-bold text-amber-200">8. Governing Law & Dispute Jurisdiction</h2>
                <p>
                    These Terms and Conditions shall be governed by and construed in accordance with the substantive laws of <strong>India</strong>. Any disputes, claims, or controversies arising out of or relating to your use of this portal or services shall be subject to the exclusive jurisdiction of the competent civil courts in <strong>Kerala, India</strong>.
                </p>
            </section>

            <section class="space-y-3 border-t border-amber-500/20 pt-6">
                <h2 class="font-cinzel text-xl font-bold text-amber-200">9. Merchant Contact Details</h2>
                <div class="bg-[#1a1128] p-5 rounded-2xl border border-amber-500/20 text-xs sm:text-sm space-y-1.5">
                    <p><strong>Merchant / Practice Name:</strong> Covilakam Astrology (Kovilakam Astrology)</p>
                    <p><strong>Directing Astrologer:</strong> Dr. E. K. Raja Varma (Vidya Vachaspathi in Vedic Astrology)</p>
                    <p><strong>Operating Address:</strong> Covilakam Astrology, Kerala, India (PIN: 686574)</p>
                    <p><strong>Primary WhatsApp:</strong> +91 7907052160</p>
                    <p><strong>Phone / GPay:</strong> 094473 27450 / +91 9447327450</p>
                    <p><strong>Official Email:</strong> varmaji@covilakamastrology.com / ekrvarma@gmail.com</p>
                </div>
            </section>
        </div>
    </div>
</div>
@endsection

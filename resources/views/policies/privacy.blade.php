@extends('layouts.app')

@section('title', 'Privacy Policy | Covilakam Astrology')
@section('meta_description', 'Official Privacy Policy of Covilakam Astrology. Learn how we safeguard your birth data, personal contact details, and secure online transactions processed through Razorpay.')

@section('content')
<div class="pt-32 pb-24 bg-[#0d0716] min-h-screen text-amber-100/90 relative overflow-hidden">
    <!-- Subtle Golden Background Glow -->
    <div class="absolute inset-0 bg-radial from-amber-600/5 via-transparent to-transparent pointer-events-none"></div>

    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
        <!-- Breadcrumb -->
        <nav class="flex items-center space-x-2 text-xs text-amber-300/70 mb-6">
            <a href="{{ route('home') }}" class="hover:text-amber-200">Home</a>
            <span>/</span>
            <span class="text-amber-300">Privacy Policy</span>
        </nav>

        <!-- Page Header -->
        <div class="border-b border-amber-500/20 pb-8 mb-10">
            <div class="inline-flex items-center space-x-2 px-3 py-1 rounded-full border border-amber-500/30 bg-amber-500/10 text-amber-300 text-xs font-semibold mb-4">
                <span>🔒 Privacy & Data Protection</span>
            </div>
            <h1 class="font-cinzel text-3xl sm:text-4xl font-bold text-amber-300 tracking-wide">
                Privacy Policy
            </h1>
            <p class="text-xs text-amber-200/60 mt-2">
                Last Updated: October 2026 • Strict Confidentiality for Astrological & Personal Data
            </p>
        </div>

        <!-- Content -->
        <div class="space-y-8 text-sm leading-relaxed text-amber-100/80">
            <section class="space-y-3">
                <h2 class="font-cinzel text-xl font-bold text-amber-200">1. Commitment to Privacy</h2>
                <p>
                    At <strong>Covilakam Astrology</strong> (<em>കോവിലകം ജ്യോതിഷം</em>), directed by <strong>Dr. E. K. Raja Varma (Vidya Vachaspathi in Vedic Astrology)</strong>, we understand that sharing your personal birth details, family circumstances, and life questions requires deep trust. We are committed to protecting your privacy and treating all personal, astrological, and transactional information with utmost sanctity and confidentiality.
                </p>
            </section>

            <section class="space-y-3">
                <h2 class="font-cinzel text-xl font-bold text-amber-200">2. Information We Collect</h2>
                <p>When you interact with our portal, book a consultation, order physical books, or generate a digital Jathakam report, we collect:</p>
                <ul class="list-disc pl-5 space-y-1.5 text-xs sm:text-sm text-amber-100/80">
                    <li><strong>Contact Information:</strong> Full name, WhatsApp phone number, calling number, and email address.</li>
                    <li><strong>Astrological Birth Data:</strong> Exact Date of Birth, Exact Time of Birth (with AM/PM), and City/Place of Birth. This data is collected solely to calculate planetary planetary longitudes, Rasi, Navamsha, and Dasa periods.</li>
                    <li><strong>Physical Shipping Address:</strong> Street address, city, state, postal PIN code, and landmark (collected only for clients ordering physical books from our Bookstore).</li>
                    <li><strong>Transaction Identifiers:</strong> Razorpay Payment ID and Order Reference Numbers for verifying completion of payments.</li>
                </ul>
            </section>

            <section class="space-y-3">
                <h2 class="font-cinzel text-xl font-bold text-amber-200">3. Absolute Payment Security via Razorpay</h2>
                <div class="p-4 rounded-xl border border-emerald-500/30 bg-emerald-500/10 text-xs sm:text-sm text-emerald-100">
                    <p class="font-semibold text-emerald-300 mb-1">🛡️ Zero Payment Data Stored on Our Servers:</p>
                    <p>
                        All online payment processing is handled externally through <strong>Razorpay</strong>, certified to <strong>PCI-DSS Level 1</strong> (the highest global standard for payment gateway security). <strong>Covilakam Astrology does NOT store, collect, or have access to your credit/debit card numbers, expiry dates, CVVs, or net-banking / UPI credentials.</strong> All financial transactions are encrypted through 256-bit SSL connections directly with your bank.
                    </p>
                </div>
            </section>

            <section class="space-y-3">
                <h2 class="font-cinzel text-xl font-bold text-amber-200">4. How We Use Your Information</h2>
                <ul class="list-disc pl-5 space-y-1.5 text-xs sm:text-sm text-amber-100/80">
                    <li>To compute astrological charts and generate your personalized Jathakam PDF report.</li>
                    <li>To deliver horoscope reports, reading summaries, and consultation reminders to your verified WhatsApp number or email address.</li>
                    <li>To dispatch physical books via India Post Speed Post / Courier and send delivery tracking information.</li>
                    <li>To communicate regarding scheduling, appointment slots, or follow-up clarifications with Dr. E. K. Raja Varma.</li>
                </ul>
            </section>

            <section class="space-y-3">
                <h2 class="font-cinzel text-xl font-bold text-amber-200">5. Strict Non-Disclosure Policy</h2>
                <p>
                    We have a strict <strong>Zero Third-Party Selling Policy</strong>. We do NOT sell, rent, monetize, or trade your personal or birth information with marketing agencies, telemarketers, or commercial brokers under any circumstance. Your information is accessed solely by Dr. E. K. Raja Varma and authorized Covilakam Astrology staff strictly for fulfilling your requested astrological service or book order.
                </p>
            </section>

            <section class="space-y-3">
                <h2 class="font-cinzel text-xl font-bold text-amber-200">6. Data Retention & Deletion Rights</h2>
                <p>
                    We retain your consultation records and generated Jathakam charts so you may request duplicate copies or follow-up consultations in the future. However, if you wish to have your birth details or contact information permanently deleted from our records, you may email us at <a href="mailto:varmaji@covilakamastrology.com" class="text-amber-300 underline">varmaji@covilakamastrology.com</a>, and your records will be expunged within 7 business days.
                </p>
            </section>

            <section class="space-y-3 border-t border-amber-500/20 pt-6">
                <h2 class="font-cinzel text-xl font-bold text-amber-200">7. Grievance Redressal Officer</h2>
                <div class="bg-[#1a1128] p-5 rounded-2xl border border-amber-500/20 text-xs sm:text-sm space-y-1.5">
                    <p>In accordance with Information Technology Act, 2000 and the Rules made thereunder:</p>
                    <p><strong>Grievance Officer:</strong> Dr. E. K. Raja Varma (Vidya Vachaspathi in Vedic Astrology)</p>
                    <p><strong>Entity:</strong> Covilakam Astrology (Kovilakam Astrology)</p>
                    <p><strong>Location:</strong> Kerala, India (PIN: 686574)</p>
                    <p><strong>Grievance Email:</strong> <a href="mailto:varmaji@covilakamastrology.com" class="text-amber-300">varmaji@covilakamastrology.com</a></p>
                    <p><strong>Support Helpline:</strong> +91 7907052160 / 094473 27450</p>
                </div>
            </section>
        </div>
    </div>
</div>
@endsection

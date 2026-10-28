@extends('layouts.app')

@section('title', 'Contact Us | Covilakam Astrology - Dr. E. K. Raja Varma')
@section('meta_description', 'Official contact page of Covilakam Astrology, directed by Dr. E. K. Raja Varma (Vidya Vachaspathi in Vedic Astrology). Get in touch for consultations, book inquiries, or support via WhatsApp, phone, or email.')

@section('content')
<div class="pt-32 pb-24 bg-[#0d0716] min-h-screen text-amber-100/90 relative overflow-hidden">
    <!-- Subtle Golden Background Glow -->
    <div class="absolute inset-0 bg-radial from-amber-600/5 via-transparent to-transparent pointer-events-none"></div>

    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
        <!-- Breadcrumb -->
        <nav class="flex items-center space-x-2 text-xs text-amber-300/70 mb-6">
            <a href="{{ route('home') }}" class="hover:text-amber-200">Home</a>
            <span>/</span>
            <span class="text-amber-300">Contact Us</span>
        </nav>

        <!-- Page Header -->
        <div class="border-b border-amber-500/20 pb-8 mb-10 text-center sm:text-left">
            <div class="inline-flex items-center space-x-2 px-3 py-1 rounded-full border border-amber-500/30 bg-amber-500/10 text-amber-300 text-xs font-semibold mb-4">
                <span>📞 Official Merchant & Practice Contact</span>
            </div>
            <h1 class="font-cinzel text-3xl sm:text-4xl font-bold text-amber-300 tracking-wide">
                Contact Covilakam Astrology
            </h1>
            <p class="text-sm text-amber-200/70 mt-2 max-w-2xl">
                Connect directly with <strong>Dr. E. K. Raja Varma (Vidya Vachaspathi in Vedic Astrology, Gold Medalist & Ph.D.)</strong> for authentic astrology consultations, book store inquiries, or support.
            </p>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
            <!-- Left Column: Contact Cards -->
            <div class="lg:col-span-5 space-y-6">
                <!-- Merchant Entity Card -->
                <div class="bg-[#1a1128] p-6 rounded-2xl border border-amber-500/30 shadow-xl space-y-4">
                    <div class="flex items-center space-x-3.5">
                        <div class="w-12 h-12 rounded-full p-0.5 bg-gradient-to-tr from-amber-600 via-amber-300 to-yellow-500 shadow-md shrink-0">
                            <img src="{{ asset('images/og-covilakam-512x512.png') }}"
                                 alt="Dr. E. K. Raja Varma"
                                 class="w-full h-full rounded-full object-cover">
                        </div>
                        <div>
                            <h3 class="font-cinzel text-lg font-bold text-amber-300">COVILAKAM ASTROLOGY</h3>
                            <p class="text-xs text-amber-400 font-medium">Dr. E. K. Raja Varma</p>
                            <p class="text-[10px] text-amber-200/60">(Vidya Vachaspathi in Vedic Astrology)</p>
                        </div>
                    </div>

                    <div class="pt-2 border-t border-amber-500/20 space-y-3 text-xs sm:text-sm">
                        <!-- Address -->
                        <div class="flex items-start space-x-3">
                            <span class="text-lg">📍</span>
                            <div>
                                <strong class="text-amber-300 block">Registered Operating Address:</strong>
                                <p class="text-amber-100/80 leading-relaxed">
                                    Covilakam Astrology Centre,<br>
                                    Kerala, India — PIN: 686574
                                </p>
                            </div>
                        </div>

                        <!-- WhatsApp -->
                        <div class="flex items-start space-x-3">
                            <span class="text-lg">💬</span>
                            <div>
                                <strong class="text-amber-300 block">Primary WhatsApp (Fastest):</strong>
                                <a href="https://wa.me/917907052160" target="_blank" class="text-emerald-400 hover:text-emerald-300 font-semibold transition-colors">
                                    +91 7907052160
                                </a>
                                <p class="text-[11px] text-amber-200/50">Available for text, voice notes & consultation booking</p>
                            </div>
                        </div>

                        <!-- Phone / GPay -->
                        <div class="flex items-start space-x-3">
                            <span class="text-lg">📞</span>
                            <div>
                                <strong class="text-amber-300 block">Telephone & GPay:</strong>
                                <a href="tel:+919447327450" class="text-amber-200 hover:text-amber-100 font-medium">
                                    094473 27450 / +91 9447327450
                                </a>
                            </div>
                        </div>

                        <!-- Email 1 -->
                        <div class="flex items-start space-x-3">
                            <span class="text-lg">✉️</span>
                            <div>
                                <strong class="text-amber-300 block">Official Support Email:</strong>
                                <a href="mailto:varmaji@covilakamastrology.com" class="text-amber-300 hover:underline">
                                    varmaji@covilakamastrology.com
                                </a>
                            </div>
                        </div>

                        <!-- Email 2 -->
                        <div class="flex items-start space-x-3">
                            <span class="text-lg">📨</span>
                            <div>
                                <strong class="text-amber-300 block">Alternate Email:</strong>
                                <a href="mailto:ekrvarma@gmail.com" class="text-amber-200/90 hover:underline">
                                    ekrvarma@gmail.com
                                </a>
                            </div>
                        </div>

                        <!-- Working Hours -->
                        <div class="flex items-start space-x-3">
                            <span class="text-lg">🕒</span>
                            <div>
                                <strong class="text-amber-300 block">Operating Hours:</strong>
                                <p class="text-amber-100/80">Monday to Saturday: 9:00 AM – 8:00 PM IST</p>
                                <p class="text-[11px] text-amber-200/50">Sunday: By prior appointment only</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Trust Badge Card -->
                <div class="bg-gradient-to-br from-amber-950/40 to-[#1e132e] p-5 rounded-2xl border border-amber-500/25 text-xs text-amber-200/80 space-y-2">
                    <p class="font-bold text-amber-300 flex items-center space-x-2">
                        <span>🛡️</span>
                        <span>Razorpay Verified Merchant</span>
                    </p>
                    <p class="leading-relaxed">
                        All payments for books and consultation services are processed securely via <strong>Razorpay</strong>, supporting all major UPI apps (GPay, PhonePe, Paytm), Credit & Debit cards, and NetBanking.
                    </p>
                </div>
            </div>

            <!-- Right Column: Interactive Inquiry Form -->
            <div class="lg:col-span-7">
                <div class="bg-[#1a1128] p-6 sm:p-8 rounded-2xl border border-amber-500/30 shadow-2xl">
                    <h3 class="font-cinzel text-xl font-bold text-amber-300 mb-2">Send an Official Message</h3>
                    <p class="text-xs text-amber-200/60 mb-6">
                        Fill in your details below. Your query will be directed personally to Dr. E. K. Raja Varma.
                    </p>

                    @if(session('success'))
                        <div class="mb-6 p-4 rounded-xl bg-emerald-500/20 border border-emerald-500/30 text-emerald-300 text-xs sm:text-sm">
                            {{ session('success') }}
                        </div>
                    @endif

                    <form action="{{ route('consultations.store') }}" method="POST" class="space-y-4">
                        @csrf
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-xs font-semibold text-amber-300 uppercase mb-1">Your Name *</label>
                                <input type="text" name="name" required placeholder="Full Name"
                                       class="w-full px-4 py-2.5 rounded-xl bg-[#0f0819] border border-amber-500/30 text-amber-100 text-sm focus:border-amber-400 focus:outline-none">
                            </div>

                            <div>
                                <label class="block text-xs font-semibold text-amber-300 uppercase mb-1">WhatsApp Number *</label>
                                <input type="tel" name="whatsapp_number" required placeholder="+91 9876543210"
                                       class="w-full px-4 py-2.5 rounded-xl bg-[#0f0819] border border-amber-500/30 text-amber-100 text-sm focus:border-amber-400 focus:outline-none">
                            </div>
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-xs font-semibold text-amber-300 uppercase mb-1">Email Address</label>
                                <input type="email" name="email" placeholder="name@example.com"
                                       class="w-full px-4 py-2.5 rounded-xl bg-[#0f0819] border border-amber-500/30 text-amber-100 text-sm focus:border-amber-400 focus:outline-none">
                            </div>

                            <div>
                                <label class="block text-xs font-semibold text-amber-300 uppercase mb-1">Subject / Service Needed</label>
                                <select name="service_requested"
                                        class="w-full px-4 py-2.5 rounded-xl bg-[#0f0819] border border-amber-500/30 text-amber-100 text-sm focus:border-amber-400 focus:outline-none">
                                    <option value="General Inquiry">General Astrological Inquiry</option>
                                    <option value="Personal Consultation">Personal Astro Consultation (₹999)</option>
                                    <option value="Deluxe Jathakam PDF">Deluxe Vedic Jathakam PDF (₹299)</option>
                                    <option value="Book Purchase Inquiry">Vedic Astrology Books Purchase</option>
                                    <option value="Marriage Compatibility">Vivaha Porutham (₹499)</option>
                                    <option value="Gem Recommendation">Gemstone Recommendation (₹399)</option>
                                </select>
                            </div>
                        </div>

                        <div>
                            <label class="block text-xs font-semibold text-amber-300 uppercase mb-1">Your Message or Life Query</label>
                            <textarea name="message" rows="4" placeholder="Describe your question, birth details (if relevant), or book requirement..."
                                      class="w-full px-4 py-2.5 rounded-xl bg-[#0f0819] border border-amber-500/30 text-amber-100 text-sm focus:border-amber-400 focus:outline-none"></textarea>
                        </div>

                        <button type="submit"
                                class="w-full py-3.5 px-6 rounded-xl font-cinzel font-bold text-sm tracking-wider uppercase text-[#1a1128] bg-gradient-to-r from-amber-300 via-yellow-400 to-amber-500 hover:from-amber-200 hover:to-yellow-300 shadow-xl transition-all transform hover:-translate-y-0.5">
                            Submit Inquiry to Astrologer
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

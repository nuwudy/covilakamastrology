@extends('layouts.admin')

@section('title', 'Profile, Credentials & Settings | Covilakam Astrology')
@section('page_title', 'Profile, Credentials & Settings')

@section('content')
<div class="max-w-5xl mx-auto space-y-8">

    <!-- Header Actions -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <h1 class="font-cinzel text-2xl font-black text-white">
                Profile, Credentials & Contact Settings
            </h1>
            <p class="text-xs text-amber-200/70 mt-1">
                Configure primary contact numbers, Google Pay details, WhatsApp business links, and professional qualifications.
            </p>
        </div>
    </div>

    <!-- Main Settings Form -->
    <form action="{{ route('admin.settings.update') }}" method="POST" enctype="multipart/form-data" class="space-y-8 text-xs">
        @csrf
        @method('PUT')

        <!-- Contact & Payment Details Card -->
        <div class="rounded-3xl bg-[#160d26] border border-amber-500/30 p-6 sm:p-10 shadow-2xl space-y-6">
            <div class="border-b border-amber-500/20 pb-4">
                <h2 class="font-cinzel text-lg font-bold text-white flex items-center space-x-2">
                    <span>💳 Official Contact, WhatsApp & Payment Numbers</span>
                </h2>
                <p class="text-xs text-amber-300/70 mt-0.5">
                    Controls direct WhatsApp triggers, floating action buttons, and digital visiting card
                </p>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-5">
                <!-- WhatsApp Display -->
                <div>
                    <label class="block font-semibold text-amber-200 mb-1.5">WhatsApp Display Number *</label>
                    <input type="text" name="whatsapp_number" value="{{ old('whatsapp_number', $settings['whatsapp_number'] ?? '+91 7907052160') }}" required
                           class="w-full px-4 py-2.5 rounded-xl bg-[#211335] border border-amber-500/30 text-white font-mono text-xs">
                </div>

                <!-- WhatsApp Raw -->
                <div>
                    <label class="block font-semibold text-amber-200 mb-1.5">WhatsApp Raw Number (No +, spaces) *</label>
                    <input type="text" name="whatsapp_raw" value="{{ old('whatsapp_raw', $settings['whatsapp_raw'] ?? '917907052160') }}" required
                           class="w-full px-4 py-2.5 rounded-xl bg-[#211335] border border-amber-500/30 text-white font-mono text-xs">
                </div>

                <!-- Phone / GPay -->
                <div>
                    <label class="block font-semibold text-amber-200 mb-1.5">Google Pay / Primary Phone *</label>
                    <input type="text" name="gpay_number" value="{{ old('gpay_number', $settings['gpay_number'] ?? '094473 27450') }}" required
                           class="w-full px-4 py-2.5 rounded-xl bg-[#211335] border border-amber-500/30 text-white font-mono text-xs">
                </div>

                <!-- Primary Phone Display -->
                <div>
                    <label class="block font-semibold text-amber-200 mb-1.5">Calling Phone (Display) *</label>
                    <input type="text" name="phone_primary" value="{{ old('phone_primary', $settings['phone_primary'] ?? '094473 27450') }}" required
                           class="w-full px-4 py-2.5 rounded-xl bg-[#211335] border border-amber-500/30 text-white font-mono text-xs">
                </div>

                <!-- Primary Email -->
                <div>
                    <label class="block font-semibold text-amber-200 mb-1.5">Primary Official Email *</label>
                    <input type="email" name="email_primary" value="{{ old('email_primary', $settings['email_primary'] ?? 'varmaji@covilakamastrology.com') }}" required
                           class="w-full px-4 py-2.5 rounded-xl bg-[#211335] border border-amber-500/30 text-white font-mono text-xs">
                </div>

                <!-- Secondary Email -->
                <div>
                    <label class="block font-semibold text-amber-200 mb-1.5">Alternative Email</label>
                    <input type="email" name="email_secondary" value="{{ old('email_secondary', $settings['email_secondary'] ?? 'ekrvarma@gmail.com') }}"
                           class="w-full px-4 py-2.5 rounded-xl bg-[#211335] border border-amber-500/30 text-white font-mono text-xs">
                </div>
            </div>
        </div>

        <!-- Astrologer Profile & Credentials Card -->
        <div class="rounded-3xl bg-[#160d26] border border-amber-500/30 p-6 sm:p-10 shadow-2xl space-y-6">
            <div class="border-b border-amber-500/20 pb-4">
                <h2 class="font-cinzel text-lg font-bold text-white flex items-center space-x-2">
                    <span>👑 DR. E. K. Raja Varma Profile & Accreditations</span>
                </h2>
                <p class="text-xs text-amber-300/70 mt-0.5">
                    Doctorate, Gold Medalist Title, and International Astrology Federation fellowship
                </p>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-5">
                <div>
                    <label class="block font-semibold text-amber-200 mb-1.5">Astrologer Name *</label>
                    <input type="text" name="astrologer_name" value="{{ old('astrologer_name', $settings['astrologer_name'] ?? 'DR. E. K. Raja Varma') }}" required
                           class="w-full px-4 py-2.5 rounded-xl bg-[#211335] border border-amber-500/30 text-white text-xs font-bold">
                </div>

                <div>
                    <label class="block font-semibold text-amber-200 mb-1.5">Title / Designation *</label>
                    <input type="text" name="astrologer_subtitle" value="{{ old('astrologer_subtitle', $settings['astrologer_subtitle'] ?? '(Vidya Vachaspathi in Vedic Astrology)') }}" required
                           class="w-full px-4 py-2.5 rounded-xl bg-[#211335] border border-amber-500/30 text-white text-xs font-bold">
                </div>

                <div>
                    <label class="block font-semibold text-amber-200 mb-1.5">IAF Life Member ID</label>
                    <input type="text" name="iaf_member_id" value="{{ old('iaf_member_id', $settings['iaf_member_id'] ?? '11009') }}"
                           class="w-full px-4 py-2.5 rounded-xl bg-[#211335] border border-amber-500/30 text-white font-mono text-xs">
                </div>

                <div>
                    <label class="block font-semibold text-amber-200 mb-1.5">Gold Medal Convocation Date</label>
                    <input type="text" name="convocation_date" value="{{ old('convocation_date', $settings['convocation_date'] ?? '27th September 2026') }}"
                           class="w-full px-4 py-2.5 rounded-xl bg-[#211335] border border-amber-500/30 text-white text-xs">
                </div>

                <div>
                    <label class="block font-semibold text-amber-200 mb-1.5">Official Portal Website</label>
                    <input type="text" name="website" value="{{ old('website', $settings['website'] ?? 'www.covilakamastrology.com') }}"
                           class="w-full px-4 py-2.5 rounded-xl bg-[#211335] border border-amber-500/30 text-white font-mono text-xs">
                </div>

                <div>
                    <label class="block font-semibold text-amber-200 mb-1.5">Tagline</label>
                    <input type="text" name="tagline" value="{{ old('tagline', $settings['tagline'] ?? 'Explore. Discover. Transform.') }}"
                           class="w-full px-4 py-2.5 rounded-xl bg-[#211335] border border-amber-500/30 text-white text-xs">
                </div>
            </div>

            <!-- About Bio -->
            <div>
                <label class="block font-semibold text-amber-200 mb-1.5">Biography & Vedic Heritage Overview</label>
                <textarea name="about_bio" rows="4"
                          class="w-full px-4 py-3 rounded-xl bg-[#211335] border border-amber-500/30 text-white text-xs leading-relaxed">{{ old('about_bio', $settings['about_bio'] ?? '') }}</textarea>
            </div>
        </div>

        <!-- Qualifications Matrix Overview -->
        <div class="rounded-3xl bg-[#160d26] border border-amber-500/30 p-6 sm:p-10 shadow-2xl space-y-4">
            <div class="border-b border-amber-500/20 pb-3 flex items-center justify-between">
                <div>
                    <h2 class="font-cinzel text-lg font-bold text-white">
                        Vedic Qualifications & Honour Matrix
                    </h2>
                    <p class="text-xs text-amber-300/70">Displayed in Section 4 on the Homepage</p>
                </div>
                <span class="px-2.5 py-1 rounded-full text-[10px] font-bold bg-amber-500/20 text-amber-300">
                    {{ count($qualifications) }} Registered
                </span>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                @foreach($qualifications as $qual)
                <div class="p-4 rounded-xl bg-[#211335] border border-amber-500/20 space-y-1">
                    <div class="flex items-center justify-between text-[11px]">
                        <span class="px-2 py-0.5 rounded bg-amber-500/20 text-amber-300 font-bold uppercase text-[9px]">{{ $qual->badge_text }}</span>
                        <span class="text-amber-400 font-mono text-[10px]">{{ $qual->year }}</span>
                    </div>
                    <h4 class="font-bold text-white text-xs">{{ $qual->title }}</h4>
                    <p class="text-[11px] text-amber-300/80">{{ $qual->institution }}</p>
                    <p class="text-[10px] text-amber-100/70">{{ $qual->highlights }}</p>
                </div>
                @endforeach
            </div>
        </div>

        <!-- Form Submit -->
        <div class="flex items-center justify-end">
            <button type="submit"
                    class="px-10 py-3.5 rounded-xl font-bold text-xs text-[#1a1128] bg-gradient-to-r from-amber-300 via-yellow-400 to-amber-500 hover:from-amber-200 hover:to-yellow-300 shadow-xl hover:shadow-amber-500/30 transition-all">
                Save Portal Settings & Contact Details
            </button>
        </div>

    </form>

</div>
@endsection

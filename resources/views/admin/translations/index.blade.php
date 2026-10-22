@extends('layouts.admin')

@section('title', '4-Language Astrology Content Management | Covilakam Astrology')
@section('page_title', '4-Language Astrology Philosophy Content')

@section('content')
<div class="space-y-6" x-data="{ activeTab: 'ml' }">

    <!-- Header Actions -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <h1 class="font-cinzel text-2xl font-black text-white">
                4-Language Astrology Philosophy Content
            </h1>
            <p class="text-xs text-amber-200/70 mt-1">
                Edit the introductory Vedic Philosophy texts shown in the interactive language switcher on the homepage.
            </p>
        </div>

        <a href="{{ route('home') }}#philosophy" target="_blank"
           class="px-4 py-2 rounded-xl text-xs font-semibold text-amber-300 bg-[#1e1333] border border-amber-500/30 hover:border-amber-400 transition-colors self-start">
            View on Live Site ↗
        </a>
    </div>

    <!-- Language Selector Tabs -->
    <div class="flex flex-wrap gap-2 border-b border-amber-500/20 pb-4">
        @foreach($translations as $item)
        <button type="button"
                @click="activeTab = '{{ $item->language_code }}'"
                :class="activeTab === '{{ $item->language_code }}' ? 'bg-gradient-to-r from-amber-400 to-yellow-500 text-black font-extrabold shadow-lg shadow-amber-500/20' : 'bg-[#160d26] text-amber-200/80 hover:bg-amber-500/10 border border-amber-500/30'"
                class="px-5 py-2.5 rounded-xl text-xs transition-all flex items-center space-x-2">
            <span>{{ $item->language_name }}</span>
            <span class="text-[10px] font-mono opacity-80">({{ strtoupper($item->language_code) }})</span>
        </button>
        @endforeach
    </div>

    <!-- Translation Forms -->
    @foreach($translations as $item)
    <div x-show="activeTab === '{{ $item->language_code }}'"
         x-cloak
         class="rounded-3xl bg-[#160d26] border border-amber-500/30 p-6 sm:p-10 shadow-2xl space-y-6">
        
        <div class="border-b border-amber-500/20 pb-4 flex items-center justify-between">
            <div>
                <h2 class="font-cinzel text-xl font-bold text-white flex items-center space-x-2">
                    <span>{{ $item->language_name }} Content</span>
                </h2>
                <p class="text-xs text-amber-300/70 mt-0.5">
                    Section Heading, Subheading & Sacred Vedic Philosophy Paragraphs
                </p>
            </div>
            <span class="px-3 py-1 rounded-full text-xs font-mono font-bold bg-amber-500/20 text-amber-300 border border-amber-500/30">
                Code: {{ $item->language_code }}
            </span>
        </div>

        <form action="{{ route('admin.translations.update', $item->id) }}" method="POST" class="space-y-6 text-xs">
            @csrf
            @method('PUT')

            <!-- Heading -->
            <div>
                <label class="block font-semibold text-amber-200 mb-1.5">
                    Main Heading *
                </label>
                <input type="text" name="heading" value="{{ old('heading', $item->heading) }}" required
                       class="w-full px-4 py-3 rounded-xl bg-[#211335] border border-amber-500/30 text-white placeholder-amber-200/40 focus:outline-none focus:border-amber-400 text-sm font-bold">
            </div>

            <!-- Subheading -->
            <div>
                <label class="block font-semibold text-amber-200 mb-1.5">
                    Subheading / Tagline
                </label>
                <input type="text" name="subheading" value="{{ old('subheading', $item->subheading) }}"
                       class="w-full px-4 py-3 rounded-xl bg-[#211335] border border-amber-500/30 text-white placeholder-amber-200/40 focus:outline-none focus:border-amber-400 text-xs">
            </div>

            <!-- Body / Content -->
            <div>
                <label class="block font-semibold text-amber-200 mb-1.5">
                    Content (HTML Paragraphs Supported) *
                </label>
                <textarea name="content" rows="10" required
                          class="w-full px-4 py-3 rounded-xl bg-[#211335] border border-amber-500/30 text-white placeholder-amber-200/40 focus:outline-none focus:border-amber-400 font-mono text-xs leading-relaxed">{{ old('content', $item->content) }}</textarea>
                <p class="text-[11px] text-amber-300/60 mt-1">
                    Format with <code>&lt;p class="mb-4"&gt;...&lt;/p&gt;</code> and <code>&lt;strong&gt;</code> tags for smooth paragraph spacing.
                </p>
            </div>

            <!-- Submit -->
            <div class="pt-4 border-t border-amber-500/20 flex items-center justify-end">
                <button type="submit"
                        class="px-8 py-3 rounded-xl font-bold text-xs text-[#1a1128] bg-gradient-to-r from-amber-300 via-yellow-400 to-amber-500 hover:from-amber-200 hover:to-yellow-300 shadow-xl hover:shadow-amber-500/30 transition-all">
                    Save {{ $item->language_name }} Content
                </button>
            </div>

        </form>

    </div>
    @endforeach

</div>
@endsection

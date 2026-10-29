@extends('layouts.app')

@php
    $featuredImageUrl = $post->featured_image
        ? (str_starts_with($post->featured_image, 'http')
            ? $post->featured_image
            : (str_starts_with($post->featured_image, 'images/')
                ? asset($post->featured_image)
                : asset('storage/' . $post->featured_image)))
        : asset('images/og-covilakam-1200x630.jpg');
    $postUrl = route('blog.show', $post->slug);
    $shareExcerpt = Str::limit(strip_tags($post->excerpt ?: $post->body), 140);
    $whatsappShareText = "✨ *" . $post->title . "*\n" . $shareExcerpt . "\n\n✍️ Dr. E. K. Raja Varma (Covilakam Astrology)\n📖 Read Full Article: " . $postUrl;
    $whatsappShareUrl = "https://api.whatsapp.com/send?text=" . rawurlencode($whatsappShareText);
    $facebookShareUrl = "https://www.facebook.com/sharer/sharer.php?u=" . rawurlencode($postUrl);
    $telegramShareUrl = "https://t.me/share/url?url=" . rawurlencode($postUrl) . "&text=" . rawurlencode("✨ " . $post->title . " — Dr. E. K. Raja Varma");
@endphp

@section('title', $post->title . ' | Covilakam Astrology')
@section('meta_description', Str::limit(strip_tags($post->excerpt ?: $post->body), 155))
@section('og_image', $featuredImageUrl)

@section('content')
<article class="pt-32 pb-24 bg-[#0d0716] min-h-screen">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <!-- Breadcrumb -->
        <nav class="flex items-center space-x-2 text-xs text-amber-300/70 mb-6">
            <a href="{{ route('home') }}" class="hover:text-amber-200">Home</a>
            <span>/</span>
            <a href="{{ route('blog.index') }}" class="hover:text-amber-200">Blog</a>
            <span>/</span>
            <span class="text-amber-100/50 truncate max-w-xs">{{ $post->title }}</span>
        </nav>

        <!-- Category & Reading Time Badge -->
        <div class="flex flex-wrap items-center justify-between gap-3 mb-4">
            <div class="flex items-center space-x-3">
                <span class="px-3 py-1 rounded-full text-xs font-bold bg-amber-500/20 text-amber-300 border border-amber-500/40">
                    {{ $post->category }}
                </span>
                <span class="text-xs text-amber-300/70 font-mono">
                    {{ $post->reading_time }} • {{ $post->published_at ? $post->published_at->format('M d, Y') : 'Recent' }}
                </span>
            </div>

            <!-- Quick Top Share Buttons -->
            <div class="flex items-center gap-2">
                <button type="button"
                        onclick="shareCovilakamBlog({
                            title: @js($post->title),
                            excerpt: @js($shareExcerpt),
                            url: @js($postUrl),
                            imageUrl: @js($featuredImageUrl)
                        }, this)"
                        class="inline-flex items-center space-x-1.5 px-3.5 py-1.5 rounded-xl text-xs font-bold text-[#1a1128] bg-gradient-to-r from-amber-300 via-yellow-400 to-amber-500 hover:from-amber-200 hover:to-yellow-300 shadow-lg transition-all cursor-pointer">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2.2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M8.684 13.342C8.886 12.938 9 12.482 9 12c0-.482-.114-.938-.316-1.342m0 2.684a3 3 0 110-2.684m0 2.684l6.632 3.316m-6.632-6l6.632-3.316m0 0a3 3 0 105.367-2.684 3 3 0 00-5.367 2.684zm0 9.316a3 3 0 105.368 2.684 3 3 0 00-5.368-2.684z"/>
                    </svg>
                    <span>Share Blog</span>
                </button>
                <a href="{{ $whatsappShareUrl }}"
                   target="_blank"
                   rel="noopener noreferrer"
                   title="Share on WhatsApp with Preview Image"
                   class="inline-flex items-center space-x-1.5 px-3 py-1.5 rounded-xl text-xs font-bold text-white bg-emerald-600 hover:bg-emerald-500 shadow-lg transition-all">
                    <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M12.031 6.172c-3.181 0-5.767 2.586-5.768 5.766-.001 1.298.38 2.27 1.019 3.287l-.711 2.598 2.664-.698c.969.585 1.961.947 2.796.947 3.179 0 5.766-2.587 5.767-5.766.001-3.181-2.586-5.767-5.767-5.767zm0 10.373c-.768 0-1.637-.251-2.327-.661l-.167-.099-1.58.414.422-1.539-.109-.174c-.453-.722-.693-1.564-.693-2.55 0-2.539 2.066-4.605 4.606-4.605 2.54 0 4.606 2.066 4.606 4.606 0 2.54-2.066 4.608-4.755 4.608z"/>
                    </svg>
                    <span>WhatsApp</span>
                </a>
            </div>
        </div>

        <!-- Article Title -->
        <h1 class="font-cinzel text-2xl sm:text-4xl lg:text-5xl font-black text-white leading-tight mb-6">
            {{ $post->title }}
        </h1>

        <!-- Author Card -->
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 p-4 rounded-2xl bg-[#1a1128] border border-amber-500/30 mb-8">
            <div class="flex items-center space-x-4">
                <img src="{{ asset('storage/media/images/covilakam-4bcJQK.webp') }}"
                     alt="Dr. E. K. Raja Varma"
                     onerror="this.onerror=null; this.src='{{ asset('images/covilakam-hero.webp') }}';"
                     class="w-14 h-14 rounded-full object-cover border-2 border-amber-400 shrink-0">
                <div>
                    <p class="font-cinzel text-sm sm:text-base font-bold text-amber-300">
                        Dr. E. K. Raja Varma
                    </p>
                    <p class="text-xs text-amber-200/80 font-medium">
                        (Vidya Vachaspathi in Vedic Astrology)
                    </p>
                    <p class="text-[11px] text-amber-100/60 mt-0.5">
                        Ph.D. in Vedic Astrology (Online Astro Counselling) • 2026 Gold Medalist
                    </p>
                </div>
            </div>

            <!-- Copy Link Button -->
            <button type="button"
                    onclick="copyCovilakamBlogLink(@js($postUrl), this)"
                    class="self-start sm:self-center inline-flex items-center space-x-1.5 px-3 py-1.5 rounded-xl text-xs font-semibold text-amber-200 bg-[#251540] border border-amber-500/30 hover:border-amber-400 hover:text-white transition-all cursor-pointer">
                <svg class="w-3.5 h-3.5 text-amber-300" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"/>
                </svg>
                <span>Copy Link</span>
            </button>
        </div>

        <!-- Featured Image with Floating Share Button -->
        <div class="rounded-3xl overflow-hidden border-2 border-amber-500/30 shadow-2xl mb-10 aspect-video relative group">
            <img src="{{ $featuredImageUrl }}"
                 alt="{{ $post->title }}"
                 onerror="this.onerror=null; this.src='data:image/svg+xml;utf8,<svg xmlns=\'http://www.w3.org/2000/svg\' width=\'800\' height=\'450\' viewBox=\'0 0 800 450\'><rect width=\'100%\' height=\'100%\' fill=\'%231a1128\'/><text x=\'50%\' y=\'55%\' font-size=\'60\' fill=\'%23f3e5ab\' dominant-baseline=\'middle\' text-anchor=\'middle\'>ॐ</text></svg>';"
                 class="w-full h-full object-cover">
            <button type="button"
                    onclick="shareCovilakamBlog({
                        title: @js($post->title),
                        excerpt: @js($shareExcerpt),
                        url: @js($postUrl),
                        imageUrl: @js($featuredImageUrl)
                    }, this)"
                    class="absolute top-4 right-4 px-3.5 py-2 rounded-full text-xs font-bold bg-[#1a1128]/90 hover:bg-amber-400 text-amber-300 hover:text-[#1a1128] border border-amber-400/60 backdrop-blur-md shadow-xl flex items-center space-x-1.5 transition-all cursor-pointer">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M8.684 13.342C8.886 12.938 9 12.482 9 12c0-.482-.114-.938-.316-1.342m0 2.684a3 3 0 110-2.684m0 2.684l6.632 3.316m-6.632-6l6.632-3.316m0 0a3 3 0 105.367-2.684 3 3 0 00-5.367 2.684zm0 9.316a3 3 0 105.368 2.684 3 3 0 00-5.368-2.684z"/>
                </svg>
                <span>Share with Image</span>
            </button>
        </div>

        <!-- Article Body -->
        <div class="prose prose-invert prose-amber max-w-none text-amber-50/90 leading-relaxed font-sans text-sm sm:text-base space-y-6">
            {!! $post->body !!}
        </div>

        <!-- Share Blog with Featured Image Card -->
        <div class="mt-12 p-6 sm:p-7 rounded-3xl bg-[#180e29] border-2 border-amber-500/35 shadow-xl flex flex-col md:flex-row items-center justify-between gap-5">
            <div class="text-center md:text-left space-y-1">
                <span class="text-[11px] font-bold uppercase tracking-widest text-amber-400">
                    📤 ലേഖനം പങ്കുവെക്കുക • Share This Article
                </span>
                <h3 class="font-cinzel text-base sm:text-lg font-bold text-white">
                    Share this Blog along with its Featured Image
                </h3>
                <p class="text-xs text-amber-200/75">
                    Share directly to WhatsApp, Facebook, Telegram, or other apps with the article cover image and link.
                </p>
            </div>

            <div class="flex flex-wrap items-center justify-center gap-2.5 shrink-0">
                <!-- Primary Native Share (Attaches Image File + Text + URL) -->
                <button type="button"
                        onclick="shareCovilakamBlog({
                            title: @js($post->title),
                            excerpt: @js($shareExcerpt),
                            url: @js($postUrl),
                            imageUrl: @js($featuredImageUrl)
                        }, this)"
                        class="px-4 py-2.5 rounded-xl font-bold text-xs text-[#1a1128] bg-gradient-to-r from-amber-300 via-yellow-400 to-amber-500 hover:from-amber-200 hover:to-yellow-300 shadow-lg flex items-center space-x-2 transition-all cursor-pointer">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M8.684 13.342C8.886 12.938 9 12.482 9 12c0-.482-.114-.938-.316-1.342m0 2.684a3 3 0 110-2.684m0 2.684l6.632 3.316m-6.632-6l6.632-3.316m0 0a3 3 0 105.367-2.684 3 3 0 00-5.367 2.684zm0 9.316a3 3 0 105.368 2.684 3 3 0 00-5.368-2.684z"/>
                    </svg>
                    <span>Share with Image</span>
                </button>

                <!-- WhatsApp Share -->
                <a href="{{ $whatsappShareUrl }}"
                   target="_blank"
                   rel="noopener noreferrer"
                   class="px-4 py-2.5 rounded-xl font-bold text-xs text-white bg-emerald-600 hover:bg-emerald-500 shadow-lg flex items-center space-x-1.5 transition-all">
                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M12.031 6.172c-3.181 0-5.767 2.586-5.768 5.766-.001 1.298.38 2.27 1.019 3.287l-.711 2.598 2.664-.698c.969.585 1.961.947 2.796.947 3.179 0 5.766-2.587 5.767-5.766.001-3.181-2.586-5.767-5.767-5.767zm0 10.373c-.768 0-1.637-.251-2.327-.661l-.167-.099-1.58.414.422-1.539-.109-.174c-.453-.722-.693-1.564-.693-2.55 0-2.539 2.066-4.605 4.606-4.605 2.54 0 4.606 2.066 4.606 4.606 0 2.54-2.066 4.608-4.755 4.608z"/>
                    </svg>
                    <span>WhatsApp</span>
                </a>

                <!-- Facebook Share -->
                <a href="{{ $facebookShareUrl }}"
                   target="_blank"
                   rel="noopener noreferrer"
                   class="px-3.5 py-2.5 rounded-xl font-bold text-xs text-white bg-[#1877F2] hover:bg-[#166fe5] shadow-lg flex items-center space-x-1.5 transition-all">
                    <span>Facebook</span>
                </a>

                <!-- Telegram Share -->
                <a href="{{ $telegramShareUrl }}"
                   target="_blank"
                   rel="noopener noreferrer"
                   class="px-3.5 py-2.5 rounded-xl font-bold text-xs text-white bg-[#229ED9] hover:bg-[#1e8ec4] shadow-lg flex items-center space-x-1.5 transition-all">
                    <span>Telegram</span>
                </a>

                <!-- Copy Link -->
                <button type="button"
                        onclick="copyCovilakamBlogLink(@js($postUrl), this)"
                        class="px-3.5 py-2.5 rounded-xl font-bold text-xs text-amber-200 bg-[#251540] border border-amber-500/40 hover:border-amber-400 hover:text-white transition-all cursor-pointer">
                    <span>Copy Link</span>
                </button>
            </div>
        </div>

        <!-- Direct Consultation CTA Box -->
        <div class="mt-10 p-8 rounded-3xl bg-gradient-to-br from-[#2b0e1a] via-[#1a1128] to-[#250d28] border-2 border-amber-500/40 shadow-2xl text-center space-y-4">
            <span class="text-2xl">✨</span>
            <h3 class="font-cinzel text-xl sm:text-2xl font-bold text-white">
                Have questions regarding this topic?
            </h3>
            <p class="text-xs sm:text-sm text-amber-100/80 max-w-xl mx-auto leading-relaxed">
                Connect directly with <strong>Dr. E. K. Raja Varma (Vidya Vachaspathi in Vedic Astrology)</strong> for personalized horoscope evaluation and authentic Vedic remedies.
            </p>

            <div class="pt-2 flex flex-col sm:flex-row items-center justify-center gap-3">
                <a href="{{ $whatsappUrl }}"
                   target="_blank"
                   class="w-full sm:w-auto px-6 py-3.5 rounded-xl font-bold text-xs sm:text-sm text-white bg-emerald-600 hover:bg-emerald-500 shadow-xl flex items-center justify-center space-x-2 transition-all">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M12.031 6.172c-3.181 0-5.767 2.586-5.768 5.766-.001 1.298.38 2.27 1.019 3.287l-.711 2.598 2.664-.698c.969.585 1.961.947 2.796.947 3.179 0 5.766-2.587 5.767-5.766.001-3.181-2.586-5.767-5.767-5.767zm0 10.373c-.768 0-1.637-.251-2.327-.661l-.167-.099-1.58.414.422-1.539-.109-.174c-.453-.722-.693-1.564-.693-2.55 0-2.539 2.066-4.605 4.606-4.605 2.54 0 4.606 2.066 4.606 4.606 0 2.54-2.066 4.608-4.755 4.608z"/>
                    </svg>
                    <span>Discuss on WhatsApp (+91 7907052160)</span>
                </a>
                <button @click="$dispatch('open-booking-modal', { service: '{{ $post->category }}' })"
                        class="w-full sm:w-auto px-6 py-3.5 rounded-xl font-bold text-xs sm:text-sm text-[#1a1128] bg-gradient-to-r from-amber-300 to-yellow-400 hover:from-amber-200 hover:to-yellow-300 shadow-xl transition-all">
                    Book Online Consultation
                </button>
            </div>
        </div>

        <!-- Recent Posts Section -->
        @if($recentPosts->count())
        <div class="mt-20 border-t border-amber-500/20 pt-12">
            <h3 class="font-cinzel text-xl sm:text-2xl font-bold text-white mb-8">
                More Articles from Covilakam Astrology
            </h3>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                @foreach($recentPosts as $recent)
                <a href="{{ route('blog.show', $recent->slug) }}"
                   class="card-gold-frame rounded-2xl p-5 flex items-center space-x-4 group">
                    <img src="{{ asset($recent->featured_image) }}"
                         alt="{{ $recent->title }}"
                         onerror="this.onerror=null; this.src='data:image/svg+xml;utf8,<svg xmlns=\'http://www.w3.org/2000/svg\' width=\'80\' height=\'80\' viewBox=\'0 0 80 80\'><rect width=\'100%\' height=\'100%\' fill=\'%231a1128\'/><text x=\'50%\' y=\'55%\' font-size=\'30\' fill=\'%23f3e5ab\' dominant-baseline=\'middle\' text-anchor=\'middle\'>ॐ</text></svg>';"
                         class="w-20 h-20 rounded-xl object-cover shrink-0 border border-amber-500/30">
                    <div>
                        <span class="text-[10px] text-amber-400 font-bold uppercase">{{ $recent->category }}</span>
                        <h4 class="font-cinzel text-sm font-bold text-white group-hover:text-amber-300 transition-colors line-clamp-2">
                            {{ $recent->title }}
                        </h4>
                        <span class="text-[11px] text-amber-300/60 mt-1 block">{{ $recent->reading_time }}</span>
                    </div>
                </a>
                @endforeach
            </div>
        </div>
        @endif

    </div>
</article>
@endsection

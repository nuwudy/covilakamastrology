@extends('layouts.app')

@section('title', $video->title . ' | Vedic Astrology Video Discourse | DR. E. K. Raja Varma')
@section('meta_description', Str::limit(strip_tags($video->description), 160))
@section('og_image', "https://img.youtube.com/vi/{$video->youtube_id}/maxresdefault.jpg")

@section('content')
<div class="pt-28 sm:pt-32 pb-24 bg-[#090511] min-h-screen text-amber-100/90 relative overflow-hidden"
     x-data="{
        copiedToast: false,
        shareVideo() {
            const shareUrl = window.location.href;
            if (navigator.share) {
                navigator.share({
                    title: '{{ addslashes($video->title) }} - DR. E. K. Raja Varma',
                    text: 'Watch this Vedic Astrology Discourse by DR. E. K. Raja Varma:',
                    url: shareUrl
                }).catch(() => {});
            } else if (navigator.clipboard) {
                navigator.clipboard.writeText(shareUrl).then(() => {
                    this.copiedToast = true;
                    setTimeout(() => { this.copiedToast = false; }, 3000);
                });
            }
        }
     }">

    <!-- Atmospheric Glows -->
    <div class="absolute -top-40 left-1/2 -translate-x-1/2 w-[900px] h-[500px] bg-amber-500/15 rounded-full blur-[160px] pointer-events-none"></div>

    <!-- Copied Toast -->
    <div x-show="copiedToast"
         x-cloak
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0 translate-y-4"
         x-transition:enter-end="opacity-100 translate-y-0"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="opacity-100 translate-y-0"
         x-transition:leave-end="opacity-0 translate-y-4"
         class="fixed bottom-6 right-6 z-50 px-4 py-3 rounded-2xl bg-[#1f1338] border border-amber-400/50 shadow-2xl flex items-center space-x-3 text-xs text-white">
        <span class="w-2 h-2 rounded-full bg-emerald-400 animate-pulse"></span>
        <span>Share link copied to clipboard!</span>
    </div>

    <div class="max-w-7xl mx-auto px-3 sm:px-6 lg:px-8 relative z-10">

        <!-- Breadcrumb & Back to Cinema Link -->
        <div class="flex items-center justify-between gap-4 mb-6 text-xs">
            <a href="{{ route('videos.index') }}"
               class="inline-flex items-center space-x-2 text-amber-300 hover:text-amber-100 bg-[#160d26] px-4 py-2 rounded-xl border border-amber-500/30 transition-all">
                <span>←</span>
                <span>Back to Cinema Video Gallery</span>
            </a>

            <div class="flex items-center space-x-2 text-amber-300/70">
                <span class="w-2 h-2 rounded-full bg-red-500 animate-pulse"></span>
                <span>Now Showing Premiere</span>
            </div>
        </div>

        <!-- Cinema Theater Stage -->
        <div class="rounded-3xl p-1 bg-gradient-to-r from-amber-500/50 via-yellow-400/50 to-purple-600/40 shadow-2xl mb-12">
            <div class="rounded-[22px] bg-[#140b22] overflow-hidden border border-amber-500/40">
                
                <!-- 16:9 Screen -->
                <div class="relative aspect-video bg-black w-full overflow-hidden shadow-2xl">
                    <iframe src="https://www.youtube-nocookie.com/embed/{{ $video->youtube_id }}?autoplay=1&rel=0&modestbranding=1"
                            class="w-full h-full border-0"
                            allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                            allowfullscreen>
                    </iframe>
                </div>

                <!-- Stage Details -->
                <div class="p-6 sm:p-10 space-y-6">
                    <div class="flex flex-wrap items-center justify-between gap-3">
                        <div class="flex items-center space-x-2">
                            <span class="px-3 py-1 rounded-full text-xs font-black uppercase tracking-wider bg-gradient-to-r from-amber-400 to-yellow-500 text-[#140b22]">
                                Episode #{{ $video->sort_order }}
                            </span>
                            @if($video->duration)
                            <span class="px-2.5 py-1 rounded-md bg-black/80 border border-white/20 text-xs font-mono text-white">
                                ⏱ {{ $video->duration }}
                            </span>
                            @endif
                        </div>

                        <div class="flex items-center space-x-3">
                            <button type="button"
                                    @click="shareVideo()"
                                    class="px-4 py-2 rounded-xl text-xs font-semibold text-amber-300 bg-[#1e1233] border border-amber-500/40 hover:text-white flex items-center space-x-1.5 transition-all">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.684 13.342C8.886 12.938 9 12.482 9 12c0-.482-.114-.938-.316-1.342m0 2.684a3 3 0 110-2.684m0 2.684l6.632 3.316m-6.632-6l6.632-3.316m0 0a3 3 0 105.367-2.684 3 3 0 00-5.367 2.684zm0 9.316a3 3 0 105.368 2.684 3 3 0 00-5.368-2.684z"/></svg>
                                <span>Share Discourse</span>
                            </button>

                            <a href="https://youtu.be/{{ $video->youtube_id }}"
                               target="_blank"
                               rel="noopener noreferrer"
                               class="px-4 py-2 rounded-xl text-xs font-bold text-red-400 bg-red-500/10 border border-red-500/30 hover:bg-red-500/20 flex items-center space-x-1.5">
                                <span>Watch on YouTube ↗</span>
                            </a>
                        </div>
                    </div>

                    <h1 class="font-['Noto_Sans_Malayalam',sans-serif] text-2xl sm:text-3xl lg:text-4xl font-black text-white leading-snug">
                        {{ $video->title }}
                    </h1>

                    <div class="text-xs sm:text-sm text-amber-300/80 font-medium">
                        Discourse by <strong class="text-amber-200">DR. E. K. Raja Varma (Vidya Vachaspathi in Vedic Astrology)</strong>
                    </div>

                    <div class="font-['Noto_Sans_Malayalam',sans-serif] text-sm sm:text-base text-amber-100/85 leading-loose bg-[#1a102c]/60 p-5 sm:p-6 rounded-2xl border border-amber-500/20">
                        {{ $video->description }}
                    </div>

                    <!-- Direct Consultation Action -->
                    <div class="pt-4 border-t border-amber-500/20 flex flex-wrap items-center justify-between gap-4">
                        <div class="text-xs text-amber-200/80">
                            Have personal questions regarding this discourse?
                        </div>
                        <div class="flex items-center gap-3">
                            <a href="https://wa.me/917907052160?text={{ rawurlencode('Namaskaram DR. E. K. Raja Varma, I watched your discourse: "' . $video->title . '" and would like to ask a question.') }}"
                               target="_blank"
                               rel="noopener noreferrer"
                               class="px-5 py-3 rounded-xl font-bold text-xs text-[#140b22] bg-gradient-to-r from-amber-300 via-yellow-400 to-amber-500 hover:from-amber-200 hover:to-yellow-300 flex items-center space-x-2 shadow-lg">
                                <span>💬 Consult on WhatsApp</span>
                            </a>
                            <button type="button"
                                    @click="$dispatch('open-booking-modal', { service: 'Accurate Predictions' })"
                                    class="px-5 py-3 rounded-xl font-semibold text-xs text-amber-200 bg-[#1e1233] border border-amber-500/40 hover:text-white">
                                Book Reading
                            </button>
                        </div>
                    </div>

                </div>
            </div>
        </div>

        <!-- More Discourses in the Cinema Collection (2-columns on mobile, 4 on PC) -->
        @if($otherVideos->count() > 0)
        <div class="space-y-6">
            <div class="flex items-center justify-between">
                <h2 class="font-cinzel text-xl sm:text-2xl font-bold text-white">
                    More Vedic Astrology <span class="gold-gradient-text">Discourses</span>
                </h2>
                <a href="{{ route('videos.index') }}" class="text-xs font-bold text-amber-300 hover:text-amber-100 flex items-center space-x-1">
                    <span>View All ({{ $otherVideos->count() + 1 }})</span>
                    <span>→</span>
                </a>
            </div>

            <!-- 2 columns on mobile, 4 on PC -->
            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-3 sm:gap-6">
                @foreach($otherVideos as $other)
                <a href="{{ route('videos.show', $other->youtube_id) }}"
                   class="group rounded-2xl sm:rounded-3xl p-0.5 bg-gradient-to-b from-amber-500/25 to-purple-900/30 hover:from-amber-400 hover:to-yellow-500 transition-all flex flex-col overflow-hidden shadow-lg hover:shadow-amber-500/20">
                    <div class="rounded-[15px] sm:rounded-[22px] bg-[#140b22] h-full flex flex-col justify-between overflow-hidden border border-amber-500/20 group-hover:border-amber-400/50">
                        <div class="relative aspect-video bg-black overflow-hidden">
                            <img src="https://img.youtube.com/vi/{{ $other->youtube_id }}/hqdefault.jpg"
                                 alt="{{ $other->title }}"
                                 class="w-full h-full object-cover transform group-hover:scale-108 transition-transform duration-500 opacity-90 group-hover:opacity-100">
                            <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-transparent to-transparent"></div>
                            
                            <!-- Play Icon -->
                            <div class="absolute inset-0 flex items-center justify-center">
                                <div class="w-9 h-9 sm:w-11 sm:h-11 rounded-full bg-gradient-to-tr from-amber-500 to-yellow-400 p-0.5 shadow-lg group-hover:scale-115 transition-transform duration-300">
                                    <div class="w-full h-full rounded-full bg-[#140b22]/90 flex items-center justify-center text-amber-300 pl-0.5">
                                        <svg class="w-4 h-4 fill-current" viewBox="0 0 24 24"><path d="M8 5v14l11-7z"/></svg>
                                    </div>
                                </div>
                            </div>

                            @if($other->duration)
                            <div class="absolute bottom-2 right-2 px-1.5 py-0.5 rounded bg-black/80 text-[9px] font-mono text-white/90">
                                {{ $other->duration }}
                            </div>
                            @endif
                        </div>

                        <div class="p-3 sm:p-4 space-y-1.5">
                            <h3 class="font-['Noto_Sans_Malayalam',sans-serif] text-xs sm:text-sm font-bold text-white group-hover:text-amber-300 transition-colors leading-snug line-clamp-2">
                                {{ $other->title }}
                            </h3>
                            <div class="text-[10px] sm:text-xs text-amber-300/70">
                                DR. E. K. Raja Varma
                            </div>
                        </div>
                    </div>
                </a>
                @endforeach
            </div>
        </div>
        @endif

    </div>

</div>

@php
    $singleVideoSchema = [
        '@context' => 'https://schema.org',
        '@type' => 'VideoObject',
        'name' => $video->title,
        'description' => $video->description,
        'thumbnailUrl' => [$video->thumbnail_url],
        'uploadDate' => $video->created_at ? $video->created_at->toIso8601String() : '2026-01-01T00:00:00+05:30',
        'embedUrl' => $video->embed_url,
        'contentUrl' => 'https://youtu.be/' . $video->youtube_id,
        'duration' => 'PT12M00S',
        'author' => [
            '@type' => 'Person',
            'name' => 'DR. E. K. Raja Varma',
            'jobTitle' => 'Vidya Vachaspathi in Vedic Astrology'
        ]
    ];
@endphp
<script type="application/ld+json">
{!! json_encode($singleVideoSchema, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT) !!}
</script>
@endsection

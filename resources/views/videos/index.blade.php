@extends('layouts.app')

@section('title', 'Exclusive Vedic Astrology Video Gallery & Discourses | Dr. E. K. Raja Varma | Covilakam Astrology')
@section('meta_description', 'Watch exclusive Malayalam Vedic Astrology video discourses by Dr. E. K. Raja Varma (Vidya Vachaspathi in Vedic Astrology, Gold Medalist). Exploring Online Astro Counselling, Marriage Compatibility (Porutham), Kaalapurusha Vaastu, and Raja Yogas.')

@section('content')
<div class="pt-28 sm:pt-32 pb-24 bg-[#090511] min-h-screen text-amber-100/90 relative overflow-hidden"
     x-data="{
        activeVideoModal: {{ $initialWatchVideo ? 'true' : 'false' }},
        currentVideo: {
            id: '{{ $initialWatchVideo->id ?? ($featuredVideo->id ?? '') }}',
            title: '{{ addslashes($initialWatchVideo->title ?? ($featuredVideo->title ?? '')) }}',
            youtube_id: '{{ $initialWatchVideo->youtube_id ?? ($featuredVideo->youtube_id ?? '') }}',
            description: '{{ addslashes($initialWatchVideo->description ?? ($featuredVideo->description ?? '')) }}',
            duration: '{{ $initialWatchVideo->duration ?? ($featuredVideo->duration ?? '12:00') }}',
            sort_order: {{ $initialWatchVideo->sort_order ?? ($featuredVideo->sort_order ?? 1) }}
        },
        searchQuery: '',
        activeCategory: 'all',
        copiedToast: false,

        openVideo(video) {
            this.currentVideo = video;
            this.activeVideoModal = true;
            document.body.style.overflow = 'hidden';
            // Update URL without page reload for easy sharing
            const url = new URL(window.location);
            url.searchParams.set('watch', video.youtube_id);
            window.history.replaceState({}, '', url);
        },

        closeVideo() {
            this.activeVideoModal = false;
            document.body.style.overflow = 'auto';
            const url = new URL(window.location);
            url.searchParams.delete('watch');
            window.history.replaceState({}, '', url);
        },

        shareVideo(video) {
            const shareUrl = window.location.origin + '{{ route('videos.index') }}?watch=' + video.youtube_id;
            if (navigator.share) {
                navigator.share({
                    title: video.title + ' - Dr. E. K. Raja Varma',
                    text: 'Watch this Vedic Astrology Discourse by Dr. E. K. Raja Varma:',
                    url: shareUrl
                }).catch(() => {});
            } else if (navigator.clipboard) {
                navigator.clipboard.writeText(shareUrl).then(() => {
                    this.copiedToast = true;
                    setTimeout(() => { this.copiedToast = false; }, 3000);
                });
            }
        },

        matchesFilter(title, desc, cat) {
            const q = this.searchQuery.toLowerCase().trim();
            const textMatch = !q || title.toLowerCase().includes(q) || desc.toLowerCase().includes(q);
            const catMatch = (this.activeCategory === 'all') || (cat === this.activeCategory);
            return textMatch && catMatch;
        }
     }"
     @keydown.escape.window="closeVideo()">

    <!-- Atmospheric Cinema Lighting & Cosmic Ambient Gradients -->
    <div class="absolute -top-40 left-1/2 -translate-x-1/2 w-[1000px] h-[550px] bg-gradient-to-b from-amber-500/15 via-purple-900/10 to-transparent rounded-full blur-[160px] pointer-events-none"></div>
    <div class="absolute top-[600px] -left-40 w-[600px] h-[600px] bg-amber-600/10 rounded-full blur-[180px] pointer-events-none"></div>
    <div class="absolute top-[1200px] -right-40 w-[600px] h-[600px] bg-purple-700/10 rounded-full blur-[180px] pointer-events-none"></div>

    <!-- Copied Link Toast Notification -->
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
        <span>Discourse share link copied to clipboard!</span>
    </div>

    <div class="max-w-7xl mx-auto px-3 sm:px-6 lg:px-8 relative z-10">

        <!-- ========================================================================= -->
        <!-- CINEMA HEADER & BRAND BILLBOARD                                          -->
        <!-- ========================================================================= -->
        <div class="text-center max-w-4xl mx-auto mb-10 sm:mb-14 space-y-4">
            
            <!-- Header Badge -->
            <div class="inline-flex items-center space-x-2 text-[11px] sm:text-xs font-bold uppercase tracking-widest text-amber-300 bg-amber-500/10 px-4 py-1.5 rounded-full border border-amber-500/30 shadow-lg shadow-amber-500/5">
                <span class="w-2 h-2 rounded-full bg-red-500 animate-pulse"></span>
                <span>Official Video Gallery • Vedic Astrology Discourses</span>
            </div>

            <!-- Page Title -->
            <h1 class="font-cinzel text-3xl sm:text-5xl lg:text-6xl font-black text-white leading-tight tracking-wide">
                VEDIC ASTROLOGY <span class="gold-gradient-text">VIDEO GALLERY</span>
            </h1>

            <div class="flex items-center justify-center space-x-4">
                <div class="h-px w-16 bg-gradient-to-r from-transparent to-amber-400"></div>
                <div class="flex items-center space-x-1 text-amber-400 text-xs">
                    <span>★</span><span>★</span><span>★</span><span>★</span><span>★</span>
                </div>
                <div class="h-px w-16 bg-gradient-to-l from-transparent to-amber-400"></div>
            </div>

            <!-- Subtitle / Speaker Attribution -->
            <p class="font-['Noto_Sans_Malayalam',sans-serif] text-sm sm:text-base text-amber-100/80 leading-relaxed max-w-3xl mx-auto">
                ജ്യോതിഷ കലാരത്നം, വിദ്യാവാചസ്പതി <strong class="text-amber-300 font-bold">DR. ഇ. കെ. രാജ വർമ്മ</strong>യുടെ ആധികാരിക ജ്യോതിഷ പ്രഭാഷണങ്ങൾ, ഓൺലൈൻ കൗൺസിലിംഗ്, വിവാഹ പൊരുത്തം, കാലപുരുഷ വാസ്തു, പഞ്ചമഹായോഗങ്ങൾ, ദോഷ പരിഹാരങ്ങൾ.
            </p>

            <!-- Metadata Quick Ticker -->
            <div class="flex flex-wrap items-center justify-center gap-2 sm:gap-4 text-[11px] sm:text-xs text-amber-200/70 pt-1">
                <span class="px-2.5 py-1 rounded-full bg-[#1b102e] border border-amber-500/20">🎬 {{ $videos->count() }} Premieres</span>
                <span class="px-2.5 py-1 rounded-full bg-[#1b102e] border border-amber-500/20">🔊 Original Malayalam Audio</span>
                <span class="px-2.5 py-1 rounded-full bg-[#1b102e] border border-amber-500/20">✨ 1080p FHD Quality</span>
                <span class="px-2.5 py-1 rounded-full bg-[#1b102e] border border-amber-500/20">🏛️ 30+ Years Wisdom</span>
            </div>
        </div>

        <!-- ========================================================================= -->
        <!-- PROMINENT SPOTLIGHT / BLOCKBUSTER PREMIERE BANNER (LATEST FEATURED VIDEO) -->
        <!-- ========================================================================= -->
        @if($featuredVideo)
        <div class="mb-14 sm:mb-18">
            <div class="relative rounded-3xl p-1 bg-gradient-to-r from-amber-500/50 via-yellow-400/60 to-purple-600/40 shadow-2xl shadow-amber-950/60">
                <div class="rounded-[22px] bg-[#140b22] overflow-hidden border border-amber-500/40 relative">
                    
                    <!-- Ambient Spotlight Behind Video Poster -->
                    <div class="absolute -top-24 -left-24 w-96 h-96 bg-amber-500/10 rounded-full blur-[100px] pointer-events-none"></div>

                    <div class="grid grid-cols-1 lg:grid-cols-12 gap-0 items-center">

                        <!-- Left / Top: Widescreen Movie Trailer Showcase -->
                        <div class="lg:col-span-7 relative group cursor-pointer overflow-hidden bg-black aspect-video"
                             @click="openVideo({
                                 id: '{{ $featuredVideo->id }}',
                                 title: '{{ addslashes($featuredVideo->title) }}',
                                 youtube_id: '{{ $featuredVideo->youtube_id }}',
                                 description: '{{ addslashes($featuredVideo->description) }}',
                                 duration: '{{ $featuredVideo->duration ?? '12:45' }}',
                                 sort_order: {{ $featuredVideo->sort_order }}
                             })">
                            
                            <!-- High Quality YouTube Poster Thumbnail -->
                            <img src="https://img.youtube.com/vi/{{ $featuredVideo->youtube_id }}/hqdefault.jpg"
                                 alt="{{ $featuredVideo->title }}"
                                 class="w-full h-full object-cover transform group-hover:scale-105 transition-transform duration-700 opacity-90 group-hover:opacity-100">
                            
                            <!-- Cinematic Vignette Gradients -->
                            <div class="absolute inset-0 bg-gradient-to-t from-black/90 via-black/30 to-black/30"></div>
                            <div class="absolute inset-0 bg-gradient-to-r from-black/60 via-transparent to-transparent hidden lg:block"></div>

                            <!-- Premiere Top Badges -->
                            <div class="absolute top-4 left-4 flex flex-wrap gap-2">
                                <span class="px-3 py-1 rounded-full text-[11px] font-black uppercase tracking-wider bg-gradient-to-r from-red-600 to-amber-600 text-white shadow-lg flex items-center space-x-1.5">
                                    <span class="w-2 h-2 rounded-full bg-white animate-ping"></span>
                                    <span>FEATURED PREMIERE</span>
                                </span>
                                <span class="px-2.5 py-1 rounded-full text-[10px] font-bold uppercase tracking-wider bg-black/80 backdrop-blur-md text-amber-300 border border-amber-500/40">
                                    4K UHD • YOUTUBE
                                </span>
                            </div>

                            <!-- Duration Badge -->
                            @if($featuredVideo->duration)
                            <div class="absolute top-4 right-4 px-2.5 py-1 rounded-md bg-black/85 backdrop-blur-md border border-white/20 text-white font-mono text-xs font-bold shadow-lg">
                                ⏱ {{ $featuredVideo->duration }}
                            </div>
                            @endif

                            <!-- Giant Glowing Cinema Play Button -->
                            <div class="absolute inset-0 flex items-center justify-center pointer-events-none">
                                <div class="relative">
                                    <div class="w-20 h-20 sm:w-24 sm:h-24 rounded-full bg-gradient-to-tr from-amber-500 via-yellow-400 to-amber-600 p-1 shadow-2xl group-hover:scale-110 transition-transform duration-300 shadow-amber-500/60 flex items-center justify-center animate-pulse">
                                        <div class="w-full h-full rounded-full bg-[#140b22] flex items-center justify-center text-amber-300 pl-1.5 shadow-inner">
                                            <svg class="w-9 h-9 sm:w-10 sm:h-10 fill-current drop-shadow-md" viewBox="0 0 24 24">
                                                <path d="M8 5v14l11-7z"/>
                                            </svg>
                                        </div>
                                    </div>
                                    <span class="absolute -bottom-8 left-1/2 -translate-x-1/2 whitespace-nowrap text-[11px] font-bold uppercase tracking-widest text-amber-200 bg-black/75 px-3 py-0.5 rounded-full border border-amber-500/40 backdrop-blur-sm">
                                        Click To Watch Discourse
                                    </span>
                                </div>
                            </div>

                            <!-- Bottom Left Bar -->
                            <div class="absolute bottom-4 left-4 right-4 flex items-center justify-between text-xs text-amber-200/90 font-medium">
                                <div class="flex items-center space-x-2 bg-black/70 backdrop-blur-md px-3 py-1 rounded-full border border-white/10">
                                    <span>🎙️ Dr. E. K. Raja Varma</span>
                                    <span>•</span>
                                    <span class="text-amber-400">Official Discourse</span>
                                </div>
                            </div>
                        </div>

                        <!-- Right / Bottom: Movie Details & Synopsis -->
                        <div class="lg:col-span-5 p-6 sm:p-8 lg:p-10 space-y-5">
                            
                            <!-- Video Category & Rating -->
                            <div class="flex flex-wrap items-center justify-between gap-2 border-b border-amber-500/20 pb-3">
                                <span class="px-3 py-1 rounded-full text-[11px] font-bold uppercase tracking-wider bg-amber-500/20 text-amber-300 border border-amber-500/30">
                                    ★ Featured Discourse • Episode #{{ $featuredVideo->sort_order }}
                                </span>
                                <div class="flex items-center space-x-1 text-amber-400 text-xs font-semibold">
                                    <span>★ 5.0</span>
                                    <span class="text-amber-200/60 font-normal">(Audience Acclaim)</span>
                                </div>
                            </div>

                            <!-- Video Title -->
                            <h2 class="font-['Noto_Sans_Malayalam',sans-serif] text-xl sm:text-2xl lg:text-3xl font-bold text-white leading-snug">
                                {{ $featuredVideo->title }}
                            </h2>

                            <!-- Synopsis Logline -->
                            <p class="font-['Noto_Sans_Malayalam',sans-serif] text-xs sm:text-sm text-amber-100/80 leading-relaxed line-clamp-4">
                                {{ $featuredVideo->description }}
                            </p>

                            <!-- Cast & Presentation Meta -->
                            <div class="grid grid-cols-2 gap-3 text-xs bg-[#1a102c]/80 rounded-2xl p-3.5 border border-amber-500/20">
                                <div>
                                    <span class="text-amber-300/60 text-[10px] uppercase font-bold block">Scholar / Speaker</span>
                                    <strong class="text-amber-200 font-semibold truncate block">Dr. E. K. Raja Varma</strong>
                                </div>
                                <div>
                                    <span class="text-amber-300/60 text-[10px] uppercase font-bold block">Subject Domain</span>
                                    <strong class="text-amber-200 font-semibold truncate block">Vedic Wisdom & Philosophy</strong>
                                </div>
                            </div>

                            <!-- Interactive Movie Action Buttons -->
                            <div class="pt-2 flex flex-wrap gap-3">
                                <!-- Watch Button -->
                                <button type="button"
                                        @click="openVideo({
                                            id: '{{ $featuredVideo->id }}',
                                            title: '{{ addslashes($featuredVideo->title) }}',
                                            youtube_id: '{{ $featuredVideo->youtube_id }}',
                                            description: '{{ addslashes($featuredVideo->description) }}',
                                            duration: '{{ $featuredVideo->duration ?? '12:45' }}',
                                            sort_order: {{ $featuredVideo->sort_order }}
                                        })"
                                        class="flex-1 min-w-[170px] px-6 py-3.5 rounded-xl font-black text-xs uppercase tracking-wider text-[#1a1128] bg-gradient-to-r from-amber-300 via-yellow-400 to-amber-500 hover:from-amber-200 hover:to-yellow-300 shadow-xl shadow-amber-500/30 hover:scale-[1.02] transition-all flex items-center justify-center space-x-2">
                                    <svg class="w-4 h-4 fill-current" viewBox="0 0 24 24"><path d="M8 5v14l11-7z"/></svg>
                                    <span>Watch Premiere Now</span>
                                </button>

                                <!-- Consult WhatsApp Button -->
                                <a href="https://wa.me/917907052160?text={{ rawurlencode('Namaskaram Dr. E. K. Raja Varma, I watched your featured video discourse: "' . $featuredVideo->title . '" and would like to ask a question.') }}"
                                   target="_blank"
                                   rel="noopener noreferrer"
                                   class="px-4 py-3.5 rounded-xl text-xs font-bold text-amber-200 bg-[#1e1233] border border-amber-500/40 hover:border-amber-300 hover:text-white transition-all flex items-center space-x-2 shrink-0">
                                    <span class="text-emerald-400 text-sm">💬</span>
                                    <span>Ask Dr. Raja Varma</span>
                                </a>

                                <!-- Share Button -->
                                <button type="button"
                                        @click="shareVideo({
                                            title: '{{ addslashes($featuredVideo->title) }}',
                                            youtube_id: '{{ $featuredVideo->youtube_id }}'
                                        })"
                                        class="p-3.5 rounded-xl text-amber-300 bg-[#1e1233] border border-amber-500/40 hover:border-amber-300 hover:text-white transition-all shrink-0"
                                        title="Share Video">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.684 13.342C8.886 12.938 9 12.482 9 12c0-.482-.114-.938-.316-1.342m0 2.684a3 3 0 110-2.684m0 2.684l6.632 3.316m-6.632-6l6.632-3.316m0 0a3 3 0 105.367-2.684 3 3 0 00-5.367 2.684zm0 9.316a3 3 0 105.368 2.684 3 3 0 00-5.368-2.684z"/>
                                    </svg>
                                </button>
                            </div>

                        </div>

                    </div>
                </div>
            </div>
        </div>
        @endif

        <!-- ========================================================================= -->
        <!-- CINEMA CONTROLS: CATEGORY GENRE TABS & INSTANT SEARCH BAR                 -->
        <!-- ========================================================================= -->
        <div class="mb-10 space-y-4">
            
            <div class="flex flex-col md:flex-row items-stretch md:items-center justify-between gap-4 bg-[#140b22]/90 border border-amber-500/30 rounded-2xl p-3 sm:p-4 shadow-xl">
                
                <!-- Category Pills (Genre Filter) -->
                <div class="flex items-center gap-1.5 overflow-x-auto pb-1 md:pb-0 scrollbar-none">
                    <button type="button"
                            @click="activeCategory = 'all'"
                            :class="activeCategory === 'all' ? 'bg-gradient-to-r from-amber-400 to-yellow-500 text-[#140b22] font-black' : 'text-amber-200/80 hover:text-white bg-[#1e1233] border border-amber-500/20'"
                            class="px-3.5 py-2 rounded-xl text-xs whitespace-nowrap transition-all shadow-sm">
                        🎬 All Discourses
                    </button>
                    <button type="button"
                            @click="activeCategory = 'marriage'"
                            :class="activeCategory === 'marriage' ? 'bg-gradient-to-r from-amber-400 to-yellow-500 text-[#140b22] font-black' : 'text-amber-200/80 hover:text-white bg-[#1e1233] border border-amber-500/20'"
                            class="px-3.5 py-2 rounded-xl text-xs whitespace-nowrap transition-all shadow-sm">
                        💍 Marriage & Compatibility
                    </button>
                    <button type="button"
                            @click="activeCategory = 'education'"
                            :class="activeCategory === 'education' ? 'bg-gradient-to-r from-amber-400 to-yellow-500 text-[#140b22] font-black' : 'text-amber-200/80 hover:text-white bg-[#1e1233] border border-amber-500/20'"
                            class="px-3.5 py-2 rounded-xl text-xs whitespace-nowrap transition-all shadow-sm">
                        📚 Education & Learning
                    </button>
                    <button type="button"
                            @click="activeCategory = 'psychology'"
                            :class="activeCategory === 'psychology' ? 'bg-gradient-to-r from-amber-400 to-yellow-500 text-[#140b22] font-black' : 'text-amber-200/80 hover:text-white bg-[#1e1233] border border-amber-500/20'"
                            class="px-3.5 py-2 rounded-xl text-xs whitespace-nowrap transition-all shadow-sm">
                        💬 Love & Psychology
                    </button>
                    <button type="button"
                            @click="activeCategory = 'counselling'"
                            :class="activeCategory === 'counselling' ? 'bg-gradient-to-r from-amber-400 to-yellow-500 text-[#140b22] font-black' : 'text-amber-200/80 hover:text-white bg-[#1e1233] border border-amber-500/20'"
                            class="px-3.5 py-2 rounded-xl text-xs whitespace-nowrap transition-all shadow-sm">
                        🔮 Online Astrology
                    </button>
                    <button type="button"
                            @click="activeCategory = 'literary'"
                            :class="activeCategory === 'literary' ? 'bg-gradient-to-r from-amber-400 to-yellow-500 text-[#140b22] font-black' : 'text-amber-200/80 hover:text-white bg-[#1e1233] border border-amber-500/20'"
                            class="px-3.5 py-2 rounded-xl text-xs whitespace-nowrap transition-all shadow-sm">
                        📜 Poetry & Philosophy
                    </button>
                </div>

                <!-- Live Search Box -->
                <div class="relative min-w-[240px] sm:min-w-[280px]">
                    <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-amber-400/60">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                        </svg>
                    </div>
                    <input type="text"
                           x-model="searchQuery"
                           placeholder="Search videos (e.g. പൊരുത്തം, വിദ്യാഭ്യാസം)..."
                           class="w-full pl-9 pr-8 py-2 rounded-xl bg-[#1b102e] border border-amber-500/30 text-xs text-white placeholder-amber-200/40 focus:outline-none focus:border-amber-400">
                    <button type="button"
                            x-show="searchQuery"
                            @click="searchQuery = ''"
                            class="absolute inset-y-0 right-0 pr-3 flex items-center text-amber-400/60 hover:text-white">
                        ✕
                    </button>
                </div>

            </div>
        </div>

        <!-- ========================================================================= -->
        <!-- THE VIDEO GALLERY GRID: STRICTLY 2 COLUMNS ON MOBILE, 3-4 ON PC           -->
        <!-- ========================================================================= -->
        <div class="space-y-4">
            
            <div class="flex items-center justify-between text-xs text-amber-200/70 px-1">
                <span class="font-cinzel uppercase tracking-wider font-bold text-amber-300">
                    Discourses Collection (<span x-text="'{{ $videos->count() }} Discourses'"></span>)
                </span>
                <span class="text-[11px] text-amber-300/60">
                    Tap any video to play discourse
                </span>
            </div>

            <!-- GRID CONTAINER: 2 columns on mobile (grid-cols-2), 3 on tablet (md:grid-cols-3), 4 on PC (lg:grid-cols-4) -->
            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-3 sm:gap-6">
                
                @foreach($videos as $video)
                @php
                    // Categorize video for filtering
                    $titleLower = mb_strtolower($video->title);
                    $descLower = mb_strtolower($video->description);
                    $category = 'counselling';
                    if (str_contains($titleLower, 'കണ്ടവരുണ്ടോ') || str_contains($titleLower, 'കവിത')) {
                        $category = 'literary';
                    } elseif (str_contains($titleLower, 'കല്യാണം') || str_contains($titleLower, 'പൊരുത്തം') || str_contains($titleLower, 'ചൊവ്വാദോഷം') || str_contains($titleLower, 'വിവാഹ')) {
                        $category = 'marriage';
                    } elseif (str_contains($titleLower, 'പഠിക്കാൻ') || str_contains($titleLower, 'പഠന') || str_contains($titleLower, 'വിദ്യാഭ്യാസം')) {
                        $category = 'education';
                    } elseif (str_contains($titleLower, 'മെസ്സേജ്') || str_contains($titleLower, 'പ്രണയം')) {
                        $category = 'psychology';
                    } elseif (str_contains($titleLower, 'വാസ്തു') || str_contains($titleLower, 'ശരീരഭാഗങ്ങൾ') || str_contains($titleLower, 'കാലപുരുഷ')) {
                        $category = 'vaastu';
                    } elseif (str_contains($titleLower, 'ഓൺലൈൻ') || str_contains($titleLower, 'ജ്യോതിഷം')) {
                        $category = 'counselling';
                    }
                @endphp

                <!-- Movie Poster Card -->
                <div x-show="matchesFilter('{{ addslashes(mb_strtolower($video->title)) }}', '{{ addslashes(mb_strtolower($video->description)) }}', '{{ $category }}')"
                     x-transition:enter="transition ease-out duration-300"
                     x-transition:enter-start="opacity-0 scale-95"
                     x-transition:enter-end="opacity-100 scale-100"
                     class="group relative rounded-2xl sm:rounded-3xl p-0.5 bg-gradient-to-b from-amber-500/25 via-amber-500/10 to-purple-900/30 hover:from-amber-400/80 hover:via-yellow-400/40 hover:to-amber-600/50 transition-all duration-300 shadow-xl hover:shadow-2xl hover:shadow-amber-500/20 flex flex-col">
                    
                    <div class="rounded-[15px] sm:rounded-[22px] bg-[#140b22] h-full flex flex-col justify-between overflow-hidden border border-amber-500/20 group-hover:border-amber-400/60 transition-all">
                        
                        <div>
                            <!-- Movie Poster Thumbnail Frame -->
                            <div class="relative aspect-video bg-black cursor-pointer overflow-hidden"
                                 @click="openVideo({
                                     id: '{{ $video->id }}',
                                     title: '{{ addslashes($video->title) }}',
                                     youtube_id: '{{ $video->youtube_id }}',
                                     description: '{{ addslashes($video->description) }}',
                                     duration: '{{ $video->duration ?? '12:00' }}',
                                     sort_order: {{ $video->sort_order }}
                                 })">
                                
                                <img src="https://img.youtube.com/vi/{{ $video->youtube_id }}/hqdefault.jpg"
                                     alt="{{ $video->title }}"
                                     loading="lazy"
                                     class="w-full h-full object-cover transform group-hover:scale-108 transition-transform duration-500 opacity-90 group-hover:opacity-100">
                                
                                <!-- Vignette Overlay -->
                                <div class="absolute inset-0 bg-gradient-to-t from-black/90 via-black/20 to-transparent"></div>

                                <!-- Center Glowing Play Icon -->
                                <div class="absolute inset-0 flex items-center justify-center">
                                    <div class="w-10 h-10 sm:w-14 sm:h-14 rounded-full bg-gradient-to-tr from-amber-500 via-yellow-400 to-amber-600 p-0.5 shadow-xl group-hover:scale-115 transition-transform duration-300 shadow-amber-500/40">
                                        <div class="w-full h-full rounded-full bg-[#140b22]/90 flex items-center justify-center text-amber-300 pl-0.5 sm:pl-1">
                                            <svg class="w-4 h-4 sm:w-6 sm:h-6 fill-current" viewBox="0 0 24 24"><path d="M8 5v14l11-7z"/></svg>
                                        </div>
                                    </div>
                                </div>

                                <!-- Episode Badge (Top Left) -->
                                <div class="absolute top-2 left-2 sm:top-2.5 sm:left-2.5">
                                    <span class="px-1.5 sm:px-2 py-0.5 rounded text-[9px] sm:text-[10px] font-black uppercase tracking-wider {{ $video->sort_order == 1 ? 'bg-red-600 text-white shadow-md' : 'bg-black/80 text-amber-300 border border-amber-500/40 backdrop-blur-sm' }}">
                                        {{ $video->sort_order == 1 ? 'PREMIERE' : 'EP #' . $video->sort_order }}
                                    </span>
                                </div>

                                <!-- Duration Badge (Bottom Right) -->
                                @if($video->duration)
                                <div class="absolute bottom-2 right-2 px-1.5 py-0.5 rounded bg-black/85 text-[9px] sm:text-[10px] font-mono text-white/90 border border-white/20">
                                    {{ $video->duration }}
                                </div>
                                @endif

                                <!-- Category Pill (Bottom Left) -->
                                <div class="absolute bottom-2 left-2 hidden sm:block">
                                    <span class="px-1.5 py-0.5 rounded text-[9px] uppercase font-bold bg-[#140b22]/90 text-amber-300/90 border border-amber-500/30">
                                        {{ ucfirst($category) }}
                                    </span>
                                </div>
                            </div>

                            <!-- Poster Details -->
                            <div class="p-3 sm:p-5 space-y-2">
                                
                                <!-- Speaker Name -->
                                <div class="flex items-center space-x-1 text-[10px] sm:text-xs text-amber-400/80 font-medium truncate">
                                    <span>Dr. E. K. Raja Varma</span>
                                </div>

                                <!-- Movie Title (2-Line Clamped) -->
                                <h3 class="font-['Noto_Sans_Malayalam',sans-serif] text-xs sm:text-sm font-bold text-white group-hover:text-amber-300 transition-colors leading-snug line-clamp-2"
                                    title="{{ $video->title }}">
                                    {{ $video->title }}
                                </h3>

                                <!-- Synopsis snippet (Hidden on small mobile for clean card, visible on tablet/PC) -->
                                <p class="font-['Noto_Sans_Malayalam',sans-serif] text-[11px] text-amber-100/70 line-clamp-2 leading-relaxed hidden sm:block">
                                    {{ $video->description }}
                                </p>
                            </div>
                        </div>

                        <!-- Card Footer / Actions -->
                        <div class="p-2.5 sm:p-4 pt-1 sm:pt-2 border-t border-amber-500/10 space-y-2">
                            
                            <!-- Watch & Direct YouTube Links -->
                            <div class="flex items-center justify-between text-[10px] sm:text-xs">
                                <button type="button"
                                        @click="openVideo({
                                            id: '{{ $video->id }}',
                                            title: '{{ addslashes($video->title) }}',
                                            youtube_id: '{{ $video->youtube_id }}',
                                            description: '{{ addslashes($video->description) }}',
                                            duration: '{{ $video->duration ?? '12:00' }}',
                                            sort_order: {{ $video->sort_order }}
                                        })"
                                        class="text-amber-400 hover:text-amber-200 font-bold flex items-center space-x-1 transition-colors">
                                    <svg class="w-3 h-3 fill-current" viewBox="0 0 24 24"><path d="M8 5v14l11-7z"/></svg>
                                    <span>Play Video</span>
                                </button>

                                <a href="https://youtu.be/{{ $video->youtube_id }}"
                                   target="_blank"
                                   rel="noopener noreferrer"
                                   class="text-red-400 hover:text-red-300 flex items-center space-x-1 transition-colors font-medium">
                                    <svg class="w-3 h-3 fill-current" viewBox="0 0 24 24"><path d="M19.615 3.184c-3.604-.246-11.631-.245-15.23 0-3.897.266-4.356 2.62-4.385 8.816.029 6.185.484 8.549 4.385 8.816 3.6.245 11.626.246 15.23 0 3.897-.266 4.356-2.62 4.385-8.816-.029-6.185-.484-8.549-4.385-8.816zm-10.615 12.816v-8l8 3.993-8 4.007z"/></svg>
                                    <span class="hidden sm:inline">YouTube</span>
                                </a>
                            </div>

                            <!-- WhatsApp Inquiry Button -->
                            <a href="https://wa.me/917907052160?text={{ rawurlencode('Namaskaram Dr. E. K. Raja Varma, I watched your YouTube video: "' . $video->title . '" and would like to ask a question.') }}"
                               target="_blank"
                               rel="noopener noreferrer"
                               class="w-full py-1.5 sm:py-2 px-2 rounded-lg sm:rounded-xl text-[10px] sm:text-[11px] font-semibold text-amber-200/90 bg-[#1e1233] border border-amber-500/30 hover:border-amber-400 hover:text-white flex items-center justify-center space-x-1 transition-all">
                                <span class="text-emerald-400">💬</span>
                                <span class="truncate">Ask Dr. Raja Varma</span>
                            </a>

                        </div>

                    </div>
                </div>
                @endforeach

            </div>

        </div>

        <!-- ========================================================================= -->
        <!-- VIP PREMIERE PASS / ASTROLOGY CONSULTATION TICKET SECTION                 -->
        <!-- ========================================================================= -->
        <div class="mt-16 sm:mt-24">
            <div class="relative rounded-3xl p-1 bg-gradient-to-r from-amber-500/40 via-yellow-400/50 to-amber-600/40 shadow-2xl shadow-amber-950/40">
                <div class="rounded-[22px] bg-[#140b22] p-6 sm:p-10 border border-amber-500/30 relative overflow-hidden">
                    
                    <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-center">
                        <div class="lg:col-span-8 space-y-4">
                            <div class="inline-flex items-center space-x-2 text-[10px] sm:text-xs font-bold uppercase tracking-wider text-amber-300 bg-amber-500/10 px-3 py-1 rounded-full border border-amber-500/30">
                                <span>🎟️ VIP Box • Direct Personal Astrology Consultation</span>
                            </div>
                            <h2 class="font-cinzel text-2xl sm:text-3xl lg:text-4xl font-black text-white">
                                Consult With <span class="gold-gradient-text">Dr. E. K. Raja Varma</span>
                            </h2>
                            <p class="font-['Noto_Sans_Malayalam',sans-serif] text-xs sm:text-sm text-amber-100/80 leading-relaxed">
                                വിഡിയോകളിൽ പ്രതിപാദിച്ച ദോഷ പരിഹാരങ്ങൾ, വിവാഹ പൊരുത്തം, ജാതക വിശകലനം, കാലപുരുഷ വാസ്തു എന്നിവ സംബന്ധിച്ച് താങ്കളുടെ സ്വന്തം ജാതക പ്രകാരം വിശദമായി സംസാരിക്കുന്നതിനായി നേരിട്ടോ ഫോൺ/വാട്ട്സ്ആപ്പ് വഴിയോ കൺസൾട്ട് ചെയ്യാം.
                            </p>
                            <div class="flex flex-wrap gap-2 text-[11px] text-amber-200/70 pt-1">
                                <span class="px-2 py-0.5 rounded bg-[#1e1233] border border-amber-500/20">✓ 100% Confidential</span>
                                <span class="px-2 py-0.5 rounded bg-[#1e1233] border border-amber-500/20">✓ WhatsApp Audio / Video Available</span>
                                <span class="px-2 py-0.5 rounded bg-[#1e1233] border border-amber-500/20">✓ Global Clients (Kerala, UAE, USA)</span>
                            </div>
                        </div>

                        <div class="lg:col-span-4 flex flex-col gap-3">
                            <button type="button"
                                    @click="$dispatch('open-booking-modal', { service: 'Accurate Predictions' })"
                                    class="w-full py-4 rounded-xl font-black text-xs uppercase tracking-wider text-[#140b22] bg-gradient-to-r from-amber-300 via-yellow-400 to-amber-500 hover:from-amber-200 hover:to-yellow-300 shadow-xl shadow-amber-500/30 transition-all text-center">
                                Book Consultation Online
                            </button>
                            <a href="https://wa.me/917907052160?text={{ rawurlencode('Namaskaram Dr. E. K. Raja Varma, I would like to book a personal Vedic astrology consultation session.') }}"
                               target="_blank"
                               rel="noopener noreferrer"
                               class="w-full py-3.5 rounded-xl font-bold text-xs text-white bg-emerald-700/80 hover:bg-emerald-600 border border-emerald-500/40 shadow-lg transition-all flex items-center justify-center space-x-2">
                                <span>💬</span>
                                <span>WhatsApp (+91 7907052160)</span>
                            </a>
                            <a href="tel:+919447327450"
                               class="w-full py-2.5 rounded-xl font-medium text-[11px] text-amber-200 bg-[#1e1233] border border-amber-500/30 text-center hover:text-white transition-all">
                                Direct Call / GPay: 094473 27450
                            </a>
                        </div>
                    </div>

                </div>
            </div>
        </div>

        <!-- Official YouTube Channel Subscribe Banner -->
        <div class="mt-14 text-center">
            <a href="https://www.youtube.com/@CovilakamAstrology"
               target="_blank"
               rel="noopener noreferrer"
               class="inline-flex items-center space-x-3 px-6 sm:px-8 py-3.5 sm:py-4 rounded-2xl bg-[#140b22] border-2 border-red-500/50 hover:border-red-400 text-white font-bold text-xs uppercase tracking-wider shadow-xl hover:shadow-red-500/20 transition-all hover:scale-105">
                <span class="w-7 h-7 rounded-full bg-red-600 flex items-center justify-center text-white shrink-0">
                    <svg class="w-4 h-4 fill-current" viewBox="0 0 24 24"><path d="M19.615 3.184c-3.604-.246-11.631-.245-15.23 0-3.897.266-4.356 2.62-4.385 8.816.029 6.185.484 8.549 4.385 8.816 3.6.245 11.626.246 15.23 0 3.897-.266 4.356-2.62 4.385-8.816-.029-6.185-.484-8.549-4.385-8.816zm-10.615 12.816v-8l8 3.993-8 4.007z"/></svg>
                </span>
                <span>Subscribe to Covilakam Astrology YouTube Channel</span>
                <span class="text-amber-400">→</span>
            </a>
        </div>

    </div>

    <!-- ========================================================================= -->
    <!-- CINEMA THEATER LIGHTBOX MODAL WITH AUTOPLAY YOUTUBE PLAYER                -->
    <!-- ========================================================================= -->
    <div x-show="activeVideoModal"
         x-cloak
         class="fixed inset-0 z-50 overflow-y-auto"
         role="dialog" aria-modal="true">
        
        <!-- Backdrop -->
        <div x-show="activeVideoModal"
             x-transition:enter="ease-out duration-300"
             x-transition:enter-start="opacity-0"
             x-transition:enter-end="opacity-100"
             x-transition:leave="ease-in duration-200"
             x-transition:leave-start="opacity-100"
             x-transition:leave-end="opacity-0"
             @click="closeVideo()"
             class="fixed inset-0 bg-black/95 backdrop-blur-xl transition-opacity"></div>

        <!-- Theater Modal Window -->
        <div class="flex min-h-full items-center justify-center p-2 sm:p-4 text-center">
            <div x-show="activeVideoModal"
                 x-transition:enter="ease-out duration-300"
                 x-transition:enter-start="opacity-0 scale-95"
                 x-transition:enter-end="opacity-100 scale-100"
                 x-transition:leave="ease-in duration-200"
                 x-transition:leave-start="opacity-100 scale-100"
                 x-transition:leave-end="opacity-0 scale-95"
                 @click.stop
                 class="relative transform overflow-hidden rounded-2xl sm:rounded-3xl bg-[#140b22] border-2 border-amber-500/50 text-left shadow-2xl transition-all w-full max-w-4xl my-4">

                <!-- Theater Top Bar -->
                <div class="px-4 sm:px-6 py-3 bg-[#0d0716] border-b border-amber-500/30 flex items-center justify-between">
                    <div class="flex items-center space-x-2">
                        <span class="w-3 h-3 rounded-full bg-red-500"></span>
                        <span class="w-3 h-3 rounded-full bg-yellow-500"></span>
                        <span class="w-3 h-3 rounded-full bg-emerald-500"></span>
                        <span class="text-xs font-mono text-amber-300/80 ml-2">Vedic Video Player • Covilakam Astrology</span>
                    </div>

                    <!-- Close Button -->
                    <button type="button"
                            @click="closeVideo()"
                            class="p-1.5 rounded-full text-amber-300 hover:text-white hover:bg-white/10 transition-colors focus:outline-none"
                            aria-label="Close Video Player">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                    </button>
                </div>

                <!-- 16:9 Cinema Screen Player Frame -->
                <div class="relative aspect-video bg-black w-full overflow-hidden">
                    <template x-if="activeVideoModal && currentVideo.youtube_id">
                        <iframe :src="'https://www.youtube-nocookie.com/embed/' + currentVideo.youtube_id + '?autoplay=1&rel=0&modestbranding=1&playsinline=1'"
                                class="w-full h-full border-0"
                                allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                                allowfullscreen>
                        </iframe>
                    </template>
                </div>

                <!-- Movie Info in Modal -->
                <div class="p-5 sm:p-7 space-y-4 bg-[#140b22]">
                    <div class="flex flex-wrap items-center justify-between gap-2">
                        <span class="px-3 py-1 rounded-full text-xs font-bold bg-amber-500/20 text-amber-300 border border-amber-500/30"
                              x-text="'Discourse #' + currentVideo.sort_order">
                        </span>
                        
                        <div class="flex items-center space-x-2">
                            <button type="button"
                                    @click="shareVideo(currentVideo)"
                                    class="px-3 py-1.5 rounded-lg text-xs font-semibold text-amber-300 bg-[#1e1233] border border-amber-500/40 hover:text-white flex items-center space-x-1.5">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.684 13.342C8.886 12.938 9 12.482 9 12c0-.482-.114-.938-.316-1.342m0 2.684a3 3 0 110-2.684m0 2.684l6.632 3.316m-6.632-6l6.632-3.316m0 0a3 3 0 105.367-2.684 3 3 0 00-5.367 2.684zm0 9.316a3 3 0 105.368 2.684 3 3 0 00-5.368-2.684z"/></svg>
                                <span>Share Discourse</span>
                            </button>

                            <a :href="'https://youtu.be/' + currentVideo.youtube_id"
                               target="_blank"
                               rel="noopener noreferrer"
                               class="px-3 py-1.5 rounded-lg text-xs font-semibold text-red-400 bg-red-500/10 border border-red-500/30 hover:bg-red-500/20 flex items-center space-x-1">
                                <span>YouTube ↗</span>
                            </a>
                        </div>
                    </div>

                    <h3 class="font-['Noto_Sans_Malayalam',sans-serif] text-lg sm:text-2xl font-bold text-white leading-snug"
                        x-text="currentVideo.title">
                    </h3>

                    <p class="font-['Noto_Sans_Malayalam',sans-serif] text-xs sm:text-sm text-amber-100/80 leading-relaxed max-h-40 overflow-y-auto pr-2"
                       x-text="currentVideo.description">
                    </p>

                    <!-- Interactive Bottom Consultation CTA Bar -->
                    <div class="pt-3 border-t border-amber-500/20 flex flex-col sm:flex-row items-stretch sm:items-center justify-between gap-3">
                        <div class="text-xs text-amber-200/70">
                            <span>Have personal astrological queries regarding this discourse?</span>
                        </div>
                        
                        <div class="flex items-center gap-2">
                            <a :href="'https://wa.me/917907052160?text=' + encodeURIComponent('Namaskaram Dr. E. K. Raja Varma, I just watched your video discourse: \'' + currentVideo.title + '\' and would like to ask a question.')"
                               target="_blank"
                               rel="noopener noreferrer"
                               class="flex-1 sm:flex-none px-4 py-2.5 rounded-xl font-bold text-xs text-[#140b22] bg-gradient-to-r from-amber-300 via-yellow-400 to-amber-500 hover:from-amber-200 hover:to-yellow-300 flex items-center justify-center space-x-1.5 shadow-md">
                                <span>💬 Consult on WhatsApp</span>
                            </a>
                            <button type="button"
                                    @click="closeVideo(); $dispatch('open-booking-modal', { service: 'Accurate Predictions' })"
                                    class="px-4 py-2.5 rounded-xl font-semibold text-xs text-amber-200 bg-[#1e1233] border border-amber-500/40 hover:text-white">
                                Book Reading
                            </button>
                        </div>
                    </div>
                </div>

            </div>
        </div>

    </div>

</div>

@php
    $videoSchemaList = [];
    foreach($videos as $vid) {
        $videoSchemaList[] = [
            '@type' => 'VideoObject',
            'name' => $vid->title,
            'description' => $vid->description,
            'thumbnailUrl' => [$vid->thumbnail_url],
            'uploadDate' => $vid->created_at ? $vid->created_at->toIso8601String() : '2026-01-01T00:00:00+05:30',
            'embedUrl' => $vid->embed_url,
            'contentUrl' => 'https://youtu.be/' . $vid->youtube_id,
            'duration' => 'PT12M00S',
            'author' => [
                '@type' => 'Person',
                'name' => 'Dr. E. K. Raja Varma',
                'jobTitle' => 'Vidya Vachaspathi in Vedic Astrology'
            ]
        ];
    }
    $schemaPayload = [
        '@context' => 'https://schema.org',
        '@graph' => $videoSchemaList,
    ];
@endphp
<script type="application/ld+json">
{!! json_encode($schemaPayload, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT) !!}
</script>
@endsection

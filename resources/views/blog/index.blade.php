@extends('layouts.app')

@section('title', 'Astrology Blogs & Vedic Articles | Dr. E. K. Raja Varma (Vidya Vachaspathi in Vedic Astrology)')
@section('meta_description', 'Explore articles on Vedic Astrology, Marriage Matching (Porutham), Navaratna Gemology, and Online Astro Counselling by Dr. E. K. Raja Varma.')

@section('content')
<div class="pt-32 pb-24 bg-[#0d0716] min-h-screen">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <!-- Header -->
        <div class="text-center max-w-3xl mx-auto mb-16 space-y-3">
            <span class="text-xs font-bold uppercase tracking-widest text-amber-400 bg-amber-500/10 px-3.5 py-1 rounded-full border border-amber-500/30">
                Covilakam Wisdom Portal
            </span>
            <h1 class="font-cinzel text-3xl sm:text-5xl font-black text-white">
                Vedic Astrology Articles
            </h1>
            <div class="w-24 h-1 bg-gradient-to-r from-transparent via-amber-400 to-transparent mx-auto"></div>
            <p class="text-xs sm:text-sm text-amber-100/70">
                In-depth articles authored by <strong>Dr. E. K. Raja Varma</strong> (Vidya Vachaspathi in Vedic Astrology) to illuminate your spiritual and worldly path.
            </p>
        </div>

        <!-- Filter & Search Bar -->
        <div class="mb-12 p-4 rounded-2xl bg-[#190f2b] border border-amber-500/25 flex flex-col md:flex-row items-center justify-between gap-4">
            <!-- Categories -->
            <div class="flex flex-wrap items-center gap-2 text-xs">
                <a href="{{ route('blog.index') }}"
                   class="px-3.5 py-1.5 rounded-xl font-semibold transition-colors {{ !request('category') ? 'bg-amber-400 text-black' : 'text-amber-200/80 bg-[#251540] hover:text-white' }}">
                    All Categories
                </a>
                @foreach($categories as $cat)
                <a href="{{ route('blog.index', ['category' => $cat]) }}"
                   class="px-3.5 py-1.5 rounded-xl font-semibold transition-colors {{ request('category') === $cat ? 'bg-amber-400 text-black' : 'text-amber-200/80 bg-[#251540] hover:text-white' }}">
                    {{ $cat }}
                </a>
                @endforeach
            </div>

            <!-- Search Form -->
            <form action="{{ route('blog.index') }}" method="GET" class="w-full md:w-72">
                @if(request('category'))
                    <input type="hidden" name="category" value="{{ request('category') }}">
                @endif
                <div class="relative">
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Search articles..."
                           class="w-full px-4 py-2 pl-9 rounded-xl bg-[#251540] border border-amber-500/30 text-xs text-white placeholder-amber-200/40 focus:outline-none focus:border-amber-400">
                    <svg class="w-4 h-4 text-amber-400/60 absolute left-3 top-2.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                    </svg>
                </div>
            </form>
        </div>

        <!-- Blog Posts Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            @forelse($posts as $post)
            @php
                $cardImageUrl = $post->featured_image
                    ? (str_starts_with($post->featured_image, 'http')
                        ? $post->featured_image
                        : (str_starts_with($post->featured_image, 'images/')
                            ? asset($post->featured_image)
                            : asset('storage/' . $post->featured_image)))
                    : asset('images/og-covilakam-1200x630.jpg');
                $cardPostUrl = route('blog.show', $post->slug);
                $cardExcerpt = Str::limit(strip_tags($post->excerpt ?: $post->body), 130);
            @endphp
            <article class="card-gold-frame rounded-3xl overflow-hidden flex flex-col justify-between group">
                <div>
                    <!-- Image -->
                    <div class="relative aspect-video overflow-hidden border-b border-amber-500/30">
                        <a href="{{ $cardPostUrl }}" class="block w-full h-full">
                            <img src="{{ $cardImageUrl }}"
                                 alt="{{ $post->title }}"
                                 onerror="this.onerror=null; this.src='data:image/svg+xml;utf8,<svg xmlns=\'http://www.w3.org/2000/svg\' width=\'400\' height=\'250\' viewBox=\'0 0 400 250\'><rect width=\'100%\' height=\'100%\' fill=\'%231a1128\'/><text x=\'50%\' y=\'55%\' font-size=\'40\' fill=\'%23f3e5ab\' dominant-baseline=\'middle\' text-anchor=\'middle\'>ॐ</text></svg>';"
                                 class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                        </a>
                        <span class="absolute top-3 left-3 px-2.5 py-1 rounded-full text-[10px] font-bold bg-[#1a1128]/90 text-amber-300 border border-amber-500/40 backdrop-blur-md pointer-events-none">
                            {{ $post->category }}
                        </span>
                        <button type="button"
                                onclick="shareCovilakamBlog({
                                    title: @js($post->title),
                                    excerpt: @js($cardExcerpt),
                                    url: @js($cardPostUrl),
                                    imageUrl: @js($cardImageUrl)
                                }, this)"
                                title="Share Blog with Featured Image"
                                class="absolute top-3 right-3 px-2.5 py-1 rounded-full text-[10px] font-bold bg-[#1a1128]/90 hover:bg-amber-400 text-amber-300 hover:text-[#1a1128] border border-amber-500/50 backdrop-blur-md flex items-center space-x-1 transition-all cursor-pointer shadow-lg">
                            <svg class="w-3 h-3" fill="none" stroke="currentColor" stroke-width="2.2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M8.684 13.342C8.886 12.938 9 12.482 9 12c0-.482-.114-.938-.316-1.342m0 2.684a3 3 0 110-2.684m0 2.684l6.632 3.316m-6.632-6l6.632-3.316m0 0a3 3 0 105.367-2.684 3 3 0 00-5.367 2.684zm0 9.316a3 3 0 105.368 2.684 3 3 0 00-5.368-2.684z"/>
                            </svg>
                            <span>Share</span>
                        </button>
                    </div>

                    <!-- Details -->
                    <div class="p-6 space-y-3">
                        <div class="flex items-center justify-between text-[11px] text-amber-300/70">
                            <span>{{ $post->reading_time }}</span>
                            <span>{{ $post->published_at ? $post->published_at->format('d M Y') : 'Recent' }}</span>
                        </div>

                        <h2 class="font-cinzel text-lg font-bold text-white group-hover:text-amber-300 transition-colors leading-snug">
                            <a href="{{ $cardPostUrl }}">
                                {{ $post->title }}
                            </a>
                        </h2>

                        <p class="text-xs text-amber-100/75 line-clamp-3 leading-relaxed">
                            {{ $post->excerpt }}
                        </p>
                    </div>
                </div>

                <!-- Footer -->
                <div class="px-6 pb-6 pt-3 border-t border-amber-500/20">
                    <div class="flex items-center justify-between gap-2">
                        <div class="text-[11px] text-amber-200/80 min-w-0">
                            <span class="block text-amber-400 font-semibold truncate max-w-[160px]">
                                {{ $post->author_name }}
                            </span>
                        </div>
                        <div class="flex items-center space-x-2 shrink-0">
                            <button type="button"
                                    onclick="copyCovilakamBlogLink(@js($cardPostUrl), this, @js($post->title))"
                                    title="Copy Blog Link"
                                    class="px-2.5 py-1 rounded-lg text-[11px] font-bold text-amber-200 bg-[#251540] hover:bg-amber-400 hover:text-[#1a1128] border border-amber-500/30 flex items-center space-x-1 transition-all cursor-pointer">
                                <span>Copy Link</span>
                            </button>
                            <button type="button"
                                    onclick="shareCovilakamBlog({
                                        title: @js($post->title),
                                        excerpt: @js($cardExcerpt),
                                        url: @js($cardPostUrl),
                                        imageUrl: @js($cardImageUrl)
                                    }, this)"
                                    title="Share Blog with Image"
                                    class="px-2.5 py-1 rounded-lg text-[11px] font-bold text-amber-300 bg-[#251540] hover:bg-amber-400 hover:text-[#1a1128] border border-amber-500/30 flex items-center space-x-1 transition-all cursor-pointer">
                                <svg class="w-3 h-3" fill="none" stroke="currentColor" stroke-width="2.2" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M8.684 13.342C8.886 12.938 9 12.482 9 12c0-.482-.114-.938-.316-1.342m0 2.684a3 3 0 110-2.684m0 2.684l6.632 3.316m-6.632-6l6.632-3.316m0 0a3 3 0 105.367-2.684 3 3 0 00-5.367 2.684zm0 9.316a3 3 0 105.368 2.684 3 3 0 00-5.368-2.684z"/>
                                </svg>
                                <span>Share</span>
                            </button>
                            <a href="{{ $cardPostUrl }}"
                               class="text-xs font-bold text-amber-300 hover:text-white transition-colors">
                                Read →
                            </a>
                        </div>
                    </div>
                </div>
            </article>
            @empty
            <div class="col-span-3 text-center py-16">
                <p class="text-amber-200/70 text-sm">No articles found matching your criteria.</p>
                <a href="{{ route('blog.index') }}" class="text-xs text-amber-400 underline mt-2 inline-block">Reset filters</a>
            </div>
            @endforelse
        </div>

        <!-- Pagination -->
        <div class="mt-12">
            {{ $posts->links() }}
        </div>

    </div>
</div>
@endsection

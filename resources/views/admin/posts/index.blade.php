@extends('layouts.admin')

@section('title', 'Vedic Wisdom Repository Management | Covilakam Astrology')
@section('page_title', 'Vedic Wisdom Repository: Astrology Articles')

@section('content')
<div class="space-y-6">

    <!-- Header Actions -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <h1 class="font-cinzel text-2xl font-black text-white">
                Vedic Wisdom Repository
            </h1>
            <p class="text-xs text-amber-200/70 mt-1">
                Manage all astrological insights, remedies, and articles appearing on the live website blog section.
            </p>
        </div>

        <a href="{{ route('admin.posts.create') }}"
           class="px-5 py-3 rounded-xl font-bold text-xs text-[#1a1128] bg-gradient-to-r from-amber-300 via-yellow-400 to-amber-500 hover:from-amber-200 hover:to-yellow-300 shadow-xl hover:shadow-amber-500/20 transition-all flex items-center space-x-2 self-start">
            <span class="text-base font-black">+</span>
            <span>Write New Article</span>
        </a>
    </div>

    <!-- Filters Bar -->
    <div class="p-4 rounded-2xl bg-[#160d26] border border-amber-500/25 flex flex-wrap items-center justify-between gap-4 text-xs">
        <form method="GET" action="{{ route('admin.posts.index') }}" class="flex flex-wrap items-center gap-3">
            <input type="text" name="search" value="{{ request('search') }}"
                   placeholder="Search articles by title or keyword..."
                   class="px-3.5 py-2 rounded-xl bg-[#211335] border border-amber-500/30 text-white placeholder-amber-200/40 focus:outline-none focus:border-amber-400 text-xs w-64">

            <select name="category" onchange="this.form.submit()"
                    class="px-3 py-2 rounded-xl bg-[#211335] border border-amber-500/30 text-amber-200 text-xs">
                <option value="">All Categories</option>
                @foreach($categories as $cat)
                <option value="{{ $cat }}" {{ request('category') === $cat ? 'selected' : '' }}>{{ $cat }}</option>
                @endforeach
            </select>

            <select name="status" onchange="this.form.submit()"
                    class="px-3 py-2 rounded-xl bg-[#211335] border border-amber-500/30 text-amber-200 text-xs">
                <option value="">All Statuses</option>
                <option value="published" {{ request('status') === 'published' ? 'selected' : '' }}>Published</option>
                <option value="draft" {{ request('status') === 'draft' ? 'selected' : '' }}>Draft</option>
            </select>

            <button type="submit"
                    class="px-4 py-2 rounded-xl bg-amber-500/20 text-amber-300 hover:bg-amber-500/30 border border-amber-500/40 font-semibold">
                Filter
            </button>

            @if(request()->hasAny(['search', 'category', 'status']))
            <a href="{{ route('admin.posts.index') }}" class="text-amber-400 hover:text-white underline">Clear</a>
            @endif
        </form>

        <div class="text-amber-300/70 text-[11px] font-mono">
            Showing {{ $posts->total() }} total articles
        </div>
    </div>

    <!-- Posts Grid / List -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @forelse($posts as $post)
        <div class="rounded-3xl bg-[#160d26] border border-amber-500/30 overflow-hidden flex flex-col justify-between hover:border-amber-400 transition-all shadow-xl group">
            <div>
                <!-- Featured Image or Fallback -->
                <div class="aspect-[16/9] bg-[#201335] relative overflow-hidden border-b border-amber-500/20">
                    @if($post->featured_image)
                    <img src="{{ str_starts_with($post->featured_image, 'http') ? $post->featured_image : asset($post->featured_image) }}"
                         alt="{{ $post->title }}"
                         class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                    @else
                    <div class="w-full h-full flex items-center justify-center bg-gradient-to-tr from-[#1a1128] to-[#251540] text-amber-300/40 text-4xl">
                        📜
                    </div>
                    @endif

                    <!-- Category & Status Badge -->
                    <div class="absolute top-3 left-3 flex items-center space-x-1.5">
                        <span class="px-2.5 py-0.5 rounded-full text-[10px] font-bold uppercase bg-amber-500/90 text-[#1a1128]">
                            {{ $post->category }}
                        </span>
                    </div>

                    <div class="absolute top-3 right-3">
                        <span class="px-2 py-0.5 rounded-full text-[10px] font-bold {{ $post->published_at && $post->published_at <= now() ? 'bg-emerald-500/90 text-white' : 'bg-amber-600/90 text-white' }}">
                            {{ $post->published_at && $post->published_at <= now() ? 'Published' : 'Draft' }}
                        </span>
                    </div>

                    @if($post->reading_time)
                    <div class="absolute bottom-2 right-2 px-2 py-0.5 rounded bg-black/80 text-[10px] text-white/90 font-mono">
                        {{ $post->reading_time }}
                    </div>
                    @endif
                </div>

                <!-- Body Content -->
                <div class="p-6 space-y-3">
                    <h3 class="font-['Noto_Sans_Malayalam',sans-serif] text-base font-bold text-white group-hover:text-amber-300 transition-colors leading-snug line-clamp-2">
                        {{ $post->title }}
                    </h3>

                    <p class="font-['Noto_Sans_Malayalam',sans-serif] text-xs text-amber-100/70 line-clamp-3 leading-relaxed">
                        {{ $post->excerpt }}
                    </p>
                </div>
            </div>

            <!-- Footer Details & Actions -->
            <div class="px-6 pb-6 pt-3 border-t border-amber-500/15 space-y-3">
                <div class="flex items-center justify-between text-[11px] text-amber-300/60 font-mono">
                    <span>{{ $post->published_at ? $post->published_at->format('M d, Y') : 'Not published' }}</span>
                    <a href="{{ route('blog.show', $post->slug) }}" target="_blank" class="text-amber-400 hover:text-white underline">
                        View Live ↗
                    </a>
                </div>

                <div class="flex items-center justify-between gap-2 pt-1">
                    <a href="{{ route('admin.posts.edit', $post->id) }}"
                       class="flex-1 py-2 px-3 rounded-xl text-center text-xs font-semibold text-amber-200 bg-[#211335] border border-amber-500/30 hover:border-amber-400 transition-colors">
                        ✏️ Edit Article
                    </a>

                    <form action="{{ route('admin.posts.destroy', $post->id) }}"
                          method="POST"
                          onsubmit="return confirm('Are you sure you want to delete article: {{ addslashes($post->title) }}?');"
                          class="inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit"
                                class="p-2 rounded-xl text-rose-400 hover:bg-rose-900/40 border border-rose-500/30 transition-colors"
                                title="Delete Article">
                            🗑️
                        </button>
                    </form>
                </div>
            </div>

        </div>
        @empty
        <div class="col-span-full py-16 text-center text-amber-200/60 bg-[#160d26] rounded-3xl border border-amber-500/20">
            No articles found. Click "+ Write New Article" above to create one.
        </div>
        @endforelse
    </div>

    <!-- Pagination -->
    <div class="mt-6">
        {{ $posts->links() }}
    </div>

</div>
@endsection

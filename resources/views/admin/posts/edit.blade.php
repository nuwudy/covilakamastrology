@extends('layouts.admin')

@section('title', 'Edit Astrology Article | Covilakam Astrology')
@section('page_title', 'Edit Article')

@section('content')
<div class="max-w-4xl mx-auto space-y-6">

    <!-- Breadcrumb & Back -->
    <div class="flex items-center justify-between">
        <a href="{{ route('admin.posts.index') }}"
           class="text-xs text-amber-400 hover:text-amber-200 flex items-center space-x-1 transition-colors">
            <span>← Back to Articles Repository</span>
        </a>

        <div class="flex items-center space-x-3">
            <a href="{{ route('blog.show', $post->slug) }}" target="_blank"
               class="text-xs text-amber-300 hover:text-white underline font-mono">
                View Live Article ↗
            </a>
            <span class="text-xs text-amber-300/70 font-mono">
                ID: {{ $post->id }}
            </span>
        </div>
    </div>

    <!-- Main Form Card -->
    <div class="rounded-3xl bg-[#160d26] border border-amber-500/30 p-6 sm:p-10 shadow-2xl space-y-8">
        
        <div>
            <h2 class="font-cinzel text-xl sm:text-2xl font-bold text-white">
                Edit Vedic Astrology Article
            </h2>
            <p class="text-xs text-amber-100/70 mt-1 font-['Noto_Sans_Malayalam',sans-serif]">
                {{ $post->title }}
            </p>
        </div>

        <form action="{{ route('admin.posts.update', $post->id) }}" method="POST" enctype="multipart/form-data" class="space-y-6 text-xs">
            @csrf
            @method('PUT')

            <!-- Article Title -->
            <div>
                <label class="block font-semibold text-amber-200 mb-1.5">
                    Article Title (Malayalam or English) *
                </label>
                <input type="text" name="title" value="{{ old('title', $post->title) }}" required
                       class="w-full px-4 py-3 rounded-xl bg-[#211335] border border-amber-500/30 text-white placeholder-amber-200/40 focus:outline-none focus:border-amber-400 font-['Noto_Sans_Malayalam',sans-serif] text-sm font-bold">
            </div>

            <!-- Slug & Category -->
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label class="block font-semibold text-amber-200 mb-1.5">
                        URL Slug *
                    </label>
                    <input type="text" name="slug" value="{{ old('slug', $post->slug) }}" required
                           class="w-full px-4 py-3 rounded-xl bg-[#211335] border border-amber-500/30 text-white placeholder-amber-200/40 focus:outline-none focus:border-amber-400 font-mono text-xs">
                </div>

                <div>
                    <label class="block font-semibold text-amber-200 mb-1.5">
                        Category *
                    </label>
                    <select name="category" required
                            class="w-full px-4 py-3 rounded-xl bg-[#211335] border border-amber-500/30 text-amber-200 focus:outline-none focus:border-amber-400 text-xs">
                        @foreach($categories as $cat)
                        <option value="{{ $cat }}" {{ old('category', $post->category) === $cat ? 'selected' : '' }}>{{ $cat }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <!-- Reading Time & Author -->
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label class="block font-semibold text-amber-200 mb-1.5">
                        Reading Time (Estimated)
                    </label>
                    <input type="text" name="reading_time" value="{{ old('reading_time', $post->reading_time) }}"
                           class="w-full px-4 py-3 rounded-xl bg-[#211335] border border-amber-500/30 text-white placeholder-amber-200/40 focus:outline-none focus:border-amber-400 text-xs font-mono">
                </div>

                <div>
                    <label class="block font-semibold text-amber-200 mb-1.5">
                        Author Name
                    </label>
                    <input type="text" name="author_name" value="{{ old('author_name', $post->author_name) }}"
                           class="w-full px-4 py-3 rounded-xl bg-[#211335] border border-amber-500/30 text-white placeholder-amber-200/40 focus:outline-none focus:border-amber-400 text-xs">
                </div>
            </div>

            <!-- Featured Image (Upload or URL) -->
            <div class="p-5 rounded-2xl bg-[#211335] border border-amber-500/30 space-y-4">
                <div class="flex items-center justify-between">
                    <label class="block font-semibold text-amber-200">
                        Featured Image
                    </label>
                    @if($post->featured_image)
                    <span class="text-[11px] text-amber-300 font-mono">Current: {{ $post->featured_image }}</span>
                    @endif
                </div>

                @if($post->featured_image)
                <div class="w-40 aspect-video rounded-xl bg-black overflow-hidden border border-amber-500/30 mb-2">
                    <img src="{{ str_starts_with($post->featured_image, 'http') ? $post->featured_image : asset($post->featured_image) }}"
                         alt="Current Featured Image"
                         class="w-full h-full object-cover">
                </div>
                @endif

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <span class="block text-[11px] text-amber-300/80 mb-1">Replace with New File:</span>
                        <input type="file" name="featured_image_file" accept="image/*"
                               class="w-full px-3 py-2 rounded-xl bg-[#160d26] border border-amber-500/30 text-amber-200 text-xs file:mr-3 file:py-1.5 file:px-3 file:rounded-lg file:border-0 file:text-xs file:font-semibold file:bg-amber-500 file:text-black hover:file:bg-amber-400">
                    </div>

                    <div>
                        <span class="block text-[11px] text-amber-300/80 mb-1">Or Direct Image URL / Path:</span>
                        <input type="text" name="featured_image_url" value="{{ old('featured_image_url', $post->featured_image) }}"
                               class="w-full px-3 py-2.5 rounded-xl bg-[#160d26] border border-amber-500/30 text-white placeholder-amber-200/40 focus:outline-none focus:border-amber-400 text-xs font-mono">
                    </div>
                </div>
            </div>

            <!-- Excerpt (Summary) -->
            <div>
                <label class="block font-semibold text-amber-200 mb-1.5">
                    Excerpt / Short Summary (Malayalam or English) *
                </label>
                <textarea name="excerpt" rows="3" required
                          class="w-full px-4 py-3 rounded-xl bg-[#211335] border border-amber-500/30 text-white placeholder-amber-200/40 focus:outline-none focus:border-amber-400 font-['Noto_Sans_Malayalam',sans-serif] text-xs leading-relaxed">{{ old('excerpt', $post->excerpt) }}</textarea>
            </div>

            <!-- Full Article Body -->
            <div>
                <label class="block font-semibold text-amber-200 mb-1.5">
                    Full Article Content (HTML / Rich Text Supported) *
                </label>
                <textarea name="body" rows="14" required
                          class="w-full px-4 py-3 rounded-xl bg-[#211335] border border-amber-500/30 text-white placeholder-amber-200/40 focus:outline-none focus:border-amber-400 font-mono text-xs leading-relaxed">{{ old('body', $post->body) }}</textarea>
            </div>

            <!-- Publishing Controls -->
            <div class="p-4 rounded-2xl bg-[#211335] border border-amber-500/30 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                <label class="flex items-center space-x-3 text-amber-200 cursor-pointer">
                    <input type="checkbox" name="is_published" value="1" {{ old('is_published', $post->published_at !== null) ? 'checked' : '' }}
                           class="w-4 h-4 rounded bg-[#160d26] border-amber-500/40 text-amber-500 focus:ring-0">
                    <span class="font-bold">Published on Website</span>
                </label>

                <div class="flex items-center space-x-2">
                    <span class="text-amber-200/80">Publish Date:</span>
                    <input type="datetime-local" name="published_at" value="{{ old('published_at', $post->published_at ? $post->published_at->format('Y-m-d\TH:i') : now()->format('Y-m-d\TH:i')) }}"
                           class="px-3 py-1.5 rounded-xl bg-[#160d26] border border-amber-500/30 text-amber-300 font-mono text-xs">
                </div>
            </div>

            <!-- Form Submit Buttons -->
            <div class="pt-4 border-t border-amber-500/20 flex items-center justify-end space-x-3">
                <a href="{{ route('admin.posts.index') }}"
                   class="px-5 py-3 rounded-xl font-medium text-xs text-amber-200 bg-[#211335] border border-amber-500/30 hover:border-amber-400 transition-colors">
                    Cancel
                </a>

                <button type="submit"
                        class="px-8 py-3 rounded-xl font-bold text-xs text-[#1a1128] bg-gradient-to-r from-amber-300 via-yellow-400 to-amber-500 hover:from-amber-200 hover:to-yellow-300 shadow-xl hover:shadow-amber-500/30 transition-all">
                    Update Article
                </button>
            </div>

        </form>

    </div>

</div>
@endsection

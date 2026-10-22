@extends('layouts.admin')

@section('title', 'Write New Astrology Article | Covilakam Astrology')
@section('page_title', 'Write New Article')

@section('content')
<div class="max-w-4xl mx-auto space-y-6">

    <!-- Breadcrumb & Back -->
    <div class="flex items-center justify-between">
        <a href="{{ route('admin.posts.index') }}"
           class="text-xs text-amber-400 hover:text-amber-200 flex items-center space-x-1 transition-colors">
            <span>← Back to Articles Repository</span>
        </a>

        <span class="text-xs text-amber-300/70 font-mono">
            New Article Draft
        </span>
    </div>

    <!-- Main Form Card -->
    <div class="rounded-3xl bg-[#160d26] border border-amber-500/30 p-6 sm:p-10 shadow-2xl space-y-8">
        
        <div>
            <h2 class="font-cinzel text-xl sm:text-2xl font-bold text-white">
                Create Vedic Astrology Insight or Article
            </h2>
            <p class="text-xs text-amber-100/70 mt-1">
                Share authentic Vedic insights, planetary remedies, marriage compatibility guidelines, and spiritual wisdom.
            </p>
        </div>

        <form action="{{ route('admin.posts.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6 text-xs">
            @csrf

            <!-- Article Title -->
            <div>
                <label class="block font-semibold text-amber-200 mb-1.5">
                    Article Title (Malayalam or English) *
                </label>
                <input type="text" name="title" value="{{ old('title') }}" required
                       placeholder="e.g. ജ്യോതിഷവും ജീവിതസരണിയും (Astrology and the Path of Life)"
                       class="w-full px-4 py-3 rounded-xl bg-[#211335] border border-amber-500/30 text-white placeholder-amber-200/40 focus:outline-none focus:border-amber-400 font-['Noto_Sans_Malayalam',sans-serif] text-sm font-bold">
            </div>

            <!-- Slug & Category -->
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label class="block font-semibold text-amber-200 mb-1.5">
                        URL Slug (Optional - auto generated if blank)
                    </label>
                    <input type="text" name="slug" value="{{ old('slug') }}"
                           placeholder="e.g. jyothisham-jeevithasaranium"
                           class="w-full px-4 py-3 rounded-xl bg-[#211335] border border-amber-500/30 text-white placeholder-amber-200/40 focus:outline-none focus:border-amber-400 font-mono text-xs">
                </div>

                <div>
                    <label class="block font-semibold text-amber-200 mb-1.5">
                        Category *
                    </label>
                    <select name="category" required
                            class="w-full px-4 py-3 rounded-xl bg-[#211335] border border-amber-500/30 text-amber-200 focus:outline-none focus:border-amber-400 text-xs">
                        @foreach($categories as $cat)
                        <option value="{{ $cat }}" {{ old('category') === $cat ? 'selected' : '' }}>{{ $cat }}</option>
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
                    <input type="text" name="reading_time" value="{{ old('reading_time', '5 min read') }}"
                           placeholder="e.g. 6 min read"
                           class="w-full px-4 py-3 rounded-xl bg-[#211335] border border-amber-500/30 text-white placeholder-amber-200/40 focus:outline-none focus:border-amber-400 text-xs font-mono">
                </div>

                <div>
                    <label class="block font-semibold text-amber-200 mb-1.5">
                        Author Name
                    </label>
                    <input type="text" name="author_name" value="{{ old('author_name', 'Dr. E. K. Raja Varma (Vidya Vachaspathi in Vedic Astrology)') }}"
                           class="w-full px-4 py-3 rounded-xl bg-[#211335] border border-amber-500/30 text-white placeholder-amber-200/40 focus:outline-none focus:border-amber-400 text-xs">
                </div>
            </div>

            <!-- Featured Image (Upload or URL) -->
            <div class="p-5 rounded-2xl bg-[#211335] border border-amber-500/30 space-y-4">
                <label class="block font-semibold text-amber-200">
                    Featured Image (Upload file OR provide image path/URL)
                </label>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <span class="block text-[11px] text-amber-300/80 mb-1">Upload Image File (WebP/JPG/PNG):</span>
                        <input type="file" name="featured_image_file" accept="image/*"
                               class="w-full px-3 py-2 rounded-xl bg-[#160d26] border border-amber-500/30 text-amber-200 text-xs file:mr-3 file:py-1.5 file:px-3 file:rounded-lg file:border-0 file:text-xs file:font-semibold file:bg-amber-500 file:text-black hover:file:bg-amber-400">
                    </div>

                    <div>
                        <span class="block text-[11px] text-amber-300/80 mb-1">Or Direct Image URL / Local Path:</span>
                        <input type="text" name="featured_image_url" value="{{ old('featured_image_url') }}"
                               placeholder="e.g. images/blog-jyothisham.jpg or https://..."
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
                          placeholder="ലേഖനത്തിന്റെ സംഗ്രഹം ഇവിടെ നൽകുക..."
                          class="w-full px-4 py-3 rounded-xl bg-[#211335] border border-amber-500/30 text-white placeholder-amber-200/40 focus:outline-none focus:border-amber-400 font-['Noto_Sans_Malayalam',sans-serif] text-xs leading-relaxed">{{ old('excerpt') }}</textarea>
                <p class="text-[11px] text-amber-300/60 mt-1">Appears on article cards on the homepage and blog listing.</p>
            </div>

            <!-- Full Article Body -->
            <div>
                <label class="block font-semibold text-amber-200 mb-1.5">
                    Full Article Content (HTML / Rich Text Supported) *
                </label>
                <textarea name="body" rows="12" required
                          placeholder="<p>ലേഖനത്തിന്റെ വിശദമായ ഉള്ളടക്കം ഇവിടെ നൽകുക...</p>
<h3>ഉപശീർഷകം</h3>
<p>വിവരണം...</p>"
                          class="w-full px-4 py-3 rounded-xl bg-[#211335] border border-amber-500/30 text-white placeholder-amber-200/40 focus:outline-none focus:border-amber-400 font-mono text-xs leading-relaxed">{{ old('body') }}</textarea>
                <p class="text-[11px] text-amber-300/60 mt-1">
                    Supports HTML elements: <code>&lt;p&gt;</code>, <code>&lt;h2&gt;</code>, <code>&lt;h3&gt;</code>, <code>&lt;ul&gt;</code>, <code>&lt;li&gt;</code>, <code>&lt;blockquote&gt;</code>, <code>&lt;strong&gt;</code>.
                </p>
            </div>

            <!-- Publishing Controls -->
            <div class="p-4 rounded-2xl bg-[#211335] border border-amber-500/30 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                <label class="flex items-center space-x-3 text-amber-200 cursor-pointer">
                    <input type="checkbox" name="is_published" value="1" {{ old('is_published', true) ? 'checked' : '' }}
                           class="w-4 h-4 rounded bg-[#160d26] border-amber-500/40 text-amber-500 focus:ring-0">
                    <span class="font-bold">Publish Immediately on Website</span>
                </label>

                <div class="flex items-center space-x-2">
                    <span class="text-amber-200/80">Publish Date:</span>
                    <input type="datetime-local" name="published_at" value="{{ old('published_at', now()->format('Y-m-d\TH:i')) }}"
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
                    Publish Article to Repository
                </button>
            </div>

        </form>

    </div>

</div>
@endsection

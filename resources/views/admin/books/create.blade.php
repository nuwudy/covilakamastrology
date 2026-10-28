@extends('layouts.admin')

@section('title', 'Add New Book | Covilakam Astrology')
@section('page_title', 'Add Book')

@section('content')
<div class="max-w-4xl mx-auto space-y-6">

    <!-- Header Actions -->
    <div class="flex items-center justify-between">
        <div>
            <h1 class="font-cinzel text-2xl font-black text-white">
                Add New Book / Publication
            </h1>
            <p class="text-xs text-amber-200/70 mt-1">
                Publish a work authored by Dr. E. K. Raja Varma.
            </p>
        </div>

        <a href="{{ route('admin.books.index') }}"
           class="px-4 py-2 rounded-xl text-xs font-semibold text-amber-200 bg-[#201335] border border-amber-500/30 hover:border-amber-400 transition-colors">
            ← Back to Books
        </a>
    </div>

    @if($errors->any())
        <div class="p-4 rounded-2xl bg-red-500/20 border border-red-500/40 text-red-200 text-xs space-y-1">
            @foreach($errors->all() as $error)
                <p>• {{ $error }}</p>
            @endforeach
        </div>
    @endif

    <!-- Form Card -->
    <div class="rounded-3xl bg-[#160d26] border border-amber-500/30 p-6 sm:p-8 shadow-2xl">
        <form action="{{ route('admin.books.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-semibold text-amber-300 uppercase mb-1">Book Title *</label>
                    <input type="text" name="title" value="{{ old('title') }}" required placeholder="e.g. മനോരഥം (Manoratham)"
                           class="w-full px-3.5 py-2.5 rounded-xl bg-[#0f0819] border border-amber-500/30 text-amber-100 text-xs focus:border-amber-400 focus:outline-none">
                </div>

                <div>
                    <label class="block text-xs font-semibold text-amber-300 uppercase mb-1">Malayalam Title</label>
                    <input type="text" name="malayalam_title" value="{{ old('malayalam_title') }}" placeholder="e.g. മനോരഥം"
                           class="w-full px-3.5 py-2.5 rounded-xl bg-[#0f0819] border border-amber-500/30 text-amber-100 text-xs focus:border-amber-400 focus:outline-none">
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-semibold text-amber-300 uppercase mb-1">Subtitle</label>
                    <input type="text" name="subtitle" value="{{ old('subtitle') }}" placeholder="e.g. മനസ്സിന്റെ രഥം - സാഹിത്യ കൃതി"
                           class="w-full px-3.5 py-2.5 rounded-xl bg-[#0f0819] border border-amber-500/30 text-amber-100 text-xs focus:border-amber-400 focus:outline-none">
                </div>

                <div>
                    <label class="block text-xs font-semibold text-amber-300 uppercase mb-1">Publisher</label>
                    <input type="text" name="publisher" value="{{ old('publisher') }}" placeholder="e.g. JB Publications"
                           class="w-full px-3.5 py-2.5 rounded-xl bg-[#0f0819] border border-amber-500/30 text-amber-100 text-xs focus:border-amber-400 focus:outline-none">
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                <div>
                    <label class="block text-xs font-semibold text-amber-300 uppercase mb-1">Price (₹ INR)</label>
                    <input type="number" step="0.01" name="price" value="{{ old('price', 100) }}" placeholder="100.00"
                           class="w-full px-3.5 py-2.5 rounded-xl bg-[#0f0819] border border-amber-500/30 text-amber-100 text-xs focus:border-amber-400 focus:outline-none">
                </div>

                <div>
                    <label class="block text-xs font-semibold text-amber-300 uppercase mb-1">Sort Order *</label>
                    <input type="number" name="sort_order" value="{{ old('sort_order', $nextSortOrder ?? 1) }}" required
                           class="w-full px-3.5 py-2.5 rounded-xl bg-[#0f0819] border border-amber-500/30 text-amber-100 text-xs focus:border-amber-400 focus:outline-none">
                </div>

                <div class="flex items-center pt-6">
                    <label class="flex items-center space-x-2 text-xs font-semibold text-amber-200 cursor-pointer">
                        <input type="checkbox" name="is_active" value="1" {{ old('is_active', true) ? 'checked' : '' }}
                               class="rounded border-amber-500/40 text-amber-500 focus:ring-amber-400 bg-[#0f0819] w-4 h-4">
                        <span>Active / Visible on Website</span>
                    </label>
                </div>
            </div>

            <div>
                <label class="block text-xs font-semibold text-amber-300 uppercase mb-1">Preview / FlipHTML5 / Dropbox URL</label>
                <input type="url" name="ebook_url" value="{{ old('ebook_url') }}" placeholder="https://online.fliphtml5.com/... or https://www.dropbox.com/..."
                       class="w-full px-3.5 py-2.5 rounded-xl bg-[#0f0819] border border-amber-500/30 text-amber-100 text-xs focus:border-amber-400 focus:outline-none">
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-semibold text-amber-300 uppercase mb-1">Cover Image Path</label>
                    <input type="text" name="cover_image" value="{{ old('cover_image', 'images/books/manoratham.jpg') }}" placeholder="images/books/your-book.jpg"
                           class="w-full px-3.5 py-2.5 rounded-xl bg-[#0f0819] border border-amber-500/30 text-amber-100 text-xs focus:border-amber-400 focus:outline-none">
                </div>

                <div>
                    <label class="block text-xs font-semibold text-amber-300 uppercase mb-1">Or Upload Cover Image File</label>
                    <input type="file" name="cover_image_file" accept="image/*"
                           class="w-full px-3.5 py-2 rounded-xl bg-[#0f0819] border border-amber-500/30 text-amber-100 text-xs focus:border-amber-400 focus:outline-none file:mr-3 file:py-1 file:px-2.5 file:rounded-lg file:border-0 file:text-[11px] file:bg-amber-500/20 file:text-amber-300 hover:file:bg-amber-500/30">
                </div>
            </div>

            <div>
                <label class="block text-xs font-semibold text-amber-300 uppercase mb-1">Description *</label>
                <textarea name="description" rows="4" required placeholder="Write a summary of the book in Malayalam or English..."
                          class="w-full px-3.5 py-2.5 rounded-xl bg-[#0f0819] border border-amber-500/30 text-amber-100 text-xs focus:border-amber-400 focus:outline-none">{{ old('description') }}</textarea>
            </div>

            <div class="pt-4 border-t border-amber-500/20 flex items-center justify-end space-x-3">
                <a href="{{ route('admin.books.index') }}"
                   class="px-5 py-2.5 rounded-xl text-xs font-semibold text-amber-200 hover:bg-white/5 transition-colors">
                    Cancel
                </a>
                <button type="submit"
                        class="px-6 py-2.5 rounded-xl font-bold text-xs text-[#1a1128] bg-gradient-to-r from-amber-300 via-yellow-400 to-amber-500 hover:from-amber-200 hover:to-yellow-300 shadow-xl transition-all">
                    Save & Publish Book
                </button>
            </div>
        </form>
    </div>
</div>
@endsection

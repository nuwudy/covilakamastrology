@extends('layouts.admin')

@section('title', 'Books & Publications Management | Covilakam Astrology')
@section('page_title', 'Books & Publications')

@section('content')
<div class="space-y-6">

    <!-- Header Actions -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <h1 class="font-cinzel text-2xl font-black text-white">
                Books & Creative Publications
            </h1>
            <p class="text-xs text-amber-200/70 mt-1">
                Manage the published literary works and audio albums authored by <strong>DR. E. K. Raja Varma (Vidya Vachaspathi in Vedic Astrology)</strong>.
            </p>
        </div>

        <a href="{{ route('admin.books.create') }}"
           class="px-5 py-3 rounded-xl font-bold text-xs text-[#1a1128] bg-gradient-to-r from-amber-300 via-yellow-400 to-amber-500 hover:from-amber-200 hover:to-yellow-300 shadow-xl hover:shadow-amber-500/20 transition-all flex items-center space-x-2 self-start">
            <span class="text-base font-black">+</span>
            <span>Add New Book / Publication</span>
        </a>
    </div>

    <!-- Alert Success -->
    @if(session('success'))
        <div class="p-4 rounded-2xl bg-emerald-500/20 border border-emerald-500/40 text-emerald-200 text-xs flex items-center space-x-2">
            <span>✓</span>
            <span>{{ session('success') }}</span>
        </div>
    @endif

    <!-- Books Table -->
    <div class="rounded-3xl bg-[#160d26] border border-amber-500/30 overflow-hidden shadow-2xl">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse text-xs">
                <thead>
                    <tr class="bg-[#12091c] border-b border-amber-500/20 text-amber-300/80 uppercase tracking-wider text-[10px]">
                        <th class="py-4 px-4 font-bold text-center w-16">Order</th>
                        <th class="py-4 px-4 font-bold w-28">Cover</th>
                        <th class="py-4 px-4 font-bold">Book Title & Details</th>
                        <th class="py-4 px-4 font-bold w-36">Publisher</th>
                        <th class="py-4 px-4 font-bold w-28">Price (₹)</th>
                        <th class="py-4 px-4 font-bold text-center w-24">Status</th>
                        <th class="py-4 px-4 font-bold text-right w-36">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-amber-500/15">
                    @forelse($books as $book)
                    <tr class="hover:bg-amber-500/5 transition-colors">
                        <!-- Sort Order -->
                        <td class="py-4 px-4 text-center">
                            <span class="w-8 h-8 rounded-xl bg-[#201335] border border-amber-500/40 font-mono font-bold text-amber-300 inline-flex items-center justify-center text-xs">
                                {{ $book->sort_order }}
                            </span>
                        </td>

                        <!-- Cover Thumbnail -->
                        <td class="py-4 px-4">
                            <div class="w-20 h-28 rounded-xl overflow-hidden bg-black/40 border border-amber-500/30 flex items-center justify-center p-1 shadow-md">
                                <img src="{{ asset($book->cover_image) }}"
                                     alt="{{ $book->title }}"
                                     class="w-full h-full object-contain rounded">
                            </div>
                        </td>

                        <!-- Title & Info -->
                        <td class="py-4 px-4 space-y-1">
                            <strong class="text-amber-200 text-sm block">
                                {{ $book->title }}
                            </strong>
                            @if($book->subtitle)
                                <p class="text-[11px] text-amber-400 font-medium">
                                    {{ $book->subtitle }}
                                </p>
                            @endif
                            <p class="text-[11px] text-amber-100/70 line-clamp-2 max-w-xl">
                                {{ $book->description }}
                            </p>
                            @if($book->ebook_url)
                                <a href="{{ $book->ebook_url }}" target="_blank" class="inline-flex items-center space-x-1 text-[10px] text-amber-300 hover:underline pt-0.5">
                                    <span>🔗</span>
                                    <span>{{ str_contains($book->ebook_url, 'fliphtml5') ? 'Interactive Flipbook' : 'Dropbox Preview' }}</span>
                                </a>
                            @endif
                        </td>

                        <!-- Publisher -->
                        <td class="py-4 px-4 text-amber-300/90 font-medium">
                            {{ $book->publisher ?: 'Covilakam' }}
                        </td>

                        <!-- Price -->
                        <td class="py-4 px-4 font-cinzel text-sm font-bold text-amber-300">
                            {{ $book->formatted_price }}
                        </td>

                        <!-- Status -->
                        <td class="py-4 px-4 text-center">
                            @if($book->is_active)
                                <span class="px-2.5 py-1 rounded-full text-[10px] font-bold bg-emerald-500/20 text-emerald-300 border border-emerald-500/40">
                                    Active
                                </span>
                            @else
                                <span class="px-2.5 py-1 rounded-full text-[10px] font-bold bg-gray-500/20 text-gray-400 border border-gray-500/40">
                                    Draft
                                </span>
                            @endif
                        </td>

                        <!-- Actions -->
                        <td class="py-4 px-4 text-right">
                            <div class="flex items-center justify-end space-x-2">
                                <a href="{{ route('admin.books.edit', $book) }}"
                                   class="p-2 rounded-lg bg-[#201335] text-amber-300 hover:bg-amber-500/20 border border-amber-500/30 transition-colors"
                                   title="Edit Book">
                                    ✏️
                                </a>

                                <form action="{{ route('admin.books.destroy', $book) }}"
                                      method="POST"
                                      onsubmit="return confirm('Are you sure you want to delete this book?');"
                                      class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                            class="p-2 rounded-lg bg-[#201335] text-red-400 hover:bg-red-500/20 border border-red-500/30 transition-colors"
                                            title="Delete Book">
                                        🗑️
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="py-12 text-center text-amber-200/60">
                            No books or publications found. Click "Add New Book" to publish.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection

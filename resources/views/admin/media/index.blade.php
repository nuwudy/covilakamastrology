@extends('layouts.admin')

@section('title', 'Admin Media Library | Covilakam Astrology')
@section('page_title', 'Covilakam Media Library (WebP Engine)')

@section('content')
<div class="py-2"
     x-data="{
        uploadModalOpen: false,
        editModalOpen: false,
        editItem: null,
        copiedToast: false,
        copiedUrl: '',

        copyToClipboard(url) {
            navigator.clipboard.writeText(url).then(() => {
                this.copiedUrl = url;
                this.copiedToast = true;
                setTimeout(() => { this.copiedToast = false; }, 2500);
            });
        },

        openEdit(item) {
            this.editItem = item;
            this.editModalOpen = true;
        }
     }">

    <!-- Toast Notification -->
    <div x-show="copiedToast"
         x-cloak
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0 translate-y-4"
         x-transition:enter-end="opacity-100 translate-y-0"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="opacity-100 translate-y-0"
         x-transition:leave-end="opacity-0 translate-y-4"
         class="fixed bottom-8 left-1/2 -translate-x-1/2 z-50 px-5 py-3 rounded-2xl bg-emerald-600 text-white font-bold text-xs shadow-2xl flex items-center space-x-2 border border-emerald-400">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
        </svg>
        <span>Media URL copied to clipboard! Ready to paste into blogs, services, or reports.</span>
    </div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <!-- Header & Top Stats -->
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-6 mb-10">
            <div>
                <div class="inline-flex items-center space-x-2 text-xs uppercase tracking-widest text-amber-400 font-bold bg-amber-500/10 px-3 py-1 rounded-full border border-amber-500/30 mb-2">
                    <span>Admin Portal</span>
                    <span>•</span>
                    <span>Auto-WebP Optimization Active</span>
                </div>
                <h1 class="font-cinzel text-3xl sm:text-4xl font-extrabold text-white">
                    Covilakam Media Library
                </h1>
                <p class="text-xs sm:text-sm text-amber-100/70 mt-1">
                    Upload and manage high-speed WebP images, sacred audio mantras, video discourses, and PDF Jathakam documents.
                </p>
            </div>

            <!-- Header Action Buttons -->
            <div class="flex items-center space-x-3">
                @auth
                <div class="hidden sm:flex flex-col items-end text-right">
                    <span class="text-xs font-bold text-amber-200">{{ auth()->user()->name }}</span>
                    <span class="text-[10px] text-amber-300/70 font-mono">{{ auth()->user()->email }}</span>
                </div>
                <form action="{{ route('admin.logout') }}" method="POST" class="inline">
                    @csrf
                    <button type="submit"
                            title="Sign Out"
                            class="px-3.5 py-3 rounded-xl font-semibold text-xs text-rose-300 bg-rose-950/50 hover:bg-rose-900/60 border border-rose-500/30 transition-all flex items-center space-x-1.5">
                        <span>Sign Out</span>
                    </button>
                </form>
                @endauth

                @guest
                <a href="{{ route('admin.login') }}"
                   class="px-4 py-3 rounded-xl font-semibold text-xs text-amber-200 bg-[#251540] hover:bg-[#321a54] border border-amber-500/30 transition-all">
                    Sign In
                </a>
                @endguest

                <button @click="uploadModalOpen = true"
                        class="px-5 py-3.5 rounded-xl font-bold text-xs sm:text-sm text-[#1a1128] bg-gradient-to-r from-amber-300 via-yellow-400 to-amber-500 hover:from-amber-200 hover:to-yellow-300 shadow-xl flex items-center space-x-2 transition-all">
                    <svg class="w-4 h-4 text-[#1a1128]" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/>
                    </svg>
                    <span>Upload New Media</span>
                </button>
            </div>
        </div>

        @if(session('success'))
        <div class="mb-8 p-4 rounded-2xl bg-emerald-950/70 border border-emerald-500/40 text-emerald-200 text-xs flex items-center justify-between">
            <div class="flex items-center space-x-2">
                <span>✨</span>
                <span>{{ session('success') }}</span>
            </div>
            <button onclick="this.parentElement.remove()" class="text-emerald-400 hover:text-white">&times;</button>
        </div>
        @endif

        <!-- Media Categories & Storage Summary Metrics -->
        <div class="grid grid-cols-2 sm:grid-cols-5 gap-3 sm:gap-4 mb-8">
            <div class="p-4 rounded-2xl bg-[#190f2b] border border-amber-500/30 flex items-center space-x-3">
                <span class="text-2xl">📁</span>
                <div>
                    <span class="text-[10px] text-amber-300/70 uppercase block font-bold">Total Assets</span>
                    <span class="font-cinzel text-xl font-black text-white">{{ $counts['all'] }}</span>
                </div>
            </div>

            <div class="p-4 rounded-2xl bg-[#190f2b] border border-amber-500/30 flex items-center space-x-3">
                <span class="text-2xl">🖼️</span>
                <div>
                    <span class="text-[10px] text-amber-300/70 uppercase block font-bold">Images (WebP)</span>
                    <span class="font-cinzel text-xl font-black text-amber-300">{{ $counts['image'] }}</span>
                </div>
            </div>

            <div class="p-4 rounded-2xl bg-[#190f2b] border border-amber-500/30 flex items-center space-x-3">
                <span class="text-2xl">🎵</span>
                <div>
                    <span class="text-[10px] text-amber-300/70 uppercase block font-bold">Audio Mantras</span>
                    <span class="font-cinzel text-xl font-black text-amber-300">{{ $counts['audio'] }}</span>
                </div>
            </div>

            <div class="p-4 rounded-2xl bg-[#190f2b] border border-amber-500/30 flex items-center space-x-3">
                <span class="text-2xl">🎬</span>
                <div>
                    <span class="text-[10px] text-amber-300/70 uppercase block font-bold">Videos</span>
                    <span class="font-cinzel text-xl font-black text-amber-300">{{ $counts['video'] }}</span>
                </div>
            </div>

            <div class="col-span-2 sm:col-span-1 p-4 rounded-2xl bg-[#190f2b] border border-amber-500/30 flex items-center space-x-3">
                <span class="text-2xl">📄</span>
                <div>
                    <span class="text-[10px] text-amber-300/70 uppercase block font-bold">PDF Documents</span>
                    <span class="font-cinzel text-xl font-black text-amber-300">{{ $counts['pdf'] }}</span>
                </div>
            </div>
        </div>

        <!-- Filter & Search Controls -->
        <div class="p-4 rounded-2xl bg-[#160d26] border border-amber-500/25 mb-8 flex flex-col md:flex-row items-center justify-between gap-4">
            <!-- Filter Pills -->
            <div class="flex flex-wrap items-center gap-2 text-xs">
                <a href="{{ route('admin.media.index') }}"
                   class="px-3.5 py-1.5 rounded-xl font-semibold transition-colors {{ !request('type') || request('type') === 'all' ? 'bg-amber-400 text-black' : 'text-amber-200/80 bg-[#251540] hover:text-white' }}">
                    All Media ({{ $counts['all'] }})
                </a>
                <a href="{{ route('admin.media.index', ['type' => 'image']) }}"
                   class="px-3.5 py-1.5 rounded-xl font-semibold transition-colors {{ request('type') === 'image' ? 'bg-amber-400 text-black' : 'text-amber-200/80 bg-[#251540] hover:text-white' }}">
                    🖼️ Images [WebP] ({{ $counts['image'] }})
                </a>
                <a href="{{ route('admin.media.index', ['type' => 'audio']) }}"
                   class="px-3.5 py-1.5 rounded-xl font-semibold transition-colors {{ request('type') === 'audio' ? 'bg-amber-400 text-black' : 'text-amber-200/80 bg-[#251540] hover:text-white' }}">
                    🎵 Audio ({{ $counts['audio'] }})
                </a>
                <a href="{{ route('admin.media.index', ['type' => 'video']) }}"
                   class="px-3.5 py-1.5 rounded-xl font-semibold transition-colors {{ request('type') === 'video' ? 'bg-amber-400 text-black' : 'text-amber-200/80 bg-[#251540] hover:text-white' }}">
                    🎬 Video ({{ $counts['video'] }})
                </a>
                <a href="{{ route('admin.media.index', ['type' => 'pdf']) }}"
                   class="px-3.5 py-1.5 rounded-xl font-semibold transition-colors {{ request('type') === 'pdf' ? 'bg-amber-400 text-black' : 'text-amber-200/80 bg-[#251540] hover:text-white' }}">
                    📄 PDFs ({{ $counts['pdf'] }})
                </a>
            </div>

            <!-- Search Field -->
            <form action="{{ route('admin.media.index') }}" method="GET" class="w-full md:w-72">
                @if(request('type'))
                    <input type="hidden" name="type" value="{{ request('type') }}">
                @endif
                <div class="relative">
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Search files by title..."
                           class="w-full px-4 py-2 pl-9 rounded-xl bg-[#251540] border border-amber-500/30 text-xs text-white placeholder-amber-200/40 focus:outline-none focus:border-amber-400">
                    <svg class="w-4 h-4 text-amber-400/60 absolute left-3 top-2.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                    </svg>
                </div>
            </form>
        </div>

        <!-- Media Grid -->
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-3 gap-6">
            @forelse($mediaItems as $item)
            <div class="card-gold-frame rounded-3xl overflow-hidden flex flex-col justify-between group p-4 bg-[#180f2b]">
                
                <!-- Media Preview Area -->
                <div class="space-y-3">
                    <div class="relative aspect-video rounded-2xl overflow-hidden bg-black/60 border border-amber-500/20 flex items-center justify-center">
                        @if($item->file_type === 'image')
                            <img src="{{ $item->url }}" alt="{{ $item->alt_text }}" class="w-full h-full object-cover">
                            @if($item->is_webp)
                                <span class="absolute top-2 left-2 px-2 py-0.5 rounded text-[9px] font-bold bg-emerald-500 text-black uppercase shadow">
                                    WebP Optimized
                                </span>
                            @endif
                        @elseif($item->file_type === 'audio')
                            <div class="w-full h-full p-4 flex flex-col items-center justify-center space-y-2 bg-gradient-to-br from-[#2c133a] to-[#160c24]">
                                <span class="text-3xl">🎵</span>
                                <span class="text-[11px] text-amber-200 font-medium truncate max-w-[200px]">{{ $item->original_name }}</span>
                                <audio controls class="w-full h-8 mt-1">
                                    <source src="{{ $item->url }}" type="{{ $item->mime_type }}">
                                </audio>
                            </div>
                        @elseif($item->file_type === 'video')
                            <div class="w-full h-full flex items-center justify-center bg-black">
                                <video controls class="w-full h-full object-contain">
                                    <source src="{{ $item->url }}" type="{{ $item->mime_type }}">
                                </video>
                            </div>
                        @elseif($item->file_type === 'pdf')
                            <div class="w-full h-full p-4 flex flex-col items-center justify-center space-y-2 bg-gradient-to-br from-[#3b0f19] to-[#1a0e28]">
                                <span class="text-4xl text-rose-400">📄</span>
                                <span class="text-[11px] text-rose-200 font-bold uppercase tracking-wider">PDF Document</span>
                                <a href="{{ $item->url }}" target="_blank"
                                   class="px-3 py-1 rounded-lg text-[10px] font-bold bg-rose-600 hover:bg-rose-500 text-white shadow">
                                    View / Download PDF
                                </a>
                            </div>
                        @endif
                    </div>

                    <!-- Meta Details -->
                    <div>
                        <div class="flex items-center justify-between text-[10px] text-amber-300/70 mb-1">
                            <span class="uppercase font-bold">{{ $item->file_type }}</span>
                            <span>{{ $item->formatted_size }}</span>
                        </div>
                        <h3 class="font-cinzel text-sm font-bold text-white truncate" title="{{ $item->title }}">
                            {{ $item->title }}
                        </h3>
                        <p class="text-[11px] text-amber-200/50 truncate font-mono mt-0.5">
                            {{ $item->file_name }}
                        </p>
                        @if($item->description)
                        <p class="text-[11px] text-amber-100/70 line-clamp-2 mt-1">
                            {{ $item->description }}
                        </p>
                        @endif
                    </div>
                </div>

                <!-- Action Toolbar -->
                <div class="pt-4 mt-4 border-t border-amber-500/20 flex items-center justify-between gap-2">
                    <button @click="copyToClipboard('{{ $item->url }}')"
                            class="px-3 py-1.5 rounded-lg text-xs font-semibold text-amber-300 bg-amber-500/10 hover:bg-amber-500/20 border border-amber-500/30 flex items-center space-x-1.5 transition-colors">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 5H6a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2v-1M8 5a2 2 0 002 2h2a2 2 0 002-2M8 5a2 2 0 012-2h2a2 2 0 012 2m0 0h2a2 2 0 012 2v3m2 4H10m0 0l3-3m-3 3l3 3"/>
                        </svg>
                        <span>Copy URL</span>
                    </button>

                    <div class="flex items-center space-x-1">
                        <button @click="openEdit({{ json_encode($item) }})"
                                title="Edit Metadata"
                                class="p-1.5 rounded-lg text-amber-200 hover:text-white hover:bg-white/10 transition-colors">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                            </svg>
                        </button>

                        <form action="{{ route('admin.media.destroy', $item->id) }}" method="POST"
                              onsubmit="return confirm('Are you sure you want to delete this media item?');" class="inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" title="Delete" class="p-1.5 rounded-lg text-rose-400 hover:text-rose-200 hover:bg-rose-900/30 transition-colors">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                </svg>
                            </button>
                        </form>
                    </div>
                </div>

            </div>
            @empty
            <div class="col-span-3 text-center py-16 bg-[#160d26] rounded-3xl border border-amber-500/20 p-8">
                <span class="text-4xl block mb-2">📁</span>
                <p class="text-amber-200 font-semibold text-sm">No media assets found in this view.</p>
                <p class="text-xs text-amber-200/60 mt-1">Upload images, audio recordings, videos, or PDF documents above.</p>
            </div>
            @endforelse
        </div>

        <!-- Pagination -->
        <div class="mt-12">
            {{ $mediaItems->links() }}
        </div>

    </div>

    <!-- Upload Modal -->
    <div x-show="uploadModalOpen"
         x-cloak
         class="fixed inset-0 z-50 overflow-y-auto" role="dialog" aria-modal="true">
        <div x-show="uploadModalOpen"
             x-transition:enter="ease-out duration-300"
             x-transition:enter-start="opacity-0"
             x-transition:enter-end="opacity-100"
             x-transition:leave="ease-in duration-200"
             x-transition:leave-start="opacity-100"
             x-transition:leave-end="opacity-0"
             @click="uploadModalOpen = false"
             class="fixed inset-0 bg-black/80 backdrop-blur-sm"></div>

        <div class="flex min-h-full items-center justify-center p-4">
            <div x-show="uploadModalOpen"
                 x-transition:enter="ease-out duration-300"
                 x-transition:enter-start="opacity-0 scale-95"
                 x-transition:enter-end="opacity-100 scale-100"
                 x-transition:leave="ease-in duration-200"
                 x-transition:leave-start="opacity-100 scale-100"
                 x-transition:leave-end="opacity-0 scale-95"
                 @click.stop
                 class="relative w-full max-w-lg rounded-3xl bg-[#190f2b] border-2 border-amber-500/40 p-6 sm:p-8 shadow-2xl">
                
                <button @click="uploadModalOpen = false" class="absolute top-5 right-5 text-amber-300/70 hover:text-white p-1">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                </button>

                <h3 class="font-cinzel text-xl font-bold text-amber-300 mb-2">
                    Upload Media Asset
                </h3>
                <p class="text-xs text-amber-200/70 mb-5">
                    Images will automatically be compressed and converted to <strong>WebP</strong> format for blazing fast web delivery.
                </p>

                <form action="{{ route('admin.media.store') }}" method="POST" enctype="multipart/form-data" class="space-y-4 text-xs">
                    @csrf
                    
                    <div>
                        <label class="block font-semibold text-amber-200 mb-1">Select File (Image, Audio, Video, PDF) *</label>
                        <input type="file" name="file" required
                               class="w-full px-3.5 py-3 rounded-xl bg-[#231538] border border-amber-500/30 text-white file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-semibold file:bg-amber-400 file:text-black hover:file:bg-amber-300 cursor-pointer">
                    </div>

                    <div>
                        <label class="block font-semibold text-amber-200 mb-1">Title (Optional)</label>
                        <input type="text" name="title" placeholder="e.g., Lord Surya Yantra WebP"
                               class="w-full px-3.5 py-2.5 rounded-xl bg-[#231538] border border-amber-500/30 text-white placeholder-amber-200/40 focus:outline-none focus:border-amber-400">
                    </div>

                    <div>
                        <label class="block font-semibold text-amber-200 mb-1">Alt Text (For SEO & Images)</label>
                        <input type="text" name="alt_text" placeholder="Descriptive alt text for search engines"
                               class="w-full px-3.5 py-2.5 rounded-xl bg-[#231538] border border-amber-500/30 text-white placeholder-amber-200/40 focus:outline-none focus:border-amber-400">
                    </div>

                    <div>
                        <label class="block font-semibold text-amber-200 mb-1">Description / Notes</label>
                        <textarea name="description" rows="2" placeholder="Brief note about this media asset..."
                                  class="w-full px-3.5 py-2.5 rounded-xl bg-[#231538] border border-amber-500/30 text-white placeholder-amber-200/40 focus:outline-none focus:border-amber-400"></textarea>
                    </div>

                    <div class="pt-2">
                        <button type="submit"
                                class="w-full py-3.5 rounded-xl font-bold text-sm text-[#1a1128] bg-gradient-to-r from-amber-300 via-yellow-400 to-amber-500 hover:from-amber-200 hover:to-yellow-300 shadow-xl transition-all">
                            Upload & Optimize Media
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Edit Metadata Modal -->
    <div x-show="editModalOpen"
         x-cloak
         class="fixed inset-0 z-50 overflow-y-auto" role="dialog" aria-modal="true">
        <div x-show="editModalOpen" @click="editModalOpen = false" class="fixed inset-0 bg-black/80 backdrop-blur-sm"></div>

        <div class="flex min-h-full items-center justify-center p-4">
            <div x-show="editModalOpen"
                 @click.stop
                 class="relative w-full max-w-lg rounded-3xl bg-[#190f2b] border-2 border-amber-500/40 p-6 sm:p-8 shadow-2xl text-xs">
                
                <button @click="editModalOpen = false" class="absolute top-5 right-5 text-amber-300/70 hover:text-white p-1">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                </button>

                <h3 class="font-cinzel text-xl font-bold text-amber-300 mb-4">
                    Edit Media Metadata
                </h3>

                <form :action="'{{ url('admin/media') }}/' + editItem?.id" method="POST" class="space-y-4">
                    @csrf
                    @method('PUT')

                    <div>
                        <label class="block font-semibold text-amber-200 mb-1">Title *</label>
                        <input type="text" name="title" x-model="editItem.title" required
                               class="w-full px-3.5 py-2.5 rounded-xl bg-[#231538] border border-amber-500/30 text-white focus:outline-none focus:border-amber-400">
                    </div>

                    <div>
                        <label class="block font-semibold text-amber-200 mb-1">Alt Text</label>
                        <input type="text" name="alt_text" x-model="editItem.alt_text"
                               class="w-full px-3.5 py-2.5 rounded-xl bg-[#231538] border border-amber-500/30 text-white focus:outline-none focus:border-amber-400">
                    </div>

                    <div>
                        <label class="block font-semibold text-amber-200 mb-1">Description</label>
                        <textarea name="description" rows="3" x-model="editItem.description"
                                  class="w-full px-3.5 py-2.5 rounded-xl bg-[#231538] border border-amber-500/30 text-white focus:outline-none focus:border-amber-400"></textarea>
                    </div>

                    <div class="pt-2">
                        <button type="submit"
                                class="w-full py-3.5 rounded-xl font-bold text-sm text-[#1a1128] bg-gradient-to-r from-amber-300 to-yellow-400 hover:from-amber-200 hover:to-yellow-300 shadow-xl transition-all">
                            Save Changes
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

</div>
@endsection

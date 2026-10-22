@extends('layouts.admin')

@section('title', 'Add New YouTube Video | Covilakam Astrology')
@section('page_title', 'Add New Video Discourse')

@section('content')
<div class="max-w-4xl mx-auto space-y-6"
     x-data="{
        youtubeUrl: '{{ old('youtube_url', '') }}',
        extractedId: '',
        parseId() {
            let val = (this.youtubeUrl || '').trim();
            if (!val) { this.extractedId = ''; return; }
            if (/^[a-zA-Z0-9_-]{11}$/.test(val)) {
                this.extractedId = val;
                return;
            }
            let m = val.match(/[?&]v=([a-zA-Z0-9_-]{11})/);
            if (m) { this.extractedId = m[1]; return; }
            m = val.match(/youtu\.be\/([a-zA-Z0-9_-]{11})/);
            if (m) { this.extractedId = m[1]; return; }
            m = val.match(/youtube\.com\/embed\/([a-zA-Z0-9_-]{11})/);
            if (m) { this.extractedId = m[1]; return; }
            m = val.match(/youtube\.com\/shorts\/([a-zA-Z0-9_-]{11})/);
            if (m) { this.extractedId = m[1]; return; }
            this.extractedId = '';
        },
        init() {
            this.parseId();
        }
     }">

    <!-- Breadcrumb & Back -->
    <div class="flex items-center justify-between">
        <a href="{{ route('admin.videos.index') }}"
           class="text-xs text-amber-400 hover:text-amber-200 flex items-center space-x-1 transition-colors">
            <span>← Back to Video Gallery</span>
        </a>

        <span class="text-xs text-amber-300/70 font-mono">
            New Video Position: #{{ $nextSortOrder }}
        </span>
    </div>

    <!-- Main Form Card -->
    <div class="rounded-3xl bg-[#160d26] border border-amber-500/30 p-6 sm:p-10 shadow-2xl space-y-8">
        
        <div>
            <h2 class="font-cinzel text-xl sm:text-2xl font-bold text-white">
                Add Vedic Astrology Video Discourse
            </h2>
            <p class="text-xs text-amber-100/70 mt-1">
                Paste any YouTube URL or 11-char ID. The backend and preview parser will automatically extract the video thumbnail and embed code.
            </p>
        </div>

        <form action="{{ route('admin.videos.store') }}" method="POST" class="space-y-6 text-xs">
            @csrf

            <!-- Video Title -->
            <div>
                <label class="block font-semibold text-amber-200 mb-1.5">
                    Video Title (Malayalam or English) *
                </label>
                <input type="text" name="title" value="{{ old('title') }}" required
                       placeholder="e.g. ഓൺലൈൻ അസ്ട്രോളജി : ഗുണങ്ങളും ദോഷങ്ങളും (Online Astrology)"
                       class="w-full px-4 py-3 rounded-xl bg-[#211335] border border-amber-500/30 text-white placeholder-amber-200/40 focus:outline-none focus:border-amber-400 font-['Noto_Sans_Malayalam',sans-serif] text-sm">
                <p class="text-[11px] text-amber-300/60 mt-1">
                    Supports authentic Malayalam unicode script.
                </p>
            </div>

            <!-- YouTube URL & Live Preview Grid -->
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 items-start">
                
                <!-- Left: Input fields (7 cols) -->
                <div class="lg:col-span-7 space-y-4">
                    <div>
                        <label class="block font-semibold text-amber-200 mb-1.5">
                            YouTube Video URL or 11-Character ID *
                        </label>
                        <input type="text" name="youtube_url" x-model="youtubeUrl" @input="parseId()" required
                               placeholder="e.g. https://youtu.be/ZFzqmHgEDKQ?si=... or ZFzqmHgEDKQ"
                               class="w-full px-4 py-3 rounded-xl bg-[#211335] border border-amber-500/30 text-white placeholder-amber-200/40 focus:outline-none focus:border-amber-400 font-mono text-xs">
                        <p class="text-[11px] text-amber-300/70 mt-1">
                            ✨ Smart Parser active: Accepts share links (<code class="text-amber-300">youtu.be/...</code>), browser links (<code class="text-amber-300">youtube.com/watch?v=...</code>), or raw 11-char IDs.
                        </p>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label class="block font-semibold text-amber-200 mb-1.5">
                                Video Duration (Optional)
                            </label>
                            <input type="text" name="duration" value="{{ old('duration', '12:30') }}"
                                   placeholder="e.g. 12:45"
                                   class="w-full px-4 py-3 rounded-xl bg-[#211335] border border-amber-500/30 text-white placeholder-amber-200/40 focus:outline-none focus:border-amber-400 font-mono text-xs">
                        </div>

                        <div>
                            <label class="block font-semibold text-amber-200 mb-1.5">
                                Sort Order (Sequence on Page) *
                            </label>
                            <input type="number" name="sort_order" value="{{ old('sort_order', $nextSortOrder) }}" min="1" required
                                   class="w-full px-4 py-3 rounded-xl bg-[#211335] border border-amber-500/30 text-white placeholder-amber-200/40 focus:outline-none focus:border-amber-400 font-mono text-xs font-bold">
                            <p class="text-[10px] text-amber-300/60 mt-1">1 = Featured Hero Video</p>
                        </div>
                    </div>

                    <!-- Active Toggle -->
                    <div class="pt-2">
                        <label class="flex items-center space-x-3 text-amber-200 cursor-pointer p-3 rounded-xl bg-[#211335] border border-amber-500/20">
                            <input type="checkbox" name="is_active" value="1" {{ old('is_active', true) ? 'checked' : '' }}
                                   class="w-4 h-4 rounded bg-[#160d26] border-amber-500/40 text-amber-500 focus:ring-0">
                            <span class="font-medium">Active (Visible immediately on the Homepage Video Gallery)</span>
                        </label>
                    </div>
                </div>

                <!-- Right: Live Thumbnail Preview (5 cols) -->
                <div class="lg:col-span-5 space-y-2">
                    <label class="block font-semibold text-amber-200">
                        Live Thumbnail Preview
                    </label>

                    <div class="aspect-video rounded-2xl bg-black border-2 border-amber-500/40 overflow-hidden relative shadow-xl flex items-center justify-center">
                        <template x-if="extractedId">
                            <div class="w-full h-full relative group">
                                <img :src="'https://img.youtube.com/vi/' + extractedId + '/hqdefault.jpg'"
                                     alt="YouTube Thumbnail"
                                     class="w-full h-full object-cover">
                                <div class="absolute inset-0 bg-black/40 flex items-center justify-center">
                                    <span class="w-12 h-12 rounded-full bg-red-600/90 text-white flex items-center justify-center text-lg pl-0.5 shadow-lg">▶</span>
                                </div>
                                <div class="absolute bottom-2 left-2 px-2 py-0.5 rounded bg-black/80 text-[10px] text-amber-300 font-mono"
                                     x-text="'ID: ' + extractedId"></div>
                            </div>
                        </template>

                        <template x-if="!extractedId">
                            <div class="p-6 text-center text-amber-300/50 space-y-2">
                                <span class="text-3xl block">🎬</span>
                                <p class="text-[11px]">Paste a valid YouTube link on the left to see live thumbnail preview</p>
                            </div>
                        </template>
                    </div>
                </div>

            </div>

            <!-- Malayalam Description -->
            <div>
                <label class="block font-semibold text-amber-200 mb-1.5">
                    Short Malayalam Description *
                </label>
                <textarea name="description" rows="4" required
                          placeholder="വിഷയത്തെക്കുറിച്ചുള്ള ലഘുവിവരണം ഇവിടെ രേഖപ്പെടുത്തുക..."
                          class="w-full px-4 py-3 rounded-xl bg-[#211335] border border-amber-500/30 text-white placeholder-amber-200/40 focus:outline-none focus:border-amber-400 font-['Noto_Sans_Malayalam',sans-serif] text-xs leading-relaxed">{{ old('description') }}</textarea>
                <p class="text-[11px] text-amber-300/60 mt-1">
                    This summary appears on the video card (with line clamp) and inside the interactive video player modal.
                </p>
            </div>

            <!-- Form Submit Buttons -->
            <div class="pt-4 border-t border-amber-500/20 flex items-center justify-end space-x-3">
                <a href="{{ route('admin.videos.index') }}"
                   class="px-5 py-3 rounded-xl font-medium text-xs text-amber-200 bg-[#211335] border border-amber-500/30 hover:border-amber-400 transition-colors">
                    Cancel
                </a>

                <button type="submit"
                        class="px-8 py-3 rounded-xl font-bold text-xs text-[#1a1128] bg-gradient-to-r from-amber-300 via-yellow-400 to-amber-500 hover:from-amber-200 hover:to-yellow-300 shadow-xl hover:shadow-amber-500/30 transition-all">
                    Save Video Discourse
                </button>
            </div>

        </form>

    </div>

</div>
@endsection

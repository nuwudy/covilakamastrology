@extends('layouts.admin')

@section('title', 'Vedic Astrology Video Gallery Management | Covilakam Astrology')
@section('page_title', 'Vedic Astrology Video Gallery')

@section('content')
<div class="space-y-6">

    <!-- Header Actions -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <h1 class="font-cinzel text-2xl font-black text-white">
                Vedic Astrology Video Gallery
            </h1>
            <p class="text-xs text-amber-200/70 mt-1">
                Manage YouTube video discourses presented by Dr. E. K. Raja Varma. Videos appear on the homepage in order of <span class="text-amber-300 font-mono font-bold">Sort Order</span>.
            </p>
        </div>

        <a href="{{ route('admin.videos.create') }}"
           class="px-5 py-3 rounded-xl font-bold text-xs text-[#1a1128] bg-gradient-to-r from-amber-300 via-yellow-400 to-amber-500 hover:from-amber-200 hover:to-yellow-300 shadow-xl hover:shadow-amber-500/20 transition-all flex items-center space-x-2 self-start">
            <span class="text-base font-black">+</span>
            <span>Add New Video Discourse</span>
        </a>
    </div>

    <!-- Notice Banner for Video 1 & Video 2 rules -->
    <div class="p-4 rounded-2xl bg-[#1e1333] border border-amber-500/40 text-xs text-amber-100/90 flex items-start space-x-3">
        <span class="text-lg text-amber-400">💡</span>
        <div class="space-y-1">
            <p class="font-semibold text-amber-300">Homepage Ordering Principle:</p>
            <p class="text-[11px] text-amber-200/80 leading-relaxed">
                Video 1 (<span class="font-mono text-amber-300 font-bold">Sort Order = 1</span>) is featured prominently as the Hero Video with the <span class="text-amber-300 font-semibold">"Featured Insight • Online Astro Counselling"</span> badge. Video 2 appears second with the <span class="text-amber-300 font-semibold">"Key Insight #2"</span> badge.
            </p>
        </div>
    </div>

    <!-- Videos Table -->
    <div class="rounded-3xl bg-[#160d26] border border-amber-500/30 overflow-hidden shadow-2xl">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse text-xs">
                <thead>
                    <tr class="bg-[#12091c] border-b border-amber-500/20 text-amber-300/80 uppercase tracking-wider text-[10px]">
                        <th class="py-4 px-4 font-bold text-center w-16">Order</th>
                        <th class="py-4 px-4 font-bold w-44">Thumbnail</th>
                        <th class="py-4 px-4 font-bold">Title & Description</th>
                        <th class="py-4 px-4 font-bold w-36">YouTube ID</th>
                        <th class="py-4 px-4 font-bold text-center w-28">Status</th>
                        <th class="py-4 px-4 font-bold text-right w-36">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-amber-500/15">
                    @forelse($videos as $video)
                    <tr class="hover:bg-amber-500/5 transition-colors">
                        <!-- Sort Order -->
                        <td class="py-4 px-4 text-center">
                            <span class="w-8 h-8 rounded-xl bg-[#201335] border border-amber-500/40 font-mono font-bold text-amber-300 inline-flex items-center justify-center text-xs">
                                {{ $video->sort_order }}
                            </span>
                        </td>

                        <!-- Thumbnail Preview -->
                        <td class="py-4 px-4">
                            <div class="relative w-36 aspect-video rounded-xl bg-black overflow-hidden border border-amber-500/40 shadow-md group">
                                <img src="https://img.youtube.com/vi/{{ $video->youtube_id }}/hqdefault.jpg"
                                     alt="{{ $video->title }}"
                                     class="w-full h-full object-cover">
                                
                                <a href="https://youtu.be/{{ $video->youtube_id }}"
                                   target="_blank"
                                   class="absolute inset-0 bg-black/60 opacity-0 group-hover:opacity-100 flex items-center justify-center text-red-400 font-bold transition-opacity">
                                    <span class="text-xs flex items-center space-x-1">
                                        <span>▶ Play</span>
                                    </span>
                                </a>

                                @if($video->duration)
                                <span class="absolute bottom-1 right-1 px-1.5 py-0.5 rounded bg-black/80 text-[9px] font-mono text-white/90">
                                    {{ $video->duration }}
                                </span>
                                @endif
                            </div>
                        </td>

                        <!-- Title & Description -->
                        <td class="py-4 px-4 space-y-1.5">
                            <div class="flex items-center space-x-2">
                                @if($video->sort_order == 1)
                                <span class="px-2 py-0.5 rounded text-[9px] font-black uppercase bg-gradient-to-r from-amber-400 to-yellow-500 text-black">
                                    Featured Hero #1
                                </span>
                                @elseif($video->sort_order == 2)
                                <span class="px-2 py-0.5 rounded text-[9px] font-bold uppercase bg-amber-500/30 text-amber-300">
                                    Featured #2
                                </span>
                                @endif
                            </div>

                            <h3 class="font-['Noto_Sans_Malayalam',sans-serif] text-sm font-bold text-white leading-snug">
                                {{ $video->title }}
                            </h3>

                            <p class="font-['Noto_Sans_Malayalam',sans-serif] text-[11px] text-amber-100/70 line-clamp-2 leading-relaxed">
                                {{ $video->description }}
                            </p>
                        </td>

                        <!-- YouTube ID & External Link -->
                        <td class="py-4 px-4 font-mono text-[11px] space-y-1">
                            <span class="text-amber-300 font-semibold block select-all">
                                {{ $video->youtube_id }}
                            </span>
                            <a href="https://youtu.be/{{ $video->youtube_id }}"
                               target="_blank"
                               class="text-[10px] text-red-400 hover:text-red-300 flex items-center space-x-1 underline">
                                <span>Watch on YouTube</span>
                                <span>↗</span>
                            </a>
                        </td>

                        <!-- Status Toggle Button -->
                        <td class="py-4 px-4 text-center">
                            <form action="{{ route('admin.videos.toggle', $video->id) }}" method="POST">
                                @csrf
                                <button type="submit"
                                        class="px-2.5 py-1 rounded-full text-[10px] font-bold uppercase tracking-wider transition-colors {{ $video->is_active ? 'bg-emerald-500/20 text-emerald-300 border border-emerald-500/40 hover:bg-emerald-500/30' : 'bg-rose-500/20 text-rose-300 border border-rose-500/40 hover:bg-rose-500/30' }}">
                                    {{ $video->is_active ? 'Active' : 'Hidden' }}
                                </button>
                            </form>
                        </td>

                        <!-- Actions -->
                        <td class="py-4 px-4 text-right">
                            <div class="flex items-center justify-end space-x-2">
                                <a href="{{ route('admin.videos.edit', $video->id) }}"
                                   class="px-3 py-1.5 rounded-lg text-amber-300 hover:bg-amber-500/20 border border-amber-500/30 text-xs font-semibold transition-colors">
                                    Edit
                                </a>

                                <form action="{{ route('admin.videos.destroy', $video->id) }}"
                                      method="POST"
                                      onsubmit="return confirm('Are you sure you want to delete this video: {{ addslashes($video->title) }}?');"
                                      class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                            class="p-1.5 rounded-lg text-rose-400 hover:bg-rose-900/40 border border-rose-500/30 transition-colors"
                                            title="Delete Video">
                                        🗑️
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="py-12 text-center text-amber-200/60">
                            No videos in the gallery. Click "Add New Video Discourse" above to add videos.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</div>
@endsection

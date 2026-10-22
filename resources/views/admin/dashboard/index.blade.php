@extends('layouts.admin')

@section('title', 'Admin Dashboard Overview | Covilakam Astrology')
@section('page_title', 'Dashboard Overview')

@section('content')
<div class="space-y-8">

    <!-- Welcome & Quick Actions Banner -->
    <div class="rounded-3xl p-6 sm:p-8 bg-gradient-to-r from-[#1e1333] via-[#1a1128] to-[#160d24] border border-amber-500/30 relative overflow-hidden shadow-2xl">
        <div class="absolute -right-20 -top-20 w-64 h-64 bg-amber-500/10 rounded-full blur-[80px] pointer-events-none"></div>

        <div class="flex flex-col md:flex-row md:items-center justify-between gap-6 relative z-10">
            <div>
                <span class="px-3 py-1 rounded-full text-[10px] font-bold uppercase tracking-wider bg-amber-500/20 text-amber-300 border border-amber-500/30">
                    Vidya Vachaspathi Management Console
                </span>
                <h1 class="font-cinzel text-2xl sm:text-3xl font-extrabold text-white mt-2">
                    Namaskaram, <span class="gold-gradient-text">DR. E. K. Raja Varma</span>
                </h1>
                <p class="text-xs sm:text-sm text-amber-100/70 mt-1 max-w-2xl">
                    Manage your authentic YouTube Video Gallery discourses, Vedic Wisdom Repository articles, free DOB predictions, and astrology translations from here.
                </p>
            </div>

            <!-- Quick Action Buttons -->
            <div class="flex flex-wrap gap-3">
                <a href="{{ route('admin.videos.create') }}"
                   class="px-4 py-2.5 rounded-xl font-bold text-xs text-[#1a1128] bg-gradient-to-r from-amber-300 via-yellow-400 to-amber-500 hover:from-amber-200 hover:to-yellow-300 shadow-lg shadow-amber-500/20 transition-all flex items-center space-x-1.5">
                    <span>+</span>
                    <span>Add New Video</span>
                </a>

                <a href="{{ route('admin.posts.create') }}"
                   class="px-4 py-2.5 rounded-xl font-bold text-xs text-white bg-amber-600/30 hover:bg-amber-600/50 border border-amber-500/40 shadow-lg transition-all flex items-center space-x-1.5">
                    <span>+</span>
                    <span>Write New Article</span>
                </a>
            </div>
        </div>
    </div>

    <!-- 4 Summary Stat Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5">
        
        <!-- Total Videos Card -->
        <a href="{{ route('admin.videos.index') }}"
           class="p-5 rounded-2xl bg-[#160d26] border border-amber-500/30 hover:border-amber-400 transition-all hover:-translate-y-1 shadow-xl group">
            <div class="flex items-center justify-between mb-3">
                <div class="w-12 h-12 rounded-xl bg-red-600/20 border border-red-500/40 flex items-center justify-center text-xl text-red-400 group-hover:scale-110 transition-transform">
                    🎬
                </div>
                <span class="text-[10px] uppercase font-bold text-amber-400 bg-amber-500/10 px-2.5 py-0.5 rounded-full border border-amber-500/20">
                    {{ $stats['active_videos'] }} Active
                </span>
            </div>
            <p class="text-xs text-amber-100/70">Video Gallery</p>
            <h3 class="text-2xl font-black text-white mt-1">{{ $stats['total_videos'] }} Videos</h3>
            <p class="text-[11px] text-amber-300/80 mt-2 flex items-center space-x-1">
                <span>Manage 7 Real YouTube Discourses</span>
                <span>→</span>
            </p>
        </a>

        <!-- Total Articles Card -->
        <a href="{{ route('admin.posts.index') }}"
           class="p-5 rounded-2xl bg-[#160d26] border border-amber-500/30 hover:border-amber-400 transition-all hover:-translate-y-1 shadow-xl group">
            <div class="flex items-center justify-between mb-3">
                <div class="w-12 h-12 rounded-xl bg-amber-500/20 border border-amber-500/40 flex items-center justify-center text-xl text-amber-300 group-hover:scale-110 transition-transform">
                    📜
                </div>
                <span class="text-[10px] uppercase font-bold text-amber-300 bg-amber-500/10 px-2.5 py-0.5 rounded-full border border-amber-500/20">
                    {{ $stats['published_posts'] }} Published
                </span>
            </div>
            <p class="text-xs text-amber-100/70">Vedic Wisdom Repository</p>
            <h3 class="text-2xl font-black text-white mt-1">{{ $stats['total_posts'] }} Articles</h3>
            <p class="text-[11px] text-amber-300/80 mt-2 flex items-center space-x-1">
                <span>Manage Blog & Insights</span>
                <span>→</span>
            </p>
        </a>

        <!-- Consultation & DOB Leads Card -->
        <a href="{{ route('admin.consultations.index') }}"
           class="p-5 rounded-2xl bg-[#160d26] border border-amber-500/30 hover:border-amber-400 transition-all hover:-translate-y-1 shadow-xl group">
            <div class="flex items-center justify-between mb-3">
                <div class="w-12 h-12 rounded-xl bg-emerald-500/20 border border-emerald-500/40 flex items-center justify-center text-xl text-emerald-300 group-hover:scale-110 transition-transform">
                    🙏
                </div>
                @if($stats['pending_consultations'] > 0)
                <span class="text-[10px] uppercase font-bold text-emerald-300 bg-emerald-500/20 px-2.5 py-0.5 rounded-full border border-emerald-500/40 animate-pulse">
                    {{ $stats['pending_consultations'] }} Pending
                </span>
                @else
                <span class="text-[10px] uppercase font-bold text-emerald-400/80 bg-emerald-500/10 px-2.5 py-0.5 rounded-full border border-emerald-500/20">
                    Up to date
                </span>
                @endif
            </div>
            <p class="text-xs text-amber-100/70">Consultation & DOB Leads</p>
            <h3 class="text-2xl font-black text-white mt-1">{{ $stats['total_consultations'] }} Inquiries</h3>
            <p class="text-[11px] text-emerald-300 mt-2 flex items-center space-x-1">
                <span>1-Click WhatsApp Reply</span>
                <span>→</span>
            </p>
        </a>

        <!-- Media Library Card -->
        <a href="{{ route('admin.media.index') }}"
           class="p-5 rounded-2xl bg-[#160d26] border border-amber-500/30 hover:border-amber-400 transition-all hover:-translate-y-1 shadow-xl group">
            <div class="flex items-center justify-between mb-3">
                <div class="w-12 h-12 rounded-xl bg-purple-500/20 border border-purple-500/40 flex items-center justify-center text-xl text-purple-300 group-hover:scale-110 transition-transform">
                    🖼️
                </div>
                <span class="text-[10px] uppercase font-bold text-purple-300 bg-purple-500/10 px-2.5 py-0.5 rounded-full border border-purple-500/20">
                    WebP Engine
                </span>
            </div>
            <p class="text-xs text-amber-100/70">Media Assets</p>
            <h3 class="text-2xl font-black text-white mt-1">{{ $stats['total_media'] }} Items</h3>
            <p class="text-[11px] text-amber-300/80 mt-2 flex items-center space-x-1">
                <span>Optimized Images & Audio</span>
                <span>→</span>
            </p>
        </a>

    </div>

    <!-- Two-Column Grid: Recent Videos & Recent Consultations -->
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
        
        <!-- Left Column: Video Gallery Quick Preview (7 Columns) -->
        <div class="lg:col-span-7 space-y-4">
            <div class="flex items-center justify-between">
                <div>
                    <h3 class="font-cinzel text-lg font-bold text-white flex items-center space-x-2">
                        <span>🎬 Vedic Astrology Video Gallery</span>
                    </h3>
                    <p class="text-xs text-amber-200/70">Current live videos shown on homepage</p>
                </div>
                <a href="{{ route('admin.videos.index') }}" class="text-xs font-semibold text-amber-400 hover:text-amber-200">
                    View All ({{ $stats['total_videos'] }}) →
                </a>
            </div>

            <div class="rounded-2xl bg-[#160d26] border border-amber-500/30 overflow-hidden divide-y divide-amber-500/15">
                @forelse($recentVideos as $video)
                <div class="p-4 flex items-center justify-between gap-4 hover:bg-amber-500/5 transition-colors">
                    <div class="flex items-center space-x-3.5 min-w-0">
                        <div class="relative w-20 h-12 rounded-lg bg-black flex-shrink-0 overflow-hidden border border-amber-500/30">
                            <img src="https://img.youtube.com/vi/{{ $video->youtube_id }}/hqdefault.jpg"
                                 alt="{{ $video->title }}"
                                 class="w-full h-full object-cover">
                            <span class="absolute bottom-1 right-1 text-[8px] bg-black/90 px-1 rounded text-white font-mono">
                                #{{ $video->sort_order }}
                            </span>
                        </div>

                        <div class="min-w-0">
                            <h4 class="font-['Noto_Sans_Malayalam',sans-serif] text-xs font-bold text-white truncate">
                                {{ $video->title }}
                            </h4>
                            <p class="text-[11px] text-amber-300/70 font-mono truncate">
                                ID: {{ $video->youtube_id }} • {{ $video->duration ?? 'Discourse' }}
                            </p>
                        </div>
                    </div>

                    <div class="flex items-center space-x-2 flex-shrink-0">
                        <span class="px-2 py-0.5 rounded text-[10px] font-bold {{ $video->is_active ? 'bg-emerald-500/20 text-emerald-300' : 'bg-rose-500/20 text-rose-300' }}">
                            {{ $video->is_active ? 'Active' : 'Hidden' }}
                        </span>

                        <a href="{{ route('admin.videos.edit', $video->id) }}"
                           class="p-1.5 rounded-lg text-amber-300 hover:bg-amber-500/20 border border-amber-500/30 text-xs">
                            ✏️ Edit
                        </a>
                    </div>
                </div>
                @empty
                <div class="p-8 text-center text-xs text-amber-200/60">
                    No videos found. Click "+ Add New Video" to get started.
                </div>
                @endforelse
            </div>
        </div>

        <!-- Right Column: Recent Leads & Inquiries (5 Columns) -->
        <div class="lg:col-span-5 space-y-4">
            <div class="flex items-center justify-between">
                <div>
                    <h3 class="font-cinzel text-lg font-bold text-white flex items-center space-x-2">
                        <span>🙏 Recent Consultation Leads</span>
                    </h3>
                    <p class="text-xs text-amber-200/70">DOB calculator & booking requests</p>
                </div>
                <a href="{{ route('admin.consultations.index') }}" class="text-xs font-semibold text-emerald-400 hover:text-emerald-200">
                    View All →
                </a>
            </div>

            <div class="rounded-2xl bg-[#160d26] border border-amber-500/30 overflow-hidden divide-y divide-amber-500/15">
                @forelse($recentConsultations as $lead)
                <div class="p-4 space-y-2 hover:bg-amber-500/5 transition-colors">
                    <div class="flex items-center justify-between">
                        <span class="font-bold text-xs text-white">{{ $lead->name }}</span>
                        <span class="text-[10px] text-amber-300/60 font-mono">{{ $lead->created_at->diffForHumans() }}</span>
                    </div>

                    <div class="text-[11px] text-amber-200/80 flex items-center justify-between">
                        <span>Service: <strong>{{ $lead->service_requested ?? 'General Reading' }}</strong></span>
                        @if($lead->birth_date)
                        <span class="font-mono text-amber-300/70">DOB: {{ $lead->birth_date }}</span>
                        @endif
                    </div>

                    @php
                        $targetPhone = preg_replace('/[^0-9]/', '', $lead->whatsapp_number ?: $lead->phone);
                        if (strlen($targetPhone) === 10) {
                            $targetPhone = '91' . $targetPhone;
                        }
                        $calc = $lead->calculated_summary;
                        if ($calc && !empty($calc['mulank'])) {
                            $rPlanet = is_array($calc['ruling_planet'] ?? null) ? ($calc['ruling_planet']['en'] ?? 'Surya') : ($calc['ruling_planet'] ?? '');
                            $gem = $calc['gemstone_en'] ?? '';
                            $reportUrl = route('consultations.prediction', $lead->id);
                            $replyText = "Namaskaram {$lead->name},\n\n"
                                . "This is DR. E. K. Raja Varma (Vidya Vachaspathi in Vedic Astrology) from Covilakam Astrology (കോവിലകം ജ്യോതിഷം).\n\n"
                                . "Here is your Vedic Horoscope Summary:\n"
                                . "• Date of Birth: " . ($lead->birth_date ? \Carbon\Carbon::parse($lead->birth_date)->format('d-m-Y') : '') . "\n"
                                . "• Birth Number (Mulank): {$calc['mulank']} ({$rPlanet})\n"
                                . "• Destiny Number (Bhagyank): " . ($calc['bhagyank'] ?? '') . "\n"
                                . "• Recommended Gemstone: {$gem}\n"
                                . "• Service Requested: " . ($lead->service_requested ?? 'Vedic Astro Reading') . "\n\n"
                                . "📜 View your complete dedicated report here:\n{$reportUrl}\n\n"
                                . "Please let me know if you would like to proceed with a detailed personal consultation.";
                        } else {
                            $replyText = "Namaskaram {$lead->name}, this is DR. E. K. Raja Varma (Vidya Vachaspathi in Vedic Astrology) from Covilakam Astrology regarding your inquiry for \"" . ($lead->service_requested ?? 'Astrology Reading') . "\". How may I guide you today?";
                        }
                    @endphp

                    <div class="pt-1 flex items-center justify-between text-[11px]">
                        <span class="px-2 py-0.5 rounded text-[10px] font-semibold {{ $lead->status === 'pending' ? 'bg-amber-500/20 text-amber-300' : 'bg-emerald-500/20 text-emerald-300' }}">
                            {{ ucfirst($lead->status) }}
                        </span>

                        @if($targetPhone)
                        <a href="https://wa.me/{{ $targetPhone }}?text={{ rawurlencode($replyText) }}"
                           target="_blank"
                           class="inline-flex items-center space-x-1 px-2.5 py-1 rounded-lg bg-emerald-600/30 hover:bg-emerald-600/50 text-emerald-300 border border-emerald-500/40 font-semibold text-[10px]">
                            <span>💬 Send Horoscope on WhatsApp</span>
                        </a>
                        @endif
                    </div>
                </div>
                @empty
                <div class="p-8 text-center text-xs text-amber-200/60">
                    No consultation inquiries recorded yet.
                </div>
                @endforelse
            </div>
        </div>

    </div>

    <!-- Recent Blog Articles Section -->
    <div class="space-y-4">
        <div class="flex items-center justify-between">
            <div>
                <h3 class="font-cinzel text-lg font-bold text-white flex items-center space-x-2">
                    <span>📜 Vedic Wisdom Repository Articles</span>
                </h3>
                <p class="text-xs text-amber-200/70">Articles currently featured on frontend blog</p>
            </div>
            <a href="{{ route('admin.posts.index') }}" class="text-xs font-semibold text-amber-400 hover:text-amber-200">
                Manage All Articles ({{ $stats['total_posts'] }}) →
            </a>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-5">
            @foreach($recentPosts as $post)
            <div class="rounded-2xl bg-[#160d26] border border-amber-500/30 p-5 flex flex-col justify-between hover:border-amber-400 transition-colors shadow-lg">
                <div class="space-y-2.5">
                    <div class="flex items-center justify-between text-[10px]">
                        <span class="px-2 py-0.5 rounded bg-amber-500/20 text-amber-300 font-bold uppercase">
                            {{ $post->category }}
                        </span>
                        <span class="text-amber-300/60 font-mono">{{ $post->reading_time }}</span>
                    </div>

                    <h4 class="font-['Noto_Sans_Malayalam',sans-serif] text-sm font-bold text-white line-clamp-2 leading-snug">
                        {{ $post->title }}
                    </h4>

                    <p class="font-['Noto_Sans_Malayalam',sans-serif] text-xs text-amber-100/70 line-clamp-2 leading-relaxed">
                        {{ $post->excerpt }}
                    </p>
                </div>

                <div class="pt-4 mt-3 border-t border-amber-500/15 flex items-center justify-between text-xs">
                    <span class="text-[10px] text-amber-300/60">
                        {{ $post->published_at ? $post->published_at->format('M d, Y') : 'Draft' }}
                    </span>
                    <a href="{{ route('admin.posts.edit', $post->id) }}"
                       class="text-amber-300 hover:text-white font-semibold">
                        Edit Article →
                    </a>
                </div>
            </div>
            @endforeach
        </div>
    </div>

</div>
@endsection

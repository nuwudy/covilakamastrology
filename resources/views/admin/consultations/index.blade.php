@extends('layouts.admin')

@section('title', 'Consultation & DOB Calculator Leads | Covilakam Astrology')
@section('page_title', 'Consultation & DOB Calculator Leads')

@section('content')
<div class="space-y-6">

    <!-- Header Actions -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <h1 class="font-cinzel text-2xl font-black text-white">
                Consultation & Free DOB Prediction Leads
            </h1>
            <p class="text-xs text-amber-200/70 mt-1">
                View seekers who submitted inquiries or used the instant numerology / Vedic planetary calculator on the homepage.
            </p>
        </div>

        <div class="flex items-center space-x-2">
            <span class="px-3 py-1.5 rounded-xl bg-[#1e1333] border border-amber-500/30 text-xs font-mono text-amber-300">
                Total Leads: <strong>{{ $stats['all'] }}</strong> ({{ $stats['pending'] }} Pending)
            </span>
        </div>
    </div>

    <!-- Filters Bar -->
    <div class="p-4 rounded-2xl bg-[#160d26] border border-amber-500/25 flex flex-wrap items-center justify-between gap-4 text-xs">
        <form method="GET" action="{{ route('admin.consultations.index') }}" class="flex flex-wrap items-center gap-3">
            <input type="text" name="search" value="{{ request('search') }}"
                   placeholder="Search by name, phone, email, place..."
                   class="px-3.5 py-2 rounded-xl bg-[#211335] border border-amber-500/30 text-white placeholder-amber-200/40 focus:outline-none focus:border-amber-400 text-xs w-64">

            <select name="status" onchange="this.form.submit()"
                    class="px-3 py-2 rounded-xl bg-[#211335] border border-amber-500/30 text-amber-200 text-xs">
                <option value="">All Statuses</option>
                <option value="pending" {{ request('status') === 'pending' ? 'selected' : '' }}>Pending</option>
                <option value="in_progress" {{ request('status') === 'in_progress' ? 'selected' : '' }}>In Progress</option>
                <option value="completed" {{ request('status') === 'completed' ? 'selected' : '' }}>Completed</option>
            </select>

            <button type="submit"
                    class="px-4 py-2 rounded-xl bg-amber-500/20 text-amber-300 hover:bg-amber-500/30 border border-amber-500/40 font-semibold">
                Filter
            </button>

            @if(request()->hasAny(['search', 'status']))
            <a href="{{ route('admin.consultations.index') }}" class="text-amber-400 hover:text-white underline">Clear</a>
            @endif
        </form>
    </div>

    <!-- Leads Table -->
    <div class="rounded-3xl bg-[#160d26] border border-amber-500/30 overflow-hidden shadow-2xl">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse text-xs">
                <thead>
                    <tr class="bg-[#12091c] border-b border-amber-500/20 text-amber-300/80 uppercase tracking-wider text-[10px]">
                        <th class="py-4 px-4 font-bold">Client / Seeker</th>
                        <th class="py-4 px-4 font-bold">DOB & Birth Place</th>
                        <th class="py-4 px-4 font-bold">Calculated Ruling Planet</th>
                        <th class="py-4 px-4 font-bold">Service / Inquiries</th>
                        <th class="py-4 px-4 font-bold text-center">Date & Status</th>
                        <th class="py-4 px-4 font-bold text-right">Quick Contact</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-amber-500/15">
                    @forelse($consultations as $lead)
                    @php
                        $targetPhone = preg_replace('/[^0-9]/', '', $lead->whatsapp_number ?: $lead->phone);
                        if (strlen($targetPhone) === 10) {
                            $targetPhone = '91' . $targetPhone;
                        }
                        $rulingPlanet = $lead->calculated_summary['ruling_planet'] ?? null;
                        $rulingPlanetName = is_array($rulingPlanet) ? ($rulingPlanet['en'] ?? reset($rulingPlanet)) : $rulingPlanet;
                        $mulank = $lead->calculated_summary['mulank'] ?? null;
                        $bhagyank = $lead->calculated_summary['bhagyank'] ?? null;
                        $selectedLang = $lead->calculated_summary['selected_language'] ?? null;
                        $gemstone = $lead->calculated_summary['gemstone_en'] ?? null;
                    @endphp
                    <tr class="hover:bg-amber-500/5 transition-colors">
                        <!-- Client Name & Contact -->
                        <td class="py-4 px-4 space-y-1">
                            <h4 class="font-bold text-sm text-white">{{ $lead->name }}</h4>
                            @if($lead->whatsapp_number || $lead->phone)
                            <p class="font-mono text-emerald-300 font-semibold text-[11px] select-all flex items-center space-x-1">
                                <span>🟢 WA:</span>
                                <span>{{ $lead->whatsapp_number ?: $lead->phone }}</span>
                            </p>
                            @endif
                            @if($selectedLang)
                            <span class="inline-block px-1.5 py-0.5 rounded text-[9px] font-bold uppercase bg-purple-500/20 text-purple-300 border border-purple-500/30">
                                Lang: {{ strtoupper($selectedLang) }}
                            </span>
                            @endif
                            @if($lead->email)
                            <p class="text-[10px] text-amber-100/60 font-mono truncate max-w-[180px]">
                                ✉️ {{ $lead->email }}
                            </p>
                            @endif
                        </td>

                        <!-- DOB & Place -->
                        <td class="py-4 px-4 space-y-1">
                            @if($lead->birth_date)
                            <p class="font-mono text-amber-300 font-semibold text-xs">
                                📅 {{ \Carbon\Carbon::parse($lead->birth_date)->format('d M Y') }}
                            </p>
                            @if($lead->birth_time)
                            <p class="font-mono text-[10px] text-amber-100/70">
                                ⏰ {{ $lead->birth_time }}
                            </p>
                            @endif
                            @else
                            <span class="text-amber-100/50 italic">DOB not provided</span>
                            @endif

                            @if($lead->birth_place)
                            <p class="text-[11px] text-amber-200/80">
                                📍 {{ $lead->birth_place }}
                            </p>
                            @endif
                        </td>

                        <!-- Calculated Ruling Planet -->
                        <td class="py-4 px-4 space-y-1">
                            @if($rulingPlanetName)
                            <div class="inline-flex items-center space-x-1.5 px-2.5 py-1 rounded-lg bg-amber-500/15 border border-amber-500/30 text-amber-300 font-semibold text-[11px]">
                                <span>🪐</span>
                                <span>{{ $rulingPlanetName }}</span>
                            </div>
                            <div class="text-[10px] text-amber-300/80 font-mono space-y-0.5 mt-1">
                                @if($mulank)<p>Mulank: <strong>{{ $mulank }}</strong> @if($bhagyank) | Bhagyank: <strong>{{ $bhagyank }}</strong>@endif</p>@endif
                                @if($gemstone)<p class="text-amber-200/70">💎 {{ $gemstone }}</p>@endif
                            </div>
                            @else
                            <span class="text-[11px] text-amber-100/50">Direct Consultation</span>
                            @endif
                        </td>

                        <!-- Service Requested & Message -->
                        <td class="py-4 px-4 space-y-1 max-w-xs">
                            <span class="px-2 py-0.5 rounded text-[10px] font-bold uppercase bg-amber-500/20 text-amber-300">
                                {{ $lead->service_requested ?? 'General Reading' }}
                            </span>
                            @if($lead->message)
                            <p class="text-[11px] text-amber-100/70 line-clamp-2 leading-relaxed">
                                "{{ $lead->message }}"
                            </p>
                            @endif
                        </td>

                        <!-- Date & Status Dropdown -->
                        <td class="py-4 px-4 text-center space-y-2">
                            <p class="text-[10px] text-amber-300/60 font-mono">
                                {{ $lead->created_at->format('M d, Y') }}
                            </p>

                            <form action="{{ route('admin.consultations.status', $lead->id) }}" method="POST" class="inline-block">
                                @csrf
                                <select name="status" onchange="this.form.submit()"
                                        class="px-2 py-0.5 rounded-full text-[10px] font-bold uppercase cursor-pointer border {{ $lead->status === 'pending' ? 'bg-amber-500/20 text-amber-300 border-amber-500/40' : ($lead->status === 'completed' ? 'bg-emerald-500/20 text-emerald-300 border-emerald-500/40' : 'bg-blue-500/20 text-blue-300 border-blue-500/40') }}">
                                    <option value="pending" {{ $lead->status === 'pending' ? 'selected' : '' }}>Pending</option>
                                    <option value="in_progress" {{ $lead->status === 'in_progress' ? 'selected' : '' }}>In Progress</option>
                                    <option value="completed" {{ $lead->status === 'completed' ? 'selected' : '' }}>Completed</option>
                                </select>
                            </form>
                        </td>

                        <!-- WhatsApp Reply 1-Click Action -->
                        <td class="py-4 px-4 text-right">
                            <div class="flex items-center justify-end space-x-2">
                                @if($targetPhone)
                                <a href="https://wa.me/{{ $targetPhone }}?text={{ rawurlencode('Namaskaram ' . $lead->name . ', this is DR. E. K. Raja Varma (Vidya Vachaspathi in Vedic Astrology) from Covilakam Astrology regarding your inquiry for "' . ($lead->service_requested ?? 'Astrology Reading') . '". How may I guide you today?') }}"
                                   target="_blank"
                                   class="inline-flex items-center space-x-1.5 px-3 py-1.5 rounded-xl bg-gradient-to-r from-emerald-500 to-green-600 hover:from-emerald-400 hover:to-green-500 text-black font-bold text-xs shadow-md transition-all">
                                    <span>💬</span>
                                    <span>WhatsApp</span>
                                </a>
                                @endif

                                <form action="{{ route('admin.consultations.destroy', $lead->id) }}"
                                      method="POST"
                                      onsubmit="return confirm('Delete consultation inquiry from {{ addslashes($lead->name) }}?');"
                                      class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                            class="p-1.5 rounded-lg text-rose-400 hover:bg-rose-900/40 border border-rose-500/30 transition-colors"
                                            title="Delete Lead">
                                        🗑️
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="py-12 text-center text-amber-200/60">
                            No consultation inquiries recorded yet.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Pagination -->
    <div class="mt-6">
        {{ $consultations->links() }}
    </div>

</div>
@endsection

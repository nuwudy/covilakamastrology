@props([
    'title' => 'Rasi Chart (D1)',
    'subtitle' => 'Chitrapaksha Sidereal',
    'chartGrid' => [],
    'centerTitle' => 'Covilakam Kundali',
    'centerContent' => null,
    'lagnaRasi' => null,
    'language' => 'en',
])

@php
    // Fixed South Indian chart layout mapping: [row][col] => rasi_number (1..12) or null (center box)
    // Row 1: Pisces(12), Aries(1), Taurus(2), Gemini(3)
    // Row 2: Aquarius(11), Center, Center, Cancer(4)
    // Row 3: Capricorn(10), Center, Center, Leo(5)
    // Row 4: Sagittarius(9), Scorpio(8), Libra(7), Virgo(6)

    $rasiMeta = [
        1 => ['en' => 'Aries (Mesha)', 'ml' => 'മേടം', 'ta' => 'மேஷம்', 'hi' => 'मेष'],
        2 => ['en' => 'Taurus (Vrishabha)', 'ml' => 'ഇടവം', 'ta' => 'ரிஷபம்', 'hi' => 'वृषभ'],
        3 => ['en' => 'Gemini (Mithuna)', 'ml' => 'മിഥുനം', 'ta' => 'மிதுனம்', 'hi' => 'मिथुन'],
        4 => ['en' => 'Cancer (Karkidaka)', 'ml' => 'കർക്കിടകം', 'ta' => 'கடகம்', 'hi' => 'कर्क'],
        5 => ['en' => 'Leo (Simha)', 'ml' => 'ചിങ്ങം', 'ta' => 'சிம்மம்', 'hi' => 'सिंह'],
        6 => ['en' => 'Virgo (Kanya)', 'ml' => 'കന്നി', 'ta' => 'கன்னி', 'hi' => 'कन्या'],
        7 => ['en' => 'Libra (Thula)', 'ml' => 'തുലാം', 'ta' => 'துலாம்', 'hi' => 'तुला'],
        8 => ['en' => 'Scorpio (Vrischika)', 'ml' => 'വൃശ്ചികം', 'ta' => 'விருச்சிகம்', 'hi' => 'वृश्चिक'],
        9 => ['en' => 'Sagittarius (Dhanu)', 'ml' => 'ധനു', 'ta' => 'தனுசு', 'hi' => 'धनु'],
        10 => ['en' => 'Capricorn (Makara)', 'ml' => 'മകരം', 'ta' => 'மகரம்', 'hi' => 'मकर'],
        11 => ['en' => 'Aquarius (Kumbha)', 'ml' => 'കുംഭം', 'ta' => 'கும்பம்', 'hi' => 'कुंभ'],
        12 => ['en' => 'Pisces (Meena)', 'ml' => 'മീനം', 'ta' => 'மீனம்', 'hi' => 'मीन'],
    ];

    $grid = [
        [12, 1, 2, 3],
        [11, 'center', 'center', 4],
        [10, 'center', 'center', 5],
        [9, 8, 7, 6],
    ];
@endphp

<div class="south-indian-chart bg-gradient-to-br from-amber-950/40 via-stone-900 to-amber-950/30 border border-amber-600/40 rounded-xl p-3 sm:p-5 shadow-2xl relative select-none">
    <div class="flex items-center justify-between mb-3 border-b border-amber-600/20 pb-2">
        <div>
            <h4 class="text-amber-300 font-serif font-bold text-sm sm:text-base flex items-center gap-2">
                <span class="inline-block w-2 h-2 rounded-full bg-amber-400 animate-pulse"></span>
                {{ $title }}
            </h4>
            <p class="text-stone-400 text-xs">{{ $subtitle }}</p>
        </div>
        <span class="text-[10px] uppercase tracking-widest text-amber-500/80 font-mono px-2 py-0.5 rounded bg-amber-500/10 border border-amber-500/20">
            South Indian Style
        </span>
    </div>

    <div class="grid grid-cols-4 grid-rows-4 gap-1 sm:gap-2 aspect-square max-w-[480px] mx-auto bg-stone-950/80 p-1 sm:p-2 rounded-lg border border-amber-700/30">
        @for ($row = 0; $row < 4; $row++)
            @for ($col = 0; $col < 4; $col++)
                @php
                    $cell = $grid[$row][$col];
                @endphp

                @if ($cell === 'center')
                    {{-- Render center 2x2 box only once at row 1, col 1 --}}
                    @if ($row === 1 && $col === 1)
                        <div class="col-span-2 row-span-2 bg-gradient-to-br from-amber-950/80 to-stone-950 border border-amber-500/30 rounded-md flex flex-col items-center justify-center p-2 text-center shadow-inner">
                            <span class="text-amber-400/90 font-serif text-xs sm:text-sm font-semibold tracking-wider">
                                {{ $centerTitle }}
                            </span>
                            @if ($centerContent)
                                <div class="text-[10px] sm:text-xs text-stone-300 mt-1 space-y-0.5">
                                    {!! $centerContent !!}
                                </div>
                            @else
                                <div class="text-[9px] sm:text-[11px] text-amber-200/70 mt-1 font-serif">
                                    ചിത്രപക്ഷ അянаംശം<br>
                                    <span class="text-[8px] sm:text-[10px] text-stone-400">Chitrapaksha Lahiri</span>
                                </div>
                            @endif
                        </div>
                    @endif
                @else
                    @php
                        $rasiIndex = (int) $cell;
                        $occupants = $chartGrid[$rasiIndex] ?? [];
                        $isLagna = ($lagnaRasi && (int)$lagnaRasi === $rasiIndex);
                        $meta = $rasiMeta[$rasiIndex] ?? [];
                        $rasiTitle = $meta[$language] ?? $meta['ml'] ?? $meta['en'];
                    @endphp
                    <div class="relative bg-stone-900/90 border {{ $isLagna ? 'border-amber-400 bg-amber-500/10 shadow-amber-500/20 shadow-md ring-1 ring-amber-400/50' : 'border-amber-800/30' }} rounded-sm p-1 flex flex-col justify-between overflow-hidden min-h-[58px] sm:min-h-[85px] transition-all hover:border-amber-500/60">
                        {{-- Rasi header label --}}
                        <div class="flex items-center justify-between text-[9px] sm:text-[11px] text-amber-400/80 font-serif leading-none border-b border-amber-900/40 pb-0.5">
                            <span class="truncate font-semibold">{{ $rasiTitle }}</span>
                            @if ($isLagna)
                                <span class="bg-amber-400 text-stone-950 text-[8px] sm:text-[9px] font-bold px-1 rounded-sm leading-tight ml-0.5">ല</span>
                            @endif
                        </div>

                        {{-- Occupants inside the Rasi --}}
                        <div class="flex-1 flex flex-wrap content-start items-center gap-1 pt-1 overflow-y-auto">
                            @forelse ($occupants as $occ)
                                @php
                                    $isAsc = in_array($occ['key'], ['As', 'Lagna']);
                                    $isMd = in_array($occ['key'], ['Md', 'Gulika']);
                                    $badgeColor = $isAsc
                                        ? 'bg-amber-400 text-stone-950 font-bold'
                                        : ($isMd
                                            ? 'bg-purple-900/70 text-purple-200 border border-purple-500/40'
                                            : 'bg-stone-800/90 text-amber-200/90 border border-amber-600/30');
                                @endphp
                                <span class="inline-flex items-center px-1 py-0.2 rounded text-[8px] sm:text-[10px] {{ $badgeColor }}" title="{{ $occ['name_en'] ?? $occ['key'] }}">
                                    {{ $occ['label'] ?? $occ['key'] }}
                                    @if (isset($occ['deg']))
                                        <span class="text-[7px] sm:text-[8px] opacity-70 ml-0.5">{{ $occ['deg'] }}°</span>
                                    @endif
                                </span>
                            @empty
                                <span class="text-[8px] text-stone-600 italic">--</span>
                            @endforelse
                        </div>
                    </div>
                @endif
            @endfor
        @endfor
    </div>
</div>


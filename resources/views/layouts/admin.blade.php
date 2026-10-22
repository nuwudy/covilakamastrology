<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full bg-[#0d0716]">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'Admin Dashboard | Covilakam Astrology')</title>

    <!-- Favicon -->
    <link rel="icon" type="image/png" href="{{ asset('favicon.png') }}?v={{ time() }}">
    <link rel="shortcut icon" href="{{ asset('favicon.ico') }}?v={{ time() }}">
    <link rel="apple-touch-icon" href="{{ asset('apple-touch-icon.png') }}?v={{ time() }}">

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cinzel:wght@600;700;800;900&family=Plus+Jakarta+Sans:wght@300;400;500;600;700&family=Noto+Sans+Malayalam:wght@400;500;600;700&display=swap" rel="stylesheet">

    <!-- Styles & Scripts via Vite -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        body {
            font-family: 'Plus Jakarta Sans', system-ui, sans-serif;
            background-color: #0d0716;
            color: #fdfbf7;
        }
        [x-cloak] { display: none !important; }
        .gold-glow {
            box-shadow: 0 0 25px rgba(212, 175, 55, 0.25);
        }
        .sidebar-active {
            background: linear-gradient(90deg, rgba(212, 175, 55, 0.18) 0%, rgba(26, 17, 40, 0.4) 100%);
            border-left: 4px solid #D4AF37;
            color: #FDE047;
            font-weight: 700;
        }
    </style>
    @stack('styles')
</head>
<body class="h-full bg-[#0d0716] text-[#fdfbf7] antialiased selection:bg-amber-500 selection:text-black"
      x-data="{ sidebarOpen: false }">

    <div class="min-h-full flex">
        
        <!-- ========================================================================= -->
        <!-- CLASSIC FIXED LEFT SIDEBAR (Cosmic Indigo #1A1128 with Gold #D4AF37)       -->
        <!-- ========================================================================= -->

        <!-- Mobile Sidebar Backdrop -->
        <div x-show="sidebarOpen"
             x-cloak
             x-transition:enter="transition-opacity ease-linear duration-300"
             x-transition:enter-start="opacity-0"
             x-transition:enter-end="opacity-100"
             x-transition:leave="transition-opacity ease-linear duration-300"
             x-transition:leave-start="opacity-100"
             x-transition:leave-end="opacity-0"
             @click="sidebarOpen = false"
             class="fixed inset-0 bg-black/80 backdrop-blur-sm z-40 lg:hidden"></div>

        <!-- Sidebar Container -->
        <aside :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full lg:translate-x-0'"
               class="fixed inset-y-0 left-0 z-50 w-64 bg-[#160d26] border-r border-amber-500/25 flex flex-col justify-between transition-transform duration-300 ease-in-out shadow-2xl">
            
            <div>
                <!-- Brand & Logo Header -->
                <div class="px-6 py-6 border-b border-amber-500/20 bg-[#12091c]">
                    <div class="flex items-center space-x-3">
                        <div class="w-11 h-11 rounded-2xl p-0.5 bg-gradient-to-tr from-amber-600 via-amber-300 to-yellow-500 shadow-md shrink-0">
                            <img src="{{ asset('images/og-covilakam-512x512.png') }}"
                                 alt="Covilakam Astrology"
                                 class="w-full h-full rounded-xl object-cover">
                        </div>
                        <div>
                            <span class="font-cinzel text-base font-extrabold tracking-wider text-amber-300 block leading-tight">
                                COVILAKAM
                            </span>
                            <span class="text-[10px] tracking-widest uppercase font-bold text-amber-400/80 block">
                                Admin Dashboard
                            </span>
                        </div>
                    </div>
                </div>

                <!-- Astrologer Identity Mini-Card -->
                <div class="px-5 py-3 mx-4 my-4 rounded-2xl bg-[#1e1333] border border-amber-500/30 text-xs">
                    <p class="font-bold text-white text-[12px] truncate">
                        DR. E. K. Raja Varma
                    </p>
                    <p class="text-[10px] text-amber-300/80 truncate">
                        Vidya Vachaspathi (Gold Medalist)
                    </p>
                </div>

                <!-- Navigation Links List -->
                <nav class="px-3 space-y-1 text-xs">
                    
                    <!-- 1. Dashboard Overview -->
                    <a href="{{ route('admin.dashboard') }}"
                       class="flex items-center justify-between px-3.5 py-3 rounded-xl transition-all {{ request()->routeIs('admin.dashboard') ? 'sidebar-active' : 'text-amber-100/70 hover:text-amber-200 hover:bg-amber-500/10' }}">
                        <div class="flex items-center space-x-3">
                            <span class="text-base">📊</span>
                            <span class="font-medium">Dashboard Overview</span>
                        </div>
                    </a>

                    <!-- 2. Vedic Astrology Video Gallery -->
                    <a href="{{ route('admin.videos.index') }}"
                       class="flex items-center justify-between px-3.5 py-3 rounded-xl transition-all {{ request()->routeIs('admin.videos.*') ? 'sidebar-active' : 'text-amber-100/70 hover:text-amber-200 hover:bg-amber-500/10' }}">
                        <div class="flex items-center space-x-3">
                            <span class="text-base">🎬</span>
                            <span class="font-medium">Video Gallery</span>
                        </div>
                        <span class="px-2 py-0.5 rounded-full text-[10px] font-bold bg-red-600/30 text-red-300 border border-red-500/30">
                            {{ \App\Models\Video::count() }}
                        </span>
                    </a>

                    <!-- 3. Vedic Wisdom Repository — Astrology Articles -->
                    <a href="{{ route('admin.posts.index') }}"
                       class="flex items-center justify-between px-3.5 py-3 rounded-xl transition-all {{ request()->routeIs('admin.posts.*') ? 'sidebar-active' : 'text-amber-100/70 hover:text-amber-200 hover:bg-amber-500/10' }}">
                        <div class="flex items-center space-x-3">
                            <span class="text-base">📜</span>
                            <span class="font-medium">Articles & Wisdom</span>
                        </div>
                        <span class="px-2 py-0.5 rounded-full text-[10px] font-bold bg-amber-500/20 text-amber-300 border border-amber-500/30">
                            {{ \App\Models\Post::count() }}
                        </span>
                    </a>

                    <!-- 4. Consultation & DOB Leads -->
                    <a href="{{ route('admin.consultations.index') }}"
                       class="flex items-center justify-between px-3.5 py-3 rounded-xl transition-all {{ request()->routeIs('admin.consultations.*') ? 'sidebar-active' : 'text-amber-100/70 hover:text-amber-200 hover:bg-amber-500/10' }}">
                        <div class="flex items-center space-x-3">
                            <span class="text-base">🙏</span>
                            <span class="font-medium">Consultation Leads</span>
                        </div>
                        @php $pendingCount = \App\Models\Consultation::where('status', 'pending')->count(); @endphp
                        @if($pendingCount > 0)
                        <span class="px-2 py-0.5 rounded-full text-[10px] font-bold bg-emerald-500/20 text-emerald-300 border border-emerald-500/40 animate-pulse">
                            {{ $pendingCount }} new
                        </span>
                        @endif
                    </a>

                    <!-- 5. 4-Language Astrology Content -->
                    <a href="{{ route('admin.translations.index') }}"
                       class="flex items-center justify-between px-3.5 py-3 rounded-xl transition-all {{ request()->routeIs('admin.translations.*') ? 'sidebar-active' : 'text-amber-100/70 hover:text-amber-200 hover:bg-amber-500/10' }}">
                        <div class="flex items-center space-x-3">
                            <span class="text-base">🌐</span>
                            <span class="font-medium">4 Languages Content</span>
                        </div>
                        <span class="text-[10px] text-amber-400 font-mono">ML/EN/HI/TA</span>
                    </a>

                    <!-- 6. Profile & Settings -->
                    <a href="{{ route('admin.settings.index') }}"
                       class="flex items-center justify-between px-3.5 py-3 rounded-xl transition-all {{ request()->routeIs('admin.settings.*') ? 'sidebar-active' : 'text-amber-100/70 hover:text-amber-200 hover:bg-amber-500/10' }}">
                        <div class="flex items-center space-x-3">
                            <span class="text-base">⚙️</span>
                            <span class="font-medium">Settings & Profile</span>
                        </div>
                    </a>

                    <!-- 7. Media Library -->
                    <a href="{{ route('admin.media.index') }}"
                       class="flex items-center justify-between px-3.5 py-3 rounded-xl transition-all {{ request()->routeIs('admin.media.*') ? 'sidebar-active' : 'text-amber-100/70 hover:text-amber-200 hover:bg-amber-500/10' }}">
                        <div class="flex items-center space-x-3">
                            <span class="text-base">🖼️</span>
                            <span class="font-medium">Media Library</span>
                        </div>
                        <span class="text-[10px] text-amber-300/70 font-mono">WebP</span>
                    </a>

                </nav>
            </div>

            <!-- Bottom Live Portal Link & Logout -->
            <div class="p-4 border-t border-amber-500/20 bg-[#12091c] space-y-2">
                <a href="{{ route('home') }}" target="_blank"
                   class="w-full py-2.5 px-3 rounded-xl text-xs font-semibold text-amber-200 bg-[#211335] hover:bg-amber-500/20 border border-amber-500/30 flex items-center justify-center space-x-2 transition-all">
                    <span>🌐 View Live Website</span>
                    <span class="text-amber-400 text-xs">↗</span>
                </a>

                <form action="{{ route('admin.logout') }}" method="POST">
                    @csrf
                    <button type="submit"
                            class="w-full py-2.5 px-3 rounded-xl text-xs font-semibold text-rose-300 hover:text-white bg-rose-950/40 hover:bg-rose-900/60 border border-rose-500/30 flex items-center justify-center space-x-2 transition-all">
                        <span>🔒 Logout Session</span>
                    </button>
                </form>
            </div>

        </aside>

        <!-- ========================================================================= -->
        <!-- MAIN CONTENT AREA WITH TOP HEADER                                         -->
        <!-- ========================================================================= -->
        <div class="flex-1 lg:pl-64 flex flex-col min-h-screen">
            
            <!-- Top Header Bar -->
            <header class="sticky top-0 z-30 bg-[#140b22]/95 border-b border-amber-500/20 backdrop-blur-md px-4 sm:px-8 py-3.5 flex items-center justify-between shadow-lg">
                <!-- Left: Mobile Toggle & Page Title -->
                <div class="flex items-center space-x-4">
                    <button type="button" @click="sidebarOpen = !sidebarOpen"
                            class="lg:hidden p-2 rounded-xl text-amber-300 hover:bg-amber-500/20 border border-amber-500/30">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                        </svg>
                    </button>

                    <div>
                        <h2 class="font-cinzel text-base sm:text-lg font-bold text-white flex items-center space-x-2">
                            <span>@yield('page_title', 'Administration Portal')</span>
                        </h2>
                    </div>
                </div>

                <!-- Right: Astrologer Designation & Live Link -->
                <div class="flex items-center space-x-3 sm:space-x-5">
                    <div class="hidden md:flex flex-col text-right">
                        <span class="text-xs font-bold text-amber-200">
                            DR. E. K. Raja Varma
                        </span>
                        <span class="text-[10px] text-amber-300/70">
                            (Vidya Vachaspathi in Vedic Astrology)
                        </span>
                    </div>

                    <a href="{{ route('home') }}" target="_blank"
                       class="hidden sm:inline-flex items-center space-x-1.5 px-3 py-1.5 rounded-lg text-xs font-medium text-amber-300 bg-amber-500/10 border border-amber-500/30 hover:bg-amber-500/20 transition-colors">
                        <span>View Website</span>
                        <span>↗</span>
                    </a>

                    <form action="{{ route('admin.logout') }}" method="POST" class="inline">
                        @csrf
                        <button type="submit"
                                title="Logout Session"
                                class="p-2 rounded-xl text-rose-300 hover:text-white hover:bg-rose-900/40 border border-rose-500/30 transition-colors">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                            </svg>
                        </button>
                    </form>
                </div>
            </header>

            <!-- Main Page Content Body -->
            <main class="flex-1 p-4 sm:p-8 bg-[#0d0716]">
                <!-- Flash Messages -->
                @if (session('success'))
                <div class="mb-6 p-4 rounded-2xl bg-emerald-950/70 border border-emerald-500/40 text-emerald-200 text-xs flex items-center justify-between shadow-xl">
                    <div class="flex items-center space-x-2.5">
                        <span class="text-base">✓</span>
                        <span class="font-medium">{{ session('success') }}</span>
                    </div>
                    <button type="button" @click="$el.parentElement.remove()" class="text-emerald-400 hover:text-white font-bold ml-4">✕</button>
                </div>
                @endif

                @if ($errors->any())
                <div class="mb-6 p-4 rounded-2xl bg-rose-950/70 border border-rose-500/40 text-rose-200 text-xs shadow-xl space-y-1">
                    <div class="font-bold mb-1 flex items-center space-x-2">
                        <span>⚠️ Please resolve the following errors:</span>
                    </div>
                    @foreach ($errors->all() as $error)
                        <p class="ml-4">• {{ $error }}</p>
                    @endforeach
                </div>
                @endif

                @yield('content')
            </main>

            <!-- Admin Footer -->
            <footer class="px-6 py-4 border-t border-amber-500/10 text-center text-[11px] text-amber-200/50 bg-[#12091c]">
                Covilakam Astrology Portal Management System • DR. E. K. Raja Varma (Vidya Vachaspathi in Vedic Astrology)
            </footer>

        </div>

    </div>

    @stack('scripts')
</body>
</html>

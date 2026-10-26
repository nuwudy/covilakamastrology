<header x-data="{ mobileMenuOpen: false, scrolled: false }"
        @scroll.window="scrolled = (window.pageYOffset > 20)"
        :class="scrolled ? 'bg-[#140b22]/95 backdrop-blur-md border-b border-amber-500/30 shadow-2xl py-3' : 'bg-transparent border-b border-amber-500/15 py-4'"
        class="fixed top-0 left-0 right-0 z-50 transition-all duration-300">
    <div class="max-w-7xl mx-auto px-3 sm:px-6 lg:px-8">
        <div class="flex items-center justify-between gap-2 sm:gap-4">
            <!-- Brand & Astrologer Name -->
            <a href="{{ route('home') }}" class="group flex items-center space-x-2.5 sm:space-x-3.5 focus:outline-none min-w-0 shrink">
                <div class="w-9 h-9 sm:w-11 sm:h-12 rounded-full p-0.5 bg-gradient-to-tr from-amber-600 via-amber-300 to-yellow-500 shadow-xl gold-glow group-hover:scale-105 transition-transform duration-300 shrink-0">
                    <img src="{{ asset('images/og-covilakam-512x512.png') }}"
                         alt="Covilakam Astrology Logo"
                         class="w-full h-full rounded-full object-cover shadow-inner">
                </div>
                <div class="min-w-0 shrink">
                    <div class="flex items-center space-x-1.5 sm:space-x-2">
                        <span class="font-cinzel text-base sm:text-xl lg:text-2xl font-bold tracking-wider text-amber-300 group-hover:text-amber-200 transition-colors whitespace-nowrap">
                            COVILAKAM
                        </span>
                        <span class="font-cinzel text-[10px] sm:text-xs uppercase px-1.5 py-0.5 rounded border border-amber-500/40 text-amber-200 bg-amber-500/10 shrink-0">
                            Astrology
                        </span>
                    </div>
                    <p class="text-[10px] sm:text-xs text-amber-100/70 font-sans tracking-wide truncate">
                        <strong class="text-amber-300 font-semibold">DR. E. K. Raja Varma</strong>
                        <span class="text-[10px] text-amber-200/60 ml-0.5 hidden sm:inline">(Vidya Vachaspathi in Vedic Astrology)</span>
                    </p>
                </div>
            </a>

            <!-- Desktop Navigation Links -->
            <nav class="hidden lg:flex items-center space-x-6 text-sm font-medium">
                <a href="{{ route('home') }}#hero" class="text-amber-100/80 hover:text-amber-300 transition-colors py-1">Home</a>
                <a href="{{ route('home') }}#dob-calculator" class="text-amber-300 font-semibold hover:text-amber-200 transition-colors py-1 flex items-center space-x-1">
                    <span>Free DOB Reading</span>
                    <span class="relative flex h-2 w-2">
                        <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-amber-400 opacity-75"></span>
                        <span class="relative inline-flex rounded-full h-2 w-2 bg-amber-500"></span>
                    </span>
                </a>
                <a href="{{ route('home') }}#services" class="text-amber-100/80 hover:text-amber-300 transition-colors py-1">Services</a>
                <a href="{{ route('home') }}#why-covilakam" class="text-amber-100/80 hover:text-amber-300 transition-colors py-1">Why Covilakam</a>
                <a href="{{ route('videos.index') }}" class="{{ request()->routeIs('videos.*') ? 'text-amber-300 font-bold border-b-2 border-amber-400' : 'text-amber-100/80 hover:text-amber-300' }} transition-colors py-1 flex items-center space-x-1">
                    <span>Videos</span>
                    <span class="w-1.5 h-1.5 rounded-full bg-red-500 animate-pulse"></span>
                </a>
                <a href="{{ route('home') }}#books" class="text-amber-100/80 hover:text-amber-300 transition-colors py-1">Books</a>
                <a href="{{ route('shop.index') }}" class="text-amber-300 font-bold hover:text-amber-100 transition-colors py-1 flex items-center space-x-1">
                    <span>📚</span>
                    <span>Bookstore</span>
                </a>
                <a href="{{ route('blog.index') }}" class="text-amber-100/80 hover:text-amber-300 transition-colors py-1">Blog</a>
                <a href="{{ route('visiting-card') }}" class="text-amber-100/80 hover:text-amber-300 transition-colors py-1">Visiting Card</a>
                @auth
                <a href="{{ route('admin.dashboard') }}" class="text-amber-300 font-semibold hover:text-amber-100 transition-colors py-1 flex items-center space-x-1">
                    <span>⚙️</span>
                    <span>Dashboard</span>
                </a>
                @endauth
            </nav>

            <!-- Actions / CTA Button -->
            <div class="hidden sm:flex items-center space-x-3 shrink-0">
                <a href="https://wa.me/917907052160?text={{ rawurlencode('Namaskaram DR. E. K. Raja Varma (Vidya Vachaspathi in Vedic Astrology), I would like to consult with you.') }}"
                   target="_blank"
                   rel="noopener noreferrer"
                   class="inline-flex items-center space-x-2 px-4 py-2 rounded-full text-xs sm:text-sm font-semibold text-[#1a1128] bg-gradient-to-r from-amber-300 via-yellow-400 to-amber-500 hover:from-amber-200 hover:to-yellow-300 shadow-md hover:shadow-amber-500/30 transition-all duration-200 transform hover:-translate-y-0.5">
                    <!-- WhatsApp SVG -->
                    <svg class="w-4 h-4 text-[#1a1128]" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M12.031 6.172c-3.181 0-5.767 2.586-5.768 5.766-.001 1.298.38 2.27 1.019 3.287l-.711 2.598 2.664-.698c.969.585 1.961.947 2.796.947 3.179 0 5.766-2.587 5.767-5.766.001-3.181-2.586-5.767-5.767-5.767zm0 10.373c-.768 0-1.637-.251-2.327-.661l-.167-.099-1.58.414.422-1.539-.109-.174c-.453-.722-.693-1.564-.693-2.55 0-2.539 2.066-4.605 4.606-4.605 2.54 0 4.606 2.066 4.606 4.606 0 2.54-2.066 4.608-4.755 4.608z"/>
                    </svg>
                    <span>Chat +91 7907052160</span>
                </a>
            </div>

            <!-- Mobile Action Area -->
            <div class="flex items-center lg:hidden shrink-0">
                <!-- Mobile Hamburger Button -->
                <button @click="mobileMenuOpen = !mobileMenuOpen"
                        class="p-2 rounded-xl text-amber-300 hover:text-amber-100 hover:bg-amber-500/10 focus:outline-none transition-colors shrink-0"
                        aria-label="Toggle Navigation">
                    <svg x-show="!mobileMenuOpen" class="w-7 h-7 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7"/>
                    </svg>
                    <svg x-show="mobileMenuOpen" x-cloak class="w-7 h-7 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>
        </div>

        <!-- Mobile Menu Dropdown -->
        <div x-show="mobileMenuOpen"
             x-cloak
             x-transition:enter="transition ease-out duration-200"
             x-transition:enter-start="opacity-0 -translate-y-4"
             x-transition:enter-end="opacity-100 translate-y-0"
             x-transition:leave="transition ease-in duration-150"
             x-transition:leave-start="opacity-100 translate-y-0"
             x-transition:leave-end="opacity-0 -translate-y-4"
             class="lg:hidden mt-3 pt-3 pb-4 border-t border-amber-500/20 bg-[#1a1128]/95 backdrop-blur-xl rounded-2xl p-4 shadow-2xl">
            <div class="flex flex-col space-y-2.5 text-sm font-medium">
                <a @click="mobileMenuOpen = false" href="{{ route('home') }}#hero" class="px-3 py-2 rounded-lg text-amber-100 hover:text-amber-300 hover:bg-amber-500/10">Home</a>
                <a @click="mobileMenuOpen = false" href="{{ route('home') }}#dob-calculator" class="px-3 py-2 rounded-lg text-amber-300 font-semibold bg-amber-500/15 flex items-center justify-between">
                    <span>Free DOB Instant Reading</span>
                    <span class="text-xs px-2 py-0.5 rounded-full bg-amber-400 text-[#1a1128] font-bold">Free</span>
                </a>
                <a @click="mobileMenuOpen = false" href="{{ route('home') }}#services" class="px-3 py-2 rounded-lg text-amber-100 hover:text-amber-300 hover:bg-amber-500/10">Core Services</a>
                <a @click="mobileMenuOpen = false" href="{{ route('home') }}#why-covilakam" class="px-3 py-2 rounded-lg text-amber-100 hover:text-amber-300 hover:bg-amber-500/10">Why Covilakam Astrology</a>
                <a @click="mobileMenuOpen = false" href="{{ route('videos.index') }}" class="px-3 py-2 rounded-lg {{ request()->routeIs('videos.*') ? 'text-amber-300 font-bold bg-amber-500/20 border border-amber-500/30' : 'text-amber-100 hover:text-amber-300 hover:bg-amber-500/10' }} flex items-center justify-between">
                    <div class="flex items-center space-x-2">
                        <span class="text-red-400">🎬</span>
                        <span>Vedic Video Gallery</span>
                    </div>
                    <span class="text-[10px] px-1.5 py-0.5 rounded bg-amber-500/20 text-amber-300 border border-amber-500/30 font-semibold">Videos</span>
                </a>
                <a @click="mobileMenuOpen = false" href="{{ route('home') }}#books" class="px-3 py-2 rounded-lg text-amber-100 hover:text-amber-300 hover:bg-amber-500/10">Dr. Raja Varma's Books (രചനകൾ)</a>
                <a @click="mobileMenuOpen = false" href="{{ route('home') }}#philosophy" class="px-3 py-2 rounded-lg text-amber-100 hover:text-amber-300 hover:bg-amber-500/10">Astrology Philosophy</a>
                <a @click="mobileMenuOpen = false" href="{{ route('shop.index') }}" class="px-3 py-2 rounded-lg text-amber-300 font-bold bg-amber-500/20 border border-amber-500/30 flex items-center justify-between">
                    <span>📚 Vedic Bookstore & Shop</span>
                    <span class="text-xs px-2 py-0.5 rounded-full bg-amber-400 text-[#1a1128] font-bold">New</span>
                </a>
                <a @click="mobileMenuOpen = false" href="{{ route('blog.index') }}" class="px-3 py-2 rounded-lg text-amber-100 hover:text-amber-300 hover:bg-amber-500/10">Astrology Blogs</a>
                <a @click="mobileMenuOpen = false" href="{{ route('visiting-card') }}" class="px-3 py-2 rounded-lg text-amber-100 hover:text-amber-300 hover:bg-amber-500/10">Digital Visiting Card</a>
                @auth
                <a @click="mobileMenuOpen = false" href="{{ route('admin.dashboard') }}" class="px-3 py-2 rounded-lg text-amber-300 hover:text-amber-100 bg-amber-500/20 flex items-center justify-between font-semibold">
                    <span>⚙️ Admin Dashboard</span>
                    <span class="text-[10px] px-1.5 py-0.5 rounded bg-amber-500/30 text-amber-200">Logged In</span>
                </a>
                @endauth

                <div class="pt-3 border-t border-amber-500/20 flex flex-col gap-2">
                    <a href="https://wa.me/917907052160?text={{ rawurlencode('Namaskaram DR. E. K. Raja Varma (Vidya Vachaspathi in Vedic Astrology), I would like to consult with you.') }}"
                       target="_blank"
                       class="w-full text-center py-2.5 rounded-xl font-bold text-xs text-[#1a1128] bg-gradient-to-r from-amber-300 via-yellow-400 to-amber-500 shadow-md">
                        Chat on WhatsApp (+91 7907052160)
                    </a>
                    <a href="tel:+919447327450"
                       class="w-full text-center py-2.5 rounded-xl font-medium text-xs text-amber-200 border border-amber-500/30 bg-amber-950/40">
                        Call / GPay: 094473 27450
                    </a>
                </div>
            </div>
        </div>
    </div>
</header>

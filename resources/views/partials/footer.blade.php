<footer class="bg-[#0f0819] text-amber-100/80 border-t border-amber-500/25 relative overflow-hidden">
    <!-- Subtle Golden Background Aura -->
    <div class="absolute inset-0 bg-radial from-amber-600/5 via-transparent to-transparent pointer-events-none"></div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pt-16 pb-12 relative z-10">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-10">
            <!-- Brand Column -->
            <div class="space-y-4">
                <div class="flex items-center space-x-3">
                    <div class="w-10 h-10 rounded-full p-0.5 bg-gradient-to-tr from-amber-600 via-amber-300 to-yellow-500">
                        <div class="w-full h-full rounded-full bg-[#1a1128] flex items-center justify-center text-amber-300 font-serif text-lg font-bold">
                            ॐ
                        </div>
                    </div>
                    <div>
                        <span class="font-cinzel text-xl font-bold tracking-wider text-amber-300 block">
                            COVILAKAM ASTROLOGY
                        </span>
                        <span class="text-xs italic text-amber-200/70">Explore. Discover. Transform.</span>
                    </div>
                </div>

                <div class="pt-2">
                    <p class="font-cinzel text-base font-bold text-amber-200">
                        Dr. E. K. Raja Varma
                    </p>
                    <p class="text-xs text-amber-400 font-medium">
                        (Vidya Vachaspathi in Vedic Astrology)
                    </p>
                </div>

                <p class="text-xs text-amber-100/70 leading-relaxed">
                    Official portal of Dr. E. K. Raja Varma (Vidya Vachaspathi in Vedic Astrology). Blending classical Parashara principles with modern psychological Astro Counselling since 2022.
                </p>

                <!-- Credentials Badges -->
                <div class="pt-2 flex flex-wrap gap-1.5 text-[10px]">
                    <span class="px-2 py-0.5 rounded-full border border-amber-500/30 bg-amber-500/10 text-amber-300">Ph.D. in Vedic Astrology</span>
                    <span class="px-2 py-0.5 rounded-full border border-amber-500/30 bg-amber-500/10 text-amber-300">2026 Gold Medalist</span>
                    <span class="px-2 py-0.5 rounded-full border border-amber-500/30 bg-amber-500/10 text-amber-300">IAF Life Member #11009</span>
                </div>
            </div>

            <!-- Quick Links -->
            <div>
                <h4 class="font-cinzel text-sm font-bold tracking-wider text-amber-300 uppercase mb-4 pb-1 border-b border-amber-500/20 inline-block">
                    Quick Navigation
                </h4>
                <ul class="space-y-2.5 text-xs">
                    <li><a href="{{ route('home') }}#hero" class="hover:text-amber-300 transition-colors flex items-center space-x-1.5"><span class="text-amber-500">❖</span><span>Home Portal</span></a></li>
                    <li><a href="{{ route('home') }}#dob-calculator" class="text-amber-300 font-semibold hover:text-amber-200 transition-colors flex items-center space-x-1.5"><span class="text-amber-500">❖</span><span>Instant Free DOB Reading</span></a></li>
                    <li><a href="{{ route('home') }}#services" class="hover:text-amber-300 transition-colors flex items-center space-x-1.5"><span class="text-amber-500">❖</span><span>Core Astro Services</span></a></li>
                    <li><a href="{{ route('home') }}#why-covilakam" class="hover:text-amber-300 transition-colors flex items-center space-x-1.5"><span class="text-amber-500">❖</span><span>Why Dr. E. K. Raja Varma</span></a></li>
                    <li><a href="{{ route('home') }}#videos" class="hover:text-amber-300 transition-colors flex items-center space-x-1.5"><span class="text-amber-500">❖</span><span>YouTube Video Gallery</span></a></li>
                    <li><a href="{{ route('home') }}#philosophy" class="hover:text-amber-300 transition-colors flex items-center space-x-1.5"><span class="text-amber-500">❖</span><span>Vedic Philosophy (4 Languages)</span></a></li>
                    <li><a href="{{ route('blog.index') }}" class="hover:text-amber-300 transition-colors flex items-center space-x-1.5"><span class="text-amber-500">❖</span><span>Astrology Articles & Insights</span></a></li>
                    <li><a href="{{ route('visiting-card') }}" class="hover:text-amber-300 transition-colors flex items-center space-x-1.5"><span class="text-amber-500">❖</span><span>Digital Visiting Card</span></a></li>
                    @auth
                        <li><a href="{{ route('admin.dashboard') }}" class="text-amber-400 font-semibold hover:text-amber-200 transition-colors flex items-center space-x-1.5"><span class="text-amber-500">❖</span><span>Admin Dashboard</span></a></li>
                    @else
                        <li><a href="{{ route('admin.login') }}" class="text-amber-400/80 hover:text-amber-200 transition-colors flex items-center space-x-1.5"><span class="text-amber-500">❖</span><span>Admin Login</span></a></li>
                    @endauth
                </ul>
            </div>

            <!-- Core Services -->
            <div>
                <h4 class="font-cinzel text-sm font-bold tracking-wider text-amber-300 uppercase mb-4 pb-1 border-b border-amber-500/20 inline-block">
                    Consultation Services
                </h4>
                <ul class="space-y-2 text-xs">
                    <li class="flex items-center space-x-2 text-amber-100/90">
                        <span class="w-1.5 h-1.5 rounded-full bg-amber-400"></span>
                        <span>Accurate Predictions (കൃത്യമായ ഗ്രഹഫലം)</span>
                    </li>
                    <li class="flex items-center space-x-2 text-amber-100/90">
                        <span class="w-1.5 h-1.5 rounded-full bg-amber-400"></span>
                        <span>Jathakam Reports (സമ്പൂർണ്ണ ജാതകം)</span>
                    </li>
                    <li class="flex items-center space-x-2 text-amber-100/90">
                        <span class="w-1.5 h-1.5 rounded-full bg-amber-400"></span>
                        <span>Marriage Match Reports (വിവാഹ പൊരുത്തം)</span>
                    </li>
                    <li class="flex items-center space-x-2 text-amber-100/90">
                        <span class="w-1.5 h-1.5 rounded-full bg-amber-400"></span>
                        <span>Gem Prediction Reports (ഭാഗ്യ രത്നം)</span>
                    </li>
                    <li class="flex items-center space-x-2 text-amber-100/90">
                        <span class="w-1.5 h-1.5 rounded-full bg-amber-400"></span>
                        <span>Muhoorthams (ശുഭ മുഹൂർത്തം)</span>
                    </li>
                    <li class="flex items-center space-x-2 text-amber-100/90">
                        <span class="w-1.5 h-1.5 rounded-full bg-amber-400"></span>
                        <span>Online Astro Counselling</span>
                    </li>
                </ul>
            </div>

            <!-- Official Contact & Payment Info -->
            <div class="space-y-3">
                <h4 class="font-cinzel text-sm font-bold tracking-wider text-amber-300 uppercase mb-4 pb-1 border-b border-amber-500/20 inline-block">
                    Contact & Payments
                </h4>

                <div class="space-y-2.5 text-xs">
                    <!-- WhatsApp -->
                    <a href="https://wa.me/917907052160" target="_blank" class="flex items-start space-x-2.5 group">
                        <span class="text-emerald-400 font-bold">WA:</span>
                        <span class="group-hover:text-emerald-300 transition-colors">+91 7907052160 (Primary WhatsApp)</span>
                    </a>

                    <!-- Phone / GPay -->
                    <div class="flex items-start space-x-2.5">
                        <span class="text-amber-400 font-bold">GPay:</span>
                        <span>094473 27450 / +91 9447327450</span>
                    </div>

                    <!-- Email 1 -->
                    <div class="flex items-start space-x-2.5">
                        <span class="text-amber-400 font-bold">Email:</span>
                        <span class="break-all">varmaji@covilakamastrology.com</span>
                    </div>

                    <!-- Email 2 -->
                    <div class="flex items-start space-x-2.5">
                        <span class="text-amber-400 font-bold">Alt:</span>
                        <span class="break-all">ekrvarma@gmail.com</span>
                    </div>

                    <!-- Website -->
                    <div class="flex items-start space-x-2.5">
                        <span class="text-amber-400 font-bold">Web:</span>
                        <span>www.covilakamastrology.com</span>
                    </div>
                </div>

                <!-- Google Pay Quick Badge -->
                <div class="mt-3 p-2.5 rounded-xl border border-amber-500/30 bg-[#1e132e] text-[11px] text-amber-200">
                    <p class="font-semibold text-amber-300 flex items-center space-x-1">
                        <span>💳 GPay Accepted: 094473 27450</span>
                    </p>
                    <p class="text-[10px] text-amber-300/70 mt-0.5">Online consultations delivered via WhatsApp, Voice Call, & PDF reports.</p>
                </div>
            </div>
        </div>

        <!-- Bottom Copyright -->
        <div class="mt-12 pt-6 border-t border-amber-500/20 flex flex-col sm:flex-row items-center justify-between text-[11px] text-amber-300/60 gap-4">
            <p>
                © {{ date('Y') }} <strong>Covilakam Astrology</strong>. All rights reserved. Directed by <strong>Dr. E. K. Raja Varma (Vidya Vachaspathi in Vedic Astrology)</strong>.
            </p>
            <div class="flex items-center space-x-4">
                <span>Explore. Discover. Transform.</span>
                <span>•</span>
                <span>IAF Fellow #11009</span>
                <span>•</span>
                @auth
                    <a href="{{ route('admin.dashboard') }}" class="text-amber-400 hover:text-amber-200 transition-colors inline-flex items-center space-x-1 font-semibold">
                        <span>⚙️ Admin Dashboard</span>
                    </a>
                @else
                    <a href="{{ route('admin.login') }}" class="text-amber-400/80 hover:text-amber-200 transition-colors inline-flex items-center space-x-1">
                        <span>🔒 Admin Login</span>
                    </a>
                @endauth
            </div>
        </div>
    </div>
</footer>

<div x-data="{ chatOpen: false, hasNotification: true }"
     class="fixed bottom-6 right-6 z-50 flex flex-col items-end select-none">

    <!-- WhatsApp Popup Bubble -->
    <div x-show="chatOpen"
         x-cloak
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0 translate-y-6 scale-95"
         x-transition:enter-end="opacity-100 translate-y-0 scale-100"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="opacity-100 translate-y-0 scale-100"
         x-transition:leave-end="opacity-0 translate-y-6 scale-95"
         @click.away="chatOpen = false"
         class="mb-3 w-80 sm:w-96 rounded-2xl shadow-2xl border border-amber-500/40 bg-[#160d24] text-white overflow-hidden">

        <!-- Popup Header -->
        <div class="bg-gradient-to-r from-[#2c0e18] via-[#4a0e17] to-[#1a1128] p-4 border-b border-amber-500/30 flex items-center justify-between">
            <div class="flex items-center space-x-3">
                <div class="relative">
                    <img src="{{ asset('storage/media/images/covilakam-4bcJQK.webp') }}"
                         alt="Dr. E. K. Raja Varma"
                         onerror="this.onerror=null; this.src='{{ asset('images/covilakam-hero.webp') }}';"
                         class="w-12 h-12 rounded-full object-cover border-2 border-amber-400 shadow-md">
                    <span class="absolute bottom-0 right-0 w-3.5 h-3.5 bg-emerald-500 border-2 border-[#160d24] rounded-full"></span>
                </div>
                <div>
                    <h4 class="font-cinzel text-sm font-bold text-amber-300">Dr. E. K. Raja Varma</h4>
                    <p class="text-[11px] text-amber-200/75 leading-tight">(Vidya Vachaspathi in Vedic Astrology)</p>
                    <span class="inline-block text-[10px] text-emerald-400 font-medium">● Available for Online Consultation</span>
                </div>
            </div>
            <button @click="chatOpen = false" class="text-amber-200/70 hover:text-white p-1 rounded-full hover:bg-white/10">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        </div>

        <!-- Chat Bubble Body -->
        <div class="p-4 bg-[#140b20] space-y-3">
            <div class="bg-[#1f1430] border border-amber-500/20 rounded-2xl rounded-tl-sm p-3.5 shadow-sm text-xs text-amber-50 leading-relaxed">
                <p class="font-semibold text-amber-300 mb-1 flex items-center space-x-1">
                    <span>Namaskaram! 🙏</span>
                </p>
                <p>
                    Connect with <strong>Dr. E. K. Raja Varma</strong> (Vidya Vachaspathi in Vedic Astrology) for Online Astro Counselling, Accurate Predictions, Jathakam analysis, or Marriage Match Reports.
                </p>
                <span class="block text-[10px] text-amber-400/60 text-right mt-1.5 font-mono">Official WhatsApp: +91 7907052160</span>
            </div>
        </div>

        <!-- Popup Footer CTA -->
        <div class="p-3 bg-[#11081a] border-t border-amber-500/20">
            <a href="https://wa.me/917907052160?text={{ rawurlencode('Namaskaram Dr. E. K. Raja Varma (Vidya Vachaspathi in Vedic Astrology), I would like to book an online astrological consultation with you.') }}"
               target="_blank"
               @click="chatOpen = false; hasNotification = false"
               class="w-full flex items-center justify-center space-x-2 py-3 px-4 rounded-xl text-xs sm:text-sm font-bold text-white bg-emerald-600 hover:bg-emerald-500 shadow-lg hover:shadow-emerald-600/30 transition-all duration-200">
                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M12.031 6.172c-3.181 0-5.767 2.586-5.768 5.766-.001 1.298.38 2.27 1.019 3.287l-.711 2.598 2.664-.698c.969.585 1.961.947 2.796.947 3.179 0 5.766-2.587 5.767-5.766.001-3.181-2.586-5.767-5.767-5.767zm0 10.373c-.768 0-1.637-.251-2.327-.661l-.167-.099-1.58.414.422-1.539-.109-.174c-.453-.722-.693-1.564-.693-2.55 0-2.539 2.066-4.605 4.606-4.605 2.54 0 4.606 2.066 4.606 4.606 0 2.54-2.066 4.608-4.755 4.608z"/>
                </svg>
                <span>Start WhatsApp Consultation</span>
            </a>
        </div>
    </div>

    <!-- Floating Circular Trigger Button -->
    <div class="relative">
        <!-- Notification Ping -->
        <span x-show="hasNotification && !chatOpen"
              class="absolute -top-1 -right-1 flex h-4 w-4 z-10">
            <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-amber-400 opacity-75"></span>
            <span class="relative inline-flex rounded-full h-4 w-4 bg-amber-500 border-2 border-[#1a1128]"></span>
        </span>

        <button @click="chatOpen = !chatOpen; hasNotification = false"
                class="group relative flex items-center justify-center w-14 h-14 sm:w-16 sm:h-16 rounded-full bg-gradient-to-tr from-emerald-600 via-emerald-500 to-teal-400 hover:from-emerald-500 hover:to-teal-300 text-white shadow-2xl hover:shadow-emerald-500/50 transition-all duration-300 transform hover:scale-105 focus:outline-none border-2 border-amber-300/80">
            <!-- Pulsing outer ring -->
            <div class="absolute -inset-1 rounded-full bg-emerald-500 opacity-30 group-hover:opacity-75 blur-sm transition-opacity"></div>
            
            <svg class="w-8 h-8 relative z-10 text-white" fill="currentColor" viewBox="0 0 24 24">
                <path d="M12.031 6.172c-3.181 0-5.767 2.586-5.768 5.766-.001 1.298.38 2.27 1.019 3.287l-.711 2.598 2.664-.698c.969.585 1.961.947 2.796.947 3.179 0 5.766-2.587 5.767-5.766.001-3.181-2.586-5.767-5.767-5.767zm0 10.373c-.768 0-1.637-.251-2.327-.661l-.167-.099-1.58.414.422-1.539-.109-.174c-.453-.722-.693-1.564-.693-2.55 0-2.539 2.066-4.605 4.606-4.605 2.54 0 4.606 2.066 4.606 4.606 0 2.54-2.066 4.608-4.755 4.608z"/>
            </svg>
        </button>
    </div>
</div>

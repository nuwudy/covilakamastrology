<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Print Visiting Card - DR. E. K. Raja Varma (Vidya Vachaspathi in Vedic Astrology)</title>

    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="{{ asset('favicon.ico') }}">
    <link rel="icon" type="image/png" sizes="48x48" href="{{ asset('favicon-48x48.png') }}">
    <link rel="shortcut icon" href="{{ asset('favicon.ico') }}">
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('apple-touch-icon.png') }}">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cinzel:wght@600;700;800;900&family=Playfair+Display:ital,wght@0,600;1,400&family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        @page {
            size: 90mm 55mm;
            margin: 0;
        }
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background-color: #11081a;
            color: #fdfbf7;
            display: flex;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
            margin: 0;
            padding: 20px;
        }
        .business-card {
            width: 90mm;
            height: 54mm;
            background: linear-gradient(135deg, #2b0e1b 0%, #150d22 55%, #350e1e 100%);
            border: 2px solid #d4af37;
            border-radius: 8px;
            padding: 5mm;
            box-sizing: border-box;
            position: relative;
            overflow: hidden;
            box-shadow: 0 10px 30px rgba(0,0,0,0.5);
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }
        @media print {
            body {
                background: transparent;
                padding: 0;
                min-height: auto;
            }
            .no-print {
                display: none !important;
            }
            .business-card {
                box-shadow: none;
                margin: auto;
                -webkit-print-color-adjust: exact;
                print-color-adjust: exact;
            }
        }
    </style>
</head>
<body>

    <div class="no-print fixed top-5 left-1/2 -translate-x-1/2 flex items-center space-x-3 bg-[#1e1330] p-2 px-4 rounded-xl border border-amber-500/40 shadow-xl z-50">
        <button onclick="window.print()" class="px-4 py-2 bg-amber-400 text-black font-bold rounded-lg text-xs hover:bg-amber-300">
            🖨️ Print Card
        </button>
        <button onclick="window.close()" class="px-4 py-2 bg-gray-700 text-white font-medium rounded-lg text-xs hover:bg-gray-600">
            Close
        </button>
    </div>

    <div class="business-card">
        <!-- Top Row -->
        <div class="flex items-center justify-between border-b border-amber-500/40 pb-1.5">
            <div class="flex items-center space-x-1.5">
                <span class="text-amber-400 font-bold text-xs font-serif">ॐ</span>
                <div>
                    <h1 class="font-cinzel text-[11px] font-bold text-amber-300 tracking-wider leading-none">
                        COVILAKAM ASTROLOGY
                    </h1>
                    <span class="text-[8px] text-amber-200/80 italic font-playfair">Explore. Discover. Transform.</span>
                </div>
            </div>
            <span class="text-[7.5px] font-bold text-amber-300 bg-amber-500/20 px-1.5 py-0.5 rounded border border-amber-400/40">
                IAF #11009
            </span>
        </div>

        <!-- Middle Profile Info -->
        <div class="flex items-center space-x-3 py-1">
            <img src="{{ asset('storage/media/images/covilakam-4bcJQK.webp') }}"
                 alt="DR. E. K. Raja Varma"
                 onerror="this.onerror=null; this.src='{{ asset('images/covilakam-hero.webp') }}';"
                 class="w-12 h-12 rounded-xl object-cover border border-amber-400 shrink-0">
            <div class="space-y-0.5">
                <h2 class="font-cinzel text-xs font-black text-amber-200 leading-none">
                    DR. E. K. Raja Varma
                </h2>
                <p class="font-cinzel text-[8.5px] font-bold text-amber-400 leading-tight">
                    (Vidya Vachaspathi in Vedic Astrology)
                </p>
                <p class="text-[7.5px] text-amber-100/90 leading-tight">
                    • Ph.D. in Vedic Astrology (Online Astro Counselling)
                </p>
                <p class="text-[7.5px] text-amber-100/90 leading-tight">
                    • Vidya Vachaspathi (Gold Medalist) | P. G. Diploma | Jothisha Bhooshanam
                </p>
            </div>
        </div>

        <!-- Bottom Contact Grid -->
        <div class="border-t border-amber-500/40 pt-1.5 grid grid-cols-2 gap-x-2 gap-y-0.5 text-[7.5px]">
            <div>
                <strong class="text-amber-400">WhatsApp:</strong> +91 7907052160
            </div>
            <div>
                <strong class="text-amber-400">GPay/Phone:</strong> 094473 27450
            </div>
            <div class="truncate">
                <strong class="text-amber-400">Email:</strong> varmaji@covilakamastrology.com
            </div>
            <div class="truncate">
                <strong class="text-amber-400">Web:</strong> www.covilakamastrology.com
            </div>
        </div>
    </div>

</body>
</html>

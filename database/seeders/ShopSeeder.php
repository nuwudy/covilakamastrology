<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Seeder;

class ShopSeeder extends Seeder
{
    public function run(): void
    {
        // Remove any old placeholder books
        Product::whereIn('slug', [
            'kerala-jyothisha-deepika',
            'vivaha-porutham-compatibility',
            'ratna-shastra-vedic-remedies'
        ])->delete();

        $products = [
            // 1. Book: Manoratham
            [
                'type' => 'book',
                'title' => 'മനോരഥം (Manoratham)',
                'title_ml' => 'മനോരഥം',
                'slug' => 'manoratham',
                'subtitle' => 'മനസ്സിന്റെ രഥം - സാഹിത്യ കൃതി',
                'description' => 'ഡോ. ഇ. കെ. രാജ വർമ്മയുടെ ആദ്യ സാഹിത്യ കൃതി. മനുഷ്യമനസ്സിന്റെ വികാരങ്ങളെയും ചിന്തകളെയും ആഴത്തിൽ അടയാളപ്പെടുത്തുന്ന രചന.',
                'price' => 100.00,
                'original_price' => 150.00,
                'image_path' => 'images/books/manoratham.jpg',
                'badge' => 'സാഹിത്യ കൃതി',
                'details' => [
                    'author' => 'ഡോ. ഇ. കെ. രാജ വർമ്മ (വിദ്യാ വാചസ്പതി)',
                    'language' => 'Malayalam',
                    'publisher' => 'JB Publications',
                    'delivery_time' => 'Courier Delivery across Kerala / Abroad',
                    'shipping_fee' => 'Speed Post Delivery Available',
                ],
                'is_active' => true,
                'sort_order' => 1,
            ],

            // 2. Book: Randamoozham
            [
                'type' => 'book',
                'title' => 'രണ്ടാമൂഴം (Randamoozham)',
                'title_ml' => 'രണ്ടാമൂഴം',
                'slug' => 'randamoozham',
                'subtitle' => 'ജീവിതാനുഭവങ്ങളുടെ രണ്ടാം ഭാവം',
                'description' => 'ജീവിതത്തിലെ വേറിട്ട കാഴ്ചപ്പാടുകളും അനുഭവങ്ങളും ലളിതമായ ശൈലിയിൽ അവതരിപ്പിക്കുന്ന ഡോ. ഇ. കെ. രാജ വർമ്മയുടെ രണ്ടാമത്തെ പുസ്തകം.',
                'price' => 120.00,
                'original_price' => 180.00,
                'image_path' => 'images/books/randamoozham.jpg',
                'badge' => 'ജീവിതാനുഭവങ്ങൾ',
                'details' => [
                    'author' => 'ഡോ. ഇ. കെ. രാജ വർമ്മ (വിദ്യാ വാചസ്പതി)',
                    'language' => 'Malayalam',
                    'publisher' => 'GB Publications',
                    'delivery_time' => 'Courier Delivery across Kerala / Abroad',
                ],
                'is_active' => true,
                'sort_order' => 2,
            ],

            // 3. Book: Thrimanam
            [
                'type' => 'book',
                'title' => 'ത്രിമാനം (Thrimanam)',
                'title_ml' => 'ത്രിമാനം',
                'slug' => 'thrimanam',
                'subtitle' => 'ജീവിതത്തിന്റെ മൂന്ന് മാനങ്ങൾ',
                'description' => 'മനുഷ്യജീവിതത്തിന്റെയും ദർശനങ്ങളുടെയും മൂന്ന് വ്യത്യസ്ത തലങ്ങളെ ആസ്പദമാക്കി രചിച്ച മൂന്നാമത്തെ കൃതി.',
                'price' => 120.00,
                'original_price' => 180.00,
                'image_path' => 'images/books/thrimanam.jpg',
                'badge' => 'ദാർശനിക രചന',
                'details' => [
                    'author' => 'ഡോ. ഇ. കെ. രാജ വർമ്മ (വിദ്യാ വാചസ്പതി)',
                    'language' => 'Malayalam',
                    'publisher' => 'Covilakam Publications',
                    'delivery_time' => 'Courier Delivery across Kerala / Abroad',
                ],
                'is_active' => true,
                'sort_order' => 3,
            ],

            // 4. Book: Chathurangam
            [
                'type' => 'book',
                'title' => 'ചതുരംഗം (Chathurangam)',
                'title_ml' => 'ചതുരംഗം',
                'slug' => 'chathurangam',
                'subtitle' => 'ജീവിതമാകുന്ന ചതുരംഗക്കളം',
                'description' => 'ചതുരംഗക്കളത്തിലെ കരുനീക്കങ്ങൾ പോലെ ജീവിതത്തിലെ സാഹചര്യങ്ങളെയും വെല്ലുവിളികളെയും അടയാളപ്പെടുത്തുന്ന നാലാമത്തെ പുസ്തകം.',
                'price' => 150.00,
                'original_price' => 200.00,
                'image_path' => 'images/books/chathurangam.jpg',
                'badge' => 'ജീവിതവീക്ഷണം',
                'details' => [
                    'author' => 'ഡോ. ഇ. കെ. രാജ വർമ്മ (വിദ്യാ വാചസ്പതി)',
                    'language' => 'Malayalam',
                    'publisher' => 'Watermelon Publications',
                    'delivery_time' => 'Courier Delivery across Kerala / Abroad',
                ],
                'is_active' => true,
                'sort_order' => 4,
            ],

            // 5. Book: Panchamrutham
            [
                'type' => 'book',
                'title' => 'പഞ്ചാമൃതം (Panchamrutham)',
                'title_ml' => 'പഞ്ചാമൃതം',
                'slug' => 'panchamrutham',
                'subtitle' => 'ജീവിതയാത്രയിൽ വഴികാട്ടിയാകാവുന്ന 101 ചിന്താശകലങ്ങളുടെ സമാഹാരം',
                'description' => 'മനുഷ്യന്റെ ദൈനംദിന ജീവിതയാത്രയിൽ ആത്മവിശ്വാസവും വെളിച്ചവും പകരുന്ന 101 മഹത്തായ ചിന്താശകലങ്ങളുടെ സമാഹാരം.',
                'price' => 150.00,
                'original_price' => 200.00,
                'image_path' => 'images/books/panchamrutham.jpg',
                'badge' => '101 ചിന്താശകലങ്ങൾ',
                'details' => [
                    'author' => 'ഡോ. ഇ. കെ. രാജ വർമ്മ (വിദ്യാ വാചസ്പതി)',
                    'language' => 'Malayalam',
                    'publisher' => 'സ്നേഹഭൂമി പബ്ലിക്കേഷൻസ്',
                    'delivery_time' => 'Courier Delivery across Kerala / Abroad',
                ],
                'is_active' => true,
                'sort_order' => 5,
            ],

            // 6. Book: Shashtangam
            [
                'type' => 'book',
                'title' => 'ഷഷ്ടാംഗം (Shashtangam)',
                'title_ml' => 'ഷഷ്ടാംഗം',
                'slug' => 'shashtangam',
                'subtitle' => '15 ചെറുകഥകളുടെ സമാഹാരം (Interactive Digital Flipbook)',
                'description' => 'ഡോ. ഇ. കെ. രാജ വർമ്മ രചിച്ച 15 മനോഹരമായ മലയാള ചെറുകഥകളുടെ സമാഹാരം. ഓൺലൈനായി പേജുകൾ മറിച്ചു വായിക്കാനുള്ള ഡിജിറ്റൽ പതിപ്പും ലഭ്യമാണ്.',
                'price' => 150.00,
                'original_price' => 200.00,
                'image_path' => 'images/books/shashtangam.jpg',
                'badge' => '15 ചെറുകഥകൾ',
                'details' => [
                    'author' => 'ഡോ. ഇ. കെ. രാജ വർമ്മ (വിദ്യാ വാചസ്പതി)',
                    'language' => 'Malayalam',
                    'publisher' => 'Covilakam Digital Edition',
                    'delivery_time' => 'Instant Digital Flipbook + Hardcover Courier',
                ],
                'is_active' => true,
                'sort_order' => 6,
            ],

            // 7. Work: Rajageetham Audio CD
            [
                'type' => 'book',
                'title' => 'രാജഗീതം (Rajageetham - Audio CD)',
                'title_ml' => 'രാജഗീതം',
                'slug' => 'rajageetham',
                'subtitle' => 'സംഗീത ആൽബം & സർഗ്ഗാത്മക സൃഷ്ടികൾ',
                'description' => 'ഡോ. ഇ. കെ. രാജ വർമ്മയുടെ സർഗ്ഗാത്മക സംഗീത-സാഹിത്യ സൃഷ്ടികളുടെ ഓഡിയോ ശേഖരം.',
                'price' => 100.00,
                'original_price' => 150.00,
                'image_path' => 'images/books/rajageetham.jpg',
                'badge' => 'സംഗീത ആൽബം',
                'details' => [
                    'author' => 'ഡോ. ഇ. കെ. രാജ വർമ്മ (വിദ്യാ വാചസ്പതി)',
                    'publisher' => 'Covilakam Creations',
                    'format' => 'Audio CD / Digital Audio Tracks',
                ],
                'is_active' => true,
                'sort_order' => 7,
            ],

            // 8. Digital Download: Elaborate Vedic DOB Astrological Profile PDF Report (₹100)
            [
                'type' => 'digital_pdf',
                'title' => 'Elaborate Vedic DOB Astrological Profile (PDF Report)',
                'title_ml' => 'വിശദമായ വേദിക് ജനനതീയതി ജ്യോതിഷ റിപ്പോർട്ട് (PDF)',
                'slug' => 'vedic-dob-profile-pdf-report',
                'subtitle' => 'Comprehensive Multi-Page Downloadable Vedic DOB Reading with Planetary Remedies',
                'description' => 'Complete, certified multi-page Vedic numerology and astrological life profile report based on your Date of Birth. Includes 4 Life Pillars (Career & Wealth, Love & Family Harmony, Health & Longevity, Spiritual Remedies & Mantras), lucky gemstones, auspicious colors, and year-ahead planetary cycle forecast certified under the supervision of DR. E. K. Raja Varma.',
                'price' => 100.00,
                'original_price' => 250.00,
                'image_path' => 'images/shop/jathakam-pdf-report-mockup-opt.jpg',
                'badge' => 'Instant Digital PDF Download (₹100)',
                'details' => [
                    'format' => 'Printable High-Resolution PDF (Certified by Dr. Raja Varma)',
                    'delivery_mode' => 'Instant Download after Payment',
                    'languages_available' => 'Malayalam / English / Tamil / Hindi',
                    'verification' => 'Certified under supervision of DR. E. K. Raja Varma',
                    'key_inclusions' => [
                        'Mulank (Birth Number) & Bhagyank (Destiny Number) Deep Analysis',
                        '4 Life Pillars (Career, Love, Health, Remedies)',
                        'Prescribed Gemstone, Wearing Rules, Lucky Days & Auspicious Colors',
                        'Deva Mantras with Sanskrit transliteration',
                        'Year Ahead Planetary Cycle Forecast'
                    ]
                ],
                'is_active' => true,
                'sort_order' => 8,
            ],

            // 9. Digital Download: Complete Deluxe Vedic Kundali & Deep Jathakam PDF Report (₹500)
            [
                'type' => 'digital_pdf',
                'title' => 'Deluxe Vedic Jathakam & Deep Kundali (PDF Report)',
                'title_ml' => 'സമ്പൂർണ്ണ ഡീലക്സ് വേദിക് ജാതകം & കുണ്ഡലി (PDF)',
                'slug' => 'deluxe-vedic-jathakam-pdf-report',
                'subtitle' => 'Comprehensive 30+ Page Personalized Kundali, Lagna, Rasi, Bhavas, Dasa-Bhukthi & Life Predictions',
                'description' => 'Receive an exquisite 30+ page personalized Vedic Horoscope Report prepared with mathematical precision by Covilakam Astrology under the guidance of DR. E. K. Raja Varma. Incorporating optional Time and Place of Birth, it includes full Lagna (Ascendant), Chandra Rasi, Janma Nakshatra, Rasi & Navamsha charts, 12 Bhavas (Astrological Houses) deep career & marriage analysis, 25-year Vimshottari Dasa-Bhukthi timeline, Sade Sati & dosha check, and tailored Vedic remedial recommendations.',
                'price' => 500.00,
                'original_price' => 1200.00,
                'image_path' => 'images/shop/jathakam-pdf-report-mockup-opt.jpg',
                'badge' => 'Instant Deluxe PDF + Priority Consultation Access (₹500)',
                'details' => [
                    'format' => 'High-Resolution Printable PDF (Color, 30+ Pages)',
                    'delivery_mode' => 'Instant Download + Sent Directly to Customer WhatsApp & Email',
                    'delivery_time' => 'Instant Generation upon Razorpay Payment',
                    'languages_available' => 'Malayalam / English',
                    'verification' => 'Reviewed under supervision of DR. E. K. Raja Varma',
                    'key_inclusions' => [
                        'Lagna (Ascendant Sign), Chandra Rasi & Janma Nakshatra',
                        'Precise Rasi, Navamsha & 12 Bhava (Houses) Planetary Charts',
                        'Full 12 Houses (Bhavas) In-Depth Career, Health & Marriage Analysis',
                        'Detailed 25-Year Vimshottari Dasa & Bhukthi Timeline with dates',
                        'Shani Gochara (Sade Sati / Ezharara Shani) Detailed Analysis',
                        'Lucky Gemstone, Auspicious Day, Favorable Colors & Deva Mantras',
                        'Priority WhatsApp Direct Access with Dr. Raja Varma'
                    ]
                ],
                'is_active' => true,
                'sort_order' => 9,
            ],

            // 10. Service: Personal Astrological Consultation with DR. E. K. Raja Varma
            [
                'type' => 'consultation',
                'title' => 'Personal Astro Consultation with DR. E. K. Raja Varma',
                'title_ml' => 'വ്യക്തിഗത ജ്യോതിഷ കൗൺസിലിംഗ്',
                'slug' => 'personal-consultation-dr-ek-raja-varma',
                'subtitle' => '30-Minute One-on-One Voice / WhatsApp Consultation with the Astrologer',
                'description' => 'A direct, private, and deeply insightful one-on-one consultation with DR. E. K. Raja Varma (Vidya Vachaspathi in Vedic Astrology, 2026 Gold Medalist & Ph.D.). Discuss your birth chart, career decisions, matrimonial matters, health, financial transitions, or personal challenges, and receive actionable Vedic guidance combined with empathetic modern counselling.',
                'price' => 999.00,
                'original_price' => 1500.00,
                'image_path' => 'images/og-covilakam-512x512.png',
                'badge' => 'Direct Astrologer Session',
                'details' => [
                    'mode' => 'Direct Phone Call / WhatsApp Audio & Video Consultation',
                    'duration' => '30 Minutes Dedicated One-on-One Session',
                    'languages' => 'Malayalam, English, Hindi, Tamil',
                    'scheduling' => 'Slot confirmed within 24 hours of booking',
                    'follow_up' => 'Includes 7 days WhatsApp follow-up clarification',
                    'key_inclusions' => [
                        'Full Birth Chart Review prior to the call',
                        'Direct answers to your 3 most critical life questions',
                        'Guidance on Career, Marriage, Business or Relocation',
                        'Accurate timings for major upcoming decisions',
                        'Prescribed Vedic Pariharams & auspicious gem recommendations'
                    ]
                ],
                'is_active' => true,
                'sort_order' => 10,
            ],

            // 11. Service: Matrimonial Porutham 10-Point Analysis
            [
                'type' => 'consultation',
                'title' => 'Matrimonial Porutham (10-Point Compatibility Analysis)',
                'title_ml' => 'വിവാഹ പൊരുത്ത പരിശോധന റിപ്പോർട്ട്',
                'slug' => 'matrimonial-porutham-compatibility-service',
                'subtitle' => 'Detailed Horoscope Matching for Bride and Groom with Written Verdict',
                'description' => 'Complete traditional Kerala matrimonial horoscope matching (10 Poruthams, Chovva Dosham, Papa Samyam balance, and Dasa Sandhi examination). You will receive an official written matching report certified by DR. E. K. Raja Varma delivered directly to your WhatsApp.',
                'price' => 499.00,
                'original_price' => 800.00,
                'image_path' => 'images/shop/book-vedic-marriage-porutham-opt.jpg',
                'badge' => 'Certified Match Report',
                'details' => [
                    'format' => 'Official Certified Match Report PDF + WhatsApp Summary',
                    'delivery_time' => 'Delivered within 24 Hours to your WhatsApp',
                    'languages' => 'Malayalam or English',
                    'key_inclusions' => [
                        '10 Classical Poruthams Detailed Score (Dina, Gana, Mahendra, etc.)',
                        'Kuja Dosham (Mars Affliction) In-Depth Evaluation for both charts',
                        'Papa Samyam (Malefic Score) Balance Check',
                        'Dasa Sandhi Conflict Analysis',
                        'Clear Final Recommendation & Remedial Measures'
                    ]
                ],
                'is_active' => true,
                'sort_order' => 11,
            ],
        ];

        foreach ($products as $p) {
            Product::updateOrCreate(['slug' => $p['slug']], $p);
        }
    }
}

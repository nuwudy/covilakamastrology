<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Seeder;

class ShopSeeder extends Seeder
{
    public function run(): void
    {
        $products = [
            // 1. Book: Kerala Jyothisha Deepika
            [
                'type' => 'book',
                'title' => 'Kerala Jyothisha Deepika',
                'title_ml' => 'കേരള ജ്യോതിഷ ദീപിക',
                'slug' => 'kerala-jyothisha-deepika',
                'subtitle' => 'The Master Compendium of Kerala Vedic Astrology & Horoscope Science',
                'description' => 'Authored by DR. E. K. Raja Varma (Vidya Vachaspathi in Vedic Astrology, Gold Medalist & Ph.D.), this authoritative volume provides an extensive, practical treatise on classical Kerala Parashara astrology, Ashtamangala Prasnam calculations, Gochara transits, and planetary house interpretations. Written with authentic Sanskrit shlokas, English annotations, and Malayalam explanations for serious astrology practitioners, students, and enthusiasts.',
                'price' => 499.00,
                'original_price' => 799.00,
                'image_path' => 'images/shop/book-kerala-jyothisha-deepika-opt.jpg',
                'badge' => 'Bestseller ★★★★★',
                'details' => [
                    'author' => 'DR. E. K. Raja Varma (Vidya Vachaspathi in Vedic Astrology)',
                    'language' => 'Malayalam & English',
                    'binding' => 'Deluxe Royal Hardcover with Gold Foil Embossing',
                    'pages' => 384,
                    'publisher' => 'Covilakam Vedic Publications (Est. 1954)',
                    'edition' => '2026 Gold Medalist Deluxe Edition',
                    'isbn' => '978-81-948210-1-4',
                    'delivery_time' => '3 - 6 Business Days via India Post Speed Post',
                    'shipping_fee' => 'Free Delivery Across India',
                    'key_topics' => [
                        'Ashtamangala Prasnam Calculation Principles',
                        'Bhavadhipathi (House Lords) & Planetary Aspect Analysis',
                        'Dasa-Bhukthi Deep Predictive Cycles',
                        'Authentic Kerala Remedial Poojas & Temple Rituals',
                        'Real Case Studies of Kerala Horoscopes'
                    ]
                ],
                'is_active' => true,
                'sort_order' => 1,
            ],

            // 2. Book: Vivaha Porutham
            [
                'type' => 'book',
                'title' => 'Vivaha Porutham & Compatibility',
                'title_ml' => 'വിവാഹ പൊരുത്ത രഹസ്യങ്ങൾ',
                'slug' => 'vivaha-porutham-compatibility',
                'subtitle' => 'Comprehensive Guide to Vedic Marriage Compatibility & Dosha Pariharam',
                'description' => 'A definitive masterwork on Vedic matrimonial matching (Porutham) by DR. E. K. Raja Varma. Covering all 10 classical Poruthams (Dina, Gana, Mahendra, Sthree Deergha, Yoni, Rasi, Rasyadhipathi, Vasyam, Rajju, and Vedha), subtle Kuja Dosha (Chovva Dosham) evaluations, Papa Samyam balance, and Dasa Sandhi calculations. Includes practical solutions to overcome horoscope incompatibilities.',
                'price' => 399.00,
                'original_price' => 599.00,
                'image_path' => 'images/shop/book-vedic-marriage-porutham-opt.jpg',
                'badge' => 'Essential Matrimonial Guide',
                'details' => [
                    'author' => 'DR. E. K. Raja Varma (Vidya Vachaspathi in Vedic Astrology)',
                    'language' => 'Malayalam & English',
                    'binding' => 'Premium Collector Edition Hardcover',
                    'pages' => 280,
                    'publisher' => 'Covilakam Vedic Publications',
                    'edition' => 'Revised 4th Edition',
                    'isbn' => '978-81-948210-2-1',
                    'delivery_time' => '3 - 6 Business Days via India Post Speed Post',
                    'shipping_fee' => 'Free Delivery Across India',
                    'key_topics' => [
                        'Complete 10-Porutham Classical Rules & Exceptions',
                        'Kuja Dosham (Mars Affliction) Myth vs Reality',
                        'Papa Samyam (Malefic Score) Scientific Computation',
                        'Dasa Sandhi Timing & Vulnerable Life Periods',
                        'Vedic Remedies for Marital Harmony & Delay in Marriage'
                    ]
                ],
                'is_active' => true,
                'sort_order' => 2,
            ],

            // 3. Book: Ratna Shastra & Remedies
            [
                'type' => 'book',
                'title' => 'Ratna Shastra & Vedic Remedies',
                'title_ml' => 'രത്നശാസ്ത്രവും ഗ്രഹദോഷങ്ങളും',
                'slug' => 'ratna-shastra-vedic-remedies',
                'subtitle' => 'Planetary Gemology, Graha Shanti Mantras & Effective Vedic Remedies',
                'description' => 'An illuminating handbook guiding seekers and astrologers on prescribing authentic astrological gemstones (Navaratna) for health, career prosperity, marital bliss, and planetary afflictions. Authored by DR. E. K. Raja Varma, with detailed instructions on gem identification, carat weight, metal setting, auspicious wearing muhurthams, and sanctifying Vedic mantras.',
                'price' => 450.00,
                'original_price' => 650.00,
                'image_path' => 'images/shop/book-ratna-shastra-remedies-opt.jpg',
                'badge' => 'Practical Gemology',
                'details' => [
                    'author' => 'DR. E. K. Raja Varma (Vidya Vachaspathi in Vedic Astrology)',
                    'language' => 'Malayalam & English',
                    'binding' => 'Fine Navy Linen Hardbound with Embossed Gilded Crest',
                    'pages' => 312,
                    'publisher' => 'Covilakam Vedic Publications',
                    'edition' => 'Expanded Illustrated Edition',
                    'isbn' => '978-81-948210-3-8',
                    'delivery_time' => '3 - 6 Business Days via India Post Speed Post',
                    'shipping_fee' => 'Free Delivery Across India',
                    'key_topics' => [
                        'Navaratna Properties & Planetary Associations',
                        'How to Avoid Flawed or Unlucky Gemstones',
                        'Ascendant (Lagna) Based Lucky Stone Calculations',
                        'Sanctification Mantras & Metal Alloys (Panchaloha / Gold)',
                        'Simple Temple Pariharams & Daily Astro Rituals'
                    ]
                ],
                'is_active' => true,
                'sort_order' => 3,
            ],

            // 4. Digital Download: Deluxe Vedic Jathakam PDF Report
            [
                'type' => 'digital_pdf',
                'title' => 'Complete Deluxe Vedic Jathakam (PDF Report)',
                'title_ml' => 'സമ്പൂർണ്ണ ഡിജിറ്റൽ ജാതകം (PDF)',
                'slug' => 'deluxe-vedic-jathakam-pdf-report',
                'subtitle' => 'Comprehensive 30+ Page Personalized Kundali, Dasa-Bhukthi & Life Predictions',
                'description' => 'Receive an exquisite 30+ page personalized Vedic Horoscope Report prepared with mathematical precision by Covilakam Astrology under the guidance of DR. E. K. Raja Varma. Includes full Rasi & Navamsha charts, Bhava Sphutam, planet dignities, Ashtakavarga, next 25-year Vimshottari Dasa-Bhukthi timeline, Sade Sati & Kandaka Shani analysis, and tailored Vedic remedial recommendations.',
                'price' => 299.00,
                'original_price' => 999.00,
                'image_path' => 'images/shop/jathakam-pdf-report-mockup-opt.jpg',
                'badge' => 'Instant Digital PDF + WhatsApp Delivery',
                'details' => [
                    'format' => 'High-Resolution Printable PDF (Color, 30+ Pages)',
                    'delivery_mode' => 'Instant Download + Sent Directly to Customer WhatsApp & Email',
                    'delivery_time' => 'Instant Generation upon Razorpay Payment',
                    'languages_available' => 'Malayalam / English',
                    'verification' => 'Reviewed under supervision of DR. E. K. Raja Varma',
                    'key_inclusions' => [
                        'Precise Rasi, Navamsha & Bhava Planetary Charts',
                        'Full 12 Houses (Bhavas) In-Depth Career, Health & Marriage Analysis',
                        'Detailed 25-Year Vimshottari Dasa & Bhukthi Timeline with dates',
                        'Shani Gochara (Sade Sati / Ezharara Shani) Detailed Analysis',
                        'Lucky Gemstone, Auspicious Day, Favorable Colors & Deva Mantras'
                    ]
                ],
                'is_active' => true,
                'sort_order' => 4,
            ],

            // 5. Service: Personal Astrological Consultation with DR. E. K. Raja Varma
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
                'sort_order' => 5,
            ],

            // 6. Service: Matrimonial Porutham 10-Point Analysis
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
                'sort_order' => 6,
            ],
        ];

        foreach ($products as $p) {
            Product::updateOrCreate(['slug' => $p['slug']], $p);
        }
    }
}

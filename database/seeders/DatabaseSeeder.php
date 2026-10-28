<?php

namespace Database\Seeders;

use App\Models\AstrologyTranslation;
use App\Models\Consultation;
use App\Models\Post;
use App\Models\Qualification;
use App\Models\Service;
use App\Models\Setting;
use App\Models\Video;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 0. Administrator Accounts
        \App\Models\User::updateOrCreate(
            ['email' => 'varmaji@covilakamastrology.com'],
            [
                'name' => 'Dr. E. K. Raja Varma (Vidya Vachaspathi in Vedic Astrology)',
                'password' => \Illuminate\Support\Facades\Hash::make('Covilakam@2026'),
                'email_verified_at' => now(),
            ]
        );

        \App\Models\User::updateOrCreate(
            ['email' => 'admin@covilakamastrology.com'],
            [
                'name' => 'Dr. E. K. Raja Varma (Administrator)',
                'password' => \Illuminate\Support\Facades\Hash::make('Covilakam@2026'),
                'email_verified_at' => now(),
            ]
        );

        \App\Models\User::updateOrCreate(
            ['email' => 'admin@covilakamastrology@gmail.com'],
            [
                'name' => 'Dr. E. K. Raja Varma (Administrator)',
                'password' => \Illuminate\Support\Facades\Hash::make('Varmaji2160#'),
                'email_verified_at' => now(),
            ]
        );

        // 1. Settings Table
        $settings = [
            'astrologer_name' => 'Dr. E. K. Raja Varma',
            'astrologer_subtitle' => '(Vidya Vachaspathi in Vedic Astrology)',
            'brand_name' => 'Covilakam Astrology',
            'tagline' => 'Explore. Discover. Transform.',
            'whatsapp_number' => '+91 7907052160',
            'whatsapp_raw' => '917907052160',
            'phone_primary' => '094473 27450',
            'phone_raw' => '+919447327450',
            'gpay_number' => '094473 27450',
            'email_primary' => 'varmaji@covilakamastrology.com',
            'email_secondary' => 'ekrvarma@gmail.com',
            'website' => 'www.covilakamastrology.com',
            'iaf_member_id' => '11009',
            'experience_year' => '2022',
            'convocation_date' => '27th September 2026',
            'profile_photo' => 'images/dr-ek-raja-varma.jpg',
            'about_bio' => 'Dr. E. K. Raja Varma (Vidya Vachaspathi in Vedic Astrology) is an internationally acknowledged Vedic Astrologer, researcher, and astro-counsellor. Awarded the coveted Gold Medal at the prestigious Shree Maharshi College of Vedic Astrology Convocation and conferred a Ph.D. in Vedic Astrology (Specialising in Online Astro Counselling) by IAMA Open University, Florida, he blends ancient Rishi-tradition precision with compassionate, practical life-guidance.',
        ];

        foreach ($settings as $key => $value) {
            Setting::updateOrCreate(['key' => $key], ['value' => $value, 'group' => 'general']);
        }

        // 2. Qualifications Table
        $qualifications = [
            [
                'title' => 'Ph.D. (Doctorate of Philosophy) in Vedic Astrology',
                'institution' => 'Indian Astrology and Maharshi Academics (IAMA) Open University, Florida',
                'year' => '2026',
                'highlights' => 'Doctoral dissertation and specialised research in Online Astro Counselling and psychological Vedic synthesis.',
                'badge_text' => 'Ph.D. Doctorate',
                'sort_order' => 1,
            ],
            [
                'title' => 'Vidya Vachaspathi in Vedic Astrology (Gold Medalist)',
                'institution' => 'Shree Maharshi College of Vedic Astrology, Udaipur, Rajasthan',
                'year' => 'Convocation: 27th September 2026',
                'highlights' => 'Honoured with the Gold Medal for outstanding merit and mastery in Classical Parashara and Jaimini Vedic Astrology.',
                'badge_text' => 'Gold Medalist 2026',
                'sort_order' => 2,
            ],
            [
                'title' => 'P. G. Diploma in Vedic Astrology',
                'institution' => 'Premier Vedic Academy of Astrology & Sciences',
                'year' => 'Post Graduate Degree',
                'highlights' => 'Advanced studies in predictive Horary (Prashna), planetary transits (Gochara), and Dasha-Bhukti synthesis.',
                'badge_text' => 'Post Graduate Diploma',
                'sort_order' => 3,
            ],
            [
                'title' => 'Jothisha Bhooshanam',
                'institution' => 'Traditional Astrological Heritage Sansthan',
                'year' => 'Traditional Title',
                'highlights' => 'Kerala tradition astrological proficiency including Ashtamangala Prashna principles and Muhurtha Shastra.',
                'badge_text' => 'Jothisha Bhooshanam',
                'sort_order' => 4,
            ],
            [
                'title' => 'Life Member (ID: 11009)',
                'institution' => 'International Vedic Astrology Federation (IVAF)',
                'year' => 'Active Life Fellow',
                'highlights' => 'Global professional accreditation ensuring high ethical standards, client confidentiality, and continuous academic exchange.',
                'badge_text' => 'IVAF Member #11009',
                'sort_order' => 5,
            ],
            [
                'title' => 'Professional Astro Consultations Since 2022',
                'institution' => 'Covilakam Astrology Global Online Portal',
                'year' => 'Since 2022',
                'highlights' => 'Successfully guided thousands of seekers worldwide in career, relationships, business, health, and spiritual alignment.',
                'badge_text' => 'Active Practitioner',
                'sort_order' => 6,
            ],
        ];

        Qualification::truncate();
        foreach ($qualifications as $item) {
            Qualification::create($item);
        }

        // 3. Services Table
        $services = [
            [
                'title' => 'Accurate Predictions',
                'slug' => 'accurate-predictions',
                'description' => 'Pinpoint analysis of planetary Dasha cycles, planetary transits, and karmic life milestones. Clear, precise guidance for career, health, finances, and important turning points.',
                'icon' => 'sparkles',
                'whatsapp_prefill' => 'Namaskaram Dr. E. K. Raja Varma (Vidya Vachaspathi in Vedic Astrology), I would like to book an Accurate Prediction reading for my horoscope.',
                'sort_order' => 1,
            ],
            [
                'title' => 'Jathakam Reports',
                'slug' => 'jathakam-reports',
                'description' => 'Comprehensive Vedic horoscope calculation and exhaustive written/audio analysis covering Lagna, Rasi, Navamsha, Dasha-Bhukti timelines, and individualized Vedic remedial measures.',
                'icon' => 'scroll',
                'whatsapp_prefill' => 'Namaskaram Dr. E. K. Raja Varma (Vidya Vachaspathi in Vedic Astrology), I need a comprehensive Jathakam Report and analysis.',
                'sort_order' => 2,
            ],
            [
                'title' => 'Marriage Match Reports',
                'slug' => 'marriage-match-reports',
                'description' => 'In-depth marital harmony assessment using the 10 Poruthams, Papasamya (balancing of afflictions), Kuja Dosha (Manglik) analysis, and Dasha compatibility for lifelong happiness.',
                'icon' => 'heart',
                'whatsapp_prefill' => 'Namaskaram Dr. E. K. Raja Varma (Vidya Vachaspathi in Vedic Astrology), I would like to check a Marriage Horoscope Matching (Porutham) report.',
                'sort_order' => 3,
            ],
            [
                'title' => 'Gem Prediction Reports',
                'slug' => 'gem-prediction-reports',
                'description' => 'Scientific gemstone recommendation aligned with your beneficial Yogakaraka planets. Prevents harmful stone wear and enhances planetary vitality, prosperity, and mental clarity.',
                'icon' => 'gem',
                'whatsapp_prefill' => 'Namaskaram Dr. E. K. Raja Varma (Vidya Vachaspathi in Vedic Astrology), I would like to receive a scientific Gemstone Prediction Report.',
                'sort_order' => 4,
            ],
            [
                'title' => 'Muhoorthams',
                'slug' => 'muhoorthams',
                'description' => 'Auspicious timing calculations for Weddings, House Warming (Grihapravesham), Business Inaugurations, Child Naming (Namakaranam), and Upanayanam according to Shastras.',
                'icon' => 'clock',
                'whatsapp_prefill' => 'Namaskaram Dr. E. K. Raja Varma (Vidya Vachaspathi in Vedic Astrology), I need auspicious Muhoortham dates for an upcoming ceremony.',
                'sort_order' => 5,
            ],
        ];

        Service::truncate();
        foreach ($services as $service) {
            Service::create($service);
        }

        // 4. Videos Table
        $this->call(VideoSeeder::class);

        // 5. Astrology Translations Table (4 Languages: ml, en, hi, ta)
        $translations = [
            [
                'language_code' => 'ml',
                'language_name' => 'മലയാളം (Malayalam)',
                'heading' => 'ജ്യോതിഷം: പ്രപഞ്ച സത്യവും ജീവിത മാർഗ്ഗദർശനവും',
                'subheading' => 'Explore. Discover. Transform. - കോവിലകം അസ്ട്രോളജി',
                'content' => "<p class='mb-4 font-semibold text-amber-200'>നമസ്കാരം, പ്രപഞ്ചത്തിലെ സർവ്വ ചരാചരങ്ങളും അദൃശ്യമായ ഗ്രഹതരംഗങ്ങളാൽ പരസ്പരം ബന്ധിക്കപ്പെട്ടിരിക്കുന്നു. വൈദിക മഹർഷിമാർ ആയിരക്കണക്കിന് വർഷങ്ങളിലൂടെ തപസ്സനുഷ്ഠിച്ചു ദർശിച്ച ജ്യോതിഷ ശാസ്ത്രം എന്നത് അന്ധവിശ്വാസമല്ല, മറിച്ച് മനുഷ്യ മനസ്സിനെയും കാലത്തിന്റെ ഗതിയെയും സമന്വയിപ്പിക്കുന്ന ഉന്നതമായ പ്രപഞ്ച ശാസ്ത്രമാണ്.</p>
                <p class='mb-4'>ഡോ. ഇ. കെ. രാജ വർമ്മ (വിദ്യാ വാചസ്പതി ഇൻ വേദിക് അസ്ട്രോളജി) നേതൃത്വം നൽകുന്ന കോവിലകം അസ്ട്രോളജിയുടെ ലക്ഷ്യം വെറുമൊരു ഭാവിക്കാല പ്രവചനമല്ല; മറിച്ച് നിങ്ങളുടെ പൂർവ്വകർമ്മ വാസനകളെയും ഗ്രഹസ്ഥിതികളെയും തിരിച്ചറിഞ്ഞ്, ജീവിതത്തിലെ പ്രതിസന്ധികളെ മറികടക്കാനുള്ള ആത്മീയവും പ്രായോഗികവുമായ ഉൾക്കാഴ്ച നൽകലാണ്.</p>
                <p class='mb-4'>നമ്മുടെ ജീവിതത്തിൽ അനുഭവപ്പെടുന്ന സുഖദുഃഖങ്ങൾ കർമ്മഫലങ്ങളാൽ മുൻകൂട്ടി നിശ്ചയിക്കപ്പെട്ടതാണെങ്കിലും, യഥാവിധി ഉള്ള ഈശ്വരാരാധന, സദ്ചിന്ത, അനുയോജ്യമായ രത്നധാരണം, ശരിയായ കർമ്മമാർഗ്ഗം എന്നിവയിലൂടെ ദുരിതങ്ങളുടെ തീവ്രത കുറയ്ക്കാനും ഭാഗ്യത്തെ ഉത്തേജിപ്പിക്കാനും സാധിക്കും. ലോകത്തെവിടെയിരുന്നും നിങ്ങൾക്ക് ഓൺലൈൻ വഴി ആധികാരിക ജ്യോതിഷ കൗൺസിലിംഗ് ലഭിക്കാൻ കോവിലകം അസ്ട്രോളജി സദാ സന്നദ്ധമാണ്.</p>",
                'sort_order' => 1,
            ],
            [
                'language_code' => 'en',
                'language_name' => 'English',
                'heading' => 'Vedic Astrology: The Eternal Cosmic Beacon of Self-Discovery',
                'subheading' => 'Explore. Discover. Transform. - Covilakam Astrology',
                'content' => "<p class='mb-4 font-semibold text-amber-200'>Vedic Astrology (Jyotisha) is not fatalism; it is the sacred light of cosmic consciousness bestowed by ancient Indian sages to illuminate humanity's karmic journey through space and time.</p>
                <p class='mb-4'>At Covilakam Astrology, Dr. E. K. Raja Varma (Vidya Vachaspathi in Vedic Astrology) applies profound academic mastery and traditional insights to decode the intricate planetary patterns imprinted upon your moment of birth. By evaluating the Dasha cycles, planetary placements, and transit vibrations, we unveil the latent potentials, opportunities, and challenges awaiting you.</p>
                <p class='mb-4'>True astrological wisdom empowers decision-making in career evolution, marital compatibility, financial stability, and spiritual awakening. Through ethical online astro-counselling, scientific gemstone recommendations, and authentic Vedic remedies, Covilakam Astrology invites you to Explore your celestial blueprint, Discover your true purpose, and Transform your destined path.</p>",
                'sort_order' => 2,
            ],
            [
                'language_code' => 'hi',
                'language_name' => 'हिन्दी (Hindi)',
                'heading' => 'वैदिक ज्योतिष: जीवन और भाग्य का दिव्य मार्गदर्शन',
                'subheading' => 'Explore. Discover. Transform. - कोविलकम एस्ट्रोलॉजी',
                'content' => "<p class='mb-4 font-semibold text-amber-200'>वैदिक ज्योतिष केवल भविष्य जानने का साधन नहीं, बल्कि हमारे पूर्वजन्म के संचित कर्मों और वर्तमान जीवन के बीच का आध्यात्मिक सेतु है। यह वेदों का पवित्र नेत्र माना गया है।</p>
                <p class='mb-4'>डॉ. ई. के. राजा वर्मा (विद्या वाचस्पति इन वैदिक एस्ट्रोलॉजी) के सानिध्य में कोविलकम एस्ट्रोलॉजी आपको प्रामाणिक और वैज्ञानिक वैदिक मार्गदर्शन प्रदान करता है। कुंडली में ग्रहों की स्थिति आपके व्यक्तित्व, स्वास्थ्य, करियर और वैवाहिक जीवन की दिशा निर्धारित करती है।</p>
                <p class='mb-4'>उचित समय पर सही निर्णय, वैदिक उपचार, सटीक रत्न परामर्श और आध्यात्मिक चिंतन द्वारा आप अपने जीवन में सकारात्मक ऊर्जा का संचार कर सकते हैं। हमारा उद्देश्य हर जिज्ञासु को अंधविश्वास से परे ज्ञान और आत्मबल प्रदान करना है।</p>",
                'sort_order' => 3,
            ],
            [
                'language_code' => 'ta',
                'language_name' => 'தமிழ் (Tamil)',
                'heading' => 'வேத ஜோதிடம்: பிரபஞ்ச ஒளியும் வாழ்வின் நல்வழியும்',
                'subheading' => 'Explore. Discover. Transform. - கோவில்அகம் அஸ்ட்ராலஜி',
                'content' => "<p class='mb-4 font-semibold text-amber-200'>வேத ஜோதிடம் என்பது மனித வாழ்வின் கர்ம வினைகளையும், நவக்கிரகங்களின் அலைவரிசைகளையும் துல்லியமாக விளக்கும் உன்னத பிரபஞ்ச விஞ்ஞானமாகும்.</p>
                <p class='mb-4'>டாக்டர் இ. கே. ராஜா வர்மா (வேத ஜோதிடத்தில் வித்யா வாசஸ்பதி) அவர்களின் வழிகாட்டுதலில் செயல்படும் கோவில்அகம் அஸ்ட்ராலஜி, பாரம்பரிய ஞானத்தையும் நவீன ஆலோசனையையும் ஒன்றிணைத்து துல்லியமான பலன்களை வழங்குகிறது.</p>
                <p class='mb-4'>திருமணப் பொருத்தம், ஜாதக கணிப்பு, யோககாரக ரத்தின பரிந்துரை மற்றும் சுப முகூர்த்த நிர்ணயம் மூலம் வாழ்வின் அனைத்து நிலைகளிலும் அமைதியையும் வெற்றியையும் பெற இணையவழி நேரடி ஆலோசனையை நீங்கள் எப்போது வேண்டுமானாலும் பெறலாம்.</p>",
                'sort_order' => 4,
            ],
        ];

        AstrologyTranslation::truncate();
        foreach ($translations as $translation) {
            AstrologyTranslation::create($translation);
        }

        // 6. Posts Table
        // First Seeded Blog Post strictly: "ജ്യോതിഷവും ജീവിതസരണിയും" (Astrology and the Path of Life)
        $posts = [
            [
                'title' => 'ജ്യോതിഷവും ജീവിതസരണിയും (Astrology and the Path of Life)',
                'slug' => 'jyothishavum-jeevithasaranium',
                'category' => 'Vedic Philosophy',
                'reading_time' => '6 min read',
                'featured_image' => 'images/blog-jyothisham.jpg',
                'excerpt' => 'മനുഷ്യ ജീവിതത്തിന്റെ ഉയർച്ച താഴ്ചകളെ പ്രപഞ്ച സത്യങ്ങളുമായി ബന്ധപ്പെടുത്തി വിലയിരുത്തുന്ന ഉദാത്തമായ ശാസ്ത്രീയ ദർശനം.',
                'body' => "<h2>ജ്യോതിഷം: പ്രപഞ്ച താളവും മനുഷ്യമനസ്സും</h2>
                <p>മനുഷ്യൻ പ്രപഞ്ചത്തിന്റെ ഒരു ലഘുരൂപമാണ് (Microcosm of the Macrocosm). നമ്മിൽ അടങ്ങിയിരിക്കുന്ന പഞ്ചഭൂതങ്ങളും മനസ്സിന്റെ വികാര വിചാരങ്ങളും സൂര്യചന്ദ്രാദി നവഗ്രഹങ്ങളുടെ കാന്തിക തരംഗങ്ങളുമായി നിരന്തരം പ്രതികരിച്ചുകൊണ്ടിരിക്കുന്നു. ഇതിനെയാണ് ജ്യോതിഷ ശാസ്ത്രം സൂക്ഷ്മമായി വിലയിരുത്തുന്നത്.</p>
                
                <h3>കർമ്മ സിദ്ധാന്തവും ഗ്രഹസ്ഥിതിയും</h3>
                <p>ഒരു വ്യക്തി ജനിക്കുന്ന നിമിഷം ആകാശത്ത് ഗ്രഹങ്ങൾ എവിടെയാണോ നിലകൊള്ളുന്നത്, ആ ചിത്രം (Kundali / Jathakam) ആ വ്യക്തിയുടെ പൂർവ്വജന്മ കർമ്മഫലങ്ങളുടെ ഒരു 'കോസ്മിക് ബാർകോഡ്' ആണ്. ലഗ്നം എന്നത് ഭൗതിക ശരീരത്തെയും, ചന്ദ്രൻ മനസ്സിനെയും, സൂര്യൻ ആത്മാവിനെയും പ്രതിനിധാനം ചെയ്യുന്നു.</p>
                
                <blockquote>\"നക്ഷത്രങ്ങൾ നമ്മുടെ ഭാവിയെ അന്ധമായി വിധിക്കുകയല്ല, മറിച്ച് നമ്മുടെ പ്രവണതകളെയും സാധ്യതകളെയും സൂചിപ്പിക്കുക മാത്രമാണ് ചെയ്യുന്നത്.\"</blockquote>
                
                <h3>ജീവിത പ്രതിസന്ധികളിൽ ജ്യോതിഷത്തിന്റെ പങ്ക്</h3>
                <p>ജീവിതത്തിൽ ഉണ്ടാകുന്ന പ്രതിസന്ധികൾ പലപ്പോഴും നമ്മെ തളർത്താറുണ്ട്. എന്നാൽ ജാതകത്തിലെ ദശാകാലങ്ങളെ തിരിച്ചറിയുന്നതിലൂടെ ഏത് കാലഘട്ടത്തിലാണ് സംയമനം പാലിക്കേണ്ടതെന്നും ഏത് ഘട്ടത്തിലാണ് ധീരമായ തീരുമാനങ്ങൾ എടുക്കേണ്ടതെന്നും മനസ്സിലാക്കാം. ഉദാഹരണത്തിന് ശനി ദശയോ ഏഴരശ്ശനിയോ ഒരു വ്യക്തിയെ പാഠങ്ങൾ പഠിപ്പിക്കാനും അച്ചടക്കമുള്ളവനാക്കാനും ഉദ്ദേശിച്ചുള്ളതാണ്, നശിപ്പിക്കാനല്ല.</p>
                
                <h3>ഉപസംഹാരം</h3>
                <p>ജ്യോതിഷം ഭയപ്പെടാനുള്ളതല്ല, ധൈര്യത്തോടെ മുന്നേറാനുള്ള ജീവിത വഴികാട്ടിയാണ്. കോവിലകം അസ്ട്രോളജിയിലൂടെ ശാസ്ത്രീയവും ആധികാരികവുമായ ജാതക വിശകലനം നേടൂ, നിങ്ങളുടെ യഥാർത്ഥ ജീവിത പാതയെ സ്വയം തിരിച്ചറിയൂ.</p>",
                'published_at' => Carbon::now()->subDays(5),
                'author_name' => 'Dr. E. K. Raja Varma (Vidya Vachaspathi in Vedic Astrology)',
            ],
            [
                'title' => 'വിവാഹ പൊരുത്ത പരിശോധനയിലെ സൂക്ഷ്മ ഘടകങ്ങൾ (The Science of Porutham & Compatibility)',
                'slug' => 'marriage-porutham-compatibility-science',
                'category' => 'Marriage Astrology',
                'reading_time' => '7 min read',
                'featured_image' => 'images/blog-marriage.jpg',
                'excerpt' => 'പത്ത് പൊരുത്തങ്ങൾക്കപ്പുറം പാപസാമ്യവും ദശാസന്ധിയും പരിശോധിക്കേണ്ടതിന്റെ ശാസ്ത്രീയ ആവശ്യകത.',
                'body' => "<h2>വിവാഹ പൊരുത്തം: രണ്ട് ആത്മാക്കളുടെ സംഗമം</h2>
                <p>ഭാരതീയ സംസ്കാരത്തിൽ വിവാഹം എന്നത് വെറും രണ്ട് വ്യക്തികളുടെ ഉടമ്പടിയല്ല; രണ്ട് കുടുംബങ്ങളുടെയും വരുംതലമുറകളുടെയും ഭാഗ്യാനുഭവങ്ങളുടെ സംയോജനമാണ്. ജ്യോതിഷത്തിൽ പൊരുത്തം നോക്കുന്നത് കേവലം ആചാരമല്ല, ദമ്പതികൾക്കിടയിലെ മാനസിക, ശാരീരിക, ആത്മീയ അനുയോജ്യത ഉറപ്പുവരുത്താനാണ്.</p>
                
                <h3>പത്ത് പൊരുത്തങ്ങളുടെ പ്രാധാന്യം</h3>
                <p>ദിനം, ഗണം, മാഹേന്ദ്രം, സ്ത്രീദീർഘം, യോനി, രാശി, രാശ്യാധിപൻ, വശ്യം, രജ്ജു, വേധം എന്നീ പത്തു പൊരുത്തങ്ങളിൽ രജ്ജു പൊരുത്തവും ദിന പൊരുത്തവും അതീവ പ്രാധാന്യമർഹിക്കുന്നു. രജ്ജു ദോഷം ദാമ്പത്യ ദീർഘായുസ്സിനെ ബാധിക്കുമെന്നാണ് ശാസ്ത്രവചനം.</p>
                
                <h3>പാപസാമ്യവും ചൊവ്വാ ദോഷവും (Kuja Dosha)</h3>
                <p>പൊരുത്തമുണ്ടെങ്കിലും രണ്ട് ജാതകങ്ങളിലെയും പാപഗ്രഹങ്ങളുടെ ശക്തി തുല്യമായിരിക്കണം (Papasamya). ഒരാളുടെ ജാതകത്തിൽ ചൊവ്വാ ദോഷമോ സർപ്പദോഷമോ ശക്തമായിരിക്കുകയും മറ്റൊരാൾക്ക് അതില്ലതിരിക്കുകയും ചെയ്താൽ ദാമ്പത്യത്തിൽ കലഹങ്ങൾ ഉണ്ടാകാൻ സാധ്യതയുണ്ട്. അതിനാൽ പാപസാമ്യം സൂക്ഷ്മമായി ഗണിക്കേണ്ടതുണ്ട്.</p>
                
                <p>ജ്യോതിഷ വിദഗ്ദ്ധനായ <strong>ഡോ. ഇ. കെ. രാജ വർമ്മ (വിദ്യാ വാചസ്പതി ഇൻ വേദിക് അസ്ട്രോളജി)</strong> നൽകുന്ന സമഗ്ര വിവാഹ പൊരുത്ത റിപ്പോർട്ട് നിങ്ങളുടെ ദാമ്പത്യ ജീവിതത്തിന് ശുഭകരമായ അടിത്തറയേകും.</p>",
                'published_at' => Carbon::now()->subDays(3),
                'author_name' => 'Dr. E. K. Raja Varma (Vidya Vachaspathi in Vedic Astrology)',
            ],
            [
                'title' => 'രത്നശാസ്ത്രവും നവരത്ന ധാരണാ വിധികളും (Vedic Gemology & Navaratna Healing)',
                'slug' => 'gemology-navaratna-selection-rules',
                'category' => 'Gem Prediction',
                'reading_time' => '5 min read',
                'featured_image' => 'images/blog-gems.jpg',
                'excerpt' => 'ഗ്രഹങ്ങളുടെ ഊർജ്ജത്തെ ശരീരത്തിലേക്ക് ആകർഷിക്കുന്ന രത്നങ്ങളുടെ തിരഞ്ഞെടുപ്പിൽ വരുത്തരുതാത്ത പിഴവുകൾ.',
                'body' => "<h2>രത്നങ്ങൾ: പ്രകൃതിയുടെ അത്ഭുത പ്രിസങ്ങൾ</h2>
                <p>സൂര്യരശ്മികളിലെ ഏഴ് വർണ്ണങ്ങളെയും അൾട്രാവയലറ്റ്, ഇൻഫ്രാറെഡ് തരംഗങ്ങളെയും ആഗിരണം ചെയ്യാനുള്ള അസാധാരണ ശേഷി രത്നങ്ങൾക്കുണ്ട്. ഓരോ നവരത്നവും ഓരോ നവഗ്രഹങ്ങളുടെ പ്രതീകമാണ്.</p>
                
                <h3>നവഗ്രഹങ്ങളും അനുയോജ്യ രത്നങ്ങളും</h3>
                <ul>
                    <li><strong>സൂര്യൻ:</strong> മാണിക്യം (Ruby) - ആത്മവിശ്വാസം, അധികാരം, ആരോഗ്യം</li>
                    <li><strong>ചന്ദ്രൻ:</strong> മുത്ത് (Natural Pearl) - മനശ്ശാന്തി, ഓർമ്മശക്തി, ഭാവന</li>
                    <li><strong>വ്യാഴം:</strong> മഞ്ഞ പുഷ്യരാഗം (Yellow Sapphire) - വിദ്യ, ധനം, ആത്മീയോന്നതി</li>
                    <li><strong>ബുധൻ:</strong> മരതകം (Emerald) - ബുദ്ധികൂർമ്മത, കച്ചവടവിജയം, വാക്ചാതുരി</li>
                    <li><strong>ശുക്രൻ:</strong> വജ്രം (Diamond) - സൗന്ദര്യം, ആഡംബരം, ദാമ്പത്യസുഖം</li>
                    <li><strong>ശനി:</strong> ഇന്ദ്രനീലം (Blue Sapphire) - ക്രമാനുഗത വളർച്ച, ദീർഘായുസ്സ്</li>
                    <li><strong>ചൊവ്വ:</strong> പവിഴം (Red Coral) - ധൈര്യം, ഊർജ്ജസ്വലത, രക്തശുദ്ധി</li>
                    <li><strong>രാഹു:</strong> ഗോമേദകം (Hessonite) - അപ്രതീക്ഷിത വിജയം, ശത്രുജയം</li>
                    <li><strong>കേതു:</strong> വൈഡൂര്യം (Cat's Eye) - ആത്മീയജ്ഞാനം, സംരക്ഷണം</li>
                </ul>
                
                <p>ജാതകത്തിലെ യോഗകാരക ഗ്രഹങ്ങളെ പരിശോധിക്കാതെ നക്ഷത്രത്തിന്റെ മാത്രം പേരിൽ തെറ്റായ രത്നം ധരിക്കുന്നത് ഗുണത്തേക്കാളേറെ ദോഷം ചെയ്യും. ശാസ്ത്രീയ നിർണ്ണയത്തിനായി കൺസൾട്ട് ചെയ്യുക.</p>",
                'published_at' => Carbon::now()->subDays(2),
                'author_name' => 'Dr. E. K. Raja Varma (Vidya Vachaspathi in Vedic Astrology)',
            ],
            [
                'title' => 'ഓൺലൈൻ അസ്ട്രോ കൗൺസിലിംഗിന്റെ ആധുനിക പ്രസക്തി (Online Astro Counselling in Modern Era)',
                'slug' => 'online-astro-counselling-modern-era',
                'category' => 'Astro Counselling',
                'reading_time' => '5 min read',
                'featured_image' => 'images/blog-counselling.jpg',
                'excerpt' => 'ആധുനിക ജീവിതത്തിലെ മാനസിക സമ്മർദ്ദങ്ങൾ ലഘൂകരിക്കാൻ വേദജ്യോതിഷ കൗൺസിലിംഗ് നൽകുന്ന പ്രായോഗിക ആശ്വാസം.',
                'body' => "<h2>വേദിക് ജ്യോതിഷവും മനശ്ശാസ്ത്ര കൗൺസിലിംഗും</h2>
                <p>ഇന്നത്തെ തിരക്കുപിടിച്ച ജീവിതശൈലിയിൽ ഉത്കണ്ഠയും ഭാവി ഭയവും പലരെയും ബാധിക്കുന്നുണ്ട്. അമേരിക്കയിലെ IAMA ഓപ്പൺ യൂണിവേഴ്സിറ്റിയിൽ നിന്ന് 'Online Astro Counselling' എന്ന വിഷയത്തിൽ പി.എച്ച്.ഡി (Ph.D.) ഗവേഷണം പൂർത്തിയാക്കിയ <strong>ഡോ. ഇ. കെ. രാജ വർമ്മ (വിദ്യാ വാചസ്പതി ഇൻ വേദിക് അസ്ട്രോളജി)</strong> രൂപകൽപ്പന ചെയ്ത ആധുനിക കൗൺസിലിംഗ് രീതി മനുഷ്യന്റെ മാനസികാവസ്ഥയെ ഗ്രഹചലനങ്ങളുമായി സംയോജിപ്പിച്ച് വിശകലനം ചെയ്യുന്നു.</p>
                
                <h3>എന്തുകൊണ്ട് ഓൺലൈൻ കൗൺസിലിംഗ്?</h3>
                <p>നിങ്ങൾ വിദേശത്തോ കേരളത്തിന് പുറത്തോ എവിടെയുമാകട്ടെ, സമയനഷ്ടമില്ലാതെ വാട്സാപ്പിലൂടെയോ വോയ്സ് കോളിലൂടെയോ അതീവ രഹസ്യസ്വഭാവത്തോടെ നേരിട്ട് സംസാരിക്കാൻ സാധിക്കുന്നു. ലളിതമായ ഭാഷയിൽ പ്രശ്നങ്ങളുടെ കാതൽ കണ്ടെത്തി മനസ്സിന് ആശ്വാസവും വ്യക്തമായ മാർഗ്ഗരേഖയും നൽകുന്നു.</p>",
                'published_at' => Carbon::now()->subDay(),
                'author_name' => 'Dr. E. K. Raja Varma (Vidya Vachaspathi in Vedic Astrology)',
            ],
        ];

        Post::truncate();
        foreach ($posts as $post) {
            Post::create($post);
        }

        // 7. Demonstrative Consultations Table
        $consultations = [
            [
                'name' => 'Sreejith Menon',
                'phone' => '+91 98471 23456',
                'whatsapp_number' => '+91 98471 23456',
                'email' => 'sreejith.menon@example.com',
                'service_requested' => 'Accurate Predictions',
                'birth_date' => '1992-04-18',
                'birth_time' => '10:30',
                'birth_place' => 'Thrissur, Kerala',
                'calculated_summary' => [
                    'mulank' => 9,
                    'bhagyank' => 7,
                    'ruling_planet' => 'Mangal / Kuja (Mars)',
                    'gemstone' => 'Red Coral (Pavizham)',
                ],
                'message' => 'Seeking career shift and business prospect predictions.',
                'status' => 'completed',
            ],
            [
                'name' => 'Ananya Pillai',
                'phone' => '+91 97455 89012',
                'whatsapp_number' => '+91 97455 89012',
                'email' => 'ananya.pillai@example.com',
                'service_requested' => 'Marriage Match Reports',
                'birth_date' => '1996-08-25',
                'birth_time' => '06:15',
                'birth_place' => 'Thiruvananthapuram, Kerala',
                'calculated_summary' => [
                    'mulank' => 7,
                    'bhagyank' => 4,
                    'ruling_planet' => 'Ketu',
                    'gemstone' => "Cat's Eye (Vaidooryam)",
                ],
                'message' => 'Horoscope matching for prospective alliance.',
                'status' => 'pending',
            ],
        ];

        Consultation::truncate();
        foreach ($consultations as $consultation) {
            Consultation::create($consultation);
        }

        // 8. Media Library Initial Items (WebP Images, Audio, Video, PDF)
        $mediaItems = [
            [
                'title' => 'Dr. E. K. Raja Varma Official Portrait (WebP)',
                'file_name' => 'dr-ek-raja-varma.webp',
                'original_name' => 'dr-ek-raja-varma.jpg',
                'file_path' => 'media/images/dr-ek-raja-varma.webp',
                'file_type' => 'image',
                'mime_type' => 'image/webp',
                'file_size' => 120356,
                'width' => 1024,
                'height' => 1024,
                'is_webp' => true,
                'alt_text' => 'Dr. E. K. Raja Varma (Vidya Vachaspathi in Vedic Astrology)',
                'description' => 'Official portrait in royal gold kasavu attire, optimized to WebP format for 84% faster loading.',
            ],
            [
                'title' => 'Sacred Vedic Cosmic Mandala (WebP)',
                'file_name' => 'vedic-cosmic-bg.webp',
                'original_name' => 'vedic-cosmic-bg.jpg',
                'file_path' => 'media/images/vedic-cosmic-bg.webp',
                'file_type' => 'image',
                'mime_type' => 'image/webp',
                'file_size' => 270730,
                'width' => 1920,
                'height' => 1080,
                'is_webp' => true,
                'alt_text' => '12 Rasi Zodiac Wheel and Sacred Geometry',
                'description' => 'Hero background image converted to WebP for instant cosmic rendering.',
            ],
            [
                'title' => 'Palm Leaf Jathakam Manuscript (WebP)',
                'file_name' => 'blog-jyothisham.webp',
                'original_name' => 'blog-jyothisham.jpg',
                'file_path' => 'media/images/blog-jyothisham.webp',
                'file_type' => 'image',
                'mime_type' => 'image/webp',
                'file_size' => 156716,
                'width' => 1200,
                'height' => 675,
                'is_webp' => true,
                'alt_text' => 'Ancient Palm Leaf Horoscope Chart',
                'description' => 'Blog featured image on Vedic philosophy and astrology.',
            ],
            [
                'title' => 'Navaratna Nine Astrological Gems (WebP)',
                'file_name' => 'blog-gems.webp',
                'original_name' => 'blog-gems.jpg',
                'file_path' => 'media/images/blog-gems.webp',
                'file_type' => 'image',
                'mime_type' => 'image/webp',
                'file_size' => 232482,
                'width' => 1200,
                'height' => 675,
                'is_webp' => true,
                'alt_text' => 'Navaratna Astrological Gems on Crimson Velvet',
                'description' => 'Scientific gemology article thumbnail optimized in WebP.',
            ],
            [
                'title' => 'Surya Beej Mantra Sacred Chant (Audio)',
                'file_name' => 'surya-beej-mantra-chant.mp3',
                'original_name' => 'surya-beej-mantra-chant.mp3',
                'file_path' => 'media/audio/surya-beej-mantra-chant.mp3',
                'file_type' => 'audio',
                'mime_type' => 'audio/mpeg',
                'file_size' => 45000,
                'is_webp' => false,
                'alt_text' => 'Lord Surya Beej Mantra Audio Stream',
                'description' => 'Sacred audio recitation of Surya Beej Mantra for mental peace and planetary vitality.',
            ],
            [
                'title' => 'Covilakam Astrology Sample Jathakam Report (PDF)',
                'file_name' => 'covilakam-sample-jathakam-report.pdf',
                'original_name' => 'covilakam-sample-jathakam-report.pdf',
                'file_path' => 'media/documents/covilakam-sample-jathakam-report.pdf',
                'file_type' => 'pdf',
                'mime_type' => 'application/pdf',
                'file_size' => 52000,
                'is_webp' => false,
                'alt_text' => 'Official Sample Horoscope Analysis PDF',
                'description' => 'Complete sample Vedic Jathakam report prepared by Dr. E. K. Raja Varma.',
            ],
            [
                'title' => 'Dr. Raja Varma Vedic Guidance Video (MP4)',
                'file_name' => 'dr-raja-varma-astro-intro.mp4',
                'original_name' => 'dr-raja-varma-astro-intro.mp4',
                'file_path' => 'media/video/dr-raja-varma-astro-intro.mp4',
                'file_type' => 'video',
                'mime_type' => 'video/mp4',
                'file_size' => 250000,
                'is_webp' => false,
                'alt_text' => 'Online Astro Counselling Video Introduction',
                'description' => 'Introductory video discourse on Vedic Astrology and online counselling.',
            ],
        ];

        \App\Models\MediaItem::truncate();
        foreach ($mediaItems as $media) {
            \App\Models\MediaItem::create($media);
        }

        // Call Shop & Razorpay Bookstore Seeder
        $this->call(ShopSeeder::class);

        // Call Dr. E. K. Raja Varma's Real Books Seeder
        $this->call(BookSeeder::class);
    }
}

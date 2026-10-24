<?php

namespace Database\Seeders;

use App\Models\Book;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BookSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 1. Permanently truncate / clear any old placeholder books
        DB::table('books')->truncate();

        // 2. Seed ONLY these 7 authentic works by Dr. E. K. Raja Varma
        $books = [
            [
                'title' => 'മനോരഥം (Manoratham)',
                'malayalam_title' => 'മനോരഥം',
                'subtitle' => 'മനസ്സിന്റെ രഥം - സാഹിത്യ കൃതി',
                'publisher' => 'JB Publications',
                'price' => 100.00,
                'cover_image' => 'images/books/manoratham.jpg',
                'ebook_url' => 'https://www.dropbox.com/scl/fi/1rm2v08yjpl88zk6hc30o/0001.jpg?rlkey=ss954guda5c004p041y3w8y8v&st=gq04ed2s&dl=1',
                'description' => 'ഡോ. ഇ. കെ. രാജ വർമ്മയുടെ ആദ്യ സാഹിത്യ കൃതി. മനുഷ്യമനസ്സിന്റെ വികാരങ്ങളെയും ചിന്തകളെയും ആഴത്തിൽ അടയാളപ്പെടുത്തുന്ന രചന.',
                'sort_order' => 1,
                'is_active' => true,
            ],
            [
                'title' => 'രണ്ടാമൂഴം (Randamoozham)',
                'malayalam_title' => 'രണ്ടാമൂഴം',
                'subtitle' => 'ജീവിതാനുഭവങ്ങളുടെ രണ്ടാം ഭാവം',
                'publisher' => 'GB Publications',
                'price' => 120.00,
                'cover_image' => 'images/books/randamoozham.jpg',
                'ebook_url' => 'https://www.dropbox.com/scl/fi/h4tm3amkza4znmr5rrbng/0001.jpg?rlkey=5u4mhs816k20v5m1w6dmcx6qy&st=m8g6fmjb&dl=1',
                'description' => 'ജീവിതത്തിലെ വേറിട്ട കാഴ്ചപ്പാടുകളും അനുഭവങ്ങളും ലളിതമായ ശൈലിയിൽ അവതരിപ്പിക്കുന്ന ഡോ. ഇ. കെ. രാജ വർമ്മയുടെ രണ്ടാമത്തെ പുസ്തകം.',
                'sort_order' => 2,
                'is_active' => true,
            ],
            [
                'title' => 'ത്രിമാനം (Thrimanam)',
                'malayalam_title' => 'ത്രിമാനം',
                'subtitle' => 'ജീവിതത്തിന്റെ മൂന്ന് മാനങ്ങൾ',
                'publisher' => 'Covilakam Publications',
                'price' => 120.00,
                'cover_image' => 'images/books/thrimanam.jpg',
                'ebook_url' => 'https://www.dropbox.com/scl/fi/jyzouhkn70x4l80pfz3f6/0001.jpg?rlkey=xzhhslc3lgsne5fwc5wv4h24f&st=gdqt6ffs&dl=1',
                'description' => 'മനുഷ്യജീവിതത്തിന്റെയും ദർശനങ്ങളുടെയും മൂന്ന് വ്യത്യസ്ത തലങ്ങളെ ആസ്പദമാക്കി രചിച്ച മൂന്നാമത്തെ കൃതി.',
                'sort_order' => 3,
                'is_active' => true,
            ],
            [
                'title' => 'ചതുരംഗം (Chathurangam)',
                'malayalam_title' => 'ചതുരംഗം',
                'subtitle' => 'ജീവിതമാകുന്ന ചതുരംഗക്കളം',
                'publisher' => 'Watermelon Publications',
                'price' => 150.00,
                'cover_image' => 'images/books/chathurangam.jpg',
                'ebook_url' => 'https://www.dropbox.com/scl/fi/ucvst31jihtwaiqmwjccj/0001.jpg?rlkey=cpn11t4hb49v7r4c94f84bvhw&st=sfo861un&dl=1',
                'description' => 'ചതുരംഗക്കളത്തിലെ കരുനീക്കങ്ങൾ പോലെ ജീവിതത്തിലെ സാഹചര്യങ്ങളെയും വെല്ലുവിളികളെയും അടയാളപ്പെടുത്തുന്ന നാലാമത്തെ പുസ്തകം.',
                'sort_order' => 4,
                'is_active' => true,
            ],
            [
                'title' => 'പഞ്ചാമൃതം (Panchamrutham)',
                'malayalam_title' => 'പഞ്ചാമൃതം',
                'subtitle' => 'ജീവിതയാത്രയിൽ വഴികാട്ടിയാകാവുന്ന 101 ചിന്താശകലങ്ങളുടെ സമാഹാരം',
                'publisher' => 'സ്നേഹഭൂമി പബ്ലിക്കേഷൻസ് (Snehabhoomi Publications)',
                'price' => 150.00,
                'cover_image' => 'images/books/panchamrutham.jpg',
                'ebook_url' => 'https://www.dropbox.com/scl/fi/3rbboawl20mldtt5jgizc/0001.jpg?rlkey=h7ulvmzsujaliwzwwm19ugwzf&st=0e9mbu8v&dl=1',
                'description' => 'മനുഷ്യന്റെ ദൈനംദിന ജീവിതയാത്രയിൽ ആത്മവിശ്വാസവും വെളിച്ചവും പകരുന്ന 101 മഹത്തായ ചിന്താശകലങ്ങളുടെ സമാഹാരം.',
                'sort_order' => 5,
                'is_active' => true,
            ],
            [
                'title' => 'ഷഷ്ടാംഗം (Shashtangam)',
                'malayalam_title' => 'ഷഷ്ടാംഗം',
                'subtitle' => '15 ചെറുകഥകളുടെ സമാഹാരം (Interactive Digital Flipbook)',
                'publisher' => 'Covilakam Digital Edition',
                'price' => 150.00,
                'cover_image' => 'images/books/shashtangam.jpg',
                'ebook_url' => 'https://online.fliphtml5.com/kvuzr/xfdb/#p=1',
                'description' => 'ഡോ. ഇ. കെ. രാജ വർമ്മ രചിച്ച 15 മനോഹരമായ മലയാള ചെറുകഥകളുടെ സമാഹാരം. ഓൺലൈനായി പേജുകൾ മറിച്ചു വായിക്കാനുള്ള ഡിജിറ്റൽ പതിപ്പും ലഭ്യമാണ്.',
                'sort_order' => 6,
                'is_active' => true,
            ],
            [
                'title' => 'രാജഗീതം (Rajageetham - Audio CD)',
                'malayalam_title' => 'രാജഗീതം',
                'subtitle' => 'സംഗീത ആൽബം & സർഗ്ഗാത്മക സൃഷ്ടികൾ',
                'publisher' => 'Covilakam Creations',
                'price' => 100.00,
                'cover_image' => 'images/books/rajageetham.jpg',
                'ebook_url' => 'https://www.dropbox.com/scl/fo/srl5u45259cmyyitegib1/ACCc_tEuYQUlwC_wk_W0Zfg?rlkey=w3ul7u79fejvzurvag90gkauk&st=pvfug1d6&dl=0',
                'description' => 'ഡോ. ഇ. കെ. രാജ വർമ്മയുടെ സർഗ്ഗാത്മക സംഗീത-സാഹിത്യ സൃഷ്ടികളുടെ ഓഡിയോ ശേഖരം.',
                'sort_order' => 7,
                'is_active' => true,
            ],
        ];

        foreach ($books as $bookData) {
            Book::create($bookData);
        }
    }
}

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\Video;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        if (Schema::hasTable('videos')) {
            Video::firstOrCreate(
                ['youtube_id' => 'x_gYSiAFjLU'],
                [
                    'title' => 'Dr. E. K. രാജവർമ്മയ്ക്ക് കീർത്തന അസ്ട്രോളജിക്കൽ റിസർച്ച് സെന്ററിന്റെ ആദരിക്കൽ ചടങ്ങ്',
                    'youtube_url' => 'https://youtu.be/x_gYSiAFjLU?si=krw2jeQs1yluY6xd',
                    'description' => 'ജ്യോതിഷ പണ്ഡിതനും കൗൺസിലറുമായ Dr. ഇ. കെ. രാജ വർമ്മയെ (Vidya Vachaspathi in Vedic Astrology) കീർത്തന അസ്ട്രോളജിക്കൽ റിസർച്ച് സെന്റർ ആദരിച്ച ചടങ്ങിന്റെ ദൃശ്യങ്ങൾ. ജ്യോതിഷ രംഗത്തെ അദ്ദേഹത്തിന്റെ സമഗ്ര സംഭാവനകളെയും സേവനങ്ങളെയും മുൻനിർത്തി നടന്ന സദസ്സ്.',
                    'duration' => '64:51',
                    'is_active' => true,
                    'sort_order' => 7,
                ]
            );
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasTable('videos')) {
            Video::where('youtube_id', 'x_gYSiAFjLU')->delete();
        }
    }
};

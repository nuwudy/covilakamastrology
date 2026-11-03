<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('astrology_readings', function (Blueprint $table) {
            $table->string('whatsapp_number', 35)->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('astrology_readings', function (Blueprint $table) {
            $table->string('whatsapp_number', 35)->nullable(false)->change();
        });
    }
};


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
        // 1. Settings Table
        Schema::create('settings', function (Blueprint $table) {
            $table->id();
            $table->string('key')->unique();
            $table->text('value')->nullable();
            $table->string('group')->default('general');
            $table->timestamps();
        });

        // 2. Qualifications Table
        Schema::create('qualifications', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('institution');
            $table->string('year')->nullable();
            $table->text('highlights')->nullable();
            $table->string('badge_text')->nullable();
            $table->integer('sort_order')->default(0);
            $table->timestamps();
        });

        // 3. Services Table
        Schema::create('services', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('slug')->unique();
            $table->text('description');
            $table->string('icon')->nullable();
            $table->text('whatsapp_prefill')->nullable();
            $table->integer('sort_order')->default(0);
            $table->timestamps();
        });

        // 4. Videos Table
        Schema::create('videos', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('youtube_url')->nullable();
            $table->string('youtube_id');
            $table->text('description')->nullable();
            $table->string('duration')->nullable();
            $table->boolean('is_active')->default(true);
            $table->integer('sort_order')->default(0);
            $table->timestamps();
        });

        // 5. Astrology Translations Table
        Schema::create('astrology_translations', function (Blueprint $table) {
            $table->id();
            $table->string('language_code'); // ml, en, hi, ta
            $table->string('language_name'); // Malayalam, English, Hindi, Tamil
            $table->string('heading');
            $table->string('subheading')->nullable();
            $table->longText('content');
            $table->integer('sort_order')->default(0);
            $table->timestamps();
        });

        // 6. Posts Table
        Schema::create('posts', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('slug')->unique();
            $table->string('category')->default('Vedic Astrology');
            $table->string('reading_time')->default('5 min read');
            $table->string('featured_image')->nullable();
            $table->text('excerpt')->nullable();
            $table->longText('body');
            $table->dateTime('published_at')->nullable();
            $table->string('author_name')->default('Dr. E. K. Raja Varma (Vidya Vachaspathi in Vedic Astrology)');
            $table->timestamps();
        });

        // 7. Consultations Table
        Schema::create('consultations', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('phone')->nullable();
            $table->string('whatsapp_number')->nullable();
            $table->string('email')->nullable();
            $table->string('service_requested')->nullable();
            $table->date('birth_date')->nullable();
            $table->time('birth_time')->nullable();
            $table->string('birth_place')->nullable();
            $table->json('calculated_summary')->nullable();
            $table->text('message')->nullable();
            $table->string('status')->default('pending');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('consultations');
        Schema::dropIfExists('posts');
        Schema::dropIfExists('astrology_translations');
        Schema::dropIfExists('videos');
        Schema::dropIfExists('services');
        Schema::dropIfExists('qualifications');
        Schema::dropIfExists('settings');
    }
};

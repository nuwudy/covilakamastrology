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
        Schema::create('astrology_readings', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique()->index();
            $table->string('full_name', 150);
            $table->string('gender', 20)->default('male');
            $table->string('whatsapp_number', 35)->nullable();
            $table->string('language', 10)->default('en');
            $table->date('dob');
            $table->time('birth_time')->default('12:00:00');
            $table->boolean('is_approximate_time')->default(false);
            $table->string('birth_place', 180)->default('Ernakulam, Kerala');
            $table->decimal('latitude', 10, 6)->default(9.931200);
            $table->decimal('longitude', 10, 6)->default(76.267300);
            $table->string('timezone', 60)->default('Asia/Kolkata');
            $table->json('chart_data');
            $table->enum('paid_tier', ['free', 'tier_100', 'tier_500'])->default('free');
            $table->string('razorpay_payment_id')->nullable();
            $table->string('razorpay_order_id')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('astrology_readings');
    }
};


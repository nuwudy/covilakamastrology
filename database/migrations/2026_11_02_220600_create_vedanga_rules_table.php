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
        Schema::create('vedanga_rules', function (Blueprint $table) {
            $table->id();
            $table->string('category', 60)->index();
            $table->string('rule_key', 100)->index();
            $table->text('content_en');
            $table->text('content_ml');
            $table->text('content_ta');
            $table->text('content_hi');
            $table->json('metadata')->nullable();
            $table->timestamps();

            $table->unique(['category', 'rule_key']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vedanga_rules');
    }
};


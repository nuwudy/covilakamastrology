<?php

use Database\Seeders\BlogPostsSeeder;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        if (Schema::hasTable('posts')) {
            (new BlogPostsSeeder())->run();
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Keep seeded posts intact on rollback
    }
};


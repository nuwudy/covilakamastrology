<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    private function cleanText(?string $val): ?string
    {
        if ($val === null) {
            return null;
        }
        $v = str_replace('DR. DR. E. K. Raja Varma', 'Dr. E. K. Raja Varma', $val);
        $v = str_replace('DR. E. K. RAJA VARMA', 'Dr. E. K. Raja Varma', $v);
        $v = str_replace('DR. E. K. Raja Varma', 'Dr. E. K. Raja Varma', $v);
        $v = str_replace('DR. Raja Varma', 'Dr. Raja Varma', $v);
        $v = str_replace('International Astrology Federation (IAF)', 'International Vedic Astrology Federation (IVAF)', $v);
        $v = str_replace('International Astrology Federation', 'International Vedic Astrology Federation (IVAF)', $v);
        $v = str_replace('Indian Astrology Federation (IAF)', 'Indian Vedic Astrology Federation (IVAF)', $v);
        $v = str_replace('Indian Astrology Federation', 'Indian Vedic Astrology Federation (IVAF)', $v);
        $v = preg_replace('/\bIAF\b/', 'IVAF', $v);

        return $v;
    }

    /**
     * Run the migrations.
     */
    public function up(): void
    {
        $tables = ['settings', 'qualifications', 'services', 'posts', 'products', 'users', 'media_items', 'books'];

        foreach ($tables as $table) {
            if (Schema::hasTable($table)) {
                foreach (DB::table($table)->get() as $row) {
                    $updates = [];
                    foreach ((array) $row as $col => $val) {
                        if (is_string($val) && $col !== 'id' && $col !== 'password') {
                            $cleaned = $this->cleanText($val);
                            if ($cleaned !== $val) {
                                $updates[$col] = $cleaned;
                            }
                        }
                    }
                    if (!empty($updates) && isset($row->id)) {
                        DB::table($table)->where('id', $row->id)->update($updates);
                    }
                }
            }
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Non-destructive text standardization
    }
};


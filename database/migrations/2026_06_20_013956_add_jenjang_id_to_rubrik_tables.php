<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // Column already exists via previous migration.
        // Ensure existing data has jenjang_id = 1 (Sarjana)
        $tables = [
            'rubrik_capaian_unggulans',
            'rubrik_naskah_gks',
            'rubrik_presentasi_gks',
            'rubrik_bahasa_inggris',
            'rubrik_wawancara_cu',
        ];
        foreach ($tables as $table) {
            if (\Illuminate\Support\Facades\Schema::hasTable($table)) {
                DB::table($table)->whereNull('jenjang_id')->update(['jenjang_id' => 1]);
            }
        }
    }

    public function down(): void
    {
        //
    }
};

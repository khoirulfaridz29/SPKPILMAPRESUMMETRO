<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        foreach (['rubrik_naskah_gks','rubrik_presentasi_gks','rubrik_bahasa_inggris','rubrik_wawancara_cu','rubrik_capaian_unggulans'] as $table) {
            Schema::table($table, fn(Blueprint $t) =>
                $t->foreignId('kriteria_id')->nullable()->constrained('kriteria_penilaian')->nullOnDelete()->after('jenjang_id')
            );
        }
    }

    public function down(): void
    {
        foreach (['rubrik_naskah_gks','rubrik_presentasi_gks','rubrik_bahasa_inggris','rubrik_wawancara_cu','rubrik_capaian_unggulans'] as $table) {
            Schema::table($table, function (Blueprint $t) {
                $t->dropForeign(['kriteria_id']);
                $t->dropColumn('kriteria_id');
            });
        }
    }
};

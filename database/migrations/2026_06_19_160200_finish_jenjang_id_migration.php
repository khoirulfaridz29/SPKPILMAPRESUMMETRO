<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // 1. Backfill mahasiswa.jenjang_id for existing data
        DB::table('mahasiswa')->whereNull('jenjang_id')->update(['jenjang_id' => 1]);

        // 2. Make mahasiswa.jenjang_id NOT NULL
        Schema::table('mahasiswa', function (Blueprint $table) {
            $table->unsignedBigInteger('jenjang_id')->nullable(false)->change();
        });

        // 3. Add jenjang_id to kriteria_penilaian
        if (Schema::hasTable('kriteria_penilaian') && !Schema::hasColumn('kriteria_penilaian', 'jenjang_id')) {
            Schema::table('kriteria_penilaian', function (Blueprint $table) {
                $table->unsignedBigInteger('jenjang_id')->nullable()->after('id');
                $table->foreign('jenjang_id')->references('id')->on('jenjang')->onDelete('restrict');
            });
        }

        DB::table('kriteria_penilaian')->whereNull('jenjang_id')->update(['jenjang_id' => 1]);

        if (Schema::hasTable('kriteria_penilaian')) {
            Schema::table('kriteria_penilaian', function (Blueprint $table) {
                $table->unsignedBigInteger('jenjang_id')->nullable(false)->change();
            });
        }

        // 4. Add nullable jenjang_id to remaining tables
        $tables = [
            'rubrik_naskah_gks', 'rubrik_presentasi_gks', 'rubrik_wawancara_cu',
            'rubrik_bahasa_inggris', 'rubrik_capaian_unggulans', 'persyaratan',
            'jadwal', 'indikator_penilaians',
        ];

        foreach ($tables as $table) {
            if (Schema::hasTable($table) && !Schema::hasColumn($table, 'jenjang_id')) {
                Schema::table($table, function (Blueprint $table) {
                    $table->unsignedBigInteger('jenjang_id')->nullable()->after('id');
                    $table->foreign('jenjang_id')->references('id')->on('jenjang')->onDelete('set null');
                });
            }
        }
    }

    public function down(): void
    {
        // Make mahasiswa.jenjang_id nullable again
        Schema::table('mahasiswa', function (Blueprint $table) {
            $table->unsignedBigInteger('jenjang_id')->nullable()->change();
        });

        // Remove from all tables except mahasiswa (handled by previous down)
        $tables = [
            'kriteria_penilaian', 'rubrik_naskah_gks', 'rubrik_presentasi_gks',
            'rubrik_wawancara_cu', 'rubrik_bahasa_inggris', 'rubrik_capaian_unggulans',
            'persyaratan', 'jadwal', 'indikator_penilaians',
        ];

        foreach ($tables as $table) {
            if (Schema::hasTable($table) && Schema::hasColumn($table, 'jenjang_id')) {
                Schema::table($table, function (Blueprint $table) {
                    $table->dropForeign(['jenjang_id']);
                    $table->dropColumn('jenjang_id');
                });
            }
        }
    }
};

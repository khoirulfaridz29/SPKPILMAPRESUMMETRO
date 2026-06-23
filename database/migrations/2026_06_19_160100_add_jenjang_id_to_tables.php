<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // Add jenjang_id to mahasiswa (nullable first, backfill, then not null)
        Schema::table('mahasiswa', function (Blueprint $table) {
            $table->unsignedBigInteger('jenjang_id')->nullable()->after('user_id');
            $table->foreign('jenjang_id')->references('id')->on('jenjang')->onDelete('restrict');
        });

        // Backfill: all existing mahasiswa are Sarjana (id=1)
        DB::table('mahasiswa')->whereNull('jenjang_id')->update(['jenjang_id' => 1]);

        // Make NOT NULL after backfill
        Schema::table('mahasiswa', function (Blueprint $table) {
            $table->unsignedBigInteger('jenjang_id')->nullable(false)->change();
        });

        // Add jenjang_id to kriteria_penilaian (default Sarjana)
        Schema::table('kriteria_penilaian', function (Blueprint $table) {
            $table->unsignedBigInteger('jenjang_id')->nullable()->after('id');
            $table->foreign('jenjang_id')->references('id')->on('jenjang')->onDelete('restrict');
        });

        DB::table('kriteria_penilaian')->whereNull('jenjang_id')->update(['jenjang_id' => 1]);

        Schema::table('kriteria_penilaian', function (Blueprint $table) {
            $table->unsignedBigInteger('jenjang_id')->nullable(false)->change();
        });

        // Add nullable jenjang_id to other tables
        $tables = [
            'rubrik_naskah_gks',
            'rubrik_presentasi_gks',
            'rubrik_wawancara_cu',
            'rubrik_bahasa_inggris',
            'rubrik_capaian_unggulans',
            'persyaratan',
            'jadwal',
        ];

        foreach ($tables as $table) {
            if (Schema::hasTable($table) && !Schema::hasColumn($table, 'jenjang_id')) {
                Schema::table($table, function (Blueprint $table) {
                    $table->unsignedBigInteger('jenjang_id')->nullable()->after('id');
                    $table->foreign('jenjang_id')->references('id')->on('jenjang')->onDelete('set null');
                });
            }
        }

        // Add jenjang_id to indikator_penilaians
        if (Schema::hasTable('indikator_penilaians') && !Schema::hasColumn('indikator_penilaians', 'jenjang_id')) {
            Schema::table('indikator_penilaians', function (Blueprint $table) {
                $table->unsignedBigInteger('jenjang_id')->nullable()->after('id');
                $table->foreign('jenjang_id')->references('id')->on('jenjang')->onDelete('set null');
            });
        }
    }

    public function down(): void
    {
        $tables = [
            'mahasiswa', 'kriteria_penilaian', 'rubrik_naskah_gks',
            'rubrik_presentasi_gks', 'rubrik_wawancara_cu',
            'rubrik_bahasa_inggris', 'rubrik_capaian_unggulans',
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

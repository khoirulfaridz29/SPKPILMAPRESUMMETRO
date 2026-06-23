<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // 1. portofolio_cu.skor_rekomendasi: DECIMAL → VARCHAR (supports range values like '30-40')
        if (Schema::hasTable('portofolio_cu')) {
            Schema::table('portofolio_cu', function (Blueprint $table) {
                $table->string('skor_rekomendasi', 50)->nullable()->change();
            });
        }

        // 2. penilaian.nilai_input: ensure DECIMAL(8,4) precision
        if (Schema::hasTable('penilaian')) {
            Schema::table('penilaian', function (Blueprint $table) {
                $table->decimal('nilai_input', 8, 4)->nullable(false)->change();
            });
        }

        // 3. kriteria_penilaian.tipe_faktor: add column if not exists
        if (Schema::hasTable('kriteria_penilaian') && !Schema::hasColumn('kriteria_penilaian', 'tipe_faktor')) {
            Schema::table('kriteria_penilaian', function (Blueprint $table) {
                $table->enum('tipe_faktor', ['Core Factor', 'Secondary Factor'])->default('Core Factor');
            });
        }
    }

    public function down(): void
    {
        if (Schema::hasTable('portofolio_cu') && Schema::hasColumn('portofolio_cu', 'skor_rekomendasi')) {
            Schema::table('portofolio_cu', function (Blueprint $table) {
                $table->decimal('skor_rekomendasi', 8, 2)->nullable()->change();
            });
        }

        if (Schema::hasTable('kriteria_penilaian') && Schema::hasColumn('kriteria_penilaian', 'tipe_faktor')) {
            Schema::table('kriteria_penilaian', function (Blueprint $table) {
                $table->dropColumn('tipe_faktor');
            });
        }
    }
};

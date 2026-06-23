<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        $tables = [
            'rubrik_naskah_gks'      => ['label' => 'Naskah GK',           'd3_label' => 'Produk Inovatif (PI)'],
            'rubrik_presentasi_gks'  => ['label' => 'Presentasi GK',       'd3_label' => 'Presentasi PI'],
            'rubrik_bahasa_inggris'  => ['label' => 'Bahasa Inggris',      'd3_label' => 'Bahasa Inggris'],
            'rubrik_wawancara_cu'    => ['label' => 'Wawancara CU',        'd3_label' => 'Wawancara CU'],
        ];

        foreach ($tables as $table => $labels) {
            if (!Schema::hasColumn($table, 'label')) {
                Schema::table($table, function (Blueprint $table) {
                    $table->string('label')->nullable()->after('jenjang_id');
                });
            }

            // Set default label for existing S1 records (jenjang_id = 1)
            DB::table($table)->where('jenjang_id', 1)->whereNull('label')->update(['label' => $labels['label']]);

            // Set default label for existing D3 records (jenjang_id = 2)
            DB::table($table)->where('jenjang_id', 2)->whereNull('label')->update(['label' => $labels['d3_label']]);
        }
    }

    public function down(): void
    {
        $tables = ['rubrik_naskah_gks', 'rubrik_presentasi_gks', 'rubrik_bahasa_inggris', 'rubrik_wawancara_cu'];
        foreach ($tables as $table) {
            if (Schema::hasColumn($table, 'label')) {
                Schema::table($table, function (Blueprint $table) {
                    $table->dropColumn('label');
                });
            }
        }
    }
};

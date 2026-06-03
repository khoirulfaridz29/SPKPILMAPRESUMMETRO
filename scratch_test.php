<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

$portfolios = App\Models\PortofolioCu::all();
echo "Total portfolios: " . $portfolios->count() . "\n";
foreach ($portfolios as $p) {
    echo "ID: {$p->id}, Name: {$p->nama_prestasi}, Rubrik ID: {$p->rubrik_cu_id}, Kategori: {$p->kategori_jenjang}, Skor Rekomendasi: {$p->skor_rekomendasi}, Status: {$p->status_validasi}\n";
}

$rubriks = App\Models\RubrikCapaianUnggulan::all();
echo "\nTotal rubriks: " . $rubriks->count() . "\n";
foreach ($rubriks as $r) {
    echo "ID: {$r->id}, Bidang: {$r->bidang}, Wujud: {$r->wujud_capaian_unggulan}\n";
    echo "  Skor: Int={$r->skor_internasional}, Reg={$r->skor_regional}, Nas={$r->skor_nasional}, Prov={$r->skor_provinsi}, KabKota={$r->skor_kab_kota}\n";
}

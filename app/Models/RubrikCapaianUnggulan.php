<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RubrikCapaianUnggulan extends Model
{
    protected $table = 'rubrik_capaian_unggulans';

    protected $fillable = [
        'jenjang_id',
        'kriteria_id',
        'bidang',
        'wujud_capaian_unggulan',
        'kode_internasional',
        'skor_internasional',
        'kode_regional',
        'skor_regional',
        'kode_nasional',
        'skor_nasional',
        'kode_provinsi',
        'skor_provinsi',
        'kode_kab_kota',
        'skor_kab_kota',
    ];

    public function jenjang()
    {
        return $this->belongsTo(Jenjang::class);
    }

    public function kriteria()
    {
        return $this->belongsTo(KriteriaPenilaian::class, 'kriteria_id');
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KriteriaPenilaian extends Model
{
    protected $table = 'kriteria_penilaian';

    protected $fillable = [
        'jenjang_id',
        'kode_kriteria',
        'nama_kriteria',
        'jenis_faktor',
        'nilai_target',
        'bobot',
        'tipe_faktor',
    ];

    public function jenjang()
    {
        return $this->belongsTo(Jenjang::class);
    }
}

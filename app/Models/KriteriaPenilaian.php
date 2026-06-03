<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KriteriaPenilaian extends Model
{
    protected $table = 'kriteria_penilaian';

    protected $fillable = [
        'kode_kriteria',
        'nama_kriteria',
        'jenis_faktor',
        'nilai_target',
        'bobot',
        'tipe_faktor',
    ];
}

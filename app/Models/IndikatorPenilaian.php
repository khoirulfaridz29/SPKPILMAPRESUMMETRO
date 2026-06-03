<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class IndikatorPenilaian extends Model
{
    protected $table = 'indikator_penilaians';

    protected $fillable = [
        'kriteria_id',
        'nama_indikator',
        'deskripsi',
        'bobot',
    ];

    public function kriteria()
    {
        return $this->belongsTo(KriteriaPenilaian::class, 'kriteria_id');
    }
}

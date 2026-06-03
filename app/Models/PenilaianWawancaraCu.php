<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PenilaianWawancaraCu extends Model
{
    protected $table = 'penilaian_wawancara_cu';

    protected $fillable = [
        'juri_id',
        'pendaftaran_id',
        'rubrik_wawancara_cu_id',
        'nilai_input',
    ];

    public function rubrikWawancaraCu()
    {
        return $this->belongsTo(RubrikWawancaraCu::class, 'rubrik_wawancara_cu_id');
    }
}

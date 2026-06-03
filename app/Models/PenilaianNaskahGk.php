<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PenilaianNaskahGk extends Model
{
    protected $table = 'penilaian_naskah_gk';

    protected $fillable = [
        'juri_id',
        'pendaftaran_id',
        'rubrik_naskah_gk_id',
        'nilai_input',
    ];

    public function juri()
    {
        return $this->belongsTo(User::class, 'juri_id');
    }

    public function pendaftaran()
    {
        return $this->belongsTo(Pendaftaran::class, 'pendaftaran_id');
    }

    public function rubrik()
    {
        return $this->belongsTo(RubrikNaskahGk::class, 'rubrik_naskah_gk_id');
    }
}

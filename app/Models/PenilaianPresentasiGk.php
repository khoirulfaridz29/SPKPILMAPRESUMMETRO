<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PenilaianPresentasiGk extends Model
{
    protected $table = 'penilaian_presentasi_gk';

    protected $fillable = [
        'juri_id',
        'pendaftaran_id',
        'rubrik_presentasi_gk_id',
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
        return $this->belongsTo(RubrikPresentasiGk::class, 'rubrik_presentasi_gk_id');
    }
}

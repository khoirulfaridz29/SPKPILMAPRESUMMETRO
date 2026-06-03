<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HasilPenilaian extends Model
{
    protected $table = 'hasil_penilaian';

    protected $fillable = [
        'pendaftaran_id',
        'skor_awal',
        'skor_final',
        'nilai_total',
        'ranking',
        'status_juara',
        'validasi_wr3',
        'nilai_sementara',
    ];

    public function pendaftaran()
    {
        return $this->belongsTo(Pendaftaran::class);
    }
}

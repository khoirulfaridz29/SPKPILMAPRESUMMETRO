<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PortofolioCu extends Model
{
    protected $table = 'portofolio_cu';

    protected $fillable = [
        'pendaftaran_id',
        'rubrik_cu_id',
        'kategori_jenjang',
        'nama_prestasi',
        'tempat',
        'tanggal_pelaksanaan',
        'file_path',
        'status_validasi',
        'skor_rekomendasi',
    ];

    public function pendaftaran()
    {
        return $this->belongsTo(Pendaftaran::class);
    }

    public function rubrikCu()
    {
        return $this->belongsTo(RubrikCapaianUnggulan::class, 'rubrik_cu_id');
    }
}

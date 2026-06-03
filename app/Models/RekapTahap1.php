<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RekapTahap1 extends Model
{
    protected $table = 'rekap_tahap_1';

    protected $fillable = [
        'pendaftaran_id',
        'status_laporan',
        'divalidasi_oleh',
        'tanggal_validasi',
    ];

    public function pendaftaran()
    {
        return $this->belongsTo(Pendaftaran::class);
    }

    public function validator()
    {
        return $this->belongsTo(User::class, 'divalidasi_oleh');
    }
}

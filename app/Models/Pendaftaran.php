<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pendaftaran extends Model
{
    protected $table = 'pendaftaran';

    protected $fillable = [
        'mahasiswa_id',
        'status_berkas',
        'status_seleksi',
        'tanggal_daftar',
        'is_submitted',
    ];

    protected $casts = [
        'tanggal_daftar' => 'date',
    ];

    public function mahasiswa()
    {
        return $this->belongsTo(Mahasiswa::class);
    }

    public function berkas()
    {
        return $this->hasMany(BerkasPendaftaran::class);
    }

    public function portofolios()
    {
        return $this->hasMany(PortofolioCu::class);
    }

    public function rekap()
    {
        return $this->hasOne(RekapTahap1::class);
    }

    public function penilaian()
    {
        return $this->hasMany(Penilaian::class);
    }

    public function hasil()
    {
        return $this->hasOne(HasilPenilaian::class);
    }

    public function penugasanJuri()
    {
        return $this->hasMany(PenugasanJuri::class);
    }
}

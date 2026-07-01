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

    public function rubrikNaskahGk()
    {
        return $this->hasMany(RubrikNaskahGk::class, 'kriteria_id');
    }

    public function rubrikPresentasiGk()
    {
        return $this->hasMany(RubrikPresentasiGk::class, 'kriteria_id');
    }

    public function rubrikBahasaInggris()
    {
        return $this->hasMany(RubrikBahasaInggris::class, 'kriteria_id');
    }

    public function rubrikWawancaraCu()
    {
        return $this->hasMany(RubrikWawancaraCu::class, 'kriteria_id');
    }

    public function rubrikCapaianUnggulan()
    {
        return $this->hasMany(RubrikCapaianUnggulan::class, 'kriteria_id');
    }

    public function getTipeKriteriaAttribute(): string
    {
        $lower = strtolower($this->nama_kriteria);
        if (str_contains($lower, 'naskah')) return 'naskah_gk';
        if (str_contains($lower, 'presentasi')) return 'presentasi_gk';
        if (str_contains($lower, 'bahasa inggris') || $lower === 'bi') return 'bahasa_inggris';
        if (str_contains($lower, 'wawancara')) return 'wawancara_cu';
        if (str_contains($lower, 'portofolio') || str_contains($lower, 'capaian') || $lower === 'cu') return 'cu';
        return 'custom';
    }
}

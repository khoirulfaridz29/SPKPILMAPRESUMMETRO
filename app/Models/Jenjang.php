<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Jenjang extends Model
{
    protected $table = 'jenjang';

    protected $fillable = [
        'kode_jenjang',
        'nama_jenjang',
        'deskripsi',
    ];

    public function mahasiswas()
    {
        return $this->hasMany(Mahasiswa::class);
    }

    public function kriteriaPenilaians()
    {
        return $this->hasMany(KriteriaPenilaian::class);
    }
}

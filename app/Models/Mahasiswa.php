<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mahasiswa extends Model
{
    use HasFactory;

    protected $table = 'mahasiswa';

    protected $fillable = [
        'user_id',
        'jenjang_id',
        'nim',
        'program_studi',
        'ipk',
        'pernah_pilmapres',
    ];

    public static function getProdiMapping()
    {
        return ProgramStudi::pluck('nama', 'kode')->toArray();
    }

    public function getAngkatanAttribute()
    {
        return '20' . substr($this->nim, 0, 2);
    }

    public function getKodeProdiAttribute()
    {
        return substr($this->nim, 2, 2);
    }

    public function getNomorUrutAttribute()
    {
        return substr($this->nim, 4);
    }

    public function getParsedProdiAttribute()
    {
        $mapping = self::getProdiMapping();
        $kode = $this->kode_prodi;
        return $mapping[$kode] ?? 'Prodi Tidak Terdefinisi (' . $kode . ')';
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function jenjang()
    {
        return $this->belongsTo(Jenjang::class);
    }
}

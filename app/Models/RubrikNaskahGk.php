<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RubrikNaskahGk extends Model
{
    use HasFactory;

    protected $table = 'rubrik_naskah_gks';
    protected $fillable = ['jenjang_id', 'kriteria_id', 'label', 'aspek_penilaian', 'kriteria_penilaian', 'bobot'];

    public function jenjang()
    {
        return $this->belongsTo(Jenjang::class);
    }

    public function kriteria()
    {
        return $this->belongsTo(KriteriaPenilaian::class, 'kriteria_id');
    }
}

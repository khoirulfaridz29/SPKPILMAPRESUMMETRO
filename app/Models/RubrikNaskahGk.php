<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RubrikNaskahGk extends Model
{
    use HasFactory;

    protected $table = 'rubrik_naskah_gks';
    protected $fillable = ['aspek_penilaian', 'kriteria_penilaian', 'bobot'];
}

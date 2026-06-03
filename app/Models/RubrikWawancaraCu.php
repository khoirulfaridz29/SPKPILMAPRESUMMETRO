<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RubrikWawancaraCu extends Model
{
    protected $table = 'rubrik_wawancara_cu';

    protected $fillable = [
        'kriteria_penilaian',
        'bobot',
    ];
}

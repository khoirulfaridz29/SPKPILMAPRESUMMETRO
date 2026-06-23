<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RubrikWawancaraCu extends Model
{
    protected $table = 'rubrik_wawancara_cu';

    protected $fillable = [
        'jenjang_id',
        'label',
        'kriteria_penilaian',
        'bobot',
    ];

    public function jenjang()
    {
        return $this->belongsTo(Jenjang::class);
    }
}

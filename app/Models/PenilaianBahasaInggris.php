<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PenilaianBahasaInggris extends Model
{
    protected $table = 'penilaian_bahasa_inggris';

    protected $fillable = [
        'juri_id',
        'pendaftaran_id',
        'rubrik_bahasa_inggris_id',
        'nilai_input',
    ];

    public function juri()
    {
        return $this->belongsTo(User::class, 'juri_id');
    }

    public function pendaftaran()
    {
        return $this->belongsTo(Pendaftaran::class, 'pendaftaran_id');
    }

    public function rubrik()
    {
        return $this->belongsTo(RubrikBahasaInggris::class, 'rubrik_bahasa_inggris_id');
    }
}

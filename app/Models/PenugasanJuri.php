<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PenugasanJuri extends Model
{
    protected $table = 'penugasan_juri';

    protected $fillable = [
        'juri_id',
        'pendaftaran_id',
        'surat_penugasan',
    ];

    public function juri()
    {
        return $this->belongsTo(User::class, 'juri_id');
    }

    public function pendaftaran()
    {
        return $this->belongsTo(Pendaftaran::class);
    }
}

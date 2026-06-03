<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BerkasPendaftaran extends Model
{
    protected $table = 'berkas_pendaftaran';

    protected $fillable = [
        'pendaftaran_id',
        'nama_berkas',
        'file_path',
        'status_validasi',
    ];

    public function pendaftaran()
    {
        return $this->belongsTo(Pendaftaran::class);
    }
}

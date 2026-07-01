<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RubrikCustomTemplateField extends Model
{
    protected $fillable = ['template_id', 'nama_field', 'tipe_input', 'urutan', 'bobot'];

    public function template()
    {
        return $this->belongsTo(RubrikCustomTemplate::class, 'template_id');
    }
}

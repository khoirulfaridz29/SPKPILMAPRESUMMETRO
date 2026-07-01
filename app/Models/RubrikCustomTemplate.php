<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RubrikCustomTemplate extends Model
{
    protected $fillable = ['nama_template'];

    public function fields()
    {
        return $this->hasMany(RubrikCustomTemplateField::class, 'template_id');
    }
}

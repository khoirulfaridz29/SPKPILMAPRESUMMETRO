<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RubrikBahasaInggris extends Model
{
    use HasFactory;

    protected $table = 'rubrik_bahasa_inggris';
    protected $fillable = [
        'jenjang_id',
        'label',
        'field',
        'excellent_score', 'excellent_criteria',
        'good_score', 'good_criteria',
        'fair_score', 'fair_criteria',
        'poor_score', 'poor_criteria'
    ];

    public function jenjang()
    {
        return $this->belongsTo(Jenjang::class);
    }
}

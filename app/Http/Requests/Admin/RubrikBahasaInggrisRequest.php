<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class RubrikBahasaInggrisRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'jenjang_id'        => 'required|exists:jenjang,id',
            'field'             => 'required|string|max:255',
            'excellent_score'   => 'required|string|max:50',
            'excellent_criteria' => 'required|string',
            'good_score'        => 'required|string|max:50',
            'good_criteria'     => 'required|string',
            'fair_score'        => 'required|string|max:50',
            'fair_criteria'     => 'required|string',
            'poor_score'        => 'required|string|max:50',
            'poor_criteria'     => 'required|string',
            'label'             => 'nullable|string|max:255',
        ];
    }
}

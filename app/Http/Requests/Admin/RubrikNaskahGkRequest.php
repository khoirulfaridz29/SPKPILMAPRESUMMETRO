<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class RubrikNaskahGkRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'jenjang_id'         => 'required|exists:jenjang,id',
            'aspek_penilaian'    => 'required|string|max:255',
            'kriteria_penilaian' => 'required|string|max:255',
            'bobot'              => 'required|numeric|min:1',
            'label'              => 'nullable|string|max:255',
        ];
    }
}

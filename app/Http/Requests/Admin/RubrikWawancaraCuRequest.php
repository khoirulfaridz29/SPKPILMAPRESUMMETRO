<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class RubrikWawancaraCuRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'kriteria_penilaian' => 'required|string|max:255',
            'bobot'              => 'required|numeric|min:1',
            'label'              => 'nullable|string|max:255',
        ];
    }
}

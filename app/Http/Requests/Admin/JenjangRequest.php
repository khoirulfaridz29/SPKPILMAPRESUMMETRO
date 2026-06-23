<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class JenjangRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'kode_jenjang' => [
                'required', 'string', 'max:20',
                Rule::unique('jenjang', 'kode_jenjang')->ignore($this->jenjang),
            ],
            'nama_jenjang' => 'required|string|max:100',
            'deskripsi' => 'nullable|string',
        ];
    }
}

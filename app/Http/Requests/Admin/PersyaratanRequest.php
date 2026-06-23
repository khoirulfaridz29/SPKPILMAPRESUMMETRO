<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class PersyaratanRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'nama_syarat' => 'required|string|max:255',
            'keterangan'  => 'nullable|string',
            'is_required' => 'required|boolean',
        ];
    }
}

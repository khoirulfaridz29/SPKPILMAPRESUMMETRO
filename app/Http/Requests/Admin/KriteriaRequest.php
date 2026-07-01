<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class KriteriaRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'jenjang_id'        => 'required|exists:jenjang,id',
            'kode_kriteria'     => [
                'required', 'string', 'max:50',
                Rule::unique('kriteria_penilaian', 'kode_kriteria')->ignore($this->kriteria),
            ],
            'nama_kriteria'     => 'required|string|max:255',
            'custom_nama_kriteria' => 'nullable|string|max:255',
            'jenis_faktor'      => 'required|in:Tahap Awal,Tahap Final',
            'tipe_faktor'       => 'required|in:Core Factor,Secondary Factor',
            'nilai_target'      => 'required|integer|min:1|max:5',
            'bobot'             => 'required|numeric|min:0|max:100',
        ];
    }
}

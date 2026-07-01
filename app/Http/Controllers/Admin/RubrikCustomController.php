<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\RubrikCustomTemplate;
use App\Models\RubrikCustomTemplateField;
use Illuminate\Http\Request;

class RubrikCustomController extends Controller
{
    public function index()
    {
        $templates = RubrikCustomTemplate::with('fields')->orderBy('id')->get();
        return view('admin.rubrik_custom.index', compact('templates'));
    }

    public function create()
    {
        return view('admin.rubrik_custom.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'nama_template' => 'required|string|max:255',
            'fields' => 'required|array|min:1',
            'fields.*.nama_field' => 'required|string|max:255',
            'fields.*.tipe_input' => 'required|in:text,number,textarea,score_range',
            'fields.*.urutan' => 'nullable|integer|min:0',
            'fields.*.bobot' => 'nullable|numeric|min:0|max:100',
        ]);

        $template = RubrikCustomTemplate::create(['nama_template' => $data['nama_template']]);

        foreach ($data['fields'] as $i => $field) {
            $template->fields()->create([
                'nama_field' => $field['nama_field'],
                'tipe_input' => $field['tipe_input'],
                'urutan' => $field['urutan'] ?? $i,
                'bobot' => $field['bobot'] ?? null,
            ]);
        }

        return redirect()->route('admin.rubrik-custom.index')->with('success', 'Template rubrik custom berhasil dibuat.');
    }

    public function edit(RubrikCustomTemplate $rubrik_custom_template)
    {
        $template = $rubrik_custom_template->load('fields');
        return view('admin.rubrik_custom.edit', compact('template'));
    }

    public function update(Request $request, RubrikCustomTemplate $rubrik_custom_template)
    {
        $data = $request->validate([
            'nama_template' => 'required|string|max:255',
            'fields' => 'required|array|min:1',
            'fields.*.nama_field' => 'required|string|max:255',
            'fields.*.tipe_input' => 'required|in:text,number,textarea,score_range',
            'fields.*.urutan' => 'nullable|integer|min:0',
            'fields.*.bobot' => 'nullable|numeric|min:0|max:100',
        ]);

        $rubrik_custom_template->update(['nama_template' => $data['nama_template']]);
        $rubrik_custom_template->fields()->delete();

        foreach ($data['fields'] as $i => $field) {
            $rubrik_custom_template->fields()->create([
                'nama_field' => $field['nama_field'],
                'tipe_input' => $field['tipe_input'],
                'urutan' => $field['urutan'] ?? $i,
                'bobot' => $field['bobot'] ?? null,
            ]);
        }

        return redirect()->route('admin.rubrik-custom.index')->with('success', 'Template rubrik custom berhasil diperbarui.');
    }

    public function destroy(RubrikCustomTemplate $rubrik_custom_template)
    {
        $rubrik_custom_template->delete();
        return redirect()->route('admin.rubrik-custom.index')->with('success', 'Template rubrik custom berhasil dihapus.');
    }
}

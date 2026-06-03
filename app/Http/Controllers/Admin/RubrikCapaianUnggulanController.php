<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\RubrikCapaianUnggulan;

class RubrikCapaianUnggulanController extends Controller
{
    public function index()
    {
        $rubriks = RubrikCapaianUnggulan::orderBy('id', 'asc')->get();
        return view('admin.rubrik_cu.index', compact('rubriks'));
    }

    public function create()
    {
        return view('admin.rubrik_cu.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'bidang' => 'required|string|max:255',
            'wujud_capaian_unggulan' => 'required|string|max:255',
            'kode_internasional' => 'nullable|string|max:50',
            'skor_internasional' => 'nullable|string|max:50',
            'kode_regional' => 'nullable|string|max:50',
            'skor_regional' => 'nullable|string|max:50',
            'kode_nasional' => 'nullable|string|max:50',
            'skor_nasional' => 'nullable|string|max:50',
            'kode_provinsi' => 'nullable|string|max:50',
            'skor_provinsi' => 'nullable|string|max:50',
            'kode_kab_kota' => 'nullable|string|max:50',
            'skor_kab_kota' => 'nullable|string|max:50',
        ]);

        RubrikCapaianUnggulan::create($data);
        return redirect()->route('admin.rubrik-cu.index')->with('success', 'Data rubrik berhasil ditambahkan.');
    }

    public function show(string $id)
    {
        //
    }

    public function edit(string $id)
    {
        $rubrik = RubrikCapaianUnggulan::findOrFail($id);
        return view('admin.rubrik_cu.edit', compact('rubrik'));
    }

    public function update(Request $request, string $id)
    {
        $data = $request->validate([
            'bidang' => 'required|string|max:255',
            'wujud_capaian_unggulan' => 'required|string|max:255',
            'kode_internasional' => 'nullable|string|max:50',
            'skor_internasional' => 'nullable|string|max:50',
            'kode_regional' => 'nullable|string|max:50',
            'skor_regional' => 'nullable|string|max:50',
            'kode_nasional' => 'nullable|string|max:50',
            'skor_nasional' => 'nullable|string|max:50',
            'kode_provinsi' => 'nullable|string|max:50',
            'skor_provinsi' => 'nullable|string|max:50',
            'kode_kab_kota' => 'nullable|string|max:50',
            'skor_kab_kota' => 'nullable|string|max:50',
        ]);

        $rubrik = RubrikCapaianUnggulan::findOrFail($id);
        $rubrik->update($data);
        return redirect()->route('admin.rubrik-cu.index')->with('success', 'Data rubrik berhasil diperbarui.');
    }

    public function destroy(string $id)
    {
        $rubrik = RubrikCapaianUnggulan::findOrFail($id);
        $rubrik->delete();
        return redirect()->route('admin.rubrik-cu.index')->with('success', 'Data rubrik berhasil dihapus.');
    }
}

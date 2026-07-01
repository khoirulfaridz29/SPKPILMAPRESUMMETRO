<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\RubrikCapaianUnggulan;
use App\Models\Jenjang;

class RubrikCapaianUnggulanController extends Controller
{
    public function index(Request $request)
    {
        $query = RubrikCapaianUnggulan::query();
        if ($request->filled('jenjang_id')) {
            $query->where('jenjang_id', $request->jenjang_id);
        }
        $rubriks = $query->with('jenjang')->orderBy('id', 'asc')->get();
        return view('admin.rubrik_cu.index', compact('rubriks'));
    }

    public function create()
    {
        $jenjangs = Jenjang::orderBy('id')->get();
        return view('admin.rubrik_cu.create', compact('jenjangs'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'jenjang_id' => 'required|exists:jenjang,id',
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
        $jenjangs = Jenjang::orderBy('id')->get();
        return view('admin.rubrik_cu.edit', compact('rubrik', 'jenjangs'));
    }

    public function update(Request $request, string $id)
    {
        $data = $request->validate([
            'jenjang_id' => 'required|exists:jenjang,id',
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

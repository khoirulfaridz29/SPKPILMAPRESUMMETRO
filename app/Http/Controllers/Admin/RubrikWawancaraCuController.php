<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\RubrikWawancaraCu;
use Illuminate\Http\Request;

class RubrikWawancaraCuController extends Controller
{
    public function index()
    {
        $rubriks = RubrikWawancaraCu::all();
        return view('admin.rubrik_wawancara_cu.index', compact('rubriks'));
    }

    public function create()
    {
        return view('admin.rubrik_wawancara_cu.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'kriteria_penilaian' => 'required|string|max:255',
            'bobot' => 'required|numeric|min:1',
        ]);

        RubrikWawancaraCu::create($request->all());

        return redirect()->route('admin.rubrik-wawancara-cu.index')->with('success', 'Rubrik Wawancara CU berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $rubrik = RubrikWawancaraCu::findOrFail($id);
        return view('admin.rubrik_wawancara_cu.edit', compact('rubrik'));
    }

    public function update(Request $request, $id)
    {
        $rubrik = RubrikWawancaraCu::findOrFail($id);
        $request->validate([
            'kriteria_penilaian' => 'required|string|max:255',
            'bobot' => 'required|numeric|min:1',
        ]);

        $rubrik->update($request->all());

        return redirect()->route('admin.rubrik-wawancara-cu.index')->with('success', 'Rubrik Wawancara CU berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $rubrik = RubrikWawancaraCu::findOrFail($id);
        $rubrik->delete();
        return redirect()->route('admin.rubrik-wawancara-cu.index')->with('success', 'Rubrik Wawancara CU berhasil dihapus.');
    }
}

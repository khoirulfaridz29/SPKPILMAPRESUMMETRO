<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\RubrikNaskahGk;
use Illuminate\Http\Request;

class RubrikNaskahGkController extends Controller
{
    public function index()
    {
        $rubriks = RubrikNaskahGk::all();
        return view('admin.rubrik_naskah_gk.index', compact('rubriks'));
    }

    public function create()
    {
        return view('admin.rubrik_naskah_gk.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'aspek_penilaian' => 'required|string|max:255',
            'kriteria_penilaian' => 'required|string|max:255',
            'bobot' => 'required|numeric|min:1',
        ]);

        RubrikNaskahGk::create($request->all());

        return redirect()->route('admin.rubrik-naskah-gk.index')->with('success', 'Rubrik Naskah GK berhasil ditambahkan.');
    }

    public function edit(RubrikNaskahGk $rubrik_naskah_gk)
    {
        return view('admin.rubrik_naskah_gk.edit', compact('rubrik_naskah_gk'));
    }

    public function update(Request $request, RubrikNaskahGk $rubrik_naskah_gk)
    {
        $request->validate([
            'aspek_penilaian' => 'required|string|max:255',
            'kriteria_penilaian' => 'required|string|max:255',
            'bobot' => 'required|numeric|min:1',
        ]);

        $rubrik_naskah_gk->update($request->all());

        return redirect()->route('admin.rubrik-naskah-gk.index')->with('success', 'Rubrik Naskah GK berhasil diperbarui.');
    }

    public function destroy(RubrikNaskahGk $rubrik_naskah_gk)
    {
        $rubrik_naskah_gk->delete();
        return redirect()->route('admin.rubrik-naskah-gk.index')->with('success', 'Rubrik Naskah GK berhasil dihapus.');
    }
}

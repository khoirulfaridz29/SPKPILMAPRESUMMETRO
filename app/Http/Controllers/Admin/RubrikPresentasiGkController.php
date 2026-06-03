<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\RubrikPresentasiGk;
use Illuminate\Http\Request;

class RubrikPresentasiGkController extends Controller
{
    public function index()
    {
        $rubriks = RubrikPresentasiGk::all();
        return view('admin.rubrik_presentasi_gk.index', compact('rubriks'));
    }

    public function create()
    {
        return view('admin.rubrik_presentasi_gk.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'aspek_penilaian' => 'required|string|max:255',
            'kriteria_penilaian' => 'required|string|max:255',
            'bobot' => 'required|numeric|min:1',
        ]);

        RubrikPresentasiGk::create($request->all());

        return redirect()->route('admin.rubrik-presentasi-gk.index')->with('success', 'Rubrik Presentasi GK berhasil ditambahkan.');
    }

    public function edit(RubrikPresentasiGk $rubrik_presentasi_gk)
    {
        return view('admin.rubrik_presentasi_gk.edit', compact('rubrik_presentasi_gk'));
    }

    public function update(Request $request, RubrikPresentasiGk $rubrik_presentasi_gk)
    {
        $request->validate([
            'aspek_penilaian' => 'required|string|max:255',
            'kriteria_penilaian' => 'required|string|max:255',
            'bobot' => 'required|numeric|min:1',
        ]);

        $rubrik_presentasi_gk->update($request->all());

        return redirect()->route('admin.rubrik-presentasi-gk.index')->with('success', 'Rubrik Presentasi GK berhasil diperbarui.');
    }

    public function destroy(RubrikPresentasiGk $rubrik_presentasi_gk)
    {
        $rubrik_presentasi_gk->delete();
        return redirect()->route('admin.rubrik-presentasi-gk.index')->with('success', 'Rubrik Presentasi GK berhasil dihapus.');
    }
}

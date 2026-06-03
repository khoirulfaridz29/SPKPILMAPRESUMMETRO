<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Persyaratan;
use Illuminate\Http\Request;

class PersyaratanController extends Controller
{
    public function index()
    {
        $persyaratan = Persyaratan::all();
        return view('admin.persyaratan.index', compact('persyaratan'));
    }

    public function create()
    {
        return view('admin.persyaratan.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_syarat' => 'required|string|max:255',
            'keterangan'  => 'nullable|string',
            'is_required' => 'required|boolean',
        ]);

        Persyaratan::create($request->all());

        return redirect()->route('admin.persyaratan.index')->with('success', 'Persyaratan berhasil ditambahkan.');
    }

    public function edit(Persyaratan $persyaratan)
    {
        return view('admin.persyaratan.edit', compact('persyaratan'));
    }

    public function update(Request $request, Persyaratan $persyaratan)
    {
        $request->validate([
            'nama_syarat' => 'required|string|max:255',
            'keterangan'  => 'nullable|string',
            'is_required' => 'required|boolean',
        ]);

        $persyaratan->update($request->all());

        return redirect()->route('admin.persyaratan.index')->with('success', 'Persyaratan berhasil diperbarui.');
    }

    public function destroy(Persyaratan $persyaratan)
    {
        $persyaratan->delete();
        return redirect()->route('admin.persyaratan.index')->with('success', 'Persyaratan berhasil dihapus.');
    }
}

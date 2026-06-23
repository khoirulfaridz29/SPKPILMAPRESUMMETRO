<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\PersyaratanRequest;
use App\Models\Persyaratan;

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

    public function store(PersyaratanRequest $request)
    {
        Persyaratan::create($request->validated());

        return redirect()->route('admin.persyaratan.index')->with('success', 'Persyaratan berhasil ditambahkan.');
    }

    public function edit(Persyaratan $persyaratan)
    {
        return view('admin.persyaratan.edit', compact('persyaratan'));
    }

    public function update(PersyaratanRequest $request, Persyaratan $persyaratan)
    {
        $persyaratan->update($request->validated());

        return redirect()->route('admin.persyaratan.index')->with('success', 'Persyaratan berhasil diperbarui.');
    }

    public function destroy(Persyaratan $persyaratan)
    {
        $persyaratan->delete();
        return redirect()->route('admin.persyaratan.index')->with('success', 'Persyaratan berhasil dihapus.');
    }
}

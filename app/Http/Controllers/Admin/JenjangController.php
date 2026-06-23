<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\JenjangRequest;
use App\Models\Jenjang;
use App\Models\KriteriaPenilaian;

class JenjangController extends Controller
{
    public function index()
    {
        $jenjang = Jenjang::orderBy('id')->get();
        return view('admin.jenjang.index', compact('jenjang'));
    }

    public function create()
    {
        return view('admin.jenjang.create');
    }

    public function store(JenjangRequest $request)
    {
        Jenjang::create($request->validated());
        return redirect()->route('admin.jenjang.index')->with('success', 'Jenjang berhasil ditambahkan.');
    }

    public function edit(Jenjang $jenjang)
    {
        return view('admin.jenjang.edit', compact('jenjang'));
    }

    public function update(JenjangRequest $request, Jenjang $jenjang)
    {
        $jenjang->update($request->validated());
        return redirect()->route('admin.jenjang.index')->with('success', 'Jenjang berhasil diperbarui.');
    }

    public function destroy(Jenjang $jenjang)
    {
        if ($jenjang->mahasiswas()->exists()) {
            return back()->with('error', 'Jenjang tidak bisa dihapus karena masih memiliki mahasiswa terdaftar.');
        }
        if (KriteriaPenilaian::where('jenjang_id', $jenjang->id)->exists()) {
            KriteriaPenilaian::where('jenjang_id', $jenjang->id)->delete();
        }
        $jenjang->delete();
        return redirect()->route('admin.jenjang.index')->with('success', 'Jenjang berhasil dihapus.');
    }
}

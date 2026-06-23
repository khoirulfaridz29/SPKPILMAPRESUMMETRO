<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\RubrikBahasaInggrisRequest;
use App\Models\RubrikBahasaInggris;
use Illuminate\Http\Request;
use App\Models\Jenjang;

class RubrikBahasaInggrisController extends Controller
{
    public function index(Request $request)
    {
        $query = RubrikBahasaInggris::query();
        if ($request->filled('jenjang_id')) {
            $query->where('jenjang_id', $request->jenjang_id);
        }
        $rubriks = $query->with('jenjang')->get();
        $jenjangs = Jenjang::orderBy('id')->get();
        return view('admin.rubrik_bahasa_inggris.index', compact('rubriks', 'jenjangs'));
    }

    public function create()
    {
        $jenjangs = Jenjang::orderBy('id')->get();
        return view('admin.rubrik_bahasa_inggris.create', compact('jenjangs'));
    }

    public function store(RubrikBahasaInggrisRequest $request)
    {
        RubrikBahasaInggris::create($request->validated());

        return redirect()->route('admin.rubrik-bahasa-inggris.index')->with('success', 'Rubrik Bahasa Inggris berhasil ditambahkan.');
    }

    public function edit(RubrikBahasaInggris $rubrik_bahasa_inggri)
    {
        $jenjangs = Jenjang::orderBy('id')->get();
        return view('admin.rubrik_bahasa_inggris.edit', compact('rubrik_bahasa_inggri', 'jenjangs'));
    }

    public function update(RubrikBahasaInggrisRequest $request, RubrikBahasaInggris $rubrik_bahasa_inggri)
    {
        $rubrik_bahasa_inggri->update($request->validated());

        return redirect()->route('admin.rubrik-bahasa-inggris.index')->with('success', 'Rubrik Bahasa Inggris berhasil diperbarui.');
    }

    public function destroy(RubrikBahasaInggris $rubrik_bahasa_inggri)
    {
        $rubrik_bahasa_inggri->delete();
        return redirect()->route('admin.rubrik-bahasa-inggris.index')->with('success', 'Rubrik Bahasa Inggris berhasil dihapus.');
    }
}

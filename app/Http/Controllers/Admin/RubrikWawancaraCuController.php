<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\RubrikWawancaraCuRequest;
use App\Models\RubrikWawancaraCu;
use Illuminate\Http\Request;
use App\Models\Jenjang;

class RubrikWawancaraCuController extends Controller
{
    public function index(Request $request)
    {
        $query = RubrikWawancaraCu::query();
        if ($request->filled('jenjang_id')) {
            $query->where('jenjang_id', $request->jenjang_id);
        }
        $rubriks = $query->with('jenjang')->get();
        $jenjangs = Jenjang::orderBy('id')->get();
        return view('admin.rubrik_wawancara_cu.index', compact('rubriks', 'jenjangs'));
    }

    public function create()
    {
        $jenjangs = Jenjang::orderBy('id')->get();
        return view('admin.rubrik_wawancara_cu.create', compact('jenjangs'));
    }

    public function store(RubrikWawancaraCuRequest $request)
    {
        RubrikWawancaraCu::create($request->validated());

        return redirect()->route('admin.rubrik-wawancara-cu.index')->with('success', 'Rubrik Wawancara CU berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $rubrik = RubrikWawancaraCu::findOrFail($id);
        $jenjangs = Jenjang::orderBy('id')->get();
        return view('admin.rubrik_wawancara_cu.edit', compact('rubrik', 'jenjangs'));
    }

    public function update(RubrikWawancaraCuRequest $request, $id)
    {
        $rubrik = RubrikWawancaraCu::findOrFail($id);
        $rubrik->update($request->validated());

        return redirect()->route('admin.rubrik-wawancara-cu.index')->with('success', 'Rubrik Wawancara CU berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $rubrik = RubrikWawancaraCu::findOrFail($id);
        $rubrik->delete();
        return redirect()->route('admin.rubrik-wawancara-cu.index')->with('success', 'Rubrik Wawancara CU berhasil dihapus.');
    }
}

<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\RubrikNaskahGkRequest;
use App\Models\RubrikNaskahGk;
use Illuminate\Http\Request;
use App\Models\Jenjang;

class RubrikNaskahGkController extends Controller
{
    public function index(Request $request)
    {
        $query = RubrikNaskahGk::query();
        if ($request->filled('jenjang_id')) {
            $query->where('jenjang_id', $request->jenjang_id);
        }
        $rubriks = $query->with('jenjang')->get();
        $jenjangs = Jenjang::orderBy('id')->get();
        return view('admin.rubrik_naskah_gk.index', compact('rubriks', 'jenjangs'));
    }

    public function create()
    {
        $jenjangs = Jenjang::orderBy('id')->get();
        return view('admin.rubrik_naskah_gk.create', compact('jenjangs'));
    }

    public function store(RubrikNaskahGkRequest $request)
    {
        RubrikNaskahGk::create($request->validated());

        return redirect()->route('admin.rubrik-naskah-gk.index')->with('success', 'Rubrik Naskah GK berhasil ditambahkan.');
    }

    public function edit(RubrikNaskahGk $rubrik_naskah_gk)
    {
        $jenjangs = Jenjang::orderBy('id')->get();
        return view('admin.rubrik_naskah_gk.edit', compact('rubrik_naskah_gk', 'jenjangs'));
    }

    public function update(RubrikNaskahGkRequest $request, RubrikNaskahGk $rubrik_naskah_gk)
    {
        $rubrik_naskah_gk->update($request->validated());

        return redirect()->route('admin.rubrik-naskah-gk.index')->with('success', 'Rubrik Naskah GK berhasil diperbarui.');
    }

    public function destroy(RubrikNaskahGk $rubrik_naskah_gk)
    {
        $rubrik_naskah_gk->delete();
        return redirect()->route('admin.rubrik-naskah-gk.index')->with('success', 'Rubrik Naskah GK berhasil dihapus.');
    }
}

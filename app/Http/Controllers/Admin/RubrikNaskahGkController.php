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
        return view('admin.rubrik_naskah_gk.index', compact('rubriks'));
    }

    public function create()
    {
        $jenjangs = Jenjang::orderBy('id')->get();
        return view('admin.rubrik_naskah_gk.create', compact('jenjangs'));
    }

    public function store(RubrikNaskahGkRequest $request)
    {
        $data = $request->validated();
        $data['label'] = $this->resolveLabel($request);

        RubrikNaskahGk::create($data);

        return redirect()->route('admin.rubrik-naskah-gk.index')->with('success', 'Rubrik Naskah GK berhasil ditambahkan.');
    }

    public function edit(RubrikNaskahGk $rubrik_naskah_gk)
    {
        $jenjangs = Jenjang::orderBy('id')->get();
        return view('admin.rubrik_naskah_gk.edit', compact('rubrik_naskah_gk', 'jenjangs'));
    }

    private function resolveLabel($request)
    {
        if ($request->filled('label_select') && $request->label_select !== '__custom__') {
            return $request->label_select;
        }
        return $request->label_select === '__custom__' ? ($request->label ?: null) : null;
    }

    public function update(RubrikNaskahGkRequest $request, RubrikNaskahGk $rubrik_naskah_gk)
    {
        $data = $request->validated();
        $data['label'] = $this->resolveLabel($request);

        $rubrik_naskah_gk->update($data);

        return redirect()->route('admin.rubrik-naskah-gk.index')->with('success', 'Rubrik Naskah GK berhasil diperbarui.');
    }

    public function destroy(RubrikNaskahGk $rubrik_naskah_gk)
    {
        $rubrik_naskah_gk->delete();
        return redirect()->route('admin.rubrik-naskah-gk.index')->with('success', 'Rubrik Naskah GK berhasil dihapus.');
    }
}

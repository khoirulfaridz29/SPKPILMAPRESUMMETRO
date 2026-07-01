<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\RubrikNaskahGkRequest;
use App\Models\RubrikNaskahGk;
use Illuminate\Http\Request;
use App\Models\Jenjang;
use App\Models\KriteriaPenilaian;

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
        $kriterias = collect();
        return view('admin.rubrik_naskah_gk.create', compact('jenjangs', 'kriterias'));
    }

    public function store(RubrikNaskahGkRequest $request)
    {
        $data = $request->validated();
        if (!empty($data['kriteria_id'])) {
            $kriteria = KriteriaPenilaian::find($data['kriteria_id']);
            $data['label'] = $kriteria?->nama_kriteria;
        }

        RubrikNaskahGk::create($data);

        return redirect()->route('admin.rubrik-naskah-gk.index')->with('success', 'Rubrik Naskah GK berhasil ditambahkan.');
    }

    public function edit(RubrikNaskahGk $rubrik_naskah_gk)
    {
        $jenjangs = Jenjang::orderBy('id')->get();
        $kriterias = KriteriaPenilaian::where('jenjang_id', $rubrik_naskah_gk->jenjang_id)->get()
            ->filter(fn($k) => $k->tipe_kriteria === 'naskah_gk');
        return view('admin.rubrik_naskah_gk.edit', compact('rubrik_naskah_gk', 'jenjangs', 'kriterias'));
    }

    public function update(RubrikNaskahGkRequest $request, RubrikNaskahGk $rubrik_naskah_gk)
    {
        $data = $request->validated();
        if (!empty($data['kriteria_id'])) {
            $kriteria = KriteriaPenilaian::find($data['kriteria_id']);
            $data['label'] = $kriteria?->nama_kriteria;
        }

        $rubrik_naskah_gk->update($data);

        return redirect()->route('admin.rubrik-naskah-gk.index')->with('success', 'Rubrik Naskah GK berhasil diperbarui.');
    }

    public function destroy(RubrikNaskahGk $rubrik_naskah_gk)
    {
        $rubrik_naskah_gk->delete();
        return redirect()->route('admin.rubrik-naskah-gk.index')->with('success', 'Rubrik Naskah GK berhasil dihapus.');
    }
}

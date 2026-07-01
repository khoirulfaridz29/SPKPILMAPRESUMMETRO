<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\RubrikPresentasiGkRequest;
use App\Models\RubrikPresentasiGk;
use Illuminate\Http\Request;
use App\Models\Jenjang;
use App\Models\KriteriaPenilaian;

class RubrikPresentasiGkController extends Controller
{
    public function index(Request $request)
    {
        $query = RubrikPresentasiGk::query();
        if ($request->filled('jenjang_id')) {
            $query->where('jenjang_id', $request->jenjang_id);
        }
        $rubriks = $query->with('jenjang')->get();
        return view('admin.rubrik_presentasi_gk.index', compact('rubriks'));
    }

    public function create()
    {
        $jenjangs = Jenjang::orderBy('id')->get();
        $kriterias = collect();
        return view('admin.rubrik_presentasi_gk.create', compact('jenjangs', 'kriterias'));
    }

    public function store(RubrikPresentasiGkRequest $request)
    {
        $data = $request->validated();
        if (!empty($data['kriteria_id'])) {
            $kriteria = KriteriaPenilaian::find($data['kriteria_id']);
            $data['label'] = $kriteria?->nama_kriteria;
        }

        RubrikPresentasiGk::create($data);

        return redirect()->route('admin.rubrik-presentasi-gk.index')->with('success', 'Rubrik Presentasi GK berhasil ditambahkan.');
    }

    public function edit(RubrikPresentasiGk $rubrik_presentasi_gk)
    {
        $jenjangs = Jenjang::orderBy('id')->get();
        $kriterias = KriteriaPenilaian::where('jenjang_id', $rubrik_presentasi_gk->jenjang_id)->get()
            ->filter(fn($k) => $k->tipe_kriteria === 'presentasi_gk');
        return view('admin.rubrik_presentasi_gk.edit', compact('rubrik_presentasi_gk', 'jenjangs', 'kriterias'));
    }

    public function update(RubrikPresentasiGkRequest $request, RubrikPresentasiGk $rubrik_presentasi_gk)
    {
        $data = $request->validated();
        if (!empty($data['kriteria_id'])) {
            $kriteria = KriteriaPenilaian::find($data['kriteria_id']);
            $data['label'] = $kriteria?->nama_kriteria;
        }

        $rubrik_presentasi_gk->update($data);

        return redirect()->route('admin.rubrik-presentasi-gk.index')->with('success', 'Rubrik Presentasi GK berhasil diperbarui.');
    }

    public function destroy(RubrikPresentasiGk $rubrik_presentasi_gk)
    {
        $rubrik_presentasi_gk->delete();
        return redirect()->route('admin.rubrik-presentasi-gk.index')->with('success', 'Rubrik Presentasi GK berhasil dihapus.');
    }
}

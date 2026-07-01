<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\RubrikBahasaInggrisRequest;
use App\Models\RubrikBahasaInggris;
use Illuminate\Http\Request;
use App\Models\Jenjang;
use App\Models\KriteriaPenilaian;

class RubrikBahasaInggrisController extends Controller
{
    public function index(Request $request)
    {
        $query = RubrikBahasaInggris::query();
        if ($request->filled('jenjang_id')) {
            $query->where('jenjang_id', $request->jenjang_id);
        }
        $rubriks = $query->with('jenjang')->get();
        return view('admin.rubrik_bahasa_inggris.index', compact('rubriks'));
    }

    public function create()
    {
        $jenjangs = Jenjang::orderBy('id')->get();
        $kriterias = collect();
        return view('admin.rubrik_bahasa_inggris.create', compact('jenjangs', 'kriterias'));
    }

    public function store(RubrikBahasaInggrisRequest $request)
    {
        $data = $request->validated();
        if (!empty($data['kriteria_id'])) {
            $kriteria = KriteriaPenilaian::find($data['kriteria_id']);
            $data['label'] = $kriteria?->nama_kriteria;
        }

        RubrikBahasaInggris::create($data);

        return redirect()->route('admin.rubrik-bahasa-inggris.index')->with('success', 'Rubrik Bahasa Inggris berhasil ditambahkan.');
    }

    public function edit(RubrikBahasaInggris $rubrik_bahasa_inggri)
    {
        $jenjangs = Jenjang::orderBy('id')->get();
        $kriterias = KriteriaPenilaian::where('jenjang_id', $rubrik_bahasa_inggri->jenjang_id)->get()
            ->filter(fn($k) => in_array($k->tipe_kriteria, ['bahasa_inggris', 'custom']));
        return view('admin.rubrik_bahasa_inggris.edit', compact('rubrik_bahasa_inggri', 'jenjangs', 'kriterias'));
    }

    public function update(RubrikBahasaInggrisRequest $request, RubrikBahasaInggris $rubrik_bahasa_inggri)
    {
        $data = $request->validated();
        if (!empty($data['kriteria_id'])) {
            $kriteria = KriteriaPenilaian::find($data['kriteria_id']);
            $data['label'] = $kriteria?->nama_kriteria;
        }

        $rubrik_bahasa_inggri->update($data);

        return redirect()->route('admin.rubrik-bahasa-inggris.index')->with('success', 'Rubrik Bahasa Inggris berhasil diperbarui.');
    }

    public function destroy(RubrikBahasaInggris $rubrik_bahasa_inggri)
    {
        $rubrik_bahasa_inggri->delete();
        return redirect()->route('admin.rubrik-bahasa-inggris.index')->with('success', 'Rubrik Bahasa Inggris berhasil dihapus.');
    }
}

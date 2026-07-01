<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\RubrikWawancaraCuRequest;
use App\Models\RubrikWawancaraCu;
use Illuminate\Http\Request;
use App\Models\Jenjang;
use App\Models\KriteriaPenilaian;

class RubrikWawancaraCuController extends Controller
{
    public function index(Request $request)
    {
        $query = RubrikWawancaraCu::query();
        if ($request->filled('jenjang_id')) {
            $query->where('jenjang_id', $request->jenjang_id);
        }
        $rubriks = $query->with('jenjang')->get();
        return view('admin.rubrik_wawancara_cu.index', compact('rubriks'));
    }

    public function create()
    {
        $jenjangs = Jenjang::orderBy('id')->get();
        $kriterias = collect();
        return view('admin.rubrik_wawancara_cu.create', compact('jenjangs', 'kriterias'));
    }

    public function store(RubrikWawancaraCuRequest $request)
    {
        $data = $request->validated();
        if (!empty($data['kriteria_id'])) {
            $kriteria = KriteriaPenilaian::find($data['kriteria_id']);
            $data['label'] = $kriteria?->nama_kriteria;
        }

        RubrikWawancaraCu::create($data);

        return redirect()->route('admin.rubrik-wawancara-cu.index')->with('success', 'Rubrik Wawancara CU berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $rubrik = RubrikWawancaraCu::findOrFail($id);
        $jenjangs = Jenjang::orderBy('id')->get();
        $kriterias = KriteriaPenilaian::where('jenjang_id', $rubrik->jenjang_id)->get()
            ->filter(fn($k) => $k->tipe_kriteria === 'wawancara_cu');
        return view('admin.rubrik_wawancara_cu.edit', compact('rubrik', 'jenjangs', 'kriterias'));
    }

    public function update(RubrikWawancaraCuRequest $request, $id)
    {
        $rubrik = RubrikWawancaraCu::findOrFail($id);
        $data = $request->validated();
        if (!empty($data['kriteria_id'])) {
            $kriteria = KriteriaPenilaian::find($data['kriteria_id']);
            $data['label'] = $kriteria?->nama_kriteria;
        }

        $rubrik->update($data);

        return redirect()->route('admin.rubrik-wawancara-cu.index')->with('success', 'Rubrik Wawancara CU berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $rubrik = RubrikWawancaraCu::findOrFail($id);
        $rubrik->delete();
        return redirect()->route('admin.rubrik-wawancara-cu.index')->with('success', 'Rubrik Wawancara CU berhasil dihapus.');
    }
}

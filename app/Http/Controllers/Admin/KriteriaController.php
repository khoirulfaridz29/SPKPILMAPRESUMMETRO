<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\KriteriaRequest;
use App\Models\KriteriaPenilaian;
use App\Models\Jenjang;
use Illuminate\Http\Request;

class KriteriaController extends Controller
{
    public function index(Request $request)
    {
        $query = KriteriaPenilaian::orderBy('jenis_faktor');
        if ($request->filled('jenjang_id')) {
            $query->where('jenjang_id', $request->jenjang_id);
        }
        $kriterias = $query->with('jenjang')->get();
        $jenjangs = Jenjang::orderBy('id')->get();
        return view('admin.kriteria.index', compact('kriterias', 'jenjangs'));
    }

    public function create()
    {
        $jenjangs = Jenjang::orderBy('id')->get();
        return view('admin.kriteria.create', compact('jenjangs'));
    }

    public function store(KriteriaRequest $request)
    {
        KriteriaPenilaian::create($request->validated());
        return redirect()->route('admin.kriteria.index')->with('success', 'Kriteria berhasil ditambahkan.');
    }

    public function edit(KriteriaPenilaian $kriteria)
    {
        $jenjangs = Jenjang::orderBy('id')->get();
        return view('admin.kriteria.edit', compact('kriteria', 'jenjangs'));
    }

    public function update(KriteriaRequest $request, KriteriaPenilaian $kriteria)
    {
        $kriteria->update($request->validated());
        return redirect()->route('admin.kriteria.index')->with('success', 'Kriteria berhasil diperbarui.');
    }

    public function destroy(KriteriaPenilaian $kriteria)
    {
        $kriteria->delete();
        return redirect()->route('admin.kriteria.index')->with('success', 'Kriteria berhasil dihapus.');
    }
}

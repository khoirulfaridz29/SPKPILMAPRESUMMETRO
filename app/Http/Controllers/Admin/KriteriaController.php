<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\KriteriaPenilaian;
use Illuminate\Http\Request;

class KriteriaController extends Controller
{
    public function index()
    {
        try {
            $columns = \Illuminate\Support\Facades\Schema::getColumnListing('kriteria_penilaian');
            if (!in_array('tipe_faktor', $columns)) {
                \Illuminate\Support\Facades\DB::statement("ALTER TABLE kriteria_penilaian ADD COLUMN tipe_faktor ENUM('Core Factor', 'Secondary Factor') NOT NULL DEFAULT 'Core Factor'");
                \Illuminate\Support\Facades\DB::statement("UPDATE kriteria_penilaian SET tipe_faktor = 'Secondary Factor' WHERE kode_kriteria IN ('A03', 'F03')");
            }
        } catch (\Exception $e) {
            // Ignore
        }

        $kriterias = KriteriaPenilaian::orderBy('jenis_faktor')->get();
        return view('admin.kriteria.index', compact('kriterias'));
    }

    public function create()
    {
        return view('admin.kriteria.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'kode_kriteria' => 'required|string|max:50|unique:kriteria_penilaian',
            'nama_kriteria' => 'required|string|max:255',
            'jenis_faktor'  => 'required|in:Tahap Awal,Tahap Final',
            'tipe_faktor'   => 'required|in:Core Factor,Secondary Factor',
            'nilai_target'  => 'required|integer|min:1|max:5',
            'bobot'         => 'required|numeric|min:0|max:100',
        ]);

        KriteriaPenilaian::create($request->all());
        return redirect()->route('admin.kriteria.index')->with('success', 'Kriteria berhasil ditambahkan.');
    }

    public function edit(KriteriaPenilaian $kriteria)
    {
        return view('admin.kriteria.edit', compact('kriteria'));
    }

    public function update(Request $request, KriteriaPenilaian $kriteria)
    {
        $request->validate([
            'kode_kriteria' => 'required|string|max:50|unique:kriteria_penilaian,kode_kriteria,'.$kriteria->id,
            'nama_kriteria' => 'required|string|max:255',
            'jenis_faktor'  => 'required|in:Tahap Awal,Tahap Final',
            'tipe_faktor'   => 'required|in:Core Factor,Secondary Factor',
            'nilai_target'  => 'required|integer|min:1|max:5',
            'bobot'         => 'required|numeric|min:0|max:100',
        ]);

        $kriteria->update($request->all());
        return redirect()->route('admin.kriteria.index')->with('success', 'Kriteria berhasil diperbarui.');
    }

    public function destroy(KriteriaPenilaian $kriteria)
    {
        $kriteria->delete();
        return redirect()->route('admin.kriteria.index')->with('success', 'Kriteria berhasil dihapus.');
    }
}

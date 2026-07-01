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
        $data = $request->validated();
        $kodeMap = [
            'Naskah Gagasan Kreatif' => 'A02',
            'Presentasi Gagasan Kreatif' => 'F02',
            'Wawancara Capaian Unggulan' => 'F01',
            'Portofolio Capaian Unggulan' => 'A01',
        ];

        if (isset($kodeMap[$data['nama_kriteria']])) {
            $data['kode_kriteria'] = $kodeMap[$data['nama_kriteria']];
        } elseif ($data['nama_kriteria'] === '__custom__') {
            $data['nama_kriteria'] = $request->custom_nama_kriteria;
        }

        KriteriaPenilaian::create($data);
        return redirect()->route('admin.kriteria.index')->with('success', 'Kriteria berhasil ditambahkan.');
    }

    public function update(KriteriaRequest $request, KriteriaPenilaian $kriteria)
    {
        $data = $request->validated();
        $kodeMap = [
            'Naskah Gagasan Kreatif' => 'A02',
            'Presentasi Gagasan Kreatif' => 'F02',
            'Wawancara Capaian Unggulan' => 'F01',
            'Portofolio Capaian Unggulan' => 'A01',
        ];

        if (isset($kodeMap[$data['nama_kriteria']])) {
            $data['kode_kriteria'] = $kodeMap[$data['nama_kriteria']];
        } elseif ($data['nama_kriteria'] === '__custom__') {
            $data['nama_kriteria'] = $request->custom_nama_kriteria;
        }

        $kriteria->update($data);
        return redirect()->route('admin.kriteria.index')->with('success', 'Kriteria berhasil diperbarui.');
    }

    public function edit(KriteriaPenilaian $kriteria)
    {
        $jenjangs = Jenjang::orderBy('id')->get();
        return view('admin.kriteria.edit', compact('kriteria', 'jenjangs'));
    }

    public function destroy(KriteriaPenilaian $kriteria)
    {
        $kriteria->delete();
        return redirect()->route('admin.kriteria.index')->with('success', 'Kriteria berhasil dihapus.');
    }
}

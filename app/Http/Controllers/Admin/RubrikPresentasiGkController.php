<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\RubrikPresentasiGkRequest;
use App\Models\RubrikPresentasiGk;
use Illuminate\Http\Request;
use App\Models\Jenjang;

class RubrikPresentasiGkController extends Controller
{
    public function index(Request $request)
    {
        $query = RubrikPresentasiGk::query();
        if ($request->filled('jenjang_id')) {
            $query->where('jenjang_id', $request->jenjang_id);
        }
        $rubriks = $query->with('jenjang')->get();
        $jenjangs = Jenjang::orderBy('id')->get();
        return view('admin.rubrik_presentasi_gk.index', compact('rubriks', 'jenjangs'));
    }

    public function create()
    {
        $jenjangs = Jenjang::orderBy('id')->get();
        return view('admin.rubrik_presentasi_gk.create', compact('jenjangs'));
    }

    public function store(RubrikPresentasiGkRequest $request)
    {
        RubrikPresentasiGk::create($request->validated());

        return redirect()->route('admin.rubrik-presentasi-gk.index')->with('success', 'Rubrik Presentasi GK berhasil ditambahkan.');
    }

    public function edit(RubrikPresentasiGk $rubrik_presentasi_gk)
    {
        $jenjangs = Jenjang::orderBy('id')->get();
        return view('admin.rubrik_presentasi_gk.edit', compact('rubrik_presentasi_gk', 'jenjangs'));
    }

    public function update(RubrikPresentasiGkRequest $request, RubrikPresentasiGk $rubrik_presentasi_gk)
    {
        $rubrik_presentasi_gk->update($request->validated());

        return redirect()->route('admin.rubrik-presentasi-gk.index')->with('success', 'Rubrik Presentasi GK berhasil diperbarui.');
    }

    public function destroy(RubrikPresentasiGk $rubrik_presentasi_gk)
    {
        $rubrik_presentasi_gk->delete();
        return redirect()->route('admin.rubrik-presentasi-gk.index')->with('success', 'Rubrik Presentasi GK berhasil dihapus.');
    }
}

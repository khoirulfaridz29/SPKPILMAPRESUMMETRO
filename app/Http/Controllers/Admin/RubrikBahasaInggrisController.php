<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\RubrikBahasaInggris;
use Illuminate\Http\Request;

class RubrikBahasaInggrisController extends Controller
{
    public function index()
    {
        $rubriks = RubrikBahasaInggris::all();
        return view('admin.rubrik_bahasa_inggris.index', compact('rubriks'));
    }

    public function create()
    {
        return view('admin.rubrik_bahasa_inggris.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'field' => 'required|string|max:255',
            'excellent_score' => 'required|string|max:50',
            'excellent_criteria' => 'required|string',
            'good_score' => 'required|string|max:50',
            'good_criteria' => 'required|string',
            'fair_score' => 'required|string|max:50',
            'fair_criteria' => 'required|string',
            'poor_score' => 'required|string|max:50',
            'poor_criteria' => 'required|string',
        ]);

        RubrikBahasaInggris::create($request->all());

        return redirect()->route('admin.rubrik-bahasa-inggris.index')->with('success', 'Rubrik Bahasa Inggris berhasil ditambahkan.');
    }

    public function edit(RubrikBahasaInggris $rubrik_bahasa_inggri)
    {
        return view('admin.rubrik_bahasa_inggris.edit', compact('rubrik_bahasa_inggri'));
    }

    public function update(Request $request, RubrikBahasaInggris $rubrik_bahasa_inggri)
    {
        $request->validate([
            'field' => 'required|string|max:255',
            'excellent_score' => 'required|string|max:50',
            'excellent_criteria' => 'required|string',
            'good_score' => 'required|string|max:50',
            'good_criteria' => 'required|string',
            'fair_score' => 'required|string|max:50',
            'fair_criteria' => 'required|string',
            'poor_score' => 'required|string|max:50',
            'poor_criteria' => 'required|string',
        ]);

        $rubrik_bahasa_inggri->update($request->all());

        return redirect()->route('admin.rubrik-bahasa-inggris.index')->with('success', 'Rubrik Bahasa Inggris berhasil diperbarui.');
    }

    public function destroy(RubrikBahasaInggris $rubrik_bahasa_inggri)
    {
        $rubrik_bahasa_inggri->delete();
        return redirect()->route('admin.rubrik-bahasa-inggris.index')->with('success', 'Rubrik Bahasa Inggris berhasil dihapus.');
    }
}

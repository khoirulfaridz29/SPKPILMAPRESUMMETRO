<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Panduan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PanduanController extends Controller
{
    public function index()
    {
        $panduan = Panduan::orderBy('created_at', 'desc')->get();
        return view('admin.panduan.index', compact('panduan'));
    }

    public function create()
    {
        return view('admin.panduan.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'judul'     => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'file_panduan' => 'required|file|mimes:pdf|max:10240',
        ]);

        $data = $request->except('file_panduan');
        $data['file_path'] = $request->file('file_panduan')->store('panduan', 'public');

        Panduan::create($data);

        return redirect()->route('admin.panduan.index')->with('success', 'Panduan berhasil diunggah.');
    }

    public function edit(Panduan $panduan)
    {
        return view('admin.panduan.edit', compact('panduan'));
    }

    public function update(Request $request, Panduan $panduan)
    {
        $request->validate([
            'judul'     => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'file_panduan' => 'nullable|file|mimes:pdf|max:10240',
        ]);

        $data = $request->except('file_panduan');
        if ($request->hasFile('file_panduan')) {
            if ($panduan->file_path) {
                Storage::disk('public')->delete($panduan->file_path);
            }
            $data['file_path'] = $request->file('file_panduan')->store('panduan', 'public');
        }

        $panduan->update($data);

        return redirect()->route('admin.panduan.index')->with('success', 'Panduan berhasil diperbarui.');
    }

    public function destroy(Panduan $panduan)
    {
        if ($panduan->file_path) {
            Storage::disk('public')->delete($panduan->file_path);
        }
        $panduan->delete();
        return redirect()->route('admin.panduan.index')->with('success', 'Panduan berhasil dihapus.');
    }

    public function download(Panduan $panduan)
    {
        $path = storage_path('app/public/' . $panduan->file_path);
        if (!file_exists($path)) {
            abort(404);
        }
        return response()->download($path, $panduan->judul . '.pdf');
    }
}

<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pengumuman;
use Illuminate\Http\Request;

class PengumumanController extends Controller
{
    public function index()
    {
        $pengumuman = Pengumuman::orderBy('tanggal_publish', 'desc')->get();
        return view('admin.pengumuman.index', compact('pengumuman'));
    }

    public function create()
    {
        return view('admin.pengumuman.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'judul'           => 'required|string|max:255',
            'konten'          => 'required|string',
            'file_pengumuman' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:5120',
            'tanggal_publish' => 'required|date',
        ]);

        $data = $request->except('file_pengumuman');
        if ($request->hasFile('file_pengumuman')) {
            $data['file_path'] = $request->file('file_pengumuman')->store('pengumuman', 'public');
        }

        Pengumuman::create($data);

        return redirect()->route('admin.pengumuman.index')->with('success', 'Pengumuman berhasil diterbitkan.');
    }

    public function edit(Pengumuman $pengumuman)
    {
        return view('admin.pengumuman.edit', compact('pengumuman'));
    }

    public function update(Request $request, Pengumuman $pengumuman)
    {
        $request->validate([
            'judul'           => 'required|string|max:255',
            'konten'          => 'required|string',
            'file_pengumuman' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:5120',
            'tanggal_publish' => 'required|date',
        ]);

        $data = $request->except('file_pengumuman');
        if ($request->hasFile('file_pengumuman')) {
            if ($pengumuman->file_path) {
                \Illuminate\Support\Facades\Storage::disk('public')->delete($pengumuman->file_path);
            }
            $data['file_path'] = $request->file('file_pengumuman')->store('pengumuman', 'public');
        }

        $pengumuman->update($data);

        return redirect()->route('admin.pengumuman.index')->with('success', 'Pengumuman berhasil diperbarui.');
    }

    public function destroy(Pengumuman $pengumuman)
    {
        if ($pengumuman->file_path) {
            \Illuminate\Support\Facades\Storage::disk('public')->delete($pengumuman->file_path);
        }
        $pengumuman->delete();
        return redirect()->route('admin.pengumuman.index')->with('success', 'Pengumuman berhasil dihapus.');
    }
}

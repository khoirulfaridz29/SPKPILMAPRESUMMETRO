@extends('layouts.dashboard')
@section('title', 'Form Pendaftaran')

@section('content')
<div class="mb-4">
    <a href="{{ route('mahasiswa.pendaftaran.index') }}" class="btn btn-sm btn-outline-secondary me-2">
        <i class="fa-solid fa-arrow-left me-1"></i> Kembali
    </a>
    <span class="fw-bold fs-5">Form Pendaftaran PILMAPRES</span>
</div>

<div class="card" style="max-width:600px">
    <div class="card-body p-4">
        <div class="alert alert-info mb-4">
            <i class="fa-solid fa-circle-info me-2"></i>
            Dengan mengklik <strong>Kirim Pendaftaran</strong>, Anda menyatakan bersedia mengikuti seluruh proses seleksi PILMAPRES UM Metro.
        </div>
        <table class="table table-borderless mb-4">
            <tr><td class="text-muted">Nama</td><td class="fw-semibold">{{ Auth::user()->nama_lengkap }}</td></tr>
            <tr><td class="text-muted">Username</td><td>{{ Auth::user()->username }}</td></tr>
        </table>
        <form action="{{ route('mahasiswa.pendaftaran.store') }}" method="POST">
            @csrf
            
            <div class="mb-3">
                <label class="form-label fw-semibold">IPK Terakhir</label>
                <input type="number" step="0.01" min="0" max="4.00" name="ipk" class="form-control" required placeholder="Contoh: 3.75">
            </div>
            
            <div class="mb-4">
                <label class="form-label fw-semibold">Pernah Mengikuti PILMAPRES?</label>
                <select name="pernah_pilmapres" class="form-select" required>
                    <option value="Belum Pernah">Belum Pernah</option>
                    <option value="Lokal">Ya, Tingkat Lokal (Universitas)</option>
                    <option value="Nasional">Ya, Tingkat Nasional</option>
                </select>
            </div>
            <button type="submit" class="btn btn-primary w-100">
                <i class="fa-solid fa-save me-2"></i> Simpan Data Awal
            </button>
        </form>
    </div>
</div>
@endsection

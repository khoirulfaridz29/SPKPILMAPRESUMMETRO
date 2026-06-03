@extends('layouts.dashboard')
@section('title', 'Penugasan Juri')

@section('content')
<div class="mb-4">
    <a href="{{ route('admin.rekap.index') }}" class="btn btn-sm btn-outline-secondary me-2">
        <i class="fa-solid fa-arrow-left me-1"></i> Kembali
    </a>
    <span class="fw-bold fs-5">Penugasan Juri untuk Peserta Lolos Tahap I</span>
</div>

<div class="row g-4">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header"><i class="fa-solid fa-list me-2"></i> Daftar Penugasan</div>
            <div class="card-body p-0">
                <table class="table table-hover mb-0 align-middle">
                    <thead class="table-light">
                        <tr>
                            <th class="ps-4">Juri</th>
                            <th>Peserta</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($penugasans as $pg)
                        <tr>
                            <td class="ps-4 fw-semibold">{{ $pg->juri->nama_lengkap }}</td>
                            <td>{{ $pg->pendaftaran->mahasiswa->user->nama_lengkap }}</td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="2" class="text-center py-4 text-muted">Belum ada penugasan.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection

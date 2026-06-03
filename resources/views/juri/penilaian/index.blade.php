@extends('layouts.dashboard')
@section('title', 'Penilaian Peserta')

@section('content')
<h4 class="fw-bold mb-4">Daftar Peserta yang Ditugaskan</h4>

<div class="card">
    <div class="card-body p-0">
        <table class="table table-hover mb-0 align-middle">
            <thead class="table-light">
                <tr>
                    <th class="ps-4">#</th>
                    <th>Nama Peserta</th>
                    <th>NIM</th>
                    <th>Program Studi</th>
                    <th class="text-center">Status Penilaian</th>
                    <th class="text-center">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($penugasans as $i => $pg)
                @php
                    $jmlPenilaian = \App\Models\Penilaian::where('juri_id', Auth::id())
                        ->where('pendaftaran_id', $pg->pendaftaran_id)->count();
                    $jmlKriteria = \App\Models\KriteriaPenilaian::count();
                @endphp
                <tr>
                    <td class="ps-4 text-muted">{{ $i + 1 }}</td>
                    <td class="fw-semibold">{{ $pg->pendaftaran->mahasiswa->user->nama_lengkap }}</td>
                    <td><code>{{ $pg->pendaftaran->mahasiswa->nim }}</code></td>
                    <td class="text-muted">{{ $pg->pendaftaran->mahasiswa->program_studi }}</td>
                    <td class="text-center">
                        @if($jmlPenilaian >= $jmlKriteria && $jmlKriteria > 0)
                            <span class="badge bg-success">Sudah Dinilai</span>
                        @else
                            <span class="badge bg-warning text-dark">Belum Dinilai</span>
                        @endif
                    </td>
                    <td class="text-center">
                        <a href="{{ route('juri.penilaian.show', $pg->pendaftaran_id) }}" class="btn btn-sm btn-primary">
                            <i class="fa-solid fa-clipboard-check me-1"></i> Nilai
                        </a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="text-center py-5 text-muted">
                        <i class="fa-solid fa-clipboard fa-2x mb-2 d-block"></i> Anda belum ditugaskan untuk menilai peserta.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection

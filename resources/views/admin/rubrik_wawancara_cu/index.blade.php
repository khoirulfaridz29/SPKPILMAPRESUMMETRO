@extends('layouts.dashboard')
@section('title', 'Rubrik Wawancara Capaian Unggulan (CU)')

@section('content')
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center bg-white py-3">
        <span class="fw-bold fs-5 text-primary"><i class="fa-solid fa-medal me-2"></i> Rubrik Wawancara Capaian Unggulan (CU)</span>
        <a href="{{ route('admin.rubrik-wawancara-cu.create') }}" class="btn btn-sm btn-primary rounded-pill px-3">
            <i class="fa-solid fa-plus me-1"></i> Tambah Kriteria
        </a>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover mb-0 align-middle">
                <thead class="table-light text-secondary">
                    <tr>
                        <th class="px-4">Kriteria Penilaian</th>
                        <th>Bobot</th>
                        <th class="text-end px-4">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($rubriks as $r)
                    <tr>
                        <td class="px-4 fw-semibold">{{ $r->kriteria_penilaian }}</td>
                        <td><span class="badge bg-light text-dark fw-bold">{{ $r->bobot }}</span></td>
                        <td class="text-end px-4">
                            <a href="{{ route('admin.rubrik-wawancara-cu.edit', $r->id) }}" class="btn btn-sm btn-outline-primary rounded-circle" style="width:32px; height:32px; padding:0; line-height:32px;">
                                <i class="fa-solid fa-edit"></i>
                            </a>
                            <form action="{{ route('admin.rubrik-wawancara-cu.destroy', $r->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Hapus kriteria ini?')">
                                @csrf @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-outline-danger rounded-circle" style="width:32px; height:32px; padding:0; line-height:32px;">
                                    <i class="fa-solid fa-trash"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                    @if($rubriks->isEmpty())
                    <tr>
                        <td colspan="3" class="text-center py-4 text-muted">Belum ada data rubrik.</td>
                    </tr>
                    @endif
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection

@extends('layouts.dashboard')
@section('title', 'Rubrik Wawancara Capaian Unggulan (CU)')

@section('content')
<div class="card border-0 shadow-sm" style="border-radius:var(--radius)">
    <div class="card-header d-flex justify-content-between align-items-center bg-white py-3">
        <span class="fw-bold fs-5 text-primary"><i class="fa-solid fa-medal me-2"></i> Rubrik Wawancara Capaian Unggulan (CU)</span>
        <a href="{{ route('admin.rubrik-wawancara-cu.create') }}" class="btn btn-sm btn-primary px-3">
            <i class="fa-solid fa-plus me-1"></i> Tambah Kriteria
        </a>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table style="width:100%;border-collapse:collapse;border-spacing:0;font-size:0.82rem">
                <thead>
                    <tr style="border-bottom:1px solid #e5e7eb;background:#f9fafb">
                        <th style="padding:0.6rem 0 0.6rem 1rem;text-align:left;font-weight:600;color:#6b7280;font-size:0.72rem;white-space:nowrap">Kriteria Penilaian</th>
                        <th style="padding:0.6rem 0;text-align:left;font-weight:600;color:#6b7280;font-size:0.72rem;white-space:nowrap">Bobot</th>
                        <th style="padding:0.6rem 0;text-align:left;font-weight:600;color:#6b7280;font-size:0.72rem;white-space:nowrap">Jenjang</th>
                        <th style="width:64px;padding:0.6rem 0.5rem 0.6rem 0;text-align:center;font-weight:600;color:#6b7280;font-size:0.72rem">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($rubriks as $r)
                    <tr style="border-bottom:1px solid #f3f4f6">
                        <td style="padding:0.7rem 0 0.7rem 1rem;font-weight:600">{{ $r->kriteria_penilaian }}</td>
                        <td style="padding:0.7rem 0"><span class="badge bg-light text-dark fw-bold">{{ $r->bobot }}</span></td>
                        <td style="padding:0.7rem 0"><span class="badge bg-secondary">{{ $r->jenjang->nama_jenjang ?? '-' }}</span></td>
                        <td style="padding:0.7rem 0.5rem 0.7rem 0;text-align:center">
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
                    <tr style="border-bottom:1px solid #f3f4f6">
                        <td colspan="4" style="padding:2rem;text-align:center;color:#9ca3af">Belum ada data rubrik.</td>
                    </tr>
                    @endif
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
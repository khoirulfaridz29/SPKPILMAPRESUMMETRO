@extends('layouts.dashboard')
@section('title', 'Rubrik Presentasi Gagasan Kreatif')

@section('content')
<div class="card border-0 shadow-sm" style="border-radius:var(--radius)">
    <div class="card-header d-flex justify-content-between align-items-center">
        <span><i class="fa-solid fa-person-chalkboard me-2"></i> Rubrik Presentasi Gagasan Kreatif</span>
        <a href="{{ route('admin.rubrik-presentasi-gk.create') }}" class="btn btn-sm btn-primary">
            <i class="fa-solid fa-plus"></i> Tambah Kriteria
        </a>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table style="width:100%;border-collapse:collapse;border-spacing:0;font-size:0.82rem">
                <thead>
                    <tr style="border-bottom:1px solid #e5e7eb;background:#f9fafb">
                        <th style="padding:0.6rem 0 0.6rem 1rem;text-align:left;font-weight:600;color:#6b7280;font-size:0.72rem;white-space:nowrap">Label</th>
                        <th style="padding:0.6rem 0;text-align:left;font-weight:600;color:#6b7280;font-size:0.72rem;white-space:nowrap">Aspek Penilaian</th>
                        <th style="padding:0.6rem 0;text-align:left;font-weight:600;color:#6b7280;font-size:0.72rem;white-space:nowrap">Kriteria Penilaian</th>
                        <th style="padding:0.6rem 0;text-align:left;font-weight:600;color:#6b7280;font-size:0.72rem;white-space:nowrap">Bobot</th>
                        <th style="padding:0.6rem 0;text-align:left;font-weight:600;color:#6b7280;font-size:0.72rem;white-space:nowrap">Jenjang</th>
                        <th style="width:64px;padding:0.6rem 0.5rem 0.6rem 0;text-align:center;font-weight:600;color:#6b7280;font-size:0.72rem">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($rubriks as $r)
                    <tr style="border-bottom:1px solid #f3f4f6">
                        <td style="padding:0.7rem 0 0.7rem 1rem;font-weight:600">{{ $r->kriteria?->nama_kriteria ?? $r->label ?? 'Presentasi GK' }}</td>
                        <td style="padding:0.7rem 0;white-space:nowrap">{{ $r->aspek_penilaian }}</td>
                        <td style="padding:0.7rem 0;white-space:nowrap">{{ $r->kriteria_penilaian }}</td>
                        <td style="padding:0.7rem 0">{{ $r->bobot }}</td>
                        <td style="padding:0.7rem 0"><span class="badge bg-secondary">{{ $r->jenjang->nama_jenjang ?? '-' }}</span></td>
                        <td style="padding:0.7rem 0.5rem 0.7rem 0;text-align:center">
                            <a href="{{ route('admin.rubrik-presentasi-gk.edit', $r->id) }}" class="btn btn-sm btn-outline-primary">
                                <i class="fa-solid fa-edit"></i>
                            </a>
                            <form action="{{ route('admin.rubrik-presentasi-gk.destroy', $r->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Hapus kriteria ini?')">
                                @csrf @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-outline-danger">
                                    <i class="fa-solid fa-trash"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                    @if($rubriks->isEmpty())
                    <tr style="border-bottom:1px solid #f3f4f6">
                        <td colspan="6" style="padding:2rem;text-align:center;color:#9ca3af">Belum ada data rubrik.</td>
                    </tr>
                    @endif
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
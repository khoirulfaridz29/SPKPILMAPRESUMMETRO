@extends('layouts.dashboard')
@section('title', 'Jenjang')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h4 class="fw-bold mb-0">Jenjang Pendidikan</h4>
    <a href="{{ route('admin.jenjang.create') }}" class="btn btn-primary">
        <i class="fa-solid fa-plus me-2"></i> Tambah Jenjang
    </a>
</div>

<div class="card border-0 shadow-sm" style="border-radius:var(--radius)">
    <div class="card-body p-0">
        <div class="table-responsive">
        <table style="width:100%;border-collapse:collapse;border-spacing:0;font-size:0.82rem">
            <thead>
                <tr style="border-bottom:1px solid #e5e7eb;background:#f9fafb">
                    <th style="width:40px;padding:0.6rem 0 0.6rem 1rem;text-align:left;font-weight:600;color:#6b7280;font-size:0.72rem">#</th>
                    <th style="padding:0.6rem 0;text-align:left;font-weight:600;color:#6b7280;font-size:0.72rem;white-space:nowrap">Kode</th>
                    <th style="padding:0.6rem 0;text-align:left;font-weight:600;color:#6b7280;font-size:0.72rem;white-space:nowrap">Nama Jenjang</th>
                    <th style="padding:0.6rem 0;text-align:left;font-weight:600;color:#6b7280;font-size:0.72rem">Deskripsi</th>
                    <th style="width:64px;padding:0.6rem 0.5rem 0.6rem 0;text-align:center;font-weight:600;color:#6b7280;font-size:0.72rem">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($jenjang as $i => $item)
                <tr style="border-bottom:1px solid #f3f4f6">
                    <td style="padding:0.7rem 0 0.7rem 1rem;color:#9ca3af;font-size:0.75rem">{{ $i + 1 }}</td>
                    <td style="padding:0.7rem 0"><span class="badge bg-secondary">{{ $item->kode_jenjang }}</span></td>
                    <td style="padding:0.7rem 0;font-weight:600">{{ $item->nama_jenjang }}</td>
                    <td style="padding:0.7rem 0">{{ $item->deskripsi ?? '-' }}</td>
                    <td style="padding:0.7rem 0.5rem 0.7rem 0;text-align:center">
                        <a href="{{ route('admin.jenjang.edit', $item) }}" class="btn btn-sm btn-outline-secondary me-1">
                            <i class="fa-solid fa-pen"></i>
                        </a>
                        <form action="{{ route('admin.jenjang.destroy', $item) }}" method="POST" class="d-inline"
                            onsubmit="return confirm('Hapus jenjang ini?')">
                            @csrf @method('DELETE')
                            <button class="btn btn-sm btn-outline-danger"><i class="fa-solid fa-trash"></i></button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" style="padding:2rem;text-align:center;color:#9ca3af">
                        <i class="fa-solid fa-graduation-cap fa-2x mb-2 d-block"></i> Belum ada data jenjang.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
        </div>
    </div>
</div>
@endsection

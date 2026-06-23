@extends('layouts.dashboard')
@section('title', 'Jadwal Pelaksanaan')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h4 class="fw-bold mb-0">Jadwal Pelaksanaan</h4>
    <a href="{{ route('admin.jadwal.create') }}" class="btn btn-primary">
        <i class="fa-solid fa-plus me-2"></i> Tambah Jadwal
    </a>
</div>

<div class="card border-0 shadow-sm" style="border-radius:var(--radius)">
    <div class="card-body p-0">
        <div class="table-responsive">
        <table style="width:100%;border-collapse:collapse;border-spacing:0;font-size:0.82rem">
            <thead>
                <tr style="border-bottom:1px solid #e5e7eb;background:#f9fafb">
                    <th style="width:40px;padding:0.6rem 0 0.6rem 1rem;text-align:left;font-weight:600;color:#6b7280;font-size:0.72rem">#</th>
                    <th style="padding:0.6rem 0;text-align:left;font-weight:600;color:#6b7280;font-size:0.72rem;white-space:nowrap">Kegiatan</th>
                    <th style="padding:0.6rem 0;text-align:left;font-weight:600;color:#6b7280;font-size:0.72rem;white-space:nowrap">Mulai</th>
                    <th style="padding:0.6rem 0;text-align:left;font-weight:600;color:#6b7280;font-size:0.72rem;white-space:nowrap">Selesai</th>
                    <th style="padding:0.6rem 0;text-align:left;font-weight:600;color:#6b7280;font-size:0.72rem">Keterangan</th>
                    <th style="width:64px;padding:0.6rem 0.5rem 0.6rem 0;text-align:center;font-weight:600;color:#6b7280;font-size:0.72rem">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($jadwal as $i => $item)
                <tr style="border-bottom:1px solid #f3f4f6">
                    <td style="padding:0.7rem 0 0.7rem 1rem;color:#9ca3af;font-size:0.75rem">{{ $i + 1 }}</td>
                    <td style="padding:0.7rem 0;font-weight:600;white-space:nowrap">{{ $item->kegiatan }}</td>
                    <td style="padding:0.7rem 0;white-space:nowrap">{{ \Carbon\Carbon::parse($item->tanggal_mulai)->format('d M Y') }}</td>
                    <td style="padding:0.7rem 0;white-space:nowrap">{{ \Carbon\Carbon::parse($item->tanggal_selesai)->format('d M Y') }}</td>
                    <td style="padding:0.7rem 0">{{ $item->keterangan ?? '-' }}</td>
                    <td style="padding:0.7rem 0.5rem 0.7rem 0;text-align:center">
                        <a href="{{ route('admin.jadwal.edit', $item) }}" class="btn btn-sm btn-outline-secondary me-1">
                            <i class="fa-solid fa-pen"></i>
                        </a>
                        <form action="{{ route('admin.jadwal.destroy', $item) }}" method="POST" class="d-inline"
                            onsubmit="return confirm('Hapus jadwal ini?')">
                            @csrf @method('DELETE')
                            <button class="btn btn-sm btn-outline-danger"><i class="fa-solid fa-trash"></i></button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" style="padding:2rem;text-align:center;color:#9ca3af">
                        <i class="fa-solid fa-calendar-xmark fa-2x mb-2 d-block"></i> Belum ada data jadwal.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
        </div>
    </div>
</div>
@endsection

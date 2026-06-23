@extends('layouts.dashboard')
@section('title', 'Manajemen Pengumuman')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h4 class="fw-bold mb-0">Manajemen Pengumuman</h4>
    <a href="{{ route('admin.pengumuman.create') }}" class="btn btn-primary">
        <i class="fa-solid fa-plus me-2"></i> Buat Pengumuman
    </a>
</div>

<div class="card border-0 shadow-sm" style="border-radius:var(--radius)">
    <div class="card-body p-0">
        <div class="table-responsive">
        <table style="width:100%;border-collapse:collapse;border-spacing:0;font-size:0.82rem">
            <thead>
                <tr style="border-bottom:1px solid #e5e7eb;background:#f9fafb">
                    <th style="width:40px;padding:0.6rem 0 0.6rem 1rem;text-align:left;font-weight:600;color:#6b7280;font-size:0.72rem">#</th>
                    <th style="padding:0.6rem 0;text-align:left;font-weight:600;color:#6b7280;font-size:0.72rem;white-space:nowrap">Judul</th>
                    <th style="padding:0.6rem 0;text-align:left;font-weight:600;color:#6b7280;font-size:0.72rem;white-space:nowrap">Tanggal Publish</th>
                    <th style="padding:0.6rem 0;text-align:left;font-weight:600;color:#6b7280;font-size:0.72rem">Ringkasan</th>
                    <th style="width:64px;padding:0.6rem 0.5rem 0.6rem 0;text-align:center;font-weight:600;color:#6b7280;font-size:0.72rem">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($pengumuman as $i => $item)
                <tr style="border-bottom:1px solid #f3f4f6">
                    <td style="padding:0.7rem 0 0.7rem 1rem;color:#9ca3af;font-size:0.75rem">{{ $i + 1 }}</td>
                    <td style="padding:0.7rem 0;font-weight:600;white-space:nowrap">{{ $item->judul }}</td>
                    <td style="padding:0.7rem 0;white-space:nowrap">{{ \Carbon\Carbon::parse($item->tanggal_publish)->format('d M Y') }}</td>
                    <td style="padding:0.7rem 0;color:#6b7280;font-size:0.72rem">{{ Str::limit(strip_tags($item->konten), 60) }}</td>
                    <td style="padding:0.7rem 0.5rem 0.7rem 0;text-align:center">
                        <a href="{{ route('admin.pengumuman.edit', $item) }}" class="btn btn-sm btn-outline-secondary me-1">
                            <i class="fa-solid fa-pen"></i>
                        </a>
                        <form action="{{ route('admin.pengumuman.destroy', $item) }}" method="POST" class="d-inline"
                            onsubmit="return confirm('Hapus pengumuman ini?')">
                            @csrf @method('DELETE')
                            <button class="btn btn-sm btn-outline-danger"><i class="fa-solid fa-trash"></i></button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" style="padding:2rem;text-align:center;color:#9ca3af">
                        <i class="fa-solid fa-bullhorn fa-2x mb-2 d-block"></i> Belum ada pengumuman.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
        </div>
    </div>
</div>
@endsection

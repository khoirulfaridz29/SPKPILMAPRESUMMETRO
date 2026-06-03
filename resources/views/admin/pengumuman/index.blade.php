@extends('layouts.dashboard')
@section('title', 'Manajemen Pengumuman')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h4 class="fw-bold mb-0">Manajemen Pengumuman</h4>
    <a href="{{ route('admin.pengumuman.create') }}" class="btn btn-primary">
        <i class="fa-solid fa-plus me-2"></i> Buat Pengumuman
    </a>
</div>

<div class="card">
    <div class="card-body p-0">
        <table class="table table-hover mb-0 align-middle">
            <thead class="table-light">
                <tr>
                    <th class="ps-4">#</th>
                    <th>Judul</th>
                    <th>Tanggal Publish</th>
                    <th>Ringkasan</th>
                    <th class="text-center">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($pengumuman as $i => $item)
                <tr>
                    <td class="ps-4 text-muted">{{ $i + 1 }}</td>
                    <td class="fw-semibold">{{ $item->judul }}</td>
                    <td>{{ \Carbon\Carbon::parse($item->tanggal_publish)->format('d M Y') }}</td>
                    <td class="text-muted small">{{ Str::limit(strip_tags($item->konten), 60) }}</td>
                    <td class="text-center">
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
                    <td colspan="5" class="text-center py-5 text-muted">
                        <i class="fa-solid fa-bullhorn fa-2x mb-2 d-block"></i> Belum ada pengumuman.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection

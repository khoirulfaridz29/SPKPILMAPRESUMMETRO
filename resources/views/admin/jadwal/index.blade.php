@extends('layouts.dashboard')
@section('title', 'Jadwal Pelaksanaan')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h4 class="fw-bold mb-0">Jadwal Pelaksanaan</h4>
    <a href="{{ route('admin.jadwal.create') }}" class="btn btn-primary">
        <i class="fa-solid fa-plus me-2"></i> Tambah Jadwal
    </a>
</div>

<div class="card">
    <div class="card-body p-0">
        <table class="table table-hover mb-0 align-middle">
            <thead class="table-light">
                <tr>
                    <th class="ps-4">#</th>
                    <th>Kegiatan</th>
                    <th>Mulai</th>
                    <th>Selesai</th>
                    <th>Keterangan</th>
                    <th class="text-center">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($jadwal as $i => $item)
                <tr>
                    <td class="ps-4 text-muted">{{ $i + 1 }}</td>
                    <td class="fw-semibold">{{ $item->kegiatan }}</td>
                    <td>{{ \Carbon\Carbon::parse($item->tanggal_mulai)->format('d M Y') }}</td>
                    <td>{{ \Carbon\Carbon::parse($item->tanggal_selesai)->format('d M Y') }}</td>
                    <td>{{ $item->keterangan ?? '-' }}</td>
                    <td class="text-center">
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
                    <td colspan="6" class="text-center py-5 text-muted">
                        <i class="fa-solid fa-calendar-xmark fa-2x mb-2 d-block"></i> Belum ada data jadwal.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection

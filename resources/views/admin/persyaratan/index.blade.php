@extends('layouts.dashboard')
@section('title', 'Persyaratan Pendaftaran')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h4 class="fw-bold mb-0">Persyaratan Pendaftaran (Dynamic Form)</h4>
    <a href="{{ route('admin.persyaratan.create') }}" class="btn btn-primary">
        <i class="fa-solid fa-plus me-2"></i> Tambah Persyaratan
    </a>
</div>

<div class="card">
    <div class="card-body p-0">
        <table class="table table-hover mb-0 align-middle">
            <thead class="table-light">
                <tr>
                    <th class="ps-4">#</th>
                    <th>Nama Persyaratan</th>
                    <th>Keterangan</th>
                    <th>Wajib?</th>
                    <th class="text-center">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($persyaratan as $i => $item)
                <tr>
                    <td class="ps-4 text-muted">{{ $i + 1 }}</td>
                    <td class="fw-semibold">{{ $item->nama_syarat }}</td>
                    <td>{{ $item->keterangan ?? '-' }}</td>
                    <td>
                        @if($item->is_required)
                            <span class="badge bg-danger">Wajib</span>
                        @else
                            <span class="badge bg-secondary">Opsional</span>
                        @endif
                    </td>
                    <td class="text-center">
                        <a href="{{ route('admin.persyaratan.edit', $item) }}" class="btn btn-sm btn-outline-secondary me-1">
                            <i class="fa-solid fa-pen"></i>
                        </a>
                        <form action="{{ route('admin.persyaratan.destroy', $item) }}" method="POST" class="d-inline"
                            onsubmit="return confirm('Hapus persyaratan ini?')">
                            @csrf @method('DELETE')
                            <button class="btn btn-sm btn-outline-danger"><i class="fa-solid fa-trash"></i></button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="text-center py-5 text-muted">
                        <i class="fa-solid fa-file-circle-xmark fa-2x mb-2 d-block"></i> Belum ada data persyaratan.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection

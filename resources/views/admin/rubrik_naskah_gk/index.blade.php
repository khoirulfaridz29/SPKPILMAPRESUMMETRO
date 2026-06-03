@extends('layouts.dashboard')
@section('title', 'Rubrik Naskah Gagasan Kreatif')

@section('content')
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <span><i class="fa-solid fa-file-pen me-2"></i> Rubrik Naskah Gagasan Kreatif</span>
        <a href="{{ route('admin.rubrik-naskah-gk.create') }}" class="btn btn-sm btn-primary">
            <i class="fa-solid fa-plus"></i> Tambah Kriteria
        </a>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead class="table-light">
                    <tr>
                        <th class="px-4">Aspek Penilaian</th>
                        <th>Kriteria Penilaian</th>
                        <th>Bobot</th>
                        <th class="text-end px-4">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($rubriks as $r)
                    <tr>
                        <td class="px-4 fw-semibold">{{ $r->aspek_penilaian }}</td>
                        <td>{{ $r->kriteria_penilaian }}</td>
                        <td>{{ $r->bobot }}</td>
                        <td class="text-end px-4">
                            <a href="{{ route('admin.rubrik-naskah-gk.edit', $r->id) }}" class="btn btn-sm btn-outline-primary">
                                <i class="fa-solid fa-edit"></i>
                            </a>
                            <form action="{{ route('admin.rubrik-naskah-gk.destroy', $r->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Hapus kriteria ini?')">
                                @csrf @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-outline-danger">
                                    <i class="fa-solid fa-trash"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                    @if($rubriks->isEmpty())
                    <tr>
                        <td colspan="4" class="text-center py-4 text-muted">Belum ada data rubrik.</td>
                    </tr>
                    @endif
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection

@extends('layouts.dashboard')
@section('title', 'Rubrik Bahasa Inggris')

@section('content')
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <span><i class="fa-solid fa-language me-2"></i> Rubrik Bahasa Inggris</span>
        <a href="{{ route('admin.rubrik-bahasa-inggris.create') }}" class="btn btn-sm btn-primary">
            <i class="fa-solid fa-plus"></i> Tambah Field
        </a>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-bordered mb-0 align-middle">
                <thead class="table-light text-center">
                    <tr>
                        <th rowspan="2">Field</th>
                        <th colspan="4">Kriteria & Skor</th>
                        <th rowspan="2" style="width: 100px;">Aksi</th>
                    </tr>
                    <tr>
                        <th>Excellent</th>
                        <th>Good to Average</th>
                        <th>Fair to Poor</th>
                        <th>Very Poor</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($rubriks as $r)
                    <tr>
                        <td class="fw-bold text-center align-middle">{{ $r->field }}</td>
                        <td>
                            <span class="badge bg-success mb-1">Skor: {{ $r->excellent_score }}</span><br>
                            <small>{{ $r->excellent_criteria }}</small>
                        </td>
                        <td>
                            <span class="badge bg-primary mb-1">Skor: {{ $r->good_score }}</span><br>
                            <small>{{ $r->good_criteria }}</small>
                        </td>
                        <td>
                            <span class="badge bg-warning text-dark mb-1">Skor: {{ $r->fair_score }}</span><br>
                            <small>{{ $r->fair_criteria }}</small>
                        </td>
                        <td>
                            <span class="badge bg-danger mb-1">Skor: {{ $r->poor_score }}</span><br>
                            <small>{{ $r->poor_criteria }}</small>
                        </td>
                        <td class="text-center align-middle">
                            <div class="d-flex flex-column gap-2">
                                <a href="{{ route('admin.rubrik-bahasa-inggris.edit', $r->id) }}" class="btn btn-sm btn-outline-primary">
                                    <i class="fa-solid fa-edit"></i>
                                </a>
                                <form action="{{ route('admin.rubrik-bahasa-inggris.destroy', $r->id) }}" method="POST" onsubmit="return confirm('Hapus field ini?')">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger w-100">
                                        <i class="fa-solid fa-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                    @if($rubriks->isEmpty())
                    <tr>
                        <td colspan="6" class="text-center py-4 text-muted">Belum ada data rubrik.</td>
                    </tr>
                    @endif
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection

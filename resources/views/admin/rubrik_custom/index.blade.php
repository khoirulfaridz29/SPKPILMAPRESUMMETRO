@extends('layouts.dashboard')
@section('title', 'Rubrik Custom')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h4 class="fw-bold mb-0"><i class="fa-solid fa-puzzle-piece me-2"></i> Template Rubrik Custom</h4>
    <a href="{{ route('admin.rubrik-custom.create') }}" class="btn btn-primary"><i class="fa-solid fa-plus me-1"></i> Tambah Template</a>
</div>

@if(session('success'))
<div class="alert alert-success">{{ session('success') }}</div>
@endif

<div class="card">
    <div class="card-body p-0">
        <table class="table table-striped mb-0">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Nama Template</th>
                    <th>Jumlah Field</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($templates as $t)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $t->nama_template }}</td>
                    <td>{{ $t->fields->count() }}</td>
                    <td>
                        <a href="{{ route('admin.rubrik-custom.edit', $t) }}" class="btn btn-sm btn-warning"><i class="fa-solid fa-edit"></i></a>
                        <form action="{{ route('admin.rubrik-custom.destroy', $t) }}" method="POST" class="d-inline" onsubmit="return confirm('Hapus template?')">
                            @csrf @method('DELETE')
                            <button class="btn btn-sm btn-danger"><i class="fa-solid fa-trash"></i></button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr><td colspan="4" class="text-center text-muted">Belum ada template.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection

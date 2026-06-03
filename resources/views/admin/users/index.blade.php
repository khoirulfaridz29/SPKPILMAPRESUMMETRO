@extends('layouts.dashboard')
@section('title', 'Kelola Akun')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h4 class="fw-bold mb-0">Kelola Akun Pengguna</h4>
    <a href="{{ route('admin.users.create') }}" class="btn btn-primary">
        <i class="fa-solid fa-user-plus me-2"></i> Tambah Akun
    </a>
</div>

{{-- Filter Role --}}
<div class="d-flex gap-2 mb-4">
    @foreach(['juri', 'wr3', 'admin', 'mahasiswa'] as $r)
    <a href="{{ route('admin.users.index', ['role' => $r]) }}"
        class="btn btn-sm {{ $role === $r ? 'btn-primary' : 'btn-outline-secondary' }}">
        {{ strtoupper($r) }}
    </a>
    @endforeach
</div>

<div class="card">
    <div class="card-body p-0">
        <table class="table table-hover mb-0 align-middle">
            <thead class="table-light">
                <tr>
                    <th class="ps-4">#</th>
                    <th>Nama Lengkap</th>
                    <th>Username</th>
                    <th>Role</th>
                    <th>Terdaftar</th>
                    <th class="text-center">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($users as $i => $u)
                <tr>
                    <td class="ps-4 text-muted">{{ $i + 1 }}</td>
                    <td class="fw-semibold">{{ $u->nama_lengkap }}</td>
                    <td><code>{{ $u->username }}</code></td>
                    <td><span class="badge badge-{{ $u->role }} px-2 py-1">{{ strtoupper($u->role) }}</span></td>
                    <td class="text-muted small">{{ $u->created_at->format('d M Y') }}</td>
                    <td class="text-center">
                        <a href="{{ route('admin.users.edit', $u) }}" class="btn btn-sm btn-outline-secondary me-1">
                            <i class="fa-solid fa-pen"></i>
                        </a>
                        <form action="{{ route('admin.users.destroy', $u) }}" method="POST" class="d-inline"
                            onsubmit="return confirm('Hapus akun ini?')">
                            @csrf @method('DELETE')
                            <button class="btn btn-sm btn-outline-danger"><i class="fa-solid fa-trash"></i></button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="text-center py-5 text-muted">
                        <i class="fa-solid fa-inbox fa-2x mb-2 d-block"></i> Tidak ada akun dengan role "{{ strtoupper($role) }}".
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection

@extends('layouts.dashboard')
@section('title', 'Kelola Akun')

@section('content')
<style>
    .table-hover tbody tr:hover { border-radius: 0; }
    .table-hover tbody tr td:first-child { border-radius: 0; }
    .table-hover tbody tr td:last-child { border-radius: 0; }
    .table-hover tbody tr { border-radius: 0; }
    .page-users .btn,
    .page-users .btn:hover,
    .page-users .btn:active,
    .page-users .btn:focus,
    .page-users .btn:focus-visible,
    .page-users .btn:first-child:active,
    .page-users .btn.show { border-radius: var(--radius) !important; }
</style>

<div class="page-users">

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

<div class="card border-0 shadow-sm" style="border-radius:var(--radius)">
    <div class="card-body p-0">
        <div class="table-responsive">
        <table style="width:100%;border-collapse:collapse;border-spacing:0;font-size:0.82rem">
            <thead>
                <tr style="border-bottom:1px solid #e5e7eb;background:#f9fafb">
                    <th style="width:40px;padding:0.6rem 0 0.6rem 1rem;text-align:left;font-weight:600;color:#6b7280;font-size:0.72rem">#</th>
                    <th style="padding:0.6rem 0;text-align:left;font-weight:600;color:#6b7280;font-size:0.72rem;white-space:nowrap">Nama Lengkap</th>
                    <th style="padding:0.6rem 0;text-align:left;font-weight:600;color:#6b7280;font-size:0.72rem;white-space:nowrap">NIDN/NIP</th>
                    <th style="padding:0.6rem 0;text-align:left;font-weight:600;color:#6b7280;font-size:0.72rem;white-space:nowrap">Username</th>
                    <th style="padding:0.6rem 0;text-align:left;font-weight:600;color:#6b7280;font-size:0.72rem;white-space:nowrap">Role</th>
                    <th style="padding:0.6rem 0;text-align:left;font-weight:600;color:#6b7280;font-size:0.72rem;white-space:nowrap">Terdaftar</th>
                    <th style="width:64px;padding:0.6rem 0.5rem 0.6rem 0;text-align:center;font-weight:600;color:#6b7280;font-size:0.72rem">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($users as $i => $u)
                <tr style="border-bottom:1px solid #f3f4f6">
                    <td style="padding:0.7rem 0 0.7rem 1rem;color:#9ca3af;font-size:0.75rem">{{ $i + 1 }}</td>
                    <td style="padding:0.7rem 0;font-weight:600;white-space:nowrap">{{ $u->nama_lengkap }}</td>
                    <td style="padding:0.7rem 0"><code>{{ $u->nidn ?? '-' }}</code></td>
                    <td style="padding:0.7rem 0"><code>{{ $u->username }}</code></td>
                    <td style="padding:0.7rem 0"><span class="badge badge-{{ $u->role }} px-2 py-1">{{ strtoupper($u->role) }}</span></td>
                    <td style="padding:0.7rem 0;color:#6b7280;font-size:0.72rem">{{ $u->created_at->format('d M Y') }}</td>
                    <td style="padding:0.7rem 0.5rem 0.7rem 0;text-align:center">
                        @if($u->role === 'mahasiswa')
                            @php $mhs = $u->mahasiswa; $nim = $mhs->nim ?? 'N/A'; @endphp
                            <form action="{{ route('admin.users.reset-password', $u) }}" method="POST" class="d-inline"
                                onsubmit="return confirm('Reset password akun ini menjadi NPM ({{ $nim }})?')">
                                @csrf
                                <button class="btn btn-sm btn-outline-warning me-1" title="Reset Password ke NPM">
                                    <i class="fa-solid fa-key"></i>
                                </button>
                            </form>
                        @else
                            <a href="{{ route('admin.users.edit', $u) }}" class="btn btn-sm btn-outline-secondary me-1">
                                <i class="fa-solid fa-pen"></i>
                            </a>
                        @endif
                        <form action="{{ route('admin.users.destroy', $u) }}" method="POST" class="d-inline"
                            onsubmit="return confirm('Hapus akun ini?')">
                            @csrf @method('DELETE')
                            <button class="btn btn-sm btn-outline-danger"><i class="fa-solid fa-trash"></i></button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" style="padding:2rem;text-align:center;color:#9ca3af">
                        <i class="fa-solid fa-inbox fa-2x mb-2 d-block"></i> Tidak ada akun dengan role "{{ strtoupper($role) }}".
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
        </div>
    </div>
</div>
</div>
@endsection

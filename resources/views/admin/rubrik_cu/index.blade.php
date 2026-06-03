@extends('layouts.dashboard')
@section('title', 'Rubrik Capaian Unggulan')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h4 class="fw-bold mb-0">Rubrik Capaian Unggulan</h4>
    <a href="{{ route('admin.rubrik-cu.create') }}" class="btn btn-primary">
        <i class="fa-solid fa-plus me-2"></i> Tambah Rubrik
    </a>
</div>

<div class="card">
    <div class="card-body p-0 table-responsive">
        <table class="table table-hover mb-0 align-middle table-sm" style="font-size: 13px;">
            <thead class="table-light">
                <tr>
                    <th class="ps-3" rowspan="2">#</th>
                    <th rowspan="2">Bidang</th>
                    <th rowspan="2">Wujud Capaian</th>
                    <th colspan="2" class="text-center">Internasional</th>
                    <th colspan="2" class="text-center">Regional</th>
                    <th colspan="2" class="text-center">Nasional</th>
                    <th colspan="2" class="text-center">Provinsi</th>
                    <th colspan="2" class="text-center">Kab/Kota/PT</th>
                    <th class="text-center" rowspan="2">Aksi</th>
                </tr>
                <tr>
                    <th class="text-center">Kode</th><th class="text-center">Skor</th>
                    <th class="text-center">Kode</th><th class="text-center">Skor</th>
                    <th class="text-center">Kode</th><th class="text-center">Skor</th>
                    <th class="text-center">Kode</th><th class="text-center">Skor</th>
                    <th class="text-center">Kode</th><th class="text-center">Skor</th>
                </tr>
            </thead>
            <tbody>
                @forelse($rubriks as $i => $r)
                <tr>
                    <td class="ps-3 text-muted">{{ $i + 1 }}</td>
                    <td class="fw-semibold">{{ $r->bidang }}</td>
                    <td>{{ $r->wujud_capaian_unggulan }}</td>
                    
                    <td class="text-center"><code>{{ $r->kode_internasional ?? '-' }}</code></td>
                    <td class="text-center">{{ $r->skor_internasional ?? '-' }}</td>
                    
                    <td class="text-center"><code>{{ $r->kode_regional ?? '-' }}</code></td>
                    <td class="text-center">{{ $r->skor_regional ?? '-' }}</td>
                    
                    <td class="text-center"><code>{{ $r->kode_nasional ?? '-' }}</code></td>
                    <td class="text-center">{{ $r->skor_nasional ?? '-' }}</td>
                    
                    <td class="text-center"><code>{{ $r->kode_provinsi ?? '-' }}</code></td>
                    <td class="text-center">{{ $r->skor_provinsi ?? '-' }}</td>
                    
                    <td class="text-center"><code>{{ $r->kode_kab_kota ?? '-' }}</code></td>
                    <td class="text-center">{{ $r->skor_kab_kota ?? '-' }}</td>

                    <td class="text-center">
                        <div class="d-flex justify-content-center gap-1">
                            <a href="{{ route('admin.rubrik-cu.edit', $r->id) }}" class="btn btn-sm btn-outline-secondary">
                                <i class="fa-solid fa-pen"></i>
                            </a>
                            <form action="{{ route('admin.rubrik-cu.destroy', $r->id) }}" method="POST" onsubmit="return confirm('Hapus data ini?')">
                                @csrf @method('DELETE')
                                <button class="btn btn-sm btn-outline-danger"><i class="fa-solid fa-trash"></i></button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="14" class="text-center py-5 text-muted">
                        <i class="fa-solid fa-inbox fa-2x mb-2 d-block"></i> Belum ada data.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection

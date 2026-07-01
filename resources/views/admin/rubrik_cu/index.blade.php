@extends('layouts.dashboard')
@section('title', 'Rubrik Capaian Unggulan')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h4 class="fw-bold mb-0">Rubrik Capaian Unggulan</h4>
    <a href="{{ route('admin.rubrik-cu.create') }}" class="btn btn-primary">
        <i class="fa-solid fa-plus me-2"></i> Tambah Rubrik
    </a>
</div>

<div class="card border-0 shadow-sm" style="border-radius:var(--radius)">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table style="width:100%;border-collapse:collapse;border-spacing:0;font-size:0.82rem">
                <thead>
                    <tr style="border-bottom:1px solid #e5e7eb;background:#f9fafb">
                        <th style="width:40px;padding:0.6rem 0 0.6rem 1rem;text-align:left;font-weight:600;color:#6b7280;font-size:0.72rem" rowspan="2">#</th>
                        <th style="padding:0.6rem 0;text-align:left;font-weight:600;color:#6b7280;font-size:0.72rem;white-space:nowrap" rowspan="2">Bidang</th>
                        <th style="padding:0.6rem 0;text-align:left;font-weight:600;color:#6b7280;font-size:0.72rem;white-space:nowrap" rowspan="2">Wujud Capaian</th>
                        <th style="padding:0.6rem 0;text-align:center;font-weight:600;color:#6b7280;font-size:0.72rem;white-space:nowrap" colspan="2">Internasional</th>
                        <th style="padding:0.6rem 0;text-align:center;font-weight:600;color:#6b7280;font-size:0.72rem;white-space:nowrap" colspan="2">Regional</th>
                        <th style="padding:0.6rem 0;text-align:center;font-weight:600;color:#6b7280;font-size:0.72rem;white-space:nowrap" colspan="2">Nasional</th>
                        <th style="padding:0.6rem 0;text-align:center;font-weight:600;color:#6b7280;font-size:0.72rem;white-space:nowrap" colspan="2">Provinsi</th>
                        <th style="padding:0.6rem 0;text-align:center;font-weight:600;color:#6b7280;font-size:0.72rem;white-space:nowrap" colspan="2">Kab/Kota/PT</th>
                        <th style="padding:0.6rem 0;text-align:center;font-weight:600;color:#6b7280;font-size:0.72rem;white-space:nowrap" rowspan="2">Jenjang</th>
                        <th style="width:64px;padding:0.6rem 0.5rem 0.6rem 0;text-align:center;font-weight:600;color:#6b7280;font-size:0.72rem" rowspan="2">Aksi</th>
                    </tr>
                    <tr style="border-bottom:1px solid #e5e7eb;background:#f9fafb">
                        <th style="padding:0.6rem 0;text-align:center;font-weight:600;color:#6b7280;font-size:0.72rem">Kode</th><th style="padding:0.6rem 0;text-align:center;font-weight:600;color:#6b7280;font-size:0.72rem">Skor</th>
                        <th style="padding:0.6rem 0;text-align:center;font-weight:600;color:#6b7280;font-size:0.72rem">Kode</th><th style="padding:0.6rem 0;text-align:center;font-weight:600;color:#6b7280;font-size:0.72rem">Skor</th>
                        <th style="padding:0.6rem 0;text-align:center;font-weight:600;color:#6b7280;font-size:0.72rem">Kode</th><th style="padding:0.6rem 0;text-align:center;font-weight:600;color:#6b7280;font-size:0.72rem">Skor</th>
                        <th style="padding:0.6rem 0;text-align:center;font-weight:600;color:#6b7280;font-size:0.72rem">Kode</th><th style="padding:0.6rem 0;text-align:center;font-weight:600;color:#6b7280;font-size:0.72rem">Skor</th>
                        <th style="padding:0.6rem 0;text-align:center;font-weight:600;color:#6b7280;font-size:0.72rem">Kode</th><th style="padding:0.6rem 0;text-align:center;font-weight:600;color:#6b7280;font-size:0.72rem">Skor</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($rubriks as $i => $r)
                    <tr style="border-bottom:1px solid #f3f4f6">
                        <td style="padding:0.7rem 0 0.7rem 1rem;color:#9ca3af;font-size:0.75rem">{{ $i + 1 }}</td>
                        <td style="padding:0.7rem 0;font-weight:600">{{ $r->bidang }}</td>
                        <td style="padding:0.7rem 0;white-space:nowrap">{{ $r->wujud_capaian_unggulan }}</td>

                        <td style="padding:0.7rem 0;text-align:center"><code>{{ $r->kode_internasional ?? '-' }}</code></td>
                        <td style="padding:0.7rem 0;text-align:center">{{ $r->skor_internasional ?? '-' }}</td>

                        <td style="padding:0.7rem 0;text-align:center"><code>{{ $r->kode_regional ?? '-' }}</code></td>
                        <td style="padding:0.7rem 0;text-align:center">{{ $r->skor_regional ?? '-' }}</td>

                        <td style="padding:0.7rem 0;text-align:center"><code>{{ $r->kode_nasional ?? '-' }}</code></td>
                        <td style="padding:0.7rem 0;text-align:center">{{ $r->skor_nasional ?? '-' }}</td>

                        <td style="padding:0.7rem 0;text-align:center"><code>{{ $r->kode_provinsi ?? '-' }}</code></td>
                        <td style="padding:0.7rem 0;text-align:center">{{ $r->skor_provinsi ?? '-' }}</td>

                        <td style="padding:0.7rem 0;text-align:center"><code>{{ $r->kode_kab_kota ?? '-' }}</code></td>
                        <td style="padding:0.7rem 0;text-align:center">{{ $r->skor_kab_kota ?? '-' }}</td>

                        <td style="padding:0.7rem 0;text-align:center">
                            <span class="badge bg-secondary">{{ $r->jenjang->nama_jenjang ?? '-' }}</span>
                        </td>
                        <td style="padding:0.7rem 0.5rem 0.7rem 0;text-align:center">
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
                    <tr style="border-bottom:1px solid #f3f4f6">
                        <td colspan="15" style="padding:2rem;text-align:center;color:#9ca3af">
                            <i class="fa-solid fa-inbox fa-2x mb-2 d-block"></i> Belum ada data.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
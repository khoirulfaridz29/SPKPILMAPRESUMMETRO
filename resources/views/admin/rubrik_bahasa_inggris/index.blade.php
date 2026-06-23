@extends('layouts.dashboard')
@section('title', 'Rubrik Bahasa Inggris')

@section('content')
<div class="card border-0 shadow-sm" style="border-radius:var(--radius)">
    <div class="card-header d-flex justify-content-between align-items-center">
        <span><i class="fa-solid fa-language me-2"></i> Rubrik Bahasa Inggris</span>
        <a href="{{ route('admin.rubrik-bahasa-inggris.create') }}" class="btn btn-sm btn-primary">
            <i class="fa-solid fa-plus"></i> Tambah Field
        </a>
    </div>
    <div class="card-body pb-0">
        <form method="GET" class="row g-2 align-items-end">
            <div class="col-auto">
                <select name="jenjang_id" class="form-select form-select-sm" onchange="this.form.submit()">
                    <option value="">Semua Jenjang</option>
                    @foreach($jenjangs as $j)
                    <option value="{{ $j->id }}" {{ request('jenjang_id') == $j->id ? 'selected' : '' }}>{{ $j->nama_jenjang }}</option>
                    @endforeach
                </select>
            </div>
        </form>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table style="width:100%;border-collapse:collapse;border-spacing:0;font-size:0.82rem">
                <thead>
                    <tr style="border-bottom:1px solid #e5e7eb;background:#f9fafb">
                        <th style="padding:0.6rem 0 0.6rem 1rem;text-align:left;font-weight:600;color:#6b7280;font-size:0.72rem;white-space:nowrap" rowspan="2">Field</th>
                        <th style="padding:0.6rem 0;text-align:center;font-weight:600;color:#6b7280;font-size:0.72rem;white-space:nowrap" colspan="4">Kriteria & Skor</th>
                        <th style="padding:0.6rem 0;text-align:left;font-weight:600;color:#6b7280;font-size:0.72rem;white-space:nowrap" rowspan="2">Jenjang</th>
                        <th style="width:64px;padding:0.6rem 0.5rem 0.6rem 0;text-align:center;font-weight:600;color:#6b7280;font-size:0.72rem" rowspan="2">Aksi</th>
                    </tr>
                    <tr style="border-bottom:1px solid #e5e7eb;background:#f9fafb">
                        <th style="padding:0.6rem 0;text-align:center;font-weight:600;color:#6b7280;font-size:0.72rem;white-space:nowrap">Excellent</th>
                        <th style="padding:0.6rem 0;text-align:center;font-weight:600;color:#6b7280;font-size:0.72rem;white-space:nowrap">Good to Average</th>
                        <th style="padding:0.6rem 0;text-align:center;font-weight:600;color:#6b7280;font-size:0.72rem;white-space:nowrap">Fair to Poor</th>
                        <th style="padding:0.6rem 0;text-align:center;font-weight:600;color:#6b7280;font-size:0.72rem;white-space:nowrap">Very Poor</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($rubriks as $r)
                    <tr style="border-bottom:1px solid #f3f4f6">
                        <td style="padding:0.7rem 0 0.7rem 1rem;font-weight:600;text-align:center">{{ $r->field }}</td>
                        <td style="padding:0.7rem 0">
                            <span class="badge bg-success mb-1">Skor: {{ $r->excellent_score }}</span><br>
                            <small>{{ $r->excellent_criteria }}</small>
                        </td>
                        <td style="padding:0.7rem 0">
                            <span class="badge bg-primary mb-1">Skor: {{ $r->good_score }}</span><br>
                            <small>{{ $r->good_criteria }}</small>
                        </td>
                        <td style="padding:0.7rem 0">
                            <span class="badge bg-warning text-dark mb-1">Skor: {{ $r->fair_score }}</span><br>
                            <small>{{ $r->fair_criteria }}</small>
                        </td>
                        <td style="padding:0.7rem 0">
                            <span class="badge bg-danger mb-1">Skor: {{ $r->poor_score }}</span><br>
                            <small>{{ $r->poor_criteria }}</small>
                        </td>
                        <td style="padding:0.7rem 0;text-align:center">
                            <span class="badge bg-secondary">{{ $r->jenjang->nama_jenjang ?? '-' }}</span>
                        </td>
                        <td style="padding:0.7rem 0.5rem 0.7rem 0;text-align:center">
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
                    <tr style="border-bottom:1px solid #f3f4f6">
                        <td colspan="7" style="padding:2rem;text-align:center;color:#9ca3af">Belum ada data rubrik.</td>
                    </tr>
                    @endif
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
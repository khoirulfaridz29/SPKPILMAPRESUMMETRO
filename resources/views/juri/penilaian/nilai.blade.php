@extends('layouts.dashboard')
@section('title', 'Rekap Nilai')

@section('content')
<div class="d-flex align-items-center justify-content-between mb-4">
    <h4 class="fw-bold mb-0">Rekap Nilai Saya</h4>
    <span class="badge fs-6" style="background:var(--primary-light);color:white;border-radius:var(--radius-sm);padding:0.4rem 0.9rem">
        {{ $grouped->flatten(1)->count() }} Peserta
    </span>
</div>

@if($grouped->isEmpty())
<div class="card border-0 shadow-sm" style="border-radius:var(--radius)">
    <div class="card-body py-5 text-center text-muted">Belum ada data penilaian.</div>
</div>
@else

<ul class="nav nav-pills mb-3 gap-1" id="jenjangTab" role="tablist">
    @foreach($grouped as $jenjangId => $items)
    @php $jenjang = $items->first()->pendaftaran->mahasiswa->jenjang; @endphp
    <li class="nav-item" role="presentation">
        <button class="nav-link {{ $loop->first ? 'active' : '' }}" id="tab-{{ $jenjangId }}" data-bs-toggle="tab" data-bs-target="#konten-{{ $jenjangId }}" type="button" role="tab"
            style="border-radius:var(--radius-sm);padding:0.4rem 0.9rem;font-size:0.82rem;font-weight:500">
            {{ $jenjang->nama_jenjang ?? 'Jenjang' }}
            <span class="badge ms-1" style="background:rgba(255,255,255,0.3);font-weight:500">{{ $items->count() }}</span>
        </button>
    </li>
    @endforeach
</ul>

<div class="tab-content" id="jenjangTabContent">
    @foreach($grouped as $jenjangId => $penugasans)
    @php
        $jenjang = $penugasans->first()->pendaftaran->mahasiswa->jenjang;
    @endphp
    <div class="tab-pane fade {{ $loop->first ? 'show active' : '' }}" id="konten-{{ $jenjangId }}" role="tabpanel">
        <div class="card border-0 shadow-sm" style="border-radius:var(--radius)">
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table style="width:100%;border-collapse:collapse;border-spacing:0;font-size:0.82rem">
                        <thead>
                            <tr style="border-bottom:1px solid #e5e7eb;background:#f9fafb">
                                <th style="width:40px;padding:0.6rem 0 0.6rem 1rem;text-align:left;font-weight:600;color:#6b7280;font-size:0.72rem">#</th>
                                <th style="padding:0.6rem 0;text-align:left;font-weight:600;color:#6b7280;font-size:0.72rem;white-space:nowrap;width:1px">Nama</th>
                                <th style="padding:0.6rem 2rem 0.6rem 0;text-align:center;font-weight:600;color:#6b7280;font-size:0.72rem;white-space:nowrap;width:1px">NPM</th>
                                @foreach(['A01','A02','A03','F01','F02','F03'] as $kd)
                                <th style="width:68px;padding:0.6rem 0;text-align:center;font-weight:600;color:#6b7280;font-size:0.72rem;white-space:nowrap">
                                    <div style="font-weight:400;color:#9ca3af;font-size:0.65rem">{{ $kd }}</div>
                                    {{ $shortNames[$kd] ?? $kd }}
                                </th>
                                @endforeach
                                <th style="width:64px;padding:0.6rem 0.5rem 0.6rem 0;text-align:center;font-weight:600;color:#6b7280;font-size:0.72rem">Detail</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($penugasans as $i => $pg)
                            @php
                                $nilaiSaya = $pg->pendaftaran->penilaian->where('juri_id', Auth::id());
                                $skor = fn($k) => $nilaiSaya->firstWhere(fn($n) => optional($n->kriteria)->kode_kriteria === $k)?->nilai_input;
                                $skorArr = ['A01' => $skor('A01'), 'A02' => $skor('A02'), 'A03' => $skor('A03'), 'F01' => $skor('F01'), 'F02' => $skor('F02'), 'F03' => $skor('F03')];
                                $pdId = $pg->pendaftaran_id;
                                $detailWawancara = ($allWawancara[$pdId] ?? collect())->pluck('nilai_input', 'rubrik_wawancara_cu_id');
                                $detailNaskah = ($allNaskah[$pdId] ?? collect())->pluck('nilai_input', 'rubrik_naskah_gk_id');
                                $detailPresentasi = ($allPresentasi[$pdId] ?? collect())->pluck('nilai_input', 'rubrik_presentasi_gk_id');
                                $detailInggris = ($allInggris[$pdId] ?? collect())->pluck('nilai_input', 'rubrik_bahasa_inggris_id');
                                $portofolios = $allPortofolio[$pdId] ?? collect();
                                $resolveSkor = function($skor) {
                                    if (!$skor) return 0;
                                    preg_match_all('/\d+(?:\.\d+)?/', $skor, $matches);
                                    if (empty($matches[0])) return 0;
                                    $angka = array_map('floatval', $matches[0]);
                                    return array_sum($angka) / count($angka);
                                };
                                $portofolioArr = $portofolios->map(fn($p) => [
                                    "nama" => $p->nama_prestasi,
                                    "kategori" => $p->kategori_jenjang,
                                    "skor_raw" => $p->skor_rekomendasi,
                                    "skor" => $resolveSkor($p->skor_rekomendasi),
                                    "wujud" => $p->rubrikCu?->wujud_capaian_unggulan ?? "-",
                                ])->values();
                            @endphp
                            <tr style="border-bottom:1px solid #f3f4f6">
                                <td style="padding:0.7rem 0 0.7rem 1rem;color:#9ca3af;font-size:0.75rem">{{ $i + 1 }}</td>
                                <td style="padding:0.7rem 0;font-weight:600;white-space:nowrap;width:1px">{{ $pg->pendaftaran->mahasiswa->user->nama_lengkap }}</td>
                                <td style="padding:0.7rem 2rem 0.7rem 0;white-space:nowrap;width:1px;color:#6b7280;font-size:0.72rem;text-align:center">{{ $pg->pendaftaran->mahasiswa->nim }}</td>
                                @foreach(['A01','A02','A03','F01','F02','F03'] as $kd)
                                @php $v = $skor($kd); @endphp
                                <td style="padding:0.7rem 0;text-align:center;font-weight:600;color:{{ $v ? '#111827' : '#d1d5db' }}">{{ $v ? number_format($v, 1) : '-' }}</td>
                                @endforeach
                                <td style="padding:0.7rem 0.5rem 0.7rem 0;text-align:center">
                                    <button class="btn-detail" style="background:#2a6df0;border:none;border-radius:6px;padding:0.15rem 0.5rem;font-size:0.7rem;color:white;cursor:pointer"
                                        data-nama="{{ $pg->pendaftaran->mahasiswa->user->nama_lengkap }}"
                                        data-nim="{{ $pg->pendaftaran->mahasiswa->nim }}"
                                        data-jenjang="{{ $jenjang->nama_jenjang ?? '-' }}"
                                        data-jenjang-id="{{ $jenjangId }}"
                                        data-skors="{{ json_encode($skorArr) }}"
                                        data-edit="{{ route('juri.penilaian.show', $pg->pendaftaran_id) }}"
                                        data-wawancara='@json($detailWawancara)'
                                        data-naskah='@json($detailNaskah)'
                                        data-presentasi='@json($detailPresentasi)'
                                        data-inggris='@json($detailInggris)'
                                        data-portofolio='@json($portofolioArr)'>
                                        Detail
                                    </button>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="9" style="padding:2rem;text-align:center;color:#9ca3af">Belum ada data.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    @endforeach
</div>

{{-- Modal --}}
<div class="modal fade" id="detailModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-xl" style="max-width:800px">
        <div class="modal-content" style="border-radius:var(--radius);border:none;max-height:90vh;display:flex;flex-direction:column">
            <div class="modal-header border-0 pb-0 px-4 pt-3 flex-shrink-0">
                <div>
                    <h6 class="fw-bold mb-0" id="modalNama"></h6>
                    <small class="text-muted" id="modalNimJenjang"></small>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body px-4 pb-4 pt-3" style="overflow-y:auto;flex:1;min-height:0">
                {{-- Ringkasan nilai per kode --}}
                <small class="fw-semibold text-muted d-block mb-2" style="font-size:0.7rem;letter-spacing:0.5px">RINGKASAN NILAI</small>
                <div class="row g-2 mb-3" id="modalScores"></div>
                <hr class="my-2">

                {{-- Detail penilaian --}}
                <div id="modalDetailContent"></div>

                <hr class="my-3">
                <a href="#" id="modalEditLink" class="btn w-100" style="background:var(--primary-light);color:white;border-radius:var(--radius-sm);padding:0.5rem;font-weight:600;font-size:0.85rem">
                    <i class="fa-solid fa-pen me-1"></i> Edit Penilaian
                </a>
            </div>
        </div>
    </div>
</div>

@endif

@push('scripts')
<script>
const kodes = ['A01','A02','A03','F01','F02','F03'];
const rubrikNaskah = @json($rubrikNaskah);
const rubrikPresentasi = @json($rubrikPresentasi);
const rubrikWawancara = @json($rubrikWawancara);
const rubrikInggris = @json($rubrikInggris);

function renderDetail(skors, wawancara, naskah, presentasi, inggris, jenjangId, portofolio) {
    const rn = rubrikNaskah[jenjangId] || {};
    const rp = rubrikPresentasi[jenjangId] || {};
    const rw = rubrikWawancara[jenjangId] || {};
    const ri = rubrikInggris[jenjangId] || {};
    let html = '';

    const aspekNaskah = {};
    Object.keys(rn).forEach(function(id) {
        const r = rn[id];
        if (!aspekNaskah[r.aspek_penilaian]) aspekNaskah[r.aspek_penilaian] = [];
        aspekNaskah[r.aspek_penilaian].push({id: id, label: r.kriteria_penilaian, bobot: r.bobot, nilai: naskah[id]});
    });
    const aspekPresentasi = {};
    Object.keys(rp).forEach(function(id) {
        const r = rp[id];
        if (!aspekPresentasi[r.aspek_penilaian]) aspekPresentasi[r.aspek_penilaian] = [];
        aspekPresentasi[r.aspek_penilaian].push({id: id, label: r.kriteria_penilaian, bobot: r.bobot, nilai: presentasi[id]});
    });

    function n(v) { return (v !== null && v !== undefined && v !== '') ? parseFloat(v) : null; }

    // ── CU Berkas (A01) ──
    const a01v = n(skors.A01);
    if (a01v !== null) {
        html += '<div class="mb-2" style="background:var(--bg-body);border-radius:var(--radius-sm);padding:0.6rem 0.9rem;border:1px solid var(--border-color)">' +
            '<div style="font-size:0.72rem;font-weight:700;color:#2a6df0;margin-bottom:0.4rem"><i class="fa-solid fa-medal me-1"></i> CU Berkas (A01)</div>';
        if (portofolio && portofolio.length > 0) {
            let totalPorto = 0;
            html += '<div style="font-size:0.7rem;font-weight:600;color:#6b7280;margin-bottom:0.3rem">Sertifikat yang dinilai:</div>';
            portofolio.forEach(function(p) {
                const skor = parseFloat(p.skor) || 0;
                totalPorto += skor;
                const detailRange = p.skor_raw && p.skor_raw != String(Math.round(skor)) ? ' (rata-rata dari ' + p.skor_raw + ')' : '';
                html += '<div class="d-flex justify-content-between align-items-center mb-1" style="font-size:0.75rem">' +
                    '<span style="flex:1">' + p.nama + ' <span class="badge" style="background:#e0f2fe;color:#0ea5e9;font-weight:500;border:none;font-size:0.6rem">' + p.kategori + '</span></span>' +
                    '<span style="font-weight:700;color:#059669">' + skor.toFixed(1) + detailRange + '</span></div>';
            });
            const finalPorto = Math.min(totalPorto, 100);
            html += '<div style="font-size:0.72rem;color:#6b7280;padding:0.3rem 0;border-top:1px dashed #e5e7eb;margin-top:0.2rem">' +
                'Σ skor rekomendasi: ' + portofolio.map(function(p) { return (parseFloat(p.skor) || 0).toFixed(1); }).join(' + ') + ' = ' + totalPorto.toFixed(1) + (totalPorto > 100 ? ' (cap 100 → 100)' : '') + '</div>';
            html += '<div class="d-flex justify-content-between align-items-center" style="font-size:0.85rem;font-weight:700;color:#111827;margin-top:0.3rem">' +
                'Skor Akhir A01' +
                '<span>' + a01v.toFixed(1) + ' / 100</span></div>';
        }
        html += '</div>';
    }

    // ── Wawancara CU (F01) ──
    const wItems = Object.keys(rw);
    if (wItems.length > 0) {
        let wTotal = 0;
        let wFormula = [];
        html += '<div class="mb-2" style="background:var(--bg-body);border-radius:var(--radius-sm);padding:0.6rem 0.9rem;border:1px solid var(--border-color)">' +
            '<div style="font-size:0.72rem;font-weight:700;color:#2a6df0;margin-bottom:0.4rem"><i class="fa-solid fa-microphone me-1"></i> Wawancara CU (F01)</div>';
        wItems.forEach(function(id) {
            const r = rw[id];
            const v = n(wawancara[id]);
            if (v !== null) {
                const weighted = v * (r.bobot / 100);
                wTotal += weighted;
                wFormula.push(v.toFixed(1) + '×' + r.bobot + '%');
                html += '<div class="d-flex justify-content-between align-items-center mb-1" style="font-size:0.78rem">' +
                    '<span style="flex:1">' + r.kriteria_penilaian + ' <span class="badge text-muted" style="background:var(--bg-card);font-weight:500;font-size:0.6rem;border:1px solid var(--border-color)">' + r.bobot + '%</span></span>' +
                    '<span style="font-weight:700">' + v.toFixed(1) + ' × ' + (r.bobot / 100).toFixed(2) + ' = ' + weighted.toFixed(2) + '</span></div>';
            }
        });
        html += '<div style="font-size:0.72rem;color:#6b7280;padding:0.3rem 0;border-top:1px dashed #e5e7eb;margin-top:0.2rem">' +
            'Σ: ' + wFormula.join(' + ') + ' = ' + wTotal.toFixed(2) + '</div>';
        html += '<div class="d-flex justify-content-between align-items-center" style="font-size:0.85rem;font-weight:700;color:#111827;margin-top:0.3rem">' +
            'Skor Akhir F01<span>' + wTotal.toFixed(1) + ' / 100</span></div>';
        html += '</div>';
    }

    // ── Naskah GK (A02) ──
    const aspekKeys = Object.keys(aspekNaskah);
    if (aspekKeys.length > 0) {
        let nTotal = 0;
        let nFormula = [];
        let nParts = [];
        html += '<div class="mb-2" style="background:var(--bg-body);border-radius:var(--radius-sm);padding:0.6rem 0.9rem;border:1px solid var(--border-color)">' +
            '<div style="font-size:0.72rem;font-weight:700;color:#2a6df0;margin-bottom:0.4rem"><i class="fa-solid fa-file-alt me-1"></i> Naskah GK (A02)</div>';
        aspekKeys.forEach(function(aspek) {
            nParts.push([]);
            html += '<div style="font-size:0.72rem;font-weight:600;color:#6b7280;margin:0.35rem 0 0.2rem">' + aspek + '</div>';
            aspekNaskah[aspek].forEach(function(item) {
                const v = n(item.nilai);
                if (v !== null) {
                    const weighted = v * (item.bobot / 100);
                    nTotal += weighted;
                    nFormula.push(v.toFixed(1) + '×' + item.bobot + '%');
                    nParts[nParts.length - 1].push(weighted);
                    html += '<div class="d-flex justify-content-between align-items-center mb-1" style="font-size:0.78rem">' +
                        '<span style="flex:1">' + item.label + ' <span class="badge text-muted" style="background:var(--bg-card);font-weight:500;font-size:0.6rem;border:1px solid var(--border-color)">' + item.bobot + '%</span></span>' +
                        '<span style="font-weight:700">' + v.toFixed(1) + ' × ' + (item.bobot / 100).toFixed(2) + ' = ' + weighted.toFixed(2) + '</span></div>';
                }
            });
        });
        html += '<div style="font-size:0.72rem;color:#6b7280;padding:0.3rem 0;border-top:1px dashed #e5e7eb;margin-top:0.2rem">' +
            'Σ: ' + nFormula.join(' + ') + ' = ' + nTotal.toFixed(2) + '</div>';
        html += '<div class="d-flex justify-content-between align-items-center" style="font-size:0.85rem;font-weight:700;color:#111827;margin-top:0.3rem">' +
            'Skor Akhir A02<span>' + nTotal.toFixed(1) + ' / 100</span></div>';
        html += '</div>';
    }

    // ── Presentasi GK (F02) ──
    const aspekPres = Object.keys(aspekPresentasi);
    if (aspekPres.length > 0) {
        let pTotal = 0;
        let pFormula = [];
        html += '<div class="mb-2" style="background:var(--bg-body);border-radius:var(--radius-sm);padding:0.6rem 0.9rem;border:1px solid var(--border-color)">' +
            '<div style="font-size:0.72rem;font-weight:700;color:#2a6df0;margin-bottom:0.4rem"><i class="fa-solid fa-chalkboard-user me-1"></i> Presentasi GK (F02)</div>';
        aspekPres.forEach(function(aspek) {
            html += '<div style="font-size:0.72rem;font-weight:600;color:#6b7280;margin:0.35rem 0 0.2rem">' + aspek + '</div>';
            aspekPresentasi[aspek].forEach(function(item) {
                const v = n(item.nilai);
                if (v !== null) {
                    const weighted = v * (item.bobot / 100);
                    pTotal += weighted;
                    pFormula.push(v.toFixed(1) + '×' + item.bobot + '%');
                    html += '<div class="d-flex justify-content-between align-items-center mb-1" style="font-size:0.78rem">' +
                        '<span style="flex:1">' + item.label + ' <span class="badge text-muted" style="background:var(--bg-card);font-weight:500;font-size:0.6rem;border:1px solid var(--border-color)">' + item.bobot + '%</span></span>' +
                        '<span style="font-weight:700">' + v.toFixed(1) + ' × ' + (item.bobot / 100).toFixed(2) + ' = ' + weighted.toFixed(2) + '</span></div>';
                }
            });
        });
        html += '<div style="font-size:0.72rem;color:#6b7280;padding:0.3rem 0;border-top:1px dashed #e5e7eb;margin-top:0.2rem">' +
            'Σ: ' + pFormula.join(' + ') + ' = ' + pTotal.toFixed(2) + '</div>';
        html += '<div class="d-flex justify-content-between align-items-center" style="font-size:0.85rem;font-weight:700;color:#111827;margin-top:0.3rem">' +
            'Skor Akhir F02<span>' + pTotal.toFixed(1) + ' / 100</span></div>';
        html += '</div>';
    }

    // ── B. Inggris (A03 / F03) ──
    const iIds = Object.keys(ri);
    if (iIds.length > 0) {
        let iTotal = 0, iCount = 0;
        let iVals = [];
        html += '<div class="mb-2" style="background:var(--bg-body);border-radius:var(--radius-sm);padding:0.6rem 0.9rem;border:1px solid var(--border-color)">' +
            '<div style="font-size:0.72rem;font-weight:700;color:#2a6df0;margin-bottom:0.4rem"><i class="fa-solid fa-language me-1"></i> B. Inggris (A03 / F03)</div>';
        iIds.forEach(function(id) {
            const r = ri[id];
            const v = n(inggris[id]);
            if (v !== null) {
                iTotal += v;
                iCount++;
                iVals.push(v.toFixed(1));
                html += '<div class="d-flex justify-content-between align-items-center mb-1" style="font-size:0.78rem">' +
                    '<span style="flex:1">' + r.field + '</span>' +
                    '<span style="font-weight:700">' + v.toFixed(1) + '</span></div>';
            }
        });
        if (iCount > 0) {
            const avg = iTotal / iCount;
            html += '<div style="font-size:0.72rem;color:#6b7280;padding:0.3rem 0;border-top:1px dashed #e5e7eb;margin-top:0.2rem">' +
                'Rata-rata: (' + iVals.join(' + ') + ') / ' + iCount + ' = ' + avg.toFixed(2) + '</div>';
            html += '<div class="d-flex justify-content-between align-items-center" style="font-size:0.85rem;font-weight:700;color:#111827;margin-top:0.3rem">' +
                'Skor Akhir A03 / F03<span>' + avg.toFixed(1) + ' / 100</span></div>';
        }
        html += '</div>';
    }

    return html;
}

document.querySelectorAll('.btn-detail').forEach(function(btn) {
    btn.addEventListener('click', function() {
        const d = this.dataset;
        const skors = JSON.parse(d.skors);
        const wawancara = JSON.parse(d.wawancara || '{}');
        const naskah = JSON.parse(d.naskah || '{}');
        const presentasi = JSON.parse(d.presentasi || '{}');
        const inggris = JSON.parse(d.inggris || '{}');
        const portofolio = JSON.parse(d.portofolio || '[]');

        document.getElementById('modalNama').textContent = d.nama;
        document.getElementById('modalNimJenjang').textContent = d.nim + ' \u00B7 ' + d.jenjang;
        document.getElementById('modalEditLink').href = d.edit;

        // Ringkasan
        const container = document.getElementById('modalScores');
        container.innerHTML = '';
        kodes.forEach(function(kode) {
            const v = skors[kode];
            const ada = v !== null && v !== undefined && v !== '';
            const num = parseFloat(v);
            const col = document.createElement('div');
            col.className = 'col-6 col-md-4 col-lg-2';
            col.innerHTML = '<div style="padding:0.5rem 0.7rem;border-radius:var(--radius-sm);background:var(--bg-body);border:1px solid var(--border-color);text-align:center">' +
                '<div style="font-size:0.65rem;color:#6b7280;font-weight:600">' + kode + '</div>' +
                '<div style="font-size:1rem;font-weight:700;color:#111827">' + (ada ? num.toFixed(1) : '-') + '</div>' +
                '</div>';
            container.appendChild(col);
        });

        // Detail
        document.getElementById('modalDetailContent').innerHTML = renderDetail(skors, wawancara, naskah, presentasi, inggris, d.jenjangId, portofolio);

        new bootstrap.Modal('#detailModal').show();
    });
});
</script>
@endpush
@endsection
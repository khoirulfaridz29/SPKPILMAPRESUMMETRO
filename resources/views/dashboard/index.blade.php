@extends('layouts.dashboard')
@section('title', 'Dashboard')

@section('content')
<style>
    html, body { height: 100%; }
    .main-wrapper { height: 100vh; }
    .page-content {
        overflow: hidden;
        display: flex;
        flex-direction: column;
        min-height: 0;
    }
    .d-wrap {
        flex: 1;
        min-height: 0;
        display: flex;
        flex-direction: column;
    }
    .d-wrap .row:last-child {
        flex: 1;
        min-height: 0;
        flex-wrap: nowrap;
    }
    .d-wrap .row:last-child > [class*="col-"] {
        display: flex;
        flex-direction: column;
        min-height: 0;
    }
    .s-card {
        background: var(--bg-card);
        border: 1px solid var(--border-color);
        border-radius: var(--radius);
        padding: 1rem 1.25rem;
        display: flex; align-items: center; gap: 1rem;
        transition: transform 0.15s, box-shadow 0.15s;
    }
    .s-card:hover { transform: translateY(-2px); box-shadow: 0 6px 16px rgba(0,0,0,0.06); }
    .s-card .si {
        width: 42px; height: 42px; border-radius: var(--radius-sm);
        display: flex; align-items: center; justify-content: center;
        font-size: 1rem; flex-shrink: 0;
    }
    .s-card .sv { font-size: 1.5rem; font-weight: 800; line-height: 1.1; letter-spacing: -0.02em; }
    .s-card .sl { font-size: 0.78rem; }
    .s-card .bar {
        position: absolute; top: 0; left: 0; bottom: 0; width: 3px;
        border-radius: 3px 0 0 3px;
    }
    .ch-card {
        background: var(--bg-card);
        border: 1px solid var(--border-color);
        border-radius: var(--radius);
        overflow: hidden;
    }
    .ch-card .hd {
        padding: 0.7rem 1.25rem;
        border-bottom: 1px solid var(--border-color);
        display: flex; align-items: center; justify-content: space-between;
    }
    .ch-card .bd { padding: 1rem 1.25rem; }
    .mhs-item {
        display: flex; align-items: center; gap: 0.75rem;
        padding: 0.6rem 0;
        border-bottom: 1px solid var(--border-color);
        transition: background 0.15s ease;
        border-radius: var(--radius-sm);
    }
    .mhs-item:last-child { border-bottom: none; }
    .mhs-item:hover { background: #f0f4ff; cursor: default; }
    .mhs-av {
        width: 36px; height: 36px; border-radius: var(--radius-sm);
        display: flex; align-items: center; justify-content: center;
        font-weight: 700; font-size: 0.85rem; flex-shrink: 0;
    }
    .dl-item {
        display: flex; align-items: flex-start; gap: 0.75rem;
        padding: 0.65rem 0;
        border-bottom: 1px solid var(--border-color);
        transition: background 0.15s ease;
        border-radius: var(--radius-sm);
    }
    .dl-item:last-child { border-bottom: none; }
    .dl-item:hover { background: transparent; cursor: default; }
    .dl-dot {
        width: 8px; height: 8px; border-radius: 50%;
        margin-top: 5px; flex-shrink: 0;
    }
    .ac-btn {
        background: var(--bg-card);
        border: 1px solid var(--border-color);
        border-radius: var(--radius);
        padding: 0.75rem 1rem;
        display: flex; align-items: center; gap: 0.75rem;
        text-decoration: none; color: inherit;
        transition: all 0.15s;
        cursor: pointer;
    }
    .ac-btn:hover {
        border-color: var(--primary-light);
        background: rgba(42,109,240,0.03);
        transform: translateY(-1px);
        box-shadow: 0 4px 12px rgba(0,0,0,0.05);
    }
    .ac-btn .aci {
        width: 36px; height: 36px;
        border-radius: var(--radius-sm);
        display: flex; align-items: center; justify-content: center;
        font-size: 0.95rem; flex-shrink: 0;
    }
    .right-col { display: flex; flex-direction: column; }
    .left-card-wrap { display: flex; }
    .left-card-wrap .ch-card { display: flex; flex-direction: column; width: 100%; }
    .left-card-wrap .ch-card .bd { flex: 1; overflow-y: auto; }
    .st-track { position:relative; padding-left:1.25rem; }
    .st-track::before { content:''; position:absolute; left:2px; top:5px; bottom:5px; width:2px; background:var(--border-color); }
    .st-item { position:relative; padding-bottom:0.75rem; }
    .st-item:last-child { padding-bottom:0; }
    .st-item .st-dot { position:absolute; left:-1.25rem; top:5px; width:7px; height:7px; border-radius:50%; transform:translateX(-50%); z-index:1; }

    .pr-ring { width:56px;height:56px;position:relative; }
    .pr-ring svg { transform:rotate(-90deg); }
    .pr-ring .bg { fill:none;stroke:rgba(255,255,255,0.2);stroke-width:5; }
    .pr-ring .fg { fill:none;stroke:white;stroke-width:5;stroke-linecap:round;transition:stroke-dasharray 0.6s; }
    .pr-ring .ct { position:absolute;inset:0;display:flex;align-items:center;justify-content:center;font-weight:800;font-size:0.9rem; }

    .juri-wlc {
        background:linear-gradient(135deg, #1a3c7a 0%, #2a5fa8 100%);
        border-radius:var(--radius);
        padding:1.25rem;
        color:white;
    }
    .juri-task {
        background:var(--bg-card);
        border:1px solid var(--border-color);
        border-radius:var(--radius);
        display:flex;
        flex-direction:column;
        flex:1;
        min-height:0;
    }
    .juri-task .hd {
        padding:0.7rem 1.25rem;
        border-bottom:1px solid var(--border-color);
        display:flex;align-items:center;justify-content:space-between;
    }
    .juri-task .bd {
        padding:0 1.25rem;
        flex:1;
        overflow-y:auto;
        min-height:0;
    }
    .juri-item {
        display:flex;align-items:center;gap:0.75rem;
        padding:0.65rem 0;
        border-bottom:1px solid var(--border-color);
        transition:background 0.15s ease;
        border-radius:var(--radius-sm);
    }
    .juri-item:last-child { border-bottom:none; }
    .juri-item:hover { background:#f0f4ff; cursor:default; }
    .juri-av {
        width:36px;height:36px;border-radius:var(--radius-sm);
        display:flex;align-items:center;justify-content:center;
        font-weight:700;font-size:0.85rem;flex-shrink:0;
    }
</style>

@php $h = now()->hour; $g = $h < 12 ? 'Pagi' : ($h < 17 ? 'Siang' : 'Malam'); @endphp

<div class="d-wrap">
{{-- GREETING + DATE --}}
<div class="d-flex align-items-center justify-content-between mb-3">
    <div>
        <h5 class="fw-bold mb-0">Selamat {{ $g }}, {{ Auth::user()->nama_lengkap }}</h5>
        <small class="text-muted">
            @switch($role)
                @case('admin') Panel Administrator @break
                @case('mahasiswa') Dashboard Peserta @break
                @case('juri') Panel Penilaian @break
                @case('wr3') Panel Wakil Rektor III @break
            @endswitch
            &middot; PILMAPRES UM Metro
        </small>
    </div>
    <div class="text-end">
        <div class="fw-semibold small">{{ now()->isoFormat('dddd, D MMMM Y') }}</div>
        <small class="text-muted"><span id="liveClock">{{ now()->format('H:i') }}</span> WIB</small>
    </div>
</div>

{{-- ====================== ADMIN ====================== --}}
@if($role === 'admin')

{{-- Stat Cards --}}
<div class="row g-2 mb-3">
    @php $cards = [
        ['total_pendaftar','users','var(--primary-light)','#e8f0fe','Total Pendaftar'],
        ['berkas_lengkap','file-circle-check','#10b981','#e6f7ee','Berkas Lengkap'],
        ['lolos_tahap1','medal','#f59e0b','#fef3c7','Lolos Tahap I'],
        ['total_kriteria','list-check','#8b5cf6','#f0e7fe','Kriteria Penilaian'],
    ]; @endphp
    @foreach($cards as [$key,$icon,$bar,$bg,$lbl])
    <div class="col-6 col-xl-3">
        <div class="s-card position-relative">
            <div class="bar" style="background:{{ $bar }}"></div>
            <div class="si" style="background:{{ $bg }};color:{{ $bar }}"><i class="fa-solid fa-{{ $icon }}"></i></div>
            <div>
                <div class="sv">{{ $stats[$key] }}</div>
                <div class="sl text-muted">{{ $lbl }}</div>
            </div>
        </div>
    </div>
    @endforeach
</div>

{{-- Mahasiswa List + Jadwal --}}
<div class="row g-3" style="flex:1; min-height:0; flex-wrap:nowrap; display:flex">
    <div class="col-lg-8 left-card-wrap">
        <div class="ch-card">
            <div class="hd">
                <span class="small fw-semibold"><i class="fa-solid fa-users me-1 text-primary"></i> Peserta PILMAPRES</span>
                <small class="text-muted">{{ count($mahasiswaList) }} mahasiswa</small>
            </div>
            <div class="bd" style="padding:0 1.25rem">
                @forelse($mahasiswaList as $m)
                @php
                    $sc = match($m->status) {
                        'Lengkap','Lolos T1' => ['#10b981','#e6f7ee'],
                        'Belum Daftar' => ['#94a3b8','#f1f5f9'],
                        default => ['#f59e0b','#fef3c7'],
                    };
                @endphp
                <div class="mhs-item">
                    <div class="mhs-av" style="background:{{ $sc[1] }};color:{{ $sc[0] }}">{{ $m->inisial }}</div>
                    <div class="flex-grow-1 min-w-0">
                        <div class="small fw-semibold text-truncate">{{ $m->nama }}</div>
                        <small class="text-muted">{{ $m->jenjang }} &middot; {{ $m->email }}</small>
                    </div>
                    <span class="badge" style="background:{{ $sc[1] }};color:{{ $sc[0] }};font-size:0.68rem;font-weight:600;border:none;border-radius:var(--radius-sm)">
                        {{ $m->status }}
                    </span>
                </div>
                @empty
                <div class="text-center py-3 text-muted small">
                    <i class="fa-regular fa-users fa-lg mb-1 opacity-50"></i>
                    <div>Belum ada mahasiswa</div>
                </div>
                @endforelse
            </div>
        </div>
    </div>
    <div class="col-lg-4 right-col">
        <div class="ch-card">
            <div class="hd">
                <span class="small fw-semibold"><i class="fa-solid fa-calendar-days me-1 text-danger"></i> Deadline</span>
                <a href="{{ route('admin.jadwal.index') }}" class="small text-decoration-none">Atur</a>
            </div>
            <div class="bd" style="padding:0 1.25rem">
                @forelse($jadwalList as $j)
                @php
                    $now = now();
                    $mulai = \Carbon\Carbon::parse($j->tanggal_mulai);
                    $selesai = \Carbon\Carbon::parse($j->tanggal_selesai);
                    $active = $now->between($mulai, $selesai);
                    $coming = $now->lt($mulai);
                    $dot = $active ? '#ef4444' : ($coming ? '#f59e0b' : '#94a3b8');
                @endphp
                <div class="dl-item">
                    <div class="dl-dot" style="background:{{ $dot }}"></div>
                    <div class="flex-grow-1 min-w-0">
                        <div class="small fw-semibold">{{ $j->kegiatan }}</div>
                        <small class="text-muted">
                            {{ $mulai->format('d M') }}{{ $selesai && !$selesai->eq($mulai) ? ' - '.$selesai->format('d M Y') : '' }}
                        </small>
                        @if($j->keterangan)
                        <br><small class="text-muted" style="font-size:0.65rem">{{ $j->keterangan }}</small>
                        @endif
                    </div>
                </div>
                @empty
                <div class="text-center py-3 text-muted small">
                    <i class="fa-regular fa-calendar fa-lg mb-1 opacity-50"></i>
                    <div>Belum ada jadwal</div>
                </div>
                @endforelse
            </div>
        </div>
        <div class="ch-card mt-3 flex-shrink-0">
            <div class="hd">
                <span class="small fw-semibold"><i class="fa-solid fa-bolt me-1 text-warning"></i> Akses Cepat</span>
            </div>
            <div class="bd d-flex flex-column gap-1">
                <a href="{{ route('admin.users.index') }}" class="ac-btn">
                    <div class="aci" style="background:#e8f0fe;color:var(--primary-light)"><i class="fa-solid fa-users-gear"></i></div>
                    <span class="small fw-semibold">Kelola Akun</span>
                </a>
                <a href="{{ route('admin.pendaftaran.index') }}" class="ac-btn">
                    <div class="aci" style="background:#fef3c7;color:#f59e0b"><i class="fa-solid fa-file-circle-check"></i></div>
                    <span class="small fw-semibold">Pendaftaran</span>
                </a>
                <a href="{{ route('admin.perhitungan.index') }}" class="ac-btn">
                    <div class="aci" style="background:#e6f7ee;color:#10b981"><i class="fa-solid fa-calculator"></i></div>
                    <span class="small fw-semibold">Perhitungan GAP</span>
                </a>
            </div>
        </div>
    </div>
</div>

{{-- ====================== MAHASISWA ====================== --}}
@elseif($role === 'mahasiswa')
@php
    $pd = $stats['pendaftaran'] ?? null;
    $steps = [
        ['Registrasi Akun', true],
        ['Isi Form Pendaftaran', (bool)$pd],
        ['Upload Berkas', $pd && $pd->berkas->count() > 0],
        ['Validasi Admin', $pd && $pd->status_berkas === 'Lengkap'],
        ['Seleksi Juri', $pd && $pd->status_seleksi === 'Lolos Tahap 1'],
        ['Pengumuman Hasil', $pd && $pd->status_seleksi === 'Selesai'],
    ];
@endphp
<div class="row g-3">
    <div class="col-lg-7">
        <div class="ch-card">
            <div class="hd">
                <span class="small fw-semibold"><i class="fa-solid fa-id-card me-1 text-primary"></i> Status Pendaftaran</span>
                @if(!$pd)
                <a href="{{ route('mahasiswa.pendaftaran.create') }}" class="btn btn-primary btn-sm">Daftar</a>
                @endif
            </div>
            <div class="bd">
                @if($pd)
                <div class="row g-2">
                    <div class="col-6">
                        <div class="d-flex align-items-center gap-2 p-2 rounded" style="background:var(--bg-body)">
                            <i class="fa-solid fa-calendar-day text-primary fa-sm"></i>
                            <div>
                                <small class="text-muted d-block lh-1">Tanggal Daftar</small>
                                <span class="fw-semibold small">{{ $pd->tanggal_daftar->format('d M Y') }}</span>
                            </div>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="d-flex align-items-center gap-2 p-2 rounded" style="background:var(--bg-body)">
                            <i class="fa-solid fa-file-circle-check text-success fa-sm"></i>
                            <div>
                                <small class="text-muted d-block lh-1">Berkas</small>
                                <span class="badge bg-{{ $pd->status_berkas === 'Lengkap' ? 'success' : 'warning text-dark' }}">{{ $pd->status_berkas }}</span>
                            </div>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="d-flex align-items-center gap-2 p-2 rounded" style="background:var(--bg-body)">
                            <i class="fa-solid fa-medal text-warning fa-sm"></i>
                            <div>
                                <small class="text-muted d-block lh-1">Seleksi</small>
                                @php $sc = ['Proses'=>'primary','Lolos Tahap 1'=>'success','Tidak Lolos'=>'danger','Selesai'=>'info']; @endphp
                                <span class="badge bg-{{ $sc[$pd->status_seleksi] ?? 'secondary' }}">{{ $pd->status_seleksi }}</span>
                            </div>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="d-flex align-items-center gap-2 p-2 rounded" style="background:var(--bg-body)">
                            <i class="fa-solid fa-folder-open text-info fa-sm"></i>
                            <div>
                                <small class="text-muted d-block lh-1">Diunggah</small>
                                <span class="fw-semibold small">{{ $pd->berkas->count() }} berkas</span>
                            </div>
                        </div>
                    </div>
                </div>
                <a href="{{ route('mahasiswa.berkas.index') }}" class="btn btn-outline-primary btn-sm mt-2">
                    <i class="fa-solid fa-upload me-1"></i> Kelola Berkas
                </a>
                @else
                <div class="text-center py-3 text-muted">
                    <i class="fa-regular fa-folder-open fa-lg mb-1 opacity-50"></i>
                    <p class="small mb-0">Anda belum mendaftar.</p>
                </div>
                @endif
            </div>
        </div>
    </div>
    <div class="col-lg-5">
        <div class="ch-card h-100">
            <div class="hd">
                <span class="small fw-semibold"><i class="fa-solid fa-route me-1 text-success"></i> Alur Pendaftaran</span>
            </div>
            <div class="bd">
                <div class="st-track">
                    @foreach($steps as [$label, $done])
                    <div class="st-item d-flex align-items-center gap-2">
                        <div class="st-dot" style="background:{{ $done ? '#10b981' : '#cbd5e1' }}"></div>
                        <span class="small {{ $done ? 'fw-semibold' : 'text-muted' }}">{{ $label }}</span>
                        @if($done)<i class="fa-solid fa-check ms-auto text-success" style="font-size:0.65rem"></i>@endif
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>

{{-- ====================== JURI ====================== --}}
@elseif($role === 'juri')
@php $pct = $stats['total_tugas'] > 0 ? round(($stats['total_selesai'] / $stats['total_tugas']) * 100) : 0; @endphp
<div class="row g-3" style="flex:1;min-height:0;flex-wrap:nowrap">
    <div class="col-lg-8" style="display:flex;flex-direction:column;height:100%">
        <div class="juri-task">
            <div class="hd">
                <span class="small fw-semibold"><i class="fa-solid fa-list-check me-1 text-primary"></i> Penugasan Saya</span>
                <small class="text-muted">{{ $stats['total_selesai'] }}/{{ $stats['total_tugas'] }} selesai</small>
            </div>
            <div class="bd">
                @forelse($penugasanList as $t)
                @php $c = $t->selesai ? ['#10b981','#e6f7ee'] : ['#f59e0b','#fef3c7']; @endphp
                <div class="juri-item">
                    <div class="juri-av" style="background:{{ $c[1] }};color:{{ $c[0] }}">{{ $t->inisial }}</div>
                    <div class="flex-grow-1 min-w-0">
                        <div class="small fw-semibold text-truncate">{{ $t->nama }}</div>
                        <small class="text-muted">{{ $t->jenjang }} &middot; {{ $t->prodi }}</small>
                    </div>
                    <span class="badge" style="background:{{ $c[1] }};color:{{ $c[0] }};font-size:0.68rem;font-weight:600;border:none;border-radius:var(--radius-sm)">
                        {{ $t->selesai ? 'Selesai' : 'Baru' }}
                    </span>
                </div>
                @empty
                <div class="text-center py-3 text-muted small">
                    <i class="fa-regular fa-list fa-lg mb-1 opacity-50"></i>
                    <div>Belum ada penugasan</div>
                </div>
                @endforelse
            </div>
        </div>
    </div>
    <div class="col-lg-4 d-flex flex-column gap-3">
        <div class="juri-wlc d-flex align-items-center gap-3">
            <div class="pr-ring">
                <svg width="56" height="56" viewBox="0 0 56 56">
                    <circle class="bg" cx="28" cy="28" r="22.5"/>
                    <circle class="fg" cx="28" cy="28" r="22.5" stroke-dasharray="{{ round(141.37 * $pct / 100) }} 141.37"/>
                </svg>
                <div class="ct">{{ $pct }}%</div>
            </div>
            <div>
                <div class="fw-bold" style="font-size:0.9rem">{{ Auth::user()->nama_lengkap }}</div>
                <small style="opacity:0.75">Juri PILMAPRES</small>
            </div>
        </div>
        <div class="ch-card">
            <div class="hd position-relative">
                <span class="small fw-semibold"><i class="fa-solid fa-book me-1 text-primary"></i> Peraturan Penilaian</span>
                @php $panduanList = \App\Models\Panduan::latest()->get(); @endphp
                @if($panduanList->isNotEmpty())
                <button class="btn btn-sm btn-outline-primary px-2 py-0" type="button" data-bs-toggle="modal" data-bs-target="#panduanModal" style="border-radius:var(--radius-sm);font-size:0.72rem">
                    <i class="fa-solid fa-download me-1"></i> Unduh
                </button>
                @endif
            </div>
            <div class="bd d-flex flex-column gap-2" style="padding:0.85rem 1.25rem">
                <div class="d-flex align-items-start gap-2">
                    <i class="fa-solid fa-1 text-primary fa-sm mt-1" style="width:16px;text-align:center"></i>
                    <div><div class="small fw-semibold">Capaian Unggulan (CU Berkas)</div><small class="text-muted">Skor rekomendasi dari sertifikat tervalidasi. Juri dapat menyesuaikan ±10 dari skor rekomendasi.</small></div>
                </div>
                <div class="d-flex align-items-start gap-2">
                    <i class="fa-solid fa-2 text-primary fa-sm mt-1" style="width:16px;text-align:center"></i>
                    <div><div class="small fw-semibold">Naskah & Presentasi GK</div><small class="text-muted">Skala penilaian 60–100 untuk setiap aspek rubrik. Nilai akhir dihitung berdasarkan bobot per aspek.</small></div>
                </div>
                <div class="d-flex align-items-start gap-2">
                    <i class="fa-solid fa-3 text-primary fa-sm mt-1" style="width:16px;text-align:center"></i>
                    <div><div class="small fw-semibold">Wawancara CU</div><small class="text-muted">Skala penilaian 60–100 untuk setiap kriteria wawancara. Bobot per kriteria sudah ditentukan admin.</small></div>
                </div>
                <div class="d-flex align-items-start gap-2">
                    <i class="fa-solid fa-4 text-primary fa-sm mt-1" style="width:16px;text-align:center"></i>
                    <div><div class="small fw-semibold">Bahasa Inggris</div><small class="text-muted">Input skor berdasarkan rubrik kategori: Excellent, Good, Fair, atau Poor. Skor yang sama digunakan untuk Video dan Lisan.</small></div>
                </div>
                <div class="d-flex align-items-start gap-2">
                    <i class="fa-solid fa-5 text-primary fa-sm mt-1" style="width:16px;text-align:center"></i>
                    <div><div class="small fw-semibold">Lengkapi Semua Tab</div><small class="text-muted">Kelima tab penilaian (CU, Naskah, Presentasi, Inggris, Wawancara) harus diisi sebelum sistem dapat memproses.</small></div>
                </div>
            </div>
        </div>
        <a href="{{ route('juri.penilaian.index') }}" class="ac-btn justify-content-center fw-semibold" style="color:var(--primary);border:2px solid var(--primary-light)">
            <i class="fa-solid fa-clipboard-check"></i> Mulai Penilaian
        </a>
    </div>
</div>

{{-- ====================== WR3 ====================== --}}
@elseif($role === 'wr3')
<div class="row g-2 mb-3">
    @php $wr3 = [
        ['total_rekap','clipboard-list','var(--primary-light)','#e8f0fe','Total Rekap Masuk'],
        ['sudah_validasi','file-circle-check','#10b981','#e6f7ee','Sudah Divalidasi'],
        ['hasil_pending','trophy','#f59e0b','#fef3c7','Hasil Perlu Validasi'],
    ]; @endphp
    @foreach($wr3 as [$key,$icon,$bar,$bg,$lbl])
    <div class="col-sm-4">
        <div class="s-card position-relative">
            <div class="bar" style="background:{{ $bar }}"></div>
            <div class="si" style="background:{{ $bg }};color:{{ $bar }}"><i class="fa-solid fa-{{ $icon }}"></i></div>
            <div>
                <div class="sv">{{ $stats[$key] }}</div>
                <div class="sl text-muted">{{ $lbl }}</div>
            </div>
        </div>
    </div>
    @endforeach
</div>

@php $pendingRekap = $stats['total_rekap'] - $stats['sudah_validasi']; @endphp
@if($pendingRekap > 0 || $stats['hasil_pending'] > 0)
<div class="alert alert-warning d-flex align-items-center gap-2 py-2 px-3 mb-3" role="alert" style="border-radius:var(--radius);border:none;background:#fef3c7;">
    <i class="fa-solid fa-triangle-exclamation text-warning" style="font-size:1.1rem"></i>
    <div class="small">
        <strong>Perhatian:</strong>
        @if($pendingRekap > 0 && $stats['hasil_pending'] > 0)
            Ada <strong>{{ $pendingRekap }}</strong> rekap berkas dan <strong>{{ $stats['hasil_pending'] }}</strong> hasil perangkingan yang perlu divalidasi.
        @elseif($pendingRekap > 0)
            Ada <strong>{{ $pendingRekap }}</strong> rekap berkas yang perlu divalidasi. Buka <strong>Validasi Laporan Tahap I</strong> di bawah.
        @else
            Ada <strong>{{ $stats['hasil_pending'] }}</strong> hasil perangkingan yang perlu divalidasi. Buka <strong>Rekomendasi Mahasiswa Berprestasi</strong> di bawah.
        @endif
    </div>
</div>
@endif

<div class="row g-3">
    <div class="col-md-6">
        <a href="{{ route('wr3.validasi.index') }}" class="ac-btn">
            <div class="aci" style="background:#e8f0fe;color:var(--primary-light)"><i class="fa-solid fa-file-shield"></i></div>
            <div><div class="small fw-semibold">Validasi Laporan Tahap I</div><small class="text-muted">Tinjau rekap berkas dari Bidang Kemahasiswaan</small></div>
        </a>
    </div>
    <div class="col-md-6">
        <a href="{{ route('wr3.rekomendasi.index') }}" class="ac-btn">
            <div class="aci" style="background:#fef3c7;color:#f59e0b"><i class="fa-solid fa-ranking-star"></i></div>
            <div><div class="small fw-semibold">Rekomendasi Mahasiswa Berprestasi</div><small class="text-muted">Lihat perangkingan dan validasi juara</small></div>
        </a>
    </div>
</div>
</div>{{-- /.d-wrap --}}
@endif

{{-- Modal Panduan --}}
@php $panduanList = \App\Models\Panduan::latest()->get(); @endphp
@if($panduanList->isNotEmpty())
<div class="modal fade" id="panduanModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" style="max-width:460px">
        <div class="modal-content" style="border-radius:var(--radius);border:none;box-shadow:0 20px 60px rgba(0,0,0,0.2)">
            <div class="modal-header border-0 pb-0">
                <h6 class="fw-bold mb-0"><i class="fa-solid fa-book me-2 text-primary"></i>Unduh Panduan</h6>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body" style="padding:1rem 1.25rem">
                @foreach($panduanList as $p)
                <a href="{{ route('panduan.download', $p) }}" class="d-flex align-items-center gap-3 text-decoration-none p-2 rounded mb-1" style="transition:background 0.15s;color:inherit" onmouseover="this.style.background='var(--bg-body)'" onmouseout="this.style.background='transparent'">
                    <div style="width:40px;height:40px;border-radius:var(--radius-sm);background:#fef2f2;display:flex;align-items:center;justify-content:center;flex-shrink:0">
                        <i class="fa-solid fa-file-pdf text-danger"></i>
                    </div>
                    <div class="flex-grow-1 min-w-0">
                        <div class="small fw-semibold">{{ $p->judul }}</div>
                        @if($p->deskripsi)<small class="text-muted">{{ Str::limit($p->deskripsi, 50) }}</small>@endif
                    </div>
                    <i class="fa-solid fa-download text-muted fa-sm flex-shrink-0"></i>
                </a>
                @endforeach
            </div>
        </div>
    </div>
</div>
@endif

{{-- Real-time clock --}}
@push('scripts')
<script>
(function() {
    var clockEl = document.getElementById('liveClock');
    if (!clockEl) return;
    function updateClock() {
        var el = document.getElementById('liveClock');
        if (!el) return;
        var now = new Date();
        el.textContent =
            String(now.getHours()).padStart(2, '0') + ':' +
            String(now.getMinutes()).padStart(2, '0');
    }
    var clockInterval = setInterval(updateClock, 1000);
    updateClock();
    document.addEventListener('turbo:before-cache', function() {
        clearInterval(clockInterval);
    });
})();
</script>
@endpush

@endsection

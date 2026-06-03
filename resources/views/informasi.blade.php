@extends('layouts.frontend')

@section('custom-css')
<style>
    .page-header {
        background-color: #1e40af !important;
        background: linear-gradient(135deg, #1e40af 0%, #3b82f6 100%) !important;
        position: relative;
        overflow: hidden;
    }
    .page-header::before {
        content: '';
        position: absolute;
        top: 0; left: 0; right: 0; bottom: 0;
        background-image: radial-gradient(rgba(255, 255, 255, 0.1) 1px, transparent 1px);
        background-size: 30px 30px;
        pointer-events: none;
    }
    .page-header .blob {
        position: absolute;
        width: 400px;
        height: 400px;
        background: rgba(255, 255, 255, 0.1);
        filter: blur(80px);
        border-radius: 50%;
        z-index: 0;
    }
    .page-header .blob-1 { top: -100px; right: -100px; background: rgba(255, 170, 0, 0.15); }
    .page-header .blob-2 { bottom: -150px; left: -100px; }
    .page-header .container {
        position: relative;
        z-index: 1;
        text-align: center;
    }

    .info-card {
        border: none;
        border-radius: 15px;
        box-shadow: 0 5px 20px rgba(0,0,0,0.05);
        transition: transform 0.3s;
        margin-bottom: 30px;
    }
    .info-card:hover {
        transform: translateY(-5px);
    }
    .icon-box {
        width: 60px;
        height: 60px;
        background-color: #eef2ff;
        color: #4f46e5;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 24px;
        margin-bottom: 20px;
    }
</style>
@endsection

@section('content')
<div class="page-header">
    <div class="container">
        <h1 class="fw-bold">Informasi PILMAPRES</h1>
        <p class="lead">Pusat informasi dan panduan Pemilihan Mahasiswa Berprestasi UM Metro</p>
    </div>
</div>

<div class="container mt-5">
    <div class="row">
        <div class="col-lg-8 mx-auto">
            <div class="card info-card">
                <div class="card-body p-4 p-md-5">
                    <h3 class="fw-bold mb-4">Syarat Pendaftaran</h3>
                    <ol class="list-group list-group-numbered list-group-flush mb-5">
                        <li class="list-group-item border-0 py-2">Terdaftar sebagai mahasiswa aktif program Sarjana (S1) atau Diploma.</li>
                        <li class="list-group-item border-0 py-2">Berusia tidak lebih dari 22 tahun pada saat mendaftar.</li>
                        <li class="list-group-item border-0 py-2">Memiliki Indeks Prestasi Kumulatif (IPK) minimal 3.00.</li>
                        <li class="list-group-item border-0 py-2">Surat pengantar dari Dekan Fakultas masing-masing.</li>
                        <li class="list-group-item border-0 py-2">Belum pernah menjadi finalis PILMAPRES tingkat Nasional.</li>
                    </ol>

                    <h3 class="fw-bold mb-4">Dokumen Persyaratan</h3>
                    <div class="row g-4">
                        @forelse($persyaratan as $item)
                        <div class="col-md-6">
                            <div class="d-flex align-items-start">
                                <div class="icon-box me-3 mt-1 {{ $item->is_required ? 'text-primary' : 'text-muted' }}">
                                    <i class="fa-solid fa-file-circle-check"></i>
                                </div>
                                <div>
                                    <h5 class="fw-bold mb-1">{{ $item->nama_syarat }}</h5>
                                    @if($item->is_required)
                                        <span class="badge bg-danger mb-2" style="font-size: 10px;">Wajib</span>
                                    @else
                                        <span class="badge bg-secondary mb-2" style="font-size: 10px;">Opsional</span>
                                    @endif
                                    <p class="text-muted small">{{ $item->keterangan ?? '-' }}</p>
                                </div>
                            </div>
                        </div>
                        @empty
                        <div class="col-12 text-center py-4">
                            <p class="text-muted">Daftar persyaratan belum diunggah oleh panitia.</p>
                        </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

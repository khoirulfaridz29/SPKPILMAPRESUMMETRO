@extends('layouts.dashboard')
@section('title', 'Rekap Tahap I')

@section('content')
<style>
    /* Premium visual style for standard view */
    .rekap-card {
        border: none;
        border-radius: 12px;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.05);
    }
    
    /* Print Styling */
    @media print {
        body {
            background: #ffffff !important;
            color: #000000 !important;
            font-family: "Times New Roman", Times, serif;
            font-size: 12pt;
            padding: 0;
            margin: 1.5cm;
        }
        /* Hide navbar, sidebar, buttons, actions, and non-printable elements */
        .sidebar, .navbar, .btn, .no-print, .breadcrumb, footer, form {
            display: none !important;
        }
        .main-content, .container-fluid, .card, .card-body {
            border: none !important;
            box-shadow: none !important;
            background: transparent !important;
            padding: 0 !important;
            margin: 0 !important;
            width: 100% !important;
        }
        /* Formal table styling for printing */
        .excel-table {
            width: 100% !important;
            border-collapse: collapse !important;
            margin-top: 15px;
        }
        .excel-table th, .excel-table td {
            border: 1px solid #000000 !important;
            padding: 8px !important;
            font-size: 11pt !important;
            color: #000000 !important;
        }
        .excel-table th {
            background-color: #f2f2f2 !important;
            font-weight: bold !important;
            text-transform: uppercase;
        }
        .print-header {
            display: block !important;
        }
        .print-title {
            display: block !important;
            text-align: center;
            font-weight: bold;
            text-transform: uppercase;
            font-size: 14pt;
            margin: 20px 0 10px 0;
            text-decoration: underline;
        }
        .print-signature {
            display: block !important;
            margin-top: 40px;
            float: right;
            text-align: center;
            width: 250px;
            font-size: 11pt;
        }
    }
</style>

<!-- KOP Surat Resmi UM Metro (Hanya Muncul saat Cetak / Print) -->
<div class="print-header d-none d-print-block">
    <table style="width: 100%; border-collapse: collapse; border: none; margin-bottom: 10px;">
        <tr style="border: none;">
            <td style="width: 90px; text-align: center; border: none; padding: 5px;">
                <img src="{{ asset('assets/UM-Metro.png') }}" alt="Logo UM Metro" style="width: 85px; height: auto;">
            </td>
            <td style="text-align: center; border: none; padding: 5px; line-height: 1.3;">
                <h3 style="margin: 0; font-weight: bold; color: #003399; font-size: 18px; font-family: 'Times New Roman', Times, serif; text-transform: uppercase; letter-spacing: 0.5px;">UNIVERSITAS MUHAMMADIYAH METRO</h3>
                <p style="margin: 3px 0 0 0; font-size: 9.5px; font-family: Arial, sans-serif; color: #222; font-weight: 500; white-space: nowrap;">Alamat: Jl. Ki Hajar Dewantara No. 116 Iringmulyo Kota Metro Telp./Fax. (0725) 42454 Kode Pos 34112</p>
                <p style="margin: 2px 0 0 0; font-size: 9.5px; font-family: Arial, sans-serif; color: #222; font-weight: 500; white-space: nowrap;">Website: www.ummetro.ac.id | e-mail: info@ummetro.ac.id</p>
            </td>
        </tr>
    </table>
    <!-- Double border divider lines -->
    <div style="border-top: 3px solid #000000; border-bottom: 1px solid #000000; height: 3px; margin-bottom: 15px; width: 100%;"></div>
</div>

<div class="print-title d-none d-print-block">
    REKAPITULASI BERKAS PENDAFTARAN MAHASISWA BERPRESTASI (TAHAP I)
</div>

<div class="d-flex justify-content-between align-items-center mb-4 no-print">
    <div>
        <h4 class="fw-bold mb-1"><i class="fa-solid fa-folder-open text-primary me-2"></i> Rekap Berkas Pendaftaran (Tahap I)</h4>
        <p class="text-muted small mb-0">Halaman ini digunakan untuk mengelola status kelulusan berkas administrasi awal mahasiswa.</p>
    </div>
    <div class="d-flex gap-2">
        <button onclick="window.print()" class="btn btn-outline-dark px-3 rounded-pill">
            <i class="fa-solid fa-print me-2"></i> Cetak Laporan
        </button>
        <a href="{{ route('admin.rekap.penugasan') }}" class="btn btn-warning px-3 rounded-pill fw-semibold">
            <i class="fa-solid fa-gavel me-2"></i> Penugasan Juri
        </a>
    </div>
</div>

<div class="card rekap-card">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover mb-0 align-middle excel-table">
                <thead class="table-light">
                    <tr>
                        <th class="ps-4">No</th>
                        <th>Nama Mahasiswa</th>
                        <th>NIM</th>
                        <th>Status Laporan Berkas</th>
                        <th>Status Seleksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($rekaps as $i => $r)
                    <tr>
                        <td class="ps-4 text-muted">{{ $i + 1 }}</td>
                        <td class="fw-bold text-dark">{{ $r->pendaftaran->mahasiswa->user->nama_lengkap }}</td>
                        <td><code>{{ $r->pendaftaran->mahasiswa->nim }}</code></td>
                        <td>
                            <span class="badge {{ $r->status_laporan === 'Divalidasi' ? 'bg-success' : 'bg-secondary' }}">
                                {{ $r->status_laporan }}
                            </span>
                        </td>
                        <td>
                            @php $colors = ['Proses'=>'primary','Lolos Tahap 1'=>'success','Tidak Lolos'=>'danger','Selesai'=>'info']; @endphp
                            <span class="badge bg-{{ $colors[$r->pendaftaran->status_seleksi] ?? 'secondary' }} rounded-pill px-3">
                                {{ $r->pendaftaran->status_seleksi }}
                            </span>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="text-center py-5 text-muted no-print">
                            <i class="fa-solid fa-inbox fa-2x mb-2 d-block text-secondary"></i> Belum ada rekap. Verifikasi dulu berkas peserta di menu Pendaftaran.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Tanda Tangan Resmi (Hanya Muncul saat Cetak / Print) -->
<div class="print-signature d-none d-print-block">
    <p style="margin-bottom: 60px;">
        Metro, {{ \Carbon\Carbon::now()->translatedFormat('d F Y') }}<br>
        <strong>Wakil Rektor III</strong>
    </p>
    <p style="text-decoration: underline; font-weight: bold; margin-bottom: 0;">
        Bapak Wakil Rektor III
    </p>
    <p style="margin-top: 0; font-size: 10pt; color: #333;">NIDN. / NIP.</p>
</div>
@endsection

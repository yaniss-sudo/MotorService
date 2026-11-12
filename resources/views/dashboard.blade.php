@extends('layouts.main')
@section('title', 'Dashboard')

@section('content')
@php
    $totalPelanggan = class_exists(\App\Models\Pelanggan::class) ? \App\Models\Pelanggan::count() : 0;
    $totalKendaraan = class_exists(\App\Models\Kendaraan::class) ? \App\Models\Kendaraan::count() : 0;
    $totalDaftarService = class_exists(\App\Models\DaftarService::class) ? \App\Models\DaftarService::count() : 0;
    $totalDataService = class_exists(\App\Models\DataService::class) ? \App\Models\DataService::count() : 0;
    $totalPembayaran = class_exists(\App\Models\Pembayaran::class) ? \App\Models\Pembayaran::count() : 0;
@endphp

<!-- BANNER HEADER -->
<div class="module-banner" style="background-image: url('{{ asset('images/christian-buehner-Fd6osyVbtG4-unsplash.jpg') }}');">
    <div class="module-banner-content">
        <div>
            <span class="module-eyebrow">Ringkasan Operasional</span>
            <h1 class="page-title">Halo, {{ auth()->user()->name }}</h1>
            <p class="page-subtitle">Pantau ringkasan data bengkel dan akses cepat ke seluruh modul layanan.</p>
        </div>

        @if(auth()->user()->isAdmin())
            <a href="{{ route('daftar-service.create') }}" class="btn btn-primary d-inline-flex align-items-center gap-2">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round">
                    <line x1="12" y1="5" x2="12" y2="19"></line>
                    <line x1="5" y1="12" x2="19" y2="12"></line>
                </svg>
                <span>Tambah Daftar Service</span>
            </a>
        @else
            <a href="{{ route('daftar-service.index') }}" class="btn btn-primary">
                Lihat Daftar Service
            </a>
        @endif
    </div>
</div>

<!-- KARTU RINGKASAN DATA -->
<div class="row g-3 mb-4">
    <div class="col-sm-6 col-xl-3">
        <a href="{{ route('pelanggan.index') }}" class="card text-decoration-none h-100">
            <div class="card-body p-4 d-flex flex-column justify-content-between">
                <div class="d-flex align-items-center justify-content-between mb-3">
                    <span class="text-uppercase fw-bold" style="font-size: 0.72rem; letter-spacing: 0.06em; color: var(--text-muted);">Pelanggan</span>
                    <span class="id-badge">Master</span>
                </div>
                <div>
                    <div class="fw-bold text-white" style="font-size: 1.85rem; line-height: 1.1;">{{ $totalPelanggan }}</div>
                    <div class="mt-2" style="font-size: 0.8rem; color: #fdba74;">Kelola data pelanggan &rarr;</div>
                </div>
            </div>
        </a>
    </div>

    <div class="col-sm-6 col-xl-3">
        <a href="{{ route('kendaraan.index') }}" class="card text-decoration-none h-100">
            <div class="card-body p-4 d-flex flex-column justify-content-between">
                <div class="d-flex align-items-center justify-content-between mb-3">
                    <span class="text-uppercase fw-bold" style="font-size: 0.72rem; letter-spacing: 0.06em; color: var(--text-muted);">Kendaraan</span>
                    <span class="id-badge">Unit</span>
                </div>
                <div>
                    <div class="fw-bold text-white" style="font-size: 1.85rem; line-height: 1.1;">{{ $totalKendaraan }}</div>
                    <div class="mt-2" style="font-size: 0.8rem; color: #fdba74;">Kelola unit motor &rarr;</div>
                </div>
            </div>
        </a>
    </div>

    <div class="col-sm-6 col-xl-3">
        <a href="{{ route('daftar-service.index') }}" class="card text-decoration-none h-100">
            <div class="card-body p-4 d-flex flex-column justify-content-between">
                <div class="d-flex align-items-center justify-content-between mb-3">
                    <span class="text-uppercase fw-bold" style="font-size: 0.72rem; letter-spacing: 0.06em; color: var(--text-muted);">Daftar Service</span>
                    <span class="id-badge">Antrean</span>
                </div>
                <div>
                    <div class="fw-bold text-white" style="font-size: 1.85rem; line-height: 1.1;">{{ $totalDaftarService }}</div>
                    <div class="mt-2" style="font-size: 0.8rem; color: #fdba74;">Lihat keluhan masuk &rarr;</div>
                </div>
            </div>
        </a>
    </div>

    <div class="col-sm-6 col-xl-3">
        <a href="{{ route('data-service.index') }}" class="card text-decoration-none h-100">
            <div class="card-body p-4 d-flex flex-column justify-content-between">
                <div class="d-flex align-items-center justify-content-between mb-3">
                    <span class="text-uppercase fw-bold" style="font-size: 0.72rem; letter-spacing: 0.06em; color: var(--text-muted);">Data Service</span>
                    <span class="id-badge">Riwayat</span>
                </div>
                <div>
                    <div class="fw-bold text-white" style="font-size: 1.85rem; line-height: 1.1;">{{ $totalDataService }}</div>
                    <div class="mt-2" style="font-size: 0.8rem; color: #fdba74;">Lihat detail servis &rarr;</div>
                </div>
            </div>
        </a>
    </div>
</div>

<!-- AKSES MODUL & INFORMASI AKUN -->
<div class="row g-3">
    <div class="col-lg-8">
        <div class="card h-100">
            <div class="card-header d-flex align-items-center justify-content-between">
                <span class="text-white">Navigasi Modul Bengkel</span>
                <span class="data-counter">{{ $totalPembayaran }} Transaksi Pembayaran</span>
            </div>
            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead>
                        <tr>
                            <th>Modul</th>
                            <th>Fungsi Utama</th>
                            <th class="text-end">Akses</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td class="fw-semibold text-white">Pelanggan</td>
                            <td style="color: var(--text-muted); font-size: 0.85rem;">Data identitas, nomor kontak, dan alamat pemilik kendaraan.</td>
                            <td class="text-end text-nowrap">
                                <div class="action-group">
                                    <a href="{{ route('pelanggan.index') }}" class="btn btn-secondary btn-sm">Buka</a>
                                    @if(auth()->user()->isAdmin())
                                        <a href="{{ route('pelanggan.create') }}" class="btn btn-primary btn-sm">+ Tambah</a>
                                    @endif
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td class="fw-semibold text-white">Kendaraan</td>
                            <td style="color: var(--text-muted); font-size: 0.85rem;">Pencatatan nomor plat, merek, tipe motor, dan relasi pemilik.</td>
                            <td class="text-end text-nowrap">
                                <div class="action-group">
                                    <a href="{{ route('kendaraan.index') }}" class="btn btn-secondary btn-sm">Buka</a>
                                    @if(auth()->user()->isAdmin())
                                        <a href="{{ route('kendaraan.create') }}" class="btn btn-primary btn-sm">+ Tambah</a>
                                    @endif
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td class="fw-semibold text-white">Daftar Service</td>
                            <td style="color: var(--text-muted); font-size: 0.85rem;">Pendaftaran antrean servis dan keluhan awal kendaraan.</td>
                            <td class="text-end text-nowrap">
                                <div class="action-group">
                                    <a href="{{ route('daftar-service.index') }}" class="btn btn-secondary btn-sm">Buka</a>
                                    @if(auth()->user()->isAdmin())
                                        <a href="{{ route('daftar-service.create') }}" class="btn btn-primary btn-sm">+ Tambah</a>
                                    @endif
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td class="fw-semibold text-white">Data Service</td>
                            <td style="color: var(--text-muted); font-size: 0.85rem;">Detail tindakan perbaikan, suku cadang, dan rincian biaya.</td>
                            <td class="text-end text-nowrap">
                                <div class="action-group">
                                    <a href="{{ route('data-service.index') }}" class="btn btn-secondary btn-sm">Buka</a>
                                    @if(auth()->user()->isAdmin())
                                        <a href="{{ route('data-service.create') }}" class="btn btn-primary btn-sm">+ Tambah</a>
                                    @endif
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td class="fw-semibold text-white">Pembayaran</td>
                            <td style="color: var(--text-muted); font-size: 0.85rem;">Pencatatan transaksi tunai dan non-tunai pelanggan.</td>
                            <td class="text-end text-nowrap">
                                <div class="action-group">
                                    <a href="{{ route('pembayaran.index') }}" class="btn btn-secondary btn-sm">Buka</a>
                                    @if(auth()->user()->isAdmin())
                                        <a href="{{ route('pembayaran.create') }}" class="btn btn-primary btn-sm">+ Tambah</a>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="col-lg-4">
        <div class="card h-100">
            <div class="card-header text-white">Informasi Sesi</div>
            <div class="card-body p-4 d-flex flex-column justify-content-between">
                <div>
                    <div class="mb-3 pb-3" style="border-bottom: 1px solid var(--border-subtle);">
                        <div style="font-size: 0.75rem; color: var(--text-muted);">Nama Pengguna</div>
                        <div class="fw-semibold text-white mt-1">{{ auth()->user()->name }}</div>
                    </div>

                    <div class="mb-3 pb-3" style="border-bottom: 1px solid var(--border-subtle);">
                        <div style="font-size: 0.75rem; color: var(--text-muted);">Email Terdaftar</div>
                        <div class="text-white mt-1" style="font-size: 0.875rem;">{{ auth()->user()->email }}</div>
                    </div>

                    <div class="mb-4">
                        <div style="font-size: 0.75rem; color: var(--text-muted);">Hak Akses</div>
                        <div class="mt-1">
                            <span class="role-tag">{{ auth()->user()->role }}</span>
                        </div>
                    </div>
                </div>

                <a href="{{ route('profile.edit') }}" class="btn btn-secondary w-100">
                    Pengaturan Profil &amp; Kata Sandi
                </a>
            </div>
        </div>
    </div>
</div>
@endsection

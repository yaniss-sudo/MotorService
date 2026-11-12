@extends('layouts.main')
@section('title', 'Dashboard')

@section('content')
@php
    $totalPelanggan = \App\Models\Pelanggan::count();
    $totalKendaraan = \App\Models\Kendaraan::count();
    $totalDaftarService = \App\Models\DaftarService::count();
    $totalDataService = \App\Models\DataService::count();
    $totalPembayaran = \App\Models\Pembayaran::count();

    $servisTerbaru = \App\Models\DaftarService::with('pelanggan')
        ->orderByDesc('tanggal_servis')
        ->orderByDesc('id_servis')
        ->take(6)
        ->get();

    $pelangganTerbaru = \App\Models\Pelanggan::orderByDesc('id_pelanggan')
        ->take(6)
        ->get();
@endphp

<!-- HEADER RINGKAS -->
<div class="dash-topbar">
    <div>
        <div class="dash-date">{{ \Carbon\Carbon::now()->translatedFormat('l, d F Y') }}</div>
        <h1 class="page-title">Dashboard</h1>
    </div>

    @if(auth()->user()->isAdmin())
        <div class="quick-bar">
            <a href="{{ route('pelanggan.create') }}" class="btn btn-secondary btn-sm">+ Pelanggan</a>
            <a href="{{ route('kendaraan.create') }}" class="btn btn-secondary btn-sm">+ Kendaraan</a>
            <a href="{{ route('pembayaran.create') }}" class="btn btn-secondary btn-sm">+ Pembayaran</a>
            <a href="{{ route('daftar-service.create') }}" class="btn btn-primary btn-sm">+ Daftar Service</a>
        </div>
    @endif
</div>

<!-- 5 METRIK UTAMA DALAM SATU BARIS -->
<div class="kpi-strip">
    <a href="{{ route('pelanggan.index') }}" class="kpi-cell">
        <span class="kpi-label">Pelanggan</span>
        <span class="kpi-value">{{ $totalPelanggan }}</span>
    </a>

    <a href="{{ route('kendaraan.index') }}" class="kpi-cell">
        <span class="kpi-label">Kendaraan</span>
        <span class="kpi-value">{{ $totalKendaraan }}</span>
    </a>

    <a href="{{ route('daftar-service.index') }}" class="kpi-cell">
        <span class="kpi-label">Daftar Service</span>
        <span class="kpi-value">{{ $totalDaftarService }}</span>
    </a>

    <a href="{{ route('data-service.index') }}" class="kpi-cell">
        <span class="kpi-label">Data Service</span>
        <span class="kpi-value">{{ $totalDataService }}</span>
    </a>

    <a href="{{ route('pembayaran.index') }}" class="kpi-cell">
        <span class="kpi-label">Pembayaran</span>
        <span class="kpi-value">{{ $totalPembayaran }}</span>
    </a>
</div>

<!-- DATA OPERASIONAL TERKINI -->
<div class="row g-3">
    <!-- ANTREAN / SERVIS MASUK TERBARU -->
    <div class="col-lg-8">
        <div class="card h-100">
            <div class="card-header d-flex align-items-center justify-content-between">
                <span class="text-white">Servis Masuk Terbaru</span>
                <a href="{{ route('daftar-service.index') }}" class="panel-link">Semua servis &rarr;</a>
            </div>
            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead>
                        <tr>
                            <th>No Plat</th>
                            <th>Pelanggan</th>
                            <th>Keluhan</th>
                            <th>Tanggal</th>
                            @if(auth()->user()->isAdmin())
                                <th class="text-end">Aksi</th>
                            @endif
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($servisTerbaru as $s)
                            <tr>
                                <td>
                                    <span class="plate-badge">{{ $s->no_plat }}</span>
                                </td>
                                <td class="fw-semibold text-white">
                                    {{ $s->pelanggan->nama_lengkap ?? '-' }}
                                </td>
                                <td>
                                    <div class="keluhan-text text-truncate" style="max-width: 240px;">
                                        {{ $s->keluhan }}
                                    </div>
                                </td>
                                <td>
                                    <span class="date-text">
                                        {{ \Carbon\Carbon::parse($s->tanggal_servis)->format('d-m-Y') }}
                                    </span>
                                </td>
                                @if(auth()->user()->isAdmin())
                                    <td class="text-end text-nowrap">
                                        <a href="{{ route('daftar-service.edit', $s->id_servis) }}" class="btn btn-warning btn-sm">
                                            Edit
                                        </a>
                                    </td>
                                @endif
                            </tr>
                        @empty
                            <tr>
                                <td colspan="{{ auth()->user()->isAdmin() ? 5 : 4 }}" class="empty-state">
                                    Belum ada servis yang masuk.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- PELANGGAN TERBARU -->
    <div class="col-lg-4">
        <div class="card h-100">
            <div class="card-header d-flex align-items-center justify-content-between">
                <span class="text-white">Pelanggan Terbaru</span>
                <a href="{{ route('pelanggan.index') }}" class="panel-link">Semua &rarr;</a>
            </div>
            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Nama Lengkap</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($pelangganTerbaru as $p)
                            <tr>
                                <td style="width: 72px;">
                                    <span class="id-badge">#{{ $p->id_pelanggan }}</span>
                                </td>
                                <td class="fw-medium text-white">
                                    {{ $p->nama_lengkap }}
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="2" class="empty-state">
                                    Belum ada data pelanggan.
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

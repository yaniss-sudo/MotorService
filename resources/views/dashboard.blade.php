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
        ->orderByDesc('created_at')
        ->take(6)
        ->get();

    $pelangganTerbaru = \App\Models\Pelanggan::orderByDesc('created_at')
        ->take(6)
        ->get();

    $kpiMax = max(1, $totalPelanggan, $totalKendaraan, $totalDaftarService, $totalDataService, $totalPembayaran);
    $kpiSum = max(1, $totalPelanggan + $totalKendaraan + $totalDaftarService + $totalDataService + $totalPembayaran);
    $pct = fn ($n) => round($n / $kpiMax * 100);
    $share = fn ($n) => round($n / $kpiSum * 100, 1);
@endphp

<!-- HEADER RINGKAS -->
<div class="dash-topbar">
    <div>
        <div class="dash-date">{{ \Carbon\Carbon::now()->translatedFormat('l, d F Y') }}</div>
        <h1 class="page-title"><span id="greeting">Halo</span>, {{ \Illuminate\Support\Str::of(auth()->user()->name)->explode(' ')->first() }} <span class="greeting-emoji">👋</span></h1>
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
        <svg class="kpi-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>
        <span class="kpi-label">Pelanggan</span>
        <span class="kpi-value">{{ $totalPelanggan }}</span>
        <div class="kpi-bar"><span data-pct="{{ $pct($totalPelanggan) }}"></span></div>
    </a>

    <a href="{{ route('kendaraan.index') }}" class="kpi-cell">
        <svg class="kpi-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><circle cx="5.5" cy="17.5" r="3.5"/><circle cx="18.5" cy="17.5" r="3.5"/><path d="M15 6a1 1 0 1 0 0-2 1 1 0 0 0 0 2zm-3 11.5V14l-3-3 4-3 2 3h2"/></svg>
        <span class="kpi-label">Kendaraan</span>
        <span class="kpi-value">{{ $totalKendaraan }}</span>
        <div class="kpi-bar"><span data-pct="{{ $pct($totalKendaraan) }}"></span></div>
    </a>

    <a href="{{ route('daftar-service.index') }}" class="kpi-cell">
        <svg class="kpi-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M16 4h2a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2V6a2 2 0 0 1 2-2h2"/><rect x="8" y="2" width="8" height="4" rx="1"/></svg>
        <span class="kpi-label">Daftar Service</span>
        <span class="kpi-value">{{ $totalDaftarService }}</span>
        <div class="kpi-bar"><span data-pct="{{ $pct($totalDaftarService) }}"></span></div>
    </a>

    <a href="{{ route('data-service.index') }}" class="kpi-cell">
        <svg class="kpi-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M14.7 6.3a1 1 0 0 0 0 1.4l1.6 1.6a1 1 0 0 0 1.4 0l3.77-3.77a6 6 0 0 1-7.94 7.94l-6.91 6.91a2.12 2.12 0 0 1-3-3l6.91-6.91a6 6 0 0 1 7.94-7.94l-3.76 3.76z"/></svg>
        <span class="kpi-label">Data Service</span>
        <span class="kpi-value">{{ $totalDataService }}</span>
        <div class="kpi-bar"><span data-pct="{{ $pct($totalDataService) }}"></span></div>
    </a>

    <a href="{{ route('pembayaran.index') }}" class="kpi-cell">
        <svg class="kpi-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><rect x="1" y="4" width="22" height="16" rx="2"/><line x1="1" y1="10" x2="23" y2="10"/></svg>
        <span class="kpi-label">Pembayaran</span>
        <span class="kpi-value">{{ $totalPembayaran }}</span>
        <div class="kpi-bar"><span data-pct="{{ $pct($totalPembayaran) }}"></span></div>
    </a>
</div>

<!-- KOMPOSISI DATA (dihitung dari angka KPI di atas) -->
<div class="card composition">
    <div class="d-flex justify-content-between align-items-center mb-2">
        <span class="text-white fw-semibold" style="font-size:.85rem">Komposisi Data Sistem</span>
        <span class="data-counter">{{ $kpiSum }} total catatan</span>
    </div>
    <div class="composition-bar">
        <span data-pct="{{ $share($totalPelanggan) }}" style="background:#ea580c"></span>
        <span data-pct="{{ $share($totalKendaraan) }}" style="background:#fb923c"></span>
        <span data-pct="{{ $share($totalDaftarService) }}" style="background:#fdba74"></span>
        <span data-pct="{{ $share($totalDataService) }}" style="background:#3b82f6"></span>
        <span data-pct="{{ $share($totalPembayaran) }}" style="background:#22c55e"></span>
    </div>
    <div class="composition-legend">
        <span><i style="background:#ea580c"></i>Pelanggan {{ $share($totalPelanggan) }}%</span>
        <span><i style="background:#fb923c"></i>Kendaraan {{ $share($totalKendaraan) }}%</span>
        <span><i style="background:#fdba74"></i>Daftar Service {{ $share($totalDaftarService) }}%</span>
        <span><i style="background:#3b82f6"></i>Data Service {{ $share($totalDataService) }}%</span>
        <span><i style="background:#22c55e"></i>Pembayaran {{ $share($totalPembayaran) }}%</span>
    </div>
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

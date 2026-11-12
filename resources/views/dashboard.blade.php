@extends('layouts.main')
@section('title', 'Dashboard')

@section('content')
<!-- BANNER HEADER -->
<div class="module-banner" style="background-image: url('{{ asset('images/sergey-zolkin-_UeY8aTI6d0-unsplash.jpg') }}');">
    <div class="module-banner-content">
        <div>
            <span class="module-eyebrow">Sistem Informasi Bengkel</span>
            <h1 class="page-title">Dashboard</h1>
            <p class="page-subtitle">Selamat datang, {{ auth()->user()->name }}. Berikut ini ringkasan aktivitas bengkel Anda.</p>
        </div>
    </div>
</div>

<!-- KARTU STATUS -->
<div class="card">
    <div class="table-toolbar">
        <span class="data-counter">
            Status: <strong class="text-white">Online</strong> &bull; {{ auth()->user()->role }}
        </span>
    </div>
    <div class="table-responsive" style="border-top: none;">
        <table class="table table-hover align-middle">
            <thead>
                <tr>
                    <th>Modul</th>
                    <th class="text-end">Aksi</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td class="fw-semibold text-white">Data Pelanggan</td>
                    <td class="text-end">
                        <a href="{{ route('pelanggan.index') }}" class="btn btn-primary btn-sm">Lihat Data</a>
                    </td>
                </tr>
                <tr>
                    <td class="fw-semibold text-white">Data Kendaraan</td>
                    <td class="text-end">
                        <a href="{{ route('kendaraan.index') }}" class="btn btn-primary btn-sm">Lihat Data</a>
                    </td>
                </tr>
                <tr>
                    <td class="fw-semibold text-white">Daftar Service</td>
                    <td class="text-end">
                        <a href="{{ route('daftar-service.index') }}" class="btn btn-primary btn-sm">Lihat Data</a>
                    </td>
                </tr>
                <tr>
                    <td class="fw-semibold text-white">Data Service</td>
                    <td class="text-end">
                        <a href="{{ route('data-service.index') }}" class="btn btn-primary btn-sm">Lihat Data</a>
                    </td>
                </tr>
                <tr>
                    <td class="fw-semibold text-white">Pembayaran</td>
                    <td class="text-end">
                        <a href="{{ route('pembayaran.index') }}" class="btn btn-primary btn-sm">Lihat Data</a>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</div>

<div class="card mt-4">
    <div class="table-toolbar">
        <span class="data-counter">
            Info: <strong class="text-white">{{ __("You're logged in!") }}</strong>
        </span>
    </div>
</div>
@endsection

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Aplikasi Service Motor</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
  <div class="container">
    <a class="navbar-brand" href="{{ route('pelanggan.index') }}">Service Motor</a>
    <div class="navbar-nav me-auto">
      <a class="nav-link" href="{{ route('pelanggan.index') }}">Pelanggan</a>
      <a class="nav-link" href="{{ route('kendaraan.index') }}">Kendaraan</a>
      <a class="nav-link" href="{{ route('daftar-service.index') }}">Daftar Service</a>
      <a class="nav-link" href="{{ route('data-service.index') }}">Data Service</a>
      <a class="nav-link" href="{{ route('pembayaran.index') }}">Pembayaran</a>
    </div>
    @auth
    <form method="POST" action="{{ route('logout') }}" class="d-flex align-items-center gap-2">
      @csrf
      <span class="text-light small">{{ auth()->user()->name }} ({{ auth()->user()->role }})</span>
      <button class="btn btn-outline-light btn-sm">Logout</button>
    </form>
    @endauth
  </div>
</nav>

<div class="container my-4">
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if($errors->any())
        <div class="alert alert-danger">
            <strong>Data belum valid:</strong>
            <ul class="mb-0">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    @yield('content')
</div>

@stack('scripts')
</body>
</html>

@extends('layouts.main')
@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
  <h3 class="mb-0">Data Kendaraan</h3>
  @if(auth()->user()->isAdmin())
    <a href="{{ route('kendaraan.create') }}" class="btn btn-primary">Tambah Kendaraan</a>
  @endif
</div>

<div class="table-responsive">
<table class="table table-bordered table-striped align-middle bg-white">
  <thead class="table-dark">
    <tr><th>Foto</th><th>No Plat</th><th>Jenis</th><th>No STNK</th><th>Tahun</th><th>Pemilik</th><th>Warna</th>
      @if(auth()->user()->isAdmin())<th>Aksi</th>@endif</tr>
  </thead>
  <tbody>
  @forelse($kendaraans as $k)
    <tr>
      <td>
        @if($k->foto)
          <img src="{{ asset('storage/'.$k->foto) }}" width="80" class="rounded" alt="Foto {{ $k->no_plat }}">
        @else
          <span class="text-muted">-</span>
        @endif
      </td>
      <td>{{ $k->no_plat }}</td>
      <td>{{ $k->jenis_kendaraan }}</td>
      <td>{{ $k->no_stnk }}</td>
      <td>{{ $k->tahun_pembuatan }}</td>
      <td>{{ $k->nama_pemilik }}</td>
      <td>{{ $k->warna }}</td>
      @if(auth()->user()->isAdmin())
      <td class="text-nowrap">
        <a href="{{ route('kendaraan.edit', $k->no_plat) }}" class="btn btn-warning btn-sm">Edit</a>
        <form action="{{ route('kendaraan.destroy', $k->no_plat) }}" method="POST" class="d-inline">
          @csrf @method('DELETE')
          <button class="btn btn-danger btn-sm" onclick="return confirm('Hapus data ini?')">Hapus</button>
        </form>
      </td>
      @endif
    </tr>
  @empty
    <tr><td colspan="8" class="text-center text-muted">Belum ada data</td></tr>
  @endforelse
  </tbody>
</table>
</div>
@endsection

@extends('layouts.main')
@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
  <h3 class="mb-0">Daftar Service</h3>
  @if(auth()->user()->isAdmin())
    <a href="{{ route('daftar-service.create') }}" class="btn btn-primary">Tambah Daftar Service</a>
  @endif
</div>

<div class="table-responsive">
<table class="table table-bordered table-striped bg-white">
  <thead class="table-dark">
    <tr><th>Id Servis</th><th>No Plat</th><th>Id Pelanggan</th><th>Nama Pelanggan</th><th>Keluhan</th><th>Tanggal Servis</th>
      @if(auth()->user()->isAdmin())<th>Aksi</th>@endif</tr>
  </thead>
  <tbody>
  @forelse($daftarServices as $d)
    <tr>
      <td>{{ $d->id_servis }}</td>
      <td>{{ $d->no_plat }}</td>
      <td>{{ $d->id_pelanggan }}</td>
      <td>{{ $d->pelanggan->nama_lengkap ?? '-' }}</td>
      <td>{{ $d->keluhan }}</td>
      <td>{{ \Carbon\Carbon::parse($d->tanggal_servis)->format('d-m-Y') }}</td>
      @if(auth()->user()->isAdmin())
      <td class="text-nowrap">
        <a href="{{ route('daftar-service.edit', $d->id_servis) }}" class="btn btn-warning btn-sm">Edit</a>
        <form action="{{ route('daftar-service.destroy', $d->id_servis) }}" method="POST" class="d-inline">
          @csrf @method('DELETE')
          <button class="btn btn-danger btn-sm" onclick="return confirm('Hapus data ini?')">Hapus</button>
        </form>
      </td>
      @endif
    </tr>
  @empty
    <tr><td colspan="7" class="text-center text-muted">Belum ada data</td></tr>
  @endforelse
  </tbody>
</table>
</div>
@endsection

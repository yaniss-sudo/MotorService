@extends('layouts.main')
@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
  <h3 class="mb-0">Data Service</h3>
  @if(auth()->user()->isAdmin())
    <a href="{{ route('data-service.create') }}" class="btn btn-primary">Tambah Data Service</a>
  @endif
</div>

<div class="table-responsive">
<table class="table table-bordered table-striped bg-white">
  <thead class="table-dark">
    <tr><th>No</th><th>Id Servis</th><th>Keluhan</th><th>Estimasi Service</th><th>Nama Mekanik</th><th>Sparepart Pengganti</th>
      @if(auth()->user()->isAdmin())<th>Aksi</th>@endif</tr>
  </thead>
  <tbody>
  @forelse($dataServices as $i => $d)
    <tr>
      <td>{{ $i + 1 }}</td>
      <td>{{ $d->id_servis }}</td>
      <td>{{ $d->daftarService->keluhan ?? '-' }}</td>
      <td>{{ $d->estimasi_service }}</td>
      <td>{{ $d->nama_mekanik }}</td>
      <td>{{ $d->sparepart_pengganti ?: '-' }}</td>
      @if(auth()->user()->isAdmin())
      <td class="text-nowrap">
        <a href="{{ route('data-service.edit', $d->id) }}" class="btn btn-warning btn-sm">Edit</a>
        <form action="{{ route('data-service.destroy', $d->id) }}" method="POST" class="d-inline">
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

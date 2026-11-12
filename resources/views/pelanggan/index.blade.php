@extends('layouts.main')
@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
  <h3 class="mb-0">Data Pelanggan</h3>
  @if(auth()->user()->isAdmin())
    <a href="{{ route('pelanggan.create') }}" class="btn btn-primary">Tambah Pelanggan</a>
  @endif
</div>

<div class="table-responsive">
<table class="table table-bordered table-striped bg-white">
  <thead class="table-dark">
    <tr><th>ID</th><th>Nama Lengkap</th><th>No HP</th><th>Alamat</th><th>Pekerjaan</th>
      @if(auth()->user()->isAdmin())<th>Aksi</th>@endif</tr>
  </thead>
  <tbody>
  @forelse($pelanggans as $p)
    <tr>
      <td>{{ $p->id_pelanggan }}</td>
      <td>{{ $p->nama_lengkap }}</td>
      <td>{{ $p->no_hp }}</td>
      <td>{{ $p->alamat }}</td>
      <td>{{ $p->pekerjaan }}</td>
      @if(auth()->user()->isAdmin())
      <td class="text-nowrap">
        <a href="{{ route('pelanggan.edit', $p->id_pelanggan) }}" class="btn btn-warning btn-sm">Edit</a>
        <form action="{{ route('pelanggan.destroy', $p->id_pelanggan) }}" method="POST" class="d-inline">
          @csrf @method('DELETE')
          <button class="btn btn-danger btn-sm" onclick="return confirm('Hapus data ini?')">Hapus</button>
        </form>
      </td>
      @endif
    </tr>
  @empty
    <tr><td colspan="6" class="text-center text-muted">Belum ada data</td></tr>
  @endforelse
  </tbody>
</table>
</div>
@endsection

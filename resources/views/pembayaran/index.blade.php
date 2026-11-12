@extends('layouts.main')
@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
  <h3 class="mb-0">Pembayaran Service</h3>
  @if(auth()->user()->isAdmin())
    <a href="{{ route('pembayaran.create') }}" class="btn btn-primary">Tambah Pembayaran</a>
  @endif
</div>

<div class="table-responsive">
<table class="table table-bordered table-striped bg-white">
  <thead class="table-dark">
    <tr><th>No</th><th>Id Servis</th><th>Jumlah Biaya</th><th>Jenis Pembayaran</th><th>Keterangan</th>
      @if(auth()->user()->isAdmin())<th>Aksi</th>@endif</tr>
  </thead>
  <tbody>
  @forelse($pembayarans as $i => $p)
    <tr>
      <td>{{ $i + 1 }}</td>
      <td>{{ $p->id_servis }}</td>
      <td>Rp {{ number_format($p->jumlah_biaya, 0, ',', '.') }}</td>
      <td>{{ $p->jenis_pembayaran }}</td>
      <td>{{ $p->keterangan ?: '-' }}</td>
      @if(auth()->user()->isAdmin())
      <td class="text-nowrap">
        <a href="{{ route('pembayaran.edit', $p->id) }}" class="btn btn-warning btn-sm">Edit</a>
        <form action="{{ route('pembayaran.destroy', $p->id) }}" method="POST" class="d-inline">
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

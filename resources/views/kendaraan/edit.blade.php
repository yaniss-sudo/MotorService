@extends('layouts.main')
@section('content')
<h3>Ubah Kendaraan</h3>
<form action="{{ route('kendaraan.update', $kendaraan->no_plat) }}" method="POST" enctype="multipart/form-data" class="card card-body">
  @csrf @method('PUT')
  <div class="mb-3">
    <label class="form-label">No Plat Kendaraan</label>
    <input type="text" class="form-control" value="{{ $kendaraan->no_plat }}" disabled>
  </div>

  @php $jenis = old('jenis_kendaraan', $kendaraan->jenis_kendaraan); @endphp
  <div class="mb-3">
    <label class="form-label d-block">Jenis Kendaraan</label>
    <div class="form-check form-check-inline">
      <input class="form-check-input" type="radio" name="jenis_kendaraan" id="matic" value="Matic" {{ $jenis === 'Matic' ? 'checked' : '' }} required>
      <label class="form-check-label" for="matic">Matic</label>
    </div>
    <div class="form-check form-check-inline">
      <input class="form-check-input" type="radio" name="jenis_kendaraan" id="manual" value="Manual Transmisi" {{ $jenis === 'Manual Transmisi' ? 'checked' : '' }}>
      <label class="form-check-label" for="manual">Manual Transmisi</label>
    </div>
    @error('jenis_kendaraan') <div class="text-danger small">{{ $message }}</div> @enderror
  </div>

  <div class="mb-3">
    <label class="form-label">No STNK</label>
    <input type="text" name="no_stnk" class="form-control @error('no_stnk') is-invalid @enderror" value="{{ old('no_stnk', $kendaraan->no_stnk) }}" required>
    @error('no_stnk') <div class="invalid-feedback">{{ $message }}</div> @enderror
  </div>
  <div class="mb-3">
    <label class="form-label">Tahun Pembuatan Kendaraan</label>
    <input type="number" name="tahun_pembuatan" class="form-control @error('tahun_pembuatan') is-invalid @enderror" value="{{ old('tahun_pembuatan', $kendaraan->tahun_pembuatan) }}" min="1980" max="{{ date('Y') }}" required>
    @error('tahun_pembuatan') <div class="invalid-feedback">{{ $message }}</div> @enderror
  </div>
  <div class="mb-3">
    <label class="form-label">Nama Pemilik</label>
    <input type="text" name="nama_pemilik" class="form-control @error('nama_pemilik') is-invalid @enderror" value="{{ old('nama_pemilik', $kendaraan->nama_pemilik) }}" required>
    @error('nama_pemilik') <div class="invalid-feedback">{{ $message }}</div> @enderror
  </div>
  <div class="mb-3">
    <label class="form-label">Warna Kendaraan</label>
    <input type="text" name="warna" class="form-control @error('warna') is-invalid @enderror" value="{{ old('warna', $kendaraan->warna) }}" required>
    @error('warna') <div class="invalid-feedback">{{ $message }}</div> @enderror
  </div>

  <div class="mb-3">
    <label class="form-label">Foto Kendaraan</label>
    @if($kendaraan->foto)
      <div class="mb-2">
        <img src="{{ asset('storage/'.$kendaraan->foto) }}" width="160" class="rounded border" alt="Foto saat ini">
        <div class="form-text">Foto saat ini. Pilih file baru hanya jika ingin menggantinya.</div>
      </div>
    @endif
    <input type="file" name="foto" class="form-control @error('foto') is-invalid @enderror" accept="image/*">
    @error('foto') <div class="invalid-feedback">{{ $message }}</div> @enderror
  </div>

  <div>
    <button class="btn btn-success">Simpan Perubahan</button>
    <a href="{{ route('kendaraan.index') }}" class="btn btn-secondary">Batal</a>
  </div>
</form>
@endsection

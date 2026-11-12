@extends('layouts.main')
@section('content')
<h3>Tambah Kendaraan</h3>
<form action="{{ route('kendaraan.store') }}" method="POST" enctype="multipart/form-data" class="card card-body">
  @csrf
  <div class="mb-3">
    <label class="form-label">No Plat Kendaraan</label>
    <input type="text" name="no_plat" class="form-control @error('no_plat') is-invalid @enderror" value="{{ old('no_plat') }}" placeholder="BK 1234 AB" required>
    @error('no_plat') <div class="invalid-feedback">{{ $message }}</div> @enderror
  </div>

  <div class="mb-3">
    <label class="form-label d-block">Jenis Kendaraan</label>
    <div class="form-check form-check-inline">
      <input class="form-check-input" type="radio" name="jenis_kendaraan" id="matic" value="Matic" {{ old('jenis_kendaraan') === 'Matic' ? 'checked' : '' }} required>
      <label class="form-check-label" for="matic">Matic</label>
    </div>
    <div class="form-check form-check-inline">
      <input class="form-check-input" type="radio" name="jenis_kendaraan" id="manual" value="Manual Transmisi" {{ old('jenis_kendaraan') === 'Manual Transmisi' ? 'checked' : '' }}>
      <label class="form-check-label" for="manual">Manual Transmisi</label>
    </div>
    @error('jenis_kendaraan') <div class="text-danger small">{{ $message }}</div> @enderror
  </div>

  <div class="mb-3">
    <label class="form-label">No STNK</label>
    <input type="text" name="no_stnk" class="form-control @error('no_stnk') is-invalid @enderror" value="{{ old('no_stnk') }}" required>
    @error('no_stnk') <div class="invalid-feedback">{{ $message }}</div> @enderror
  </div>
  <div class="mb-3">
    <label class="form-label">Tahun Pembuatan Kendaraan</label>
    <input type="number" name="tahun_pembuatan" class="form-control @error('tahun_pembuatan') is-invalid @enderror" value="{{ old('tahun_pembuatan') }}" min="1980" max="{{ date('Y') }}" required>
    @error('tahun_pembuatan') <div class="invalid-feedback">{{ $message }}</div> @enderror
  </div>
  <div class="mb-3">
    <label class="form-label">Nama Pemilik</label>
    <input type="text" name="nama_pemilik" class="form-control @error('nama_pemilik') is-invalid @enderror" value="{{ old('nama_pemilik') }}" required>
    @error('nama_pemilik') <div class="invalid-feedback">{{ $message }}</div> @enderror
  </div>
  <div class="mb-3">
    <label class="form-label">Warna Kendaraan</label>
    <input type="text" name="warna" class="form-control @error('warna') is-invalid @enderror" value="{{ old('warna') }}" required>
    @error('warna') <div class="invalid-feedback">{{ $message }}</div> @enderror
  </div>
  <div class="mb-3">
    <label class="form-label">Foto Kendaraan (jpg/png/webp, maks 2 MB)</label>
    <input type="file" name="foto" class="form-control @error('foto') is-invalid @enderror" accept="image/*">
    @error('foto') <div class="invalid-feedback">{{ $message }}</div> @enderror
  </div>

  <div>
    <button class="btn btn-success">Simpan</button>
    <a href="{{ route('kendaraan.index') }}" class="btn btn-secondary">Batal</a>
  </div>
</form>
@endsection

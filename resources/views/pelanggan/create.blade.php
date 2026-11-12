@extends('layouts.main')
@section('content')
<h3>Tambah Pelanggan</h3>
<form action="{{ route('pelanggan.store') }}" method="POST" class="card card-body">
  @csrf
  <div class="mb-3">
    <label class="form-label">Id Pelanggan</label>
    <input type="text" class="form-control" value="Otomatis" disabled>
  </div>
  <div class="mb-3">
    <label class="form-label">Nama Lengkap</label>
    <input type="text" name="nama_lengkap" class="form-control @error('nama_lengkap') is-invalid @enderror" value="{{ old('nama_lengkap') }}" required>
    @error('nama_lengkap') <div class="invalid-feedback">{{ $message }}</div> @enderror
  </div>
  <div class="mb-3">
    <label class="form-label">No HP</label>
    <input type="text" name="no_hp" class="form-control @error('no_hp') is-invalid @enderror" value="{{ old('no_hp') }}" required>
    @error('no_hp') <div class="invalid-feedback">{{ $message }}</div> @enderror
  </div>
  <div class="mb-3">
    <label class="form-label">Alamat</label>
    <textarea name="alamat" class="form-control @error('alamat') is-invalid @enderror" required>{{ old('alamat') }}</textarea>
    @error('alamat') <div class="invalid-feedback">{{ $message }}</div> @enderror
  </div>
  <div class="mb-3">
    <label class="form-label">Pekerjaan</label>
    <input type="text" name="pekerjaan" class="form-control @error('pekerjaan') is-invalid @enderror" value="{{ old('pekerjaan') }}" required>
    @error('pekerjaan') <div class="invalid-feedback">{{ $message }}</div> @enderror
  </div>
  <div>
    <button class="btn btn-success">Simpan</button>
    <a href="{{ route('pelanggan.index') }}" class="btn btn-secondary">Batal</a>
  </div>
</form>
@endsection

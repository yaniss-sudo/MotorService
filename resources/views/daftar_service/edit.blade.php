@extends('layouts.main')
@section('content')
<h3>Ubah Daftar Service</h3>
<form action="{{ route('daftar-service.update', $daftarService->id_servis) }}" method="POST" class="card card-body">
  @csrf @method('PUT')
  <div class="mb-3">
    <label class="form-label">Id Servis Pelanggan</label>
    <input type="text" class="form-control" value="{{ $daftarService->id_servis }}" disabled>
  </div>

  @php
    $platDipilih = old('no_plat', $daftarService->no_plat);
    $pelangganDipilih = old('id_pelanggan', $daftarService->id_pelanggan);
  @endphp

  <div class="mb-3">
    <label class="form-label">No Plat Kendaraan</label>
    <select name="no_plat" class="form-select @error('no_plat') is-invalid @enderror" required>
      <option value="">-- Pilih No Plat --</option>
      @foreach($kendaraans as $k)
        <option value="{{ $k->no_plat }}" {{ $platDipilih === $k->no_plat ? 'selected' : '' }}>{{ $k->no_plat }}</option>
      @endforeach
    </select>
    @error('no_plat') <div class="invalid-feedback">{{ $message }}</div> @enderror
  </div>

  <div class="mb-3">
    <label class="form-label">Id Pelanggan</label>
    <select name="id_pelanggan" id="id_pelanggan" class="form-select @error('id_pelanggan') is-invalid @enderror" required>
      <option value="">-- Pilih Id Pelanggan --</option>
      @foreach($pelanggans as $p)
        <option value="{{ $p->id_pelanggan }}" {{ (string) $pelangganDipilih === (string) $p->id_pelanggan ? 'selected' : '' }}>{{ $p->id_pelanggan }}</option>
      @endforeach
    </select>
    @error('id_pelanggan') <div class="invalid-feedback">{{ $message }}</div> @enderror
  </div>

  <div class="mb-3">
    <label class="form-label">Nama Pelanggan</label>
    <input type="text" id="nama_pelanggan" class="form-control" readonly>
  </div>

  <div class="mb-3">
    <label class="form-label">Keluhan Kendaraan</label>
    <textarea name="keluhan" class="form-control @error('keluhan') is-invalid @enderror" required>{{ old('keluhan', $daftarService->keluhan) }}</textarea>
    @error('keluhan') <div class="invalid-feedback">{{ $message }}</div> @enderror
  </div>

  <div class="mb-3">
    <label class="form-label">Tanggal Servis</label>
    <input type="date" name="tanggal_servis" class="form-control @error('tanggal_servis') is-invalid @enderror"
           value="{{ old('tanggal_servis', \Carbon\Carbon::parse($daftarService->tanggal_servis)->format('Y-m-d')) }}" required>
    @error('tanggal_servis') <div class="invalid-feedback">{{ $message }}</div> @enderror
  </div>

  <div>
    <button class="btn btn-success">Simpan Perubahan</button>
    <a href="{{ route('daftar-service.index') }}" class="btn btn-secondary">Batal</a>
  </div>
</form>
@endsection

@push('scripts')
<script>
const selectPelanggan = document.getElementById('id_pelanggan');
const inputNama = document.getElementById('nama_pelanggan');

function isiNama() {
    if (!selectPelanggan.value) { inputNama.value = ''; return; }
    fetch('/lookup/pelanggan/' + encodeURIComponent(selectPelanggan.value), {
        headers: { 'Accept': 'application/json' }
    })
    .then(res => res.ok ? res.json() : null)
    .then(json => { inputNama.value = json ? json.nama_lengkap : ''; })
    .catch(() => { inputNama.value = ''; });
}

selectPelanggan.addEventListener('change', isiNama);
isiNama();
</script>
@endpush

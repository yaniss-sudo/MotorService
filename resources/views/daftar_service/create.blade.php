@extends('layouts.main')
@section('content')
<h3>Tambah Daftar Service</h3>
<form action="{{ route('daftar-service.store') }}" method="POST" class="card card-body">
  @csrf
  <div class="mb-3">
    <label class="form-label">Id Servis Pelanggan</label>
    <input type="text" class="form-control" value="Otomatis" disabled>
  </div>

  <div class="mb-3">
    <label class="form-label">No Plat Kendaraan</label>
    <select name="no_plat" class="form-select @error('no_plat') is-invalid @enderror" required>
      <option value="">-- Pilih No Plat --</option>
      @foreach($kendaraans as $k)
        <option value="{{ $k->no_plat }}" {{ old('no_plat') === $k->no_plat ? 'selected' : '' }}>{{ $k->no_plat }}</option>
      @endforeach
    </select>
    @error('no_plat') <div class="invalid-feedback">{{ $message }}</div> @enderror
  </div>

  <div class="mb-3">
    <label class="form-label">Id Pelanggan</label>
    <select name="id_pelanggan" id="id_pelanggan" class="form-select @error('id_pelanggan') is-invalid @enderror" required>
      <option value="">-- Pilih Id Pelanggan --</option>
      @foreach($pelanggans as $p)
        <option value="{{ $p->id_pelanggan }}" {{ (string) old('id_pelanggan') === (string) $p->id_pelanggan ? 'selected' : '' }}>{{ $p->id_pelanggan }}</option>
      @endforeach
    </select>
    @error('id_pelanggan') <div class="invalid-feedback">{{ $message }}</div> @enderror
  </div>

  <div class="mb-3">
    <label class="form-label">Nama Pelanggan</label>
    <input type="text" id="nama_pelanggan" class="form-control" placeholder="Terisi otomatis setelah memilih Id Pelanggan" readonly>
  </div>

  <div class="mb-3">
    <label class="form-label">Keluhan Kendaraan</label>
    <textarea name="keluhan" class="form-control @error('keluhan') is-invalid @enderror" required>{{ old('keluhan') }}</textarea>
    @error('keluhan') <div class="invalid-feedback">{{ $message }}</div> @enderror
  </div>

  <div class="mb-3">
    <label class="form-label">Tanggal Servis</label>
    <input type="date" name="tanggal_servis" class="form-control @error('tanggal_servis') is-invalid @enderror" value="{{ old('tanggal_servis') }}" required>
    @error('tanggal_servis') <div class="invalid-feedback">{{ $message }}</div> @enderror
  </div>

  <div>
    <button class="btn btn-success">Simpan</button>
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
isiNama(); // isi otomatis jika form dimuat ulang dengan data lama
</script>
@endpush

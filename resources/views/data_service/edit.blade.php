@extends('layouts.main')
@section('content')
<h3>Ubah Data Service</h3>
<form action="{{ route('data-service.update', $dataService->id) }}" method="POST" class="card card-body">
  @csrf @method('PUT')
  @php $servisDipilih = old('id_servis', $dataService->id_servis); @endphp

  <div class="mb-3">
    <label class="form-label">Id Servis Pelanggan</label>
    <select name="id_servis" id="id_servis" class="form-select @error('id_servis') is-invalid @enderror" required>
      <option value="">-- Pilih Id Servis --</option>
      @foreach($daftarServices as $d)
        <option value="{{ $d->id_servis }}" {{ (string) $servisDipilih === (string) $d->id_servis ? 'selected' : '' }}>
          {{ $d->id_servis }} - {{ $d->no_plat }}
        </option>
      @endforeach
    </select>
    @error('id_servis') <div class="invalid-feedback">{{ $message }}</div> @enderror
  </div>

  <div class="mb-3">
    <label class="form-label">Keluhan Kendaraan</label>
    <textarea id="keluhan" class="form-control" readonly></textarea>
  </div>

  <div class="mb-3">
    <label class="form-label">Estimasi Service</label>
    <input type="text" name="estimasi_service" class="form-control @error('estimasi_service') is-invalid @enderror" value="{{ old('estimasi_service', $dataService->estimasi_service) }}" required>
    @error('estimasi_service') <div class="invalid-feedback">{{ $message }}</div> @enderror
  </div>

  <div class="mb-3">
    <label class="form-label">Nama Mekanik</label>
    <input type="text" name="nama_mekanik" class="form-control @error('nama_mekanik') is-invalid @enderror" value="{{ old('nama_mekanik', $dataService->nama_mekanik) }}" required>
    @error('nama_mekanik') <div class="invalid-feedback">{{ $message }}</div> @enderror
  </div>

  <div class="mb-3">
    <label class="form-label">Sparepart Pengganti</label>
    <textarea name="sparepart_pengganti" class="form-control @error('sparepart_pengganti') is-invalid @enderror">{{ old('sparepart_pengganti', $dataService->sparepart_pengganti) }}</textarea>
    @error('sparepart_pengganti') <div class="invalid-feedback">{{ $message }}</div> @enderror
  </div>

  <div>
    <button class="btn btn-success">Simpan Perubahan</button>
    <a href="{{ route('data-service.index') }}" class="btn btn-secondary">Batal</a>
  </div>
</form>
@endsection

@push('scripts')
<script>
const selectServis = document.getElementById('id_servis');
const inputKeluhan = document.getElementById('keluhan');

function isiKeluhan() {
    if (!selectServis.value) { inputKeluhan.value = ''; return; }
    fetch('/lookup/servis/' + encodeURIComponent(selectServis.value), {
        headers: { 'Accept': 'application/json' }
    })
    .then(res => res.ok ? res.json() : null)
    .then(json => { inputKeluhan.value = json ? json.keluhan : ''; })
    .catch(() => { inputKeluhan.value = ''; });
}

selectServis.addEventListener('change', isiKeluhan);
isiKeluhan();
</script>
@endpush

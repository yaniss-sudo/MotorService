@extends('layouts.main')
@section('content')
<h3>Ubah Pembayaran Service</h3>
<form action="{{ route('pembayaran.update', $pembayaran->id) }}" method="POST" class="card card-body">
  @csrf @method('PUT')
  @php
    $servisDipilih = old('id_servis', $pembayaran->id_servis);
    $jenis = old('jenis_pembayaran', $pembayaran->jenis_pembayaran);
  @endphp

  <div class="mb-3">
    <label class="form-label">Id Servis Pelanggan</label>
    <select name="id_servis" class="form-select @error('id_servis') is-invalid @enderror" required>
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
    <label class="form-label">Jumlah Biaya Servis (Rp)</label>
    <input type="number" name="jumlah_biaya" class="form-control @error('jumlah_biaya') is-invalid @enderror" value="{{ old('jumlah_biaya', $pembayaran->jumlah_biaya) }}" min="0" required>
    @error('jumlah_biaya') <div class="invalid-feedback">{{ $message }}</div> @enderror
  </div>

  <div class="mb-3">
    <label class="form-label d-block">Jenis Pembayaran</label>
    <div class="form-check form-check-inline">
      <input class="form-check-input" type="radio" name="jenis_pembayaran" id="tunai" value="Cash / Tunai" {{ $jenis === 'Cash / Tunai' ? 'checked' : '' }} required>
      <label class="form-check-label" for="tunai">Cash / Tunai</label>
    </div>
    <div class="form-check form-check-inline">
      <input class="form-check-input" type="radio" name="jenis_pembayaran" id="nontunai" value="Non Tunai" {{ $jenis === 'Non Tunai' ? 'checked' : '' }}>
      <label class="form-check-label" for="nontunai">Non Tunai</label>
    </div>
    @error('jenis_pembayaran') <div class="text-danger small">{{ $message }}</div> @enderror
  </div>

  <div class="mb-3">
    <label class="form-label">Keterangan</label>
    <textarea name="keterangan" class="form-control @error('keterangan') is-invalid @enderror">{{ old('keterangan', $pembayaran->keterangan) }}</textarea>
    @error('keterangan') <div class="invalid-feedback">{{ $message }}</div> @enderror
  </div>

  <div>
    <button class="btn btn-success">Simpan Perubahan</button>
    <a href="{{ route('pembayaran.index') }}" class="btn btn-secondary">Batal</a>
  </div>
</form>
@endsection

@extends('layouts.main')
@section('title', 'Ubah Daftar Service')

@section('content')
<div class="form-shell">
    <a href="{{ route('daftar-service.index') }}" class="breadcrumb-back">
        <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <line x1="19" y1="12" x2="5" y2="12"></line>
            <polyline points="12 19 5 12 12 5"></polyline>
        </svg>
        <span>Kembali ke Daftar Service</span>
    </a>

    @php
        $platDipilih = old('no_plat', $daftarService->no_plat);
        $pelangganDipilih = old('id_pelanggan', $daftarService->id_pelanggan);
    @endphp

    <form action="{{ route('daftar-service.update', $daftarService->id_servis) }}" method="POST" class="editor-card">
        @csrf
        @method('PUT')

        <div class="editor-header">
            <h1 class="editor-title">Ubah Daftar Service</h1>
            <span class="id-badge">ID Servis: #{{ $daftarService->id_servis }}</span>
        </div>

        <div class="editor-body">
            <!-- KELOMPOK 1: PELANGGAN & KENDARAAN -->
            <div class="form-section-label">Data Pelanggan &amp; Kendaraan</div>

            <div class="row g-3 mb-4">
                <div class="col-md-5">
                    <label for="id_pelanggan" class="form-label">Id Pelanggan</label>
                    <select name="id_pelanggan" id="id_pelanggan" class="form-select @error('id_pelanggan') is-invalid @enderror" required>
                        <option value="">-- Pilih Id Pelanggan --</option>
                        @foreach($pelanggans as $p)
                            <option value="{{ $p->id_pelanggan }}" {{ (string) $pelangganDipilih === (string) $p->id_pelanggan ? 'selected' : '' }}>
                                {{ $p->id_pelanggan }}
                            </option>
                        @endforeach
                    </select>
                    @error('id_pelanggan')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-7">
                    <label for="nama_pelanggan" class="form-label">Nama Pelanggan</label>
                    <input type="text" id="nama_pelanggan" class="form-control" placeholder="Otomatis terisi saat ID dipilih" readonly>
                </div>

                <div class="col-md-6">
                    <label for="no_plat" class="form-label">No Plat Kendaraan</label>
                    <select name="no_plat" id="no_plat" class="form-select @error('no_plat') is-invalid @enderror" required>
                        <option value="">-- Pilih No Plat --</option>
                        @foreach($kendaraans as $k)
                            <option value="{{ $k->no_plat }}" {{ $platDipilih === $k->no_plat ? 'selected' : '' }}>
                                {{ $k->no_plat }}
                            </option>
                        @endforeach
                    </select>
                    @error('no_plat')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6">
                    <label for="tanggal_servis" class="form-label">Tanggal Servis</label>
                    <input
                        type="date"
                        id="tanggal_servis"
                        name="tanggal_servis"
                        class="form-control @error('tanggal_servis') is-invalid @enderror"
                        value="{{ old('tanggal_servis', \Carbon\Carbon::parse($daftarService->tanggal_servis)->format('Y-m-d')) }}"
                        required
                    >
                    @error('tanggal_servis')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <!-- KELOMPOK 2: KELUHAN -->
            <div class="form-section-label">Catatan Servis</div>

            <div>
                <label for="keluhan" class="form-label">Keluhan Kendaraan</label>
                <textarea
                    id="keluhan"
                    name="keluhan"
                    rows="3"
                    class="form-control @error('keluhan') is-invalid @enderror"
                    required
                >{{ old('keluhan', $daftarService->keluhan) }}</textarea>
                @error('keluhan')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
        </div>

        <div class="editor-footer">
            <a href="{{ route('daftar-service.index') }}" class="btn btn-secondary">Batal</a>
            <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
        </div>
    </form>
</div>
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

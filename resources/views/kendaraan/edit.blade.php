@extends('layouts.main')
@section('title', 'Ubah Kendaraan')

@section('content')
<div class="form-shell">
    <a href="{{ route('kendaraan.index') }}" class="breadcrumb-back">
        <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <line x1="19" y1="12" x2="5" y2="12"></line>
            <polyline points="12 19 5 12 12 5"></polyline>
        </svg>
        <span>Kembali ke Data Kendaraan</span>
    </a>

    @php
        $jenis = old('jenis_kendaraan', $kendaraan->jenis_kendaraan);
    @endphp

    <form action="{{ route('kendaraan.update', $kendaraan->no_plat) }}" method="POST" enctype="multipart/form-data" class="editor-card" id="editKendaraanForm">
        @csrf
        @method('PUT')

        <div class="editor-header">
            <h1 class="editor-title">Ubah Kendaraan</h1>
            <span class="id-badge">No Plat: {{ $kendaraan->no_plat }}</span>
        </div>

        <div class="editor-body">
            <!-- KELOMPOK 1: IDENTITAS KENDARAAN -->
            <div class="form-section-label">Identitas Kendaraan</div>

            <div class="row g-3 mb-4">
                <div class="col-md-6">
                    <label for="no_plat" class="form-label">No Plat Kendaraan</label>
                    <input type="text" class="form-control" value="{{ $kendaraan->no_plat }}" disabled readonly>
                </div>

                <div class="col-md-6">
                    <label for="jenis_kendaraan" class="form-label">Jenis Kendaraan</label>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="jenis_kendaraan" id="matic" value="Matic" {{ $jenis === 'Matic' ? 'checked' : '' }} required>
                        <label class="form-check-label" for="matic">Matic</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="jenis_kendaraan" id="manual" value="Manual Transmisi" {{ $jenis === 'Manual Transmisi' ? 'checked' : '' }}>
                        <label class="form-check-label" for="manual">Manual Transmisi</label>
                    </div>
                    @error('jenis_kendaraan')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6">
                    <label for="no_stnk" class="form-label">No STNK</label>
                    <input
                        type="text"
                        name="no_stnk"
                        id="no_stnk"
                        class="form-control @error('no_stnk') is-invalid @enderror"
                        value="{{ old('no_stnk', $kendaraan->no_stnk) }}"
                        required
                    >
                    @error('no_stnk')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6">
                    <label for="tahun_pembuatan" class="form-label">Tahun Pembuatan</label>
                    <input
                        type="number"
                        name="tahun_pembuatan"
                        id="tahun_pembuatan"
                        class="form-control @error('tahun_pembuatan') is-invalid @enderror"
                        value="{{ old('tahun_pembuatan', $kendaraan->tahun_pembuatan) }}"
                        min="1980"
                        max="{{ date('Y') }}"
                        required
                    >
                    @error('tahun_pembuatan')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>
            <!-- KELOMPOK 2: PEMILIK & DOKUMEN -->
            <div class="form-section-label">Pemilik &amp; Dokumen</div>

            <div class="row g-3 mb-4">
                <div class="col-md-6">
                    <label for="nama_pemilik" class="form-label">Nama Pemilik</label>
                    <input
                        type="text"
                        name="nama_pemilik"
                        id="nama_pemilik"
                        class="form-control @error('nama_pemilik') is-invalid @enderror"
                        value="{{ old('nama_pemilik', $kendaraan->nama_pemilik) }}"
                        required
                    >
                    @error('nama_pemilik')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6">
                    <label for="warna" class="form-label">Warna Kendaraan</label>
                    <input
                        type="text"
                        name="warna"
                        id="warna"
                        class="form-control @error('warna') is-invalid @enderror"
                        value="{{ old('warna', $kendaraan->warna) }}"
                        required
                    >
                    @error('warna')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-12">
                    <label for="foto" class="form-label">Foto Kendaraan</label>
                    @if($kendaraan->foto)
                        <div class="mb-2">
                            <img src="{{ asset('storage/'.$kendaraan->foto) }}" width="160" class="rounded border" alt="Foto saat ini">
                            <div class="form-hint">Foto saat ini. Pilih file baru hanya jika ingin menggantinya.</div>
                        </div>
                    @endif
                    <input
                        type="file"
                        name="foto"
                        id="foto"
                        class="form-control @error('foto') is-invalid @enderror"
                        accept="image/*"
                    >
                    @error('foto')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>
        </div>

        <div class="editor-footer">
            <a href="{{ route('kendaraan.index') }}" class="btn btn-secondary">Batal</a>
            <button type="submit" class="btn btn-primary" id="submitBtn">Simpan Perubahan</button>
        </div>
    </form>
</div>
@endsection

@push('scripts')
<script>
    document.getElementById('editKendaraanForm')?.addEventListener('submit', function () {
        const btn = document.getElementById('submitBtn');
        if (btn) {
            btn.disabled = true;
            btn.textContent = 'Menyimpan...';
        }
    });
</script>
@endpush

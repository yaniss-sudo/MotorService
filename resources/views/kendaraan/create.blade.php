@extends('layouts.main')
@section('title', 'Tambah Kendaraan')

@section('content')
<div class="form-shell">
    <a href="{{ route('kendaraan.index') }}" class="breadcrumb-back">
        <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <line x1="19" y1="12" x2="5" y2="12"></line>
            <polyline points="12 19 5 12 12 5"></polyline>
        </svg>
        <span>Kembali ke Data Kendaraan</span>
    </a>

    <form action="{{ route('kendaraan.store') }}" method="POST" enctype="multipart/form-data" class="editor-card" id="createKendaraanForm">
        @csrf

        <div class="editor-header">
            <h1 class="editor-title">Tambah Kendaraan</h1>
            <span class="id-badge">Unit Baru</span>
        </div>

        <div class="editor-body">
            <!-- KELOMPOK 1: IDENTITAS KENDARAAN -->
            <div class="form-section-label">Identitas Kendaraan</div>

            <div class="row g-3 mb-4">
                <div class="col-md-6">
                    <label for="no_plat" class="form-label">No Plat Kendaraan</label>
                    <input
                        type="text"
                        name="no_plat"
                        id="no_plat"
                        class="form-control @error('no_plat') is-invalid @enderror"
                        value="{{ old('no_plat') }}"
                        placeholder="BK 1234 AB"
                        required
                    >
                    @error('no_plat')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6">
                    <label class="form-label d-block">Jenis Kendaraan</label>
                    <div class="radio-group-box @error('jenis_kendaraan') border-danger @enderror">
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="jenis_kendaraan" id="matic" value="Matic" {{ old('jenis_kendaraan') === 'Matic' ? 'checked' : '' }} required>
                            <label class="form-check-label" for="matic">Matic</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="jenis_kendaraan" id="manual" value="Manual Transmisi" {{ old('jenis_kendaraan') === 'Manual Transmisi' ? 'checked' : '' }}>
                            <label class="form-check-label" for="manual">Manual Transmisi</label>
                        </div>
                    </div>
                    @error('jenis_kendaraan')
                        <div class="invalid-feedback d-block">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6">
                    <label for="no_stnk" class="form-label">No STNK</label>
                    <input
                        type="text"
                        name="no_stnk"
                        id="no_stnk"
                        class="form-control @error('no_stnk') is-invalid @enderror"
                        value="{{ old('no_stnk') }}"
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
                        value="{{ old('tahun_pembuatan') }}"
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

            <div class="row g-3">
                <div class="col-md-6">
                    <label for="nama_pemilik" class="form-label">Nama Pemilik</label>
                    <input
                        type="text"
                        name="nama_pemilik"
                        id="nama_pemilik"
                        class="form-control @error('nama_pemilik') is-invalid @enderror"
                        value="{{ old('nama_pemilik') }}"
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
                        value="{{ old('warna') }}"
                        required
                    >
                    @error('warna')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-12">
                    <label for="foto" class="form-label">Foto Kendaraan (jpg/png/webp, maks 2 MB)</label>
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
            <button type="submit" class="btn btn-primary" id="submitBtn">Simpan</button>
        </div>
    </form>
</div>
@endsection

@push('scripts')
<script>
    document.getElementById('createKendaraanForm')?.addEventListener('submit', function () {
        const btn = document.getElementById('submitBtn');
        if (btn) {
            btn.disabled = true;
            btn.textContent = 'Menyimpan...';
        }
    });
</script>
@endpush

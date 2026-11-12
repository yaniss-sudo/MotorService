@extends('layouts.main')
@section('title', 'Tambah Pelanggan')

@section('content')
<div class="form-shell">
    <a href="{{ route('pelanggan.index') }}" class="breadcrumb-back">
        <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <line x1="19" y1="12" x2="5" y2="12"></line>
            <polyline points="12 19 5 12 12 5"></polyline>
        </svg>
        <span>Kembali ke Data Pelanggan</span>
    </a>

    <form action="{{ route('pelanggan.store') }}" method="POST" class="editor-card" id="createPelangganForm">
        @csrf

        <div class="editor-header">
            <h1 class="editor-title">Tambah Pelanggan</h1>
            <span class="id-badge">ID Pelanggan: Otomatis</span>
        </div>

        <div class="editor-body">
            <!-- KELOMPOK 1: DATA IDENTITAS -->
            <div class="form-section-label">Data Identitas Pelanggan</div>

            <div class="row g-3 mb-4">
                <div class="col-md-6">
                    <label for="nama_lengkap" class="form-label">Nama Lengkap</label>
                    <input
                        type="text"
                        name="nama_lengkap"
                        id="nama_lengkap"
                        class="form-control @error('nama_lengkap') is-invalid @enderror"
                        value="{{ old('nama_lengkap') }}"
                        required
                    >
                    @error('nama_lengkap')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6">
                    <label for="no_hp" class="form-label">No HP</label>
                    <input
                        type="text"
                        name="no_hp"
                        id="no_hp"
                        class="form-control @error('no_hp') is-invalid @enderror"
                        value="{{ old('no_hp') }}"
                        required
                    >
                    @error('no_hp')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6">
                    <label for="pekerjaan" class="form-label">Pekerjaan</label>
                    <input
                        type="text"
                        name="pekerjaan"
                        id="pekerjaan"
                        class="form-control @error('pekerjaan') is-invalid @enderror"
                        value="{{ old('pekerjaan') }}"
                        required
                    >
                    @error('pekerjaan')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6">
                    <label for="id_pelanggan" class="form-label">Id Pelanggan</label>
                    <input type="text" class="form-control" value="Otomatis" disabled readonly>
                </div>
            </div>

            <!-- KELOMPOK 2: ALAMAT -->
            <div class="form-section-label">Alamat</div>

            <div>
                <label for="alamat" class="form-label">Alamat Lengkap</label>
                <textarea
                    name="alamat"
                    id="alamat"
                    rows="3"
                    class="form-control @error('alamat') is-invalid @enderror"
                    required
                >{{ old('alamat') }}</textarea>
                @error('alamat')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
        </div>

        <div class="editor-footer">
            <a href="{{ route('pelanggan.index') }}" class="btn btn-secondary">Batal</a>
            <button type="submit" class="btn btn-primary" id="submitBtn">Simpan</button>
        </div>
    </form>
</div>
@endsection

@push('scripts')
<script>
    document.getElementById('createPelangganForm')?.addEventListener('submit', function () {
        const btn = document.getElementById('submitBtn');
        if (btn) {
            btn.disabled = true;
            btn.textContent = 'Menyimpan...';
        }
    });
</script>
@endpush

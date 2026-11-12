@extends('layouts.main')
@section('title', 'Tambah Pembayaran')

@section('content')
<div class="form-shell">
    <a href="{{ route('pembayaran.index') }}" class="breadcrumb-back">
        <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <line x1="19" y1="12" x2="5" y2="12"></line>
            <polyline points="12 19 5 12 12 5"></polyline>
        </svg>
        <span>Kembali ke Pembayaran</span>
    </a>

    <form action="{{ route('pembayaran.store') }}" method="POST" class="editor-card" id="createPembayaranForm">
        @csrf

        <div class="editor-header">
            <h1 class="editor-title">Tambah Pembayaran</h1>
            <span class="id-badge">ID Pembayaran: Otomatis</span>
        </div>

        <div class="editor-body">
            <!-- KELOMPOK 1: REFERENSI & NOMINAL -->
            <div class="form-section-label">Referensi &amp; Nominal</div>

            <div class="row g-3 mb-4">
                <div class="col-md-6">
                    <label for="id_servis" class="form-label">Id Servis Pelanggan</label>
                    <select
                        name="id_servis"
                        id="id_servis"
                        class="form-select @error('id_servis') is-invalid @enderror"
                        required
                    >
                        <option value="">-- Pilih Id Servis --</option>
                        @foreach($daftarServices as $d)
                            <option value="{{ $d->id_servis }}" {{ (string) old('id_servis') === (string) $d->id_servis ? 'selected' : '' }}>
                                {{ $d->id_servis }} - {{ $d->no_plat }}
                            </option>
                        @endforeach
                    </select>
                    @error('id_servis')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6">
                    <label for="jumlah_biaya" class="form-label">Jumlah Biaya Servis (Rp)</label>
                    <input
                        type="number"
                        name="jumlah_biaya"
                        id="jumlah_biaya"
                        class="form-control @error('jumlah_biaya') is-invalid @enderror"
                        value="{{ old('jumlah_biaya') }}"
                        min="0"
                        required
                    >
                    @error('jumlah_biaya')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <!-- KELOMPOK 2: JENIS & KETERANGAN -->
            <div class="form-section-label">Detail Pembayaran</div>

            <div class="row g-3 mb-4">
                <div class="col-md-6">
                    <label for="jenis_pembayaran" class="form-label">Jenis Pembayaran</label>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="jenis_pembayaran" id="tunai" value="Cash / Tunai" {{ old('jenis_pembayaran') === 'Cash / Tunai' ? 'checked' : '' }} required>
                        <label class="form-check-label" for="tunai">Cash / Tunai</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="jenis_pembayaran" id="nontunai" value="Non Tunai" {{ old('jenis_pembayaran') === 'Non Tunai' ? 'checked' : '' }}>
                        <label class="form-check-label" for="nontunai">Non Tunai</label>
                    </div>
                    @error('jenis_pembayaran')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6">
                    <label for="keterangan" class="form-label">Keterangan</label>
                    <textarea
                        name="keterangan"
                        id="keterangan"
                        rows="3"
                        class="form-control @error('keterangan') is-invalid @enderror"
                    >{{ old('keterangan') }}</textarea>
                    @error('keterangan')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>
        </div>

        <div class="editor-footer">
            <a href="{{ route('pembayaran.index') }}" class="btn btn-secondary">Batal</a>
            <button type="submit" class="btn btn-primary" id="submitBtn">Simpan</button>
        </div>
    </form>
</div>
@endsection

@push('scripts')
<script>
    document.getElementById('createPembayaranForm')?.addEventListener('submit', function () {
        const btn = document.getElementById('submitBtn');
        if (btn) {
            btn.disabled = true;
            btn.textContent = 'Menyimpan...';
        }
    });
</script>
@endpush

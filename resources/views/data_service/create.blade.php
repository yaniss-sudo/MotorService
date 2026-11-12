@extends('layouts.main')
@section('title', 'Tambah Data Service')

@section('content')
<div class="form-shell">
    <a href="{{ route('data-service.index') }}" class="breadcrumb-back">
        <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <line x1="19" y1="12" x2="5" y2="12"></line>
            <polyline points="12 19 5 12 12 5"></polyline>
        </svg>
        <span>Kembali ke Data Service</span>
    </a>

    <form action="{{ route('data-service.store') }}" method="POST" class="editor-card" id="createDataServiceForm">
        @csrf

        <div class="editor-header">
            <h1 class="editor-title">Tambah Data Service</h1>
            <span class="id-badge">ID Servis: Otomatis</span>
        </div>

        <div class="editor-body">
            <!-- KELOMPOK 1: REFERENSI SERVIS -->
            <div class="form-section-label">Referensi Servis</div>

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
                    <label for="keluhan" class="form-label">Keluhan Kendaraan</label>
                    <textarea
                        id="keluhan"
                        name="keluhan"
                        rows="3"
                        class="form-control @error('keluhan') is-invalid @enderror"
                        placeholder="Terisi otomatis setelah memilih Id Servis"
                        readonly
                    ></textarea>
                    @error('keluhan')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <!-- KELOMPOK 2: DETAIL SERVICE -->
            <div class="form-section-label">Detail Pelaksanaan Service</div>

            <div class="row g-3 mb-4">
                <div class="col-md-6">
                    <label for="estimasi_service" class="form-label">Estimasi Service</label>
                    <input
                        type="text"
                        name="estimasi_service"
                        id="estimasi_service"
                        class="form-control @error('estimasi_service') is-invalid @enderror"
                        value="{{ old('estimasi_service') }}"
                        placeholder="contoh: 2 jam"
                        required
                    >
                    @error('estimasi_service')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6">
                    <label for="nama_mekanik" class="form-label">Nama Mekanik</label>
                    <input
                        type="text"
                        name="nama_mekanik"
                        id="nama_mekanik"
                        class="form-control @error('nama_mekanik') is-invalid @enderror"
                        value="{{ old('nama_mekanik') }}"
                        required
                    >
                    @error('nama_mekanik')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div>
                <label for="sparepart_pengganti" class="form-label">Sparepart Pengganti</label>
                <textarea
                    name="sparepart_pengganti"
                    id="sparepart_pengganti"
                    rows="3"
                    class="form-control @error('sparepart_pengganti') is-invalid @enderror"
                    placeholder="Kosongkan jika tidak ada"
                >{{ old('sparepart_pengganti') }}</textarea>
                @error('sparepart_pengganti')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
        </div>

        <div class="editor-footer">
            <a href="{{ route('data-service.index') }}" class="btn btn-secondary">Batal</a>
            <button type="submit" class="btn btn-primary" id="submitBtn">Simpan</button>
        </div>
    </form>
</div>
@endsection

@push('scripts')
<script>
const selectServis = document.getElementById('id_servis');
const inputKeluhan = document.getElementById('keluhan');
const defaultPlaceholder = 'Terisi otomatis setelah memilih Id Servis';

function isiKeluhan() {
    if (!selectServis.value) {
        inputKeluhan.value = '';
        inputKeluhan.classList.remove('is-resolved');
        return;
    }

    inputKeluhan.placeholder = 'Memuat data servis...';

    fetch('/lookup/servis/' + encodeURIComponent(selectServis.value), {
        headers: { 'Accept': 'application/json' }
    })
    .then(res => res.ok ? res.json() : null)
    .then(json => {
        inputKeluhan.placeholder = defaultPlaceholder;
        inputKeluhan.value = json ? json.keluhan : '';

        if (json && json.keluhan) {
            inputKeluhan.classList.remove('is-resolved');
            void inputKeluhan.offsetWidth;
            inputKeluhan.classList.add('is-resolved');
        }
    })
    .catch(() => {
        inputKeluhan.value = '';
        inputKeluhan.placeholder = defaultPlaceholder;
    });
}

selectServis.addEventListener('change', isiKeluhan);
isiKeluhan();

document.getElementById('createDataServiceForm')?.addEventListener('submit', function () {
    const btn = document.getElementById('submitBtn');
    if (btn) {
        btn.disabled = true;
        btn.textContent = 'Menyimpan...';
    }
});
</script>
@endpush

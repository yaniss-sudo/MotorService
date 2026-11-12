@extends('layouts.main')
@section('title', 'Data Service')

@section('content')
<!-- BANNER HEADER DENGAN BACKDROP -->
<div class="module-banner" style="background-image: url('{{ asset('images/sergey-zolkin-_UeY8aTI6d0-unsplash.jpg') }}');">
    <div class="module-banner-content">
        <div>
            <span class="module-eyebrow">Administrasi Bengkel</span>
            <h1 class="page-title">Data Service</h1>
            <p class="page-subtitle">Catatan estimasi, mekanik, dan sparepart untuk setiap servis.</p>
        </div>

        @if(auth()->user()->isAdmin())
            <a href="{{ route('data-service.create') }}" class="btn btn-primary d-inline-flex align-items-center gap-2">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round">
                    <line x1="12" y1="5" x2="12" y2="19"></line>
                    <line x1="5" y1="12" x2="19" y2="12"></line>
                </svg>
                <span>Tambah Data Service</span>
            </a>
        @endif
    </div>
</div>

<!-- KARTU TABEL DATA -->
<div class="card">
    <div class="table-toolbar">
        <div class="search-input-wrap">
            <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <circle cx="11" cy="11" r="8"></circle>
                <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
            </svg>
            <input type="text" id="tableSearch" class="form-control" placeholder="Cari id servis, keluhan, mekanik...">
        </div>

        <span class="data-counter">
            Total: <strong class="text-white">{{ $dataServices->count() }}</strong> Data Service
        </span>
    </div>

    <div class="table-responsive">
        <table class="table table-hover align-middle" id="dataServiceTable">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Id Servis</th>
                    <th>Keluhan</th>
                    <th>Estimasi Service</th>
                    <th>Nama Mekanik</th>
                    <th>Sparepart Pengganti</th>
                    @if(auth()->user()->isAdmin())
                        <th class="text-end">Aksi</th>
                    @endif
                </tr>
            </thead>
            <tbody>
                @forelse($dataServices as $i => $d)
                    <tr>
                        <td>{{ $i + 1 }}</td>
                        <td><span class="id-badge">#{{ $d->id_servis }}</span></td>
                        <td>
                            <div class="keluhan-text">{{ $d->daftarService->keluhan ?? '-' }}</div>
                        </td>
                        <td>{{ $d->estimasi_service }}</td>
                        <td class="fw-semibold text-white">{{ $d->nama_mekanik }}</td>
                        <td>{{ $d->sparepart_pengganti ?: '-' }}</td>
                        @if(auth()->user()->isAdmin())
                            <td class="text-end text-nowrap">
                                <div class="action-group">
                                    <a href="{{ route('data-service.edit', $d->id) }}" class="btn btn-warning btn-sm">Edit</a>
                                    <form action="{{ route('data-service.destroy', $d->id) }}" method="POST" class="d-inline m-0">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Hapus data ini?')">Hapus</button>
                                    </form>
                                </div>
                            </td>
                        @endif
                    </tr>
                @empty
                    <tr>
                        <td colspan="{{ auth()->user()->isAdmin() ? 7 : 6 }}" class="empty-state">
                            Belum ada data service yang tercatat.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection

@push('scripts')
<script>
    document.getElementById('tableSearch')?.addEventListener('keyup', function () {
        const keyword = this.value.toLowerCase();
        const rows = document.querySelectorAll('#dataServiceTable tbody tr');

        rows.forEach(row => {
            if (row.querySelector('.empty-state')) return;
            const text = row.textContent.toLowerCase();
            row.style.display = text.includes(keyword) ? '' : 'none';
        });
    });
</script>
@endpush

@extends('layouts.main')
@section('title', 'Kendaraan')

@section('content')
<!-- BANNER HEADER DENGAN BACKDROP -->
<div class="module-banner" style="background-image: url('{{ asset('images/sergey-zolkin-_UeY8aTI6d0-unsplash.jpg') }}');">
    <div class="module-banner-content">
        <div>
            <span class="module-eyebrow">Manajemen Kendaraan</span>
            <h1 class="page-title">Data Kendaraan</h1>
            <p class="page-subtitle">Kelola data kendaraan motor yang terdaftar di bengkel.</p>
        </div>

        @if(auth()->user()->isAdmin())
            <a href="{{ route('kendaraan.create') }}" class="btn btn-primary d-inline-flex align-items-center gap-2">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round">
                    <line x1="12" y1="5" x2="12" y2="19"></line>
                    <line x1="5" y1="12" x2="19" y2="12"></line>
                </svg>
                <span>Tambah Kendaraan</span>
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
            <input type="text" id="tableSearch" class="form-control" placeholder="Cari no plat, pemilik, jenis...">
        </div>

        <span class="data-counter">
            Total: <strong class="text-white">{{ $kendaraans->count() }}</strong> Kendaraan
        </span>
    </div>

    <div class="table-responsive">
        <table class="table table-hover align-middle" id="kendaraanTable">
            <thead>
                <tr>
                    <th>Foto</th>
                    <th>No Plat</th>
                    <th>Jenis</th>
                    <th>No STNK</th>
                    <th>Tahun</th>
                    <th>Pemilik</th>
                    <th>Warna</th>
                    @if(auth()->user()->isAdmin())
                        <th class="text-end">Aksi</th>
                    @endif
                </tr>
            </thead>
            <tbody>
                @forelse($kendaraans as $k)
                    <tr>
                        <td>
                            @if($k->foto)
                                <img src="{{ asset('storage/'.$k->foto) }}" width="80" class="rounded" alt="Foto {{ $k->no_plat }}">
                            @else
                                <span class="text-muted">-</span>
                            @endif
                        </td>
                        <td>
                            <span class="plate-badge">{{ $k->no_plat }}</span>
                        </td>
                        <td>{{ $k->jenis_kendaraan }}</td>
                        <td>{{ $k->no_stnk }}</td>
                        <td>{{ $k->tahun_pembuatan }}</td>
                        <td class="fw-semibold text-white">{{ $k->nama_pemilik }}</td>
                        <td>{{ $k->warna }}</td>
                        @if(auth()->user()->isAdmin())
                            <td class="text-end text-nowrap">
                                <div class="action-group">
                                    <a href="{{ route('kendaraan.edit', $k->no_plat) }}" class="btn btn-warning btn-sm">Edit</a>
                                    <form action="{{ route('kendaraan.destroy', $k->no_plat) }}" method="POST" class="d-inline m-0">
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
                        <td colspan="{{ auth()->user()->isAdmin() ? 8 : 7 }}" class="empty-state">
                            Belum ada data kendaraan yang tercatat.
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
        const rows = document.querySelectorAll('#kendaraanTable tbody tr');

        rows.forEach(row => {
            if (row.querySelector('.empty-state')) return;
            const text = row.textContent.toLowerCase();
            row.style.display = text.includes(keyword) ? '' : 'none';
        });
    });
</script>
@endpush

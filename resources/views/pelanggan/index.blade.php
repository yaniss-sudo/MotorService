@extends('layouts.main')
@section('title', 'Pelanggan')

@section('content')
<!-- BANNER HEADER DENGAN BACKDROP -->
<div class="module-banner" style="background-image: url('{{ asset('images/sergey-zolkin-_UeY8aTI6d0-unsplash.jpg') }}');">
    <div class="module-banner-content">
        <div>
            <span class="module-eyebrow">Manajemen Pelanggan</span>
            <h1 class="page-title">Data Pelanggan</h1>
            <p class="page-subtitle">Kelola data pelanggan bengkel dan kontak mereka.</p>
        </div>

        @if(auth()->user()->isAdmin())
            <a href="{{ route('pelanggan.create') }}" class="btn btn-primary d-inline-flex align-items-center gap-2">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round">
                    <line x1="12" y1="5" x2="12" y2="19"></line>
                    <line x1="5" y1="12" x2="19" y2="12"></line>
                </svg>
                <span>Tambah Pelanggan</span>
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
            <input type="text" id="tableSearch" class="form-control" placeholder="Cari nama, no HP, alamat...">
        </div>

        <span class="data-counter">
            Total: <strong class="text-white">{{ $pelanggans->count() }}</strong> Pelanggan
        </span>
    </div>

    <div class="table-responsive">
        <table class="table table-hover align-middle" id="pelangganTable">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nama Lengkap</th>
                    <th>No HP</th>
                    <th>Alamat</th>
                    <th>Pekerjaan</th>
                    @if(auth()->user()->isAdmin())
                        <th class="text-end">Aksi</th>
                    @endif
                </tr>
            </thead>
            <tbody>
                @forelse($pelanggans as $p)
                    <tr>
                        <td>
                            <span class="id-badge">#{{ $p->id_pelanggan }}</span>
                        </td>
                        <td class="fw-semibold text-white">
                            {{ $p->nama_lengkap }}
                        </td>
                        <td>{{ $p->no_hp }}</td>
                        <td>{{ $p->alamat }}</td>
                        <td>{{ $p->pekerjaan }}</td>
                        @if(auth()->user()->isAdmin())
                            <td class="text-end text-nowrap">
                                <div class="action-group">
                                    <a href="{{ route('pelanggan.edit', $p->id_pelanggan) }}" class="btn btn-warning btn-sm">Edit</a>
                                    <form action="{{ route('pelanggan.destroy', $p->id_pelanggan) }}" method="POST" class="d-inline m-0">
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
                        <td colspan="{{ auth()->user()->isAdmin() ? 6 : 5 }}" class="empty-state">
                            Belum ada data pelanggan yang tercatat.
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
        const rows = document.querySelectorAll('#pelangganTable tbody tr');

        rows.forEach(row => {
            if (row.querySelector('.empty-state')) return;
            const text = row.textContent.toLowerCase();
            row.style.display = text.includes(keyword) ? '' : 'none';
        });
    });
</script>
@endpush

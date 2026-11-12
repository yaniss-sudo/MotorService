@extends('layouts.main')
@section('title', 'Pembayaran')

@section('content')
<!-- BANNER HEADER DENGAN BACKDROP -->
<div class="module-banner" style="background-image: url('{{ asset('images/sergey-zolkin-_UeY8aTI6d0-unsplash.jpg') }}');">
    <div class="module-banner-content">
        <div>
            <span class="module-eyebrow">Keuangan Bengkel</span>
            <h1 class="page-title">Pembayaran Service</h1>
            <p class="page-subtitle">Catatan pembayaran dan biaya servis pelanggan.</p>
        </div>

        @if(auth()->user()->isAdmin())
            <a href="{{ route('pembayaran.create') }}" class="btn btn-primary d-inline-flex align-items-center gap-2">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round">
                    <line x1="12" y1="5" x2="12" y2="19"></line>
                    <line x1="5" y1="12" x2="19" y2="12"></line>
                </svg>
                <span>Tambah Pembayaran</span>
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
            <input type="text" id="tableSearch" class="form-control" placeholder="Cari id servis, jenis, keterangan...">
        </div>

        <span class="data-counter">
            Total: <strong class="text-white">{{ $pembayarans->count() }}</strong> Pembayaran
        </span>
    </div>

    <div class="table-responsive">
        <table class="table table-hover align-middle" id="pembayaranTable">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Id Servis</th>
                    <th class="text-end">Jumlah Biaya</th>
                    <th>Jenis Pembayaran</th>
                    <th>Keterangan</th>
                    @if(auth()->user()->isAdmin())
                        <th class="text-end">Aksi</th>
                    @endif
                </tr>
            </thead>
            <tbody>
                @forelse($pembayarans as $i => $p)
                    <tr>
                        <td>{{ $i + 1 }}</td>
                        <td><span class="id-badge">#{{ $p->id_servis }}</span></td>
                        <td class="currency text-end">Rp {{ number_format($p->jumlah_biaya, 0, ',', '.') }}</td>
                        <td>
                            <span class="badge-pembayaran {{ str_contains(strtolower($p->jenis_pembayaran), 'tunai') ? 'badge-pembayaran-cash' : 'badge-pembayaran-nontunai' }}">
                                {{ $p->jenis_pembayaran }}
                            </span>
                        </td>
                        <td>{{ $p->keterangan ?: '-' }}</td>
                        @if(auth()->user()->isAdmin())
                            <td class="text-end text-nowrap">
                                <div class="action-group">
                                    <a href="{{ route('pembayaran.edit', $p->id) }}" class="btn btn-warning btn-sm">Edit</a>
                                    <form action="{{ route('pembayaran.destroy', $p->id) }}" method="POST" class="d-inline m-0">
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
                            Belum ada data pembayaran yang tercatat.
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
        const rows = document.querySelectorAll('#pembayaranTable tbody tr');

        rows.forEach(row => {
            if (row.querySelector('.empty-state')) return;
            const text = row.textContent.toLowerCase();
            row.style.display = text.includes(keyword) ? '' : 'none';
        });
    });
</script>
@endpush

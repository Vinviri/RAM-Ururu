@extends('layouts.app')

@section('title', 'Data Stok Barang')
@section('page-title', 'Data Stok Barang')
@section('breadcrumb', 'Persediaan Barang / Data Stok')

@section('content')
<div class="stok-container">
    {{-- Main List Area --}}
    <div class="stok-main">
        <div class="page-card">
            <div class="page-card-header">
                <h2 class="page-card-title">Daftar Stok</h2>
                <div class="search-box">
                    <form method="GET" action="{{ route('persediaan.stok') }}">
                        <input type="text" name="search" class="form-input-plain" placeholder="Cari nama atau kode..." value="{{ request('search') }}" onblur="this.form.submit()">
                    </form>
                </div>
            </div>
            <div class="page-card-body">
                @if($barangs->count() > 0)
                <div class="stok-list">
                    @foreach($barangs as $barang)
                    <div class="stok-item" onclick="loadDetail({{ $barang->id_barang }}, this)">
                        <div class="stok-item-info">
                            <span class="code-badge">{{ $barang->kode_barang }}</span>
                            <h3 class="stok-item-name">{{ $barang->nama_barang }}</h3>
                            <span class="stok-item-category">{{ $barang->kategori->nama_kategori ?? 'Umum' }}</span>
                        </div>
                        <div class="stok-item-amount">
                            <span class="stok-badge {{ $barang->stok_saat_ini < 10 ? 'stock-low' : 'stock-high' }}" style="font-size: 1.2rem; padding: 0.4rem 0.8rem;">
                                {{ number_format($barang->stok_saat_ini) }}
                            </span>
                        </div>
                    </div>
                    @endforeach
                </div>
                @else
                <div class="empty-state">
                    <svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path d="m7.5 4.27 9 5.15"/><path d="M21 8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16Z"/><path d="m3.3 7 8.7 5 8.7-5"/><path d="M12 22V12"/></svg>
                    <p>Barang tidak ditemukan</p>
                </div>
                @endif
            </div>
        </div>
    </div>

    {{-- Right Sidebar Panel --}}
    <div class="stok-sidebar" id="stok-panel">
        <div class="panel-empty" id="panel-empty">
            <svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" style="margin-bottom: 1rem; color: var(--gray-400);"><circle cx="12" cy="12" r="10"/><path d="m15 9-6 6"/><path d="m9 9 6 6"/></svg>
            <p style="color: var(--gray-500); text-align: center;">Pilih barang dari daftar untuk melihat detail dan riwayat.</p>
        </div>
        <div class="panel-content hidden" id="panel-content">
            <div class="panel-header">
                <span class="code-badge" id="panel-kode">-</span>
                <h3 class="panel-title" id="panel-nama">-</h3>
                <span class="status-badge" id="panel-status">-</span>
            </div>
            
            <div class="panel-stock-box">
                <span class="panel-stock-label">Stok Saat Ini</span>
                <span class="panel-stock-value" id="panel-stok">0</span>
            </div>

            <div class="panel-history">
                <h4>5 Transaksi Terakhir</h4>
                <div class="history-list" id="history-list">
                    <!-- History injected via JS -->
                </div>
            </div>
            
            <div class="panel-actions">
                <a href="{{ route('persediaan.masuk.create') }}" class="btn btn-primary" style="width: 100%; justify-content: center; margin-bottom: 0.5rem; background: var(--success); box-shadow: 0 4px 12px rgba(16, 185, 129, 0.2);">
                    Catat Barang Masuk
                </a>
                <a href="{{ route('persediaan.keluar.create') }}" class="btn btn-primary" style="width: 100%; justify-content: center; background: var(--danger); box-shadow: 0 4px 12px rgba(239, 68, 68, 0.2);">
                    Catat Barang Keluar
                </a>
            </div>
        </div>
    </div>
</div>

<style>
.stok-container {
    display: grid;
    grid-template-columns: 1fr 350px;
    gap: 1.5rem;
    height: calc(100vh - 120px);
}

.stok-main {
    height: 100%;
}

.stok-main .page-card {
    height: 100%;
    display: flex;
    flex-direction: column;
}

.stok-list {
    display: flex;
    flex-direction: column;
    gap: 1rem;
    overflow-y: auto;
    padding-right: 0.5rem;
}

.stok-item {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 1.2rem;
    background: var(--white);
    border: 1px solid var(--gray-200);
    border-radius: 16px;
    cursor: pointer;
    transition: all 0.3s ease;
}

.stok-item:hover, .stok-item.active {
    border-color: var(--primary);
    box-shadow: 0 4px 12px var(--primary-light);
    transform: translateY(-2px);
}

.stok-item-info {
    display: flex;
    flex-direction: column;
    gap: 0.4rem;
}

.stok-item-name {
    font-size: 1.1rem;
    font-weight: 600;
    color: var(--gray-900);
    margin: 0;
}

.stok-item-category {
    font-size: 0.85rem;
    color: var(--gray-500);
}

.stok-sidebar {
    background: var(--white);
    border-radius: 20px;
    box-shadow: 0 8px 30px rgba(0,0,0,0.04);
    padding: 1.5rem;
    display: flex;
    flex-direction: column;
    height: 100%;
    overflow-y: auto;
}

.panel-empty {
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    height: 100%;
}

.panel-content {
    display: flex;
    flex-direction: column;
    height: 100%;
}

.panel-content.hidden {
    display: none;
}

.panel-header {
    display: flex;
    flex-direction: column;
    align-items: flex-start;
    gap: 0.5rem;
    padding-bottom: 1.5rem;
    border-bottom: 1px solid var(--gray-200);
}

.panel-title {
    font-size: 1.2rem;
    font-weight: 600;
    margin: 0;
}

.panel-stock-box {
    background: var(--primary-light);
    padding: 1.5rem;
    border-radius: 12px;
    display: flex;
    flex-direction: column;
    align-items: center;
    margin: 1.5rem 0;
}

.panel-stock-label {
    font-size: 0.9rem;
    color: var(--primary);
    font-weight: 500;
}

.panel-stock-value {
    font-size: 3rem;
    font-weight: 700;
    color: var(--primary);
    line-height: 1;
    margin-top: 0.5rem;
}

.panel-history {
    flex: 1;
}

.panel-history h4 {
    font-size: 0.95rem;
    color: var(--gray-700);
    margin-bottom: 1rem;
}

.history-list {
    display: flex;
    flex-direction: column;
    gap: 0.8rem;
}

.history-item {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 0.8rem;
    background: var(--gray-50);
    border-radius: 8px;
    font-size: 0.85rem;
}

.history-item-left {
    display: flex;
    flex-direction: column;
    gap: 0.2rem;
}

.history-date {
    color: var(--gray-500);
    font-size: 0.75rem;
}

.history-amount.masuk {
    color: var(--success);
    font-weight: 600;
}

.history-amount.keluar {
    color: var(--danger);
    font-weight: 600;
}

.panel-actions {
    margin-top: auto;
    padding-top: 1.5rem;
}

@media (max-width: 992px) {
    .stok-container {
        grid-template-columns: 1fr;
        height: auto;
    }
}
</style>
@endsection

@push('scripts')
<script>
    function loadDetail(id, element) {
        // Highlight active item
        document.querySelectorAll('.stok-item').forEach(el => el.classList.remove('active'));
        element.classList.add('active');

        // Fetch detail
        fetch('/api/barang-detail/' + id)
            .then(r => r.json())
            .then(data => {
                document.getElementById('panel-empty').style.display = 'none';
                document.getElementById('panel-content').classList.remove('hidden');
                
                document.getElementById('panel-kode').textContent = data.barang.kode_barang;
                document.getElementById('panel-nama').textContent = data.barang.nama_barang;
                
                const statusBadge = document.getElementById('panel-status');
                statusBadge.textContent = data.barang.status_barang;
                statusBadge.className = 'status-badge ' + (data.barang.status_barang === 'Tersedia' ? 'status-available' : (data.barang.status_barang === 'Warning' ? 'status-warning' : 'status-unavailable'));
                
                document.getElementById('panel-stok').textContent = new Intl.NumberFormat('id-ID').format(data.barang.stok_saat_ini);
                
                const historyList = document.getElementById('history-list');
                historyList.innerHTML = '';
                
                if (data.riwayat.length === 0) {
                    historyList.innerHTML = '<p style="color:var(--gray-500); font-size: 0.85rem; text-align: center;">Belum ada transaksi</p>';
                } else {
                    data.riwayat.forEach(row => {
                        const isMasuk = row.jenis_transaksi === 'Masuk';
                        const sign = isMasuk ? '+' : '-';
                        const cls = isMasuk ? 'masuk' : 'keluar';
                        
                        // Format tanggal
                        const tgl = new Date(row.tgl_transaksi);
                        const tglFormatted = tgl.toLocaleDateString('id-ID', { day: '2-digit', month: 'short', year: 'numeric' });
                        
                        historyList.innerHTML += `
                            <div class="history-item">
                                <div class="history-item-left">
                                    <span style="font-weight:500">${row.jenis_transaksi}</span>
                                    <span class="history-date">${tglFormatted} | ${row.user ? row.user.nama_admin : '-'}</span>
                                </div>
                                <div class="history-amount ${cls}">${sign}${row.jumlah_barang}</div>
                            </div>
                        `;
                    });
                }
            });
    }
</script>
@endpush

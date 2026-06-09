@extends('layouts.app')

@section('title', 'Dashboard')
@section('page-title', 'Dashboard')
@section('breadcrumb', 'Beranda / Dashboard')
@section('description', 'Dashboard Sistem Persediaan Barang Toko RAM Ururu')

@section('content')
<div class="dashboard">
    {{-- Statistics Cards --}}
    <div class="stats-grid">
        {{-- Total Barang --}}
        <div class="stat-card stat-card-blue" id="stat-total-barang">
            <div class="stat-card-content">
                <div class="stat-info">
                    <p class="stat-label">Total Barang</p>
                    <h3 class="stat-value">{{ number_format($totalBarang) }}</h3>
                    <p class="stat-desc">Jenis barang terdaftar</p>
                </div>
                <div class="stat-icon stat-icon-blue">
                    <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="m7.5 4.27 9 5.15"/>
                        <path d="M21 8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16Z"/>
                        <path d="m3.3 7 8.7 5 8.7-5"/>
                        <path d="M12 22V12"/>
                    </svg>
                </div>
            </div>
            <div class="stat-card-bar stat-bar-blue"></div>
        </div>

        {{-- Total Stok Masuk --}}
        <div class="stat-card stat-card-green" id="stat-stok-masuk">
            <div class="stat-card-content">
                <div class="stat-info">
                    <p class="stat-label">Total Stok Masuk</p>
                    <h3 class="stat-value">{{ number_format($totalStokMasuk) }}</h3>
                    <p class="stat-desc">Unit barang masuk</p>
                </div>
                <div class="stat-icon stat-icon-green">
                    <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M12 3v12"/>
                        <path d="m8 11 4 4 4-4"/>
                        <path d="M8 5H4a2 2 0 0 0-2 2v10a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V7a2 2 0 0 0-2-2h-4"/>
                    </svg>
                </div>
            </div>
            <div class="stat-card-bar stat-bar-green"></div>
        </div>

        {{-- Total Stok Keluar --}}
        <div class="stat-card stat-card-red" id="stat-stok-keluar">
            <div class="stat-card-content">
                <div class="stat-info">
                    <p class="stat-label">Total Stok Keluar</p>
                    <h3 class="stat-value">{{ number_format($totalStokKeluar) }}</h3>
                    <p class="stat-desc">Unit barang keluar</p>
                </div>
                <div class="stat-icon stat-icon-red">
                    <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M12 21V9"/>
                        <path d="m16 13-4-4-4 4"/>
                        <path d="M8 5H4a2 2 0 0 0-2 2v10a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V7a2 2 0 0 0-2-2h-4"/>
                    </svg>
                </div>
            </div>
            <div class="stat-card-bar stat-bar-red"></div>
        </div>

        {{-- Stok Rendah --}}
        <div class="stat-card stat-card-amber" id="stat-stok-rendah">
            <div class="stat-card-content">
                <div class="stat-info">
                    <p class="stat-label">Stok Rendah</p>
                    <h3 class="stat-value">{{ $stokRendah }}</h3>
                    <p class="stat-desc">Barang stok &lt; 10</p>
                </div>
                <div class="stat-icon stat-icon-amber">
                    <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="m21.73 18-8-14a2 2 0 0 0-3.48 0l-8 14A2 2 0 0 0 4 21h16a2 2 0 0 0 1.73-3"/>
                        <path d="M12 9v4"/>
                        <path d="M12 17h.01"/>
                    </svg>
                </div>
            </div>
            <div class="stat-card-bar stat-bar-amber"></div>
        </div>
    </div>

    {{-- Detail Tables Section --}}
    <div class="dashboard-grid">
        {{-- Stok Terendah Table --}}
        <div class="dashboard-card" id="card-stok-terendah">
            <div class="card-header">
                <div class="card-header-info">
                    <h3 class="card-title">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="m21.73 18-8-14a2 2 0 0 0-3.48 0l-8 14A2 2 0 0 0 4 21h16a2 2 0 0 0 1.73-3"/>
                            <path d="M12 9v4"/>
                            <path d="M12 17h.01"/>
                        </svg>
                        Stok Terendah
                    </h3>
                    <p class="card-subtitle">Barang dengan stok kurang dari 10 unit</p>
                </div>
                <span class="card-badge badge-warning">Perlu Perhatian</span>
            </div>
            <div class="card-body">
                @if(count($barangTerendah) > 0)
                <div class="table-responsive">
                    <table class="data-table">
                        <thead>
                            <tr>
                                <th>Kode</th>
                                <th>Nama Barang</th>
                                <th>Kategori</th>
                                <th>Stok</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($barangTerendah as $item)
                            <tr>
                                <td><span class="code-badge">{{ $item->kode_barang }}</span></td>
                                <td>{{ $item->nama_barang }}</td>
                                <td>{{ $item->kategori->nama_kategori ?? '-' }}</td>
                                <td>
                                    <span class="stock-badge stock-low">{{ $item->stok_saat_ini }}</span>
                                </td>
                                <td>
                                    <span class="status-badge {{ $item->status_barang === 'Tersedia' ? 'status-available' : 'status-unavailable' }}">
                                        {{ $item->status_barang }}
                                    </span>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                @else
                <div class="empty-state">
                    <svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M12 22c5.523 0 10-4.477 10-10S17.523 2 12 2 2 6.477 2 12s4.477 10 10 10z"/>
                        <path d="M8 14s1.5 2 4 2 4-2 4-2"/>
                        <line x1="9" x2="9.01" y1="9" y2="9"/>
                        <line x1="15" x2="15.01" y1="9" y2="9"/>
                    </svg>
                    <p>Semua stok barang aman!</p>
                    <span>Tidak ada barang dengan stok di bawah 10 unit</span>
                </div>
                @endif
            </div>
        </div>

        {{-- Stok Tertinggi Table --}}
        <div class="dashboard-card" id="card-stok-tertinggi">
            <div class="card-header">
                <div class="card-header-info">
                    <h3 class="card-title">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M6 20h4a2 2 0 0 0 2-2v-8a2 2 0 0 0-2-2H6a2 2 0 0 0-2 2v8a2 2 0 0 0 2 2Z"/>
                            <path d="M14 20h4a2 2 0 0 0 2-2V6a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2Z"/>
                        </svg>
                        Stok Tertinggi
                    </h3>
                    <p class="card-subtitle">Barang dengan stok terbanyak</p>
                </div>
                <span class="card-badge badge-success">Top 5</span>
            </div>
            <div class="card-body">
                @if(count($barangTertinggi) > 0)
                <div class="table-responsive">
                    <table class="data-table">
                        <thead>
                            <tr>
                                <th>Kode</th>
                                <th>Nama Barang</th>
                                <th>Kategori</th>
                                <th>Stok</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($barangTertinggi as $item)
                            <tr>
                                <td><span class="code-badge">{{ $item->kode_barang }}</span></td>
                                <td>{{ $item->nama_barang }}</td>
                                <td>{{ $item->kategori->nama_kategori ?? '-' }}</td>
                                <td>
                                    <span class="stock-badge stock-high">{{ number_format($item->stok_saat_ini) }}</span>
                                </td>
                                <td>
                                    <span class="status-badge {{ $item->status_barang === 'Tersedia' ? 'status-available' : 'status-unavailable' }}">
                                        {{ $item->status_barang }}
                                    </span>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                @else
                <div class="empty-state">
                    <svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
                        <path d="m7.5 4.27 9 5.15"/>
                        <path d="M21 8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16Z"/>
                        <path d="m3.3 7 8.7 5 8.7-5"/>
                        <path d="M12 22V12"/>
                    </svg>
                    <p>Belum ada data barang</p>
                    <span>Tambahkan barang melalui menu Master Data</span>
                </div>
                @endif
            </div>
        </div>

        {{-- Transaksi Terbaru --}}
        <div class="dashboard-card card-full-width" id="card-transaksi-terbaru">
            <div class="card-header">
                <div class="card-header-info">
                    <h3 class="card-title">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <circle cx="12" cy="12" r="10"/>
                            <polyline points="12 6 12 12 16 14"/>
                        </svg>
                        Transaksi Terbaru
                    </h3>
                    <p class="card-subtitle">5 transaksi terakhir yang dilakukan</p>
                </div>
            </div>
            <div class="card-body">
                @if(count($transaksiTerbaru) > 0)
                <div class="table-responsive">
                    <table class="data-table">
                        <thead>
                            <tr>
                                <th>Tanggal</th>
                                <th>Kode Barang</th>
                                <th>Nama Barang</th>
                                <th>Jenis</th>
                                <th>Jumlah</th>
                                <th>Pencatat</th>
                                <th>Keterangan</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($transaksiTerbaru as $trx)
                            <tr>
                                <td>{{ $trx->tgl_transaksi ? $trx->tgl_transaksi->format('d/m/Y') : '-' }}</td>
                                <td><span class="code-badge">{{ $trx->barang->kode_barang ?? '-' }}</span></td>
                                <td>{{ $trx->barang->nama_barang ?? '-' }}</td>
                                <td>
                                    <span class="type-badge {{ $trx->jenis_transaksi === 'Masuk' ? 'type-in' : 'type-out' }}">
                                        @if($trx->jenis_transaksi === 'Masuk')
                                            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M12 3v12"/><path d="m8 11 4 4 4-4"/></svg>
                                        @else
                                            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M12 21V9"/><path d="m16 13-4-4-4 4"/></svg>
                                        @endif
                                        {{ $trx->jenis_transaksi }}
                                    </span>
                                </td>
                                <td><strong>{{ number_format($trx->jumlah_barang) }}</strong></td>
                                <td>{{ $trx->user->nama_admin ?? '-' }}</td>
                                <td class="text-muted">{{ Str::limit($trx->keterangan, 40) ?? '-' }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                @else
                <div class="empty-state">
                    <svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
                        <circle cx="12" cy="12" r="10"/>
                        <polyline points="12 6 12 12 16 14"/>
                    </svg>
                    <p>Belum ada transaksi</p>
                    <span>Transaksi akan muncul setelah ada barang masuk atau keluar</span>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection

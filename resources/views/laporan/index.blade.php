@extends('layouts.app')

@section('title', 'Laporan Transaksi')
@section('page-title', 'Laporan Transaksi')
@section('breadcrumb', 'Laporan / Riwayat Transaksi')

@section('content')
    <div class="page-card">
        <div class="page-card-header" style="justify-content: space-between; align-items: flex-end;">
            <div>
                <h2 class="page-card-title">Riwayat Keluar Masuk Barang</h2>
                <p style="color: var(--gray-500); font-size: 0.9rem; margin-top: 0.5rem;">Daftar seluruh aktivitas transaksi
                    persediaan barang.</p>
            </div>

            <form method="GET" action="{{ route('laporan.index') }}" class="filter-form">
                <div class="filter-group">
                    <label for="start_date">Dari Tanggal</label>
                    <input type="date" id="start_date" name="start_date" class="form-input-plain"
                        value="{{ request('start_date') }}">
                </div>
                <div class="filter-group">
                    <label for="end_date">Sampai Tanggal</label>
                    <input type="date" id="end_date" name="end_date" class="form-input-plain"
                        value="{{ request('end_date') }}">
                </div>
                <div class="filter-group">
                    <label for="jenis_transaksi">Jenis Transaksi</label>
                    <select id="jenis_transaksi" name="jenis_transaksi" class="form-select">
                        <option value="">Semua</option>
                        <option value="Masuk" {{ request('jenis_transaksi') == 'Masuk' ? 'selected' : '' }}>Masuk</option>
                        <option value="Keluar" {{ request('jenis_transaksi') == 'Keluar' ? 'selected' : '' }}>Keluar</option>
                    </select>
                </div>
                <div class="filter-actions">
                    <button type="submit" class="btn btn-primary" style="height: 100%;">Terapkan Filter</button>
                    <a href="{{ route('laporan.index') }}" class="btn btn-secondary" style="height: 100%;">Reset</a>
                    <a href="{{ route('laporan.export-pdf', request()->all()) }}" class="btn btn-success"
                        style="height: 100%; display: flex; align-items: center; gap: 0.5rem;" target="_blank">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none"
                            stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path>
                            <polyline points="14 2 14 8 20 8"></polyline>
                            <line x1="16" y1="13" x2="8" y2="13"></line>
                            <line x1="16" y1="17" x2="8" y2="17"></line>
                            <polyline points="10 9 9 9 8 9"></polyline>
                        </svg>
                        Export PDF
                    </a>
                </div>
            </form>
        </div>

        <div class="page-card-body">
            @if($transaksis->count() > 0)
                <div class="table-responsive">
                    <table class="data-table">
                        <thead>
                            <tr>
                                <th>Tgl Transaksi</th>
                                <th>Kode Barang</th>
                                <th>Nama Barang</th>
                                <th>Jenis</th>
                                <th>Jumlah</th>
                                <th>Keterangan</th>
                                <th>Pencatat (Admin)</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($transaksis as $t)
                                <tr>
                                    <td style="color: var(--gray-600);">{{ date('d M Y', strtotime($t->tgl_transaksi)) }}</td>
                                    <td><span class="code-badge">{{ $t->barang->kode_barang ?? '-' }}</span></td>
                                    <td style="font-weight: 500;">{{ $t->barang->nama_barang ?? '-' }}</td>
                                    <td>
                                        <span class="status-badge"
                                            style="background: {{ $t->jenis_transaksi == 'Masuk' ? 'rgba(16,185,129,0.1)' : 'rgba(239,68,68,0.1)' }}; color: {{ $t->jenis_transaksi == 'Masuk' ? 'var(--success)' : 'var(--danger)' }};">
                                            {{ $t->jenis_transaksi }}
                                        </span>
                                    </td>
                                    <td
                                        style="font-weight: 600; font-size: 1.1rem; color: {{ $t->jenis_transaksi == 'Masuk' ? 'var(--success)' : 'var(--danger)' }};">
                                        {{ $t->jenis_transaksi == 'Masuk' ? '+' : '-' }}{{ number_format($t->jumlah_barang) }}
                                    </td>
                                    <td style="color: var(--gray-500); max-width: 200px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;"
                                        title="{{ $t->keterangan }}">
                                        {{ $t->keterangan ?? '-' }}
                                    </td>
                                    <td>{{ $t->user->nama_admin ?? '-' }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="empty-state">
                    <svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" viewBox="0 0 24 24" fill="none"
                        stroke="currentColor" stroke-width="1.5">
                        <rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect>
                        <line x1="16" y1="2" x2="16" y2="6"></line>
                        <line x1="8" y1="2" x2="8" y2="6"></line>
                        <line x1="3" y1="10" x2="21" y2="10"></line>
                    </svg>
                    <p>Tidak ada data transaksi</p>
                    <span>Belum ada transaksi pada periode ini</span>
                </div>
            @endif
        </div>
    </div>

    <style>
        .filter-form {
            display: flex;
            gap: 1rem;
            align-items: flex-end;
        }

        .filter-group {
            display: flex;
            flex-direction: column;
            gap: 0.4rem;
        }

        .filter-group label {
            font-size: 0.85rem;
            color: var(--gray-600);
            font-weight: 500;
        }

        .filter-actions {
            display: flex;
            gap: 0.5rem;
            height: 42px;
            /* align with inputs */
        }

        @media (max-width: 992px) {
            .page-card-header {
                flex-direction: column;
                align-items: flex-start !important;
                gap: 1.5rem;
            }

            .filter-form {
                width: 100%;
                flex-wrap: wrap;
            }

            .filter-group {
                flex: 1;
                min-width: 150px;
            }
        }
    </style>
@endsection
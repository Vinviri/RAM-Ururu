@extends('layouts.app')

@section('title', 'Form Barang Masuk')
@section('page-title', 'Form Barang Masuk')
@section('breadcrumb', 'Persediaan Barang / Barang Masuk')

@section('content')
<div class="page-card" style="max-width: 800px; margin: 0 auto;">
    <div class="page-card-header">
        <h2 class="page-card-title">Catat Barang Masuk</h2>
    </div>
    <div class="page-card-body">
        <form method="POST" action="{{ route('persediaan.masuk.store') }}" style="padding: 1.5rem;">
            @csrf
            
            <div class="form-group" style="margin-bottom: 1.5rem;">
                <label class="form-label" for="id_barang">Pilih Barang</label>
                <select id="id_barang" name="id_barang" class="form-select" required style="padding: 0.8rem; font-size: 1rem;">
                    <option value="">-- Pilih Barang --</option>
                    @foreach($barangs as $barang)
                        <option value="{{ $barang->id_barang }}" {{ old('id_barang') == $barang->id_barang ? 'selected' : '' }}>
                            {{ $barang->kode_barang }} - {{ $barang->nama_barang }} (Stok: {{ $barang->stok_saat_ini }})
                        </option>
                    @endforeach
                </select>
                @error('id_barang') <span class="form-error">{{ $message }}</span> @enderror
            </div>

            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.5rem; margin-bottom: 1.5rem;">
                <div class="form-group">
                    <label class="form-label" for="jumlah_barang">Jumlah Masuk</label>
                    <input type="number" id="jumlah_barang" name="jumlah_barang" class="form-input-plain" value="{{ old('jumlah_barang', 1) }}" min="1" required style="padding: 0.8rem; font-size: 1rem;">
                    @error('jumlah_barang') <span class="form-error">{{ $message }}</span> @enderror
                </div>
                
                <div class="form-group">
                    <label class="form-label" for="tgl_transaksi">Tanggal Transaksi</label>
                    <input type="date" id="tgl_transaksi" name="tgl_transaksi" class="form-input-plain" value="{{ old('tgl_transaksi', date('Y-m-d')) }}" required style="padding: 0.8rem; font-size: 1rem;">
                    @error('tgl_transaksi') <span class="form-error">{{ $message }}</span> @enderror
                </div>
            </div>

            <div class="form-group" style="margin-bottom: 2rem;">
                <label class="form-label" for="keterangan">Keterangan (Opsional)</label>
                <textarea id="keterangan" name="keterangan" class="form-input-plain" rows="3" placeholder="Contoh: Pembelian dari Supplier A" style="padding: 0.8rem; font-size: 1rem; resize: vertical;">{{ old('keterangan') }}</textarea>
                @error('keterangan') <span class="form-error">{{ $message }}</span> @enderror
            </div>

            <div style="display: flex; gap: 1rem; justify-content: flex-end;">
                <a href="{{ route('persediaan.stok') }}" class="btn btn-secondary" style="padding: 0.8rem 1.5rem;">Batal</a>
                <button type="submit" class="btn btn-primary" style="padding: 0.8rem 2rem; background: var(--success); box-shadow: 0 4px 12px rgba(16, 185, 129, 0.2);">Simpan Transaksi</button>
            </div>
        </form>
    </div>
</div>
@endsection

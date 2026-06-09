@extends('layouts.app')

@section('title', 'Form Barang Keluar')
@section('page-title', 'Form Barang Keluar')
@section('breadcrumb', 'Persediaan Barang / Barang Keluar')

@section('content')
<div class="page-card" style="max-width: 800px; margin: 0 auto;">
    <div class="page-card-header">
        <h2 class="page-card-title">Catat Barang Keluar</h2>
    </div>
    <div class="page-card-body">
        
        @if($errors->has('jumlah_barang'))
            <div style="background: #fee2e2; border-left: 4px solid var(--danger); padding: 1rem; border-radius: 8px; margin-bottom: 1.5rem;">
                <p style="color: var(--danger); font-weight: 500; margin: 0;">Error Validasi Stok</p>
                <p style="color: var(--gray-700); font-size: 0.9rem; margin-top: 0.25rem;">{{ $errors->first('jumlah_barang') }}</p>
            </div>
        @endif

        <form method="POST" action="{{ route('persediaan.keluar.store') }}">
            @csrf
            
            <div class="form-group" style="margin-bottom: 1.5rem;">
                <label class="form-label" for="id_barang">Pilih Barang</label>
                <select id="id_barang" name="id_barang" class="form-select" required style="padding: 0.8rem; font-size: 1rem;" onchange="updateMaxStok(this)">
                    <option value="" data-stok="0">-- Pilih Barang --</option>
                    @foreach($barangs as $barang)
                        <option value="{{ $barang->id_barang }}" data-stok="{{ $barang->stok_saat_ini }}" {{ old('id_barang') == $barang->id_barang ? 'selected' : '' }}>
                            {{ $barang->kode_barang }} - {{ $barang->nama_barang }} (Stok Tersedia: {{ $barang->stok_saat_ini }})
                        </option>
                    @endforeach
                </select>
                @error('id_barang') <span class="form-error">{{ $message }}</span> @enderror
            </div>

            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.5rem; margin-bottom: 1.5rem;">
                <div class="form-group">
                    <label class="form-label" for="jumlah_barang">Jumlah Keluar</label>
                    <input type="number" id="jumlah_barang" name="jumlah_barang" class="form-input-plain" value="{{ old('jumlah_barang', 1) }}" min="1" required style="padding: 0.8rem; font-size: 1rem;">
                    <span id="stok-hint" style="font-size: 0.8rem; color: var(--gray-500); margin-top: 0.3rem; display: block;"></span>
                </div>
                
                <div class="form-group">
                    <label class="form-label" for="tgl_transaksi">Tanggal Transaksi</label>
                    <input type="date" id="tgl_transaksi" name="tgl_transaksi" class="form-input-plain" value="{{ old('tgl_transaksi', date('Y-m-d')) }}" required style="padding: 0.8rem; font-size: 1rem;">
                    @error('tgl_transaksi') <span class="form-error">{{ $message }}</span> @enderror
                </div>
            </div>

            <div class="form-group" style="margin-bottom: 2rem;">
                <label class="form-label" for="keterangan">Keterangan (Opsional)</label>
                <textarea id="keterangan" name="keterangan" class="form-input-plain" rows="3" placeholder="Contoh: Digunakan untuk project B" style="padding: 0.8rem; font-size: 1rem; resize: vertical;">{{ old('keterangan') }}</textarea>
                @error('keterangan') <span class="form-error">{{ $message }}</span> @enderror
            </div>

            <div style="display: flex; gap: 1rem; justify-content: flex-end;">
                <a href="{{ route('persediaan.stok') }}" class="btn btn-secondary" style="padding: 0.8rem 1.5rem;">Batal</a>
                <button type="submit" class="btn btn-primary" style="padding: 0.8rem 2rem; background: var(--danger); box-shadow: 0 4px 12px rgba(239, 68, 68, 0.2);">Simpan Transaksi</button>
            </div>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script>
    function updateMaxStok(select) {
        const option = select.options[select.selectedIndex];
        const maxStok = option.getAttribute('data-stok');
        const inputJumlah = document.getElementById('jumlah_barang');
        const hint = document.getElementById('stok-hint');
        
        if (maxStok > 0) {
            inputJumlah.max = maxStok;
            hint.textContent = `Maksimal: ${maxStok}`;
            if(parseInt(inputJumlah.value) > parseInt(maxStok)) {
                inputJumlah.value = maxStok;
            }
        } else {
            inputJumlah.removeAttribute('max');
            hint.textContent = '';
        }
    }
    
    // Initialize on load if old value exists
    document.addEventListener('DOMContentLoaded', function() {
        const select = document.getElementById('id_barang');
        if (select.value) updateMaxStok(select);
    });
</script>
@endpush

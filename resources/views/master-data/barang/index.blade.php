@extends('layouts.app')

@section('title', 'Daftar Barang')
@section('page-title', 'Daftar Barang')
@section('breadcrumb', 'Master Data / Daftar Barang')

@section('content')
<div class="page-card">
    <div class="page-card-header">
        <h2 class="page-card-title">Daftar Barang</h2>
        <button class="btn btn-primary" onclick="openModal('add')" id="btn-tambah-barang">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                <line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/>
            </svg>
            Tambah Barang
        </button>
    </div>
    <div class="page-card-body">
        @if($barangs->count() > 0)
        <div class="table-responsive">
            <table class="data-table">
                <thead>
                    <tr>
                        <th>Kode</th>
                        <th>Nama Barang</th>
                        <th>Kategori</th>
                        <th>Stok</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($barangs as $barang)
                    <tr id="barang-{{ $barang->id_barang }}">
                        <td><span class="code-badge">{{ $barang->kode_barang }}</span></td>
                        <td style="font-weight: 500;">{{ $barang->nama_barang }}</td>
                        <td>{{ $barang->kategori->nama_kategori ?? '-' }}</td>
                        <td>
                            <span class="stock-badge {{ $barang->stok_saat_ini < 10 ? 'stock-low' : 'stock-high' }}">
                                {{ number_format($barang->stok_saat_ini) }}
                            </span>
                        </td>
                        <td>
                            <span class="status-badge {{ $barang->status_barang === 'Tersedia' ? 'status-available' : 'status-unavailable' }}">
                                {{ $barang->status_barang }}
                            </span>
                        </td>
                        <td>
                            <div class="action-btns">
                                <button class="btn btn-icon btn-icon-info" onclick="showDetail({{ $barang->id_barang }})" title="Detail">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                        <path d="M2.062 12.348a1 1 0 0 1 0-.696 10.75 10.75 0 0 1 19.876 0 1 1 0 0 1 0 .696 10.75 10.75 0 0 1-19.876 0"/>
                                        <circle cx="12" cy="12" r="3"/>
                                    </svg>
                                </button>
                                <button class="btn btn-icon btn-icon-edit" onclick="openEditModal({{ $barang->id_barang }})" title="Edit">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                        <path d="M21.174 6.812a1 1 0 0 0-3.986-3.987L3.842 16.174a2 2 0 0 0-.5.83l-1.321 4.352a.5.5 0 0 0 .623.622l4.353-1.32a2 2 0 0 0 .83-.497z"/>
                                    </svg>
                                </button>
                                <button type="button" class="btn btn-icon btn-icon-delete" title="Hapus" onclick="openDeleteModal('{{ route('barang.destroy', $barang->id_barang) }}')">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                        <path d="M3 6h18"/><path d="M19 6v14c0 1-1 2-2 2H7c-1 0-2-1-2-2V6"/>
                                        <path d="M8 6V4c0-1 1-2 2-2h4c1 0 2 1 2 2v2"/>
                                    </svg>
                                </button>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @else
        <div class="empty-state">
            <svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path d="m7.5 4.27 9 5.15"/><path d="M21 8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16Z"/><path d="m3.3 7 8.7 5 8.7-5"/><path d="M12 22V12"/></svg>
            <p>Belum ada barang</p>
            <span>Klik tombol "Tambah Barang" untuk mulai menambahkan</span>
        </div>
        @endif
    </div>
</div>

{{-- Modal Tambah/Edit Barang --}}
<div class="modal-overlay" id="modal-barang">
    <div class="modal-card">
        <div class="modal-header">
            <h3 class="modal-title" id="modal-title">Tambah Barang</h3>
            <button class="modal-close" onclick="closeModal()">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
            </button>
        </div>
        <form id="form-barang" method="POST" action="{{ route('barang.store') }}">
            @csrf
            <div id="method-field"></div>
            <div class="modal-body">
                <div class="form-group">
                    <label class="form-label" for="kode_barang">Kode Barang</label>
                    <input type="text" id="kode_barang" name="kode_barang" class="form-input-plain" placeholder="Contoh: BRG-001" required>
                </div>
                <div class="form-group">
                    <label class="form-label" for="nama_barang">Nama Barang</label>
                    <input type="text" id="nama_barang" name="nama_barang" class="form-input-plain" placeholder="Masukkan nama barang" required>
                </div>
                <div class="form-group">
                    <label class="form-label" for="id_kategori">Kategori</label>
                    <select id="id_kategori" name="id_kategori" class="form-select" required>
                        <option value="">Pilih Kategori</option>
                        @foreach($kategoris as $kat)
                            <option value="{{ $kat->id_kategori }}">{{ $kat->nama_kategori }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label class="form-label" for="stok_saat_ini">Stok Awal</label>
                    <input type="number" id="stok_saat_ini" name="stok_saat_ini" class="form-input-plain" placeholder="0" min="0" value="0" required>
                </div>
                <div class="form-group">
                    <label class="form-label" for="status_barang">Status</label>
                    <select id="status_barang" name="status_barang" class="form-select" required>
                        <option value="Tersedia">Tersedia</option>
                        <option value="Tidak Tersedia">Tidak Tersedia</option>
                    </select>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" onclick="closeModal()">Batal</button>
                <button type="submit" class="btn btn-primary">Simpan</button>
            </div>
        </form>
    </div>
</div>

{{-- Modal Detail --}}
<div class="modal-overlay" id="modal-detail">
    <div class="modal-card">
        <div class="modal-header">
            <h3 class="modal-title">Detail Barang</h3>
            <button class="modal-close" onclick="closeDetailModal()">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
            </button>
        </div>
        <div class="modal-body">
            <div class="form-group"><label class="form-label">Kode Barang</label><p id="detail-kode" style="color:var(--gray-700);font-size:0.9rem;">-</p></div>
            <div class="form-group"><label class="form-label">Nama Barang</label><p id="detail-nama" style="color:var(--gray-700);font-size:0.9rem;">-</p></div>
            <div class="form-group"><label class="form-label">Kategori</label><p id="detail-kategori" style="color:var(--gray-700);font-size:0.9rem;">-</p></div>
            <div class="form-group"><label class="form-label">Stok Saat Ini</label><p id="detail-stok" style="color:var(--gray-700);font-size:0.9rem;">-</p></div>
            <div class="form-group"><label class="form-label">Status</label><p id="detail-status" style="color:var(--gray-700);font-size:0.9rem;">-</p></div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" onclick="closeDetailModal()">Tutup</button>
        </div>
    </div>
</div>

{{-- Modal Konfirmasi Hapus --}}
<div class="modal-overlay" id="modal-delete">
    <div class="modal-card" style="max-width: 400px;">
        <div class="modal-header">
            <h3 class="modal-title">Konfirmasi Hapus</h3>
            <button type="button" class="modal-close" onclick="closeDeleteModal()">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
            </button>
        </div>
        <div class="modal-body">
            <p style="color: var(--gray-700); font-size: 0.95rem;">Apakah Anda yakin ingin menghapus data ini? Tindakan ini tidak dapat dibatalkan.</p>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" onclick="closeDeleteModal()">Batal</button>
            <form id="delete-form-action" method="POST" action="">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-primary" style="background-color: var(--red-600); border-color: var(--red-600);">Ya, Hapus</button>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    function openModal(mode) {
        const modal = document.getElementById('modal-barang');
        const title = document.getElementById('modal-title');
        const form = document.getElementById('form-barang');
        const methodField = document.getElementById('method-field');

        title.textContent = 'Tambah Barang';
        form.action = '{{ route("barang.store") }}';
        methodField.innerHTML = '';
        form.reset();
        document.getElementById('stok_saat_ini').value = '0';

        modal.classList.add('show');
    }

    function openEditModal(id) {
        fetch('/barang/' + id)
            .then(r => r.json())
            .then(data => {
                const modal = document.getElementById('modal-barang');
                const title = document.getElementById('modal-title');
                const form = document.getElementById('form-barang');
                const methodField = document.getElementById('method-field');

                title.textContent = 'Edit Barang';
                form.action = '/barang/' + id;
                methodField.innerHTML = '<input type="hidden" name="_method" value="PUT">';

                document.getElementById('kode_barang').value = data.kode_barang;
                document.getElementById('nama_barang').value = data.nama_barang;
                document.getElementById('id_kategori').value = data.id_kategori;
                document.getElementById('stok_saat_ini').value = data.stok_saat_ini;
                document.getElementById('status_barang').value = data.status_barang;

                modal.classList.add('show');
            });
    }

    function closeModal() {
        document.getElementById('modal-barang').classList.remove('show');
    }

    function showDetail(id) {
        fetch('/barang/' + id)
            .then(r => r.json())
            .then(data => {
                document.getElementById('detail-kode').textContent = data.kode_barang;
                document.getElementById('detail-nama').textContent = data.nama_barang;
                document.getElementById('detail-kategori').textContent = data.kategori ? data.kategori.nama_kategori : '-';
                document.getElementById('detail-stok').textContent = data.stok_saat_ini;
                document.getElementById('detail-status').textContent = data.status_barang;
                document.getElementById('modal-detail').classList.add('show');
            });
    }

    function closeDetailModal() {
        document.getElementById('modal-detail').classList.remove('show');
    }

    // Auto-dismiss toasts
    document.querySelectorAll('.toast').forEach(t => {
        setTimeout(() => t.style.display = 'none', 4000);
    });

    function openDeleteModal(url) {
        document.getElementById('delete-form-action').action = url;
        document.getElementById('modal-delete').classList.add('show');
    }

    function closeDeleteModal() {
        document.getElementById('modal-delete').classList.remove('show');
    }

    @if($errors->any())
        openModal('add');
    @endif
</script>
@endpush

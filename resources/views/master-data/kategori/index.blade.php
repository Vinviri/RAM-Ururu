@extends('layouts.app')

@section('title', 'Kategori Barang')
@section('page-title', 'Kategori Barang')
@section('breadcrumb', 'Master Data / Kategori Barang')

@section('content')
<div class="page-card">
    <div class="page-card-header">
        <h2 class="page-card-title">Daftar Kategori</h2>
        <button class="btn btn-primary" onclick="openModal('add')" id="btn-tambah-kategori">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                <line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/>
            </svg>
            Tambah Kategori
        </button>
    </div>
    <div class="page-card-body">
        @if($kategoris->count() > 0)
        <div class="kategori-list">
            @foreach($kategoris as $index => $kategori)
            <div class="kategori-item" id="kategori-{{ $kategori->id_kategori }}">
                <div class="kategori-avatar kategori-avatar-{{ ($index % 6) + 1 }}">
                    {{ strtoupper(substr($kategori->nama_kategori, 0, 1)) }}
                </div>
                <div class="kategori-info">
                    <div class="kategori-name">{{ $kategori->nama_kategori }}</div>
                    <div class="kategori-count">{{ $kategori->barang_count }} barang</div>
                </div>
                <div class="kategori-actions">
                    <button class="btn btn-icon btn-icon-info" onclick="showDetail({{ $kategori->id_kategori }})" title="Detail">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M2.062 12.348a1 1 0 0 1 0-.696 10.75 10.75 0 0 1 19.876 0 1 1 0 0 1 0 .696 10.75 10.75 0 0 1-19.876 0"/>
                            <circle cx="12" cy="12" r="3"/>
                        </svg>
                    </button>
                    <button class="btn btn-icon btn-icon-edit" onclick="openModal('edit', {{ $kategori->id_kategori }}, '{{ addslashes($kategori->nama_kategori) }}')" title="Edit">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M21.174 6.812a1 1 0 0 0-3.986-3.987L3.842 16.174a2 2 0 0 0-.5.83l-1.321 4.352a.5.5 0 0 0 .623.622l4.353-1.32a2 2 0 0 0 .83-.497z"/>
                        </svg>
                    </button>
                    <button type="button" class="btn btn-icon btn-icon-delete" title="Hapus" onclick="openDeleteModal('{{ route('kategori.destroy', $kategori->id_kategori) }}')">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M3 6h18"/><path d="M19 6v14c0 1-1 2-2 2H7c-1 0-2-1-2-2V6"/>
                            <path d="M8 6V4c0-1 1-2 2-2h4c1 0 2 1 2 2v2"/>
                        </svg>
                    </button>
                </div>
            </div>
            @endforeach
        </div>
        @else
        <div class="empty-state">
            <svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
                <path d="M22 19a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h5l2 3h9a2 2 0 0 1 2 2z"/>
            </svg>
            <p>Belum ada kategori</p>
            <span>Klik tombol "Tambah Kategori" untuk mulai menambahkan</span>
        </div>
        @endif
    </div>
</div>

{{-- Modal Tambah/Edit Kategori --}}
<div class="modal-overlay" id="modal-kategori">
    <div class="modal-card">
        <div class="modal-header">
            <h3 class="modal-title" id="modal-title">Tambah Kategori</h3>
            <button class="modal-close" onclick="closeModal()">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/>
                </svg>
            </button>
        </div>
        <form id="form-kategori" method="POST" action="{{ route('kategori.store') }}">
            @csrf
            <div id="method-field"></div>
            <div class="modal-body">
                <div class="form-group">
                    <label class="form-label" for="nama_kategori">Nama Kategori</label>
                    <input type="text" id="nama_kategori" name="nama_kategori" class="form-input-plain" placeholder="Masukkan nama kategori" required>
                    @if($errors->has('nama_kategori'))
                        <span class="form-error">{{ $errors->first('nama_kategori') }}</span>
                    @endif
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" onclick="closeModal()">Batal</button>
                <button type="submit" class="btn btn-primary" id="btn-submit">Simpan</button>
            </div>
        </form>
    </div>
</div>

{{-- Modal Detail Kategori --}}
<div class="modal-overlay" id="modal-detail">
    <div class="modal-card">
        <div class="modal-header">
            <h3 class="modal-title">Detail Kategori</h3>
            <button class="modal-close" onclick="closeDetailModal()">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/>
                </svg>
            </button>
        </div>
        <div class="modal-body">
            <div class="form-group">
                <label class="form-label">ID Kategori</label>
                <p id="detail-id" style="color: var(--gray-700); font-size: 0.9rem;">-</p>
            </div>
            <div class="form-group">
                <label class="form-label">Nama Kategori</label>
                <p id="detail-nama" style="color: var(--gray-700); font-size: 0.9rem;">-</p>
            </div>
            <div class="form-group">
                <label class="form-label">Jumlah Barang</label>
                <p id="detail-count" style="color: var(--gray-700); font-size: 0.9rem;">-</p>
            </div>
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
    function openModal(mode, id = null, nama = '') {
        const modal = document.getElementById('modal-kategori');
        const title = document.getElementById('modal-title');
        const form = document.getElementById('form-kategori');
        const input = document.getElementById('nama_kategori');
        const methodField = document.getElementById('method-field');

        if (mode === 'edit') {
            title.textContent = 'Edit Kategori';
            form.action = '/kategori/' + id;
            methodField.innerHTML = '<input type="hidden" name="_method" value="PUT">';
            input.value = nama;
        } else {
            title.textContent = 'Tambah Kategori';
            form.action = '{{ route("kategori.store") }}';
            methodField.innerHTML = '';
            input.value = '';
        }

        modal.classList.add('show');
        setTimeout(() => input.focus(), 100);
    }

    function closeModal() {
        document.getElementById('modal-kategori').classList.remove('show');
    }

    function showDetail(id) {
        fetch('/kategori/' + id)
            .then(r => r.json())
            .then(data => {
                document.getElementById('detail-id').textContent = data.id_kategori;
                document.getElementById('detail-nama').textContent = data.nama_kategori;
                document.getElementById('detail-count').textContent = (data.barang_count || 0) + ' barang';
                document.getElementById('modal-detail').classList.add('show');
            });
    }

    function closeDetailModal() {
        document.getElementById('modal-detail').classList.remove('show');
    }

    // Show modal if there are validation errors
    @if($errors->any())
        openModal('add');
    @endif

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
</script>
@endpush

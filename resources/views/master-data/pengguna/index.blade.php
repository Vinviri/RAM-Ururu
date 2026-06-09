@extends('layouts.app')

@section('title', 'Manajemen Pengguna')
@section('page-title', 'Manajemen Pengguna')
@section('breadcrumb', 'Master Data / Manajemen Pengguna')

@section('content')
<div class="page-card">
    <div class="page-card-header">
        <h2 class="page-card-title">Daftar Pengguna</h2>
        <button class="btn btn-primary" onclick="openModal('add')" id="btn-tambah-pengguna">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                <line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/>
            </svg>
            Tambah Pengguna
        </button>
    </div>
    <div class="page-card-body">
        @if($penggunas->count() > 0)
        <div class="table-responsive">
            <table class="data-table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nama Admin</th>
                        <th>Email</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($penggunas as $user)
                    <tr id="pengguna-{{ $user->id_user }}">
                        <td>{{ $user->id_user }}</td>
                        <td style="font-weight: 500;">{{ $user->nama_admin }}</td>
                        <td>{{ $user->email }}</td>
                        <td>
                            <div class="action-btns">
                                <button class="btn btn-icon btn-icon-info" onclick="showDetail({{ $user->id_user }})" title="Detail">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                        <path d="M2.062 12.348a1 1 0 0 1 0-.696 10.75 10.75 0 0 1 19.876 0 1 1 0 0 1 0 .696 10.75 10.75 0 0 1-19.876 0"/>
                                        <circle cx="12" cy="12" r="3"/>
                                    </svg>
                                </button>
                                <button class="btn btn-icon btn-icon-edit" onclick="openEditModal({{ $user->id_user }}, '{{ addslashes($user->nama_admin) }}', '{{ $user->email }}')" title="Edit">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                        <path d="M21.174 6.812a1 1 0 0 0-3.986-3.987L3.842 16.174a2 2 0 0 0-.5.83l-1.321 4.352a.5.5 0 0 0 .623.622l4.353-1.32a2 2 0 0 0 .83-.497z"/>
                                    </svg>
                                </button>
                                @if($user->id_user !== Auth::id())
                                <button type="button" class="btn btn-icon btn-icon-delete" title="Hapus" onclick="openDeleteModal('{{ route('pengguna.destroy', $user->id_user) }}')">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                        <path d="M3 6h18"/><path d="M19 6v14c0 1-1 2-2 2H7c-1 0-2-1-2-2V6"/>
                                        <path d="M8 6V4c0-1 1-2 2-2h4c1 0 2 1 2 2v2"/>
                                    </svg>
                                </button>
                                @endif
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @else
        <div class="empty-state">
            <svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                <path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/>
                <line x1="19" x2="19" y1="8" y2="14"/><line x1="22" x2="16" y1="11" y2="11"/>
            </svg>
            <p>Belum ada pengguna</p>
            <span>Klik tombol "Tambah Pengguna" untuk menambahkan admin baru</span>
        </div>
        @endif
    </div>
</div>

{{-- Modal Tambah/Edit Pengguna --}}
<div class="modal-overlay" id="modal-pengguna">
    <div class="modal-card">
        <div class="modal-header">
            <h3 class="modal-title" id="modal-title">Tambah Pengguna</h3>
            <button class="modal-close" onclick="closeModal()">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
            </button>
        </div>
        <form id="form-pengguna" method="POST" action="{{ route('pengguna.store') }}">
            @csrf
            <div id="method-field"></div>
            <div class="modal-body">
                <div class="form-group">
                    <label class="form-label" for="nama_admin">Nama Admin</label>
                    <input type="text" id="nama_admin" name="nama_admin" class="form-input-plain" placeholder="Masukkan nama admin" required>
                </div>
                <div class="form-group">
                    <label class="form-label" for="email">Email</label>
                    <input type="email" id="email" name="email" class="form-input-plain" placeholder="Masukkan email" required>
                </div>
                <div class="form-group">
                    <label class="form-label" for="password">Password <span id="password-hint" style="font-weight:400;color:var(--gray-400);"></span></label>
                    <input type="password" id="password" name="password" class="form-input-plain" placeholder="Masukkan password" minlength="6">
                </div>
                <div class="form-group">
                    <label class="form-label" for="password_confirmation">Konfirmasi Password</label>
                    <input type="password" id="password_confirmation" name="password_confirmation" class="form-input-plain" placeholder="Ulangi password">
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
            <h3 class="modal-title">Detail Pengguna</h3>
            <button class="modal-close" onclick="closeDetailModal()">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
            </button>
        </div>
        <div class="modal-body">
            <div class="form-group"><label class="form-label">ID</label><p id="detail-id" style="color:var(--gray-700);font-size:0.9rem;">-</p></div>
            <div class="form-group"><label class="form-label">Nama Admin</label><p id="detail-nama" style="color:var(--gray-700);font-size:0.9rem;">-</p></div>
            <div class="form-group"><label class="form-label">Email</label><p id="detail-email" style="color:var(--gray-700);font-size:0.9rem;">-</p></div>
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
    let isEditMode = false;

    function openModal(mode) {
        const modal = document.getElementById('modal-pengguna');
        const title = document.getElementById('modal-title');
        const form = document.getElementById('form-pengguna');
        const methodField = document.getElementById('method-field');
        const passHint = document.getElementById('password-hint');
        const passInput = document.getElementById('password');

        isEditMode = false;
        title.textContent = 'Tambah Pengguna';
        form.action = '{{ route("pengguna.store") }}';
        methodField.innerHTML = '';
        passHint.textContent = '';
        passInput.required = true;
        form.reset();

        modal.classList.add('show');
    }

    function openEditModal(id, nama, email) {
        const modal = document.getElementById('modal-pengguna');
        const title = document.getElementById('modal-title');
        const form = document.getElementById('form-pengguna');
        const methodField = document.getElementById('method-field');
        const passHint = document.getElementById('password-hint');
        const passInput = document.getElementById('password');

        isEditMode = true;
        title.textContent = 'Edit Pengguna';
        form.action = '/pengguna/' + id;
        methodField.innerHTML = '<input type="hidden" name="_method" value="PUT">';
        passHint.textContent = '(kosongkan jika tidak diubah)';
        passInput.required = false;

        document.getElementById('nama_admin').value = nama;
        document.getElementById('email').value = email;
        document.getElementById('password').value = '';
        document.getElementById('password_confirmation').value = '';

        modal.classList.add('show');
    }

    function closeModal() {
        document.getElementById('modal-pengguna').classList.remove('show');
    }

    function showDetail(id) {
        fetch('/pengguna/' + id)
            .then(r => r.json())
            .then(data => {
                document.getElementById('detail-id').textContent = data.id_user;
                document.getElementById('detail-nama').textContent = data.nama_admin;
                document.getElementById('detail-email').textContent = data.email;
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
</script>
@endpush

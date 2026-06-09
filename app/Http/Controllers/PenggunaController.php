<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class PenggunaController extends Controller
{
    public function index()
    {
        $penggunas = User::orderBy('id_user', 'desc')->get();
        return view('master-data.pengguna.index', compact('penggunas'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_admin' => 'required|string|max:100',
            'email' => 'required|email|max:100|unique:users,email',
            'password' => 'required|string|min:6|confirmed',
        ], [
            'nama_admin.required' => 'Nama admin wajib diisi.',
            'email.required' => 'Email wajib diisi.',
            'email.email' => 'Format email tidak valid.',
            'email.unique' => 'Email sudah terdaftar.',
            'password.required' => 'Password wajib diisi.',
            'password.min' => 'Password minimal 6 karakter.',
            'password.confirmed' => 'Konfirmasi password tidak cocok.',
        ]);

        User::create([
            'nama_admin' => $request->nama_admin,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        return redirect()->route('pengguna.index')->with('success', 'Pengguna berhasil ditambahkan.');
    }

    public function show(User $pengguna)
    {
        return response()->json($pengguna);
    }

    public function update(Request $request, User $pengguna)
    {
        $request->validate([
            'nama_admin' => 'required|string|max:100',
            'email' => 'required|email|max:100|unique:users,email,' . $pengguna->id_user . ',id_user',
            'password' => 'nullable|string|min:6|confirmed',
        ], [
            'nama_admin.required' => 'Nama admin wajib diisi.',
            'email.required' => 'Email wajib diisi.',
            'email.unique' => 'Email sudah terdaftar.',
            'password.min' => 'Password minimal 6 karakter.',
            'password.confirmed' => 'Konfirmasi password tidak cocok.',
        ]);

        $data = [
            'nama_admin' => $request->nama_admin,
            'email' => $request->email,
        ];

        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        $pengguna->update($data);

        return redirect()->route('pengguna.index')->with('success', 'Pengguna berhasil diperbarui.');
    }

    public function destroy(User $pengguna)
    {
        if ($pengguna->id_user === Auth::id()) {
            return redirect()->route('pengguna.index')->with('error', 'Anda tidak dapat menghapus akun sendiri.');
        }

        try {
            $pengguna->delete();
            return redirect()->route('pengguna.index')->with('success', 'Pengguna berhasil dihapus.');
        } catch (\Exception $e) {
            return redirect()->route('pengguna.index')->with('error', 'Pengguna tidak dapat dihapus karena memiliki riwayat transaksi.');
        }
    }
}

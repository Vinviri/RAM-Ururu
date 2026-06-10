<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\Kategori;
use Illuminate\Http\Request;

class BarangController extends Controller
{
    public function index()
    {
        $barangs = Barang::with('kategori')->orderBy('id_barang', 'desc')->get();
        $kategoris = Kategori::orderBy('nama_kategori')->get();
        return view('master-data.barang.index', compact('barangs', 'kategoris'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'id_kategori' => 'required|exists:kategori,id_kategori',
            'kode_barang' => 'required|string|max:20|unique:barang,kode_barang',
            'nama_barang' => 'required|string|max:150',
            'stok_saat_ini' => 'required|integer|min:0',
        ], [
            'id_kategori.required' => 'Kategori wajib dipilih.',
            'id_kategori.exists' => 'Kategori tidak valid.',
            'kode_barang.required' => 'Kode barang wajib diisi.',
            'kode_barang.unique' => 'Kode barang sudah digunakan.',
            'kode_barang.max' => 'Kode barang maksimal 20 karakter.',
            'nama_barang.required' => 'Nama barang wajib diisi.',
            'stok_saat_ini.required' => 'Stok wajib diisi.',
            'stok_saat_ini.min' => 'Stok tidak boleh negatif.',
            'status_barang.required' => 'Status wajib dipilih.',
        ]);

        $data = $request->only(['id_kategori', 'kode_barang', 'nama_barang', 'stok_saat_ini']);

        Barang::create($data);

        return redirect()->route('barang.index')->with('success', 'Barang berhasil ditambahkan.');
    }

    public function show(Barang $barang)
    {
        $barang->load('kategori');
        return response()->json($barang);
    }

    public function update(Request $request, Barang $barang)
    {
        $request->validate([
            'id_kategori' => 'required|exists:kategori,id_kategori',
            'kode_barang' => 'required|string|max:20|unique:barang,kode_barang,' . $barang->id_barang . ',id_barang',
            'nama_barang' => 'required|string|max:150',
            'stok_saat_ini' => 'required|integer|min:0',
        ], [
            'kode_barang.unique' => 'Kode barang sudah digunakan.',
        ]);

        $data = $request->only(['id_kategori', 'kode_barang', 'nama_barang', 'stok_saat_ini']);

        $barang->update($data);

        return redirect()->route('barang.index')->with('success', 'Barang berhasil diperbarui.');
    }

    public function destroy(Barang $barang)
    {
        // DB schema uses ON DELETE CASCADE for transaksi.id_barang, 
        // so we can safely delete the barang and its transactions will be removed.
        $barang->delete();

        return redirect()->route('barang.index')->with('success', 'Barang berhasil dihapus.');
    }
}

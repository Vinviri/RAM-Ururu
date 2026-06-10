<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\Transaksi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PersediaanController extends Controller
{
    /**
     * Tampilkan Data Stok Barang
     */
    public function indexStok(Request $request)
    {
        $query = Barang::with('kategori')->orderBy('id_barang', 'desc');

        if ($request->has('search') && $request->search != '') {
            $query->where('nama_barang', 'like', '%' . $request->search . '%')
                  ->orWhere('kode_barang', 'like', '%' . $request->search . '%');
        }

        $barangs = $query->get();
        return view('persediaan.stok', compact('barangs'));
    }

    /**
     * API Detail Barang + Riwayat untuk panel kanan
     */
    public function getDetailBarang(Barang $barang)
    {
        $barang->load('kategori');
        $riwayat = $barang->transaksi()
                          ->with('user')
                          ->orderBy('tgl_transaksi', 'desc')
                          ->orderBy('id_transaksi', 'desc')
                          ->limit(5)
                          ->get();

        return response()->json([
            'barang' => $barang,
            'riwayat' => $riwayat
        ]);
    }

    /**
     * Form Barang Masuk
     */
    public function createMasuk()
    {
        $barangs = Barang::orderBy('nama_barang', 'asc')->get();
        return view('persediaan.masuk', compact('barangs'));
    }

    /**
     * Proses Simpan Barang Masuk
     */
    public function storeMasuk(Request $request)
    {
        $request->validate([
            'id_barang' => 'required|exists:barang,id_barang',
            'jumlah_barang' => 'required|integer|min:1',
            'tgl_transaksi' => 'required|date',
            'keterangan' => 'nullable|string|max:255',
        ], [
            'id_barang.required' => 'Silakan pilih barang.',
            'jumlah_barang.min' => 'Jumlah barang masuk minimal 1.',
            'tgl_transaksi.required' => 'Tanggal transaksi wajib diisi.',
        ]);

        try {
            DB::beginTransaction();

            $barang = Barang::findOrFail($request->id_barang);

            // Insert Transaksi
            Transaksi::create([
                'id_barang' => $barang->id_barang,
                'id_user' => Auth::id(),
                'jenis_transaksi' => 'Masuk',
                'tgl_transaksi' => $request->tgl_transaksi,
                'jumlah_barang' => $request->jumlah_barang,
                'keterangan' => $request->keterangan,
            ]);

            // Update Stok Barang
            $barang->stok_saat_ini += $request->jumlah_barang;
            

            $barang->save();

            DB::commit();

            return redirect()->route('persediaan.stok')->with('success', 'Transaksi Barang Masuk berhasil dicatat.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Terjadi kesalahan sistem: ' . $e->getMessage())->withInput();
        }
    }

    /**
     * Form Barang Keluar
     */
    public function createKeluar()
    {
        // Hanya tampilkan barang yang stoknya lebih dari 0
        $barangs = Barang::where('stok_saat_ini', '>', 0)->orderBy('nama_barang', 'asc')->get();
        return view('persediaan.keluar', compact('barangs'));
    }

    /**
     * Proses Simpan Barang Keluar
     */
    public function storeKeluar(Request $request)
    {
        $request->validate([
            'id_barang' => 'required|exists:barang,id_barang',
            'jumlah_barang' => 'required|integer|min:1',
            'tgl_transaksi' => 'required|date',
            'keterangan' => 'nullable|string|max:255',
        ], [
            'id_barang.required' => 'Silakan pilih barang.',
            'jumlah_barang.min' => 'Jumlah barang keluar minimal 1.',
            'tgl_transaksi.required' => 'Tanggal transaksi wajib diisi.',
        ]);

        try {
            DB::beginTransaction();

            $barang = Barang::findOrFail($request->id_barang);

            // Validasi Stok
            if ($request->jumlah_barang > $barang->stok_saat_ini) {
                DB::rollBack();
                return back()->withErrors(['jumlah_barang' => 'Jumlah barang keluar melebihi stok saat ini (' . $barang->stok_saat_ini . ').'])->withInput();
            }

            // Insert Transaksi
            Transaksi::create([
                'id_barang' => $barang->id_barang,
                'id_user' => Auth::id(),
                'jenis_transaksi' => 'Keluar',
                'tgl_transaksi' => $request->tgl_transaksi,
                'jumlah_barang' => $request->jumlah_barang,
                'keterangan' => $request->keterangan,
            ]);

            // Update Stok Barang
            $barang->stok_saat_ini -= $request->jumlah_barang;
            
            $barang->save();

            DB::commit();

            return redirect()->route('persediaan.stok')->with('success', 'Transaksi Barang Keluar berhasil dicatat.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Terjadi kesalahan sistem: ' . $e->getMessage())->withInput();
        }
    }
}

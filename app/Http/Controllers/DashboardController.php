<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\Transaksi;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    /**
     * Menampilkan halaman dashboard dengan statistik
     */
    public function index()
    {
        // Total keseluruhan barang (jumlah item unik)
        $totalBarang = Barang::count();

        // Total stok masuk (sum jumlah where jenis = Masuk)
        $totalStokMasuk = Transaksi::where('jenis_transaksi', 'Masuk')->sum('jumlah_barang');

        // Total stok keluar (sum jumlah where jenis = Keluar)
        $totalStokKeluar = Transaksi::where('jenis_transaksi', 'Keluar')->sum('jumlah_barang');

        // Barang dengan stok terendah (< 10), ambil 5 teratas
        $stokRendah = Barang::where('stok_saat_ini', '<', 10)->count();
        $barangTerendah = Barang::orderBy('stok_saat_ini', 'asc')->limit(5)->get();

        // Barang dengan stok tertinggi, ambil 5 teratas
        $barangTertinggi = Barang::orderBy('stok_saat_ini', 'desc')->limit(5)->get();
        
        // Transaksi terbaru (5 terakhir)
        $transaksiTerbaru = Transaksi::with(['barang', 'user'])
                            ->orderBy('tgl_transaksi', 'desc')
                            ->orderBy('id_transaksi', 'desc')
                            ->limit(5)
                            ->get();

        return view('dashboard.index', compact(
            'totalBarang', 
            'totalStokMasuk', 
            'totalStokKeluar', 
            'stokRendah',
            'barangTerendah',
            'barangTertinggi',
            'transaksiTerbaru'
        ));
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Transaksi;
use Illuminate\Http\Request;

class LaporanController extends Controller
{
    public function index(Request $request)
    {
        $query = Transaksi::with(['barang.kategori', 'user'])->orderBy('tgl_transaksi', 'desc')->orderBy('id_transaksi', 'desc');

        if ($request->has('start_date') && $request->start_date != '') {
            $query->whereDate('tgl_transaksi', '>=', $request->start_date);
        }

        if ($request->has('end_date') && $request->end_date != '') {
            $query->whereDate('tgl_transaksi', '<=', $request->end_date);
        }

        if ($request->has('jenis_transaksi') && $request->jenis_transaksi != '') {
            $query->where('jenis_transaksi', $request->jenis_transaksi);
        }

        $transaksis = $query->get();

        return view('laporan.index', compact('transaksis'));
    }

    public function exportPdf(Request $request)
    {
        $query = Transaksi::with(['barang.kategori', 'user'])->orderBy('tgl_transaksi', 'desc')->orderBy('id_transaksi', 'desc');

        if ($request->has('start_date') && $request->start_date != '') {
            $query->whereDate('tgl_transaksi', '>=', $request->start_date);
        }

        if ($request->has('end_date') && $request->end_date != '') {
            $query->whereDate('tgl_transaksi', '<=', $request->end_date);
        }

        if ($request->has('jenis_transaksi') && $request->jenis_transaksi != '') {
            $query->where('jenis_transaksi', $request->jenis_transaksi);
        }

        $transaksis = $query->get();

        // Pastikan Anda sudah menginstall package dompdf terlebih dahulu:
        // composer require barryvdh/laravel-dompdf
        $pdf = \PDF::loadView('laporan.pdf', compact('transaksis'));
        return $pdf->download('laporan-transaksi-' . date('Y-m-d') . '.pdf');
    }
}

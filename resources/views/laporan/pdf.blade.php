{{-- 
    Template ini digunakan untuk generate PDF laporan.
    Anda bisa mengaktifkannya nanti jika sudah menginstall dompdf
--}}

{{-- 
<!DOCTYPE html>
<html>
<head>
    <title>Laporan Transaksi</title>
    <style>
        body { font-family: sans-serif; font-size: 12px; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
        th { background-color: #f4f4f4; }
        h2 { text-align: center; }
    </style>
</head>
<body>
    <h2>Laporan Riwayat Transaksi Barang</h2>
    <p>Tanggal Cetak: {{ date('d M Y') }}</p>

    <table>
        <thead>
            <tr>
                <th>Tgl Transaksi</th>
                <th>Kode Barang</th>
                <th>Nama Barang</th>
                <th>Jenis</th>
                <th>Jumlah</th>
                <th>Keterangan</th>
                <th>Admin</th>
            </tr>
        </thead>
        <tbody>
            @foreach($transaksis as $t)
            <tr>
                <td>{{ date('d M Y', strtotime($t->tgl_transaksi)) }}</td>
                <td>{{ $t->barang->kode_barang ?? '-' }}</td>
                <td>{{ $t->barang->nama_barang ?? '-' }}</td>
                <td>{{ $t->jenis_transaksi }}</td>
                <td>{{ $t->jenis_transaksi == 'Masuk' ? '+' : '-' }}{{ number_format($t->jumlah_barang) }}</td>
                <td>{{ $t->keterangan ?? '-' }}</td>
                <td>{{ $t->user->nama_admin ?? '-' }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
--}}

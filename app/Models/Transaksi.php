<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transaksi extends Model
{
    protected $table = 'transaksi';
    protected $primaryKey = 'id_transaksi';

    protected $fillable = [
        'id_barang',
        'id_user',
        'jenis_transaksi',
        'jumlah_barang',
        'tgl_transaksi',
        'keterangan',
    ];

    protected function casts(): array
    {
        return [
            'tgl_transaksi' => 'date',
        ];
    }

    /**
     * Relasi: Transaksi milik satu Barang
     */
    public function barang()
    {
        return $this->belongsTo(Barang::class, 'id_barang', 'id_barang');
    }

    /**
     * Relasi: Transaksi dicatat oleh satu User
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'id_user', 'id_user');
    }
}

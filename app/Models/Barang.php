<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Barang extends Model
{
    protected $table = 'barang';
    protected $primaryKey = 'id_barang';

    protected $fillable = [
        'id_kategori',
        'kode_barang',
        'nama_barang',
        'stok_saat_ini',
        'status_barang',
    ];

    /**
     * Relasi: Barang milik satu Kategori
     */
    public function kategori()
    {
        return $this->belongsTo(Kategori::class, 'id_kategori', 'id_kategori');
    }

    /**
     * Relasi: Barang memiliki banyak transaksi
     */
    public function transaksi()
    {
        return $this->hasMany(Transaksi::class, 'id_barang', 'id_barang');
    }

    protected static function booted()
    {
        static::saving(function ($barang) {
            if ($barang->stok_saat_ini < 5) {
                $barang->status_barang = 'Tidak Tersedia';
            } elseif ($barang->stok_saat_ini == 5) {
                $barang->status_barang = 'Warning';
            } else {
                $barang->status_barang = 'Tersedia';
            }
        });
    }
}

<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Keranjang extends Model
{
    use HasFactory;
    protected $table = 'keranjang';
    protected $fillable = ['idbarang', 'idpeminjaman', 'jumlah_peminjaman'];

    public function barang()
    {
        return $this->belongsTo(Barang::class, 'idbarang');
    }
    public function peminjaman()
    {
        return $this->belongsTo(Peminjaman::class, 'idpeminjaman');
    }
}

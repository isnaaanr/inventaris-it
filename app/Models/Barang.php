<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Barang extends Model
{
    use HasFactory;
    protected $table = 'barang';
    protected $fillable = ['nama', 'stok', 'jenis'];

    public function kurangiStok($jumlah)
    {
        if ($this->stok >= $jumlah) {
            $this->stok -= $jumlah;
            $this->save();
            return true;
        }
        return false;
    }

    public function peminjaman()
    {
        return $this->belongsToMany(Peminjaman::class, 'keranjang', 'idbarang', 'idpeminjaman')
                    ->withPivot('jumlah_peminjaman')
                    ->withTimestamps();
    }

}

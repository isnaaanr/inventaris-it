<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Peminjaman extends Model
{
    use HasFactory;
    protected $table = 'peminjaman';

    protected $fillable = ['nama_peminjam', 'unit', 'keperluan', 'tempat', 'tanggal_peminjaman', 'tanggal_kembali'];

    
    public function keranjang()
    {
        return $this->hasMany(Keranjang::class, 'idpeminjaman');
    }
    
    public function barang()
    {
        return $this->belongsToMany(Barang::class, 'keranjang', 'idpeminjaman', 'idbarang')
                    ->withPivot('jumlah_peminjaman')
                    ->withTimestamps();
    }
}

<?php

use App\Http\Controllers\Barang\BarangController;
use App\Http\Controllers\KeranjangController;
use App\Http\Controllers\PeminjamanController;
use App\Models\Peminjaman;
use Mpdf\Tag\B;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

// Route yang membutuhkan login
Route::middleware(['auth'])->group(function () {

    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    // Route Profile
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Route Barang
    Route::get('/barang', [BarangController::class, 'index'])->name('barang');
    Route::delete('/barang/{id}', [BarangController::class, 'destroy'])->name('barang.delete');
    Route::put('/barang/{id}', [BarangController::class, 'update'])->name('barang.update');
    Route::post('/barang/add', [BarangController::class, 'store'])->name('barang.store');
    Route::get('/barang/search', [BarangController::class, 'search'])->name('barang.search');
    Route::get('/barang/autocomplete', [PeminjamanController::class, 'autocomplete'])->name('barang.autocomplete');

    // Route Peminjaman
    Route::get('/peminjaman', [PeminjamanController::class, 'index'])->name('peminjaman.index');
    Route::post('/peminjaman/add/{id}', [PeminjamanController::class, 'addPeminjaman'])->name('peminjaman.add');
    Route::post('/peminjaman/checkout', [PeminjamanController::class, 'checkout'])->name('peminjaman.checkout');
    Route::delete('/peminjaman/remove/{id}', [PeminjamanController::class, 'removeFromPeminjaman'])->name('peminjaman.remove');
    Route::post('/peminjaman/update/{id}', [PeminjamanController::class, 'updateJumlah']);
    Route::get('/peminjaman/search', [PeminjamanController::class, 'searchPeminjaman'])->name('peminjaman.search');

    // Route Riwayat
    Route::get('/riwayat', [PeminjamanController::class, 'riwayat'])->name('riwayat');
    Route::get('/riwayat/{id}/pengembalian', [PeminjamanController::class, 'pengembalian'])->name('riwayat.pengembalian');
    Route::delete('/riwayat/delete/{id}', [PeminjamanController::class, 'destroy'])->name('riwayat.delete');
    Route::get('/riwayat/search', [PeminjamanController::class, 'searchRiwayat'])->name('riwayat.search');
    Route::get('/peminjaman/cetak-pdf/{id}', [PeminjamanController::class, 'cetakPdf'])->name('riwayat.cetak-pdf');
});

// Route yang tidak membutuhkan login (seperti halaman depan dan login)
Route::get('/', function () {
    return view('welcome');
});
require __DIR__.'/auth.php';
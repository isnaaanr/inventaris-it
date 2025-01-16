<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('keranjang', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('idbarang');
            $table->unsignedBigInteger('idpeminjaman');

            $table->foreign('idbarang')->references('id')->on('barang')->onDelete('cascade');
            $table->foreign('idpeminjaman')->references('id')->on('peminjaman')->onDelete('cascade');

            $table->integer('jumlah_peminjaman');  
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('keranjang');
    }
};

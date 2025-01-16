<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BarangSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $barang = [
            ['nama' => 'Laptop Dell XPS', 'jenis' => 'Laptop', 'stok' => 10],
            ['nama' => 'Laptop HP Envy', 'jenis' => 'Laptop', 'stok' => 8],
            ['nama' => 'Kamera Canon EOS', 'jenis' => 'Kamera', 'stok' => 15],
            ['nama' => 'Kamera Nikon D3500', 'jenis' => 'Kamera', 'stok' => 5],
            ['nama' => 'Laptop Asus ZenBook', 'jenis' => 'Laptop', 'stok' => 7],
            ['nama' => 'Kamera Sony Alpha', 'jenis' => 'Kamera', 'stok' => 12],
            ['nama' => 'Kabel HDMI 2m', 'jenis' => 'Aksesoris', 'stok' => 20],
            ['nama' => 'Kabel Ethernet Cat6', 'jenis' => 'Aksesoris', 'stok' => 25],
            ['nama' => 'Wireless Mouse Logitech', 'jenis' => 'Aksesoris', 'stok' => 18],
            ['nama' => 'Keyboard Mechanical Razer', 'jenis' => 'Aksesoris', 'stok' => 10],
            ['nama' => 'Monitor LG UltraWide', 'jenis' => 'Monitor', 'stok' => 8],
            ['nama' => 'Proyektor Epson', 'jenis' => 'Proyektor', 'stok' => 5],
            ['nama' => 'Laptop Lenovo ThinkPad', 'jenis' => 'Laptop', 'stok' => 9],
            ['nama' => 'Kabel USB Type-C', 'jenis' => 'Aksesoris', 'stok' => 30],
            ['nama' => 'Power Bank Anker 20,000mAh', 'jenis' => 'Aksesoris', 'stok' => 15],
        ];

        DB::table('barang')->insert($barang);
    }
}
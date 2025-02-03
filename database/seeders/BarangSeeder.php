<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;

class BarangSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create('id_ID'); // Menggunakan locale Indonesia
        
        $jenisBarang = ['Laptop', 'Kamera', 'Aksesoris', 'Monitor', 'Proyektor'];
        
        $data = [];
        for ($i = 0; $i < 500; $i++) {
            $data[] = [
                'nama' => $faker->word . ' ' . $faker->randomElement(['Dell', 'HP', 'Canon', 'Nikon', 'Sony', 'Asus', 'LG', 'Epson', 'Lenovo', 'Logitech']),
                'jenis' => $faker->randomElement($jenisBarang),
                'stok' => $faker->numberBetween(1, 50),
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        DB::table('barang')->insert($data);
    }
}

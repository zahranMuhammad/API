<?php

namespace Database\Seeders;

use App\Models\Produk;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        $data_produk = [
            [
                'nama' => 'Nabati',
                'harga' => 2000,
                'rating' => '4.5',
                'gambar_produk' => 'https://arti-assets.sgp1.digitaloceanspaces.com/renyswalayanku/products/3da54c94-5ad1-4bb5-ab0d-bfbce4a44a87.jpg'
            ],
            [
                'nama' => 'Roma',
                'harga' => 4000,
                'rating' => '4.6',
                'gambar_produk' => 'https://c.alfagift.id/product/1/1_A7678590001073_20240521155519086_base.jpg'
            ],
            [
                'nama' => 'Fanta',
                'harga' => 6000,
                'rating' => '4.9',
                'gambar_produk' => 'https://cdn.ralali.id/assets/img/Libraries/100000175896001_FANTA_Minuman_Bersoda_1_Liter_Isi_12-1e0f3da99ecbc64f8abf300244dc40af-1.jpg'
            ],
            [
                'nama' => 'Coca - Cola',
                'harga' => 8000,
                'rating' => '4.4',
                'gambar_produk' => 'https://images-cdn.ubuy.co.id/676066df4df7d72f1e5b1d3f-coca-cola-500ml-bottle-24-pieces-cola.jpg'
            ],
            [
                'nama' => 'Popmie',
                'harga' => 7000,
                'rating' => '4.7',
                'gambar_produk' => 'https://api.duniamurah.com/assets/collections/catalogue/img/6167ad0b5dd9a.jpg'
            ],
            [
                'nama' => 'Oreo',
                'harga' => 3000,
                'rating' => '4.7',
                'gambar_produk' => 'https://www.selectro.co.id/cdn/shop/products/cycle_three_31_1024x1024.JPG?v=1441092514'
            ],
        ];

        Produk::insert($data_produk);
    }

}

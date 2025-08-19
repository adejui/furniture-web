<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $products = [
            [
                'name' => 'Meja Kayu Minimalis',
                'description' => 'Meja kayu solid desain minimalis cocok untuk ruang tamu atau kerja.',
                'price' => 750000,
                'stock' => 10,
                'category_id' => 1,
                'discount_id' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Kursi Gaming Ergonomis',
                'description' => 'Kursi gaming nyaman dengan sandaran punggung tinggi dan adjustable armrest.',
                'price' => 2200000,
                'stock' => 5,
                'category_id' => 2,
                'discount_id' => 2,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Lemari Pakaian 3 Pintu',
                'description' => 'Lemari pakaian dengan desain modern dan ruang penyimpanan luas.',
                'price' => 3400000,
                'stock' => 3,
                'category_id' => 3,
                'discount_id' => 3,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Sofa L Minimalis',
                'description' => 'Sofa bentuk L dengan bahan kain premium dan busa empuk.',
                'price' => 5600000,
                'stock' => 2,
                'category_id' => 4,
                'discount_id' => 3,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Rak Buku Kayu Jati',
                'description' => 'Rak buku dari kayu jati asli, tahan lama dan anti rayap.',
                'price' => 1450000,
                'stock' => 8,
                'category_id' => 5,
                'discount_id' => 3,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        foreach ($products as $product) {
            Product::create([
                'name' => $product['name'],
                'slug' => Str::slug($product['name']),
                'description' => $product['description'],
                'price' => $product['price'],
                'stock' => $product['stock'],
                'category_id' => $product['category_id'],
                'discount_id' => $product['discount_id'],
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}

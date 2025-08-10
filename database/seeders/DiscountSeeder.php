<?php

namespace Database\Seeders;

use Carbon\Carbon;
use App\Models\Discount;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class DiscountSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Discount::create([
            'name' => 'Diskon Awal Tahun',
            'discount_type' => 'percentage', // bisa 'percentage' atau 'fixed'
            'value' => 20, // 20% potongan
            'start_date' => Carbon::now(),
            'end_date' => Carbon::now()->addDays(30),
            'description' => 'Promo awal tahun potongan 20% untuk semua produk',
        ]);

        Discount::create([
            'name' => 'Diskon Lebaran',
            'discount_type' => 'fixed', // potongan nominal
            'value' => 50000, // Rp50.000
            'start_date' => Carbon::now()->addDays(10),
            'end_date' => Carbon::now()->addDays(20),
            'description' => 'Potongan harga Rp50.000 khusus menyambut Lebaran',
        ]);

        Discount::create([
            'name' => 'Diskon Akhir Tahun',
            'discount_type' => 'percentage',
            'value' => 30, // 30%
            'start_date' => Carbon::now()->addMonths(5),
            'end_date' => Carbon::now()->addMonths(5)->addDays(15),
            'description' => 'Promo akhir tahun dengan potongan 30% untuk produk tertentu',
        ]);
    }
}

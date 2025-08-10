<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class OrderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('orders')->insert([
            [
                'status'            => 'pending',
                'total_price'       => 250000,
                'shipping_name'     => 'John Doe',
                'shipping_phone'    => '081234567890',
                'shipping_address'  => 'Jl. Merdeka No. 123, Jakarta',
                'user_id'           => 2,
                'created_at'        => Carbon::now(),
                'updated_at'        => Carbon::now(),
            ],
            [
                'status'            => 'completed',
                'total_price'       => 500000,
                'shipping_name'     => 'Jane Smith',
                'shipping_phone'    => '081298765432',
                'shipping_address'  => 'Jl. Sudirman No. 45, Bandung',
                'user_id'           => 3,
                'created_at'        => Carbon::now(),
                'updated_at'        => Carbon::now(),
            ],
            [
                'status'            => 'shipped',
                'total_price'       => 350000,
                'shipping_name'     => 'Budi Santoso',
                'shipping_phone'    => '082112223334',
                'shipping_address'  => 'Jl. Diponegoro No. 89, Surabaya',
                'user_id'           => 4,
                'created_at'        => Carbon::now(),
                'updated_at'        => Carbon::now(),
            ],
        ]);
    }
}

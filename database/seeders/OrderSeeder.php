<?php

namespace Database\Seeders;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Order;
use App\Models\Product;
use App\Models\OrderItem;
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
        // cari user yang bukan admin
        $user = User::where('role', '!=', 'admin')->first();

        // kalau belum ada user non-admin, buat user baru
        if (!$user) {
            $user = User::factory()->create([
                'name' => 'Customer 1',
                'email' => 'customer1@example.com',
                'password' => bcrypt('password'),
                'role' => 'customer', // pastikan ada kolom role di tabel users
            ]);
        }

        $products = Product::take(5)->get();

        // buat 3 order contoh
        for ($i = 1; $i <= 3; $i++) {
            $order = Order::create([
                'user_id'          => $user->id,
                'status'           => 'pending',
                'shipping_name'    => 'Penerima ' . $i,
                'shipping_phone'   => '0812345678' . $i,
                'shipping_address' => 'Alamat pengiriman ' . $i,
                'total_price'      => 0,
            ]);

            $totalPrice = 0;

            // pilih random 1–3 produk
            $items = $products->random(rand(1, 3));

            foreach ($items as $product) {
                $qty   = rand(1, 5);
                $price = $product->price * $qty;

                OrderItem::create([
                    'order_id'   => $order->id,
                    'product_id' => $product->id,
                    'quantity'   => $qty,
                    'price'      => $price,
                ]);

                $totalPrice += $price;
            }

            $order->update(['total_price' => $totalPrice]);
        }
    }
    // public function run(): void
    // {
    //     DB::table('orders')->insert([
    //         [
    //             'status'            => 'pending',
    //             'total_price'       => 250000,
    //             'shipping_name'     => 'John Doe',
    //             'shipping_phone'    => '081234567890',
    //             'shipping_address'  => 'Jl. Merdeka No. 123, Jakarta',
    //             'user_id'           => 2,
    //             'created_at'        => Carbon::now(),
    //             'updated_at'        => Carbon::now(),
    //         ],
    //         [
    //             'status'            => 'completed',
    //             'total_price'       => 500000,
    //             'shipping_name'     => 'Jane Smith',
    //             'shipping_phone'    => '081298765432',
    //             'shipping_address'  => 'Jl. Sudirman No. 45, Bandung',
    //             'user_id'           => 3,
    //             'created_at'        => Carbon::now(),
    //             'updated_at'        => Carbon::now(),
    //         ],
    //         [
    //             'status'            => 'shipped',
    //             'total_price'       => 350000,
    //             'shipping_name'     => 'Budi Santoso',
    //             'shipping_phone'    => '082112223334',
    //             'shipping_address'  => 'Jl. Diponegoro No. 89, Surabaya',
    //             'user_id'           => 4,
    //             'created_at'        => Carbon::now(),
    //             'updated_at'        => Carbon::now(),
    //         ],
    //     ]);
    // }
}

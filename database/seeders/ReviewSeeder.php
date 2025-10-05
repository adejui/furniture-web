<?php

namespace Database\Seeders;

use Illuminate\Support\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class ReviewSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('reviews')->insert([
            [
                'rating' => 5,
                'comment' => 'Produk ini sangat bagus dan berkualitas!',
                'product_id' => 1,
                'user_id' => 2,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'rating' => 4,
                'comment' => 'Cukup memuaskan, hanya saja pengiriman agak lama.',
                'product_id' => 2,
                'user_id' => 3,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'rating' => 3,
                'comment' => 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Adipisci et perferendis repellat dolore quod ad voluptas ullam quaerat in dolor eius laboriosam alias eligendi reprehenderit inventore repellendus aspernatur nam vero rem nostrum unde, libero veniam? Ab sint rerum nostrum excepturi, delectus quis eius eligendi et fugiat, exercitationem natus consequuntur adipisci necessitatibus aperiam in. Odit culpa quia facilis consequatur. Alias doloremque eaque voluptatibus fuga hic illo velit, consequatur reiciendis dolor culpa? Eum laboriosam dolorum alias assumenda corrupti et, similique a vitae officia sapiente quia blanditiis reiciendis rem earum ullam suscipit reprehenderit distinctio quam nemo rerum quibusdam, eaque omnis. Corporis, aut ea!',
                'product_id' => 3,
                'user_id' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
        ]);
    }
}

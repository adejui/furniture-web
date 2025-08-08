<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            ['name' => 'Meja','slug' => 'meja', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Kursi','slug' => 'kursi', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Lemari','slug' => 'lemari', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Sofa','slug' => 'sofa', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Rak','slug' => 'rak', 'created_at' => now(), 'updated_at' => now()],
        ];

        DB::table('categories')->insert($categories);
    }
}

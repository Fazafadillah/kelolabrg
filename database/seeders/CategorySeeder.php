<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            ['category_name' => 'Elektronik',        'description' => 'Barang-barang elektronik kantor'],
            ['category_name' => 'Alat Tulis Kantor', 'description' => 'Perlengkapan tulis dan kantor'],
            ['category_name' => 'Furniture',         'description' => 'Perabotan dan furniture kantor'],
        ];

        foreach ($categories as $cat) {
            Category::create($cat);
        }
    }
}

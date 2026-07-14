<?php

namespace Database\Seeders;

use App\Models\Item;
use App\Models\Supplier;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ItemSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $items = [
            [
                'item_code'   => 'BRG-001',
                'item_name'   => 'Laptop Asus Vivobook',
                'category_id' => 1,
                'supplier_id' => 1,
                'stock'       => 15,
                'unit'        => 'unit',
                'price'       => 7500000,
                'description' => 'Laptop untuk kebutuhan operasional kantor',
            ],
            [
                'item_code'   => 'BRG-002',
                'item_name'   => 'Pulpen Standard AE7',
                'category_id' => 2,
                'supplier_id' => 2,
                'stock'       => 8,
                'unit'        => 'pcs',
                'price'       => 3500,
                'description' => 'Pulpen tinta hitam',
            ],
            [
                'item_code'   => 'BRG-003',
                'item_name'   => 'Kursi Kantor Ergonomis',
                'category_id' => 3,
                'supplier_id' => 2,
                'stock'       => 25,
                'unit'        => 'unit',
                'price'       => 850000,
                'description' => 'Kursi kantor dengan sandaran tinggi',
            ],
        ];

        foreach ($items as $item) {
            Item::create($item);
        }
    }
}

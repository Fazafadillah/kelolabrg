<?php

namespace Database\Seeders;

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
        $suppliers = [
            [
                'supplier_name' => 'PT Sumber Makmur',
                'phone'         => '081234567890',
                'email'         => 'sumbermakmur@email.com',
                'address'       => 'Jl. Industri No. 10, Bandung',
            ],
            [
                'supplier_name' => 'CV Mitra Jaya',
                'phone'         => '082198765432',
                'email'         => 'mitrajaya@email.com',
                'address'       => 'Jl. Raya Timur No. 5, Jakarta',
            ],
        ];

        foreach ($suppliers as $sup) {
            Supplier::create($sup);
        }
    }
}

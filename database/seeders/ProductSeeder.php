<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Product;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Product::create([
            'name' => 'Chocolate Croissant',
            'description' => 'Butter croissant with chocolate filling',
            'price' => 55.00,
            'stock' => 20,
            'image' => '/images/choco-croissant.jpg',
        ]);

        Product::create([
            'name' => 'Almond Tart',
            'description' => 'Sweet almond tart with custard filling',
            'price' => 75.00,
            'stock' => 15,
            'image' => '/images/almond-tart.jpg',
        ]);
    
    }
}

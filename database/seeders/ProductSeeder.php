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
            'name' => 'Premium Shio Pan',
            'description' => 'Soft and buttery Japanese-style bread.',
            'price' => 100.00,
            'stock' => 20,
            'image' => '/images/S.jpg',
        ]);

        Product::create([
            'name' => 'Chocolate Cake',
            'description' => 'Soft chocolate cake made with premium cocoa.',
            'price' => 120.00,
            'stock' => 20,
            'image' => '/images/CH.jpg',
        ]);

        Product::create([
            'name' => 'Butter Croissant',
            'description' => 'Flaky and buttery croissant baked to golden perfection.',
            'price' => 100.00,
           'stock' => 20,
            'image' => '/images/BC.jpg',
        ]);

        Product::create([
            'name' => 'Cookie',
            'description' => 'Crispy and soft cookies with chocolate chips.',
            'price' => 50.00,
            'stock' => 15,
            'image' => '/images/C.jpg',
        ]);

        Product::create([
            'name' => 'Brownie',
            'description' => 'Rich and fudgy chocolate brownie.',
            'price' => 30.00,
            'stock' => 15,
            'image' => '/images/B.jpg',
        ]);

        Product::create([
            'name' => 'Nougat(1 pcs.)',
            'description' => 'Chewy nougat with nuts.',
            'price' => 10.00,
            'stock' => 20,
            'image' => '/images/N.jpg',
        ]);

        Product::create([
            'name' => 'Macaron',
            'description' => 'Light and airy macarons with a creamy.',
            'price' => 50.00,
            'stock' => 20,
            'image' => '/images/M.jpg',
        ]);

        Product::create([
            'name' => 'Cupcake',
            'description' => 'Soft and fluffy cupcakes with sweet, creamy frosting.',
            'price' => 50.00,
            'stock' => 20,
            'image' => '/images/CUP.jpg',
        ]);
    
    }
}

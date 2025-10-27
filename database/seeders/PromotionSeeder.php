<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Promotion;

class PromotionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Promotion::create([
           'name' => 'Nougat 5+1',
           'description' => 'Promotion : Buy 5 get 1 free!!',
           'promo_price' => 50.00,
           'buy_quantity' => 6,
           'stock' => 20,
           'image' => '/images/N.jpg',
        ]);

        Promotion::create([
           'name' => 'Promo Brownie',
           'description' => 'Promotion : Buy 2 for 50 THB!!',
           'promo_price' => 50.00,
           'buy_quantity' => 2,
           'stock' => 15,
           'image' => '/images/B.jpg',
      ]);

        Promotion::create([
           'name' => 'Promo Cookie',
           'description' => 'Promotion : Buy 3 for 120 THB!!',
           'promo_price' => 120.00,
           'buy_quantity' => 3,
           'stock' => 15,
           'image' => '/images/C.jpg',
        ]);
    
      }
   }
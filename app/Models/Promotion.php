<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Promotion extends Model
{
    protected $fillable = ['name', 'description', 'promo_price', 'buy_quantity', 'stock', 'image'];
}


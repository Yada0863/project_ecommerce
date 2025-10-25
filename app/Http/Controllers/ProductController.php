<?php

namespace App\Http\Controllers;
use App\Models\Product;

use Illuminate\Http\Request;

class ProductController extends Controller
{
    // แสดงสินค้าทั้งหมด
    public function index()
    {
        $products = Product::all();
        return view('products.index', compact('products'));
    }

    // แสดงรายละเอียดสินค้าเดี่ยว
    public function show($id)
    {
        $product = Product::findOrFail($id);
        return view('products.show', compact('product'));
    }

}

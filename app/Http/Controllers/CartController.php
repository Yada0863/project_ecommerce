<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;


class CartController extends Controller
{   
    // แสดงหน้าตะกร้าสินค้า
    public function index()
    {
        // ดึงข้อมูลตะกร้าสินค้าจาก session
        $cart = session()->get('cart', []);

        // คำนวณราคารวม
        $total = collect($cart)->sum(function($item){
            return $item['price'] * $item['quantity'];
        });
        return view('cart.index', compact('cart', 'total'));
    }

    // เพิ่มสินค้าลงในตะกร้า
    public function add(Request $request, $id)
    {
        $product = Product::findOrFail($id);
        $quantity = max(1, (int) $request->input('quantity', 1));
        $cart = session()->get('cart', []);
        if(isset($cart[$id])){
            $cart[$id]['quantity'] += $quantity; // ถ้ามีแล้ว + จำนวน
        } else {
            $cart[$id] = [
                'id' => $product->id,
                'name' => $product->name,
                'price' => $product->price,
                'quantity' => $quantity,
                'image' => $product->image,
            ];
        }

        // บันทึกข้อมูลตะกร้าใน session
        session()->put('cart', $cart);

        return response()->json([
            'success' => true,
            'cart_count' => count($cart),
            'cart' => $cart
        ]);
    }

    // อัปเดตจำนวนสินค้าใน cart
    public function update(Request $request)
    {
        $cart = session()->get('cart', []);
        $quantities = $request->input('quantities', []);

        foreach($quantities as $id => $qty){
            if(isset($cart[$id])){
                $cart[$id]['quantity'] = max(1, (int)$qty);
            }
        }

        session()->put('cart', $cart);

        return response()->json([
            'success' => true,
            'cart_count' => count($cart),
            'cart' => $cart
        ]);
    }

    // ลบสินค้า
    public function remove($id)
    {
        $cart = session()->get('cart', []);
        if(isset($cart[$id])){
            unset($cart[$id]);
        }
        session()->put('cart', $cart);

        return response()->json([
            'success' => true,
            'cart_count' => count($cart),
            'cart' => $cart
        ]);
    }
}

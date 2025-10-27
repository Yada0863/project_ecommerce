<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Promotion;

class CartController extends Controller
{
    // แสดงหน้าตะกร้าสินค้า
    public function index()
    {
        $cart = session()->get('cart', []);

        // ใส่ default 'quantity' สำหรับ promotion  
        foreach ($cart as $key => $item) {
            if (!isset($item['quantity'])) {
                if (isset($item['sets']) && isset($item['buy_quantity'])) {
                    $cart[$key]['quantity'] = $item['sets'] * $item['buy_quantity'];
                    // กำหนด price ต่อชิ้น
                    $cart[$key]['price'] = $item['price'] / $item['buy_quantity'];
                } else {
                    $cart[$key]['quantity'] = 0;
                }
            }
        }

        // คำนวณราคารวม
        $total = collect($cart)->sum(function($item){
            return $item['price'] * $item['quantity'];
        });

        return view('cart.index', compact('cart', 'total'));
    }

    // เพิ่มสินค้า
    public function add(Request $request, $id)
    {
        $product = Product::findOrFail($id);
        $quantity = max(1, (int) $request->input('quantity', 1));
        $cart = session()->get('cart', []);

        if(isset($cart[$id])){
            $cart[$id]['quantity'] += $quantity;
        } else {
            $cart[$id] = [
                'id' => $product->id,
                'name' => $product->name,
                'price' => $product->price,
                'quantity' => $quantity,
                'image' => $product->image,
            ];
        }

        session()->put('cart', $cart);

        return response()->json(['success' => true, 'cart_count' => count($cart)]);
    }

    // เพิ่มโปรโมชั่น
    public function addPromotion(Request $request, $id)
    {
        $promotion = Promotion::findOrFail($id);
        $sets = max(1, (int) $request->input('quantity', 1)); // จำนวนชุด 
        $cart = session()->get('cart', []);

        $key = 'promotion_' . $promotion->id;

        if (isset($cart[$key])) {
            $cart[$key]['sets'] += $sets;
        } else {
            $cart[$key] = [
                'id' => $promotion->id,
                'name' => $promotion->name,
                'price' => $promotion->promo_price / $promotion->buy_quantity, // ราคาต่อชิ้น
                'sets' => $sets,
                'quantity' => $sets * $promotion->buy_quantity, // จำนวนชิ้นจริง
                'buy_quantity' => $promotion->buy_quantity, // จำนวนชิ้นต่อชุด
                'image' => $promotion->image,
            ];
        }

        // อัปเดต quantity เป็นจำนวนชิ้นจริง
        $cart[$key]['quantity'] = $cart[$key]['sets'] * $promotion->buy_quantity;

        session()->put('cart', $cart);

        return response()->json(['success' => true, 'cart_count' => count($cart)]);
    }

    // อัปเดตจำนวนสินค้า/โปรโมชั่น
    public function update(Request $request)
    {
        $cart = session()->get('cart', []);
        $quantities = $request->input('quantities', []);

        foreach($quantities as $id => $qty){
            if(isset($cart[$id])){
                $qty = max(1, (int)$qty);

                if(isset($cart[$id]['buy_quantity'])){
                    // สำหรับโปรโมชั่น: จำนวนชุด = ceil(จำนวนชิ้น / buy_quantity)
                    $cart[$id]['sets'] = ceil($qty / $cart[$id]['buy_quantity']);
                    $cart[$id]['quantity'] = $cart[$id]['sets'] * $cart[$id]['buy_quantity']; // จำนวนชิ้นจริง
                } else {
                    $cart[$id]['quantity'] = $qty; // สินค้าปกติ
                }
            }
        }

        session()->put('cart', $cart);

        return response()->json(['success' => true, 'cart_count' => count($cart)]);
    }

    // ลบสินค้า //  
    public function remove($id)
    {
        $cart = session()->get('cart', []);
        if(isset($cart[$id])){
            unset($cart[$id]);
        }

        session()->put('cart', $cart);

        return response()->json(['success' => true, 'cart_count' => count($cart)]);
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\OrderItem;

class OrderController extends Controller
{
    // แสดงหน้าชำระเงิน (Checkout)
    public function checkout()
    {
        $cart = session()->get('cart', []);
        if (empty($cart)) {
            return redirect()->route('cart.index')->with('error', 'Cart is empty!');
        }

        return view('checkout', compact('cart'));
    }

    // สร้างคำสั่งซื้อ
    public function placeOrder(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email',
            'address' => 'required',
        ]);

        $cart = session()->get('cart', []);
        $total = collect($cart)->sum(fn($item) => $item['price'] * $item['quantity']);

        $order = Order::create([
            'user_id' => auth()->id(),
            'name' => $request->name,
            'email' => $request->email,
            'address' => $request->address,
            'total' => $total,
        ]);

        foreach ($cart as $id => $item) {
    // ตรวจสอบว่าเป็น promotion หรือสินค้า
    $isPromotion = str_starts_with($id, 'promotion_');

    OrderItem::create([
        'order_id' => $order->id,
        'product_id' => $isPromotion ? null : $id, // ถ้าเป็น promotion ให้ใส่ null  
        'promotion_id' => $isPromotion ? str_replace('promotion_', '', $id) : null, // เพิ่มบรรทัดนี้ถ้ามีคอลัมน์ promotion_id
        'quantity' => $item['quantity'],
        'price' => $item['price'],
    ]);
}


        // เคลียร์ตะกร้า
        session()->forget('cart');
        return redirect()->route('order.success')->with('success', 'Order placed successfully!');
    }

    // หน้าแสดงคำสั่งซื้อสำเร็จ
    public function success()
    {
        return view('order_success');
    }

    // แสดงคำสั่งซื้อของผู้ใช้ปัจจุบันทั้งหมด
    public function myOrders()
    {
        $orders = Order::where('user_id', auth()->id())
            ->latest()
            ->get();

        return view('orders.index', compact('orders'));
    }

    // แสดงรายละเอียดคำสั่งซื้อเฉพาะ order
    public function showOrder($id)
    {
    $order = Order::with(['items.product', 'items.promotion'])
        ->where('user_id', auth()->id())
        ->findOrFail($id);

    return view('orders.show', compact('order'));
    }


}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\Promotion;

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
    $isPromotion = str_starts_with($id, 'promotion_');

    if ($isPromotion) {
        $promotionId = str_replace('promotion_', '', $id);
        $promotion = Promotion::find($promotionId);

        OrderItem::create([
            'order_id' => $order->id,
            'product_id' => null,
            'promotion_id' => $promotionId,
            'name' => $promotion?->name ?? 'Deleted Promotion',
            'quantity' => $item['quantity'],
            'price' => $item['price'],
        ]);
    } else {
        $productId = (int) $id; // แปลงเป็น integer
        $product = Product::find($productId);

        OrderItem::create([
            'order_id' => $order->id,
            'product_id' => $productId,
            'promotion_id' => null,
            'name' => $product?->name ?? 'Deleted Product', // ถ้า null จะขึ้น Deleted Product
            'quantity' => $item['quantity'],
            'price' => $item['price'],
        ]);
    }
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

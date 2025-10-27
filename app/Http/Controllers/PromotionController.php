<?php

namespace App\Http\Controllers;

use App\Models\Promotion; // ต้องมี Model Promotion
use Illuminate\Http\Request;

class PromotionController extends Controller
{
    // แสดงโปรโมชั่น
    public function index()
    {
        $promotions = Promotion::all(); // ดึงข้อมูลทั้งหมดจาก DB
        return view('promotions.index', compact('promotions'));
    }

    // แสดงรายละเอียดโปรโมชั่นเดียว
    public function show($id)
    {
        $promotion = Promotion::findOrFail($id); // ดึงข้อมูลตาม id
        return view('promotions.show', compact('promotion'));
    }
}

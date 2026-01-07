<?php

namespace App\Http\Controllers\frontend;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CartController extends Controller
{
public function addToCart(Request $request)
{
    $request->validate([
        'course_id' => 'required|exists:courses,id'
    ]);

    $userId   = Auth::id();
    $courseId = $request->course_id;

    // بررسی وجود محصول در سبد
    $exists = Cart::where('user_id', $userId)
        ->where('course_id', $courseId)
        ->exists();

    if ($exists) {
        return response()->json([
            'success' => false,
            'message' => 'این محصول قبلاً به سبد خرید اضافه شده است',
            'cart_count' => Cart::where('user_id', $userId)->count()
        ]);
    }

    // اضافه کردن محصول (فقط یک عدد)
    Cart::create([
        'user_id'   => $userId,
        'course_id' => $courseId,
        'quantity'  => 1,
    ]);

    return response()->json([
        'success' => true,
        'message' => 'محصول با موفقیت به سبد خرید اضافه شد',
        'cart_count' => Cart::where('user_id', $userId)->count()
    ]);
}
    
    public function removeFromCart(Request $request)
    {
        $cartItem = Cart::where([
            'user_id' => Auth::id(),
            'course_id' => $request->course_id
        ])->first();
        
        if ($cartItem) {
            if ($cartItem->quantity > 1) {
                $cartItem->decrement('quantity');
            } else {
                $cartItem->delete();
            }
        }
        
        return response()->json([
            'success' => true,
            'message' => 'سبد خرید آپدیت شد'
        ]);
    }
}
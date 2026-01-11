<?php

namespace App\Http\Controllers\frontend;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CartController extends Controller
{

    /**
     * Handle Ajax Request Add Item in Cart Course Single
     * @return json
     */
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

    /**
     * Handle Ajax Request Remove Item in Cart Course Single
     * @return json
     */
    public function removeFromCart(Request $request, $courseid)
    {
        $cartItem = Cart::where([
            'user_id' => Auth::id(),
            'course_id' => $courseid
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


    /**
     * Show Cart Items Page
     * @return view
     */

    public function index()
{
    $items = Cart::with('course')
                ->where('user_id', Auth::id())
                ->get();

    // محاسبات با collection
        $calculations = $items->reduce(function ($carry, $item) {
        $regularPrice = $item->course->regular_price;
        $salePrice = $item->course->sale_price;

        // بررسی وجود تخفیف معتبر
        $hasDiscount = $salePrice && $salePrice > 0 && $salePrice < $regularPrice;
        $itemFinalPrice = $hasDiscount ? $salePrice : $regularPrice;
        $itemDiscount = $hasDiscount ? ($regularPrice - $salePrice) : 0;

        return [
            'totalRegularPrice' => $carry['totalRegularPrice'] + $regularPrice,
            'totalSalePrice' => $carry['totalSalePrice'] + $itemFinalPrice,
            'totalDiscount' => $carry['totalDiscount'] + $itemDiscount,
            'course_count' => $carry['course_count'] + 1
        ];
    }, ['totalRegularPrice' => 0, 'totalSalePrice' => 0, 'totalDiscount' => 0, 'course_count' => 0]);

    return view('frontend.cart', array_merge(
        ['items' => $items],
        $calculations,
        ['finalPrice' => $calculations['totalSalePrice']]
    ));
}
    }

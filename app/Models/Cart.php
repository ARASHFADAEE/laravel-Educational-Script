<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Cart extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'course_id',
        'quantity'
    ];

    // رابطه با کاربر
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // رابطه با دوره/محصول
    public function course()
    {
        return $this->belongsTo(Course::class);
    }
    
    // اضافه کردن محصول با چک کردن تکراری نبودن
    public static function addItem($userId, $courseId, $quantity = 1)
    {
        return self::updateOrCreate(
            [
                'user_id' => $userId,
                'course_id' => $courseId
            ],
            [
                'quantity' => DB::raw("quantity + {$quantity}")
            ]
        );
    }

    //method for price cart
    public static function calculateCartTotals($userId)
    {
        $items = self::with('course')->where('user_id', $userId)->get();
        
        $totals = [
            'items' => $items,
            'course_count' => $items->count(),
            'totalRegularPrice' => 0,
            'totalSalePrice' => 0,
            'totalDiscount' => 0,
        ];
        
        foreach ($items as $item) {
            $course = $item->course;
            $regularPrice = $course->regular_price;
            $salePrice = $course->sale_price;
            
            // بررسی تخفیف
            $hasValidDiscount = $salePrice && $salePrice > 0 && $salePrice < $regularPrice;
            $itemPrice = $hasValidDiscount ? $salePrice : $regularPrice;
            $itemDiscount = $hasValidDiscount ? ($regularPrice - $salePrice) : 0;
            
            $totals['totalRegularPrice'] += $regularPrice;
            $totals['totalSalePrice'] += $itemPrice;
            $totals['totalDiscount'] += $itemDiscount;
        }
        
        $totals['finalPrice'] = $totals['totalSalePrice'];
        
        return $totals;
    }
}
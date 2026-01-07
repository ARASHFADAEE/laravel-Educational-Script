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
}
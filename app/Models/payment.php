<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class payment extends Model
{
    //
    protected $fillable = [
        'user_id',
        'course_id',
        'amount',
        'payment_method',
        'status'
    ];

    
}

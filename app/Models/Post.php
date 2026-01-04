<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    protected $fillable = [
        'category_id',
        'user_id',
        'user_id',
        'title',
        'slug',
        'body',
        'status',
    ];
}

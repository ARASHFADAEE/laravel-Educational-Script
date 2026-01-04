<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Post extends Model
{
    protected $fillable = [
        'category_id',
        'user_id',
        'title',
        'slug',
        'body',
        'status',
    ];
    public function user()
    {
        $this->BelongsTo(Post::class);

    }

    public function post_categorie(){
        $this->belongsTo(Post::class);
    }


    public function comments(){
        $this->hasMany(comment::class);    }
}

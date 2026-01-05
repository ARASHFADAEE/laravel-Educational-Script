<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Models\seo_meta as Seo;

class Post extends Model
{
    protected $fillable = [
        'category_id',
        'user_id',
        'title',
        'slug',
        'body',
        'status',
        'thumbnail'
    ];

    public function seo()
    {
        return $this->morphOne(Seo::class, 'metable');
    }
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

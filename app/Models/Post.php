<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Models\seo_meta as Seo;
use App\Models\post_categorie as PostCategory;

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
        return $this->belongsTo(User::class, 'user_id');
    }

public function post_categorie()
    {
        return $this->belongsTo(PostCategory::class, 'category_id');
    }


    public function comments(){
        return $this->hasMany(comment::class);    }
}

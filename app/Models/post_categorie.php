<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class post_categorie extends Model
{
    protected $fillable = [
        'name',
        'slug'
    ];

    
    public function posts()
    {
        return $this->hasMany(Post::class, 'category_id');
    }


}

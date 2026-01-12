<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Course_categorie extends Model
{
    //

    protected $fillable = [
        'name',
        'slug'
    ];


    public function courses()
    {
        return $this->hasMany(course::class , 'category_id');
    }
}

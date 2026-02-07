<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    protected $fillable = [
        'category_id',
        'user_id',
        'title',
        'slug',
        'level',
        'regular_price',
        'status',
        'thumbnail',
        'description',
        'sale_price',
        'time_course'

    ];



    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function course_categorie(){
return $this->belongsTo(CourseCategory::class, 'category_id', 'id');

}


    public function lessons(){
        return $this->hasMany(Lesson::class);
    }
    public function chapters()
    {
        return $this->hasMany(Chapter::class);
    }

    public function payments()
{
    return $this->hasMany(Payment::class);
}

    public function carts(){
        return $this->hasMany(Cart::class);
    }







}

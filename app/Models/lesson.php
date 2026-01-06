<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class lesson extends Model
{
    //

    protected $fillable = [
        'course_id',
        'title',
        'slug',
        'content',
        'video_url',
        'position',
        'is_free'
    ];


    public function course(){
        return $this->belongsTo(course::class);
    }
}

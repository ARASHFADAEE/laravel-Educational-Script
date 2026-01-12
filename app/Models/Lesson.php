<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Lesson extends Model
{
    //

    protected $fillable = [
        'chapter_id',
        'title',
        'slug',
        'content',
        'video_url',
        'position',
        'is_free',
        'File_link'
    ];




    public function chapter()
    {
        return $this->belongsTo(Chapter::class, 'chapter_id');
    }

}

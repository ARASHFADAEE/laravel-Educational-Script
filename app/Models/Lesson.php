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
        'file_link',
        'duration',
        'is_hls'
    ];




    public function chapter()
    {
        return $this->belongsTo(Chapter::class, 'chapter_id');
    }

}

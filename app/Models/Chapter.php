<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Chapter extends Model
{
    use HasFactory;

    protected $fillable = [
        'course_id',
        'title',
        'slug',
        'description',
        'position',
    ];

    /**
     * Get the course that owns the chapter.
     */
    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    /**
     * Get the lessons for the chapter.
     *
     */
     public function lessons()
     {
         return $this->hasMany(Lesson::class);
     }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SeoMeta extends Model
{
    protected $fillable = [
        'meta_title',
        'meta_description',
        'meta_keywords',
        'metable_type',
        'metable_id'
    ];


    public function metable()
    {
        return $this->morphTo();
    }
}

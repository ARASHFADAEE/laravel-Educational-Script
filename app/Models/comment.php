<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class comment extends Model
{
    //
    protected $fillable = [
        'post_id',
        'user_id',
        'body',
        'parent_id',
    ];


    public function user(){

        $this->belongsTo(user::class);

    }

    public function post(){
        $this->belongsTo(Post::class);
    }
}

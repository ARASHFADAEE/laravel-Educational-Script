<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;

use App\Models\User;



use Illuminate\Http\Request;


class dashboard extends Controller
{


    public function bag(){

        $user_count = User::count();

        return [
            'user_count' => $user_count,


        ];
    }
    public function index()
    {
        return view('admin.index',$this->bag());
    }
}

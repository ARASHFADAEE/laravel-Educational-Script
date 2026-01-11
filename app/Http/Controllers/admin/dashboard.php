<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\course;
use App\Models\payment;
use App\Models\User;



use Illuminate\Http\Request;
use PhpParser\Node\Expr\Array_;


class dashboard extends Controller
{

    /**
     *
     * Data Dashboard Componnent
     *
     * @return Array
     *
     **/
    public function bag(){

        $user_count = User::count();
        $course_count = course::count();
        $payment_count = payment::query()->where('status','completed')->count();
        $payment_sum= payment::query()->where('status','completed')->sum('amount');
        $users_lastest=User::latest()->take(5)->get();


        return [
            'user_count' => $user_count,
            'course_count' => $course_count,
            'payment_count' => $payment_count,
            'payment_sum' => $payment_sum,
            'users_lastest' => $users_lastest
        ];
    }



    /**
     *
     * Show Dashboard Page
     *
     * @return view
     *
     **/
    public function index()
    {
        return view('admin.index',$this->bag());
    }
}

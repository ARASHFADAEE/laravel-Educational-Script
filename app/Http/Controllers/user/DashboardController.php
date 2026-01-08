<?php

namespace App\Http\Controllers\user;

use App\Http\Controllers\Controller;
use App\Models\enrollment;
use App\Models\payment;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
class DashboardController extends Controller
{
    /**
     * View Dashboard User index
     * @return view
     */

    public function index(){
        
        //Get Data User Loggined
        $user = Auth::user();
        
        //Courses Payment User
        $purchasedCourses = $user->payments()
            ->with('course') 
            ->where('status', 'completed')
            ->latest()
            ->get()
            ->pluck('course'); 

        return view('user.index', compact('purchasedCourses'));



    }


    /**
     * view Courses User Lists
     * 
     * @return view
     */

    
    public function Courses(){
        //Get Id User Auth
        $userId=Auth::id();

        //Get List Course User Enrollment
        $items=enrollment::query()->where('user_id','=',$userId)->with('course')->get();

        return view('user.courses',compact('items'));
        

    }


    /**
     * view payments User Lists
     * 
     * @return view
     */

    public function payments(){
        $userId=Auth::id();
        $payments=payment::query()->where('user_id','=',$userId)->with('course')->get();

        return view('user.payments',compact('payments'));

    }

}

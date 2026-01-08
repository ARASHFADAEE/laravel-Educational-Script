<?php

namespace App\Http\Controllers\user;

use App\Http\Controllers\Controller;
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
}

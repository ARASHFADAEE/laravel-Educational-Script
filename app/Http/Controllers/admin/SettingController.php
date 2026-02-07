<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    /**
     *
     * Show List Setting In Form Admin Panel
     *
     * */
    public function index(){

        $settings = Setting::all();



    }
}

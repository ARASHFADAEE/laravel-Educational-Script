<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Symfony\Component\Routing\Route;
use Illuminate\Support\Facades\Auth;


class RegisterController extends Controller
{


    /**
     *
     * Show Register Form
     * @return view
     *
     */
    public function show()
    {
        if (Auth::check()) {
            return redirect()->route('home');
        }
        return view('Auth.register');
    }



    /**
     *
     * Handle Register Form
     * @return view(home)
     *
     */
    public function register(Request $request)
    {
        // اعتبارسنجی ورودی‌ها
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ]);

        // ایجاد کاربر جدید
        $user = \App\Models\User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
        ]);

        // ورود خودکار کاربر پس از ثبت‌نام
        auth()->login($user);

        // هدایت به صفحه اصلی یا داشبورد
        return redirect()->route('home');
    }
}

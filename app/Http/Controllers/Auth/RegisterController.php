<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RegisterController extends Controller
{
    public function show()
    {
        if (Auth::check()) {
            return redirect()->route('home');
        }

        return view('Auth.register');
    }

    public function register(Request $request)
    {
        $validated = $request->validate(
            [
                'name' => 'required|string|max:255',
                'email' => 'required|string|email|max:255|unique:users,email',
                'phone' => 'required|string|max:20|unique:users,phone',
                'password' => 'required|string|min:8|confirmed',
            ],
            [
                'phone.required' => 'شماره موبایل الزامی است.',
                'phone.unique' => 'این شماره موبایل قبلا ثبت شده است.',
            ]
        );

        $phone = $this->normalizePhone((string) $validated['phone']);

        if (!preg_match('/^09\d{9}$/', $phone)) {
            return back()->withInput($request->except('password', 'password_confirmation'))->withErrors([
                'phone' => 'شماره موبایل معتبر نیست. (مثال: 09123456789)',
            ]);
        }

        $user = User::create([
            'name' => $validated['name'],
            'email' => mb_strtolower((string) $validated['email']),
            'phone' => $phone,
            'password' => $validated['password'],
        ]);

        Auth::login($user);

        return redirect()->route('home')->with('success', 'ثبت‌نام با موفقیت انجام شد.');
    }

    private function normalizePhone(string $phone): string
    {
        $converted = str_replace(
            ['۰', '۱', '۲', '۳', '۴', '۵', '۶', '۷', '۸', '۹'],
            ['0', '1', '2', '3', '4', '5', '6', '7', '8', '9'],
            $phone
        );

        $digits = preg_replace('/\D+/', '', $converted) ?? '';

        if (str_starts_with($digits, '98') && strlen($digits) === 12) {
            $digits = '0' . substr($digits, 2);
        } elseif (str_starts_with($digits, '9') && strlen($digits) === 10) {
            $digits = '0' . $digits;
        }

        return $digits;
    }
}

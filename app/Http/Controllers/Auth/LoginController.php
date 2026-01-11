<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Log;

class LoginController extends Controller
{
    /**
     *
     * Show Login Form
     *
     * @return View
     */

    public function show()
    {
        // اگر کاربر قبلا لاگین کرده بود، به داشبورد هدایت شود
        if (Auth::check()) {
            return redirect()->route('home');
        }

        return view('auth.login');
    }

    /**
     *
     * Handle Login Form (Submit Form)
     *
     */

    public function submit(Request $request)
    {
        // اعتبارسنجی داده‌های ورودی
        $validated = $request->validate(
            [
                'email' => 'required|email|min:8|max:255',
                'password' => 'required|min:8',
                'remember' => 'nullable|boolean'
            ],
            [
                'email.required' => 'وارد کردن ایمیل الزامی هست',
                'email.email' => 'ایمیل وارد شده استاندارد نیست',
                'email.min' => 'حداقل کاراکتر برای ایمیل ۸ کاراکتر هست',
                'email.max' => 'حداکثر کاراکتر برای ایمیل ۲۵۵ کاراکتر هست',
                'password.required' => 'وارد کردن پسورد الزامیست',
                'password.min' => 'حداقل کاراکتر برای رمز عبور ۸ کاراکتر هست',
            ]
        );

        try {
            // تلاش برای احراز هویت کاربر
            $credentials = [
                'email' => $validated['email'],
                'password' => $validated['password']
            ];

            $remember = $request->has('remember') ? true : false;

            if (Auth::attempt($credentials, $remember)) {
                // احراز هویت موفق
                $request->session()->regenerate();

                // لاگ کردن ورود موفق
                Log::info('User logged in', [
                    'user_id' => Auth::id(),
                    'email' => $validated['email'],
                    'ip' => $request->ip()
                ]);

                // هدایت بر اساس نقش کاربر
                $user = Auth::user();

                if ($user->role=='admin') {
                    return redirect()->intended(route('admin.dashboard'))->with('success','ورود با موفقیت انجام شد');
                } elseif ($user->role=='user') {
                    return redirect()->back()->with('success','ورود با موفقیت انجام شد');
                } else {
                    return redirect()->back()->with('success','ورود با موفقیت انجام شد');
                }

            } else {
                // احراز هویت ناموفق
                Log::warning('Failed login attempt', [
                    'email' => $validated['email'],
                    'ip' => $request->ip()
                ]);

                return back()
                    ->withInput($request->only('email', 'remember'))
                    ->withErrors([
                        'email' => 'ایمیل یا رمز عبور اشتباه است',
                    ]);
            }

        } catch (\Exception $e) {
            // ثبت خطا در لاگ
            Log::error('Login error', [
                'error' => $e->getMessage(),
                'email' => $validated['email'] ?? 'N/A',
                'ip' => $request->ip()
            ]);

            return back()
                ->withInput($request->only('email', 'remember'))
                ->withErrors([
                    'email' => 'خطایی در ورود رخ داد. لطفا مجددا تلاش کنید.',
                ]);
        }
    }

    /**
     * Handle LogOut User
     *
     * @return view
     */

    public function logout(Request $request)
    {
        $user = Auth::user();

        // لاگ کردن خروج
        Log::info('User logged out', [
            'user_id' => $user->id ?? null,
            'email' => $user->email ?? 'N/A',
            'ip' => $request->ip()
        ]);

        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('home')->with('success', 'با موفقیت خارج شدید.');
    }

    /**
     *
     * Handle Accses User LLogin
     *
     *
     */
    public function check()
    {
        return response()->json([
            'logged_in' => Auth::check(),
            'user' => Auth::check() ? [
                'id' => Auth::id(),
                'name' => Auth::user()->name,
                'email' => Auth::user()->email,
                'role' => Auth::user()->role // اگر role دارید
            ] : null
        ]);
    }
}

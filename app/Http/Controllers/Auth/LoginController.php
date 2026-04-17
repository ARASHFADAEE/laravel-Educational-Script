<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Jobs\SendOtpSmsJob;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class LoginController extends Controller
{
    public function show()
    {
        if (Auth::check()) {
            return redirect()->route('home');
        }

        return view('Auth.login');
    }

    public function submit(Request $request)
    {
        $mode = $request->input('auth_mode', 'password');

        if ($mode === 'otp') {
            return $this->handleOtpFlow($request);
        }

        return $this->handlePasswordFlow($request);
    }

    public function logout(Request $request)
    {
        $user = Auth::user();

        Log::info('User logged out', [
            'user_id' => $user->id ?? null,
            'email' => $user->email ?? 'N/A',
            'ip' => $request->ip(),
        ]);

        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('home')->with('success', 'با موفقیت خارج شدید.');
    }

    public function check()
    {
        return response()->json([
            'logged_in' => Auth::check(),
            'user' => Auth::check() ? [
                'id' => Auth::id(),
                'name' => Auth::user()->name,
                'email' => Auth::user()->email,
                'role' => Auth::user()->role,
            ] : null,
        ]);
    }

    private function handlePasswordFlow(Request $request)
    {
        $validated = $request->validate(
            [
                'identifier' => 'required|string|max:255',
                'password' => 'required|string|min:8|max:255',
                'remember' => 'nullable|boolean',
            ],
            [
                'identifier.required' => 'ایمیل یا شماره موبایل را وارد کنید.',
                'password.required' => 'وارد کردن رمز عبور الزامی است.',
                'password.min' => 'حداقل کاراکتر برای رمز عبور ۸ کاراکتر است.',
            ]
        );

        $identifier = trim((string) $validated['identifier']);
        $field = $this->isEmail($identifier) ? 'email' : 'phone';
        $value = $field === 'phone' ? $this->normalizePhone($identifier) : mb_strtolower($identifier);

        $credentials = [
            $field => $value,
            'password' => $validated['password'],
        ];

        $remember = $request->boolean('remember');

        if (!Auth::attempt($credentials, $remember)) {
            Log::warning('Failed password login attempt', [
                'identifier' => $identifier,
                'field' => $field,
                'ip' => $request->ip(),
            ]);

            return back()->withInput($request->only('identifier', 'remember', 'auth_mode'))->withErrors([
                'identifier' => 'اطلاعات ورود صحیح نیست.',
            ]);
        }

        $request->session()->regenerate();

        Cache::forget($this->otpKey($value));
        Cache::forget($this->otpCooldownKey($value));

        Log::info('User logged in with password', [
            'user_id' => Auth::id(),
            'field' => $field,
            'identifier' => $value,
            'ip' => $request->ip(),
        ]);

        return $this->redirectAfterLogin(Auth::user());
    }

    private function handleOtpFlow(Request $request)
    {
        $validated = $request->validate(
            [
                'identifier' => 'required|string|max:255',
                'otp_code' => 'nullable|digits:6',
            ],
            [
                'identifier.required' => 'شماره موبایل را وارد کنید.',
                'otp_code.digits' => 'کد ورود باید ۶ رقم باشد.',
            ]
        );

        $rawIdentifier = trim((string) $validated['identifier']);

        if ($this->isEmail($rawIdentifier)) {
            return back()->withInput($request->only('identifier', 'auth_mode'))->withErrors([
                'identifier' => 'برای ورود با کد یکبارمصرف، شماره موبایل وارد کنید.',
            ]);
        }

        $phone = $this->normalizePhone($rawIdentifier);

        if (!preg_match('/^09\d{9}$/', $phone)) {
            return back()->withInput($request->only('identifier', 'auth_mode'))->withErrors([
                'identifier' => 'شماره موبایل معتبر نیست. (مثال: 09123456789)',
            ]);
        }

        $user = User::where('phone', $phone)->first();

        // اگر کاربر وجود نداشت، یک کاربر تستی موقت ایجاد می‌کنیم (ثبت‌نام سریع)
        if (!$user) {
            $user = User::create([
                'name' => 'کاربر جدید',
                'phone' => $phone,
                'email' => $phone . '@temp.com', // ایمیل موقت
                'password' => Hash::make(str()->random(16)),
            ]);

            // علامت‌گذاری برای ریدایرکت به تکمیل پروفایل
            $request->session()->put('needs_profile_completion', true);
        }

        $otpCode = trim((string) $request->input('otp_code', ''));

        if ($otpCode === '') {
            return $this->sendOtpCode($request, $user, $phone);
        }

        return $this->verifyOtpCode($request, $user, $phone, $otpCode);
    }

    private function sendOtpCode(Request $request, User $user, string $phone)
    {
        if (Cache::has($this->otpCooldownKey($phone))) {
            return back()->withInput($request->only('identifier', 'auth_mode'))->withErrors([
                'otp_code' => 'کد قبلی هنوز معتبر است. لطفا کمی بعد دوباره تلاش کنید.',
            ]);
        }

        $code = (string) random_int(100000, 999999);

        Cache::put($this->otpKey($phone), [
            'user_id' => $user->id,
            'code_hash' => Hash::make($code),
            'attempts' => 0,
            'expires_at' => now()->addMinutes(2)->timestamp,
        ], now()->addMinutes(2));

        Cache::put($this->otpCooldownKey($phone), true, now()->addSeconds(60));

        // ارسال جاب برای پیامک
        SendOtpSmsJob::dispatch($code, $phone);

        Log::info('OTP login code generated and job dispatched', [
            'user_id' => $user->id,
            'phone' => $phone,
            'otp_code' => app()->environment('local') ? $code : '***',
            'ip' => $request->ip(),
        ]);

        $request->session()->flash('otp_pending_phone', $phone);
        $request->session()->flash('otp_pending_masked', $this->maskPhone($phone));

        if (app()->environment('local')) {
            $request->session()->flash('otp_debug_code', $code);
        }

        return back()->withInput([
            'identifier' => $phone,
            'auth_mode' => 'otp',
        ])->with('success', 'کد ورود ارسال شد. لطفا کد ۶ رقمی را وارد کنید.');
    }

    private function verifyOtpCode(Request $request, User $user, string $phone, string $otpCode)
    {
        $record = Cache::get($this->otpKey($phone));

        if (!$record || !isset($record['code_hash'], $record['user_id'], $record['expires_at'])) {
            return back()->withInput($request->only('identifier', 'auth_mode'))->withErrors([
                'otp_code' => 'کد منقضی شده است. دوباره درخواست کد دهید.',
            ]);
        }

        if ((int) $record['user_id'] !== (int) $user->id) {
            Cache::forget($this->otpKey($phone));
            return back()->withInput($request->only('identifier', 'auth_mode'))->withErrors([
                'otp_code' => 'درخواست نامعتبر است. لطفا دوباره تلاش کنید.',
            ]);
        }

        if ((int) ($record['attempts'] ?? 0) >= 5) {
            Cache::forget($this->otpKey($phone));
            return back()->withInput($request->only('identifier', 'auth_mode'))->withErrors([
                'otp_code' => 'تعداد تلاش بیش از حد مجاز بود. دوباره کد دریافت کنید.',
            ]);
        }

        if (now()->timestamp > (int) $record['expires_at']) {
            Cache::forget($this->otpKey($phone));
            return back()->withInput($request->only('identifier', 'auth_mode'))->withErrors([
                'otp_code' => 'زمان کد به پایان رسیده است. دوباره درخواست کد دهید.',
            ]);
        }

        if (!Hash::check($otpCode, (string) $record['code_hash'])) {
            $record['attempts'] = (int) ($record['attempts'] ?? 0) + 1;
            Cache::put($this->otpKey($phone), $record, now()->addSeconds(90));

            return back()->withInput($request->only('identifier', 'auth_mode'))->withErrors([
                'otp_code' => 'کد وارد شده صحیح نیست.',
            ]);
        }

        Cache::forget($this->otpKey($phone));
        Cache::forget($this->otpCooldownKey($phone));

        Auth::login($user);
        $request->session()->regenerate();

        Log::info('User logged in with OTP', [
            'user_id' => $user->id,
            'phone' => $phone,
            'ip' => $request->ip(),
        ]);

        if ($request->session()->pull('needs_profile_completion')) {
            return redirect()->route('user.profile')->with('success', 'خوش آمدید! لطفا پروفایل خود را تکمیل کنید.');
        }

        return $this->redirectAfterLogin($user);
    }

    private function redirectAfterLogin(User $user)
    {
        if ($user->role === 'admin') {
            return redirect()->intended(route('admin.dashboard'))->with('success', 'ورود با موفقیت انجام شد.');
        }

        return redirect()->intended(route('home'))->with('success', 'ورود با موفقیت انجام شد.');
    }

    private function isEmail(string $value): bool
    {
        return filter_var($value, FILTER_VALIDATE_EMAIL) !== false;
    }

    private function normalizePhone(string $phone): string
    {
        // تبدیل اعداد فارسی به انگلیسی
        $converted = str_replace(
            ['۰', '۱', '۲', '۳', '۴', '۵', '۶', '۷', '۸', '۹', '٠', '١', '٢', '٣', '٤', '٥', '٦', '٧', '٨', '٩'],
            ['0', '1', '2', '3', '4', '5', '6', '7', '8', '9', '0', '1', '2', '3', '4', '5', '6', '7', '8', '9'],
            $phone
        );

        // حذف تمامی کاراکترهای غیر عددی
        $digits = preg_replace('/\D+/', '', $converted) ?? '';

        // استانداردسازی به فرمت 09xxxxxxxxx
        if (str_starts_with($digits, '989') && strlen($digits) === 12) {
            $digits = '0' . substr($digits, 2);
        } elseif (str_starts_with($digits, '00989') && strlen($digits) === 14) {
            $digits = '0' . substr($digits, 4);
        } elseif (str_starts_with($digits, '9') && strlen($digits) === 10) {
            $digits = '0' . $digits;
        }

        return $digits;
    }

    private function maskPhone(string $phone): string
    {
        if (strlen($phone) !== 11) {
            return $phone;
        }

        return substr($phone, 0, 4) . '***' . substr($phone, -4);
    }

    private function otpKey(string $phone): string
    {
        return 'auth_login_otp_' . $phone;
    }

    private function otpCooldownKey(string $phone): string
    {
        return 'auth_login_otp_cooldown_' . $phone;
    }
}

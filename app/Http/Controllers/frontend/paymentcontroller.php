<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Admin\SubscriptionSettingController;
use App\Jobs\SendSuccessPaymentSmsJob;
use App\Models\Cart;
use App\Models\Course;
use App\Models\Enrollment;
use App\Models\Payment;
use App\Models\Subscription;
use App\Models\SubscriptionPlan;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;

class PaymentController extends Controller
{
    /**
     * Handle cart payment request (logged-in users).
     */
    public function request_zibal()
    {
        $userId = Auth::id();

        if (!Cart::where('user_id', $userId)->exists()) {
            return back()->with('error', 'سبد خرید شما خالی است!');
        }

        $totals = Cart::calculateCartTotals($userId);
        $amountInRials = $totals['finalPrice'] * 10;

        if ($amountInRials <= 0) {
            return back()->with('error', 'مبلغ پرداخت معتبر نیست!');
        }

        $response = Http::post('https://gateway.zibal.ir/v1/request', [
            'merchant' => 'zibal',
            'amount' => $amountInRials,
            'callbackUrl' => route('payment.callback'),
            'description' => 'پرداخت سبد خرید دوره‌های آموزشی',
            'orderId' => 'cart_' . $userId . '_' . time(),
        ]);

        $result = $response->json();

        if (isset($result['result']) && (int) $result['result'] === 100 && isset($result['trackId'])) {
            $trackId = $result['trackId'];

            session([
                'zibal_trackId' => $trackId,
                'zibal_expected_amount' => $amountInRials,
                'checkout_payload' => [
                    'mode' => 'cart',
                    'user_id' => $userId,
                ],
            ]);

            return redirect()->away('https://gateway.zibal.ir/start/' . $trackId);
        }

        return back()->with('error', 'خطا در اتصال به درگاه پرداخت: ' . ($result['message'] ?? 'نامشخص'));
    }

    /**
     * Handle direct checkout from single course (guest or logged-in).
     */
    public function requestCourseZibal(Request $request, Course $course)
    {
        if (Auth::check()) {
            $request->validate([
                'first_name' => 'nullable|string|max:80',
                'last_name' => 'nullable|string|max:80',
                'phone' => 'nullable|string|max:20',
            ]);
        } else {
            $request->validate([
                'first_name' => 'required|string|max:80',
                'last_name' => 'required|string|max:80',
                'phone' => 'required|string|max:20',
            ]);
        }

        $price = $this->courseFinalPrice($course);
        $amountInRials = $price * 10;

        // اگر دوره رایگان است، بدون درگاه ثبت نام کنید
        if ($amountInRials <= 0) {
            return $this->enrollFreeCourse($request, $course);
        }

        $firstName = trim((string) $request->input('first_name', ''));
        $lastName = trim((string) $request->input('last_name', ''));
        $normalizedPhone = $this->normalizePhone((string) $request->input('phone', ''));

        if (!Auth::check() && !preg_match('/^09\d{9}$/', $normalizedPhone)) {
            return back()->with('error', 'شماره موبایل معتبر نیست.');
        }

        if (Auth::check()) {
            $user = Auth::user();
            $parts = explode(' ', trim((string) $user->name), 2);
            $firstName = $firstName !== '' ? $firstName : ($parts[0] ?? '');
            $lastName = $lastName !== '' ? $lastName : ($parts[1] ?? '');
            $normalizedPhone = $normalizedPhone !== '' ? $normalizedPhone : $this->normalizePhone((string) ($user->phone ?? ''));

            $alreadyEnrolled = Enrollment::where('user_id', $user->id)
                ->where('course_id', $course->id)
                ->exists();
            if ($alreadyEnrolled) {
                return redirect()->route('course.show', $course->slug)
                    ->with('success', 'شما قبلا در این دوره ثبت‌نام کرده‌اید.');
            }
        }

        $response = Http::post('https://gateway.zibal.ir/v1/request', [
            'merchant' => env('ZIBAL_MERCHENT'),
            'amount' => $amountInRials,
            'callbackUrl' => route('payment.callback'),
            'description' => 'خرید دوره: ' . $course->title,
            'orderId' => 'course_' . $course->id . '_' . time(),
        ]);

        $result = $response->json();

        if (isset($result['result']) && (int) $result['result'] === 100 && isset($result['trackId'])) {
            $trackId = $result['trackId'];

            session([
                'zibal_trackId' => $trackId,
                'zibal_expected_amount' => $amountInRials,
                'checkout_payload' => [
                    'mode' => 'single_course',
                    'course_id' => $course->id,
                    'course_slug' => $course->slug,
                    'amount_toman' => $price,
                    'user_id' => Auth::id(),
                    'first_name' => $firstName,
                    'last_name' => $lastName,
                    'phone' => $normalizedPhone,
                ],
            ]);

            return redirect()->away('https://gateway.zibal.ir/start/' . $trackId);
        }

        return back()->with('error', 'خطا در اتصال به درگاه پرداخت: ' . ($result['message'] ?? 'نامشخص'));
    }

    /**
     * Handle subscription checkout from single course page.
     */
    public function requestSubscriptionZibal(Request $request, Course $course)
    {
        if (!in_array($course->access_type, ['subscription', 'both'])) {
            return back()->with('error', 'خرید اشتراک برای این دوره فعال نیست.');
        }

        $request->validate([
            'subscription_plan_id' => 'required|exists:subscription_plans,id',
            'first_name' => 'nullable|string|max:80',
            'last_name' => 'nullable|string|max:80',
            'phone' => 'nullable|string|max:20',
        ]);

        $planId = (int) $request->input('subscription_plan_id');
        $plan = SubscriptionPlan::findOrFail($planId);

        $pivot = $course->subscriptionPlans()->where('subscription_plan_id', $planId)->first();
        $price = $pivot && (int) $pivot->pivot->price > 0
            ? (int) $pivot->pivot->price
            : SubscriptionSettingController::getPlanPrice($plan->slug);

        if ($price <= 0) {
            return back()->with('error', 'قیمت اشتراک برای این دوره تنظیم نشده است. لطفا با مدیریت تماس بگیرید.');
        }

        $amountInRials = $price * 10;

        if ($amountInRials <= 0) {
            return back()->with('error', 'مبلغ پرداخت معتبر نیست!');
        }

        $firstName = trim((string) $request->input('first_name', ''));
        $lastName = trim((string) $request->input('last_name', ''));
        $normalizedPhone = $this->normalizePhone((string) $request->input('phone', ''));

        if (!Auth::check() && !preg_match('/^09\d{9}$/', $normalizedPhone)) {
            return back()->with('error', 'شماره موبایل معتبر نیست.');
        }

        $response = Http::post('https://gateway.zibal.ir/v1/request', [
            'merchant' => env('ZIBAL_MERCHENT'),
            'amount' => $amountInRials,
            'callbackUrl' => route('payment.callback'),
            'description' => 'خرید اشتراک (' . $course->title . ') - پلن #' . $planId,
            'orderId' => 'subscription_course_' . $course->id . '_' . $planId . '_' . time(),
        ]);

        $result = $response->json();

        if (isset($result['result']) && (int) $result['result'] === 100 && isset($result['trackId'])) {
            $trackId = $result['trackId'];

            session([
                'zibal_trackId' => $trackId,
                'zibal_expected_amount' => $amountInRials,
                'checkout_payload' => [
                    'mode' => 'subscription',
                    'course_id' => $course->id,
                    'subscription_plan_id' => $planId,
                    'amount_toman' => $price,
                    'user_id' => Auth::id(),
                    'first_name' => $firstName,
                    'last_name' => $lastName,
                    'phone' => $normalizedPhone,
                ],
            ]);

            return redirect()->away('https://gateway.zibal.ir/start/' . $trackId);
        }

        return back()->with('error', 'خطا در اتصال به درگاه پرداخت: ' . ($result['message'] ?? 'نامشخص'));
    }

    /**
     * Handle global subscription checkout from subscription plans page.
     */
    public function requestPlanSubscriptionZibal(Request $request)
    {
        $request->validate([
            'subscription_plan_id' => 'required|exists:subscription_plans,id',
            'first_name' => Auth::check() ? 'nullable|string|max:80' : 'required|string|max:80',
            'last_name' => Auth::check() ? 'nullable|string|max:80' : 'required|string|max:80',
            'phone' => Auth::check() ? 'nullable|string|max:20' : 'required|string|max:20',
        ]);

        $plan = SubscriptionPlan::findOrFail((int) $request->input('subscription_plan_id'));
        $price = SubscriptionSettingController::getPlanPrice($plan->slug);
        $amountInRials = $price * 10;

        if ($amountInRials <= 0) {
            return back()->with('error', 'قیمت این پلن تنظیم نشده است.');
        }

        $firstName = trim((string) $request->input('first_name', ''));
        $lastName = trim((string) $request->input('last_name', ''));
        $normalizedPhone = $this->normalizePhone((string) $request->input('phone', ''));

        if (!Auth::check() && !preg_match('/^09\d{9}$/', $normalizedPhone)) {
            return back()->with('error', 'شماره موبایل معتبر نیست.')->withInput();
        }

        $response = Http::post('https://gateway.zibal.ir/v1/request', [
            'merchant' => env('ZIBAL_MERCHENT'),
            'amount' => $amountInRials,
            'callbackUrl' => route('payment.callback'),
            'description' => 'خرید اشتراک: ' . $plan->name,
            'orderId' => 'subscription_plan_' . $plan->id . '_' . time(),
        ]);

        $result = $response->json();

        if (isset($result['result']) && (int) $result['result'] === 100 && isset($result['trackId'])) {
            $trackId = $result['trackId'];

            session([
                'zibal_trackId' => $trackId,
                'zibal_expected_amount' => $amountInRials,
                'checkout_payload' => [
                    'mode' => 'subscription',
                    'subscription_plan_id' => $plan->id,
                    'amount_toman' => $price,
                    'user_id' => Auth::id(),
                    'first_name' => $firstName,
                    'last_name' => $lastName,
                    'phone' => $normalizedPhone,
                ],
            ]);

            return redirect()->away('https://gateway.zibal.ir/start/' . $trackId);
        }

        return back()->with('error', 'خطا در اتصال به درگاه پرداخت: ' . ($result['message'] ?? 'نامشخص'))->withInput();
    }

    /**
     * Handle payment callback from Zibal.
     */
    public function callback()
    {
        $trackId = request('trackId');
        $success = request('success');
        $payload = session('checkout_payload', []);
        $mode = $payload['mode'] ?? 'cart';

        $expectedTrackId = session('zibal_trackId');
        $expectedAmount = (int) session('zibal_expected_amount', 0);

        if ((int) $success !== 1 || empty($trackId)) {
            return $this->failedRedirect($mode, $payload, 'پرداخت کنسل شد یا ناموفق بود.');
        }

        if ((string) $trackId !== (string) $expectedTrackId) {
            return $this->failedRedirect($mode, $payload, 'اطلاعات پرداخت نامعتبر است.');
        }

        $verifyResponse = Http::post('https://gateway.zibal.ir/v1/verify', [
            'merchant' => 'zibal',
            'trackId' => $trackId,
        ]);
        $verifyResult = $verifyResponse->json();

        $verified = isset($verifyResult['result'], $verifyResult['status'], $verifyResult['amount'])
            && (int) $verifyResult['result'] === 100
            && (int) $verifyResult['status'] === 1
            && (int) $verifyResult['amount'] === $expectedAmount;

        if (!$verified) {
            return $this->failedRedirect($mode, $payload, 'پرداخت تأیید نشد. لطفا مجدد تلاش کنید.');
        }

        try {
            if ($mode === 'single_course') {
                $user = DB::transaction(function () use ($payload, $trackId) {
                    $course = Course::findOrFail($payload['course_id']);
                    $amount = (int) ($payload['amount_toman'] ?? $this->courseFinalPrice($course));

                    $user = $this->resolveCheckoutUser($payload);

                    Enrollment::firstOrCreate(
                        [
                            'user_id' => $user->id,
                            'course_id' => $course->id,
                        ],
                        [
                            'price' => $amount,
                            'status' => 'completed',
                        ]
                    );

                    Payment::firstOrCreate(
                        [
                            'user_id' => $user->id,
                            'course_id' => $course?->id,
                            'transaction_id' => (string) $trackId,
                        ],
                        [
                            'amount' => $amount,
                            'payment_method' => 'zibal',
                            'status' => 'completed',
                        ]
                    );

                    // SendSuccessPaymentSmsJob::dispatch($user->phone,$course->title ,$user->name);



                    return $user;
                });

                if (!Auth::check() || Auth::id() !== $user->id) {
                    Auth::login($user);
                }


                $this->clearCheckoutSession();


                return redirect('/dashboard')
                    ->with('success', 'پرداخت موفق بود. حساب کاربری شما ایجاد/فعال شد و دوره به حساب شما اضافه شد.');


            }

            if ($mode === 'subscription') {
                $user = DB::transaction(function () use ($payload, $trackId) {
                    $course = !empty($payload['course_id']) ? Course::findOrFail($payload['course_id']) : null;
                    $planId = $payload['subscription_plan_id'];
                    $price = (int) ($payload['amount_toman'] ?? 0);

                    $user = $this->resolveCheckoutUser($payload);

                    if ($course) {
                        Payment::firstOrCreate(
                            [
                                'user_id' => $user->id,
                                'course_id' => $course->id,
                                'transaction_id' => (string) $trackId,
                            ],
                            [
                                'amount' => $price,
                                'payment_method' => 'zibal',
                                'status' => 'completed',
                            ]
                        );
                    }

                    // create subscription
                    $plan = SubscriptionPlan::findOrFail($planId);
                    $start = now();
                    $end = $start->copy()->addDays($plan->duration_days);

                    Subscription::updateOrCreate(
                        [
                            'user_id' => $user->id,
                            'status' => 'active',
                        ],
                        [
                            'subscription_plan_id' => $plan->id,
                            'start_date' => $start,
                            'end_date' => $end,
                            'amount' => $price,
                            'transaction_id' => (string) $trackId,
                            'payment_method' => 'zibal',
                        ]
                    );

                    // enroll user to this course if course allows subscription access
                    if ($course && in_array($course->access_type, ['subscription', 'both'])) {
                        Enrollment::firstOrCreate(
                            [
                                'user_id' => $user->id,
                                'course_id' => $course->id,
                            ],
                            [
                                'price' => $price,
                                'status' => 'completed',
                            ]
                        );
                    }

                    return $user;
                });

                if (!Auth::check() || Auth::id() !== $user->id) {
                    Auth::login($user);
                }

                $this->clearCheckoutSession();

                return redirect('/dashboard')
                    ->with('success', 'اشتراک با موفقیت خریداری شد و دسترسی فعال شد.');
            }

            // Cart checkout flow
            $userId = $payload['user_id'] ?? Auth::id();
            if (!$userId) {
                $this->clearCheckoutSession();
                return redirect()->route('home')->with('error', 'جلسه پرداخت معتبر نیست. لطفا دوباره تلاش کنید.');
            }

            DB::transaction(function () use ($userId, $trackId) {
                $cartItems = Cart::with('course')->where('user_id', $userId)->get();

                foreach ($cartItems as $item) {
                    $amount = $this->courseFinalPrice($item->course);

                    Payment::firstOrCreate(
                        [
                            'user_id' => $userId,
                            'course_id' => $item->course_id,
                            'transaction_id' => (string) $trackId,
                        ],
                        [
                            'amount' => $amount,
                            'payment_method' => 'zibal',
                            'status' => 'completed',
                        ]
                    );

                    Enrollment::firstOrCreate(
                        [
                            'user_id' => $userId,
                            'course_id' => $item->course_id,
                        ],
                        [
                            'price' => $amount,
                            'status' => 'completed',
                        ]
                    );
                }

                Cart::where('user_id', $userId)->delete();
            });

            $this->clearCheckoutSession();

            return redirect('/dashboard')
                ->with('success', 'پرداخت با موفقیت انجام شد! دوره‌ها به حساب شما اضافه شدند.');
        } catch (\Throwable $e) {
            report($e);
            return $this->failedRedirect($mode, $payload, 'خطا در ثبت سفارش. لطفا با پشتیبانی تماس بگیرید.');
        }
    }

    private function resolveCheckoutUser(array $payload): User
    {
        $payloadUserId = $payload['user_id'] ?? null;
        if ($payloadUserId) {
            $user = User::find($payloadUserId);
            if ($user) {
                if (!empty($payload['phone']) && empty($user->phone)) {
                    $user->update(['phone' => $this->normalizePhone((string) $payload['phone'])]);
                }
                return $user;
            }
        }

        $phone = $this->normalizePhone((string) ($payload['phone'] ?? ''));
        if (preg_match('/^09\d{9}$/', $phone)) {
            $existing = User::where('phone', $phone)->first();
            if ($existing) {
                return $existing;
            }
        }

        $firstName = trim((string) ($payload['first_name'] ?? ''));
        $lastName = trim((string) ($payload['last_name'] ?? ''));
        $fullName = trim($firstName . ' ' . $lastName);
        if ($fullName === '') {
            $fullName = 'کاربر جدید';
        }

        $baseEmail = $phone !== '' ? 'guest_' . $phone . '@noemail.local' : 'guest_' . Str::lower(Str::random(12)) . '@noemail.local';
        $email = $baseEmail;
        while (User::where('email', $email)->exists()) {
            $email = 'guest_' . Str::lower(Str::random(10)) . '@noemail.local';
        }

        return User::create([
            'name' => $fullName,
            'phone' => $phone !== '' ? $phone : null,
            'email' => $email,
            'password' => Hash::make(Str::random(16)),
        ]);
    }

    private function courseFinalPrice(Course $course): int
    {
        $regular = (int) $course->regular_price;
        $sale = (int) ($course->sale_price ?? 0);

        return ($sale > 0 && $sale < $regular) ? $sale : $regular;
    }

    private function normalizePhone(string $phone): string
    {
        $converted = str_replace(
            ['۰', '۱', '۲', '۳', '۴', '۵', '۶', '۷', '۸', '۹'],
            ['0', '1', '2', '3', '4', '5', '6', '7', '8', '9'],
            $phone
        );

        $digits = preg_replace('/\D+/', '', $converted) ?? '';

        if (Str::startsWith($digits, '98') && strlen($digits) === 12) {
            $digits = '0' . substr($digits, 2);
        }

        if (Str::startsWith($digits, '0098') && strlen($digits) === 14) {
            $digits = '0' . substr($digits, 4);
        }

        return $digits;
    }

    private function failedRedirect(string $mode, array $payload, string $message)
    {
        if ($mode === 'single_course' && !empty($payload['course_slug'])) {
            return redirect()->route('course.show', $payload['course_slug'])->with('error', $message);
        }

        if ($mode === 'subscription') {
            return redirect()->route('subscription.index')->with('error', $message);
        }

        return redirect('/cart')->with('error', $message);
    }

    private function clearCheckoutSession(): void
    {
        session()->forget([
            'zibal_trackId',
            'zibal_expected_amount',
            'checkout_payload',
        ]);
    }

    /**
     * Handle free course enrollment directly without payment gateway
     */
    private function enrollFreeCourse(Request $request, Course $course)
    {
        try {
            $user = DB::transaction(function () use ($request, $course) {
                $firstName = trim((string) $request->input('first_name', ''));
                $lastName = trim((string) $request->input('last_name', ''));
                $normalizedPhone = $this->normalizePhone((string) $request->input('phone', ''));

                if (Auth::check()) {
                    $user = Auth::user();
                    $parts = explode(' ', trim((string) $user->name), 2);
                    $firstName = $firstName !== '' ? $firstName : ($parts[0] ?? '');
                    $lastName = $lastName !== '' ? $lastName : ($parts[1] ?? '');
                    $normalizedPhone = $normalizedPhone !== '' ? $normalizedPhone : $this->normalizePhone((string) ($user->phone ?? ''));

                    // بررسی اینکه آیا قبلاً ثبت نام کرده یا نه
                    $alreadyEnrolled = Enrollment::where('user_id', $user->id)
                        ->where('course_id', $course->id)
                        ->exists();
                    if ($alreadyEnrolled) {
                        return $user;
                    }
                } else {
                    // کاربر مهمان است - حساب بسازیم
                    if (!preg_match('/^09\d{9}$/', $normalizedPhone)) {
                        abort(422, 'شماره موبایل معتبر نیست.');
                    }

                    $user = $this->resolveCheckoutUser([
                        'phone' => $normalizedPhone,
                        'first_name' => $firstName,
                        'last_name' => $lastName,
                    ]);
                }

                // Enrollment ایجاد کنید
                Enrollment::firstOrCreate(
                    [
                        'user_id' => $user->id,
                        'course_id' => $course->id,
                    ],
                    [
                        'price' => 0,
                        'status' => 'completed',
                    ]
                );

                return $user;
            });

            if (!Auth::check() || Auth::id() !== $user->id) {
                Auth::login($user);
            }

            return redirect('/dashboard')
                ->with('success', 'ثبت‌نام در دوره رایگان با موفقیت انجام شد!');
        } catch (\Throwable $e) {
            report($e);
            return back()->with('error', 'خطا در ثبت‌نام. لطفا مجدد تلاش کنید.');
        }
    }
}

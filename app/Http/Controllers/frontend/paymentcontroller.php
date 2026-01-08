<?php

namespace App\Http\Controllers\frontend;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use App\Models\Cart;
use App\Models\enrollment;
use App\Models\Payment;
use Illuminate\Support\Facades\DB;

class PaymentController extends Controller
{
    public function request_zibal()
    {
        $userId = Auth::id();

        if (!Cart::where('user_id', $userId)->exists()) {
            return back()->with('error', 'سبد خرید شما خالی است!');
        }

        $totals = Cart::calculateCartTotals($userId);

        $amountInRials = $totals['finalPrice'] * 10; // تومان به ریال

        if ($amountInRials <= 0) {
            return back()->with('error', 'مبلغ پرداخت معتبر نیست!');
        }

        $response = Http::post('https://gateway.zibal.ir/v1/request', [
            'merchant'    => 'zibal', // در پروداکشن merchant واقعی بذار
            'amount'      => $amountInRials,
            'callbackUrl' => route('payment.callback'),
            'description' => 'پرداخت سبد خرید دوره‌های آموزشی',
            'orderId'     => 'order_' . $userId . '_' . time(), // اختیاری اما خوبه برای شناسایی
        ]);

        $result = $response->json();

        if (isset($result['result']) && $result['result'] == 100 && isset($result['trackId'])) {
            $trackId = $result['trackId'];

            // ذخیره موقت trackId و مبلغ برای verify بعدی
            session([
                'zibal_trackId' => $trackId,
                'zibal_expected_amount' => $amountInRials,
            ]);

            return redirect()->away('https://gateway.zibal.ir/start/' . $trackId);
        }

        return back()->with('error', 'خطا در اتصال به درگاه پرداخت: ' . ($result['message'] ?? 'نامشخص'));
    }

    // متد کال‌بک زیبال
    public function callback()
    {
        $trackId = request('trackId');
        $success = request('success'); // 1 = موفق، 0 = ناموفق یا کنسل
        $statusCode = request('status'); // کد وضعیت زیبال

        $userId = Auth::id();

        // اگر کاربر پرداخت رو کنسل کرده یا خطا داده
        if ($success != 1 || empty($trackId)) {
            return redirect('/cart')->with('error', 'پرداخت کنسل شد یا ناموفق بود.');
        }

        // گرفتن اطلاعات ذخیره شده از سشن
        $expectedTrackId = session('zibal_trackId');
        $expectedAmount = session('zibal_expected_amount');

        if ($trackId != $expectedTrackId) {
            return redirect('/cart')->with('error', 'اطلاعات پرداخت نامعتبر است.');
        }

        // درخواست verify به زیبال
        $verifyResponse = Http::post('https://gateway.zibal.ir/v1/verify', [
            'merchant' => 'zibal',
            'trackId'  => $trackId,
        ]);

        $verifyResult = $verifyResponse->json();

        // بررسی موفقیت verify
        if (
            isset($verifyResult['result']) &&
            $verifyResult['result'] == 100 &&
            isset($verifyResult['status']) &&
            $verifyResult['status'] == 1 && // پرداخت موفق
            $verifyResult['amount'] == $expectedAmount
        ) {
            // شروع تراکنش دیتابیس برای امنیت
            DB::transaction(function () use ($userId, $verifyResult) {
                $cartItems = Cart::with('course')->where('user_id', $userId)->get();

                foreach ($cartItems as $item) {
                    Payment::create([
                        'user_id'        => $userId,
                        'course_id'      => $item->course_id,
                        'amount'         => $item->course->sale_price > 0 ? $item->course->sale_price : $item->course->regular_price, // به تومان
                        'payment_method' => 'zibal',
                        'status'         => 'completed',
                    ]);
                    enrollment::create([
                        'user_id'=>$userId,
                        'course_id'=>$item->course_id,
                        'price'=> $item->course->sale_price > 0 ? $item->course->sale_price : $item->course->regular_price,
                        'status'=>'completed'
                    ]);
                }

                // خالی کردن سبد خرید
                Cart::where('user_id', $userId)->delete();
            });

            // پاک کردن سشن
            session()->forget(['zibal_trackId', 'zibal_expected_amount']);



            return redirect('/dashboard')->with('success', 'پرداخت با موفقیت انجام شد! دوره‌ها به حساب شما اضافه شدند.');
        }

        // اگر verify ناموفق بود (تقلب، مبلغ تغییر کرده و ...)
        return redirect('/cart')->with('error', 'پرداخت تأیید نشد. لطفاً مجدد تلاش کنید یا با پشتیبانی تماس بگیرید.');
    }
}

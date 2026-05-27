<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Enrollment;
use App\Models\Payment;
use App\Models\Subscription;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Lesson;
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
        $items=Enrollment::query()->where('user_id','=',$userId)->with('course')->get();

        return view('user.courses',compact('items'));


    }


    /**
     * view payments User Lists
     *
     * @return view
     */

    public function payments(){
        $userId=Auth::id();
        $paymentRecords = Payment::query()
            ->where('user_id','=',$userId)
            ->with(['course', 'subscription.subscriptionPlan'])
            ->orderBy('created_at','desc')
            ->get();

        $paymentTransactionIds = $paymentRecords
            ->pluck('transaction_id')
            ->filter()
            ->map(fn ($transactionId) => (string) $transactionId)
            ->all();

        $subscriptionsWithoutPayment = Subscription::query()
            ->where('user_id', $userId)
            ->whereNotNull('transaction_id')
            ->when(!empty($paymentTransactionIds), function ($query) use ($paymentTransactionIds) {
                $query->whereNotIn('transaction_id', $paymentTransactionIds);
            })
            ->with('subscriptionPlan')
            ->get();

        $transactions = $paymentRecords
            ->map(function (Payment $payment) {
                $subscription = $payment->subscription;

                return (object) [
                    'id' => $payment->transaction_id ?: $payment->id,
                    'status' => $payment->status,
                    'type' => $subscription ? 'subscription' : 'course',
                    'type_label' => $subscription ? 'خرید اشتراک' : 'خرید دوره آموزشی',
                    'title' => $subscription
                        ? ($subscription->subscriptionPlan->name ?? 'اشتراک')
                        : ($payment->course->title ?? 'دوره حذف شده'),
                    'subtitle' => $subscription && $payment->course
                        ? 'برای دوره: ' . $payment->course->title
                        : null,
                    'amount' => $payment->amount,
                    'created_at' => $payment->created_at,
                ];
            })
            ->merge($subscriptionsWithoutPayment->map(function (Subscription $subscription) {
                return (object) [
                    'id' => $subscription->transaction_id ?: $subscription->id,
                    'status' => $subscription->status === 'active' ? 'completed' : $subscription->status,
                    'type' => 'subscription',
                    'type_label' => 'خرید اشتراک',
                    'title' => $subscription->subscriptionPlan->name ?? 'اشتراک',
                    'subtitle' => $subscription->end_date ? 'اعتبار تا ' . verta($subscription->end_date)->format('j F Y') : null,
                    'amount' => $subscription->amount,
                    'created_at' => $subscription->created_at,
                ];
            }))
            ->sortByDesc('created_at')
            ->values();

        return view('user.payments',compact('transactions'));

    }



    /**
     * view profile data user
     *
     * @return view
     */

    public function profile(){


        return view('user.profile');
    }




}

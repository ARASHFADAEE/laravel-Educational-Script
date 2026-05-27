<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Payment;
use App\Models\Subscription;
use App\Models\User;
use App\Models\Course;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Redirect;

class PaymentController extends Controller
{


    /**
     * Show List Payments in Admin Panel
     *
     * @return view
     */

    public function index(){


     $paymentRecords = Payment::with([
         'user:id,name',
         'course:id,title',
         'subscription.subscriptionPlan'
     ])
     ->orderBy('created_at', 'desc')
     ->get();

     $paymentTransactionIds = $paymentRecords
         ->pluck('transaction_id')
         ->filter()
         ->map(fn ($transactionId) => (string) $transactionId)
         ->all();

     $subscriptionsWithoutPayment = Subscription::query()
         ->whereNotNull('transaction_id')
         ->when(!empty($paymentTransactionIds), function ($query) use ($paymentTransactionIds) {
             $query->whereNotIn('transaction_id', $paymentTransactionIds);
         })
         ->with(['user:id,name', 'subscriptionPlan'])
         ->get();

     $transactions = $paymentRecords
         ->map(function (Payment $payment) {
             $subscription = $payment->subscription;

             return (object) [
                 'id' => $payment->id,
                 'tracking_id' => $payment->transaction_id ?: $payment->id,
                 'record_type' => 'payment',
                 'transaction_type' => $subscription ? 'subscription' : 'course',
                 'transaction_type_label' => $subscription ? 'خرید اشتراک' : 'خرید دوره تکی',
                 'buyer_name' => $payment->user->name ?? 'کاربر حذف شده',
                 'title' => $subscription
                     ? ($subscription->subscriptionPlan->name ?? 'اشتراک')
                     : ($payment->course->title ?? 'دوره حذف شده'),
                 'subtitle' => $subscription && $payment->course
                     ? 'برای دوره: ' . $payment->course->title
                     : null,
                 'status' => $payment->status,
                 'created_at' => $payment->created_at,
                 'editable' => true,
             ];
         })
         ->merge($subscriptionsWithoutPayment->map(function (Subscription $subscription) {
             return (object) [
                 'id' => $subscription->id,
                 'tracking_id' => $subscription->transaction_id ?: $subscription->id,
                 'record_type' => 'subscription',
                 'transaction_type' => 'subscription',
                 'transaction_type_label' => 'خرید اشتراک',
                 'buyer_name' => $subscription->user->name ?? 'کاربر حذف شده',
                 'title' => $subscription->subscriptionPlan->name ?? 'اشتراک',
                 'subtitle' => $subscription->end_date ? 'اعتبار تا ' . verta($subscription->end_date)->format('j F Y') : null,
                 'status' => $subscription->status === 'active' ? 'completed' : $subscription->status,
                 'created_at' => $subscription->created_at,
                 'editable' => false,
             ];
         }))
         ->sortByDesc('created_at')
         ->values();

     $page = LengthAwarePaginator::resolveCurrentPage();
     $perPage = 10;
     $payments = new LengthAwarePaginator(
         $transactions->forPage($page, $perPage)->values(),
         $transactions->count(),
         $perPage,
         $page,
         [
             'path' => request()->url(),
             'query' => request()->query(),
         ]
     );

             return view('admin.payments.index',compact('payments'));

         }

    /**
     * Show Create Payment in Admin Panel
     *
     * @return view
     */
    public function create()
{
    $users = User::select('id', 'name')->get();
    $courses = Course::select('id', 'title')->get();

    return view('admin.payments.create', compact('users', 'courses'));
}

    /**
     * Handle Payment Form in Admin Panel
     *
     * @return view
     */

    public function store(Request $request)
{
    $validated = $request->validate([
        'user_id' => 'required|exists:users,id',
        'course_id' => 'required|exists:courses,id',
        'amount' => 'required|numeric|min:1000',
        'payment_method' => 'required|in:online,cash,card',
        'status' => 'required|in:pending,completed,failed',
    ]);

    Payment::create($validated);

    return redirect()->route('admin.payments.index')
        ->with('success', 'پرداخت با موفقیت ایجاد شد.');
}

    /**
     * Show Edit Payment in Admin Panel
     *
     * @return view
     */
    public function edit($id)
{
    $payment = Payment::with(['user', 'course'])->findOrFail($id);
    $users = User::select('id', 'name')->get();
    $courses = Course::select('id', 'title')->get();

    return view('admin.payments.edit', compact('payment', 'users', 'courses'));
    }



    /**
     * Handle Update Payment in  Admin Panel
     *
     * @return Redirect(PaymentsLists)
     */

    public function update(Request $request, $id)
{
    $payment = Payment::findOrFail($id);

    $validated = $request->validate([
        'user_id' => 'required|exists:users,id',
        'course_id' => 'required|exists:courses,id',
        'amount' => 'required|numeric|min:1000',
        'payment_method' => 'required|in:online,cash,card',
        'status' => 'required|in:pending,completed,failed',
    ]);

    $payment->update($validated);

    return redirect()->route('admin.payments.index')
        ->with('success', 'پرداخت با موفقیت به‌روزرسانی شد.');
}



    /**
     * Handle Destroy Payment in  Admin Panel
     *
     * @return Redirect(PaymentsLists)
     */

    public function destroy($id){

        $peyment=Payment::query()->findOrFail($id);

        $peyment->delete();


        return redirect()->route('admin.payments.index')->with('success','تاریخچه پرداخت با موفقیت حذف شد ');

    }
}

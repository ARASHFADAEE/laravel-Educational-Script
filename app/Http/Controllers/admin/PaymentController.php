<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Payment;
use App\Models\User;
use App\Models\Course;
use Illuminate\Support\Facades\Redirect;

class PaymentController extends Controller
{


    /**
     * Show List Payments in Admin Panel
     *
     * @return view
     */

    public function index(){


     $payments = Payment::with([
         'user:id,name',
         'course:id,title'
     ])
     ->orderBy('created_at', 'desc')
     ->paginate(10);

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

        $peyment=payment::query()->findOrFail($id);

        $peyment->delete();


        return redirect()->route('admin.payments.index')->with('success','تاریخچه پرداخت با موفقیت حذف شد ');

    }
}

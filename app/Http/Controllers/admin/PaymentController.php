<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\payment;

class PaymentController extends Controller
{
    

    public function index(){


$payments = Payment::with([
    'user:id,name', 
    'course:id,title'
])->paginate(10);
        return view('admin.payments.index',compact('payments'));

    }



    public function edit($id){

        $payment=Payment::query()->findOrFail($id);



    
    }

    public function update(){

    }


    public function destroy($id){

        $peyment=payment::query()->findOrFail($id);

        $peyment->delete();


        return redirect()->route('admin.payments.index')->with('sucsess','تاریخچه پرداخت با موفقیت حذف شد ');

    }
}

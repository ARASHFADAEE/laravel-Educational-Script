<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    public function index(Request $request)
    {
        $submitted = null;

        if ($request->isMethod('post')) {
            $submitted = $request->validate([
                'name' => ['required', 'string', 'max:255'],
                'email' => ['required', 'email', 'max:255'],
                'phone' => ['nullable', 'string', 'max:30'],
                'subject' => ['required', 'string', 'max:255'],
                'project_type' => ['nullable', 'string', 'max:255'],
                'budget' => ['nullable', 'string', 'max:255'],
                'message' => ['required', 'string', 'min:20', 'max:3000'],
            ]);

            return back()
                ->with('success', 'درخواست شما با موفقیت ثبت شد. به زودی با شما در ارتباط خواهیم بود.')
                ->withInput();
        }

        return view('frontend.contact', compact('submitted'));
    }
}

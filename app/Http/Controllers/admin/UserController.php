<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
class UserController extends Controller
{



    public function index()
    {
        $users = User::orderBy('id', 'desc')->paginate(10);



        return view('admin.users.index',compact('users'));
    }

    public function create()
    {
        return view('admin.users.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'role' => 'required|in:admin,user',
            'password' => 'required|string|min:8|confirmed',
            'avatar' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'bio'   => 'required|string|max:600',

        ]);

        $file_path=Storage::disk('public')->put('avatar',$request->file('avatar'));

        User::create([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'role' => $request->input('role'),
            'password' => bcrypt($request->input('password')),
            'avatar'=>$file_path,
            'bio' =>$request->input('bio')
        ]);

        return redirect()->route('admin.users.index')->with('success', 'کاربر با موفقیت ایجاد شد');
    }


    public function edit($id)
    {
        $user = User::findOrFail($id);
        return view('admin.users.edit', compact('user'));
    }


public function update(Request $request, $id)
{
    $user = User::findOrFail($id);

    $validated = $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|email|unique:users,email,' . $user->id,
        'role' => 'required|in:admin,user',
        'password' => 'nullable|string|min:8|confirmed',
        'avatar' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
        'bio'    => 'required|string|max:600',
    ]);

    // مدیریت پسورد (اگر وارد شده بود)
    if ($request->filled('password')) {
        $validated['password'] = bcrypt($request->password);
    } else {
        unset($validated['password']); // پسورد قدیمی حفظ بشه
    }

    // مدیریت آپلود آواتار
    if ($request->hasFile('avatar')) {
        // حذف تصویر قدیمی
        if ($user->avatar && Storage::disk('public')->exists($user->avatar)) {
            Storage::disk('public')->delete($user->avatar);
        }

        // ذخیره تصویر جدید و اضافه کردن مسیر به $validated
        $validated['avatar'] = $request->file('avatar')->store('avatar', 'public');
    }
    // اگر فایل آپلود نشده، avatar از $validated حذف نمی‌شه و مقدار قبلی حفظ می‌شه

    // آپدیت یکجا و تمیز
    $user->update($validated);

    return redirect()->route('admin.users.index')
             ->with('success', 'آپدیت کاربر با موفقیت انجام شد');
}

    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        return redirect()->route('admin.users.index')->with('success', 'کاربر با موفقیت حذف شد');
    }






}

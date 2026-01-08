<?php

namespace App\Http\Controllers\user;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rules;
use App\Models\User;

class UserProfileController extends Controller
{
    /**
     * Display the user's profile page.
     * 
     * @return \Illuminate\View\View
     */
    public function profile()
    {
        // دریافت اطلاعات کاربر فعلی
        $user = Auth::user();
        
        // نمایش صفحه پروفایل با اطلاعات کاربر
        return view('user.profile', compact('user'));
    }

    /**
     * Update the user's profile information.
     * 
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function updateProfile(Request $request)
    {
        // کاربر فعلی
        $user = Auth::user();
        
        // اعتبارسنجی داده‌های ورودی
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'phone' => ['nullable', 'string', 'max:20', 'regex:/^[\d\s\-\+\(\)]+$/'],
            'avatar' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif,webp', 'max:2048'], // 2MB max
        ], [
            'name.required' => 'وارد کردن نام الزامی است.',
            'name.string' => 'نام باید متن باشد.',
            'name.max' => 'نام نمی‌تواند بیشتر از ۲۵۵ کاراکتر باشد.',
            'phone.string' => 'شماره تلفن باید متن باشد.',
            'phone.max' => 'شماره تلفن نمی‌تواند بیشتر از ۲۰ کاراکتر باشد.',
            'phone.regex' => 'فرمت شماره تلفن معتبر نیست.',
            'avatar.image' => 'فایل باید تصویر باشد.',
            'avatar.mimes' => 'فرمت تصویر باید یکی از موارد jpeg, png, jpg, gif, webp باشد.',
            'avatar.max' => 'حجم تصویر نمی‌تواند بیشتر از ۲ مگابایت باشد.',
        ]);

        try {
            // آپدیت اطلاعات پایه
            $user->name = $validated['name'];
            $user->phone = $validated['phone'] ?? null;

            // آپلود آواتار
            if ($request->hasFile('avatar')) {
                // حذف آواتار قبلی اگر وجود دارد
                if ($user->avatar && Storage::disk('public')->exists($user->avatar)) {
                    Storage::disk('public')->delete($user->avatar);
                }
                
                // ذخیره آواتار جدید
                $avatarPath = $request->file('avatar')->store('avatars', 'public');
                $user->avatar = $avatarPath;
            }

            // ذخیره تغییرات
            $user->save();

            // بازگشت با پیام موفقیت
            return back()->with([
                'success' => 'اطلاعات پروفایل با موفقیت بروزرسانی شد.',
                'tab' => 'tabOne' // بازگشت به تب اول
            ]);

        } catch (\Exception $e) {
            // در صورت خطا
            return back()->with([
                'error' => 'خطایی در بروزرسانی اطلاعات رخ داد. لطفاً مجدداً تلاش کنید.',
                'tab' => 'tabOne'
            ]);
        }
    }

    /**
     * Update the user's password.
     * 
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function updatePassword(Request $request)
    {
        // کاربر فعلی
        $user = Auth::user();
        
        // اعتبارسنجی داده‌های ورودی
        $validated = $request->validate([
            'current_password' => ['required', 'current_password'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ], [
            'current_password.required' => 'وارد کردن رمز عبور فعلی الزامی است.',
            'current_password.current_password' => 'رمز عبور فعلی نادرست است.',
            'password.required' => 'وارد کردن رمز عبور جدید الزامی است.',
            'password.confirmed' => 'تکرار رمز عبور مطابقت ندارد.',
            'password.min' => 'رمز عبور باید حداقل ۸ کاراکتر باشد.',
        ]);

        try {
            // آپدیت رمز عبور
            $user->password = Hash::make($validated['password']);
            $user->save();

            // بازگشت با پیام موفقیت
            return back()->with([
                'success' => 'رمز عبور با موفقیت تغییر یافت.',
                'tab' => 'tabTwo' // بازگشت به تب دوم
            ]);

        } catch (\Exception $e) {
            // در صورت خطا
            return back()->with([
                'error' => 'خطایی در تغییر رمز عبور رخ داد. لطفاً مجدداً تلاش کنید.',
                'tab' => 'tabTwo'
            ]);
        }
    }

    /**
     * Delete the user's avatar.
     * 
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse
     */
    public function deleteAvatar(Request $request)
    {
        // کاربر فعلی
        $user = Auth::user();
        
        try {
            // حذف آواتار
            if ($user->avatar && Storage::disk('public')->exists($user->avatar)) {
                Storage::disk('public')->delete($user->avatar);
                $user->avatar = null;
                $user->save();
            }

            // اگر درخواست AJAX باشد
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => 'تصویر پروفایل با موفقیت حذف شد.'
                ]);
            }

            // بازگشت با پیام موفقیت
            return back()->with([
                'success' => 'تصویر پروفایل با موفقیت حذف شد.',
                'tab' => 'tabOne'
            ]);

        } catch (\Exception $e) {
            // در صورت خطا
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'خطایی در حذف تصویر رخ داد.'
                ], 500);
            }

            return back()->with([
                'error' => 'خطایی در حذف تصویر رخ داد.',
                'tab' => 'tabOne'
            ]);
        }
    }

    /**
     * Get user profile data for API.
     * 
     * @return \Illuminate\Http\JsonResponse
     */
    public function getProfileData()
    {
        $user = Auth::user();
        
        return response()->json([
            'success' => true,
            'data' => [
                'name' => $user->name,
                'email' => $user->email,
                'phone' => $user->phone,
                'avatar' => $user->avatar ? Storage::url($user->avatar) : null,
                'role' => $user->role,
                'email_verified' => !is_null($user->email_verified_at),
                'created_at' => $user->created_at->format('Y-m-d H:i:s'),
            ]
        ]);
    }

    /**
     * Validate current password for sensitive operations.
     * 
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function validateCurrentPassword(Request $request)
    {
        $request->validate([
            'current_password' => ['required', 'current_password'],
        ]);

        return response()->json([
            'success' => true,
            'message' => 'رمز عبور فعلی صحیح است.'
        ]);
    }

    /**
     * Update user's notification preferences.
     * 
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function updateNotifications(Request $request)
    {
        // کاربر فعلی
        $user = Auth::user();
        
        // اعتبارسنجی داده‌های ورویی
        $validated = $request->validate([
            'notifications' => ['nullable', 'array'],
            'notifications.*' => ['boolean'],
        ]);

        // در اینجا می‌توانید تنظیمات نوتیفیکیشن را ذخیره کنید
        // به عنوان مثال در جدول جداگانه یا در فیلد JSON

        return back()->with([
            'success' => 'تنظیمات اعلان‌ها با موفقیت بروزرسانی شد.',
            'tab' => 'tabFour'
        ]);
    }
}
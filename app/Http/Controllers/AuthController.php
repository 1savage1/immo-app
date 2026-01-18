<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    /**
     * ✅ تسجيل حساب جديد (POST /register)
     */
    public function register(Request $request)
    {
        // ✅ تحقق من البيانات القادمة من الفورم
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', 'unique:users,email'],
            'password' => ['required', 'string', 'min:6', 'confirmed'],
        ]);

        // ✅ إنشاء المستخدم في قاعدة البيانات
        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            // ✅ تشفير كلمة السر
            'password' => Hash::make($data['password']),
        ]);

        // ✅ تسجيل الدخول مباشرة بعد التسجيل
        Auth::login($user);

        // ✅ تحويل للصفحة الرئيسية
        return redirect()->route('home');
    }

    /**
     * ✅ تسجيل الدخول (POST /login)
     */
    public function login(Request $request)
    {
        // ✅ تحقق من بيانات الدخول
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required', 'string'],
        ]);

        // ✅ محاولة تسجيل الدخول
        if (Auth::attempt($credentials)) {
            // ✅ حماية: تجديد الجلسة
            $request->session()->regenerate();
            return redirect()->route('home');
        }

        // ✅ إذا البيانات خطأ نرجع بنفس الصفحة مع رسالة
        return back()->withErrors([
            'email' => 'بيانات الدخول غير صحيحة.',
        ])->onlyInput('email');
    }

    /**
     * ✅ تسجيل الخروج (POST /logout)
     */
    public function logout(Request $request)
    {
        Auth::logout();

        // ✅ تنظيف الجلسة لأمان أكثر
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('home');
    }
}

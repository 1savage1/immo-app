<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PropertyController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Admin\AdminPropertyController;

// ===============================
// ✅ صفحات العرض الرئيسية (Public)
// ===============================
Route::get('/', [PropertyController::class, 'index'])->name('home');
Route::get('/vente', [PropertyController::class, 'vente'])->name('vente');
Route::get('/location', [PropertyController::class, 'location'])->name('location');

// ===============================
// ✅ Routes Auth (login/register/logout)
// ===============================

// ✅ عرض صفحة login
Route::get('/login', function () {
    return view('auth.login');
})->name('login');

// ✅ تنفيذ login (POST)
Route::post('/login', [AuthController::class, 'login'])->name('login.post');

// ✅ عرض صفحة register
Route::get('/register', function () {
    return view('auth.register');
})->name('register');

// ✅ تنفيذ register (POST)
Route::post('/register', [AuthController::class, 'register'])->name('register.post');

// ✅ تنفيذ logout (POST)
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// ===============================
// ✅ Routes تحتاج تسجيل دخول (User)
// ===============================
Route::middleware('auth')->group(function () {

    // ✅ صفحة تعرض للمستخدم كل إعلاناته (حتى pending)
    Route::get('/mes-biens', [PropertyController::class, 'mine'])->name('properties.mine');

    // ✅ صفحة فورم إضافة عقار
    // ✅ لازم تكون قبل /properties/{property} باش ما تصراش مشكلة 404
    Route::get('/properties/create', [PropertyController::class, 'create'])->name('properties.create');

    // ✅ إرسال الفورم (حفظ العقار + رفع الصور)
    Route::post('/properties', [PropertyController::class, 'store'])->name('properties.store');
});

// ===============================
// ✅ صفحة تفاصيل عقار (Public)
// ===============================

// ✅ نخليها لآخر + نفرض أن الـ {property} رقم فقط
Route::get('/properties/{property}', [PropertyController::class, 'show'])
    ->whereNumber('property') // ✅ يمنع كلمات مثل create
    ->name('properties.show');

// ===============================
// ✅ Admin Routes (لازم auth + admin)
// ===============================
Route::middleware(['auth', 'admin'])
    ->prefix('admin')
    ->group(function () {

        // ✅ قائمة العقارات pending
        Route::get('/properties/pending', [AdminPropertyController::class, 'pending'])
            ->name('admin.properties.pending');

        // ✅ تفاصيل العقار للأدمن (حتى لو كان pending)
        // ✅ هذا هو التعديل المهم باش زر Details يخدم
        Route::get('/properties/{property}', [AdminPropertyController::class, 'show'])
            ->whereNumber('property')
            ->name('admin.properties.show');

        // ✅ موافقة الأدمن على عقار
        Route::post('/properties/{property}/approve', [AdminPropertyController::class, 'approve'])
            ->whereNumber('property')
            ->name('admin.properties.approve');

        // ✅ رفض العقار
        Route::post('/properties/{property}/reject', [AdminPropertyController::class, 'reject'])
            ->whereNumber('property')
            ->name('admin.properties.reject');
    });

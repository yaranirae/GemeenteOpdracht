<?php

use App\Http\Controllers\ComplaintController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\MapController;
use App\Http\Controllers\Auth\LoginController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

// تسجيل الدخول والخروج
Route::get('login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('login', [LoginController::class, 'login']);
Route::post('logout', [LoginController::class, 'logout'])->name('logout');

// الصفحة الرئيسية
Route::get('/', function () {
    return view('welcome');
});

// ✅ أضف هذا السطر - سياسة الخصوصية (خارج الـ admin)
Route::get('/privacy-beleid', [AdminController::class, 'privacyPolicy'])->name('privacy.policy');

// خريطة الموقع
Route::get('/map', [MapController::class, 'showMap'])->name('map.show');
Route::post('/geocode', [MapController::class, 'geocodeAddress'])->name('geocode');
Route::post('/reverse-geocode', [MapController::class, 'reverseGeocode'])->name('reverse.geocode');

// مسارات الشكاوى العامة
Route::prefix('klachten')->group(function () {
    Route::get('/', [ComplaintController::class, 'index'])->name('complaints.index');
    Route::get('/aanmaken', [ComplaintController::class, 'create'])->name('complaints.create');
    Route::post('/', [ComplaintController::class, 'store'])->name('complaints.store');
    Route::get('/bedankt', [ComplaintController::class, 'thankyou'])->name('complaints.thankyou');
    Route::get('/aanmaken/terug', [ComplaintController::class, 'reopen'])->name('complaints.reopen');

});

// مسارات إدارة الشكاوى (للمستخدمين العاديين)
Route::prefix('complaints')->group(function () {
    Route::post('/{id}/update-status', [ComplaintController::class, 'updateStatus'])->name('complaints.updateStatus');
    Route::post('/{id}/send-message', [ComplaintController::class, 'sendCustomMessage'])->name('complaints.sendMessage');
    Route::delete('/{id}/delete-photo', [ComplaintController::class, 'deletePhoto'])->name('complaints.deletePhoto');
});

// مسارات الأدمن (محمي بالـ middleware)
Route::prefix('admin')->middleware(['auth'])->group(function () {
    // Dashboard
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
    Route::get('/data-management', [AdminController::class, 'dataManagement'])->name('admin.data-management');
    Route::post('/data-cleanup', [AdminController::class, 'executeDataCleanup'])->name('admin.execute-data-cleanup');
    Route::post('/data-deletion', [AdminController::class, 'executeDataDeletion'])->name('admin.execute-data-delete');

    // Route::post('/data-cleanup', function() {
//     $controller = new App\Http\Controllers\AdminController();
//     $result = $controller->autoAnonymizeOldData();

    //     return redirect()->back()->with('success', "تم تجهيل {$result} مشتكي");
// });
    // إدارة الشكاوى
    Route::prefix('complaints')->group(function () {
        Route::get('/', [AdminController::class, 'complaints'])->name('admin.complaints');
        Route::get('/{id}', [AdminController::class, 'showComplaint'])->name('admin.complaints.show'); // تم التصحيح هنا
        Route::post('/{id}/status', [AdminController::class, 'updateComplaintStatus'])->name('admin.complaints.status');
        Route::delete('/{id}', [AdminController::class, 'deleteComplaint'])->name('admin.complaints.delete');
    });

    // إدارة المشتكين
    Route::prefix('melders')->group(function () {
        Route::get('/', [AdminController::class, 'melders'])->name('admin.melders');
        Route::get('/{id}', [AdminController::class, 'showMelder'])->name('admin.melder.show');
    });
});
Route::get('/clear-session', function () {
    session()->forget('user_data');
    session()->forget('location_data');
    return redirect('/');
})->name('session.clear');

// مسارات Auth الافتراضية
Auth::routes();
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');


<?php
use App\Http\Controllers\ComplaintController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\MapController;
use App\Http\Controllers\Auth\LoginController;
use Illuminate\Support\Facades\Route;

// تسجيل الدخول والخروج
Route::get('login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('login', [LoginController::class, 'login']);
Route::post('logout', [LoginController::class, 'logout'])->name('logout');

Route::get('/', function () {
   return redirect('/map');
});


// خريطة الموقع
Route::get('/map', [MapController::class, 'showMap'])->name('map.show');
Route::post('/geocode', [MapController::class, 'geocodeAddress'])->name('geocode');


// مسارات الشكاوى
Route::get('/klachten', [ComplaintController::class, 'index'])->name('complaints.index');
Route::get('/klachten/aanmaken', [ComplaintController::class, 'create'])->name('complaints.create');
Route::post('/klachten', [ComplaintController::class, 'store'])->name('complaints.store');
Route::get('/klachten/bedankt', [ComplaintController::class, 'thankyou'])->name('complaints.thankyou');
Route::post('/complaints/{id}/status', [ComplaintController::class, 'updateStatus'])->name('complaints.updateStatus');
Route::post('/complaints/{id}/message', [ComplaintController::class, 'sendCustomMessage'])->name('complaints.sendMessage');

// مسارات الأدمن (محمي بالـ middleware)
// Admin routes
Route::prefix('admin')->middleware(['auth'])->group(function () {
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
    Route::get('/complaints', [AdminController::class, 'complaints'])->name('admin.complaints');
    Route::get('/complaints/{id}', [AdminController::class, 'showComplaint'])->name('admin.complaints.show');
    Route::post('/complaints/{id}/status', [AdminController::class, 'updateComplaintStatus'])->name('admin.complaints.status');
    Route::delete('/complaints/{id}', [AdminController::class, 'deleteComplaint'])->name('admin.complaints.delete');
});
// مسارات Auth الافتراضية
Auth::routes();
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');


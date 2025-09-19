<?php

use App\Http\Controllers\MapController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/map', [MapController::class, 'showMap'])->name('map.show');
Route::post('/geocode', [MapController::class, 'geocodeAddress'])->name('geocode');
Route::get('/', function () {
    return redirect('/map');
});
use App\Http\Controllers\ComplaintController;

Route::get('/klachten', [ComplaintController::class, 'index'])->name('complaints.index');
Route::get('/klachten/aanmaken', [ComplaintController::class, 'create'])->name('complaints.create');
Route::post('/klachten', [ComplaintController::class, 'store'])->name('complaints.store');
Route::get('/klachten/bedankt', [ComplaintController::class, 'thankyou'])->name('complaints.thankyou');

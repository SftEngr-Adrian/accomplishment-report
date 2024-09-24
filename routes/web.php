<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AccomplishmentReportController;

Route::middleware(['auth'])->group(function () {
    Route::get('/reports/create', [AccomplishmentReportController::class, 'create'])->name('reports.create');
    Route::post('/reports', [AccomplishmentReportController::class, 'store'])->name('reports.store');
    Route::get('/reports', [AccomplishmentReportController::class, 'index'])->name('reports.index');
});

Route::get('/signup', [AuthController::class, 'showSignupForm']);
Route::post('/signup', [AuthController::class, 'signup']);
Route::get('/signin', [AuthController::class, 'showSigninForm']);
Route::post('/signin', [AuthController::class, 'signin']);
Route::get('/report', [AuthController::class, 'showReportForm'])->middleware('auth');

Route::get('/', function () {
    return view('welcome');
});

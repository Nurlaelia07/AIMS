<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\SuhuController;
use App\Http\Controllers\PhController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\UserController;



/*

Note:

Untuk setiap fitur bagusnya dibuatkan controller untuk mengelola -
proses yang akan dilakukan sebelum diarahkan ke suatu halaman/view

*/


Route::get('/', [UserController::class, 'welcome'])->name('welcome');
Route::get('/home', [HomeController::class, 'homeData'])->name('home');

Route::get('/suhu', [SuhuController::class, 'latestSuhu']);
Route::post('/suhu', [SuhuController::class, 'updateparametersuhu']);

Route::get('/riwayat-suhu', [SuhuController::class, 'index'])->name('suhu.riwayat');

Route::get('/ph', [PhController::class, 'latestPh']);
Route::post('/ph', [PhController::class, 'updateparameterph']);

Route::get('/riwayat-ph', [PhController::class, 'index'])->name('ph.riwayat');


Route::get('/register', [UserController::class, 'register'])->name('register');
Route::post('/register', [UserController::class, 'create'])->name('register.submit');

Route::get('/login', [UserController::class, 'showLoginForm'])->name('login');
Route::post('/home', [UserController::class, 'login'])->name('login.submit');
Route::post('/', [UserController::class, 'logout'])->name('logout');

Route::get('/get-notif', [NotificationController::class, 'checkNotifications'])->name('notifications');

Route::get('/ppm', function () {
    return view('ppm.ppm');
});
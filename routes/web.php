<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('home');
});

Route::get('/suhu', function () {
    return view('suhu.suhu');
});

Route::get('riwayat-suhu', function () {
    return view('suhu.riwayat');
});

Route::get('/ph', function () {
    return view('ph.ph');
});

Route::get('riwayat-ph', function () {
    return view('ph.riwayat');
});

Route::get('/ppm', function () {
    return view('ppm.ppm');
});

Route::get('riwayat-ppm', function () {
    return view('ppm.riwayat');
});

Route::get('login', function(){
    return view('auth.login');
});

Route::get('register', function(){
    return view('auth.register');
});
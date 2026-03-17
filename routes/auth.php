<?php

use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;

Route::post('login', [AuthController::class, 'login'])->name('login');
Route::post('logout', [AuthController::class, 'logout'])->name('logout');

Route::get('login', function () {
    return view('auth.login-directeur');
});

Route::get('login/student', function () {
    return view('auth.login-student');
});

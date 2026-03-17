<?php

use App\Http\Controllers\AuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/dashboard', function () {
    return view('dashboard');
});


////////////////////
Route::get('/login', function () {
    return view('auth.login-directeur');
});

Route::get('/student/login', function () {
    return view('auth.login-student');
});

Route::get('/classes', function () {
    return view('classes.list');
});

Route::get('/students', function () {
    return view('students.list');
});



Route::get('/teachers', function () {
    return view('teachers.list');
});
Route::get('/paiments', function () {
    return view('paiments.list');
});

Route::get('/paiments/detail', function () {
    return view('paiments.monthly');
});

Route::get('/students/profile', function (Request $request) {
    $currentTab = $request->query('tab', 'notes');

    return view('students.profile', [
        'tab' => $currentTab,
    ]);
});
//////////////////////////
//auth
Route::post('login', [AuthController::class,'login'])->name('login');
Route::post('logout', [AuthController::class,'logout'])->name('logout');

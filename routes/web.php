<?php

use App\Http\Controllers\API\V1\AuthController;
use Illuminate\Support\Facades\Route;

Route::get('/login', function () {
    return view('auth.login');
})->name('login');


Route::get('students', function () {
    return view('students.list');
});


Route::prefix('administration')->group(function () {

    Route::get('/dashboard', function () {
        return view('dashboard');
    });

    Route::get('/classes', function () {
        return view('classes.list');
    });

    Route::get('/students', function () {
        return view('students.list');
    });

    Route::get('/students/profile', function () {
        return view('students.profile');
    });

    Route::get('/teachers', function () {
        return view('teachers.list');
    });

    Route::prefix('paiments')->group(function () {
        Route::get('/', function () {
            return view('paiments.list');
        });
        Route::get('/detail', function () {
            return view('paiments.monthly');
        });
    });
});

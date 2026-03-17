<?php

use App\Http\Controllers\DirecteurController;
use App\Http\Middleware\IsDirecteur;
use Illuminate\Support\Facades\Route;

Route::middleware(IsDirecteur::class)->group(function () {

    Route::get('/dashboard', function () {
        return view('dashboard');
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

    // 2. You can even nest groups to add a prefix for payments
    Route::prefix('paiments')->group(function () {
        Route::get('/', function () {
            return view('paiments.list');
        });
        Route::get('/detail', function () {
            return view('paiments.monthly');
        });
    });

});

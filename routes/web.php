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
        return view('lists.classes');
    });

    Route::get('/students', function () {
        return view('lists.students');
    });

    Route::get('/add-students', function () {
        return view('forms.add-student');
    });

    Route::get('/students/{id}', function () {
        return view('students.inspect');
    });

    Route::get('/student-detail', function () {
        return view('detail.profile');
    });



    Route::get('/teachers', function () {
        return view('lists.teachers');
    });

    Route::prefix('paiments')->group(function () {
        Route::get('/', function () {
            return view('lists.paiments');
        });
        Route::get('/detail/{id}', function () {
            return view('paiments.monthly');
        });
    });
});

Route::prefix('student')->group(function () {
    Route::get('/profile', function () {
        return view('students.profile');
    });

    Route::get('/notes', function () {
        return view('students.notes');
    });

    Route::get('/absences', function () {
        return view('students.absences');
    });
});

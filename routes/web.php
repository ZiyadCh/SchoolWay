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

    ////////////////////
    //forms
    Route::get('/add-students', function () {
        return view('forms.add-student');
    })->name('student-form');

    Route::get('/add-teacher', function () {
        return view('forms.add-teacher');
    })->name('teacher-form');

    Route::get('/add-class', function () {
        return view('forms.add-class');
    })->name('class-form');

    ////////////////////
    //INSPECTION

    // student
    Route::get('/students/{id}', function () {
        return view('students.inspect');
    });

    Route::get('/user/update/{id}', function () {
        return view('forms.update-user');
    })->name('update-user');

    Route::get('/student-detail', function () {
        return view('detail.profile');
    });


    // teacher
    Route::get('/teachers', function () {
        return view('lists.teachers');
    });

    Route::get('/teachers/{id}', function () {
        return view('teachers.inspect');
    });

    // classees
    Route::get('/classes/{id}', function () {
        return view('classes.inspect');
    });

    Route::get('/students/classes', function () {
        return view('classes.inspect');
    })->name('student-classes');
    ////////////////////
    //paiment stuff

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

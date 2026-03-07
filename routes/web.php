<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('dashboard');
});

Route::get('/login', function () {
    return view('auth.login');
});

Route::get('/classes', function () {
    return view('classes.list');
});

Route::get('/students', function () {
    return view('students.list');
});

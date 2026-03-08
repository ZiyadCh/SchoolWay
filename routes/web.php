<?php

use Illuminate\Http\Request;
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

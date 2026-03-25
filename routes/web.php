<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('students', function () {
    return view('students.list');
});
Route::post('logout', [AuthController::class,'logout'])->name('logout');

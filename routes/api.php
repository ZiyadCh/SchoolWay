<?php

use App\Http\Controllers\API\V1\LevelController;
use App\Http\Controllers\API\V1\StudentController;
use App\Http\Controllers\API\V1\SchoolClassController;
use App\Http\Controllers\API\V1\TeacherController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::prefix('v1')->group(function () {
    //students
    Route::apiResource('students', StudentController::class);
    //classes
    Route::apiResource('classes', SchoolClassController::class);
    //levels
    Route::apiResource('levels', LevelController::class);
    //teachers
    Route::apiResource('teachers', TeacherController::class);
});

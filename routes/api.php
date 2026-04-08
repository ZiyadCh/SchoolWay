<?php

use App\Http\Controllers\API\V1\AbsenceController;
use App\Http\Controllers\API\V1\AuthController;
use App\Http\Controllers\API\V1\DevoirController;
use App\Http\Controllers\API\V1\LevelController;
use App\Http\Controllers\API\V1\StudentController;
use App\Http\Controllers\API\V1\SchoolClassController;
use App\Http\Controllers\API\V1\SubjectController;
use App\Http\Controllers\API\V1\TeacherController;
use App\Http\Controllers\API\V1\YearController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::prefix('v1')->group(function () {

    //auth
    Route::post('/login', [AuthController::class, 'login'])->name('api.login');

    Route::middleware('auth:sanctum')->group(function () {
        Route::post('/logout', [AuthController::class, 'logout']);
    })->name('logout');

    //years
    Route::apiResource('years', YearController::class);
    //students
    Route::apiResource('students', StudentController::class);
    //classes
    Route::apiResource('classes', SchoolClassController::class);
    //levels
    Route::apiResource('levels', LevelController::class);
    //teachers
    Route::apiResource('teachers', TeacherController::class);
    //subjects
    Route::apiResource('subjects', SubjectController::class);
    //devoirs
    Route::apiResource('devoirs', DevoirController::class);
    //absences
    Route::apiResource('absences', AbsenceController::class);

});

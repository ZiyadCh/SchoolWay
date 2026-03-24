<?php

use App\Http\Controllers\API\V1\LevelController;
use App\Http\Controllers\API\V1\StudentController;
use App\Http\Controllers\API\V1\SchoolClassController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::prefix('v1')->group(function () {
    Route::apiResource('students', StudentController::class);
    Route::apiResource('classes', SchoolClassController::class);
    Route::apiResource('levels', LevelController::class);
});

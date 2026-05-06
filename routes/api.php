<?php

use App\Http\Controllers\API\V1\AbsenceController;
use App\Http\Controllers\API\V1\AuthController;
use App\Http\Controllers\API\V1\DevoirController;
use App\Http\Controllers\API\V1\EnrollementController;
use App\Http\Controllers\API\V1\ExamController;
use App\Http\Controllers\API\V1\LevelController;
use App\Http\Controllers\API\V1\PaimentController;
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

    // Public
    Route::post('/login', [AuthController::class, 'login'])->name('api.login');

    // All authenticated
    Route::middleware('auth:sanctum')->group(function () {
        Route::post('/logout', [AuthController::class, 'logout']);
        Route::post('/reset-password', [AuthController::class, 'resetPassword']);

        Route::get('years', [YearController::class, 'index']);
        Route::get('years/{year}', [YearController::class, 'show']);
        Route::get('levels', [LevelController::class, 'index']);
        Route::get('levels/{level}', [LevelController::class, 'show']);
        Route::get('subjects', [SubjectController::class, 'index']);
        Route::get('subjects/{subject}', [SubjectController::class, 'show']);
        Route::get('school_classes', [SchoolClassController::class, 'index']);
        Route::get('school_classes/{school_class}', [SchoolClassController::class, 'show']);
        Route::get('students/{student}', [StudentController::class, 'show']);
        Route::get('teachers', [TeacherController::class, 'index']);
        Route::get('teachers/{teacher}', [TeacherController::class, 'show']);
        Route::get('absences', [AbsenceController::class, 'index']);
        Route::get('absences/{absence}', [AbsenceController::class, 'show']);
        Route::get('devoirs', [DevoirController::class, 'index']);
        Route::get('devoirs/{devoir}', [DevoirController::class, 'show']);
        Route::get('exams', [ExamController::class, 'index']);
        Route::get('exams/{exam}', [ExamController::class, 'show']);
        Route::get('paiments', [PaimentController::class, 'index']);
    });

    // Teacher + admin
    Route::middleware(['auth:sanctum', 'teacher'])->group(function () {
        Route::post('absences', [AbsenceController::class, 'store']);
        Route::put('absences/{absence}', [AbsenceController::class, 'update']);
        Route::delete('absences/{absence}', [AbsenceController::class, 'destroy']);

        Route::post('devoirs', [DevoirController::class, 'store']);
        Route::put('devoirs/{devoir}', [DevoirController::class, 'update']);
        Route::delete('devoirs/{devoir}', [DevoirController::class, 'destroy']);

        Route::post('exams', [ExamController::class, 'store']);
        Route::put('exams/{exam}', [ExamController::class, 'update']);
        Route::delete('exams/{exam}', [ExamController::class, 'destroy']);

    });

    // Admin only
    Route::middleware(['auth:sanctum', 'directeur'])->group(function () {

        Route::post('enrollements', [EnrollementController::class, 'store']);
        Route::get('students', [StudentController::class, 'index']);
        Route::post('students', [StudentController::class, 'store']);
        Route::put('students/{student}', [StudentController::class, 'update']);
        Route::delete('students/{student}', [StudentController::class, 'destroy']);

        Route::post('school_classes', [SchoolClassController::class, 'store']);
        Route::put('school_classes/{school_class}', [SchoolClassController::class, 'update']);
        Route::delete('school_classes/{school_class}', [SchoolClassController::class, 'destroy']);

        Route::post('levels', [LevelController::class, 'store']);
        Route::put('levels/{level}', [LevelController::class, 'update']);
        Route::delete('levels/{level}', [LevelController::class, 'destroy']);

        Route::post('subjects', [SubjectController::class, 'store']);
        Route::put('subjects/{subject}', [SubjectController::class, 'update']);
        Route::delete('subjects/{subject}', [SubjectController::class, 'destroy']);

        Route::post('teachers', [TeacherController::class, 'store']);
        Route::put('teachers/{teacher}', [TeacherController::class, 'update']);
        Route::delete('teachers/{teacher}', [TeacherController::class, 'destroy']);

        Route::post('years', [YearController::class, 'store']);
        Route::put('years/{year}', [YearController::class, 'update']);
        Route::delete('years/{year}', [YearController::class, 'destroy']);
        Route::post('years/enroll-students', [YearController::class, 'enrollStudents']);
        Route::post('years/{year}/select', [YearController::class, 'selectYear']);
        Route::post('years/{year}/end', [YearController::class, 'endYear']);

        Route::post('paiments/mark-payment', [PaimentController::class, 'markAsPaid'])->name('markAsPaid');
        Route::get('paiments/paiment-stats', [PaimentController::class, 'getPaymentStats']);
        Route::put('paiments/{paiment}', [PaimentController::class, 'update']);
    });
});

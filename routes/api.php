<?php

use App\Http\Controllers\CurriculumController;
use App\Http\Controllers\GroupController;
use App\Http\Controllers\LectureController;
use App\Http\Controllers\StudentController;
use Illuminate\Support\Facades\Route;

Route::prefix('students')->group(function () {
    Route::get('/', [StudentController::class, 'index'])
        ->name('students.index');

    Route::get('/{student}', [StudentController::class, 'show'])
        ->name('students.show')
        ->whereNumber('student');

    Route::patch('/{student}', [StudentController::class, 'update'])
        ->name('students.update')
        ->whereNumber('student');

    Route::post('/', [StudentController::class, 'store'])
        ->name('students.store');

    Route::delete('/{student}', [StudentController::class, 'destroy'])
        ->name('students.destroy')
        ->whereNumber('student');
});

Route::prefix('lectures')->group(function () {
    Route::get('/', [LectureController::class, 'index'])
        ->name('lectures.index');
    Route::get('/{lecture}', [LectureController::class, 'show'])
        ->name('lectures.show')
        ->whereNumber('lecture');
    Route::post('/', [LectureController::class, 'store'])
        ->name('lectures.store');
    Route::patch('/{lecture}', [LectureController::class, 'update'])
        ->name('lectures.update')
        ->whereNumber('lecture');
    Route::delete('/{lecture}', [LectureController::class, 'destroy'])
        ->name('lectures.destroy')
        ->whereNumber('lecture');
});

Route::prefix('classes')->group(function () {
    Route::get('/', [GroupController::class, 'index'])
        ->name('classes.index');

    Route::get('/{group}', [GroupController::class, 'show'])
        ->name('classes.show')
        ->whereNumber('group');

    Route::post('/', [GroupController::class, 'store'])
        ->name('classes.store');

    Route::patch('/{group}', [GroupController::class, 'update'])
        ->name('classes.update')
        ->whereNumber('group');

    Route::delete('/{group}', [GroupController::class, 'destroy'])
        ->name('classes.destroy')
        ->whereNumber('group');


    Route::get('/{group}/curriculum', [CurriculumController::class, 'show'])
        ->name('classes.curriculum.show')
        ->whereNumber('group');

    Route::patch('/{group}/curriculum', [CurriculumController::class, 'update'])
        ->name('classes.curriculum.update')
        ->whereNumber('group');
});

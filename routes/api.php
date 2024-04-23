<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\SubjectController;
use App\Http\Controllers\Api\ScheduleController;
use App\Http\Controllers\Api\InstructorController;

Route::middleware(['auth:sanctum'])->get('/user', function (Request $request) {
    return $request->user();
});

//SUBJECT ROUTES

Route::get('subjects', [SubjectController::class, 'index']);

Route::post('subject',[SubjectController::class, 'store']);


//INSTRUCTOR ROUTES

Route::get('instructors', [InstructorController::class, 'index']);

Route::post('instructor',[InstructorController::class, 'store']);


//SCHEDULE ROUTES

Route::get('schedules', [ScheduleController::class, 'index']);

Route::post('schedule',[ScheduleController::class, 'store']);




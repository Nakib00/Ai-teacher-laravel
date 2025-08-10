<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\SchoolClassController;
use App\Http\Controllers\ClassBookController;
use App\Http\Controllers\ChapterBookController;
use App\Http\Controllers\TopicController;
use App\Http\Controllers\Api\AiTeacherController;
use App\Http\Controllers\ReportModelController;

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

Route::middleware('auth:api')->group(function () {
    Route::get('/get-profile/{id}', [AuthController::class, 'getProfile']);
    Route::get('/teachers', [AiTeacherController::class, 'getTeacher']);
    Route::post('/token', [AiTeacherController::class, 'getLiveKitToken']);

    Route::post('/addClass', [SchoolClassController::class, 'addClass']);
    Route::get('/getAllClass', [SchoolClassController::class, 'getClass']);

    Route::post('/addBook', [ClassBookController::class, 'addBook']);
    Route::get('/getBookOfClass/{id}', [ClassBookController::class, 'getBook']);
    Route::get('/get-all-book', [ClassBookController::class, 'getAllBook']);

    Route::post('/add-chapter', [ChapterBookController::class, 'addChapter']);
    Route::get('/get-chapter/{id}', [ChapterBookController::class, 'getChapter']);
    Route::get('/get-all-chapter', [ChapterBookController::class, 'getAllChapter']);

    Route::post('/add-topic', [TopicController::class, 'addTopic']);
    Route::get('/get-topic-by-chapter/{id}', [TopicController::class, 'getTopicsByChapter']);
    Route::get('/get-all-topic', [TopicController::class, 'getAllTopic']);

Route::post('/addReport', [ReportModelController::class, 'addReport']);
Route::get('/getAllReport', [ReportModelController::class, 'getAllReport']);
Route::get('/getReportByUser/{user_id}', [ReportModelController::class, 'getReportByUser']);
Route::put('/updateReport/{id}', [ReportModelController::class, 'updateReport']);
Route::delete('/deleteReport/{id}', [ReportModelController::class, 'deleteReport']);

});

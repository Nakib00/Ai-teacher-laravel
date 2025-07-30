<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\SchoolClassController;
use App\Http\Controllers\ClassBookController;
use App\Http\Controllers\ChapterBookController;
use App\Http\Controllers\TopicController;

use App\Http\Controllers\Api\AiTeacherController;

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);


Route::middleware('auth:api')->group(function () {
    Route::get('/get-profile/{id}', [AuthController::class, 'getProfile']);
    Route::get('/teachers', [AiTeacherController::class, 'index']);
    Route::post('/token', [AiTeacherController::class, 'getLiveKitToken']);
   
    Route::post('/addClass', [SchoolClassController::class, 'addClass']);
    Route::get('/getAllClass', [SchoolClassController::class, 'getClass']);

    Route::post('/addBook', [ClassBookController::class, 'addBook']);
    Route::get('/getBookOfClass/{id}', [ClassBookController::class, 'getBook']);


    Route::post('/add-chapter', [ChapterBookController::class, 'addChapter']);
    Route::get('/get-chapter/{id}', [ChapterBookController::class, 'getChapter']);


    Route::post('/add-topic', [TopicController::class, 'addTopic']);
    Route::get('/get-topic-by-chapter/{id}', [TopicController::class, 'getTopicsByChapter']);
});

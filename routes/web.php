<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SurveyController;
use App\Http\Controllers\AnswerController;
use App\Http\Controllers\InterviewRequestController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/about', function () {
    return view('static_pages.about');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::get('/profile/detail', [ProfileController::class, 'detail'])->name('profile.detail');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::post('/deliver', [ProfileController::class, 'deliver']);
    
    
    // Route::get('/surveys', [SurveyController::class, 'index'])->name('surveys.index');
    // Route::get('/surveys/{survey}', [SurveyController::class, 'show'])->name('surveys.show');
    Route::get('/surveys/create', [SurveyController::class, 'create'])->name('surveys.create');
    Route::post('/surveys', [SurveyController::class, 'store']);
    
    Route::get('/answers/{survey}', [AnswerController::class, 'create']);
    Route::post('/answers', [AnswerController::class, 'store']);
    
    Route::post('/interviews/request/{survey}', [InterviewRequestController::class, 'request'])->name('interviews.request');
    Route::put('/interviews/accept/{survey}', [InterviewRequestController::class, 'accept'])->name('interviews.accept');
    Route::get('/interviews/{survey}/select', [InterviewRequestController::class, 'select']);
    Route::post('/interviews/{survey}/select', [InterviewRequestController::class, 'store']);
    // 投稿をajaxで取得するAPI
    Route::get('/interviews/{survey}/show_all', [InterviewRequestController::class, 'show_all']);
    // インタビュー結果を返すAPI
    Route::post('/interviews/{survey}/show_result', [InterviewRequestController::class, 'show_result']);
    
    Route::post('/interviews/{survey}', [InterviewRequestController::class, 'create']);
    Route::get('/interviews/{survey}', [InterviewRequestController::class, 'show']);
    Route::delete('/interviews/{survey}', [InterviewRequestController::class, 'destroy']);
    
});

Route::get('/surveys', [SurveyController::class, 'index'])->name('surveys.index');
Route::get('/surveys/{survey}', [SurveyController::class, 'show'])->name('surveys.show');

require __DIR__.'/auth.php';

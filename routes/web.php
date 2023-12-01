<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SurveyController;
use App\Http\Controllers\AnswerController;
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

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::get('/profile/detail', [ProfileController::class, 'detail'])->name('profile.detail');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::post('/deliver', [ProfileController::class, 'deliver']);
    
    
    Route::get('/surveys', [SurveyController::class, 'index'])->name('surveys.index');
    Route::get('/surveys/create', [SurveyController::class, 'create'])->name('surveys.create');
    Route::get('/surveys/{survey}', [SurveyController::class, 'show']);
    Route::post('/surveys', [SurveyController::class, 'store']);
    
    Route::get('/answers/{survey}', [AnswerController::class, 'create']);
    Route::post('/answers', [AnswerController::class, 'store']);
    
    Route::get('/interviews/{survey}', [InterviewRequestController::class, 'show']);
    Route::post('/interviews/request/{survey}', [InterviewRequestController::class, 'request']);
    Route::post('/interviews/accept/{survey}', [InterviewRequestController::class, 'accept']);
});

require __DIR__.'/auth.php';

<?php

use App\Http\Controllers\CategoryController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\QuestionnaireController;
use App\Http\Controllers\AnswerController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;

Route::get('/', function () {
    return view('login');
});
Route::get('register', function () {
    return view('register');
});



Route::post('/login', action: [LoginController::class, 'login'])->name('users.login');

Route::post('/register', [RegisterController::class, 'store'])->name('users.store');



Route::get('/show_categories', [CategoryController::class, 'index'])->name('categories.index');

Route::post('/categories', [CategoryController::class, 'store'])->name('categories.store');

Route::get('/questions_list', [QuestionnaireController::class, 'index'])->name('questions');

Route::post('/questions', [QuestionnaireController::class, 'store'])->name('questions.store');


Route::middleware(['auth'])->group(function () {
    Route::get('/show_answers', [AnswerController::class, 'index'])->name('show_answers');
    Route::post('/answers', [AnswerController::class, 'store'])->name('store_answers');
});

<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ArticleController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\TagController;
use Illuminate\Support\Facades\Route;

Route::get('/', [AuthController::class, 'showLogin'])->name('showlogin');
Route::post('/login', [AuthController::class, 'login'])->name('login');
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register']);




// Article Routes
Route::get('/dashboard', [ArticleController::class, 'dashboard'])->name('dashboard');
Route::get('/articles/create', [ArticleController::class, 'createArticle'])->name('articles.create');
Route::post('/articles', [ArticleController::class, 'storeArticle'])->name('articles.store');
Route::get('/articles/{id}/edit', [ArticleController::class, 'editArticle'])->name('articles.edit');
Route::put('/articles/{id}', [ArticleController::class, 'updateArticle'])->name('articles.update');
Route::delete('/articles/{id}', [ArticleController::class, 'deleteArticle'])->name('articles.destroy');


Route::resource('categories', CategoryController::class);


Route::resource('tags', TagController::class);


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

// Category Routes
Route::get('/categories', [CategoryController::class, 'index'])->name('categories.index');
Route::get('/categories/create', [CategoryController::class, 'create'])->name('categories.create');
Route::post('/categories', [CategoryController::class, 'store'])->name('categories.store');
Route::get('/categories/{id}/edit', [CategoryController::class, 'edit'])->name('categories.edit');
Route::put('/categories/{id}', [CategoryController::class, 'update'])->name('categories.update');
Route::delete('/categories/{id}', [CategoryController::class, 'destroy'])->name('categories.destroy');

// Tag Routes
Route::get('/tags/create', [TagController::class, 'create'])->name('tags.create');
Route::post('/tags', [TagController::class, 'store'])->name('tags.store');

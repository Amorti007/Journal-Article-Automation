<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ArticleController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CommentController;

Route::get('/', function () {
    return redirect()->route('articles.index');
});

// Makale rotaları
Route::resource('articles', ArticleController::class);
Route::get('articles/{article}/download', [ArticleController::class, 'download'])->name('articles.download');

// Kategori rotaları (Örn: /categories/1)
Route::get('categories/{category}', [CategoryController::class, 'show'])->name('categories.show');

// Yorum rotaları
Route::post('articles/{article}/comments', [CommentController::class, 'store'])->name('comments.store');
Route::delete('comments/{comment}', [CommentController::class, 'destroy'])->name('comments.destroy');

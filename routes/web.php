<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ArticleController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\JournalController;

// Redirect root to our simulated articles page
Route::get('/', function () {
    return redirect()->route('articles.index');
});

// Teammates' Route moved to /journals
Route::get('/journals', [JournalController::class, 'index'])->name('journals.index');

// Dashboard
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// Auth Profile Routes
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// --- Our Routes ---
// Makale rotaları
Route::resource('articles', ArticleController::class);
Route::get('articles/{article}/download', [ArticleController::class, 'download'])->name('articles.download');

// Kategori rotaları (Örn: /categories/1)
Route::get('categories/{category}', [CategoryController::class, 'show'])->name('categories.show');

// Yorum rotaları
Route::post('articles/{article}/comments', [CommentController::class, 'store'])->name('comments.store');
Route::delete('comments/{comment}', [CommentController::class, 'destroy'])->name('comments.destroy');

require __DIR__.'/auth.php';

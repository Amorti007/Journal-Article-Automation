<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ArticleController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\JournalController;
use App\Http\Controllers\IssueController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\EditorController;

// Arkadaşının tasarladığı sayfayı ana sayfa yapıyoruz
Route::get('/', function () {
    $featuredJournals = App\Models\Journal::where('status', 'approved')->withCount('articles')->take(3)->get();
    $totalArticles = App\Models\Article::where('status', 'approved')->count();
    $totalJournals = App\Models\Journal::where('status', 'approved')->count();
    $totalAuthors = App\Models\User::has('articles')->count();
    
    return view('welcome', compact('featuredJournals', 'totalArticles', 'totalJournals', 'totalAuthors'));
})->name('home');

// İhtiyaç ihtimaline karşı /journals olarak da kalsın
Route::get('/journals', [JournalController::class, 'index'])->name('journals.index');
Route::get('/journals/create', [JournalController::class, 'create'])->name('journals.create');
Route::post('/journals', [JournalController::class, 'store'])->name('journals.store');
Route::get('/journals/{journal}', [JournalController::class, 'show'])->name('journals.show');
Route::delete('/journals/{journal}', [JournalController::class, 'destroy'])->name('journals.destroy');

// Sayı (Issue) rotaları
Route::get('/issues/create', [IssueController::class, 'create'])->name('issues.create');
Route::post('/issues', [IssueController::class, 'store'])->name('issues.store');

// Dashboard
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// Auth Profile Routes
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Admin Routes
    Route::get('/admin/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
    Route::patch('/admin/journals/{journal}/approve', [AdminController::class, 'approveJournal'])->name('admin.journals.approve');
    Route::patch('/admin/journals/{journal}/reject', [AdminController::class, 'rejectJournal'])->name('admin.journals.reject');
    Route::delete('/admin/journals/{journal}', [AdminController::class, 'deleteJournal'])->name('admin.journals.destroy');
    Route::patch('/admin/articles/{article}/approve', [AdminController::class, 'approveArticle'])->name('admin.articles.approve');
    Route::patch('/admin/articles/{article}/reject', [AdminController::class, 'rejectArticle'])->name('admin.articles.reject');
    Route::delete('/admin/articles/{article}', [AdminController::class, 'deleteArticle'])->name('admin.articles.destroy');
    Route::delete('/admin/comments/{comment}', [AdminController::class, 'deleteComment'])->name('admin.comments.destroy');

    // Editor Routes
    Route::get('/editor/dashboard', [EditorController::class, 'dashboard'])->name('editor.dashboard');
    Route::patch('/editor/articles/{article}/approve', [EditorController::class, 'approveArticleRequest'])->name('editor.articles.approve');
    Route::patch('/editor/articles/{article}/reject', [EditorController::class, 'rejectArticleRequest'])->name('editor.articles.reject');
    Route::post('/editor/articles/{article}/request-delete', [EditorController::class, 'requestDelete'])->name('editor.articles.requestDelete');
    Route::delete('/editor/articles/{article}/approve-delete', [EditorController::class, 'approveDelete'])->name('editor.articles.approveDelete');
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

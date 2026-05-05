<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\JournalController;

Route::get('/', [JournalController::class, 'index'])->name('journals.index');

Route::get('/journals/{journal}', [JournalController::class, 'show'])->name('journals.show');
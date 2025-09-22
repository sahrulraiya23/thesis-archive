<?php

use App\Http\Controllers\Admin\ThesisController as AdminThesisController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PublicController;
use Illuminate\Support\Facades\Route;

// Public routes
Route::get('/', [PublicController::class, 'thesisIndex'])->name('home');
Route::get('/thesis', [PublicController::class, 'thesisIndex'])->name('public.thesis.index');
Route::get('/thesis/{thesis}', [PublicController::class, 'thesisShow'])->name('public.thesis.show');
Route::get('/plagiarism-check', [PublicController::class, 'plagiarismCheck'])->name('plagiarism.check');
Route::post('/plagiarism-check', [PublicController::class, 'checkPlagiarism'])->name('plagiarism.submit');

// Authenticated routes
Route::middleware('auth')->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Admin routes
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::resource('thesis', AdminThesisController::class);
});

require __DIR__ . '/auth.php';

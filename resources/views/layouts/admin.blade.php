<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'Sistem Pengarsipan Tugas Akhir')</title>

    <!-- Tailwind CSS -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- Font Awesome -->
    <script src="https:// Authenticated routes
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

require __DIR__.'/auth.php';
?> ?>

document.addEventListener('DOMContentLoaded', function() {
    const sidebarToggle = document.getElementById('sidebarToggle');
    const sidenav = document.querySelector('.sidenav');
    
    // Check if mobile
    const isMobile = window.innerWidth <= 768;
    
    if (isMobile) {
        document.body.classList.add('sidenav-toggle');
    }
    
    sidebarToggle.addEventListener('click', function() {
        if (isMobile) {
            sidenav.classList.toggle('show');
        } else {
            document.body.classList.toggle('sidenav-toggle');
        }
    });
    
    // Close sidebar when clicking outside on mobile
    if (isMobile) {
        document.addEventListener('click', function(e) {
            if (!sidenav.contains(e.target) && !sidebarToggle.contains(e.target)) {
                sidenav.classList.remove('show');
            }
        });
    }
    
    // Handle window resize
    window.addEventListener('resize', function() {
        const isMobileNow = window.innerWidth <= 768;
        
        if (isMobileNow && !isMobile) {
            document.body.classList.add('sidenav-toggle');
            sidenav.classList.remove('show');
        } else if (!isMobileNow && isMobile) {
            document.body.classList.remove('sidenav-toggle');
            sidenav.classList.remove('show');
        }
    });
});

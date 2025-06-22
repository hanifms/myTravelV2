<?php

use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Middleware\AdminMiddleware;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

Route::get('/', function () {
    return view('welcome');
});

// Default dashboard route - will redirect based on role
Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        $user = Auth::user();

        if ($user->isAdmin()) {
            return redirect()->route('admin.dashboard');
        }

        return view('dashboard');
    })->name('dashboard');
});

// User routes
Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    // Travel Package Routes
    Route::get('/travel-packages', [App\Http\Controllers\User\TravelController::class, 'index'])->name('travel-packages.index');
    Route::get('/travel-packages/{travelPackage}', [App\Http\Controllers\User\TravelController::class, 'show'])->name('travel-packages.show');

    // Booking Routes
    Route::get('/my-bookings', [App\Http\Controllers\User\BookingController::class, 'myBookings'])->name('bookings.my-bookings');
    Route::get('/travel-packages/{travelPackage}/book', [App\Http\Controllers\User\BookingController::class, 'create'])->name('bookings.create');
    Route::post('/travel-packages/{travelPackage}/book', [App\Http\Controllers\User\BookingController::class, 'store'])->name('bookings.store');
    Route::get('/bookings/{booking}', [App\Http\Controllers\User\BookingController::class, 'show'])->name('bookings.show');
});

// Admin routes
Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
    AdminMiddleware::class,
])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');
});

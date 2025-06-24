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

    // Review Routes
    Route::get('/bookings/{booking}/review', [App\Http\Controllers\User\ReviewController::class, 'create'])->name('reviews.create');
    Route::post('/bookings/{booking}/review', [App\Http\Controllers\User\ReviewController::class, 'store'])->name('reviews.store');
    Route::get('/my-reviews', [App\Http\Controllers\User\ReviewController::class, 'index'])->name('reviews.index');
});

// Admin routes
Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
    AdminMiddleware::class,
])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');

    // User management routes
    Route::resource('users', \App\Http\Controllers\Admin\UserController::class);

    // Booking management routes
    Route::resource('bookings', \App\Http\Controllers\Admin\BookingController::class)->except(['create', 'store', 'destroy']);
    Route::get('bookings/filter', [\App\Http\Controllers\Admin\BookingController::class, 'filter'])->name('bookings.filter');

    // Travel Package management routes
    Route::resource('travel-packages', \App\Http\Controllers\Admin\TravelPackageController::class);
    Route::put('travel-packages/{travelPackage}/toggle-visibility', [\App\Http\Controllers\Admin\TravelPackageController::class, 'toggleVisibility'])
        ->name('travel-packages.toggle-visibility');
});

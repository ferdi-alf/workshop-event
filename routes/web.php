<?php

use App\Http\Controllers\FeedbackController;
use App\Http\Controllers\IndexController;
use App\Http\Controllers\ParticipantsController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\WorkshopController;
use Illuminate\Support\Facades\Route;


Route::get('/', [IndexController::class, 'welcome'])->name('welcome');

Route::get('/workshop/register/{slug}', [IndexController::class, 'register'])
    ->name('workshop.register');

Route::post('/workshop/register/{slug}', [IndexController::class, 'store'])
    ->name('workshop.register.store');
    
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::controller(WorkshopController::class)->prefix('workshop')->name('workshop.')->group(function () {
        Route::get('/', 'index')->name('index');
        Route::get('/{id}', 'index')->name('index');
        Route::post('/', 'store')->name('store');
        Route::put('/{id}', 'update')->name('update');
        Route::delete('/{id}', 'destroy')->name('destroy');
    });
    
    Route::controller(UserController::class)->prefix('user')->name('user.')->group(function () {
        Route::get('/', 'index')->name('index');
        Route::get('/{id}', 'show')->name('show');
        Route::post('/', 'store')->name('store');
        Route::put('/{id}', 'update')->name('update');
        Route::delete('/{id}', 'destroy')->name('destroy');
    });

    Route::controller(ParticipantsController::class)->prefix('participants')->name('participants.')->group(function () {
        Route::get('/', 'index')->name('index');
        Route::get('/{id}', 'show')->name('show');
        Route::post('/', 'store')->name('store');
        Route::put('/{id}', 'update')->name('update');
        Route::delete('/{id}', 'destroy')->name('destroy');
    });

    Route::controller(FeedbackController::class)->prefix('feedback')->name('feedback.')->group(function () {
        Route::get('/', 'index')->name('index');
        Route::get('/search', 'searchWorkshops')->name('search'); // Route baru untuk search
        Route::post('/', 'store')->name('store');
    });
});

require __DIR__.'/auth.php';

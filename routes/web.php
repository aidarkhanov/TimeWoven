<?php

use App\Http\Controllers\EventController;
use App\Http\Controllers\InvitationController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', fn() => view('welcome'));

Route::get('/dashboard', fn() => view('dashboard'))
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware('auth')
    ->group(function () {
        Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
        Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
        Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    });

Route::prefix('events')
    ->middleware(['auth', 'verified'])
    ->group(function () {
        Route::get('/', [EventController::class, 'show'])->name('events.show');
        Route::post('/', [EventController::class, 'store'])->name('events.store');
        Route::get('/create', [EventController::class, 'create'])->name('events.create');
        Route::get('/{event}/edit', [EventController::class, 'edit'])->name('events.edit');
        Route::patch('/{event}', [EventController::class, 'update'])->name('events.update');
        Route::delete('/{event}', [EventController::class, 'destroy'])->name('events.destroy');
    });

Route::post('/invitations/respond/{token}', [InvitationController::class, 'respond'])
    ->name('invitations.respond');

require __DIR__.'/auth.php';

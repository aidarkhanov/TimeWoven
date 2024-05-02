<?php

use App\Http\Livewire\EventForm;
use App\Http\Livewire\EventList;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    Route::prefix('events')->group(function () {
        Route::get('/', EventList::class)->name('list-event');
//        Route::get('/create', EventForm::class)->name('create-event');
//        Route::get('/edit/{event_id}', EventForm::class)->name('edit-event');
    });

});

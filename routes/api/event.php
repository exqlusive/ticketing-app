<?php

use App\Http\Controllers\Event\EventController;
use Illuminate\Support\Facades\Route;

Route::resource('events', EventController::class);

Route::prefix('events/{id}/schedules')->group(function () {
    Route::get('/', [EventController::class, 'schedule']);
    Route::post('/', [EventController::class, 'storeSchedule']);

    Route::get('/{scheduleId}', [EventController::class, 'showSchedule']);
    Route::put('/{scheduleId}', [EventController::class, 'updateSchedule']);
});

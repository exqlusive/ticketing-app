<?php

use App\Http\Controllers\Event\EventController;
use App\Http\Controllers\Event\EventScheduleController;
use App\Http\Controllers\Event\EventTicketController;
use Illuminate\Support\Facades\Route;

Route::resource('events', EventController::class);

Route::resource('events.schedules', EventScheduleController::class)
    ->except(['destroy']);

Route::resource('events.tickets', EventTicketController::class)
    ->except(['destroy']);

<?php

use App\Http\Controllers\Event\EventController;
use Illuminate\Support\Facades\Route;

Route::resource('/events', EventController::class);

<?php

use App\Http\Controllers\Organization\OrganizationController;
use Illuminate\Support\Facades\Route;

Route::resource('/organizations', OrganizationController::class);

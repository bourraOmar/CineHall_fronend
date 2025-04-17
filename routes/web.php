<?php

use Illuminate\Support\Facades\Route;

Route::get('/', [AuthController::class, 'index']);


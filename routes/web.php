<?php

use Illuminate\Support\Facades\Route;

Route::get('/', [AuthController::class, 'index']);

Route::get('/register', function(){
    return view('register');
})->name('register')->middleware('guest');
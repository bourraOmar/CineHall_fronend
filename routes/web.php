<?php

use Illuminate\Support\Facades\Route;

Route::get('/', [AuthController::class, 'index']);

Route::get('/register', function(){
    return view('register');
})->name('register')->middleware('guest');

Route::get('/login', function(){
    return view('login');
})->name('login')->middleware('guest');
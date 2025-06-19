<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Aut\RegisterController;


Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');


Route::get('/', function () {
    return view('home');
});


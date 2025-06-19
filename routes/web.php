<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Aut\RegisterController;



Route::get('/', function () {
    return view('home');
});


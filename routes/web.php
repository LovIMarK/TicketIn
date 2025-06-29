<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TicketController;
use App\Models\Ticket;


/*|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|*/
Route::get('/', function () {
    return view('index');
})->name('index');

Route::get('/login', function () {
    return view('login');
})->name('login');

Route::get('/register', function () {
    return view('register');
})->name('register');

Route::get('logout', function () {
    return redirect()->route('index');
})->name('logout');

Route::get('/dashboard', function () {
    return view('dashboard');
})->name('dashboard');


/*|--------------------------------------------------------------------------
| Route for TicketController
|--------------------------------------------------------------------------*/
Route::get('/tickets', [TicketController::class, 'index'])->name('tickets.index');

Route::get('/tickets/{ticket}/summary', function ($ticketId) {
    $ticket = Ticket::findOrFail($ticketId);
    return view('tickets.summary', ['ticket' => $ticket]);
})->name('tickets.summary');

Route::get('/tickets/{ticket}', [TicketController::class, 'show'])->name('tickets.show');

Route::put('/tickets/{ticket}', [TicketController::class, 'update'])->name('tickets.update');






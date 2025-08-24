

<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\LogoutController;
use App\Http\Controllers\Admin\TicketController as AdminTicketController;
use App\Http\Controllers\Agent\TicketController as AgentTicketController;
use App\Http\Controllers\User\TicketController as UserTicketController;
use App\Http\Controllers\TicketController;
use App\Http\Controllers\Admin\UserController as AdminUserController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Admin\DashboardController;

/**
 * Web routes registration.
 *
 * Public (guest) routes for auth/register, plus authenticated areas for:
 * - Admin  (prefix 'admin', name 'admin.*', middleware: auth + role:admin)
 * - Agent  (prefix 'agent', name 'agent.*', middleware: auth + role:agent)
 * - User   (prefix 'user',  name 'user.*',  middleware: auth + role:user)
 *
 */

/*
|--------------------------------------------------------------------------
| Public Routes (guest)
|--------------------------------------------------------------------------
*/
Route::get('/', fn() => view('index'))->name('index');

// Authentication
Route::get('/login',[LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login',[LoginController::class, 'login']);
Route::get('/register',[RegisterController::class, 'showRegistrationForm'])->name('register');
Route::post('/register',[RegisterController::class, 'register']);

// Logout (POST to avoid CSRF via links)
Route::post('/logout', [LogoutController::class, 'perform'])->name('logout');

// Authenticated shared routes
Route::middleware(['auth'])->group(function () {
    // Create ticket (any authenticated role); redirect target decided by role
    Route::post('/create-ticket', [TicketController::class, 'store'])->name('tickets.store');

    // Profile
    Route::get('/profile', [ProfileController::class, 'profile'])->name('profile');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');
});

// Admin area
Route::middleware(['auth', 'role:admin'])->name('admin.')->prefix('admin')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('home');

    // Tickets
    Route::get('/tickets', [AdminTicketController::class, 'tickets'])->name('tickets');
    Route::get('/tickets/{ticket}/show', [AdminTicketController::class, 'show'])->name('tickets.show');
    Route::get('/tickets/{ticket}/summary', [AdminTicketController::class, 'summary'])->name('tickets.summary');
    Route::get('/tickets/{status}', [AdminTicketController::class, 'ticketsByStatus'])->name('tickets.byStatus');
    Route::get('/tickets/{priority}', [AdminTicketController::class, 'ticketsByPriority'])->name('tickets.byPriority');
    Route::get('/create-ticket', [AdminTicketController::class, 'createTicket'])->name('create');
    Route::put('/tickets/{ticket}', [AdminTicketController::class, 'update'])->name('tickets.update');

    // Users
    Route::get('/users', [AdminUserController::class, 'index'])->name('users.index');
    Route::get('/users/{user}/edit', [AdminUserController::class, 'edit'])->name('users.edit');
    Route::put('/users/{user}', [AdminUserController::class, 'update'])->name('users.update');
    Route::delete('/users/{user}', [AdminUserController::class, 'destroy'])->name('users.destroy');
    Route::get('/users/create', [AdminUserController::class, 'create'])->name('users.create');
    Route::post('/users', [AdminUserController::class, 'store'])->name('users.store');

});

// Agent area
Route::middleware(['auth', 'role:agent'])->name('agent.')->prefix('agent')->group(function () {
    // Home lists tickets (agent inbox)
    Route::get('/tickets', [AgentTicketController::class, 'tickets'])->name('home');

    Route::get('/tickets/{ticket}/show', [AgentTicketController::class, 'show'])->name('tickets.show');
    Route::put('/tickets/{ticket}', [AgentTicketController::class, 'update'])->name('tickets.update');
    Route::get('/tickets/{ticket}/summary', [AgentTicketController::class, 'summary'])->name('tickets.summary');
    Route::get('/tickets/{status}', [AgentTicketController::class, 'ticketsByStatus'])->name('tickets.byStatus');
    Route::get('/tickets/{priority}', [AgentTicketController::class, 'ticketsByPriority'])->name('tickets.byPriority');
    Route::get('/create-ticket', [AgentTicketController::class, 'createTicket'])->name('tickets.create');

});

// End-user area
Route::middleware(['auth', 'role:user'])->name('user.')->prefix('user')->group(function () {
    Route::get('/tickets', [UserTicketController::class, 'tickets'])->name('home');
    Route::get('/create-ticket', [UserTicketController::class, 'createTicket'])->name('tickets.create');
    Route::get('/tickets/{ticket}/show', [UserTicketController::class, 'show'])->name('tickets.show');
    Route::get('/tickets/{ticket}/summary', [UserTicketController::class, 'summary'])->name('tickets.summary');
    Route::put('/tickets/{ticket}', [UserTicketController::class, 'update'])->name('tickets.update');
});

<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Project1\MyController;

// ==========================================
// 1. AUTHENTICATION & REGISTRATION ROUTES(routes which can be accessed by anyone)
// ==========================================
Route::get('/login', [MyController::class, 'showLoginForm'])->name('login');
Route::post('/login', [MyController::class, 'login']);

Route::get('/register', [MyController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [MyController::class, 'register'])->name('register.store');
Route::get('/dashboard', function () { return view('dashboard'); });




Route::get('/tickets/{id}', [MyController::class, 'getTicketDetails']);
// ===================================================
// 2. ROLE GROUP 3: END-USERS ONLY
// ===================================================
Route::middleware(['my_role:3'])->group(function () {
Route::get('/user-panel', [MyController::class, 'showUserPanel']);
Route::post('/tickets/store', [MyController::class, 'storeTicket']);
Route::post('/tickets/reopen/{id}', [MyController::class, 'reopenTicket']);

Route::post('/user/tickets/close/{id}',[MyController::class,'closeTicket']);
Route::get('/user/tickets/show/{id}', [MyController::class, 'showTicketDetails']);
// 🌟 THE ULTIMATE GET FIXED LINK ROUTE: Place at the absolute bottom of routes/web.php
Route::get('/user/tickets/close-direct/{id}', [MyController::class, 'closeTicket']);


    Route::post('/tickets/reopen/{id}', [MyController::class, 'reopenTicket']);
    Route::post('/user/tickets/close/{id}', [MyController::class, 'closeTicket']);

});


// ===================================================
//  ROLE GROUP 2: SUPPORT ENGINEERS ONLY
// ===================================================
Route::middleware(['my_role:2'])->group(function () {
Route::get('/support-panel/{id?}', [MyController::class, 'showSupportPanel']);
Route::post('/tickets/{id}/update-status', [MyController::class, 'updateTicketStatus']);
Route::post('/tickets/update-details/{id}', [MyController::class, 'updateResolutionDetails']);
Route::get('/support/tickets/show/{id}', [MyController::class, 'showTicketDetails']);
});


// ===================================================
// 🔐 ROLE GROUP 1: ADMINISTRATORS ONLY
// ===================================================
Route::middleware(['my_role:1'])->group(function(){

Route::get('/admin-panel', [MyController::class, 'showAdminPanel']);

Route::post('/tickets/{id}/assign', [MyController::class, 'assignTicket']);
Route::post('/admin/update-engineer-team/{userId}', [MyController::class, 'updateEngineerTeam']);
Route::get('/admin/tickets/show/{id}', [MyController::class, 'showTicketDetails']);
Route::post('/admin/tickets/{id}/close', [MyController::class, 'closeTicket'])->name('tickets.close');
Route::post('/close-ticket/{id}', [MyController::class, 'closeTicket'])->name('ticket.close');

});

Route::match(['get', 'post'], '/tickets/close/{id}', [MyController::class, 'closeTicket'])->name('universal.ticket.close');




// ==========================================
// 3. TICKET OPERATIONS
// ==========================================


// Route handler tracking asynchronous engineer status transitions






<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;

use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\PermissionController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\BookingTypeController;
use App\Http\Controllers\Admin\BankAccountController;
use App\Http\Controllers\Admin\BookingController;
use App\Http\Controllers\Admin\TicketController;
use App\Http\Controllers\TicketVerifyController;
use App\Http\Controllers\Admin\DashboardController;

Route::get('/ticket/verify/{ticketId}', [TicketVerifyController::class, 'show'])
    ->name('ticket.verify');

Route::get('/', function () {
    return redirect()->route('login');
});


Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])->name('dashboard');



/*
|--------------------------------------------------------------------------
| Profile Routes
|--------------------------------------------------------------------------
*/

Route::middleware('auth')->group(function () {

    Route::get('/profile', [ProfileController::class, 'edit'])
        ->name('profile.edit');

    Route::patch('/profile', [ProfileController::class, 'update'])
        ->name('profile.update');

    Route::delete('/profile', [ProfileController::class, 'destroy'])
        ->name('profile.destroy');

});



/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
*/

Route::middleware(['auth'])
->prefix('admin')
->name('admin.')
->group(function () {

    Route::resource('roles', RoleController::class);

    Route::resource('permissions', PermissionController::class);

    Route::resource('users', UserController::class);
    Route::get('user-access-control', [UserController::class, 'accessControl'])
        ->name('users.access-control');

    // Booking Routes
    Route::resource('booking_types', BookingTypeController::class);
    
    Route::resource('bank_accounts', BankAccountController::class);
    
    Route::resource('bookings', BookingController::class);

    Route::post('bookings/{booking}/status', [BookingController::class, 'updateStatus'])
        ->name('bookings.update-status');
    
    Route::get('bookings/{booking}/download-pdf', [TicketController::class, 'downloadPDF'])
        ->name('bookings.download-pdf');

});



require __DIR__.'/auth.php';

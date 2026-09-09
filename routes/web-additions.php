<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TicketVerifyController;

Route::get('/ticket/verify/{ticketId}', [TicketVerifyController::class, 'show'])
    ->name('ticket.verify');

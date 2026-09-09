<?php

namespace App\Http\Controllers;

use App\Models\Pilgrim;

class TicketVerifyController extends Controller
{
    public function show($ticketId)
    {
        $pilgrim = Pilgrim::with(['booking', 'bookingType'])
            ->where('ticket_id', $ticketId)
            ->firstOrFail();

        return view('ticket.verify', compact('pilgrim'));
    }
}

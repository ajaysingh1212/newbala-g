<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use PDF;

class TicketController extends Controller
{
    public function downloadPDF($bookingId)
    {
        $booking = Booking::with('pilgrims.bookingType')->findOrFail($bookingId);

        $pdf = PDF::loadView('admin.bookings.ticket', compact('booking'));

        if (request()->boolean('download')) {
            return $pdf->download('booking_tickets_' . $booking->id . '.pdf');
        }

        return $pdf->stream('booking_tickets_' . $booking->id . '.pdf');
    }
}

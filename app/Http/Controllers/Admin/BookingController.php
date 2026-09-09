<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\BookingType;
use App\Models\Pilgrim;
use Illuminate\Http\Request;
use PDF;

class BookingController extends Controller
{
    public function index()
    {
        $bookings = Booking::with('pilgrims')->latest()->paginate(10);
        return view('admin.bookings.index', compact('bookings'));
    }

    public function create()
    {
        $bookingTypes = BookingType::where('status', 'active')->get();
        return view('admin.bookings.create', compact('bookingTypes'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'group_name' => 'required|string',
            'main_person_name' => 'required|string',
            'email' => 'required|email',
            'visiting_date' => 'required|date',
            'slot_time' => 'required|string',
            'payment_status' => 'required|in:confirmed,pending',
            'pilgrims' => 'required|array|min:1',
            'pilgrims.*.name' => 'required|string',
            'pilgrims.*.age' => 'required|integer|min:1',
            'pilgrims.*.phone_number' => 'required|string',
            'pilgrims.*.id_type' => 'required|in:aadhar,pan,other',
            'pilgrims.*.id_number' => 'required|string',
            'pilgrims.*.gender' => 'required|in:male,female,other',
            'pilgrims.*.booking_type_id' => 'required|exists:booking_types,id'
        ]);

        if ($request->payment_status === 'confirmed') {
            $request->validate([
                'payment_screenshot' => 'required|image|max:2048',
                'ref_utr' => 'nullable|string'
            ]);
        }

        $totalAmount = 0;
        foreach ($request->pilgrims as $pilgrim) {
            $bookingType = BookingType::find($pilgrim['booking_type_id']);
            $totalAmount += $bookingType->amount;
        }

        $data = [
            'ticket_number' => $this->generateTicketNumber(),
            'group_name' => $request->group_name,
            'main_person_name' => $request->main_person_name,
            'email' => $request->email,
            'visiting_date' => $request->visiting_date,
            'slot_time' => $request->slot_time,
            'total_amount' => $totalAmount,
            'payment_status' => $request->payment_status,
            'ref_utr' => $request->ref_utr,
            'status' => 'pending'
        ];

        if ($request->hasFile('payment_screenshot')) {
            $data['payment_screenshot'] = $request->file('payment_screenshot')->store('payments', 'public');
        }

        $booking = Booking::create($data);

        foreach ($request->pilgrims as $pilgrim) {
            $bookingType = BookingType::find($pilgrim['booking_type_id']);

            $newPilgrim = Pilgrim::create([
                'booking_id' => $booking->id,
                'name' => $pilgrim['name'],
                'age' => $pilgrim['age'],
                'phone_number' => $pilgrim['phone_number'],
                'id_type' => $pilgrim['id_type'],
                'id_number' => $pilgrim['id_number'],
                'gender' => $pilgrim['gender'],
                'booking_type_id' => $pilgrim['booking_type_id'],
                'amount' => $bookingType->amount,
            ]);

            $newPilgrim->ticket_id = 'IDJ' . now()->format('ymd') . str_pad((string) $newPilgrim->id, 6, '0', STR_PAD_LEFT);
            $newPilgrim->save();
        }

        return redirect()->route('admin.bookings.show', $booking->id)->with('success', 'Booking created successfully. PDF will be generated.');
    }

    public function show($id)
    {
        $booking = Booking::with('pilgrims.bookingType')->findOrFail($id);
        return view('admin.bookings.show', compact('booking'));
    }

    public function edit($id)
    {
        $booking = Booking::with('pilgrims')->findOrFail($id);
        $bookingTypes = BookingType::where('status', 'active')->get();
        return view('admin.bookings.edit', compact('booking', 'bookingTypes'));
    }

    public function update(Request $request, $id)
    {
        $booking = Booking::findOrFail($id);

        $request->validate([
            'group_name' => 'required|string',
            'main_person_name' => 'required|string',
            'email' => 'required|email',
            'visiting_date' => 'required|date',
            'slot_time' => 'required|string',
            'payment_status' => 'required|in:confirmed,pending',
        ]);

        if ($request->payment_status === 'confirmed') {
            $request->validate([
                'payment_screenshot' => 'nullable|image|max:2048',
                'ref_utr' => 'nullable|string'
            ]);
        }

        $data = [
            'group_name' => $request->group_name,
            'main_person_name' => $request->main_person_name,
            'email' => $request->email,
            'visiting_date' => $request->visiting_date,
            'slot_time' => $request->slot_time,
            'payment_status' => $request->payment_status,
            'ref_utr' => $request->ref_utr
        ];

        if ($request->hasFile('payment_screenshot')) {
            $data['payment_screenshot'] = $request->file('payment_screenshot')->store('payments', 'public');
        }

        $booking->update($data);

        return redirect()->route('admin.bookings.show', $booking->id)->with('success', 'Booking updated successfully');
    }

    public function destroy($id)
    {
        $booking = Booking::findOrFail($id);
        $booking->pilgrims()->delete();
        $booking->delete();

        return redirect()->route('admin.bookings.index')->with('success', 'Booking deleted successfully');
    }

    public function updateStatus(Request $request, $bookingId)
    {
        $booking = Booking::findOrFail($bookingId);

        $validated = $request->validate([
            'status' => 'required|in:completed,cancelled',
        ]);

        $booking->status = $validated['status'];
        $booking->payment_status = $validated['status'] === 'completed' ? 'confirmed' : 'pending';
        $booking->save();

        return redirect()->route('admin.bookings.index')->with(
            'success',
            $validated['status'] === 'completed' ? 'Booking confirmed successfully.' : 'Booking rejected successfully.'
        );
    }

    public function generatePDF($id)
    {
        $booking = Booking::with('pilgrims.bookingType')->findOrFail($id);

        $pdf = PDF::loadView('admin.bookings.ticket-pdf', compact('booking'));

        return $pdf->download('booking_tickets_' . $booking->id . '.pdf');
    }

    protected function generateTicketNumber(): string
    {
        do {
            $letters = strtoupper(substr(str_shuffle('ABCDEFGHIJKLMNOPQRSTUVWXYZ'), 0, 5));
            $numbers = str_pad((string) random_int(10000, 99999), 5, '0', STR_PAD_LEFT);
            $ticketNumber = $letters . $numbers;
        } while (Booking::where('ticket_number', $ticketNumber)->exists());

        return $ticketNumber;
    }
}

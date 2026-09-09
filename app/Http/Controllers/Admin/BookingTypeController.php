<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BookingType;
use Illuminate\Http\Request;

class BookingTypeController extends Controller
{
    public function index()
    {
        $bookingTypes = BookingType::latest()->paginate(10);
        return view('admin.booking_types.index', compact('bookingTypes'));
    }

    public function create()
    {
        return view('admin.booking_types.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|unique:booking_types',
            'amount' => 'required|numeric|min:0',
            'description' => 'nullable|string',
            'status' => 'required|in:active,inactive'
        ]);

        BookingType::create([
            'title' => $request->title,
            'amount' => $request->amount,
            'description' => $request->description,
            'status' => $request->status
        ]);

        return redirect()->route('admin.booking_types.index')->with('success', 'Booking Type created successfully');
    }

    public function edit($id)
    {
        $bookingType = BookingType::findOrFail($id);
        return view('admin.booking_types.edit', compact('bookingType'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'title' => 'required|string|unique:booking_types,title,' . $id,
            'amount' => 'required|numeric|min:0',
            'description' => 'nullable|string',
            'status' => 'required|in:active,inactive'
        ]);

        $bookingType = BookingType::findOrFail($id);
        $bookingType->update([
            'title' => $request->title,
            'amount' => $request->amount,
            'description' => $request->description,
            'status' => $request->status
        ]);

        return redirect()->route('admin.booking_types.index')->with('success', 'Booking Type updated successfully');
    }

    public function destroy($id)
    {
        $bookingType = BookingType::findOrFail($id);
        $bookingType->delete();

        return redirect()->route('admin.booking_types.index')->with('success', 'Booking Type deleted successfully');
    }
}

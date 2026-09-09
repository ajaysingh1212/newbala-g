@extends('layouts.admin')

@section('title', 'Booking Details')

@section('content')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Booking Details</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('admin.bookings.index') }}">Bookings</a></li>
                    <li class="breadcrumb-item active">{{ $booking->id }}</li>
                </ol>
            </div>
        </div>
    </div>
</div>

<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <!-- Booking Info Card -->
                <div class="card card-primary card-outline">
                    <div class="card-header">
                        <h3 class="card-title">Booking #{{ $booking->id }} - {{ $booking->group_name }}</h3>
                        <div class="card-tools">
                            <a href="{{ route('admin.bookings.download-pdf', $booking->id) }}" class="btn btn-sm btn-success">
                                <i class="fas fa-download"></i> Download PDF Tickets
                            </a>
                            <a href="{{ route('admin.bookings.edit', $booking->id) }}" class="btn btn-sm btn-primary">
                                <i class="fas fa-edit"></i> Edit
                            </a>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <h5>Booking Information</h5>
                                <table class="table table-sm">
                                    <tr>
                                        <th>Ticket Number:</th>
                                        <td><span class="badge badge-primary" style="font-size: 14px; letter-spacing: 1px;">{{ $booking->ticket_number ?? 'N/A' }}</span></td>
                                    </tr>
                                    <tr>
                                        <th>Group Name:</th>
                                        <td>{{ $booking->group_name }}</td>
                                    </tr>
                                    <tr>
                                        <th>Main Person:</th>
                                        <td>{{ $booking->main_person_name }}</td>
                                    </tr>
                                    <tr>
                                        <th>Email:</th>
                                        <td>{{ $booking->email }}</td>
                                    </tr>
                                    <tr>
                                        <th>Visiting Date:</th>
                                        <td>{{ $booking->visiting_date->format('d M, Y') }}</td>
                                    </tr>
                                    <tr>
                                        <th>Slot/Time:</th>
                                        <td>{{ $booking->slot_time }}</td>
                                    </tr>
                                </table>
                            </div>
                            <div class="col-md-6">
                                <h5>Payment Information</h5>
                                <table class="table table-sm">
                                    <tr>
                                        <th>Total Amount:</th>
                                        <td><strong>₹ {{ number_format($booking->total_amount, 2) }}</strong></td>
                                    </tr>
                                    <tr>
                                        <th>Payment Status:</th>
                                        <td>
                                            @if($booking->payment_status === 'confirmed')
                                                <span class="badge badge-success">Confirmed</span>
                                            @else
                                                <span class="badge badge-warning">Pending</span>
                                            @endif
                                        </td>
                                    </tr>
                                    @if($booking->ref_utr)
                                    <tr>
                                        <th>Ref/UTR:</th>
                                        <td>{{ $booking->ref_utr }}</td>
                                    </tr>
                                    @endif
                                    <tr>
                                        <th>Booking Status:</th>
                                        <td>
                                            @if($booking->status === 'completed')
                                                <span class="badge badge-success">Completed</span>
                                            @elseif($booking->status === 'pending')
                                                <span class="badge badge-warning">Pending</span>
                                            @else
                                                <span class="badge badge-danger">Cancelled</span>
                                            @endif
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Created:</th>
                                        <td>{{ $booking->created_at->format('d M, Y H:i A') }}</td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Pilgrims Table -->
                <div class="card card-secondary card-outline">
                    <div class="card-header">
                        <h3 class="card-title">Pilgrims ({{ $booking->pilgrims->count() }})</h3>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered table-hover">
                                <thead class="bg-light">
                                    <tr>
                                        <th>#</th>
                                        <th>Name</th>
                                        <th>Age</th>
                                        <th>Gender</th>
                                        <th>Phone</th>
                                        <th>ID Type</th>
                                        <th>ID Number</th>
                                        <th>Booking Type</th>
                                        <th>Amount</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($booking->pilgrims as $key => $pilgrim)
                                    <tr>
                                        <td>{{ $key + 1 }}</td>
                                        <td>{{ $pilgrim->name }}</td>
                                        <td>{{ $pilgrim->age }}</td>
                                        <td>{{ ucfirst($pilgrim->gender) }}</td>
                                        <td>{{ $pilgrim->phone_number }}</td>
                                        <td>{{ ucfirst($pilgrim->id_type) }}</td>
                                        <td>{{ $pilgrim->id_number }}</td>
                                        <td>{{ $pilgrim->bookingType->title }}</td>
                                        <td>₹ {{ number_format($pilgrim->amount, 2) }}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                                <tfoot>
                                    <tr class="bg-light">
                                        <th colspan="8" class="text-right">Total:</th>
                                        <th>₹ {{ number_format($booking->total_amount, 2) }}</th>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>

                <!-- Payment Screenshot -->
                @if($booking->payment_screenshot)
                <div class="card card-info card-outline">
                    <div class="card-header">
                        <h3 class="card-title">Payment Screenshot</h3>
                    </div>
                    <div class="card-body text-center">
                        <img src="{{ asset('storage/' . $booking->payment_screenshot) }}" alt="Payment Screenshot" class="img-fluid" style="max-width: 400px;">
                    </div>
                </div>
                @endif
            </div>
        </div>
    </div>
</section>
@endsection

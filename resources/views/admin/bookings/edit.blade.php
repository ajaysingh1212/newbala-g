@extends('layouts.admin')



@section('content')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Edit Booking</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('admin.bookings.index') }}">Bookings</a></li>
                    <li class="breadcrumb-item active">Edit</li>
                </ol>
            </div>
        </div>
    </div>
</div>

@include('admin.bookings.partials._wizard-styles')

<section class="content">
    <div class="container-fluid">
        <div class="booking-wizard">

            @include('admin.bookings.partials._wizard-stepper')

            <form id="bookingForm" action="{{ route('admin.bookings.update', $booking->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                @include('admin.bookings.partials._step-booking-details')
                @include('admin.bookings.partials._step-pilgrims')
                @include('admin.bookings.partials._step-review')
                @include('admin.bookings.partials._step-payment')
            </form>
        </div>
    </div>
</section>

@php
    $existingPilgrims = $booking->pilgrims->map(function ($pilgrim) {
        return [
            'id'              => $pilgrim->id,
            'name'            => $pilgrim->name,
            'age'             => $pilgrim->age,
            'gender'          => $pilgrim->gender,
            'phone_number'    => $pilgrim->phone_number,
            'id_type'         => $pilgrim->id_type,
            'id_number'       => $pilgrim->id_number,
            'booking_type_id' => $pilgrim->booking_type_id,
        ];
    })->values();
@endphp
@include('admin.bookings.partials._wizard-script')
@endsection

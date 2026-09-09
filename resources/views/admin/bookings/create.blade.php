@extends('layouts.admin')


@section('content')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Create New Booking</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('admin.bookings.index') }}">Bookings</a></li>
                    <li class="breadcrumb-item active">Create</li>
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

            <form id="bookingForm" action="{{ route('admin.bookings.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                @include('admin.bookings.partials._step-booking-details')
                @include('admin.bookings.partials._step-pilgrims')
                @include('admin.bookings.partials._step-review')
                @include('admin.bookings.partials._step-payment')
            </form>
        </div>
    </div>
</section>

@php $existingPilgrims = []; @endphp
@include('admin.bookings.partials._wizard-script')
@endsection

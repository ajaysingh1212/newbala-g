@extends('layouts.admin')

@section('title', 'Edit Bank Account')

@section('content')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Edit Bank Account</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('admin.bank_accounts.index') }}">Bank Accounts</a></li>
                    <li class="breadcrumb-item active">Edit</li>
                </ol>
            </div>
        </div>
    </div>
</div>

<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-8 offset-md-2">
                <div class="card card-primary">
                    <div class="card-header">
                        <h3 class="card-title">Edit Bank Account</h3>
                    </div>
                    <form action="{{ route('admin.bank_accounts.update', $bankAccount->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="card-body">
                            <div class="form-group">
                                <label for="account_holder_name">Account Holder Name *</label>
                                <input type="text" class="form-control @error('account_holder_name') is-invalid @enderror" 
                                    id="account_holder_name" name="account_holder_name" placeholder="Enter account holder name" value="{{ old('account_holder_name', $bankAccount->account_holder_name) }}" required>
                                @error('account_holder_name')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="bank_name">Bank Name *</label>
                                <input type="text" class="form-control @error('bank_name') is-invalid @enderror" 
                                    id="bank_name" name="bank_name" placeholder="Enter bank name" value="{{ old('bank_name', $bankAccount->bank_name) }}" required>
                                @error('bank_name')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="account_number">Account Number *</label>
                                <input type="text" class="form-control @error('account_number') is-invalid @enderror" 
                                    id="account_number" name="account_number" placeholder="Enter account number" value="{{ old('account_number', $bankAccount->account_number) }}" required>
                                @error('account_number')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="ifsc_code">IFSC Code *</label>
                                <input type="text" class="form-control @error('ifsc_code') is-invalid @enderror" 
                                    id="ifsc_code" name="ifsc_code" placeholder="Enter IFSC code" value="{{ old('ifsc_code', $bankAccount->ifsc_code) }}" required>
                                @error('ifsc_code')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="upi_id">UPI ID</label>
                                <input type="text" class="form-control @error('upi_id') is-invalid @enderror" 
                                    id="upi_id" name="upi_id" placeholder="Enter UPI ID" value="{{ old('upi_id', $bankAccount->upi_id) }}">
                                @error('upi_id')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="upi_scanner">UPI QR Code Scanner Image</label>
                                @if($bankAccount->upi_scanner)
                                    <div class="mb-2">
                                        <img src="{{ asset('storage/' . $bankAccount->upi_scanner) }}" alt="UPI QR Code" class="img-thumbnail" style="max-width: 200px;">
                                    </div>
                                @endif
                                <input type="file" class="form-control @error('upi_scanner') is-invalid @enderror" 
                                    id="upi_scanner" name="upi_scanner" accept="image/*">
                                <small class="form-text text-muted">Upload UPI QR code image (max: 2MB)</small>
                                @error('upi_scanner')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="form-check mb-3">
                                <input type="checkbox" class="form-check-input" id="print_on_ticket" name="print_on_ticket" value="1" {{ $bankAccount->print_on_ticket ? 'checked' : '' }}>
                                <label class="form-check-label" for="print_on_ticket">
                                    Print on Ticket
                                </label>
                                <small class="d-block text-muted">Show this bank account details on the ticket</small>
                            </div>

                            <div class="form-group">
                                <label for="status">Status *</label>
                                <select class="form-control @error('status') is-invalid @enderror" id="status" name="status" required>
                                    <option value="">Select Status</option>
                                    <option value="active" {{ old('status', $bankAccount->status) === 'active' ? 'selected' : '' }}>Active</option>
                                    <option value="inactive" {{ old('status', $bankAccount->status) === 'inactive' ? 'selected' : '' }}>Inactive</option>
                                </select>
                                @error('status')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="card-footer">
                            <button type="submit" class="btn btn-primary">Update</button>
                            <a href="{{ route('admin.bank_accounts.index') }}" class="btn btn-secondary">Cancel</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

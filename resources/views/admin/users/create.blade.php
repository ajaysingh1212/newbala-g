@extends('layouts.admin')

@section('title','Create User')

@section('content')

<div class="card shadow-lg">

<div class="card-header">
    <h3>Create User</h3>
</div>

<form action="{{ route('admin.users.store') }}" method="POST">

@csrf

<div class="card-body">

    <div class="row">
        <div class="col-md-6">
            <label>Name</label>
            <input type="text" name="name" class="form-control" value="{{ old('name') }}" required>
        </div>

        <div class="col-md-6">
            <label>Email</label>
            <input type="email" name="email" class="form-control" value="{{ old('email') }}" required>
        </div>
    </div>

    <br>

    <div class="row">
        <div class="col-md-6">
            <label>Password</label>
            <input type="password" name="password" class="form-control" required>
        </div>

        <div class="col-md-6">
            <label>Role</label>
            <select name="roles[]" class="form-control" required>
                @foreach($roles as $role)
                    <option value="{{ $role->id }}">{{ $role->name }}</option>
                @endforeach
            </select>
        </div>
    </div>

    <hr>

    <div class="row">
        <div class="col-md-4">
            <label>Max Devices Allowed</label>
            <input type="number" name="max_devices" class="form-control" min="1" max="20" value="{{ old('max_devices', 1) }}" required>
        </div>

        <div class="col-md-4">
            <label>Allow Phone Access</label>
            <div class="mt-2">
                <input type="checkbox" name="allow_phone" value="1" {{ old('allow_phone', true) ? 'checked' : '' }}>
                <span class="ml-2">Phone enabled</span>
            </div>
        </div>

        <div class="col-md-4">
            <label>Allow Laptop Access</label>
            <div class="mt-2">
                <input type="checkbox" name="allow_laptop" value="1" {{ old('allow_laptop', true) ? 'checked' : '' }}>
                <span class="ml-2">Laptop enabled</span>
            </div>
        </div>
    </div>

    <div class="mt-4">
        <label>Blocked IPs (one per line)</label>
        <textarea name="blocked_ips" rows="5" class="form-control" placeholder="192.168.1.10&#10;10.0.0.5">{{ old('blocked_ips') }}</textarea>
    </div>

</div>

<div class="card-footer">
    <button class="btn btn-success">
        <i class="fas fa-save"></i> Save
    </button>
</div>

</form>

</div>

@endsection

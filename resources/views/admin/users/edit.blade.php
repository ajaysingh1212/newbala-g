@extends('layouts.admin')

@section('title','Edit User')

@section('content')

<div class="card">

<div class="card-header">
    <h3>Edit User</h3>
</div>

<form action="{{ route('admin.users.update',$user->id) }}" method="POST">

@csrf
@method('PUT')

<div class="card-body">

    <div class="form-group">
        <label>Name</label>
        <input type="text" name="name" value="{{ $user->name }}" class="form-control" required>
    </div>

    <div class="form-group">
        <label>Email</label>
        <input type="email" name="email" value="{{ $user->email }}" class="form-control" required>
    </div>

    <div class="form-group">
        <label>Password</label>
        <input type="password" name="password" class="form-control" placeholder="Leave blank to keep current password">
    </div>

    <div class="form-group">
        <label>Role</label>
        <select name="roles[]" class="form-control" required>
            @foreach($roles as $role)
                <option value="{{ $role->id }}" {{ in_array($role->id,$userRoles) ? 'selected' : '' }}>
                    {{ $role->name }}
                </option>
            @endforeach
        </select>
    </div>

    <hr>

    <div class="row">
        <div class="col-md-4">
            <label>Max Devices Allowed</label>
            <input type="number" name="max_devices" class="form-control" min="1" max="20" value="{{ old('max_devices', $user->max_devices ?? 1) }}" required>
        </div>

        <div class="col-md-4">
            <label>Allow Phone Access</label>
            <div class="mt-2">
                <input type="checkbox" name="allow_phone" value="1" {{ old('allow_phone', $user->allow_phone ?? true) ? 'checked' : '' }}>
                <span class="ml-2">Phone enabled</span>
            </div>
        </div>

        <div class="col-md-4">
            <label>Allow Laptop Access</label>
            <div class="mt-2">
                <input type="checkbox" name="allow_laptop" value="1" {{ old('allow_laptop', $user->allow_laptop ?? true) ? 'checked' : '' }}>
                <span class="ml-2">Laptop enabled</span>
            </div>
        </div>
    </div>

    <div class="mt-4">
        <label>Blocked IPs (one per line)</label>
        <textarea name="blocked_ips" rows="5" class="form-control" placeholder="192.168.1.10&#10;10.0.0.5">{{ old('blocked_ips', implode("\n", (array) ($user->blocked_ips ?? []))) }}</textarea>
    </div>

</div>

<div class="card-footer">
    <button class="btn btn-primary">Update</button>
</div>

</form>

</div>

@endsection

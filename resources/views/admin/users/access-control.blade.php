@extends('layouts.admin')

@section('title', 'User Access Control')

@section('content')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0"><i class="fas fa-shield-alt mr-2"></i>User Access Control</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                    <li class="breadcrumb-item active">User Access Control</li>
                </ol>
            </div>
        </div>
    </div>
</div>

<section class="content">
    <div class="container-fluid">
        <div class="row">
            @foreach($users as $user)
                <div class="col-lg-6 mb-4">
                    <div class="card shadow-sm border-0">
                        <div class="card-header bg-gradient-primary text-white">
                            <h3 class="card-title mb-0">
                                <i class="fas fa-user-shield mr-2"></i>{{ $user->name }}
                            </h3>
                        </div>

                        <div class="card-body">
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <p class="mb-1 text-muted">Email</p>
                                    <strong>{{ $user->email }}</strong>
                                </div>
                                <div class="col-md-6">
                                    <p class="mb-1 text-muted">Roles</p>
                                    <span class="badge badge-info">{{ $user->roles->pluck('name')->implode(', ') ?: 'No role' }}</span>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-md-4">
                                    <div class="info-box bg-light shadow-none mb-0">
                                        <span class="info-box-icon bg-success"><i class="fas fa-mobile-alt"></i></span>
                                        <div class="info-box-content">
                                            <span class="info-box-text">Phone</span>
                                            <span class="info-box-number">{{ $user->allow_phone ? 'Allowed' : 'Blocked' }}</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="info-box bg-light shadow-none mb-0">
                                        <span class="info-box-icon bg-warning"><i class="fas fa-laptop"></i></span>
                                        <div class="info-box-content">
                                            <span class="info-box-text">Laptop</span>
                                            <span class="info-box-number">{{ $user->allow_laptop ? 'Allowed' : 'Blocked' }}</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="info-box bg-light shadow-none mb-0">
                                        <span class="info-box-icon bg-danger"><i class="fas fa-desktop"></i></span>
                                        <div class="info-box-content">
                                            <span class="info-box-text">Max Devices</span>
                                            <span class="info-box-number">{{ $user->max_devices ?? 1 }}</span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <h6 class="font-weight-bold text-primary"><i class="fas fa-ban mr-2"></i>Blocked IPs</h6>
                                    @if(!empty($user->blocked_ips))
                                        <ul class="list-group list-group-flush">
                                            @foreach($user->blocked_ips as $ip)
                                                <li class="list-group-item px-0">
                                                    <span class="badge badge-danger">{{ $ip }}</span>
                                                </li>
                                            @endforeach
                                        </ul>
                                    @else
                                        <p class="text-muted mb-0">No IP blocked</p>
                                    @endif
                                </div>

                                <div class="col-md-6">
                                    <h6 class="font-weight-bold text-success"><i class="fas fa-history mr-2"></i>Login History</h6>
                                    @if($user->login_history && $user->login_history->isNotEmpty())
                                        <div class="table-responsive">
                                            <table class="table table-sm table-bordered mb-0">
                                                <thead class="thead-light">
                                                    <tr>
                                                        <th>IP</th>
                                                        <th>Device</th>
                                                        <th>Login Time</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach($user->login_history as $session)
                                                        <tr>
                                                            <td><span class="badge badge-secondary">{{ $session->ip_address ?: 'Unknown' }}</span></td>
                                                            <td>{{ Str::limit($session->user_agent ?: 'Unknown Device', 35) }}</td>
                                                            <td>{{ $session->last_activity_formatted ?? '-' }}</td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    @else
                                        <p class="text-muted mb-0">No login history found</p>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>
@endsection

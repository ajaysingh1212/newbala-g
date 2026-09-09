@extends('layouts.admin')



@section('content')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">
                    <i class="fas fa-tags text-info"></i> Booking Types
                </h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}"><i class="fas fa-home"></i> Home</a></li>
                    <li class="breadcrumb-item active">Booking Types</li>
                </ol>
            </div>
        </div>
    </div>
</div>

<section class="content">
    <div class="container-fluid">
        @if($message = Session::get('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="fas fa-check-circle"></i> <strong>Success!</strong> {{ $message }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        @endif

        <div class="card card-outline card-primary">
            <div class="card-header bg-gradient-primary">
                <div class="row align-items-center">
                    <div class="col-md-6">
                        <h3 class="card-title">
                            <i class="fas fa-list"></i> Manage Booking Types
                        </h3>
                    </div>
                    <div class="col-md-6 text-right">
                        <a href="{{ route('admin.booking_types.create') }}" class="btn btn-success btn-sm">
                            <i class="fas fa-plus-circle"></i> Add New Booking Type
                        </a>
                    </div>
                </div>
            </div>
            <div class="card-body p-0">
                <table id="bookingTypesTable" class="table table-striped table-hover">
                    <thead class="bg-gradient-dark">
                        <tr>
                            <th style="width: 5%">#</th>
                            <th style="width: 25%">Title</th>
                            <th style="width: 15%">Amount (₹)</th>
                            <th style="width: 30%">Description</th>
                            <th style="width: 10%">Status</th>
                            <th style="width: 15%">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($bookingTypes as $type)
                        <tr class="align-middle">
                            <td>
                                <span class="badge badge-info">{{ $type->id }}</span>
                            </td>
                            <td>
                                <strong class="text-info">{{ $type->title }}</strong>
                            </td>
                            <td>
                                <span class="badge badge-warning badge-pill">₹{{ number_format($type->amount, 2) }}</span>
                            </td>
                            <td>
                                <small class="text-muted">{{ Str::limit($type->description, 50) }}</small>
                            </td>
                            <td>
                                @if($type->status === 'active')
                                    <span class="badge badge-success badge-pill">
                                        <i class="fas fa-check-circle"></i> Active
                                    </span>
                                @else
                                    <span class="badge badge-danger badge-pill">
                                        <i class="fas fa-times-circle"></i> Inactive
                                    </span>
                                @endif
                            </td>
                            <td>
                                <div class="btn-group btn-group-sm" role="group">
                                    <a href="{{ route('admin.booking_types.edit', $type->id) }}" class="btn btn-info" title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="{{ route('admin.booking_types.destroy', $type->id) }}" method="POST" style="display:inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger" title="Delete" onclick="return confirm('Are you sure?')">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="card-footer text-center text-muted small">
                Showing {{ $bookingTypes->count() }} booking types
            </div>
        </div>
    </div>
</section>

@endsection

@section('scripts')
<script>
$(function() {
    $('#bookingTypesTable').DataTable({
        "paging": true,
        "lengthChange": true,
        "searching": true,
        "ordering": true,
        "info": true,
        "autoWidth": false,
        "responsive": true,
        "pageLength": 10,
        "order": [[0, "desc"]],
        "columnDefs": [
            {
                "targets": [5],
                "orderable": false,
                "searchable": false
            }
        ],
        "language": {
            "paginate": {
                "first": '<i class="fas fa-step-backward"></i>',
                "last": '<i class="fas fa-step-forward"></i>',
                "next": '<i class="fas fa-chevron-right"></i>',
                "previous": '<i class="fas fa-chevron-left"></i>'
            }
        }
    });
});
</script>
@endsection

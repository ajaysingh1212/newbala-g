@extends('layouts.admin')



@section('content')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">
                    <i class="fas fa-landmark text-success"></i> Bank Accounts
                </h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}"><i class="fas fa-home"></i> Home</a></li>
                    <li class="breadcrumb-item active">Bank Accounts</li>
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

        <div class="card card-outline card-success">
            <div class="card-header bg-gradient-success">
                <div class="row align-items-center">
                    <div class="col-md-6">
                        <h3 class="card-title">
                            <i class="fas fa-university"></i> Manage Bank Accounts
                        </h3>
                    </div>
                    <div class="col-md-6 text-right">
                        <a href="{{ route('admin.bank_accounts.create') }}" class="btn btn-primary btn-sm">
                            <i class="fas fa-plus-circle"></i> Add Bank Account
                        </a>
                    </div>
                </div>
            </div>
            <div class="card-body p-0">
                <table id="bankAccountsTable" class="table table-striped table-hover">
                    <thead class="bg-gradient-dark">
                        <tr>
                            <th style="width: 5%">#</th>
                            <th style="width: 20%">Account Holder</th>
                            <th style="width: 18%">Bank Name</th>
                            <th style="width: 18%">Account Number</th>
                            <th style="width: 12%">UPI ID</th>
                            <th style="width: 8%">Print</th>
                            <th style="width: 10%">Status</th>
                            <th style="width: 9%">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($bankAccounts as $account)
                        <tr>
                            <td>
                                <span class="badge badge-info">{{ $account->id }}</span>
                            </td>
                            <td>
                                <strong class="text-info">{{ $account->account_holder_name }}</strong>
                            </td>
                            <td>
                                <i class="fas fa-bank"></i> {{ $account->bank_name }}
                            </td>
                            <td>
                                <small class="text-muted">{{ $account->account_number }}</small>
                            </td>
                            <td>
                                @if($account->upi_id)
                                    <span class="badge badge-warning">{{ $account->upi_id }}</span>
                                @else
                                    <span class="text-muted">-</span>
                                @endif
                            </td>
                            <td>
                                @if($account->print_on_ticket)
                                    <span class="badge badge-success">
                                        <i class="fas fa-check"></i> Yes
                                    </span>
                                @else
                                    <span class="badge badge-secondary">
                                        <i class="fas fa-times"></i> No
                                    </span>
                                @endif
                            </td>
                            <td>
                                @if($account->status === 'active')
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
                                    <a href="{{ route('admin.bank_accounts.edit', $account->id) }}" class="btn btn-info" title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="{{ route('admin.bank_accounts.destroy', $account->id) }}" method="POST" style="display:inline;">
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
                Showing {{ $bankAccounts->count() }} bank accounts
            </div>
        </div>
    </div>
</section>

@endsection

@section('scripts')
<script>
$(function() {
    $('#bankAccountsTable').DataTable({
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
                "targets": [7],
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

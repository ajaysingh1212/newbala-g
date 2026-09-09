<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BankAccount extends Model
{
    protected $fillable = [
        'account_holder_name',
        'account_number',
        'ifsc_code',
        'bank_name',
        'upi_id',
        'upi_scanner',
        'print_on_ticket',
        'status'
    ];

    protected $casts = [
        'print_on_ticket' => 'boolean',
        'status' => 'string',
    ];
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pilgrim extends Model
{
    protected $fillable = [
        'booking_id',
        'name',
        'age',
        'phone_number',
        'id_type',
        'id_number',
        'gender',
        'booking_type_id',
        'amount',
        'ticket_id'
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'age' => 'integer',
        'id_type' => 'string',
        'gender' => 'string',
    ];

    public function booking()
    {
        return $this->belongsTo(Booking::class);
    }

    public function bookingType()
    {
        return $this->belongsTo(BookingType::class);
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BookingType extends Model
{
    protected $fillable = [
        'title',
        'amount',
        'description',
        'status'
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'status' => 'string',
    ];

    public function pilgrims()
    {
        return $this->hasMany(Pilgrim::class);
    }
}

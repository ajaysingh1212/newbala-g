<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use App\Models\User;

class Booking extends Model
{
    protected $fillable = [
        'ticket_number',
        'created_by',
        'group_name',
        'main_person_name',
        'email',
        'visiting_date',
        'slot_time',
        'total_amount',
        'payment_status',
        'payment_screenshot',
        'ref_utr',
        'status'
    ];

    protected $casts = [
        'total_amount' => 'decimal:2',
        'visiting_date' => 'date',
        'payment_status' => 'string',
        'status' => 'string',
    ];

    protected static function booted(): void
    {
        static::creating(function (self $booking) {
            if (empty($booking->ticket_number)) {
                $booking->ticket_number = self::generateTicketNumber();
            }
        });
    }

    public static function generateTicketNumber(): string
    {
        do {
            $letters = strtoupper(substr(str_shuffle('ABCDEFGHIJKLMNOPQRSTUVWXYZ'), 0, 5));
            $numbers = str_pad((string) random_int(10000, 99999), 5, '0', STR_PAD_LEFT);
            $ticketNumber = $letters . $numbers;
        } while (self::where('ticket_number', $ticketNumber)->exists());

        return $ticketNumber;
    }

    public function pilgrims()
    {
        return $this->hasMany(Pilgrim::class);
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function scopeVisibleTo(Builder $query, User $user): Builder
    {
        return $user->isSuperAdmin() ? $query : $query->where('created_by', $user->id);
    }
}

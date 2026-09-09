<?php

namespace Tests\Feature;

use App\Models\Booking;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class BookingTicketNumberTest extends TestCase
{
    use RefreshDatabase;

    public function test_booking_ticket_number_is_generated_in_required_format(): void
    {
        $first = Booking::create([
            'group_name' => 'Group One',
            'main_person_name' => 'John Doe',
            'email' => 'john@example.com',
            'visiting_date' => '2026-08-20',
            'slot_time' => '10:00 AM',
            'total_amount' => 1500,
            'payment_status' => 'pending',
            'status' => 'pending',
        ]);

        $second = Booking::create([
            'group_name' => 'Group Two',
            'main_person_name' => 'Jane Doe',
            'email' => 'jane@example.com',
            'visiting_date' => '2026-08-21',
            'slot_time' => '12:00 PM',
            'total_amount' => 2000,
            'payment_status' => 'confirmed',
            'status' => 'pending',
        ]);

        $this->assertMatchesRegularExpression('/^[A-Z]{5}\d{5}$/', $first->ticket_number);
        $this->assertMatchesRegularExpression('/^[A-Z]{5}\d{5}$/', $second->ticket_number);
        $this->assertNotSame($first->ticket_number, $second->ticket_number);
    }
}

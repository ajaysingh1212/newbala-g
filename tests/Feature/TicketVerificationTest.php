<?php

namespace Tests\Feature;

use App\Models\Booking;
use App\Models\Pilgrim;
use App\Models\BookingType;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TicketVerificationTest extends TestCase
{
    use RefreshDatabase;

    public function test_public_ticket_verification_page_loads_for_valid_ticket(): void
    {
        $bookingType = BookingType::create([
            'title' => 'VIP Darshan',
            'amount' => 1500,
            'description' => 'VIP access',
            'status' => 'active',
        ]);

        $booking = Booking::create([
            'group_name' => 'Test Group',
            'main_person_name' => 'Amit Singh',
            'email' => 'amit@example.com',
            'visiting_date' => '2026-08-20',
            'slot_time' => '10:00 AM',
            'total_amount' => 1500,
            'payment_status' => 'confirmed',
            'status' => 'pending',
        ]);

        $pilgrim = Pilgrim::create([
            'booking_id' => $booking->id,
            'name' => 'Rohan Singh',
            'age' => 32,
            'phone_number' => '9876543210',
            'id_type' => 'aadhar',
            'id_number' => '123456789012',
            'gender' => 'male',
            'booking_type_id' => $bookingType->id,
            'amount' => 1500,
            'ticket_id' => 'IDJ260803000001',
        ]);

        $response = $this->get(route('ticket.verify', ['ticketId' => $pilgrim->ticket_id]));

        $response->assertOk();
        $response->assertSee('Rohan Singh');
        $response->assertSee('Test Group');
    }

    public function test_ticket_view_embeds_qr_code_data_uri(): void
    {
        $bookingType = BookingType::create([
            'title' => 'VIP Darshan',
            'amount' => 1500,
            'description' => 'VIP access',
            'status' => 'active',
        ]);

        $booking = Booking::create([
            'group_name' => 'Test Group',
            'main_person_name' => 'Amit Singh',
            'email' => 'amit@example.com',
            'visiting_date' => '2026-08-20',
            'slot_time' => '10:00 AM',
            'total_amount' => 1500,
            'payment_status' => 'confirmed',
            'status' => 'pending',
        ]);

        Pilgrim::create([
            'booking_id' => $booking->id,
            'name' => 'Rohan Singh',
            'age' => 32,
            'phone_number' => '9876543210',
            'id_type' => 'aadhar',
            'id_number' => '123456789012',
            'gender' => 'male',
            'booking_type_id' => $bookingType->id,
            'amount' => 1500,
            'ticket_id' => 'IDJ260803000002',
        ]);

        $booking->load('pilgrims.bookingType');
        $html = view('admin.bookings.ticket', ['booking' => $booking])->render();

        $this->assertStringContainsString('data:image/png;base64,', $html);
        $this->assertStringContainsString('IDJ260803000002', $html);
        $this->assertStringContainsString('page-break-inside: avoid', $html);
    }

    public function test_booking_status_can_be_updated_from_index_page(): void
    {
        $user = User::factory()->create();

        $booking = Booking::create([
            'group_name' => 'Test Group',
            'main_person_name' => 'Amit Singh',
            'email' => 'amit@example.com',
            'visiting_date' => '2026-08-20',
            'slot_time' => '10:00 AM',
            'total_amount' => 1500,
            'payment_status' => 'confirmed',
            'status' => 'pending',
        ]);

        $response = $this->actingAs($user)->post(route('admin.bookings.update-status', $booking->id), [
            'status' => 'completed',
        ]);

        $response->assertRedirect(route('admin.bookings.index'));
        $this->assertDatabaseHas('bookings', [
            'id' => $booking->id,
            'status' => 'completed',
        ]);

        $indexResponse = $this->actingAs($user)->get(route('admin.bookings.index'));
        $indexResponse->assertSee('Confirm');
        $indexResponse->assertSee('Reject');
    }
}

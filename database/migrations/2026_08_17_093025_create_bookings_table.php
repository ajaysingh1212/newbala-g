<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('bookings', function (Blueprint $table) {
            $table->id();
            $table->string('ticket_number')->unique()->nullable();
            $table->string('group_name');
            $table->string('main_person_name');
            $table->string('email');
            $table->date('visiting_date');
            $table->string('slot_time');
            $table->decimal('total_amount', 10, 2)->default(0);
            $table->enum('payment_status', ['confirmed', 'pending'])->default('pending');
            $table->string('payment_screenshot')->nullable();
            $table->string('ref_utr')->nullable();
            $table->enum('status', ['completed', 'pending', 'cancelled'])->default('pending');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bookings');
    }
};

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
        Schema::create('pilgrims', function (Blueprint $table) {
            $table->id();
            $table->foreignId('booking_id')->constrained()->onDelete('cascade');
            $table->string('name');
            $table->integer('age');
            $table->string('phone_number');
            $table->enum('id_type', ['aadhar', 'pan', 'other'])->default('aadhar');
            $table->string('id_number');
            $table->enum('gender', ['male', 'female', 'other'])->default('male');
            $table->foreignId('booking_type_id')->constrained('booking_types');
            $table->decimal('amount', 10, 2);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pilgrims');
    }
};

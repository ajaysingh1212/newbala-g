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
        Schema::table('users', function (Blueprint $table) {
            $table->unsignedInteger('max_devices')->default(1)->after('password');
            $table->boolean('allow_phone')->default(true)->after('max_devices');
            $table->boolean('allow_laptop')->default(true)->after('allow_phone');
            $table->json('blocked_ips')->nullable()->after('allow_laptop');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['max_devices', 'allow_phone', 'allow_laptop', 'blocked_ips']);
        });
    }
};

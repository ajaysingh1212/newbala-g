<?php

namespace Tests\Feature;

use App\Models\Role;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserDeviceAccessTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_be_blocked_by_ip_and_device_type(): void
    {
        $superAdminRole = Role::create(['name' => 'Super Admin', 'slug' => 'super-admin']);
        $adminRole = Role::create(['name' => 'Admin', 'slug' => 'admin']);

        $user = User::factory()->create([
            'name' => 'Test Admin',
            'email' => 'admin@example.com',
            'max_devices' => 1,
            'allow_phone' => false,
            'allow_laptop' => true,
            'blocked_ips' => ['192.168.1.12'],
        ]);

        $user->roles()->sync([$adminRole->id]);

        $this->assertFalse($user->canUseDeviceType('phone'));
        $this->assertTrue($user->canUseDeviceType('laptop'));
        $this->assertTrue($user->isIpBlocked('192.168.1.12'));
        $this->assertFalse($user->canLoginOnDevice('Mozilla/5.0 (Windows NT 10.0; Win64; x64)', '192.168.1.12'));
    }

    public function test_user_device_limit_blocks_new_device_when_limit_is_reached(): void
    {
        $adminRole = Role::create(['name' => 'Admin', 'slug' => 'admin']);

        $user = User::factory()->create([
            'name' => 'Limited Admin',
            'email' => 'limited@example.com',
            'max_devices' => 2,
            'allow_phone' => true,
            'allow_laptop' => true,
            'blocked_ips' => [],
        ]);

        $user->roles()->sync([$adminRole->id]);

        \Illuminate\Support\Facades\DB::table('sessions')->insert([
            ['id' => 'device-1', 'user_id' => $user->id, 'ip_address' => '127.0.0.1', 'user_agent' => 'Phone Agent', 'payload' => 'x', 'last_activity' => now()->timestamp],
            ['id' => 'device-2', 'user_id' => $user->id, 'ip_address' => '127.0.0.2', 'user_agent' => 'Laptop Agent', 'payload' => 'x', 'last_activity' => now()->timestamp],
        ]);

        $this->assertFalse($user->canLoginOnDevice('Mozilla/5.0 (iPhone; CPU iPhone OS 17_0 like Mac OS X)', '127.0.0.3'));
        $this->assertFalse($user->canLoginOnDevice('Mozilla/5.0 (Windows NT 10.0; Win64; x64)', '127.0.0.3'));
    }

    public function test_super_admin_can_view_user_access_control_dashboard(): void
    {
        $superAdminRole = Role::create(['name' => 'Super Admin', 'slug' => 'super-admin']);
        $adminRole = Role::create(['name' => 'Admin', 'slug' => 'admin']);

        $superAdmin = User::factory()->create([
            'name' => 'Super Admin',
            'email' => 'superadmin-dashboard@example.com',
        ]);
        $superAdmin->roles()->sync([$superAdminRole->id]);

        $user = User::factory()->create([
            'name' => 'Dashboard User',
            'email' => 'dashboard-user@example.com',
            'max_devices' => 2,
            'allow_phone' => true,
            'allow_laptop' => false,
            'blocked_ips' => ['10.0.0.7'],
        ]);
        $user->roles()->sync([$adminRole->id]);

        \Illuminate\Support\Facades\DB::table('sessions')->insert([
            ['id' => 'history-1', 'user_id' => $user->id, 'ip_address' => '192.168.1.10', 'user_agent' => 'Mozilla/5.0 (iPhone; CPU iPhone OS 17_0 like Mac OS X)', 'payload' => 'x', 'last_activity' => now()->subMinutes(20)->timestamp],
            ['id' => 'history-2', 'user_id' => $user->id, 'ip_address' => '203.0.113.15', 'user_agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64)', 'payload' => 'x', 'last_activity' => now()->subHours(2)->timestamp],
        ]);

        $this->actingAs($superAdmin)
            ->get('/admin/user-access-control')
            ->assertOk()
            ->assertSee('User Access Control')
            ->assertSee('Dashboard User')
            ->assertSee('192.168.1.10')
            ->assertSee('203.0.113.15');
    }
}

<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Role;
use Hash;

class UserSeeder extends Seeder
{

public function run(): void
{

/*
Create Roles
*/

$superAdmin = Role::create([
'name' => 'Super Admin',
'slug' => 'super-admin'
]);

$admin = Role::create([
'name' => 'Admin',
'slug' => 'admin'
]);

$userRole = Role::create([
'name' => 'User',
'slug' => 'user'
]);


/*
Create Users
*/

$superAdminUser = User::create([
'name' => 'Super Admin',
'email' => 'superadmin@gmail.com',
'password' => Hash::make('12345678'),
'max_devices' => 5,
'allow_phone' => true,
'allow_laptop' => true,
'blocked_ips' => []
]);

$adminUser = User::create([
'name' => 'Admin',
'email' => 'admin@gmail.com',
'password' => Hash::make('12345678'),
'max_devices' => 2,
'allow_phone' => true,
'allow_laptop' => true,
'blocked_ips' => []
]);

$normalUser = User::create([
'name' => 'User',
'email' => 'user@gmail.com',
'password' => Hash::make('12345678'),
'max_devices' => 1,
'allow_phone' => true,
'allow_laptop' => false,
'blocked_ips' => []
]);


/*
Assign Roles
*/

$superAdminUser->roles()->sync([$superAdmin->id]);

$adminUser->roles()->sync([$admin->id]);

$normalUser->roles()->sync([$userRole->id]);

}
}

<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        $users = [
            ['name' => 'Admin Demo', 'email' => 'admin@demo.com', 'role' => 'Admin'],
            ['name' => 'Manager Demo', 'email' => 'manager@demo.com', 'role' => 'Manager'],
            ['name' => 'Staff Demo', 'email' => 'staff@demo.com', 'role' => 'Staff'],
        ];

        foreach ($users as $data) {
            $user = User::updateOrCreate(
                ['email' => $data['email']],
                [
                    'name' => $data['name'],
                    'password' => Hash::make('password'),
                    'email_verified_at' => now(),
                ]
            );
            $user->syncRoles([$data['role']]);
        }
    }
}

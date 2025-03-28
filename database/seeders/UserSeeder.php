<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\{User,Store};
use Spatie\Permission\Models\Role;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create or update roles
        $roles = [
            ['name' => 'admin'],
            ['name' => 'store'],
            ['name' => 'user'],
            ['name' => 'customer'],
        ];

        foreach ($roles as $role) {
            Role::updateOrCreate(['name' => $role['name']]);
        }

        // Define users and their corresponding roles
        $users = [
            [
                'name' => 'deep',
                'email' => 'deep@gmail.com',
                'password' => bcrypt('pass@store'),
                'role' => 'store',
            ],
            [
                'name' => 'admin',
                'email' => 'admin@gmail.com',
                'password' => bcrypt('pass@admin'),
                'role' => 'admin',
            ],
            [
                'name' => 'sunil',
                'email' => 'sunil@gmail.com',
                'password' => bcrypt('pass@user'),
                'role' => 'user',
            ],
        ];

        // Add 5 customers
        for ($i = 1; $i <= 5; $i++) {
            $users[] = [
                'name' => "customer$i",
                'email' => "customer$i@gmail.com",
                'password' => bcrypt('pass@customer'),
                'role' => 'customer',
            ];
        }

        // Create or update users and assign roles
        foreach ($users as $userData) {
            $user = User::updateOrCreate(
                ['email' => $userData['email']], // Search condition
                [
                    'name' => $userData['name'],
                    'password' => $userData['password'],
                ]
            );

            // Assign the correct role to the user
            $role = Role::where('name', $userData['role'])->first();
            if ($role) {
                $user->syncRoles([$role]);
            }
            if($userData['role'] == "store"){
                Store::create([
                    'name' => 'Deep Store',
                    'description' => 'a cake store',
                    'user_id' => $user->id,
                    'status' => true
                ]);
            }
        }
    }
}

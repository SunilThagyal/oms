<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
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
        }
    }
}

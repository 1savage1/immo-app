<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Property;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Create Admin User
        $admin = User::create([
            'name' => 'Admin User',
            'email' => 'admin@admin.com',
            'password' => Hash::make('password'),
            'is_admin' => true,
        ]);

        // Create Normal User
        $user = User::create([
            'name' => 'John Doe',
            'email' => 'user@user.com',
            'password' => Hash::make('password'),
            'is_admin' => false,
        ]);

        // Create some properties
        Property::create([
            'user_id' => $user->id,
            'owner_email' => 'owner1@example.com',
            'owner_phone' => '0555001122',
            'title' => 'Luxury Villa in Oran',
            'description' => 'A beautiful luxury villa located near the beach with a stunning view.',
            'category' => 'villa',
            'operation' => 'vente',
            'city' => 'Oran',
            'rooms' => 5,
            'area' => 300,
            'price' => 45000000,
            'status' => 'approved',
        ]);

        Property::create([
            'user_id' => $user->id,
            'owner_email' => 'owner2@example.com',
            'owner_phone' => '0555001133',
            'title' => 'Modern Apartment Algiers',
            'description' => 'A cozy modern apartment in the center of Algiers.',
            'category' => 'appartement',
            'operation' => 'location',
            'city' => 'Algiers',
            'rooms' => 3,
            'area' => 120,
            'price' => 80000,
            'status' => 'approved',
        ]);

        Property::create([
            'user_id' => $user->id,
            'owner_email' => 'owner3@example.com',
            'owner_phone' => '0555001144',
            'title' => 'Studio for rent in Constantine',
            'description' => 'A nice small studio perfect for students.',
            'category' => 'studio',
            'operation' => 'location',
            'city' => 'Constantine',
            'rooms' => 1,
            'area' => 40,
            'price' => 30000,
            'status' => 'pending',
        ]);
    }
}

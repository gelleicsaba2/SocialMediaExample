<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Relation;
use Illuminate\Support\Facades\DB;


class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::create([
            'name' => 'Admin User',
            'email' => 'admin@example.com',
            'password' => Hash::make('11111111'), // Make sure to hash the password
            'email_verified_at' => now(), // Mark the email as verified
            'is_admin' => true, // Assuming you have an is_admin column in your users table
        ]);

        User::create([
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => Hash::make('22222222'), // Make sure to hash the password
            'email_verified_at' => now(), // Mark the email as verified
        ]);

        User::create([
            'name' => 'John Deer',
            'email' => 'john@example.com',
            'password' => Hash::make('33333333'), // Make sure to hash the password
            'email_verified_at' => null, // Mark the email as verified
        ]);



    }
}

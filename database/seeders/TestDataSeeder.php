<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Relation;
use Illuminate\Support\Facades\DB;

class TestDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Relation::create([
            'user_id' => 3,
            'friend_id' => 2,
            'accepted' => false,
        ]);

        // create faker users
        User::factory(16)->create();
        DB::statement('UPDATE users SET email_verified_at = NULL WHERE id > 3');
    }
}

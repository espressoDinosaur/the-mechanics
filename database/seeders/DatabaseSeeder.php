<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::factory()->create([
            'name' => 'Richard Allen Gabor',
            'email' => 'gabor.richard@clsu2.edu.ph',
            'password' => '021004',
            'role' => '1',
        ]);
    }
}

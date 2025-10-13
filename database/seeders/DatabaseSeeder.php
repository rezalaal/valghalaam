<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::factory()->create([
            'first_name' => 'Admin',
            'last_name' => 'User',
            'phone' => '0000000000',
            'email' => 'admin@local.tld',
            'password' => Hash::make('admin')
        ]);
        
        User::factory()->create([
            'first_name' => 'Test',
            'last_name' => 'User',
            'phone' => '09123456789',
            'email' => null,
            'password' => Hash::make('test')
        ]);
    }
}

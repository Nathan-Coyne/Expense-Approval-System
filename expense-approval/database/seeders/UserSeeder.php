<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    public function run() {
        User::factory()
            ->create(['name' => 'Login', 'email' => 'test@example.com', 'password' => bcrypt('password')]);
        User::factory()
            ->create(['name' => 'Admin Login', 'email' => 'test_admin@example.com', 'password' => bcrypt('password')]);
        $this->command->info('Users populated successfully!');

    }
}

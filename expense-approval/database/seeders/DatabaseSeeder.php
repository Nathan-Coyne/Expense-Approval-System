<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
                PermissionSeeder::class,
                CategorySeeder::class,
                StatusSeeder::class,
                UserSeeder::class,
                UserPermissionSeeder::class,
            ]
        );
        $this->command->info('Database populated!');
    }
}

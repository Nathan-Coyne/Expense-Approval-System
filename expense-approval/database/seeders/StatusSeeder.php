<?php

namespace Database\Seeders;
use App\Models\Status;
use Illuminate\Database\Seeder;


class StatusSeeder extends Seeder
{
    public function run(): void
    {
        Status::firstOrCreate(['slug' => 'pending', 'name' => 'Pending']);
        Status::firstOrCreate(['slug' => 'approved', 'name' => 'Approved']);
        Status::firstOrCreate(['slug' => 'rejected', 'name' => 'Rejected']);

        $this->command->info('Expense Category successfully!');
    }

}

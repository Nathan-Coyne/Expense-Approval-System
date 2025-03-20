<?php

namespace Database\Seeders;

use App\Models\Expense;
use App\Models\Status;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;

class ExpenseSeeder extends Seeder
{
    public function run(): void
    {
        // Clean up storage
        Storage::disk('receipts')->deleteDirectory('receipts');
        Storage::disk('receipts')->makeDirectory('receipts');
        $pending = Status::where('name', 'Pending')->first();
        $approved = Status::where('name', 'Approved')->first();
        $rejected = Status::where('name', 'Rejected')->first();
        // Get test user
        $user = User::first();

        // Create 50 expenses
        Expense::factory(50)
            ->for($user)
            ->create()
            ->each(function ($expense) use ($pending, $approved, $rejected) {
                // Attach initial status
                $expense->statuses()->attach($pending->id);

                // Randomly approve or reject 30% of expenses
                if (rand(1, 100) <= 30) {
                    $status = rand(1, 100) <= 70 ? $approved : $rejected;

                    $expense->statuses()->detach($pending->id);
                    $expense->statuses()->attach($status->id);

                }
            });
    }
}

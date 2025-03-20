<?php

namespace Database\Seeders;

use App\Enum\PlatformPermissions;
use App\Models\Category\Category;
use App\Models\Category\ExpenseCategory;
use App\Models\Expense;
use App\Models\Permission;
use App\Models\Platform;
use App\Models\User;
use Illuminate\Database\Seeder;

class FileSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        ExpenseCategory::firstOrCreate(['name' => 'Travel', 'slug' => 'travel']);
        ExpenseCategory::firstOrCreate(['name' => 'Food', 'slug' => 'food']);
        ExpenseCategory::firstOrCreate(['name' => 'Office', 'slug' => 'office']);
        ExpenseCategory::firstOrCreate(['name' => 'Other', 'slug' => 'other']);

        $this->command->info('Expense Category successfully!');
    }
}

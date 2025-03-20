<?php

namespace Database\Seeders;

use App\Enum\PlatformPermissions;
use App\Models\Permission;
use App\Models\Platform;
use App\Models\User;
use Illuminate\Database\Seeder;

class ExpensePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $submitPermission = Permission::firstOrCreate([
            'name' => PlatformPermissions::SUBMIT_EXPENSES,
            'description' => 'Allows submitting expenses'
        ]);

        $approvePermission = Permission::firstOrCreate([
            'name' => PlatformPermissions::APPROVE_EXPENSES,
            'description' => 'Allows approving expenses'
        ]);

        $platform = Platform::firstOrCreate(['name' => 'Test Platform']);

        $submitter = User::factory()->create(['name' => 'Login', 'email' => 'test@example.com', 'password' => bcrypt('password')]);
        $approver = User::factory()->create(['name' => 'Admin Login', 'email' => 'test_admin@example.com', 'password' => bcrypt('password')]);

        $platform->grantees(User::class)->attach($platform->id, [
            'permission_id' => $submitPermission->id,
            'granter_type' => Platform::class,
            'grantee_type' => User::class,
            'grantee_id' => $submitter->id
        ]);

        $platform->grantees(User::class)->attach($platform->id, [
            'permission_id' => $approvePermission->id,
            'granter_type' => Platform::class,
            'grantee_type' => User::class,
            'grantee_id' => $approver->id
        ]);

        $this->command->info('Expense permissions seeded successfully!');
    }
}

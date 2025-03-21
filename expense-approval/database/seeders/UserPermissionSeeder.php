<?php

namespace Database\Seeders;

use App\Enum\PlatformPermissions;
use App\Models\Permission;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserPermissionSeeder extends Seeder
{
    public function run()
    {
        $subUser = User::where('email', 'test@example.com')->first();
        $appUser =  User::where('email', 'test_admin@example.com')->first();
        $submitPermission = Permission::where([
            'slug' => PlatformPermissions::SUBMIT_EXPENSES->value,
        ])->first();

        $approvePermission = Permission::where([
            'slug' => PlatformPermissions::APPROVE_EXPENSES->value,
        ])->first();
        $subUser->permissions()->attach([$submitPermission->id]);
        $appUser->permissions()->attach([$approvePermission->id]);

        $this->command->info('User Permissions populated successfully!');

    }

}

<?php

namespace Database\Seeders;

use App\Enum\PlatformPermissions;
use App\Models\Permission;
use Illuminate\Database\Seeder;

class PermissionSeeder extends Seeder
{
    public function run()
    {
        // Create permissions
        $permissions = [
            [
                'slug' => PlatformPermissions::VIEW_EXPENSES->value,
                'description' => PlatformPermissions::VIEW_EXPENSES->getDescription(),
                'name' => PlatformPermissions::VIEW_EXPENSES->getPlatformPermissionName()
            ],
            [
                'slug' => PlatformPermissions::SUBMIT_EXPENSES->value,
                'description' => PlatformPermissions::SUBMIT_EXPENSES->getDescription(),
                'name' => PlatformPermissions::SUBMIT_EXPENSES->getPlatformPermissionName()
            ],
            [
                'slug' => PlatformPermissions::APPROVE_EXPENSES->value,
                'description' => PlatformPermissions::APPROVE_EXPENSES->getDescription(),
                'name' => PlatformPermissions::APPROVE_EXPENSES->getPlatformPermissionName()
            ],
            [
                'slug' => PlatformPermissions::VIEW_EXPENSE_REPORT->value,
                'description' => PlatformPermissions::VIEW_EXPENSE_REPORT->getDescription(),
                'name' => PlatformPermissions::VIEW_EXPENSE_REPORT->getPlatformPermissionName()
            ],
        ];

        foreach ($permissions as $permission) {
            Permission::create($permission);
        }
    }

}

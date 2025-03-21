<?php

namespace App\Enum;

use App\Models\Permission;

enum PlatformPermissions: string
{
    case VIEW_EXPENSES = 'view_expenses';
    case APPROVE_EXPENSES = 'approve_expense';
    case SUBMIT_EXPENSES = 'submit_expense';
    case VIEW_EXPENSE_REPORT = 'view_expenses_report';

    public function getDescription(): string
    {
        return match($this) {
            self::VIEW_EXPENSES => 'View your expenses',
            self::APPROVE_EXPENSES => 'Allows approving expenses',
            self::SUBMIT_EXPENSES => 'Allows submitting expenses',
            self::VIEW_EXPENSE_REPORT => 'View expenses report',
        };
    }

    public function getPlatformPermission(): Permission
    {
        return new Permission([
            'name' => $this->value,
            'description' => $this->getDescription(),
        ]);
    }

    public function getPlatformPermissionName(): string
    {
        return match($this) {
            self::VIEW_EXPENSES => 'View expenses',
            self::APPROVE_EXPENSES => 'Approve expenses',
            self::SUBMIT_EXPENSES => 'Submit expenses',
            self::VIEW_EXPENSE_REPORT => 'View expenses report',
        };
    }
}

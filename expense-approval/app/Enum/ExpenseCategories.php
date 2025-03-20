<?php

namespace App\Enum;

use App\Exceptions\ExpenseCategoryException;

enum ExpenseCategories: string
{
    case Travel = 'Travel';
    case Food = 'Food';
    case Office = 'Office';
    case Other = 'Other';

    public static function fromValueOrFail(string $value): self
    {
        return self::tryFrom($value) ?? throw ExpenseCategoryException::notFound($value);
    }
}

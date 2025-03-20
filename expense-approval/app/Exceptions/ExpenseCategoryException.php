<?php

namespace App\Exceptions;

class ExpenseCategoryException extends \Exception
{
    public const CATEGORY_NOT_FOUND = 1004;

    public static function notFound(string $identifier): self
    {
        return new self(
            "Expense category not found: {$identifier}",
            self::CATEGORY_NOT_FOUND,
            null,
        );
    }
}

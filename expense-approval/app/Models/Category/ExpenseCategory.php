<?php

namespace App\Models\Category;

use App\Models\Expense;

class ExpenseCategory extends Category
{
    protected $table = 'categories';
    protected static function booted()
    {
        static::addGlobalScope('expense', function ($builder) {
            $builder->where('categorizable_type', Expense::class);
        });

        static::creating(function ($model) {
            $model->categorizable_type = Expense::class;
        });
    }
}

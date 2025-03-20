<?php

namespace App\Livewire\Forms;

use App\Enum\ExpenseCategories;
use App\Models\Expense;
use Illuminate\Validation\Rules\Enum;
use Livewire\Attributes\Validate;
use Livewire\Form;

class ExpenseForm extends Form
{
    #[Validate('required|min:10')]
    public $description;
    #[Validate('required|numeric')]
    public int $amount;
    #[Validate('required|image|max:1024')]
    public $image;
    #[Validate(['required', new Enum(ExpenseCategories::class)])]
    public $category;
}

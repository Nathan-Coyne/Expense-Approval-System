<?php

namespace Database\Factories;

use App\Models\Category\ExpenseCategory;
use App\Models\Expense;
use App\Models\File;
use App\Models\Status;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;


class ExpenseFactory extends Factory
{
    public function definition(): array
    {
        return [
            'description' => fake()->sentence(),
            'amount' => fake()->randomFloat(2, 10, 1000),
            'category_id' => ExpenseCategory::where('categorizable_type', Expense::class)->inRandomOrder()->first()->id,
            'user_id' => User::inRandomOrder()->first()->id,
            'file_id' => File::create([
                'path' => 'receipts/' . Str::uuid() . '.jpg',
                'name' => 'receipt.jpg',
                'type' => 'image/jpeg',
                'extension' => 'jpg',
                'size' => fake()->numberBetween(1000, 5000)
            ])->id
        ];
    }
}

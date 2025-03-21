<?php

namespace Tests\Unit;

use App\Enum\ExpenseCategories;
use App\Models\Category\ExpenseCategory;
use App\Models\User;
use Database\Seeders\DatabaseSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Livewire\Livewire;
use Tests\TestCase;

class ExpenseCreateTest extends TestCase
{
    use RefreshDatabase;

    protected User $user;
    protected User $otherUser;
    protected ExpenseCategory $category;

    protected function setUp(): void
    {
        parent::setUp();

        $this->user = User::factory()->create();
        $this->otherUser = User::factory()->create();
        $this->seed(DatabaseSeeder::class);
    }

    /** @test */
    public function can_create_expense()
    {
        $user = User::where('email', 'test@example.com')->first();

        $file = UploadedFile::fake()->image('receipt.jpg');

        Livewire::actingAs($user)
            ->test('expense-create')
            ->set('form.description', 'Test expense')
            ->set('form.amount', 10050)
            ->set('form.category', ExpenseCategories::Other->value)
            ->set('form.image', $file)
            ->call('save');

        $this->assertDatabaseHas('expenses', [
            'description' => 'Test expense',
            'user_id' => $user->id
        ]);
    }
}

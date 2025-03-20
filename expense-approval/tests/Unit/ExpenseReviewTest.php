<?php

namespace Tests\Unit;

use App\Livewire\ExpenseReview;
use App\Models\Expense;
use App\Models\Status;
use App\Models\User;
use Database\Seeders\CategorySeeder;
use Database\Seeders\ExpensePermissionSeeder;
use Database\Seeders\StatusSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

class ExpenseReviewTest extends TestCase
{
    use RefreshDatabase;

    protected User $user;
    protected Status $pendingStatus;
    protected Status $approvedStatus;
    protected Status $rejectedStatus;

    protected function setUp(): void
    {
        parent::setUp();

        $this->user = User::factory()->create();
        $this->seed(StatusSeeder::class);
        $this->seed(CategorySeeder::class);
        $this->seed(ExpensePermissionSeeder::class);
        $this->pendingStatus = Status::where('name', 'Pending')->first();
        $this->approvedStatus = Status::where('name', 'Approved')->first();
        $this->rejectedStatus = Status::where('name', 'Rejected')->first();
        $this->user = User::where('email', 'test_admin@example.com')->first();

    }


    /** @test */
    public function shows_pending_expenses()
    {
        $pendingExpense = Expense::factory()
            ->hasAttached($this->pendingStatus)
            ->create();

        Livewire::actingAs($this->user)
            ->test(ExpenseReview::class)
            ->assertSee($pendingExpense->description)
            ->assertSee($pendingExpense->user->email)
            ->assertDontSee('No pending expenses to review');
    }

    /** @test */
    public function shows_empty_state_when_no_pending_expenses()
    {
        Livewire::actingAs($this->user)
            ->test(ExpenseReview::class)
            ->assertSee('No pending expenses to review');
    }

    /** @test */
    public function can_approve_expense()
    {
        $expense = Expense::factory()
            ->hasAttached($this->pendingStatus)
            ->create();

        Livewire::actingAs($this->user)
            ->test(ExpenseReview::class)
            ->call('approveExpense', $expense->id)
            ->assertHasNoErrors()
            ->assertSee('Expense approved successfully!');

        $this->assertTrue($expense->statuses->contains($this->approvedStatus));
        $this->assertFalse($expense->statuses->contains($this->pendingStatus));
    }

    /** @test */
    public function can_reject_expense()
    {
        $expense = Expense::factory()
            ->hasAttached($this->pendingStatus)
            ->create();

        Livewire::actingAs($this->user)
            ->test(ExpenseReview::class)
            ->call('rejectExpense', $expense->id)
            ->assertHasNoErrors()
            ->assertSee('Expense rejected successfully!');

        $this->assertTrue($expense->statuses->contains($this->rejectedStatus));
        $this->assertFalse($expense->statuses->contains($this->pendingStatus));
    }

    /** @test */
    public function shows_error_when_approving_without_approved_status()
    {
        $this->approvedStatus->delete();
        $expense = Expense::factory()
            ->hasAttached($this->pendingStatus)
            ->create();

        Livewire::actingAs($this->user)
            ->test(ExpenseReview::class)
            ->call('approveExpense', $expense->id)
            ->assertHasErrors(['approve' => 'Error approving expense try again later or contact support']);
        $expense->refresh();
        $this->assertTrue($expense->statuses->contains($this->pendingStatus));
    }

    /** @test */
    public function shows_error_when_rejecting_without_rejected_status()
    {
        $this->rejectedStatus->delete();
        $expense = Expense::factory()
            ->hasAttached($this->pendingStatus)
            ->create();

        Livewire::actingAs($this->user)
            ->test(ExpenseReview::class)
            ->call('rejectExpense', $expense->id)
            ->assertHasErrors(['approve' => 'Error rejecting expense try again later or contact support']);

        $expense->refresh();
        $this->assertTrue($expense->statuses->contains($this->pendingStatus));
    }

    /** @test */
    public function removes_approved_expense_from_list()
    {
        $expense = Expense::factory()
            ->hasAttached($this->pendingStatus)
            ->create();

        Livewire::actingAs($this->user)
            ->test(ExpenseReview::class)
            ->assertSee($expense->description)
            ->call('approveExpense', $expense->id)
            ->assertDontSee($expense->description);
    }

    /** @test */
    public function removes_rejected_expense_from_list()
    {
        $expense = Expense::factory()
            ->hasAttached($this->pendingStatus)
            ->create();

        Livewire::actingAs($this->user)
            ->test(ExpenseReview::class)
            ->assertSee($expense->description)
            ->call('rejectExpense', $expense->id)
            ->assertDontSee($expense->description);
    }

    /** @test */
    public function shows_validation_errors()
    {
        // Test with invalid expense ID
        Livewire::actingAs($this->user)
            ->test(ExpenseReview::class)
            ->call('approveExpense', 999)
            ->assertHasErrors(['approve']);
    }
}

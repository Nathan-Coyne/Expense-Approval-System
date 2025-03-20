<?php

namespace App\Livewire;

use App\Enum\PlatformPermissions;
use App\Jobs\ApprovalNotification;
use App\Models\Expense;
use App\Models\Platform;
use App\Models\Status;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

/**
 * Todo - Move Logic into a service class
 */
class ExpenseReview extends Component
{
    public $expenses;
    public $hasApproveExpensePermission;

    public function mount() {
        $this->loadPendingExpenses();

        $this->hasApproveExpensePermission =
            Auth::user()->hasGrantedGotPermission(
                Platform::class,
                PlatformPermissions::APPROVE_EXPENSES->value
            );

        if (!$this->hasApproveExpensePermission) {
            return redirect()->route('dashboard');
        }
    }

    protected function loadPendingExpenses()
    {
        $this->expenses = Expense::whereHas('statuses', fn($query) =>
        $query->where('slug', 'pending')
        )->with(['statuses', 'file', 'expenseCategory', 'user'])->get();
    }

    public function approveExpense($expenseId) {
        if (!$this->hasApproveExpensePermission) {
            return redirect()->route('dashboard');
        }

        $expense = null;
        $approved = null;

        try {
            DB::transaction(function () use ($expenseId, &$approved, &$expense) {
                $expense = Expense::find($expenseId);
                $expense->statuses()->detach();
                $approved = Status::where('slug', 'approved')->first();
                $expense->statuses()->attach($approved->id);
            });
        } catch (\Throwable $e) {
            return $this->addError('approve', 'Error approving expense try again later or contact support');
        }

        ApprovalNotification::dispatch($expense, $approved);

        $this->loadPendingExpenses();
        session()->flash('success', 'Expense approved successfully!');
    }

    public function rejectExpense($expenseId) {
        $expense = null;
        $rejected = null;

        try {
            DB::transaction(function () use ($expenseId, &$rejected, &$expense) {
                $expense = Expense::find($expenseId);
                $expense->statuses()->detach();
                $rejected = Status::where('slug', 'rejected')->first();
                $expense->statuses()->attach($rejected->id);
            });
        } catch (\Throwable $e) {
            return $this->addError('approve', 'Error rejecting expense try again later or contact support');
        }

        ApprovalNotification::dispatch($expense, $rejected);
        $this->loadPendingExpenses();
        session()->flash('success', 'Expense rejected successfully!');
    }

    public function render() {
        return view('livewire.expense-review')->layout('layouts.app');
    }
}

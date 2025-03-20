<?php
namespace App\Jobs;

use App\Models\Expense;
use App\Models\Status;
use App\Notifications\ExpenseApproved;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class ApprovalNotification implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct(
        public Expense $expense,
        public Status $status
    ) {}

    public function handle(): void
    {
        $this->expense->user->notify(
            new ExpenseApproved($this->expense, $this->status)
        );
    }
}

<?php

namespace App\Jobs;

use App\Models\Expense;
use App\Models\Status;
use App\Notifications\ExpenseRejected;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class RejectionNotification implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct(
        public Expense $expense,
        public Status $status
    ) {}

    public function handle(): void
    {
        $this->expense->user->notify(
            new ExpenseRejected($this->expense, $this->status)
        );
    }
}

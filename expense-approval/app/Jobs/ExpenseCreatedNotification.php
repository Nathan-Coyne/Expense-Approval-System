<?php

namespace App\Jobs;

use App\Models\Expense;
use App\Models\Permission;
use App\Models\Platform;
use App\Models\Status;
use App\Models\User;
use App\Notifications\ExpenseApproved;
use App\Notifications\ExpenseCreated;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class ExpenseCreatedNotification implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct(
        public Expense $expense,
        public Status $status
    ) {}

    public function handle(): void
    {
        /** TODO enum for this*/
        $platform = Platform::where('name', 'Test Platform')->first();
        $users = $platform->granteeWithPermission(User::class, 'approve_expense')->get();

        foreach ($users as $user) {
            $user->notify(
                new ExpenseCreated($this->expense, $this->status)
            );
        }
    }
}

<?php

namespace App\Notifications;

use App\Models\Expense;
use App\Models\Status;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ExpenseRejected extends Notification
{
    use Queueable;

    public function __construct(
        public Expense $expense,
        public Status $status
    ) {}

    public function via($notifiable): array
    {
        return ['mail'];
    }

    public function toMail($notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('Expense Rejected')
            ->line('Your expense has been rejected')
            ->line('Amount: ' . $this->expense->amountFormatted)
            ->line('Status: ' . $this->status->name);
    }
}


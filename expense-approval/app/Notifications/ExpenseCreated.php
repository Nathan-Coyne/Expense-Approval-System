<?php

namespace App\Notifications;

use App\Models\Expense;
use App\Models\Status;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ExpenseCreated extends Notification
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
            ->subject('Expense Created')
            ->line('A new expense has been created')
            ->line('Amount: ' . $this->expense->amountFormatted)
            ->line('Status: ' . $this->status->name)
            ->action('View Expense', route('review-expense'));
    }
}

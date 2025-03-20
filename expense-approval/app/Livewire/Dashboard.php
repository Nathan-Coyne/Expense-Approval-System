<?php

namespace App\Livewire;

use App\Enum\PlatformPermissions;
use App\Models\Platform;
use Livewire\Component;

class Dashboard extends Component
{
    public $email;
    public $name;
    public $user;
    public $hasSubmitExpensePermission;
    public $hasApproveExpensePermission;

    public function mount()
    {
        if (! auth()->check()) {
            return redirect()->route('login');
        }
        $this->user = auth()->user();
        $this->email = $this->user->email;
        $this->name = $this->user->name;
        $this->hasSubmitExpensePermission =
            $this->user->hasGrantedGotPermission(
                Platform::class,
                PlatformPermissions::SUBMIT_EXPENSES->value
            );
        $this->hasApproveExpensePermission =
            $this->user->hasGrantedGotPermission(
                Platform::class,
                PlatformPermissions::APPROVE_EXPENSES->value
            );
    }

    public function navigateToSubmitExpense()
    {
        if ($this->hasSubmitExpensePermission) {
            $this->redirect('/create-expense');
        }
    }

    public function navigateToReviewExpense()
    {
        if ($this->hasApproveExpensePermission) {
            $this->redirect('/review-expense');
        }
    }

    public function render()
    {
        return view('livewire.dashboard')->layout('layouts.app');
    }
}

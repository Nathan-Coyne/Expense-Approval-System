<?php

namespace App\Livewire;

use Illuminate\View\View;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class Logout extends Component
{
    public bool $isLoggedIn;

    public function mount(): void
    {
        $this->isLoggedIn = Auth::check();
    }

    public function logout()
    {
        Auth::logout();
        session()->invalidate();
        session()->regenerateToken();

        return redirect()->route('login');
    }

    public function render(): View
    {
        return view('livewire.logout');
    }
}

<?php

namespace App\Livewire;

use App\Livewire\Forms\LoginForm;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Login extends Component
{
    public LoginForm $form;

    public function mount() {
        if (Auth::check()) {
            return redirect()->route('dashboard');
        }
    }

    public function authenticate()
    {
        $this->form->validate();

        if (Auth::attempt($this->form->all())) {
            return redirect()->route('dashboard');
        }

        return $this->addError('login', 'Invalid credentials.');
    }

    public function render()
    {
        return view('livewire.login')->layout('layouts.app');
    }

}

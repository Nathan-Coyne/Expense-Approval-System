<?php

namespace App\Livewire;

use Livewire\Component;

class Nav extends Component
{
   public function home()
   {
       if (! auth()->check()) {
          return redirect()->route('login');
       }
       return redirect()->route('dashboard');
   }

    public function render()
    {
        return view('livewire.components.nav');
    }
}

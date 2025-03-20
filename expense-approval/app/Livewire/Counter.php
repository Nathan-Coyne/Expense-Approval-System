<?php
namespace App\Livewire;

use Livewire\Component;

class Counter extends Component
{
    public $count = 0;  // Declare the $count variable

    // Method to increment the count
    public function increment()
    {
        $this->count++;
    }

    public function render()
    {
        return view('livewire.counter')->layout('layouts.app');
    }
}

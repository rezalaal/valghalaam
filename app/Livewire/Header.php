<?php

namespace App\Livewire;

use Livewire\Component;

class Header extends Component
{

    public function toggleTheme()
    {
        $this->dispatch('toggle-theme');
    }

    public function render()
    {
        return view('livewire.header');
    }
}

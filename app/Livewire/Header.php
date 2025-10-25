<?php

namespace App\Livewire;

use Livewire\Attributes\On;
use Livewire\Component;

class Header extends Component
{

    public $theme = 'light';

    #[On('setThemeFromJs')]
    public function setTheme($savedTheme)
    {
        $this->theme = $savedTheme;
    }

    public function toggleTheme()
    {
        $this->theme = $this->theme === 'light' ? 'dark' : 'light';
        $this->dispatch('toggle-theme');
    }

    public function render()
    {
        return view('livewire.header');
    }
}

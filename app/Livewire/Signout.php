<?php

namespace App\Livewire;

use Livewire\Component;

class Signout extends Component
{

    
    public function mount()
    {
        auth()->logout();
        return redirect()->to('/');
    }

    public function render()
    {
        return view('livewire.signout');
    }
}

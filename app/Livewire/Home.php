<?php

namespace App\Livewire;

use App\Traits\InviteTrait;
use Livewire\Attributes\Title;
use Livewire\Component;
use Mary\Traits\Toast;
class Home extends Component
{
    use Toast;
    use InviteTrait;

    #[Title('پویش رانندگی - والقلم')]
    public function render()
    {
        return view('livewire.home');
    }
}

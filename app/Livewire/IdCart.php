<?php

namespace App\Livewire;

use Livewire\Component;

class IdCart extends Component
{
    public $canViewCard = false;
    public $haveAvatar = false;
    public $haveCode = false;
    public $haveName = false;
    public $haveJobTitle = false;
    public $haveCity = false;
    public $user;

    public function mount()
    {
        $user = $this->user = auth()->user();
        if(!$user) {
            return redirect(404);
        }

        if($user->getFirstMediaUrl('avatar')) {
            $this->haveAvatar = true;
        }

        if($user->code_value) {
            $this->haveCode = true;
        }

        if($user->first_name && $user->last_name) {
            $this->haveName = true;
        }

        if($user->job_title) {
            $this->haveJobTitle = true;
        }

        if($user->city_id) {
            $this->haveCity = true;
        }

        if($this->haveAvatar && $this->haveCode && $this->haveJobTitle && $this->haveName && $this->haveCity) {
            $this->canViewCard = true;
        }

    }
    public function render()
    {
        return view('livewire.id-cart');
    }
}

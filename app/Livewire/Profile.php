<?php

namespace App\Livewire;

use App\Services\LoginUserByPhoneService;
use App\Traits\InviteTrait;
use Livewire\Attributes\Title;
use Livewire\Component;
use Mary\Traits\Toast;

class Profile extends Component
{
    use Toast;
    use InviteTrait;
    public $loginForm = true;
    

    public $phone;
    public $password;

    public function toggleForm()
    {
        $this->loginForm = !$this->loginForm;
    }    

    public function login()
    {
        
        $result = (new LoginUserByPhoneService())->handle([
            'phone' => english($this->phone),
            'password' => english($this->password),
        ], requiredInvitedBy:false);
        
        if(!$result['success']) {
            $this->error($result['message']);
            return;
        }

        return redirect()->to('/profile');
    }

    #[Title('ورود|عضویت')]
    public function render()
    {
        if(auth()->user()) {
            return view('livewire.profile',[
                'user' => auth()->user()
            ]);
        }
        return view('livewire.login');
    }
}

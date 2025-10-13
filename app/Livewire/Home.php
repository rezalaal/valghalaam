<?php

namespace App\Livewire;

use Livewire\Attributes\Title;
use Livewire\Attributes\Validate;
use Livewire\Component;
use Illuminate\Support\Facades\Validator;
use Mary\Traits\Toast;
class Home extends Component
{
    use Toast;
    public $inviteCode;

    public function invite()
    {
        $data = ['code' => $this->inviteCode];

        $validator = Validator::make($data, [
            'code' => ['required', 'integer', 'exists:users,code'],
        ]);

        if ($validator->fails()) {
            $this->error('کد معرف وجود ندارد');
            return;
        }

        return redirect()->to('/i/'.$this->inviteCode);
    }

    #[Title('پویش رانندگی - والقلم')]
    public function render()
    {
        return view('livewire.home');
    }
}

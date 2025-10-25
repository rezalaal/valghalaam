<?php

namespace App\Traits;

use Illuminate\Support\Facades\Validator;

trait InviteTrait
{
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
}

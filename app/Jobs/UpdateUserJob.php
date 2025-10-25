<?php

namespace App\Jobs;

use App\Data\UserData;
use App\Models\User;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;

class UpdateUserJob implements ShouldQueue
{
    use Queueable;

    public $userData;

    public function __construct(public UserData $dto){
        $this->userData = $dto;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $user = User::find($this->userData->id ?? null);
        if($user) {
            $user->update([
                'first_name' => $this->userData->first_name ?? $user->first_name,
                'last_name'  => $this->userData->last_name ?? $user->last_name,
                'phone'      => $this->userData->phone ?? $user->phone,
                'is_legal'   => $this->userData->is_legal ?? $user->is_legal,
                'is_foreign'   => $this->userData->is_foreign ?? $user->is_foreign,
            ]);
        }
    }
}

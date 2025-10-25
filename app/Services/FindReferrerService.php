<?php

namespace App\Services;

use App\ValueObjects\ReferrerName;
use App\Repositories\UserRepository;
use Illuminate\Support\Facades\Validator;

class FindReferrerService
{
    public function __construct(
        protected UserRepository $users
    ){}

    public function handle(int $code): ?string
    {
        // 1. validate
        $validator = Validator::make(['code' => $code], [
            'code' => ['required', 'integer', 'exists:users,code'],
        ]);

        if ($validator->fails()) {
            return null;
        }

        // 2. find user
        $user = $this->users->findByCode((int) $code);

        // 3. build display name
        return ReferrerName::fromUser($user)->full();
    }
}

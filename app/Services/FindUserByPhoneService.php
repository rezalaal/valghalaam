<?php

namespace App\Services;

use App\Models\User;
use App\Data\UserData;
use App\Repositories\UserRepository;
use Illuminate\Support\Facades\Validator;

class FindUserByPhoneService
{
    /**
     * Create a new class instance.
     */
    public function __construct(
        protected UserRepository $users)
    {}

    public function handle(string $phone): array
    {
        $validated = Validator::make(
            ['phone' => $phone],
            ['phone' => ['required', 'regex:/^09\d{9}$/']],
            [
                'phone.required' => 'شماره تلفن الزامی است.',
                'phone.regex' => 'شماره باید ۱۱ رقم و با ۰۹ شروع شود.',
            ]
        );

        if ($validated->fails()) {
            return [
                'success' => false,
                'message' => $validated->errors()->first('phone'),
                'user' => null,
            ];
        }

        $user = $this->users->findByPhone($phone);
        
        return [
            'success' => true,
            'message' => null,
            'user' => $user ? UserData::fromModel($user) : null,
        ];
    }
}

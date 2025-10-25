<?php

namespace App\Services;

use App\Repositories\UserRepository;
use Illuminate\Support\Facades\Validator;

class LoginUserByPhoneService
{
    public function handle(array $input): array
    {
        $validator = Validator::make(
            $input,
            [
                'phone' => ['required', 'regex:/^09\d{9}$/'],
                'password' => ['required', 'min:3'],
            ],
            [
                'phone.required' => 'شماره تلفن الزامی است.',
                'phone.regex' => 'شماره باید ۱۱ رقم و با ۰۹ شروع شود.',
                'password.required' => 'کلمه عبور الزامی است.',
                'password.min' => 'کلمه عبور باید بیشتر از دو حرف باشد.',
            ]
        );

        if ($validator->fails()) {
            return [
                'success' => false,
                'message' => $validator->errors()->first(),
                'user' => null,
            ];
        }

        $credentials = [
            'phone' => $input['phone'],
            'password' => $input['password'],
        ];

        return UserRepository::loginByPhone($credentials);
    }

    public function create(array $input): array
    {
        $validator = Validator::make(
            [
                'invited_by' => $input['invited_by'],
                'phone' => $input['phone'],
                'password' => $input['password'],
                'password_confirmation' => $input['password_confirmation'],
            ],
            [
                'invited_by' => ['required', 'exists:users,id'],
                'phone' => ['required', 'regex:/^09\d{9}$/'],
                'password' => ['required', 'min:4', 'confirmed'],
                'password_confirmation' => ['required', 'min:4', 'confirmed:password'],                
            ],
            [
                'invited_by.required' => 'دعوت کننده الزامی است',
                'invited_by.exists' => 'دعوت کننده وجود ندارد',
                'phone.required' => 'شماره تلفن الزامی است.',
                'phone.regex' => 'شماره باید ۱۱ رقم و با ۰۹ شروع شود.',
                'password.required' => 'کلمه عبور الزامی است.',
                'password.min' => 'کلمه عبور باید بیشتر از دو حرف باشد.',
                'password_confirmation.required' => 'تکرار کلمه عبور الزامی است.',
                'password_confirmation.min' => 'تکرار کلمه عبور باید بیشتر از دو حرف باشد.',
                'password_confirmation.confirmed' => 'کلمه عبور با تکرارش همخوانی ندارد.',               
            ]
        );


        if ($validator->fails()) {
            return [
                'success' => false,
                'message' => $validator->errors()->first(),
                'user' => null,
            ];
        }

        $credentials = [
            'phone' => $input['phone'],
            'password' => $input['password'],
        ];

        return UserRepository::create($credentials);
    }
}

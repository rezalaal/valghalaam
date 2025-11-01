<?php

namespace App\Services;

use App\Repositories\UserRepository;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class UpdateUserService
{
    public static function handle(array $input)
    {
        $validator = Validator::make(
            [
                'email' => $input['email'],
                'first_name' => $input['first_name'],
                'last_name' => $input['last_name'],
                'company_name' => $input['company_name'],
                'job_title' => $input['job_title'],
                'city_id' => $input['city_id'],
                'gender_id' => $input['gender_id'],
                'education' => $input['education'],
                'invited_by' => $input['invited_by']
            ],
            [
                'email' => ['nullable', 'email', 'max:255', Rule::unique('users', 'email')->ignore(auth()->user()->id)],
                'first_name' => ['nullable', 'string', 'min:2', 'max:50'],
                'last_name' => ['nullable', 'string', 'min:2', 'max:50'],
                'company_name' => ['nullable', 'string', 'max:100'],
                'job_title' => ['nullable', 'string', 'max:100'],
                'city_id' => ['nullable', 'exists:iran_cities,id'],
                'gender_id' => ['nullable', 'integer', 'in:1,2'],
                'education' => ['nullable', 'integer', 'in:0,1,2,3,4'],
            ],
            [
                'email.unique' => 'این ایمیل قبلا استفاده شده است',
                'email.email' => 'ایمیل وارد شده معتبر نیست.',
                'first_name.min' => 'نام باید حداقل ۲ حرف باشد.',
                'last_name.min' => 'نام خانوادگی باید حداقل ۲ حرف باشد.',
                'city_id.exists' => 'شناسه شهر معتبر نیست.',
                'gender_id.in' => 'جنسیت انتخاب شده معتبر نیست.',
                'education.in' => 'تحصیلات انتخاب شده معتبر نیست',
                'education.integer' => 'کد تحصیلات نامعتبر است'
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
            'email' => $input['email'],
            'first_name' => $input['first_name'],
            'last_name' => $input['last_name'],
            'company_name' => $input['company_name'],
            'job_title' => $input['job_title'],
            'city_id' => $input['city_id'],
            'gender_id' => $input['gender_id'],
            'education' => $input['education'],
            'invited_by' => $input['invited_by']
        ];
        
        return UserRepository::update($credentials);
    }
}

<?php

namespace App\Livewire;

use App\Enums\Education;
use App\Models\User;
use Mary\Traits\Toast;
use Livewire\Component;
use App\Models\IranCity;
use App\Models\IranProvince;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class Invitation extends Component
{
    use Toast;
    public $id;

    public $step = 1;

    public $error = 0;

    public $referrer;

    public $phone;
    public $email = null;

    public $tabSelected = 'password-tab';

    public $is_legal = false;
    public $is_foreign = false;
    public $password;
    public $confirm;
    public $first_name;
    public $last_name;
    public $company_name;
    public $job_title;
    public $user;

    public $invited_by;

    public $provinces;
    public $province;
    public $cities = [];
    public $city_id = NULL;
    public $gender_id = NULL;

    public $education;
    public $education_id;

    public function mount()
    {
        $data = ['code' => request()->code];

        $validator = Validator::make($data, [
            'code' => ['required', 'integer', 'exists:users,code'],
        ]);

        if ($validator->fails()) {
            $this->error = 1; // کد معرف نامعتبر است            
        }

        $this->provinces = IranProvince::all();
        $this->education = Education::all();
        
        $user = User::where('code', $data['code'])->first();
        if($user) {
            $this->referrer = $user->first_name . ' ' . $user->last_name;      
            $this->invited_by = $user->id;      
        }else{
            $this->error = 1;
        }

        
    }

    public function updatedProvince($value)
    {
        info($value);
        $this->cities = IranCity::where('province_id', $value)->get();
    }

    public function goToStep2()
    {
        if($this->referrer && $this->error == 0) {
            $this->step = 2;
        }
    }

    public function checkPassword()
    {
        $validated = Validator::make(
            [
                'password' => $this->password,
                'confirm' => $this->confirm,                
            ],
            [
                'password' => ['required', 'min:3'],
                'confirm' => ['required', 'min:3', 'same:password'],                
            ],
            [
                'password.required' => 'کلمه عبور الزامی است.',
                'password.min' => 'کلمه عبور باید بیشتر از دو حرف باشد.',
                'confirm.required' => 'تکرار کلمه عبور الزامی است.',
                'confirm.min' => 'تکرار کلمه عبور باید بیشتر از دو حرف باشد.',
                'confirm.same' => 'کلمه عبور با تکرارش همخوانی ندارد.',               
            ]
        );


        if ($validated->fails()) {
            $this->error($validated->errors()->first());
            return;
        }

        $this->step = 4;
    }

    public function checkStatus()
    {
        $this->step = 5;
    }

    public function checkPhone()
    {
        $validated = Validator::make(
            ['phone' => $this->phone],
            ['phone' => ['required', 'regex:/^09\d{9}$/']],
            [
                'phone.required' => 'شماره تلفن الزامی است.',
                'phone.regex' => 'شماره باید ۱۱ رقم و با ۰۹ شروع شود.',
            ]
        );

        if ($validated->fails()) {
            $this->error($validated->errors()->first('phone'));
            return;
        }

        // 2️⃣ بررسی وجود در دیتابیس
        $exists = User::where('phone', $this->phone)->exists();

        if ($exists) {
            $this->error = 2; // کاربر قبلا ثبت نام کرده است
        } else {
            $this->step = 3;
        }

    }

    public function register()
    {
        $validated = Validator::make(
            [
                'phone' => $this->phone,
                'password' => $this->password,
                'confirm' => $this->confirm,
                'email' => $this->email,
                'first_name' => $this->first_name,
                'last_name' => $this->last_name,
                'company_name' => $this->company_name,
                'job_title' => $this->job_title,
                'is_legal' => $this->is_legal,
                'is_foreign' => $this->is_foreign,
                'invited_by' => $this->invited_by,
                'city_id' => $this->city_id,
                'gender_id' => $this->gender_id,
                'education' => $this->education_id,
            ],
            [
                'phone' => ['required', 'regex:/^09\d{9}$/'],
                'password' => ['required', 'min:3'],
                'confirm' => ['required', 'min:3', 'same:password'],
                'email' => ['nullable', 'email', 'max:255', 'unique:users,email'],
                'first_name' => ['nullable', 'string', 'min:2', 'max:50'],
                'last_name' => ['nullable', 'string', 'min:2', 'max:50'],
                'company_name' => ['nullable', 'string', 'max:100'],
                'job_title' => ['nullable', 'string', 'max:100'],
                'is_legal' => ['nullable', 'boolean'],
                'is_foreign' => ['nullable', 'boolean'],
                'invited_by' => ['nullable', 'exists:users,id'],
                'city_id' => ['nullable', 'exists:iran_cities,id'],
                'gender_id' => ['nullable', 'integer', 'in:1,2'],
                'education' => ['nullable', 'integer', 'in:0,1,2,3,4'],
            ],
            [
                'phone.required' => 'شماره تلفن الزامی است.',
                'phone.regex' => 'شماره باید ۱۱ رقم و با ۰۹ شروع شود.',
                'password.required' => 'کلمه عبور الزامی است.',
                'password.min' => 'کلمه عبور باید بیشتر از دو حرف باشد.',
                'confirm.required' => 'تکرار کلمه عبور الزامی است.',
                'confirm.min' => 'تکرار کلمه عبور باید بیشتر از دو حرف باشد.',
                'confirm.same' => 'کلمه عبور با تکرارش همخوانی ندارد.',
                'email.unique' => 'ایمیل قبلا ثبت شده است',
                'email.email' => 'ایمیل وارد شده معتبر نیست.',
                'first_name.min' => 'نام باید حداقل ۲ حرف باشد.',
                'last_name.min' => 'نام خانوادگی باید حداقل ۲ حرف باشد.',
                'invited_by.exists' => 'کاربر معرف معتبر نیست.',
                'city_id.exists' => 'شناسه شهر معتبر نیست.',
                'gender_id.in' => 'جنسیت انتخاب شده معتبر نیست.',
                'education.in' => 'تحصیلات انتخاب شده معتبر نیست',
                'education.integer' => 'کد تحصیلات نامعتبر است'
            ]
        );


        if ($validated->fails()) {
            $this->error($validated->errors()->first());
            return;
        }

        try {
            $this->user = User::firstOrCreate([
                'first_name' => $this->first_name,
                'last_name' => $this->last_name,
                'company_name' => $this->company_name,
                'job_title' => $this->job_title,
                'phone' => $this->phone,
                'email' => $this->email,
                'password' => $this->password,
                'is_legal' => $this->is_legal,
                'is_foreign' => $this->is_foreign,
                'invited_by' => $this->invited_by,
                'city_id' => $this->city_id,
                'gender_id' => $this->gender_id,
                'education' => $this->education_id

            ]);
            $this->success(" با موفقیت ثبت شد");
            $this->step = 6;
        }catch(\Exception $e) {
            $this->error($e->getMessage());
        }
        
    }

    public function render()
    {
        return view('livewire.invitation');
    }
}

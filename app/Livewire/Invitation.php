<?php

namespace App\Livewire;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Livewire\Component;
use Mary\Traits\Toast;
use Illuminate\Support\Facades\Validator;

class Invitation extends Component
{
    use Toast;
    public $id;

    public $step = 1;

    public $error = 0;

    public $referrer;

    public $phone;
    public $email;

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

    public function mount()
    {
        $data = ['code' => request()->code];

        $validator = Validator::make($data, [
            'code' => ['required', 'integer', 'exists:users,code'],
        ]);

        if ($validator->fails()) {
            $this->error = 1; // کد معرف نامعتبر است            
        }

        $user = User::where('code', $data['code'])->first();
        if($user) {
            $this->referrer = $user->first_name . ' ' . $user->last_name;      
            $this->invited_by = $user->id;      
        }else{
            $this->error = 1;
        }

        
    }

    public function goToStep2()
    {
        if($this->referrer && $this->error == 0) {
            $this->step = 2;
        }
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
                'confirm' => $this->confirm
            ],
            [
                'phone' => ['required', 'regex:/^09\d{9}$/'],
                'password' => ['required', 'min:3'],
                'confirm' => ['required', 'min:3', 'confirmed:password']
            ],
            [
                'phone.required' => 'شماره تلفن الزامی است.',
                'phone.regex' => 'شماره باید ۱۱ رقم و با ۰۹ شروع شود.',
                'password.required' => 'کلمه عبور الزامی است',
                'password.min' => 'کلمه عبور باید بیشتر از دو حرف باشد',
                'confirm.required' => 'تکرار کلمه عبور الزامی است',
                'confirm.min' => 'تکرار کلمه عبور باید بیشتر از دو حرف باشد',
                'confirm.confirmed' => 'کلمه عبور با تکرارش همخوانی ندارد',
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
                'invited_by' => $this->invited_by
            ]);
            $this->success(" با موفقیت ثبت شد");
            $this->step = 4;
        }catch(\Exception $e) {
            info($e->getMessage());
            $this->error('خطا در ثبت سفیر');
        }
        
    }

    public function render()
    {
        return view('livewire.invitation');
    }
}

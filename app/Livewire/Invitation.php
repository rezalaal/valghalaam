<?php

namespace App\Livewire;

use App\Data\UserData;
use App\Enums\Education;
use App\Jobs\UpdateUserJob;
use App\Models\Code;
use App\Models\User;
use App\Services\LoginUserByPhoneService;
use Livewire\WithFileUploads;
use Mary\Traits\Toast;
use Livewire\Component;
use App\Models\IranCity;
use App\Models\IranProvince;
use App\Services\FindReferrerService;
use App\Services\FindUserByPhoneService;
use App\Services\UpdateUserService;
use Exception;

class Invitation extends Component
{
    use Toast;
    use WithFileUploads;
    public $id;

    public $step = 1;    

    public $referrer;

    public $phone;
    public $email = null;
    public $is_legal = false;
    public $is_foreign = false;
    public $password;
    public $password_confirmation;
    public $first_name;
    public $last_name;
    public $company_name;
    public $job_title;
    public $user;

    public $invited_by;

    public $provinces;
    public $province_id;
    public $cities = [];
    public $city_id = NULL;
    public $gender_id = NULL;

    public $education;
    public $education_id;

    public $avatar;

    public function mount($code, FindReferrerService $findReferrer)
    {       
        $this->referrer = $findReferrer->handle($code)?->full();        
        $this->invited_by = $findReferrer->handle($code)?->id();
        if(auth()->user()) {
            $this->avatar = auth()->user()->getFirstMediaUrl('avatar');
            $this->step = 4;
            return;
        }
    }        

    public function updatedProvinceId($value)
    {
        $this->cities = IranCity::where('province_id', $value)->get();
        if ($this->cities->isNotEmpty()) {
            $this->city_id = $this->cities->first()->id;
        }
    }

    public function goToStep2()
    {
        if($this->referrer) {
            if(auth()->user()) {
                $this->prepareUserDTO(UserData::fromModel(auth()->user()));
            }            
            $this->step = 2;
        }
    }

    public function checkPassword(LoginUserByPhoneService $service)
    {
        $result = $service->create([
            'phone' => english($this->phone),
            'password' => english($this->password),
            'password_confirmation' => english($this->password_confirmation),
            'invited_by' => $this->invited_by
        ]);        

        if (!$result['success']) {
            $this->error($result['message']);
            return;
        }

        $this->prepareUserDTO($result['user']);  
        
        $this->step = 4;
    }

    public function checkStatus()
    {
        if(auth()->user()) {
            $this->prepareUserDTO(UserData::fromModel(auth()->user()));
        }
        
        $this->step = 5;
    }

    public function checkPhone(FindUserByPhoneService $service)
    {
        $result = $service->handle(english($this->phone));

        if (!$result['success']) {
            $this->error($result['message']);
            return;
        }
        
        if ($result['user']) {
            $this->prepareUserDTO($result['user']);       
        } 
        
        $this->step = 3;
    }

    public function prepareUserDTO(UserData $userData)
    {

        $this->user = $userData->toArray();

        $this->is_legal = $userData->is_legal;
        $this->is_foreign = $userData->is_foreign;
        $this->avatar = $userData->avatar;
        $this->id = $userData->id;
        $this->first_name = $userData->first_name;
        $this->last_name = $userData->last_name;
        $this->company_name = $userData->company_name;
        $this->job_title = $userData->job_title;
        $this->phone = $userData->phone;
        $this->email = $userData->email;
        $this->is_legal = $userData->is_legal;
        $this->is_foreign = $userData->is_foreign;
        $this->avatar = $userData->avatar;
        $this->city_id = $userData->city_id;
        $this->gender_id = $userData->gender_id;
        $this->provinces = IranProvince::all();
        $this->education = Education::all();
        
        
        if ($this->city_id) {
            $city = IranCity::find($this->city_id);
            if ($city) {
                $this->province_id = $city->province_id;
                $this->cities = IranCity::where('province_id', $city->province_id)->get();
            }
        } else {            
            $this->cities = collect();
        }

        if (!empty($userData->education)) {
            $this->education_id = $userData->education;
        } elseif (!empty($this->education)) {
            $this->education_id = $this->education[0]['id'];
        }

    }

    public function login(LoginUserByPhoneService $service)
    {
        $result = $service->handle([            
            'phone' => english($this->user['phone']),
            'password' => english($this->password),
            'invited_by' => $this->invited_by
        ]);        

        if (!$result['success']) {
            $this->error($result['message']);
            return;
        }

        $this->user = $result['user'];        
        $this->step = 4;
    }

    public function register()
    {
        $input = [
            'email' => $this->email,
            'first_name' => $this->first_name,
            'last_name' => $this->last_name,
            'company_name' => $this->company_name,
            'job_title' => $this->job_title,
            'city_id' => $this->city_id,
            'gender_id' => $this->gender_id,
            'education' => $this->education_id,
            'invited_by' => $this->invited_by
        ];                
        
        $result = UpdateUserService::handle($input);
        
        if (!$result['success']) {
            $this->error($result['message']);
            return;
        }

        $this->addCodeProcess($result['user']);

        // $this->step = 6;
        return redirect()->to('/profile');
    }

    protected function addCodeProcess($user): void
    {
        if (empty($user['id'])) {
            return;
        }

        $safir = User::find($user['id']);
        if (!$safir) {
            return;
        }

        if (Code::where('user_id', $safir->id)->exists()) {
            return;
        }

        $safirCode = Code::whereNull('user_id')
            ->where('is_reserved', false)
            ->first();

        if (!$safirCode) {
            return;
        }

        $safirCode->update(['user_id' => $safir->id]);
    }


    public function updatedIsLegal()
    {
        $this->user['is_legal'] = $this->is_legal;        
        UpdateUserJob::dispatch(UserData::from($this->user));
    }

    public function updatedIsForeign()
    {
        $this->user['is_foreign'] = $this->is_foreign;        
        UpdateUserJob::dispatch(UserData::from($this->user));
    }

    public function updatedAvatar()
    {
        if (!$this->avatar) {
            return;
        }


        try {
            if (!$this->user || empty($this->user['id'])) {
                return;
            }

            $user = User::find($this->user['id']);
            if (!$user) {
                return;
            }

            // پاک کردن collection قدیمی
            $user->clearMediaCollection('avatar');

            // آپلود واقعی
            $user->addMedia($this->avatar->getPathname())
                ->usingFileName($this->avatar->getClientOriginalName())
                ->toMediaCollection('avatar');
            
        } catch (\Exception $e) {
            info("Error uploading avatar: ".$e->getMessage());
        }
    }

    public function render()
    {
        return view('livewire.invitation.step'. $this->step);
    }
}

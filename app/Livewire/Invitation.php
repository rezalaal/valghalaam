<?php

namespace App\Livewire;

use App\Data\UserData;
use App\Enums\Education;
use App\Jobs\UpdateUserJob;
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
        $this->referrer = $findReferrer->handle($code);
        $this->invited_by = $code;        
    }        

    public function updatedProvinceId($value)
    {
        $this->cities = IranCity::where('province_id', $value)->get();
    }

    public function goToStep2()
    {
        if($this->referrer) {
            $this->step = 2;
        }
    }

    public function checkPassword(LoginUserByPhoneService $service)
    {
        $result = $service->create([
            'phone' => $this->phone,
            'password' => $this->password,
            'password_confirmation' => $this->password_confirmation,
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
        $this->step = 5;
    }

    public function checkPhone(FindUserByPhoneService $service)
    {
        $result = $service->handle($this->phone);

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
        // $this->education = $userData->education;
        $this->provinces = IranProvince::all();
        $this->education = Education::all();
    }

    public function login(LoginUserByPhoneService $service)
    {
        $result = $service->handle([            
            'phone' => $this->user['phone'],
            'password' => $this->password,
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
        ];                
        
        $result = UpdateUserService::handle($input);
        
        if (!$result['success']) {
            $this->error($result['message']);
            return;
        }

        $this->step = 6;
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
            info("No avatar uploaded.");
            return;
        }

        // اطلاعات فایل
        info("Avatar file info:");
        info("Name: ".$this->avatar->getClientOriginalName());
        info("MimeType: ".$this->avatar->getClientMimeType());
        info("Size: ".$this->avatar->getSize());
        info("Is valid? ".($this->avatar->isValid() ? 'yes' : 'no'));
        info("Temporary path: ".$this->avatar->getPathname());

        try {
            if (!$this->user || empty($this->user['id'])) {
                info("No user set for avatar upload.");
                return;
            }

            $user = User::find($this->user['id']);
            if (!$user) {
                info("User not found with ID: ".$this->user['id']);
                return;
            }

            // پاک کردن collection قدیمی
            $user->clearMediaCollection('avatar');
            info("Cleared previous avatar media.");

            // بررسی دسترسی پوشه
            $storagePath = storage_path('app/public/avatars');
            if (!is_writable($storagePath)) {
                info("Storage path not writable: ".$storagePath);
            } else {
                info("Storage path writable: ".$storagePath);
            }

            // آپلود واقعی
            $user->addMedia($this->avatar->getPathname())
                ->usingFileName($this->avatar->getClientOriginalName())
                ->toMediaCollection('avatar');

            info("Avatar uploaded successfully to media collection.");

        } catch (\Exception $e) {
            info("Error uploading avatar: ".$e->getMessage());
        }
    }

    public function render()
    {
        return view('livewire.invitation.step'. $this->step);
    }
}

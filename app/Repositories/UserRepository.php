<?php

namespace App\Repositories;

use App\Data\UserData;
use App\Models\User;
use Exception;
use Illuminate\Support\Facades\Auth;

class UserRepository
{
    public function findByCode(int $code): ?User
    {
        return User::select('first_name', 'last_name')->where('code', $code)->first();
    }

    public function findByPhone(string $phone): ?User
    {
        return User::where('phone', $phone)->first();
    }

    public static function loginByPhone(array $credentials): array
    {
        if (!Auth::attempt([
            'phone' => $credentials['phone'],
            'password' => $credentials['password']
        ])) {
            return [
                'success' => false,
                'message' => 'رمز عبور نادرست است',
                'user' => null
            ];
        }
        $user = Auth::user();
        if($credentials['invited_by']){
            $user->invited_by = $credentials['invited_by'];
            $user->save();
        }
        
        session()->put('authenticated', true);
        return [
                'success' => true,
                'message' => 'با موفقیت وارد شدید',
                'user' => UserData::fromModel($user)->toArray()
            ];
    }

    public static function create(array $credentials)
    {
        $user = User::firstOrCreate([
            'phone' => $credentials['phone'],
        ],
        [
            'password' => $credentials['password'],
            'invited_by' => $credentials['invited_by']
        ]);

        if(!$user) {
            return [
                'success' => false,
                'message' => 'خطای ثبت نام',
                'user' => UserData::fromModel($user)
            ];
        }
        Auth::login($user);
        session()->put('authenticated', true);
        return [
            'success' => true,
            'message' => 'ثبت نام با موفقیت انجام شد',
            'user' => UserData::fromModel($user)
        ];
    }

    public static function update(array $user)
    {
        try {
            $currentUser = auth()->user();
            $result = User::find(auth()->user()->id)->update($user);            
        }catch(Exception $e) {
            return [
                'success' => false,
                'message' => $e->getMessage(),
                'user' => UserData::fromModel(auth()->user())->toArray()
            ];
        }
        if(!$result) {
            return [
                'success' => false,
                'message' => 'خطای به روزرسانی',
                'user' => UserData::fromModel(auth()->user())->toArray()
            ];
        }
        $updatedUser = User::find($currentUser->id);
        
        return [
            'success' => true,
            'message' => 'ثبت نام با موفقیت انجام شد',
            'user' => UserData::fromModel($updatedUser)->toArray()
        ];
    }
}

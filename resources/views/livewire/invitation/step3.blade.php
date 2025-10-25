<div class="p-8 font-vazir font-xs font-light" dir="rtl">
    <x-steps wire:model="step" class="border-y border-base-content/10 my-5 py-5">
        <x-step step="3" text="{{ $user ? 'ورود' : 'رمز'}}" class="font-bold">
            
        </x-step>
    </x-steps>
    @if ($user)
        <h3 class="text-lg font-black">مرحله سوم - ورود</h3>
        <div class="mt-4">ثبت نام شما قبلا انجام شده است اکنون می توانید ورود کنید</div>
        <x-form wire:submit="login" class="grid grid-cols-1 lg:grid-cols-4">
            <x-password class="px-1" label="کلمه عبور" placeholder="کلمه عبور" wire:model="password" clearable  required/>
            <x-button label="ورود" class="btn-primary lg:w-32 lg:mt-[2.2rem]" type="submit" spinner="login"/>
        </x-form>
    @else
        <h3 class="text-lg font-black">مرحله سوم - تخصیص رمز</h3>
        <div class="mt-4">لطفا برای خود رمز عبور مشخص کنید</div>
        <x-form wire:submit="checkPassword" class="grid grid-cols-1 lg:grid-cols-4">
            <x-password class="px-1" label="کلمه عبور" placeholder="کلمه عبور" wire:model="password" clearable  required/>
            <x-password class="px-1" label="تکرار کلمه عبور" placeholder="تکرار کلمه عبور" wire:model="password_confirmation" clearable required/>
            <x-button label="ثبت نام" class="btn-primary lg:w-32 lg:mt-[2.2rem]" type="submit" spinner="checkPassword"/>
        </x-form>
    @endif        
</div>
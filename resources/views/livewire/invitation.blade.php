<div class="p-8 font-vazir font-xs font-light" dir="rtl">
    <x-steps wire:model="step" class="border-y border-base-content/10 my-5 py-5">
        <x-step step="1" text="بررسی معرف" class="font-bold">
            <div class="mt-4">
                <h3>ثبت نام</h3>
                @if ($error == 1)
                    <x-alert title="توجه!" description="کد معرف وجود ندارد. امکان ثبت نام بدون کد معرف وجود ندارد" icon="o-shield-exclamation" class="alert-warning mt-4" />
                @else
                    @if ($referrer)
                        <x-alert title="خوش آمدید!" description="شما توسط {{ $referrer }}  به این پویش دعوت شده اید. جهت عضویت و فعالیت در این پویش مراحل ثبت نام را طی کنید" icon="o-shield-exclamation" class="alert-success mt-4" />
                        <x-button label="مرحله بعد" class="btn-primary mt-4" type="submit" spinner="save3" wire:click='goToStep2'/>
                    @endif
                @endif                
            </div>
        </x-step>
        <x-step step="2" text="ثبت نام">
            @if ($error == 2)
                <x-alert title="خطا!" description="این شماره همراه قبلا ثبت نام شده است. جهت بررسی وضعیت از بخش کاربری وارد شوید" icon="o-shield-exclamation" class="alert-danger bg-rose-600 mt-4" />
            @else
                <x-form wire:submit="checkPhone" class="grid grid-cols-1 lg:grid-cols-4">
                    <x-input class="px-1" label="شماره تلفن همراه" prefix="0" wire:model="phone" placeholder="شماره تلفن همراه" icon="o-device-phone-mobile" />                
                    <x-button label="بررسی" class="btn-primary lg:w-32 lg:mt-[2.2rem]" type="submit" spinner="save3"/>
                </x-form>
            @endif
        </x-step>
        <x-step step="3" text="مشخصات">
            <x-form wire:submit="register">
                <div class="flex gap-2">
                    <x-toggle label="شخصیت حقوقی هستم" wire:model.live="is_legal"/>
                    <x-toggle label="خارج از کشور هستم" wire:model="is_foreign"/>
                </div>
                <div class="grid grid-cols-1 lg:grid-cols-4 gap-2">
                    @if($is_legal)
                        <x-input class="px-1" label=" نام شرکت" prefix="0" wire:model="company_name" placeholder="نام شرکت" />
                    @else
                        <x-input class="px-1" label="نام" prefix="0" wire:model="first_name" placeholder="نام" />  
                        <x-input class="px-1" label=" نام خانوادگی" prefix="0" wire:model="last_name" placeholder="نام خانوادگی" /> 
                    @endif              
                    <x-input class="px-1" label=" عنوان شغلی" prefix="0" wire:model="job_title" placeholder="عنوان شغلی" />
                    <x-input class="px-1" label="  ایمیل" prefix="0" wire:model="email" placeholder="ایمیل " />
                    <x-password class="px-1" label="کلمه عبور" placeholder="کلمه عبور" wire:model="password" clearable  required/>
                    <x-password class="px-1" label="تکرار کلمه عبور" placeholder="تکرار کلمه عبور" wire:model="confirm" clearable required/>
                    <x-button label="ثبت نام" class="btn-primary lg:w-32 lg:mt-[2.2rem]" type="submit" spinner="save3"/>
                </div>
            </x-form>
        </x-step>
        <x-step step="4" text="پایان">
            @if ($user)
            <x-card title="ثبت نام با موفقیت انجام شد" subtitle="عضویت شما طی ۷۲ ساعت آینده بررسی و تایید خواهد شد" shadow separator>
                <h1>{{ $user->first_name }} {{ $user->last_name }}</h1>
                <h2>{{ $user->company_name }}</h2>
                <p>از طریق همین سایت می توانید کارت عضویت خود را دریافت کنید و سایر دوستان و آشنایان و ... را به این پویش دعوت کنید</p>
                <p>شما ۲ امتیاز از ثبت نام خود به دست آورده اید جهت دریافت امتیاز بیشتر می توانید موارد زیر را انجام دهید</p>
            </x-card>
            @endif
        </x-step>
    </x-steps>
</div>

<div class="p-8 font-vazir font-xs font-light" dir="rtl">
    <x-steps wire:model="step" class="border-y border-base-content/10 my-5 py-5">
        <x-step step="2" text=" ثبت نام" class="font-bold">
            
        </x-step>
    </x-steps>    
    <h3 class="text-lg font-bold">مرحله دوم - بررسی وضعیت ثبت نام</h3>
    <x-form wire:submit="checkPhone" class="grid grid-cols-1 lg:grid-cols-4 mt-4">
        <x-input class="px-1" label="شماره تلفن همراه" prefix="0" wire:model="phone" placeholder="شماره تلفن همراه" icon="o-device-phone-mobile" />                
        <x-button label="بررسی" class="btn-primary lg:w-32 lg:mt-[2.2rem]" type="submit" spinner="checkPhone"/>
    </x-form>        
</div>
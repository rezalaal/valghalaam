<div class="p-8 font-vazir font-xs font-light" dir="rtl">
    @php
    $gender = [
        ['id' => 1 , 'gender' => 'مرد', 'hint' => 'مرد'],
        ['id' => 2 , 'gender' => 'زن' , 'hint' => 'زن']
    ];
    @endphp
    <x-steps wire:model="step" class="border-y border-base-content/10 my-5 py-5">
        <x-step step="5" text="اطلاعات تکمیلی" class="font-bold">
            
        </x-step>
    </x-steps>
    @auth           
    <x-form wire:submit="register">        
        @if($is_legal)                        
            <x-input class="px-1" label=" نام شرکت" prefix="0" wire:model="company_name" placeholder="نام شرکت" />
        @else
            <x-input class="px-1" label="نام" prefix="0" wire:model="first_name" placeholder="نام" />  
            <x-input class="px-1" label=" نام خانوادگی" prefix="0" wire:model="last_name" placeholder="نام خانوادگی" /> 
            <x-radio label="جنسیت" wire:model="gender_id" :options="$gender" inline />
            <x-select
                label="تحصیلات"
                wire:model.live="education_id"
                :options="$education"
                option-value="id"
                option-label="name" 
                placeholder="تحصیلات"
            />
        @endif    
        @if(!$is_foreign)          
            <x-select
                label="استان"
                wire:model.live="province_id"
                :options="$provinces"
                option-value="id"
                option-label="name" 
            />
            <x-select
                label="شهر"
                wire:model="city_id"
                :options="$cities"
                option-value="id"
                option-label="name" />
        @endif            
        <x-input class="px-1" label=" عنوان شغلی" prefix="0" wire:model="job_title" placeholder="عنوان شغلی" />
        <x-input class="px-1" label="  ایمیل" prefix="0" wire:model="email" placeholder="ایمیل " />            
        <x-button label="ثبت نام" class="btn-primary lg:w-32 lg:mt-[2.2rem]" type="submit" spinner="save3"/>            
    </x-form> 
    @endauth       
</div>
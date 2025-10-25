<div class="p-8 font-vazir font-xs font-light" dir="rtl">
    <x-steps wire:model="step" class="border-y border-base-content/10 my-5 py-5">
        <x-step step="1" text=" معرف" class="font-bold">
            <h3 class="text-lg font-black">مرحله اول - بررسی معرف</h3>
        </x-step>
    </x-steps>
    <div class="mt-4">                        
        @if ($referrer)
            <x-alert title="خوش آمدید!" description="شما توسط {{ $referrer }} به این پویش دعوت شده اید. جهت عضویت و فعالیت در این پویش مراحل ثبت نام را طی کنید" icon="o-globe-alt" class="alert-success mt-4" />
            <div class="flex items-center gap-4">
                <x-button label="مرحله بعد" class="btn-primary mt-4" type="submit" spinner="save3" wire:click='goToStep2'/>            
                <x-button label="بازگشت" class="mt-4" link="/" />
            </div>
        @else
            <x-alert title="خطا" description="کد وارد شده نامعتبر است." icon="o-shield-exclamation" class="alert-error mt-4" />
        @endif
    </div>
</div>
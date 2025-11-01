<div class="p-8 font-vazir font-xs font-light" dir="rtl">
    <x-steps wire:model="step" class="border-y border-base-content/10 my-5 py-5">
        <x-step step="4" text="وضعیت" class="font-bold">
            
        </x-step>
    </x-steps>
    @auth           
    <x-form wire:submit="checkStatus" class="grid grid-cols-1">
        <h3 class="text-lg font-black">مرحله چهارم - وضعیت و تصویر پروفایل</h3>
        <x-toggle label="شخصیت حقوقی هستم" wire:model.live="is_legal"/>
        <x-toggle label="خارج از کشور هستم" wire:model.live="is_foreign"/>
        <div class="flex items-center border border-dashed p-2">
            <div>
                <h3 class="text-sm">لطفا یک تصویر پرسنلی مناسب بارگزاری کنید</h3>
                <p class="text-sky-500">با کلیک روی تصویر می توانید این کار را انجام دهید</p>
            </div>
            @php
            @endphp
            <x-file wire:model.live="avatar" accept="image/png, image/jpeg, image/jpg" class="flex">
                <img src="{{ $avatar ?? asset('images/avatar.png') }}" class="h-40 w-40 object-cover rounded-lg" />
                <div wire:loading wire:target="avatar"
                    class="absolute inset-0 bg-gray-800 bg-opacity-50 flex items-center justify-center rounded-lg">
                    <svg class="animate-spin h-8 w-8 text-white" xmlns="http://www.w3.org/2000/svg" fill="none"
                        viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor"
                            stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor"
                            d="M4 12a8 8 0 018-8v8z"></path>
                    </svg>
                </div>
            </x-file>
        </div>
        <x-button label="مرحله بعدی" class="btn-primary lg:w-32 lg:mt-[2.2rem]" type="submit" spinner="checkStatus"/>
    </x-form>
    @endauth       
</div>
<div dir="rtl" class="mx-4 lg:flex flex-col mt-8 justify-center items-center">
    @if($loginForm)
    <div class="mx-8">
        <h1 class="text-xl text-center font-black">ورود</h1>
        <x-form wire:submit="login" class="mt-4">
            <x-input label="شماره تلفن همراه" wire:model="phone" />
            <x-password label="کلمه عبور" wire:model="password" right />
        
            <x-slot:actions>
                <x-button label="عضویت در پویش" wire:click='toggleForm'/>
                <x-button label="ورود" class="btn-primary" type="submit" spinner="login" />
            </x-slot:actions>
        </x-form>
    </div>
    @else
    <div class="mx-8">
        <h1 class="text-xl text-center font-black">عضویت در پویش</h1>
        <x-form wire:submit="invite">
            <x-input label="کد معرف" wire:model="inviteCode" />
            <x-slot:actions>
                <x-button label="قبلا عضو شده ام" wire:click='toggleForm'/>
                <x-button label="عضویت در پویش" class="btn-primary" type="submit" spinner="save3" />
            </x-slot:actions>
        </x-form>
    </div>
    @endif
</div>
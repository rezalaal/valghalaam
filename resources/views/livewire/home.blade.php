<div class="grid grid-cols-1 lg:grid-cols-5 mt-8 font-vazir font-light" dir="rtl">
    <div class="mx-8">
        <x-form wire:submit="invite">
            <x-input label="کد معرف" wire:model="inviteCode" />
            <x-slot:actions>
                <x-button label="عضویت در پویش" class="btn-primary" type="submit" spinner="invite" />
            </x-slot:actions>
        </x-form>
    </div>
    <div class="mx-8 col-span-4 mt-4 mb-20">
        <livewire:ambassadors>
    </div>
</div>


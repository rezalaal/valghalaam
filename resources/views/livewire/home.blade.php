<div class="grid grid-cols-1 lg:grid-cols-3 mt-8 font-vazir font-light" dir="rtl">
    <div></div>
    <div>
        <x-form wire:submit="invite">
            <x-input label="کد معرف" wire:model="inviteCode" />
            <x-slot:actions>
                <x-button label="عضویت در پویش" class="btn-primary" type="submit" spinner="save3" />
            </x-slot:actions>
        </x-form>
    </div>
    <div></div>
</div>


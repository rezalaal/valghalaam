<div>
    <x-file wire:model.live="photo" accept="image/png, image/jpeg">
        <img src="{{ $user->avatar ?? asset('images/avatar.png') }}" class="h-40 rounded-lg" />
    </x-file>
</div>

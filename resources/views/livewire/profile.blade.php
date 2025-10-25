<div>
    <h1 class="text-lg font-black text-center mt-4">پروفایل کاربری</h1>
    <div dir="rtl" class="m-4 flex flex-col gap-4">
        @if ($user->is_legal)
            <p>کاربر حقوقی {{ $user->company_name }}</p>
        @else
            <p>کاربر: {{ $user->first_name }} {{ $user->last_name }}</p>
        @endif
        
        <span class="text-sm text-gray-400">{{ $user->phone }}</span>
        <a href="signout" wire:navigate>خروج از حساب کاربری</a>
    </div>
</div>

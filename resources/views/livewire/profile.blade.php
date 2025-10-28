<div>
    <h1 class="text-lg font-black text-center mt-4">پروفایل کاربری</h1>
    <p class="text-sm text-gray-400 text-center">@farsi($user->phone)</p>
    @php
        $avatarUrl = $user->getFirstMediaUrl('avatar') ?: asset('images/avatar.png');
    @endphp
    
    <img src="{{ $avatarUrl }}" 
        alt="پروفایل {{ $user->first_name }}"
        class="h-40 w-40 object-cover rounded-full mx-auto mt-2" 
    />
    <div dir="rtl" class="m-4 flex flex-col gap-4 px-4">
        
        <div>{{ $user->code ? "کد سفیر: ".$user->code : "فاقد کد"}}</div>
        <div>{{ $user->is_legal ? "کاربر حقوقی ". $user->company_name : "کاربر: ".$user->first_name." ". $user->last_name }}</div>
        <div>عنوان شغلی {{ $user->job_title }}</div>        
        <div>ایمیل: {{ $user->email }}</div>
        <div>{{ $user->is_foreign ? "خارج از کشور" : ''}}</div>
        @if ($user->city_id)
            <div>محل سکونت: {{ $user->city->province->name }} :: {{ $user->city->name }}</div>
        @endif
        @if ($user->gender_id && \App\Enums\Gender::tryFrom($user->gender_id))
            <div>جنسیت:‌{{ \App\Enums\Gender::from($user->gender_id)->label() }}</div>
        @endif
        @if ($user->education )
            <div>مدرک تحصیلی {{ $user->education->label() }}</div>
        @endif
        @if ($user->invited_by)
            <div>دعوت شده توسط: {{ $user->inviter->first_name }} {{ $user->inviter->last_name }}</div>
        @endif
        

        <a href="signout" wire:navigate>خروج از حساب کاربری</a>
    </div>
</div>

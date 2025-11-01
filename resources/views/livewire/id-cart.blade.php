<div class="h-screen w-full flex justify-center items-center">
    @if ($canViewCard)
        <div class="flex flex-col w-full items-center justify-center lg:w-[40%]">
            <h1 class="font-lalezar text-center text-xl mt-4">کارت سفیر</h1>
            <div class="bg-ghalam w-[90%] rounded-2xl mt-8 p-4">
                <div class="bg-black w-full flex gap-4">
                    <div class="w-[30%] bg-ghalam p-2 flex flex-col justify-evenly">
                        <img src="{{ $user->getFirstMediaUrl('avatar')}}" class="rounded-lg object-cover">
                        <p class="text-black text-center p-2 font-black text-xs" >{{ $user->first_name }} {{ $user->last_name }}</p>
                    </div>
                    <div class="w-[70%] flex flex-col justify-center gap-1 items-center">
                        <h1 class="text-ghalam text-xl font-lalezar">من در بین خطوط خردمندانه می رانم</h1>    
                        <button class="bg-ghalam px-4 py-1 rounded-lg text-sm font-lalezar">کد سفیر</button>
                        <p class="text-ghalam font-black text-3xl">{{ $user->code_value }}</p>
                        <p class="text-ghalam">{{ $user->city->province->name }} :: {{ $user->city->name }}</p>
                        <p class="text-ghalam font-lalezar">سفیر پویش رانندگی ایمن {{ $user->job_title }}</p>
                    </div>                    
                </div>
                <div class="bg-black flex px-2 gap-2 justify-center items-center pt-2" dir="rtl">
                    <img src="/qr/{{$user->code_value}}" alt="qrcode" class="w-24">
                    <p class="text-white p-1 text-justify" dir="rtl">ما سفیران پویش رانندگی ایمن ضمن ترویج و اجرای رانندگی بین خطوط و خردمندانه تلاش می کنیم آمار کشته های تصادفات جاده ای ایران را تا سال ۱۴۱۴ به صفر برسانیم چرا که نجات جان بشریت (حداقل ۲۰۰ میلیارد انسان) است. (عمل به قرآن - ۳۲ مائده)</p>
                </div>
                <div class="bg-black text-white flex justify-between p-2">
                    <div class="flex gap-2 justify-center items-center text-ghalam">
                        <img src="images/whatsapp.png" alt="whatsapp" class="size-4">
                        <span>09303170960</span>
                    </div>
                    <div class="flex gap-2 justify-center items-center text-ghalam">
                        <img src="images/instagram.png" alt="instagram" class="size-4">
                        <span>@valghalaam</span>
                    </div>
                </div>
                <div>
                    <p dir="rtl" class="text-[10px] pt-1 px-1">تاریخ عضویت {{ verta($user->created_at)->format('Y/m/d')}}</p>
                </div>
            </div>
            <a href="/i/{{ $user->code_value }}" class="mt-2 underline text-sky-800">{{ env('APP_URL')}}/i/{{$user->code_value}}</a>
        </div>
    @else        
        <div class="flex flex-col gap-4" dir="rtl">
            <x-alert icon="o-exclamation-triangle" class="alert-error">
                کارت سفیر شما هنوز صادر نشده است
            </x-alert>
            @if (!$haveAvatar)
                <x-alert icon="o-exclamation-triangle" class="alert-error">
                    فاقد تصویر پرسنلی
                </x-alert>
            @endif
            @if (!$haveCode)
                <x-alert icon="o-exclamation-triangle" class="alert-error">
                    فاقد کد
                </x-alert>
            @endif
            @if (!$haveCity)
                <x-alert icon="o-exclamation-triangle" class="alert-error">
                    محل سکونت مشخص نیست
                </x-alert>
            @endif
            @if (!$haveJobTitle)
                <x-alert icon="o-exclamation-triangle" class="alert-error">
                    عنوان شغلی مشخص نیست 
                </x-alert>
            @endif
            @if (!$haveName)
                <x-alert icon="o-exclamation-triangle" class="alert-error">
                    نام مشخص نیست 
                </x-alert>
            @endif

            <x-button class="btn-primary btn-dash" link="/i/{{ $user->inviter_code_value }}">
                به روزرسانی و ویرایش مشخصات
            </x-button>
        </div>
    @endif
    
</div>

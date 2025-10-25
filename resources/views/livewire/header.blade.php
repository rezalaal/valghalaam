<header class="bg-ghalam text-4xl  text-black flex justify-between items-center px-4">
    <div class="flex justify-center items-center">
        <a href="/">
            <img src="{{ asset('images/logo.png') }}" alt="Logo" class="w-16 h-16">
        </a>
        @auth
            <a href="/profile" wire:navigate>
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6 hidden lg:flex">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.501 20.118a7.5 7.5 0 0 1 14.998 0A17.933 17.933 0 0 1 12 21.75c-2.676 0-5.216-.584-7.499-1.632Z" />
                </svg>
            </a>
        @endauth
        @guest
            <a href="/profile" wire:navigate>
                <div class="hidden lg:flex">
                    <div class="text-xs">
                        ورود|ثبت نام
                    </div>
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-4">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 9V5.25A2.25 2.25 0 0 0 13.5 3h-6a2.25 2.25 0 0 0-2.25 2.25v13.5A2.25 2.25 0 0 0 7.5 21h6a2.25 2.25 0 0 0 2.25-2.25V15M12 9l-3 3m0 0 3 3m-3-3h12.75" />
                    </svg>
                </div>
            </a>
        @endguest
    </div>
    <div class="lg:hidden flex flex-col justify-center items-center gap-0 p-0">
        <p class="text-sm text-center font-lalezar">
            نٓ وَٱلْقَلَمِ وَمَا يَسْطُرُونَ    
        </p>
        <div class="font-vazir font-light text-sm">
            پویش رانندگی بین خطوط
        </div>
    </div>
    <div class="font-vazir font-light text-sm lg:text-3xl lg:font-extrabold hidden lg:block">
        پویش رانندگی بین خطوط
    </div>
    <div class="flex items-center">
        <p class="text-sm lg:text-xl text-center font-lalezar p-8 hidden lg:block">
            نٓ وَٱلْقَلَمِ وَمَا يَسْطُرُونَ    
        </p>
        <label class="toggle text-base-content">
            <input 
                type="checkbox" 
                id="theme-btn" 
                class="theme-controller" 
                wire:click='toggleTheme' 
                wire:model='theme'
                @checked($theme === 'dark')    
            />
            <svg aria-label="sun" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><g stroke-linejoin="round" stroke-linecap="round" stroke-width="2" fill="none" stroke="currentColor"><circle cx="12" cy="12" r="4"></circle><path d="M12 2v2"></path><path d="M12 20v2"></path><path d="m4.93 4.93 1.41 1.41"></path><path d="m17.66 17.66 1.41 1.41"></path><path d="M2 12h2"></path><path d="M20 12h2"></path><path d="m6.34 17.66-1.41 1.41"></path><path d="m19.07 4.93-1.41 1.41"></path></g></svg>
            <svg aria-label="moon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><g stroke-linejoin="round" stroke-linecap="round" stroke-width="2" fill="none" stroke="currentColor"><path d="M12 3a6 6 0 0 0 9 9 9 9 0 1 1-9-9Z"></path></g></svg>
        </label>
    </div>
    <div class="fixed z-50 bg-white dark:bg-gray-950 bottom-0 left-0 w-full h-12 border-t border-gray-300 flex lg:hidden justify-evenly items-center pt-2">
        <a href="/profile" wire:navigate>
            <div class="flex flex-col justify-center items-center">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6 dark:text-white">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.501 20.118a7.5 7.5 0 0 1 14.998 0A17.933 17.933 0 0 1 12 21.75c-2.676 0-5.216-.584-7.499-1.632Z" />
                </svg>
                <p class="text-xs dark:text-white">پروفایل</p>
            </div>
        </a>
        <a href="/" wire:navigate>
            <div class="flex flex-col justify-center items-center lg:hidden">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6 dark:text-white">
                <path stroke-linecap="round" stroke-linejoin="round" d="m2.25 12 8.954-8.955c.44-.439 1.152-.439 1.591 0L21.75 12M4.5 9.75v10.125c0 .621.504 1.125 1.125 1.125H9.75v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21h4.125c.621 0 1.125-.504 1.125-1.125V9.75M8.25 21h8.25" />
                </svg>
                <p class="text-xs dark:text-white">صفحه اصلی</p>
            </div>
        </a>
    </div>
</header>
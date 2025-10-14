<header class="bg-ghalam text-4xl  text-black flex justify-between items-center px-4">
    <a href="/">
        <img src="{{ asset('images/logo.png') }}" alt="Logo" class="w-16 h-16">
    </a>
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
            <input type="checkbox" value="synthwave" class="theme-controller" onclick="toggleTheme()"/>

            <svg aria-label="sun" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><g stroke-linejoin="round" stroke-linecap="round" stroke-width="2" fill="none" stroke="currentColor"><circle cx="12" cy="12" r="4"></circle><path d="M12 2v2"></path><path d="M12 20v2"></path><path d="m4.93 4.93 1.41 1.41"></path><path d="m17.66 17.66 1.41 1.41"></path><path d="M2 12h2"></path><path d="M20 12h2"></path><path d="m6.34 17.66-1.41 1.41"></path><path d="m19.07 4.93-1.41 1.41"></path></g></svg>

            <svg aria-label="moon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><g stroke-linejoin="round" stroke-linecap="round" stroke-width="2" fill="none" stroke="currentColor"><path d="M12 3a6 6 0 0 0 9 9 9 9 0 1 1-9-9Z"></path></g></svg>

        </label>
    </div>
</header>

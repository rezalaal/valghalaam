import './bootstrap';

document.addEventListener('DOMContentLoaded', () => {
    let currentTheme = localStorage.getItem('theme')
    document.querySelector("body").setAttribute('data-theme', currentTheme)
})

Livewire.on("toggle-theme", () => {
    let currentTheme = localStorage.getItem('theme')

    if (currentTheme == 'dark') {
        document.querySelector("body").setAttribute('data-theme', 'light')
        localStorage.setItem('theme', 'light')
    }else{
        document.querySelector("body").setAttribute('data-theme', 'dark')
        localStorage.setItem('theme', 'dark')
    }

})
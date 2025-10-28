import './bootstrap';

document.addEventListener('DOMContentLoaded', () => {
    const body = document.body;
    const root = document.documentElement;
    
    
    const savedTheme = localStorage.getItem('theme') || 'light';
    
    Livewire.dispatch('setThemeFromJs',{savedTheme: savedTheme});
    applyTheme(savedTheme);

    Livewire.on('toggle-theme', () => {
        const newTheme = (localStorage.getItem('theme') === 'dark') ? 'light' : 'dark';
        applyTheme(newTheme);
        Livewire.dispatch('setThemeFromJs',{savedTheme: newTheme});
    });

    function applyTheme(theme) {
        body.setAttribute('data-theme', theme);
        root.classList.toggle('dark', theme === 'dark');
        root.classList.toggle('light', theme === 'light');
        localStorage.setItem('theme', theme);
    }
});

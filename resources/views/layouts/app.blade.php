<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, viewport-fit=cover">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ isset($title) ? $title.' - '.config('app.name') : config('app.name') }}</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=lalezar:400" rel="stylesheet" />
    <link href="https://fonts.bunny.net/css?family=vazirmatn:100,200,300,400,500,600,700,800,900" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen font-vazir font-light text-xs antialiased bg-base-200" data-theme="cupcake">
    <livewire:header />
    <main>
        {{ $slot }}
    </main>
    
    <x-toast position="toast-top toast-center" />
</body>
</html>

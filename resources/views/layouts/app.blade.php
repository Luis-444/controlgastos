<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])

        <!-- Styles -->
        @livewireStyles
    </head>
    <body class="font-sans h-screen overflow-hidden">

        <div
        x-data="
            {
              sidebar: localStorage.getItem('Sidebar') == 'false' ? false : true
            }
        "
        class="main__container">
        <!-- topbar -->
            @livewire('navigation-menu-component')
            <main class="secondary__container">
                {{ $slot }}
                {{-- @livewire('notification-component') --}}
            </main>
            <livewire:notification-component />
        </div>
        @stack('modals')
        @livewireScripts
    </body>
</html>

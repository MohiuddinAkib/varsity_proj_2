<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap">

        <!-- Styles -->
        <style>
            [x-cloak] {
                display: none !important;
            }
        </style>
        <livewire:styles/>
        <link rel="stylesheet" href="{{ asset('css/app.css') }}">
        @stack("styles")
    </head>

    <body class="font-sans antialiased">
        <main class="min-h-screen bg-gray-100 flex flex-col">
            @include('layouts.navigation')

            <div class="flex-grow w-4/5 mx-auto pt-8">
                {{ $slot }}
            </div>
        </main>

        <!-- Scripts -->
        <livewire:scripts/>
        <script src="{{ asset('js/app.js') }}"></script>
        @stack("scripts")
    </body>
</html>

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

        <link rel="icon" href="/favicon.svg" type="image/svg+xml">

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans text-gray-900 antialiased bg-gray-100">
        <div class="min-h-screen flex flex-col">
            @include('layouts.site-header')

            <main class="flex-1 flex justify-center items-start sm:items-center px-4 pb-12">
                <div class="w-full sm:max-w-md p-8 bg-white rounded-xl shadow-lg ring-1 ring-gray-200">
                    {{ $slot }}
                </div>
            </main>
        </div>
    </body>
</html>

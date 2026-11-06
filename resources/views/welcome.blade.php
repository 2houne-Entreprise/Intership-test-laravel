<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>{{ config('app.name') }}</title>

        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
        <link rel="icon" href="/favicon.svg" type="image/svg+xml">
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased bg-gray-100 text-gray-900">
        <div class="min-h-screen flex flex-col">
            <header class="max-w-5xl w-full mx-auto px-6 py-6 flex items-center justify-between">
                <a href="/" class="flex items-center gap-2">
                    <x-application-logo class="h-8 w-8 text-indigo-600" />
                    <span class="font-semibold text-lg">TaskFlow</span>
                </a>

                <nav class="flex items-center gap-4 text-sm">
                    @auth
                        <a href="{{ route('projects.index') }}" class="font-medium text-indigo-600">Mes projets</a>
                    @else
                        <a href="{{ route('login') }}" class="text-gray-600 hover:text-gray-900">Connexion</a>
                        <a href="{{ route('register') }}" class="px-4 py-2 rounded-md bg-indigo-600 text-white hover:bg-indigo-700">Créer un compte</a>
                    @endauth
                </nav>
            </header>

            <main class="flex-1 flex items-center">
                <div class="max-w-5xl w-full mx-auto px-6 py-16">
                    <h1 class="text-4xl sm:text-5xl font-semibold tracking-tight max-w-2xl">
                        Organisez vos projets, suivez vos tâches.
                    </h1>
                    <p class="mt-4 text-lg text-gray-600 max-w-xl">
                        Créez des projets, ajoutez des tâches avec une échéance et un statut, et voyez tout de suite ce qui est en retard.
                    </p>
                    <div class="mt-8">
                        <a href="{{ auth()->check() ? route('projects.index') : route('register') }}" class="inline-block px-6 py-3 rounded-md bg-indigo-600 text-white font-medium hover:bg-indigo-700">
                            Commencer
                        </a>
                    </div>
                </div>
            </main>
        </div>
    </body>
</html>

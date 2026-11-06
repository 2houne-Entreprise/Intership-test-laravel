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
            @include('layouts.site-header')

            <main class="flex-1">
                <div class="max-w-5xl mx-auto px-6 pt-8 pb-16 grid lg:grid-cols-2 gap-12 items-center">
                    <div>
                        <h1 class="text-4xl sm:text-5xl font-semibold tracking-tight leading-tight">
                            Organisez vos projets, suivez vos tâches.
                        </h1>
                        <p class="mt-5 text-lg text-gray-600 max-w-md">
                            Créez des projets, ajoutez des tâches avec une échéance et un statut, et voyez tout de suite ce qui est en retard.
                        </p>

                        <div class="mt-8 flex flex-wrap gap-3">
                            @auth
                                <a href="{{ route('dashboard') }}" class="px-5 py-3 rounded-md bg-indigo-600 text-white font-medium hover:bg-indigo-700 focus:outline-none focus-visible:ring-2 focus-visible:ring-indigo-500 focus-visible:ring-offset-2">Ouvrir mon tableau de bord</a>
                            @else
                                <a href="{{ route('register') }}" class="px-5 py-3 rounded-md bg-indigo-600 text-white font-medium hover:bg-indigo-700 focus:outline-none focus-visible:ring-2 focus-visible:ring-indigo-500 focus-visible:ring-offset-2">Créer un compte</a>
                                <a href="{{ route('login') }}" class="px-5 py-3 rounded-md bg-white border border-gray-300 text-gray-700 font-medium hover:bg-gray-50 focus:outline-none focus-visible:ring-2 focus-visible:ring-indigo-500 focus-visible:ring-offset-2">Se connecter</a>
                            @endauth
                        </div>

                        @guest
                            <p class="mt-5 text-sm text-gray-500">
                                Compte de démo : <span class="font-medium text-gray-700">demo@taskflow.test</span>, mot de passe <span class="font-medium text-gray-700">password</span>
                            </p>
                        @endguest
                    </div>

                    <div class="bg-white rounded-xl shadow-lg ring-1 ring-gray-200 p-8">
                        <p class="text-gray-600">
                            Conçu et développé par <span class="font-semibold text-gray-900">Amar</span>
                            pour le test technique <span class="font-semibold text-indigo-600">2Houne</span>.
                        </p>
                        <ul class="mt-6 grid grid-cols-2 gap-3">
                            @foreach (['laravel' => 'Laravel 13', 'php' => 'PHP 8.4', 'sqlite' => 'SQLite', 'blade' => 'Blade'] as $icon => $name)
                                <li class="flex items-center gap-3 p-3 rounded-lg border border-gray-200">
                                    <img src="/icons/{{ $icon }}.svg" alt="" class="h-6 w-6">
                                    <span class="font-medium text-gray-800">{{ $name }}</span>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </main>
        </div>
    </body>
</html>

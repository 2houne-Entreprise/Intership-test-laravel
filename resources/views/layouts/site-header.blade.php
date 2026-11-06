<header class="max-w-5xl w-full mx-auto px-6 py-6 flex items-center justify-between">
    <a href="/" class="flex items-center gap-2">
        <x-application-logo class="h-8 w-8 text-indigo-600" />
        <span class="font-semibold text-lg">TaskFlow</span>
    </a>

    <nav class="flex items-center gap-4 text-sm">
        <x-locale-switch />
        @auth
            <a href="{{ route('projects.index') }}" class="font-medium text-indigo-600">{{ __('Mes projets') }}</a>
        @else
            <a href="{{ route('login') }}" class="text-gray-600 hover:text-gray-900">{{ __('Connexion') }}</a>
            <a href="{{ route('register') }}" class="px-4 py-2 rounded-md bg-indigo-600 text-white hover:bg-indigo-700">{{ __('Créer un compte') }}</a>
        @endauth
    </nav>
</header>

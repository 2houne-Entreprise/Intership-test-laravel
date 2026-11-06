<x-app-layout>
    <x-slot name="header">
        @yield('header')
    </x-slot>

    <div class="py-8 max-w-3xl mx-auto px-4 space-y-6">
        @if (session('success'))
            <x-alert>{{ session('success') }}</x-alert>
        @endif

        @if ($errors->any())
            <x-alert type="error">Le formulaire contient des erreurs.</x-alert>
        @endif

        @yield('content')
    </div>
</x-app-layout>

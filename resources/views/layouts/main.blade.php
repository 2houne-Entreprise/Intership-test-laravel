<x-app-layout>
    @hasSection('header')
        <x-slot name="header">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                @yield('header')
            </h2>
        </x-slot>
    @endif

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            @session('success')
                <x-alert type="success">{{ $value }}</x-alert>
            @endsession

            @session('error')
                <x-alert type="error">{{ $value }}</x-alert>
            @endsession

            @yield('content')
        </div>
    </div>
</x-app-layout>

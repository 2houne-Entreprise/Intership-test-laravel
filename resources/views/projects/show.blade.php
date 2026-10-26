<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ $project->name }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            @if (session('success'))
                <div class="p-4 bg-green-100 text-green-800 rounded-md">
                    {{ session('success') }}
                </div>
            @endif

            <div class="p-6 bg-white shadow-sm sm:rounded-lg">
                <p class="text-gray-700">{{ $project->description ?? 'Aucune description.' }}</p>

                <div class="mt-6 flex items-center gap-4">
                    <a href="{{ route('projects.edit', $project) }}" class="text-indigo-600 hover:underline">Modifier</a>

                    <form method="POST" action="{{ route('projects.destroy', $project) }}" onsubmit="return confirm('Supprimer ce projet ?')">
                        @csrf
                        @method('DELETE')

                        <x-danger-button>Supprimer</x-danger-button>
                    </form>

                    <a href="{{ route('projects.index') }}" class="text-gray-600 hover:underline">Retour</a>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

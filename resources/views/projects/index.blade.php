<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800">Mes projets</h2>
    </x-slot>

    <div class="py-8 max-w-3xl mx-auto px-4 space-y-6">
        @if (session('success'))
            <p class="p-3 bg-green-100 text-green-800 rounded">{{ session('success') }}</p>
        @endif

        <form method="POST" action="{{ route('projects.store') }}" class="p-6 bg-white rounded shadow-sm space-y-4">
            @csrf
            @include('projects.fields', ['project' => null])
            <x-primary-button>Créer</x-primary-button>
        </form>

        <div class="bg-white rounded shadow-sm divide-y">
            @forelse ($projects as $project)
                <div class="p-4 flex justify-between gap-4">
                    <div>
                        <a href="{{ route('projects.show', $project) }}" class="font-semibold hover:text-indigo-600">{{ $project->name }}</a>
                        <p class="text-sm text-gray-600">{{ $project->description }}</p>
                    </div>
                    <div class="flex gap-3 text-sm">
                        <a href="{{ route('projects.edit', $project) }}" class="text-indigo-600">Modifier</a>
                        <form method="POST" action="{{ route('projects.destroy', $project) }}" onsubmit="return confirm('Supprimer ce projet ?')">
                            @csrf
                            @method('DELETE')
                            <button class="text-red-600">Supprimer</button>
                        </form>
                    </div>
                </div>
            @empty
                <p class="p-4 text-gray-500">Aucun projet.</p>
            @endforelse
        </div>
    </div>
</x-app-layout>

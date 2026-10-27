@extends('layouts.main')

@section('header', 'Mes projets')

@section('content')
    <div class="p-6 bg-white shadow-sm sm:rounded-lg">
        <h3 class="text-lg font-medium text-gray-900">Nouveau projet</h3>

        <form method="POST" action="{{ route('projects.store') }}" class="mt-4 space-y-4">
            @csrf

            <div>
                <x-input-label for="name" value="Nom" />
                <x-text-input id="name" name="name" type="text" class="mt-1 block w-full" :value="old('name')" required />
                <x-input-error :messages="$errors->get('name')" class="mt-2" />
            </div>

            <div>
                <x-input-label for="description" value="Description" />
                <textarea id="description" name="description" rows="3" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">{{ old('description') }}</textarea>
                <x-input-error :messages="$errors->get('description')" class="mt-2" />
            </div>

            <x-primary-button>Créer</x-primary-button>
        </form>
    </div>

    <div class="p-6 bg-white shadow-sm sm:rounded-lg">
        @forelse ($projects as $project)
            <a href="{{ route('projects.show', $project) }}" class="block py-3 border-b last:border-0 hover:bg-gray-50">
                <span class="font-medium text-gray-900">{{ $project->name }}</span>
                <span class="block text-sm text-gray-500">{{ $project->description }}</span>
                <span class="block mt-1 text-sm text-gray-600">
                    {{ $project->tasks->count() }} tâche(s)
                    @foreach ($project->tasks->take(3) as $task)
                        · {{ $task->title }} ({{ $task->status_label }})
                    @endforeach
                </span>
            </a>
        @empty
            <p class="text-gray-500">Aucun projet pour le moment.</p>
        @endforelse
    </div>
@endsection

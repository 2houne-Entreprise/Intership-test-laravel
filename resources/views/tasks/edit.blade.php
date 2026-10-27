@extends('layouts.main')

@section('header', 'Modifier la tâche · '.$project->name)

@section('content')
    <div class="p-6 bg-white shadow-sm sm:rounded-lg">
        <form method="POST" action="{{ route('projects.tasks.update', [$project, $task]) }}" enctype="multipart/form-data" class="space-y-4">
            @csrf
            @method('PUT')

            @include('tasks.form-fields', ['task' => $task])

            <div class="flex items-center gap-4">
                <x-primary-button>Enregistrer</x-primary-button>
                <a href="{{ route('projects.show', $project) }}" class="text-gray-600 hover:underline">Annuler</a>
            </div>
        </form>
    </div>
@endsection

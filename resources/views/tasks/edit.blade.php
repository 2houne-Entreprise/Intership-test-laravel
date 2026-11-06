@extends('layouts.main')

@section('header')
    <h2 class="font-semibold text-xl text-gray-800">Modifier la tâche</h2>
@endsection

@section('content')
    <form method="POST" action="{{ route('projects.tasks.update', [$project, $task]) }}" class="p-6 bg-white rounded shadow-sm space-y-4">
        @csrf
        @method('PUT')
        @include('tasks.fields')
        <x-primary-button>Enregistrer</x-primary-button>
        <a href="{{ route('projects.show', $project) }}" class="ms-3 text-sm text-gray-600">Annuler</a>
    </form>
@endsection

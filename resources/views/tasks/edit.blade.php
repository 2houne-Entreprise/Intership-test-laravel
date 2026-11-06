@extends('layouts.main')

@section('header')
    <h2 class="font-semibold text-xl text-gray-800">{{ __('Modifier la tâche') }}</h2>
@endsection

@section('content')
    <form method="POST" action="{{ route('projects.tasks.update', [$project, $task]) }}" class="p-6 bg-white rounded shadow-sm space-y-4">
        @csrf
        @method('PUT')
        @include('tasks.fields')
        <x-primary-button>{{ __('Enregistrer') }}</x-primary-button>
        <a href="{{ route('projects.show', $project) }}" class="ms-3 text-sm text-gray-600">{{ __('Annuler') }}</a>
    </form>
@endsection

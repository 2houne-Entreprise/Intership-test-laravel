@extends('layouts.main')

@section('header')
    <h2 class="font-semibold text-xl text-gray-800">Modifier le projet</h2>
@endsection

@section('content')
    <form method="POST" action="{{ route('projects.update', $project) }}" class="p-6 bg-white rounded shadow-sm space-y-4">
        @csrf
        @method('PUT')
        @include('projects.fields')
        <x-primary-button>Enregistrer</x-primary-button>
        <a href="{{ route('projects.index') }}" class="ms-3 text-sm text-gray-600">Annuler</a>
    </form>
@endsection

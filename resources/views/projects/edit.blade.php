
@extends('layouts.taskflow')

@section('title', 'Modifier le projet')

@section('content')
    <div class="max-w-3xl mx-auto">
        <div class="bg-white p-6 shadow rounded-lg">

            <form action="{{ route('projects.update', $project) }}"
                  method="POST">
                @csrf
                @method('PUT')

                <div class="mb-4">
                    <label for="name" class="block mb-2">
                        Nom du projet
                    </label>

                    <input type="text"
                           id="name"
                           name="name"
                           value="{{ old('name', $project->name) }}"
                           class="w-full border-gray-300 rounded"
                           required>

                    @error('name')
                        <x-alert type="error" :message="$message" />
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="description" class="block mb-2">
                        Description
                    </label>

                    <textarea id="description"
                              name="description"
                              class="w-full border-gray-300 rounded">{{ old('description', $project->description) }}</textarea>

                    @error('description')
                        <x-alert type="error" :message="$message" />
                    @enderror
                </div>

                <button type="submit"
                        style="background-color:#2563eb;
                               color:white;
                               padding:10px 20px;
                               border:none;
                               border-radius:6px;
                               cursor:pointer;">
                    Enregistrer les modifications
                </button>

                <a href="{{ route('projects.index') }}"
                   class="ml-4 text-gray-600">
                    Annuler
                </a>
            </form>

        </div>
    </div>
@endsection

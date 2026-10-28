
@extends('layouts.taskflow')

@section('title', $project->name)

@section('content')
    <div class="max-w-4xl mx-auto">

        {{-- Informations du projet --}}
        <div class="bg-white p-6 shadow rounded-lg mb-6">
            <h3 class="text-xl font-bold mb-4">
                {{ $project->name }}
            </h3>

            <p class="text-gray-700 mb-4">
                {{ $project->description ?? 'Aucune description' }}
            </p>

            <p class="text-sm text-gray-500 mb-6">
                Créé le {{ $project->created_at->format('d/m/Y') }}
            </p>

            <a href="{{ route('projects.edit', $project) }}"
               class="text-blue-600">
                Modifier
            </a>

            <a href="{{ route('projects.index') }}"
               class="ml-4 text-gray-600">
                Retour aux projets
            </a>
        </div>

        {{-- Messages de succès --}}
        @if(session('success'))
            <x-alert type="success" :message="session('success')" />
        @endif

        {{-- Formulaire de création de tâche --}}
        <div class="bg-white p-6 shadow rounded-lg mb-6">
            <h3 class="text-xl font-bold mb-4">
                Ajouter une tâche
            </h3>

            <form action="{{ route('tasks.store', $project) }}"
                  method="POST"
                  enctype="multipart/form-data">
                @csrf

                <div class="mb-4">
                    <label for="title" class="block mb-2">
                        Titre *
                    </label>

                    <input type="text"
                           id="title"
                           name="title"
                           value="{{ old('title') }}"
                           class="w-full border-gray-300 rounded">

                    @error('title')
                        <x-alert type="error" :message="$message" />
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="status" class="block mb-2">
                        Statut *
                    </label>

                    <select id="status"
                            name="status"
                            class="w-full border-gray-300 rounded">
                        <option value="pending"
                            @selected(old('status', 'pending') === 'pending')>
                            En attente
                        </option>

                        <option value="in_progress"
                            @selected(old('status') === 'in_progress')>
                            En cours
                        </option>

                        <option value="done"
                            @selected(old('status') === 'done')>
                            Terminée
                        </option>
                    </select>

                    @error('status')
                        <x-alert type="error" :message="$message" />
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="deadline" class="block mb-2">
                        Date limite
                    </label>

                    <input type="date"
                           id="deadline"
                           name="deadline"
                           value="{{ old('deadline') }}"
                           class="w-full border-gray-300 rounded">

                    @error('deadline')
                        <x-alert type="error" :message="$message" />
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="attachment" class="block mb-2">
                        Pièce jointe
                    </label>

                    <input type="file"
                           id="attachment"
                           name="attachment"
                           class="w-full border rounded p-2">

                    @error('attachment')
                        <x-alert type="error" :message="$message" />
                    @enderror
                </div>

                <button type="submit"
                        style="background:#2563eb;
                               color:white;
                               padding:10px 20px;
                               border-radius:6px;
                               cursor:pointer;">
                    Ajouter la tâche
                </button>
            </form>
        </div>

        {{-- Tableau des tâches --}}
        <div class="bg-white p-6 shadow rounded-lg">
            <h3 class="text-xl font-bold mb-4">
                Liste des tâches
            </h3>

            <div class="overflow-x-auto">
                <table class="w-full border-collapse">
                    <thead>
                        <tr class="border-b bg-gray-50">
                            <th class="p-3 text-left">Titre</th>
                            <th class="p-3 text-left">Statut</th>
                            <th class="p-3 text-left">Échéance</th>
                            <th class="p-3 text-left">Actions</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse($project->tasks as $task)
                            <tr class="border-b">
                                <td class="p-3">
                                    {{ $task->title }}
                                </td>

                                <td class="p-3">
                                    <form action="{{ route('tasks.update', [$project, $task]) }}"
                                          method="POST">
                                        @csrf
                                        @method('PUT')

                                        <input type="hidden"
                                               name="title"
                                               value="{{ $task->title }}">

                                        <input type="hidden"
                                               name="deadline"
                                               value="{{ $task->deadline?->format('Y-m-d') }}">

                                        <select name="status"
                                                onchange="this.form.submit()"
                                                class="border-gray-300 rounded text-sm">
                                            <option value="pending"
                                                @selected($task->status === 'pending')>
                                                En attente
                                            </option>

                                            <option value="in_progress"
                                                @selected($task->status === 'in_progress')>
                                                En cours
                                            </option>

                                            <option value="done"
                                                @selected($task->status === 'done')>
                                                Terminée
                                            </option>
                                        </select>

                                        @error('status')
                                            <x-alert type="error" :message="$message" />
                                        @enderror
                                    </form>
                                </td>

                                <td class="p-3">
                                    {{ $task->deadline?->format('d/m/Y') ?? '—' }}
                                </td>

                                <td class="p-3">
                                    @if($task->attachment_path)
                                        <a href="{{ asset('storage/'.$task->attachment_path) }}"
                                           download
                                           class="text-blue-600 block mb-2">
                                            Télécharger
                                        </a>
                                    @endif

                                    <form action="{{ route('tasks.destroy', [$project, $task]) }}"
                                          method="POST"
                                          onsubmit="return confirm('Supprimer cette tâche ?')">
                                        @csrf
                                        @method('DELETE')

                                        <button type="submit"
                                                class="text-red-600">
                                            Supprimer
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4"
                                    class="p-4 text-center text-gray-500">
                                    Aucune tâche pour ce projet.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

    </div>
@endsection

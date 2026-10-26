@extends('layouts.main')

@section('header', $project->name)

@section('content')
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

    <div class="p-6 bg-white shadow-sm sm:rounded-lg">
        <h3 class="text-lg font-medium text-gray-900">Nouvelle tâche</h3>

        <form method="POST" action="{{ route('projects.tasks.store', $project) }}" class="mt-4 space-y-4">
            @csrf

            @include('tasks.form-fields', ['task' => null])

            <x-primary-button>Ajouter</x-primary-button>
        </form>
    </div>

    <div class="p-6 bg-white shadow-sm sm:rounded-lg">
        <h3 class="text-lg font-medium text-gray-900">Tâches</h3>

        @if ($tasks->isEmpty())
            <p class="mt-4 text-gray-500">Aucune tâche pour le moment.</p>
        @else
            <div class="mt-4 overflow-x-auto">
                <table class="min-w-full text-sm text-left">
                    <thead class="border-b text-gray-600">
                        <tr>
                            <th class="py-2 pr-4">Titre</th>
                            <th class="py-2 pr-4">Statut</th>
                            <th class="py-2 pr-4">Échéance</th>
                            <th class="py-2">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($tasks as $task)
                            <tr class="border-b last:border-0">
                                <td class="py-3 pr-4 font-medium text-gray-900">{{ $task->title }}</td>
                                <td class="py-3 pr-4">
                                    <form method="POST" action="{{ route('projects.tasks.update', [$project, $task]) }}">
                                        @csrf
                                        @method('PATCH')

                                        <label for="status-{{ $task->id }}" class="sr-only">Statut</label>
                                        <select id="status-{{ $task->id }}" name="status" onchange="this.form.submit()" class="border-gray-300 rounded-md shadow-sm text-sm">
                                            @foreach (App\TaskStatus::cases() as $status)
                                                <option value="{{ $status->value }}" @selected($task->status === $status)>
                                                    {{ $status->label() }}
                                                </option>
                                            @endforeach
                                        </select>

                                        <noscript>
                                            <x-secondary-button type="submit">OK</x-secondary-button>
                                        </noscript>
                                    </form>
                                </td>
                                <td class="py-3 pr-4 text-gray-600">{{ $task->deadline?->format('d/m/Y') ?? '—' }}</td>
                                <td class="py-3">
                                    <div class="flex items-center gap-4">
                                        <a href="{{ route('projects.tasks.edit', [$project, $task]) }}" class="text-indigo-600 hover:underline">Modifier</a>

                                        <form method="POST" action="{{ route('projects.tasks.destroy', [$project, $task]) }}" onsubmit="return confirm('Supprimer cette tâche ?')">
                                            @csrf
                                            @method('DELETE')

                                            <x-danger-button>Supprimer</x-danger-button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>
@endsection

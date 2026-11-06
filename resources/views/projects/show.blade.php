@extends('layouts.main')

@section('header')
    <a href="{{ route('projects.index') }}" class="text-sm text-gray-500 hover:text-gray-700">← Projets</a>
    <div class="flex justify-between items-start gap-4">
        <div>
            <h2 class="font-semibold text-xl text-gray-800">{{ $project->name }}</h2>
            <p class="text-sm text-gray-600">{{ $project->description }}</p>
        </div>
        <a href="{{ route('projects.edit', $project) }}" class="text-sm text-indigo-600 shrink-0">Modifier le projet</a>
    </div>
@endsection

@section('content')
    <form method="POST" action="{{ route('projects.tasks.store', $project) }}" class="p-6 bg-white rounded shadow-sm space-y-4">
        @csrf
        @include('tasks.fields', ['task' => null])
        <x-primary-button>Ajouter la tâche</x-primary-button>
    </form>

    <div class="bg-white rounded shadow-sm overflow-x-auto">
        <table class="w-full text-sm">
            <thead class="bg-gray-50 text-left text-gray-600">
                <tr>
                    <th class="p-3">Titre</th>
                    <th class="p-3">Statut</th>
                    <th class="p-3">Échéance</th>
                    <th class="p-3">Changer</th>
                    <th class="p-3"></th>
                </tr>
            </thead>
            <tbody class="divide-y">
                @forelse ($project->tasks as $task)
                    <tr>
                        <td class="p-3 font-medium">{{ $task->title }}</td>
                        <td class="p-3">
                            <span @class([
                                'px-2 py-0.5 rounded-full text-xs whitespace-nowrap',
                                'bg-gray-100 text-gray-700' => $task->status === App\Enums\TaskStatus::Pending,
                                'bg-amber-100 text-amber-800' => $task->status === App\Enums\TaskStatus::InProgress,
                                'bg-green-100 text-green-800' => $task->status === App\Enums\TaskStatus::Done,
                            ])>{{ $task->status_label }}</span>
                        </td>
                        <td class="p-3 whitespace-nowrap">
                            {{ $task->deadline?->format('d/m/Y') ?? '—' }}
                            @if ($task->isOverdue())
                                <span class="ms-1 px-2 py-0.5 rounded-full text-xs bg-red-100 text-red-700">En retard</span>
                            @endif
                        </td>
                        <td class="p-3">
                            <form method="POST" action="{{ route('projects.tasks.status', [$project, $task]) }}" class="flex gap-2">
                                @csrf
                                @method('PATCH')
                                <select name="status" class="border-gray-300 rounded-md text-sm py-1">
                                    @foreach (App\Enums\TaskStatus::cases() as $status)
                                        <option value="{{ $status->value }}" @selected($task->status === $status)>{{ $status->label() }}</option>
                                    @endforeach
                                </select>
                                <button class="text-indigo-600">OK</button>
                            </form>
                        </td>
                        <td class="p-3">
                            <div class="flex justify-end gap-3">
                                <a href="{{ route('projects.tasks.edit', [$project, $task]) }}" class="text-indigo-600">Modifier</a>
                                <form method="POST" action="{{ route('projects.tasks.destroy', [$project, $task]) }}" onsubmit="return confirm('Supprimer cette tâche ?')">
                                    @csrf
                                    @method('DELETE')
                                    <button class="text-red-600">Supprimer</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="p-4 text-gray-500">Aucune tâche.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
@endsection

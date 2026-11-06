@extends('layouts.main')

@section('header')
    <h2 class="font-semibold text-xl text-gray-800">{{ $project->name }}</h2>
    <p class="text-sm text-gray-600">{{ $project->description }}</p>
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
                    <th class="p-3"></th>
                </tr>
            </thead>
            <tbody class="divide-y">
                @forelse ($project->tasks as $task)
                    <tr>
                        <td class="p-3 font-medium">{{ $task->title }}</td>
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
                        <td class="p-3">{{ $task->deadline?->format('d/m/Y') ?? '—' }}</td>
                        <td class="p-3 text-right">
                            <a href="{{ route('projects.tasks.edit', [$project, $task]) }}" class="text-indigo-600">Modifier</a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="p-4 text-gray-500">Aucune tâche.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
@endsection

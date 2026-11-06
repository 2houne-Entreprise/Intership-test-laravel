<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800">{{ $project->name }}</h2>
        <p class="text-sm text-gray-600">{{ $project->description }}</p>
    </x-slot>

    <div class="py-8 max-w-3xl mx-auto px-4 space-y-6">
        @if (session('success'))
            <p class="p-3 bg-green-100 text-green-800 rounded">{{ session('success') }}</p>
        @endif

        <form method="POST" action="{{ route('projects.tasks.store', $project) }}" class="p-6 bg-white rounded shadow-sm space-y-4">
            @csrf
            @include('tasks.fields', ['task' => null])
            <x-primary-button>Ajouter la tâche</x-primary-button>
        </form>

        <div class="bg-white rounded shadow-sm divide-y">
            @forelse ($project->tasks as $task)
                <div class="p-4 flex justify-between gap-4">
                    <div>
                        <p class="font-semibold">{{ $task->title }}</p>
                        <p class="text-sm text-gray-600">
                            {{ $task->status->label() }}
                            @if ($task->deadline) · {{ $task->deadline->format('d/m/Y') }} @endif
                        </p>
                    </div>
                    <a href="{{ route('projects.tasks.edit', [$project, $task]) }}" class="text-sm text-indigo-600">Modifier</a>
                </div>
            @empty
                <p class="p-4 text-gray-500">Aucune tâche.</p>
            @endforelse
        </div>
    </div>
</x-app-layout>

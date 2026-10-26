<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ $project->name }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            @if (session('success'))
                <div class="p-4 bg-green-100 text-green-800 rounded-md">
                    {{ session('success') }}
                </div>
            @endif

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

                @forelse ($tasks as $task)
                    <div class="flex items-center justify-between py-3 border-b last:border-0">
                        <div>
                            <span class="font-medium text-gray-900">{{ $task->title }}</span>
                            <span class="block text-sm text-gray-500">
                                {{ $task->status->label() }}
                                @if ($task->deadline)
                                    · échéance le {{ $task->deadline->format('d/m/Y') }}
                                @endif
                            </span>
                        </div>

                        <div class="flex items-center gap-4">
                            <a href="{{ route('projects.tasks.edit', [$project, $task]) }}" class="text-indigo-600 hover:underline">Modifier</a>

                            <form method="POST" action="{{ route('projects.tasks.destroy', [$project, $task]) }}" onsubmit="return confirm('Supprimer cette tâche ?')">
                                @csrf
                                @method('DELETE')

                                <x-danger-button>Supprimer</x-danger-button>
                            </form>
                        </div>
                    </div>
                @empty
                    <p class="mt-4 text-gray-500">Aucune tâche pour le moment.</p>
                @endforelse
            </div>
        </div>
    </div>
</x-app-layout>

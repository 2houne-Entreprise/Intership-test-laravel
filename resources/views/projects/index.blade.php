@extends('layouts.main')

@section('header')
    <h2 class="font-semibold text-xl text-gray-800">{{ __('Mes projets') }}</h2>
@endsection

@section('content')
    <form method="POST" action="{{ route('projects.store') }}" class="p-6 bg-white rounded shadow-sm space-y-4">
        @csrf
        @include('projects.fields', ['project' => null])
        <x-primary-button>{{ __('Créer') }}</x-primary-button>
    </form>

    <form method="GET" class="flex gap-2">
        <x-text-input name="q" :value="request('q')" :placeholder="__('Rechercher un projet')" class="flex-1 min-w-0 text-sm" />
        <x-secondary-button type="submit">{{ __('Rechercher') }}</x-secondary-button>
    </form>

    <div class="bg-white rounded shadow-sm divide-y">
        @forelse ($projects as $project)
            <div class="p-4 flex justify-between gap-4">
                <div>
                    <a href="{{ route('projects.show', $project) }}" class="font-semibold hover:text-indigo-600">{{ $project->name }}</a>
                    <p class="text-sm text-gray-600">{{ $project->description }}</p>
                    <p class="mt-1 text-xs text-gray-500">
                        {{ trans_choice('{0,1} :count tâche|[2,*] :count tâches', $project->tasks_count) }}
                        @if ($project->overdue_count)
                            · <span class="text-red-600">{{ __(':count en retard', ['count' => $project->overdue_count]) }}</span>
                        @endif
                    </p>
                </div>
                <div class="flex gap-3 text-sm">
                    <a href="{{ route('projects.edit', $project) }}" class="text-indigo-600">{{ __('Modifier') }}</a>
                    <form method="POST" action="{{ route('projects.destroy', $project) }}" onsubmit="return confirm(@js(__('Supprimer ce projet ?')))">
                        @csrf
                        @method('DELETE')
                        <button class="text-red-600">{{ __('Supprimer') }}</button>
                    </form>
                </div>
            </div>
        @empty
            <p class="p-4 text-gray-500">{{ request('q') ? __('Aucun projet ne correspond à la recherche.') : __('Aucun projet.') }}</p>
        @endforelse
    </div>

    {{ $projects->links() }}
@endsection

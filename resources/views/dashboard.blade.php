@extends('layouts.main')

@section('header')
    <h2 class="font-semibold text-xl text-gray-800">Tableau de bord</h2>
@endsection

@section('content')
    @if ($projectsCount === 0)
        <div class="p-8 bg-white rounded shadow-sm text-center">
            <p class="text-gray-600">Vous n'avez pas encore de projet.</p>
            <a href="{{ route('projects.index') }}" class="mt-4 inline-block px-4 py-2 rounded-md bg-indigo-600 text-white hover:bg-indigo-700">
                Créer mon premier projet
            </a>
        </div>
    @else
        @php
            $done = $statusCounts['done'] ?? 0;
            $colors = ['pending' => 'bg-gray-400', 'in_progress' => 'bg-amber-400', 'done' => 'bg-green-500'];
        @endphp

        <div class="grid grid-cols-2 sm:grid-cols-4 gap-4">
            <div class="p-4 bg-white rounded shadow-sm">
                <p class="text-sm text-gray-500">Projets</p>
                <p class="text-2xl font-semibold">{{ $projectsCount }}</p>
            </div>
            <div class="p-4 bg-white rounded shadow-sm">
                <p class="text-sm text-gray-500">Tâches</p>
                <p class="text-2xl font-semibold">{{ $totalTasks }}</p>
            </div>
            <div class="p-4 bg-white rounded shadow-sm">
                <p class="text-sm text-gray-500">En retard</p>
                <p @class(['text-2xl font-semibold', 'text-red-600' => $overdueCount > 0])>{{ $overdueCount }}</p>
            </div>
            <div class="p-4 bg-white rounded shadow-sm">
                <p class="text-sm text-gray-500">Terminées</p>
                <p class="text-2xl font-semibold">{{ $totalTasks ? round($done / $totalTasks * 100) : 0 }} %</p>
            </div>
        </div>

        <div class="grid sm:grid-cols-2 gap-4">
            <div class="p-6 bg-white rounded shadow-sm">
                <h3 class="font-semibold mb-4">Tâches par statut</h3>
                <div class="space-y-3">
                    @foreach (App\Enums\TaskStatus::cases() as $status)
                        @php $count = $statusCounts[$status->value] ?? 0; @endphp
                        <div>
                            <div class="flex justify-between text-sm">
                                <span>{{ $status->label() }}</span>
                                <span class="text-gray-500">{{ $count }}</span>
                            </div>
                            <div class="mt-1 h-2 bg-gray-100 rounded-full">
                                <div class="h-2 rounded-full {{ $colors[$status->value] }}" style="width: {{ $totalTasks ? $count / $totalTasks * 100 : 0 }}%"></div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            <div class="p-6 bg-white rounded shadow-sm">
                <h3 class="font-semibold mb-4">Avancement des projets</h3>
                <div class="space-y-3">
                    @foreach ($projects as $project)
                        @php $percent = $project->tasks_count ? round($project->done_count / $project->tasks_count * 100) : 0; @endphp
                        <a href="{{ route('projects.show', $project) }}" class="block group">
                            <div class="flex justify-between text-sm">
                                <span class="group-hover:text-indigo-600 truncate">{{ $project->name }}</span>
                                <span class="text-gray-500 shrink-0">{{ $project->done_count }}/{{ $project->tasks_count }}</span>
                            </div>
                            <div class="mt-1 h-2 bg-gray-100 rounded-full">
                                <div class="h-2 rounded-full bg-indigo-500" style="width: {{ $percent }}%"></div>
                            </div>
                        </a>
                    @endforeach
                </div>
            </div>
        </div>

        <div class="bg-white rounded shadow-sm">
            <h3 class="p-4 font-semibold border-b">En retard</h3>
            @forelse ($overdueTasks as $task)
                <a href="{{ route('projects.show', $task->project) }}" class="p-4 flex justify-between gap-4 border-b last:border-0 hover:bg-gray-50">
                    <div>
                        <p class="font-medium">{{ $task->title }}</p>
                        <p class="text-sm text-gray-500">{{ $task->project->name }}</p>
                    </div>
                    <span class="text-sm text-red-600 shrink-0">{{ $task->deadline->format('d/m/Y') }}</span>
                </a>
            @empty
                <p class="p-4 text-gray-500">Aucune tâche en retard.</p>
            @endforelse
        </div>
    @endif
@endsection

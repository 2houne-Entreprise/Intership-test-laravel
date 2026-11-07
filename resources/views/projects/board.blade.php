@extends('layouts.main')

@section('width', 'max-w-6xl')

@section('header')
    @include('projects.header')
@endsection

@section('content')
    <p class="text-sm text-gray-500">{{ __('Glissez une tâche pour changer son statut.') }}</p>

    <p data-board-error class="hidden p-3 rounded bg-red-100 text-red-800">{{ __('Impossible de déplacer la tâche. Réessayez.') }}</p>
    <p data-board-live class="sr-only" aria-live="polite"></p>

    <div data-board data-moved="{{ __('Tâche déplacée vers') }}" class="grid md:grid-cols-3 gap-4 items-start">
        @foreach (App\Enums\TaskStatus::cases() as $status)
            @php $tasks = $columns->get($status->value, collect()); @endphp

            <section data-column="{{ $status->value }}" data-label="{{ $status->label() }}"
                     class="rounded-lg bg-gray-50 p-3 ring-1 ring-gray-200 transition-colors data-[over=true]:bg-indigo-50 data-[over=true]:ring-2 data-[over=true]:ring-indigo-300">
                <h3 class="flex items-center justify-between px-1 pb-3 text-sm font-semibold text-gray-700">
                    <span class="flex items-center gap-2">
                        <span @class([
                            'h-2 w-2 rounded-full',
                            'bg-gray-400' => $status === App\Enums\TaskStatus::Pending,
                            'bg-amber-400' => $status === App\Enums\TaskStatus::InProgress,
                            'bg-green-500' => $status === App\Enums\TaskStatus::Done,
                        ])></span>
                        {{ $status->label() }}
                    </span>
                    <span data-count class="font-normal text-gray-400">{{ $tasks->count() }}</span>
                </h3>

                <ul data-list class="space-y-2">
                    @foreach ($tasks as $task)
                        <li data-task draggable="true" data-url="{{ route('projects.tasks.status', [$project, $task]) }}"
                            class="cursor-grab rounded-md bg-white p-3 shadow-sm ring-1 ring-gray-200 hover:ring-indigo-300 active:cursor-grabbing data-[dragging=true]:opacity-50">
                            <p class="text-sm font-medium text-gray-900">{{ $task->title }}</p>
                            <div class="mt-2 flex items-center gap-2 text-xs text-gray-500">
                                @if ($task->deadline)
                                    <span>{{ $task->deadline->format('d/m/Y') }}</span>
                                @endif
                                <span data-overdue @class(['px-2 py-0.5 rounded-full bg-red-100 text-red-700', 'hidden' => ! $task->isOverdue()])>{{ __('En retard') }}</span>
                                @if ($task->attachment_path)
                                    <svg class="ms-auto h-4 w-4 text-gray-400" viewBox="0 0 20 20" fill="currentColor" role="img" aria-label="{{ __('Pièce jointe') }}">
                                        <path fill-rule="evenodd" d="M15.621 4.379a3 3 0 0 0-4.242 0l-7 7a3 3 0 0 0 4.241 4.243h.001l.497-.5a.75.75 0 0 1 1.064 1.057l-.498.501-.002.002a4.5 4.5 0 0 1-6.364-6.364l7-7a4.5 4.5 0 0 1 6.368 6.36l-3.455 3.553A2.625 2.625 0 1 1 9.52 9.52l3.45-3.451a.75.75 0 1 1 1.061 1.06l-3.45 3.451a1.125 1.125 0 0 0 1.587 1.595l3.454-3.553a3 3 0 0 0 0-4.242Z" clip-rule="evenodd" />
                                    </svg>
                                @endif
                            </div>
                        </li>
                    @endforeach
                </ul>

                <p data-empty @class(['py-6 text-center text-sm text-gray-400 rounded-md border-2 border-dashed border-gray-200', 'hidden' => $tasks->isNotEmpty()])>
                    {{ __('Déposez une tâche ici') }}
                </p>
            </section>
        @endforeach
    </div>
@endsection

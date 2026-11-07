@extends('layouts.main')

@section('header')
    @include('projects.header')
@endsection

@section('content')
    <form method="POST" action="{{ route('projects.tasks.store', $project) }}" enctype="multipart/form-data" class="p-6 bg-white rounded shadow-sm space-y-4">
        @csrf
        @include('tasks.fields', ['task' => null])

        <div>
            <x-input-label for="attachment" :value="__('Pièce jointe (pdf, image, doc, 5 Mo max)')" />
            <input id="attachment" name="attachment" type="file" accept=".pdf,.jpg,.jpeg,.png,.txt,.doc,.docx"
                   class="mt-1 block w-full text-sm text-gray-600 file:me-3 file:rounded-md file:border-0 file:bg-indigo-50 file:px-3 file:py-2 file:text-sm file:font-medium file:text-indigo-700 hover:file:bg-indigo-100 file:cursor-pointer">
            <x-input-error :messages="$errors->get('attachment')" class="mt-2" />
        </div>
        <x-primary-button>{{ __('Ajouter la tâche') }}</x-primary-button>
    </form>

    <form method="GET" class="flex flex-wrap gap-2">
        <x-text-input name="q" :value="request('q')" :placeholder="__('Rechercher une tâche')" class="flex-1 min-w-0 text-sm" />
        <select name="status" aria-label="{{ __('Filtrer par statut') }}" class="border-gray-300 rounded-md shadow-sm text-sm">
            <option value="">{{ __('Tous les statuts') }}</option>
            @foreach (App\Enums\TaskStatus::cases() as $status)
                <option value="{{ $status->value }}" @selected(request('status') === $status->value)>{{ $status->label() }}</option>
            @endforeach
        </select>
        <x-secondary-button type="submit">{{ __('Filtrer') }}</x-secondary-button>
    </form>

    <div class="bg-white rounded shadow-sm overflow-x-auto">
        <table class="block sm:table w-full text-sm">
            <thead class="hidden sm:table-header-group bg-gray-50 text-left text-gray-600">
                <tr>
                    <th class="p-3">{{ __('Titre') }}</th>
                    <th class="p-3">{{ __('Statut') }}</th>
                    <th class="p-3">{{ __('Échéance') }}</th>
                    <th class="p-3">{{ __('Changer') }}</th>
                    <th class="p-3"></th>
                </tr>
            </thead>
            <tbody class="block sm:table-row-group divide-y">
                @forelse ($tasks as $task)
                    <tr class="block sm:table-row py-2 sm:py-0">
                        <td class="block sm:table-cell px-3 pt-1 sm:p-3">
                            <p class="font-medium">{{ $task->title }}</p>
                            @if ($task->attachment_path)
                                <a href="{{ Storage::url($task->attachment_path) }}" target="_blank" rel="noopener" class="text-xs text-indigo-600 hover:underline">
                                    {{ __('Voir la pièce jointe') }} ({{ strtoupper(pathinfo($task->attachment_path, PATHINFO_EXTENSION)) }})
                                </a>
                            @endif
                        </td>
                        <td class="inline-block sm:table-cell px-3 py-1 sm:p-3">
                            <span @class([
                                'px-2 py-0.5 rounded-full text-xs whitespace-nowrap',
                                'bg-gray-100 text-gray-700' => $task->status === App\Enums\TaskStatus::Pending,
                                'bg-amber-100 text-amber-800' => $task->status === App\Enums\TaskStatus::InProgress,
                                'bg-green-100 text-green-800' => $task->status === App\Enums\TaskStatus::Done,
                            ])>{{ $task->status_label }}</span>
                        </td>
                        <td class="inline-block sm:table-cell py-1 sm:p-3 whitespace-nowrap text-gray-600 sm:text-gray-900">
                            {{ $task->deadline?->format('d/m/Y') ?? '—' }}
                            @if ($task->isOverdue())
                                <span class="ms-1 px-2 py-0.5 rounded-full text-xs bg-red-100 text-red-700">{{ __('En retard') }}</span>
                            @endif
                        </td>
                        <td class="block sm:table-cell px-3 py-1 sm:p-3">
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
                        <td class="block sm:table-cell px-3 pt-1 pb-2 sm:p-3">
                            <div class="flex sm:justify-end gap-4">
                                <a href="{{ route('projects.tasks.edit', [$project, $task]) }}" class="text-indigo-600">{{ __('Modifier') }}</a>
                                <form method="POST" action="{{ route('projects.tasks.destroy', [$project, $task]) }}" onsubmit="return confirm(@js(__('Supprimer cette tâche ?')))">
                                    @csrf
                                    @method('DELETE')
                                    <button class="text-red-600">{{ __('Supprimer') }}</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="block sm:table-cell p-4 text-gray-500">
                            {{ request()->hasAny(['q', 'status']) ? __('Aucune tâche ne correspond à la recherche.') : __('Aucune tâche.') }}
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{ $tasks->links() }}
@endsection

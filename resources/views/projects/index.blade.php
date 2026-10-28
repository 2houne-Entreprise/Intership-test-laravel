
@extends('layouts.taskflow')

@section('title', 'Mes projets')

@section('content')
    <div class="bg-white p-6 shadow rounded-lg">

        @if(session('success'))
            <x-alert type="success" :message="session('success')" />
        @endif

        <a href="{{ route('projects.create') }}"
           style="display:inline-block;
                  background-color:#2563eb;
                  color:white;
                  padding:10px 18px;
                  border-radius:6px;
                  margin-bottom:24px;
                  text-decoration:none;">
            + Nouveau projet
        </a>

        <div class="overflow-x-auto">
            <table class="w-full border-collapse">
                <thead>
                    <tr class="bg-gray-100">
                        <th class="p-3 text-left">Nom</th>
                        <th class="p-3 text-left">Description</th>
                        <th class="p-3 text-left">Actions</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse($projects as $project)
                        <tr class="border-b">
                            <td class="p-3">
                                {{ $project->name }}
                            </td>

                            <td class="p-3">
                                {{ $project->description ?? '—' }}
                            </td>

                            <td class="p-3">
                                <a href="{{ route('projects.show', $project) }}"
                                   class="text-blue-600">
                                    Voir
                                </a>

                                <a href="{{ route('projects.edit', $project) }}"
                                   class="text-orange-600 ml-3">
                                    Modifier
                                </a>

                                <form action="{{ route('projects.destroy', $project) }}"
                                      method="POST"
                                      class="inline ml-3"
                                      onsubmit="return confirm('Supprimer ce projet ?')">
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
                            <td colspan="3"
                                class="p-4 text-center text-gray-500">
                                Aucun projet pour le moment.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

    </div>
@endsection

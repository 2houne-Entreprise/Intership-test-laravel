<a href="{{ route('projects.index') }}" class="text-sm text-gray-500 hover:text-gray-700">← {{ __('Projets') }}</a>
<div class="flex justify-between items-start gap-4">
    <div>
        <h2 class="font-semibold text-xl text-gray-800">{{ $project->name }}</h2>
        <p class="text-sm text-gray-600">{{ $project->description }}</p>
    </div>
    <a href="{{ route('projects.edit', $project) }}" class="text-sm text-indigo-600 shrink-0">{{ __('Modifier le projet') }}</a>
</div>

<nav class="mt-4 inline-flex rounded-md bg-gray-100 p-1 text-sm" aria-label="{{ __('Affichage') }}">
    @foreach (['projects.show' => __('Liste'), 'projects.board' => __('Tableau Kanban')] as $route => $label)
        <a href="{{ route($route, $project) }}"
           @if (request()->routeIs($route)) aria-current="page" @endif
           @class([
               'px-3 py-1.5 rounded',
               'bg-white shadow-sm font-medium text-gray-900' => request()->routeIs($route),
               'text-gray-600 hover:text-gray-900' => ! request()->routeIs($route),
           ])>{{ $label }}</a>
    @endforeach
</nav>

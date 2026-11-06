<?php

namespace App\Http\Controllers;

use App\Enums\TaskStatus;
use Illuminate\Http\Request;

class ProjectController extends Controller
{
    public function index(Request $request)
    {
        $projects = $request->user()->projects()
            ->when($request->query('q'), fn ($query, $search) => $query->where('name', 'like', "%{$search}%"))
            ->withCount(['tasks', 'tasks as overdue_count' => fn ($query) => $query->overdue()])
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view('projects.index', compact('projects'));
    }

    public function store(Request $request)
    {
        $request->user()->projects()->create($this->validated($request));

        return back()->with('success', 'Projet créé.');
    }

    public function show(Request $request, string $id)
    {
        $project = $request->user()->projects()->findOrFail($id);

        $tasks = $project->tasks()
            ->when($request->query('q'), fn ($query, $search) => $query->where('title', 'like', "%{$search}%"))
            ->when(TaskStatus::tryFrom((string) $request->query('status')), fn ($query, $status) => $query->where('status', $status))
            ->orderByRaw("status = 'done'")
            ->orderByRaw('deadline is null')
            ->orderBy('deadline')
            ->paginate(10)
            ->withQueryString();

        return view('projects.show', compact('project', 'tasks'));
    }

    public function edit(Request $request, string $id)
    {
        $project = $request->user()->projects()->findOrFail($id);

        return view('projects.edit', compact('project'));
    }

    public function update(Request $request, string $id)
    {
        $project = $request->user()->projects()->findOrFail($id);
        $project->update($this->validated($request));

        return redirect()->route('projects.index')->with('success', 'Projet modifié.');
    }

    public function destroy(Request $request, string $id)
    {
        $project = $request->user()->projects()->findOrFail($id);
        $project->tasks->each->delete();
        $project->delete();

        return back()->with('success', 'Projet supprimé.');
    }

    private function validated(Request $request): array
    {
        return $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
        ]);
    }
}

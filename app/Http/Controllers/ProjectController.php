<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ProjectController extends Controller
{
    public function index(Request $request)
    {
        $projects = $request->user()->projects()
            ->withCount(['tasks', 'tasks as overdue_count' => fn ($query) => $query->overdue()])
            ->latest()
            ->get();

        return view('projects.index', compact('projects'));
    }

    public function store(Request $request)
    {
        $request->user()->projects()->create($this->validated($request));

        return back()->with('success', 'Projet créé.');
    }

    public function show(Request $request, string $id)
    {
        $project = $request->user()->projects()->with('tasks')->findOrFail($id);

        return view('projects.show', compact('project'));
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

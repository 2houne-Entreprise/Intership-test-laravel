<?php

namespace App\Http\Controllers;

use App\Models\Project;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ProjectController extends Controller
{
    public function index(Request $request): View
    {
        $projects = $request->user()
            ->projects()
            ->with('tasks')
            ->latest()
            ->get();

        return view('projects.index', compact('projects'));
    }

    public function create(): View
    {
        return view('projects.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
        ]);

        $request->user()->projects()->create($validated);

        return redirect()
            ->route('projects.index')
            ->with('success', 'Projet créé avec succès.');
    }

    public function show(Request $request, string $id): View
    {
        $project = $this->findOwnedProject($request, $id);

        $project->load('tasks');

        return view('projects.show', compact('project'));
    }

    public function edit(Request $request, string $id): View
    {
        $project = $this->findOwnedProject($request, $id);

        return view('projects.edit', compact('project'));
    }

    public function update(
        Request $request,
        string $id
    ): RedirectResponse {
        $project = $this->findOwnedProject($request, $id);

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
        ]);

        $project->update($validated);

        return redirect()
            ->route('projects.index')
            ->with('success', 'Projet modifié avec succès.');
    }

    public function destroy(
        Request $request,
        string $id
    ): RedirectResponse {
        $project = $this->findOwnedProject($request, $id);

        $project->delete();

        return redirect()
            ->route('projects.index')
            ->with('success', 'Projet supprimé avec succès.');
    }

    private function findOwnedProject(
        Request $request,
        string $id
    ): Project {
        return $request->user()
            ->projects()
            ->findOrFail($id);
    }
}

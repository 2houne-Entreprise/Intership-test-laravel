<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProjectRequest;
use App\Models\Project;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ProjectController extends Controller
{
    /**
     * Display the authenticated user's projects.
     */
    public function index(Request $request): View
    {
        $projects = $request->user()->projects()->latest()->get();

        return view('projects.index', ['projects' => $projects]);
    }

    /**
     * Store a new project for the authenticated user.
     */
    public function store(ProjectRequest $request): RedirectResponse
    {
        $request->user()->projects()->create($request->validated());

        return redirect()->route('projects.index')->with('success', 'Projet créé avec succès.');
    }

    /**
     * Display the specified project.
     */
    public function show(Request $request, Project $project): View
    {
        $this->ensureOwnership($request, $project);

        return view('projects.show', [
            'project' => $project,
            'tasks' => $project->tasks()->latest()->get(),
        ]);
    }

    /**
     * Show the form for editing the specified project.
     */
    public function edit(Request $request, Project $project): View
    {
        $this->ensureOwnership($request, $project);

        return view('projects.edit', ['project' => $project]);
    }

    /**
     * Update the specified project.
     */
    public function update(ProjectRequest $request, Project $project): RedirectResponse
    {
        $this->ensureOwnership($request, $project);

        $project->update($request->validated());

        return redirect()->route('projects.show', $project)->with('success', 'Projet mis à jour.');
    }

    /**
     * Delete the specified project.
     */
    public function destroy(Request $request, Project $project): RedirectResponse
    {
        $this->ensureOwnership($request, $project);

        $project->delete();

        return redirect()->route('projects.index')->with('success', 'Projet supprimé.');
    }
}

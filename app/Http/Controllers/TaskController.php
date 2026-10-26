<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTaskRequest;
use App\Http\Requests\UpdateTaskRequest;
use App\Models\Project;
use App\Models\Task;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class TaskController extends Controller
{
    /**
     * Store a new task in the given project.
     */
    public function store(StoreTaskRequest $request, Project $project): RedirectResponse
    {
        $this->ensureOwnership($request, $project);

        $project->tasks()->create($request->validated());

        return redirect()->route('projects.show', $project)->with('success', 'Tâche ajoutée.');
    }

    /**
     * Show the form for editing the given task.
     */
    public function edit(Request $request, Project $project, Task $task): View
    {
        $this->ensureOwnership($request, $project);

        return view('tasks.edit', ['project' => $project, 'task' => $task]);
    }

    /**
     * Update the given task.
     */
    public function update(UpdateTaskRequest $request, Project $project, Task $task): RedirectResponse
    {
        $this->ensureOwnership($request, $project);

        $task->update($request->validated());

        return redirect()->route('projects.show', $project)->with('success', 'Tâche mise à jour.');
    }

    /**
     * Delete the given task.
     */
    public function destroy(Request $request, Project $project, Task $task): RedirectResponse
    {
        $this->ensureOwnership($request, $project);

        $task->delete();

        return redirect()->route('projects.show', $project)->with('success', 'Tâche supprimée.');
    }
}

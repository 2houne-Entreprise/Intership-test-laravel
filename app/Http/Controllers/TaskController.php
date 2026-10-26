<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTaskRequest;
use App\Http\Requests\UpdateTaskRequest;
use App\Models\Project;
use App\Models\Task;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class TaskController extends Controller
{
    /**
     * Store a new task in the given project.
     */
    public function store(StoreTaskRequest $request, Project $project): RedirectResponse
    {
        $project->tasks()->create($request->validated());

        return redirect()->route('projects.show', $project)->with('success', 'Tâche ajoutée.');
    }

    /**
     * Show the form for editing the given task.
     */
    public function edit(Project $project, Task $task): View
    {
        return view('tasks.edit', ['project' => $project, 'task' => $task]);
    }

    /**
     * Update the given task.
     */
    public function update(UpdateTaskRequest $request, Project $project, Task $task): RedirectResponse
    {
        $task->update($request->validated());

        return redirect()->route('projects.show', $project)->with('success', 'Tâche mise à jour.');
    }

    /**
     * Delete the given task.
     */
    public function destroy(Project $project, Task $task): RedirectResponse
    {
        $task->delete();

        return redirect()->route('projects.show', $project)->with('success', 'Tâche supprimée.');
    }
}

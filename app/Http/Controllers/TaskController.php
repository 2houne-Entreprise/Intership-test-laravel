<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTaskRequest;
use App\Http\Requests\UpdateTaskRequest;
use App\Models\Project;
use App\Models\Task;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class TaskController extends Controller
{
    /**
     * Store a new task in the given project.
     */
    public function store(StoreTaskRequest $request, Project $project): RedirectResponse
    {
        $data = $request->safe()->except('attachment');

        if ($request->hasFile('attachment')) {
            $data['attachment_path'] = $this->storeAttachment($request);
        }

        $project->tasks()->create($data);

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
     * Update the given task, replacing its attachment when a new file is sent.
     */
    public function update(UpdateTaskRequest $request, Project $project, Task $task): RedirectResponse
    {
        $data = $request->safe()->except('attachment');

        if ($request->hasFile('attachment')) {
            $this->deleteAttachment($task);
            $data['attachment_path'] = $this->storeAttachment($request);
        }

        $task->update($data);

        return redirect()->route('projects.show', $project)->with('success', 'Tâche mise à jour.');
    }

    /**
     * Delete the given task and its attachment.
     */
    public function destroy(Project $project, Task $task): RedirectResponse
    {
        $this->deleteAttachment($task);

        $task->delete();

        return redirect()->route('projects.show', $project)->with('success', 'Tâche supprimée.');
    }

    /**
     * Store the uploaded attachment on the public disk and return its path.
     */
    private function storeAttachment(StoreTaskRequest $request): string
    {
        return Storage::disk('public')->putFile('attachments', $request->file('attachment'));
    }

    /**
     * Remove the task's attachment file from the public disk, if any.
     */
    private function deleteAttachment(Task $task): void
    {
        if ($task->attachment_path) {
            Storage::disk('public')->delete($task->attachment_path);
        }
    }
}

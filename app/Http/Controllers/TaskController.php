<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTaskRequest;
use App\Http\Requests\UpdateTaskRequest;
use App\Models\Project;
use App\Models\Task;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class TaskController extends Controller
{
    public function store(
        StoreTaskRequest $request,
        Project $project
    ): RedirectResponse {
        $this->checkOwnership($request, $project);

        $data = $request->safe()->except('attachment');

        if ($request->hasFile('attachment')) {
            $data['attachment_path'] = $request
                ->file('attachment')
                ->store('attachments', 'public');
        }

        $project->tasks()->create($data);

        return redirect()
            ->route('projects.show', $project)
            ->with('success', 'Tâche créée avec succès.');
    }

    public function update(
        UpdateTaskRequest $request,
        Project $project,
        Task $task
    ): RedirectResponse {
        $this->checkOwnership($request, $project);

        $task = $project->tasks()
            ->findOrFail($task->id);

        $data = $request->safe()->except('attachment');

        if ($request->hasFile('attachment')) {
            $newPath = $request
                ->file('attachment')
                ->store('attachments', 'public');

            if ($task->attachment_path) {
                Storage::disk('public')
                    ->delete($task->attachment_path);
            }

            $data['attachment_path'] = $newPath;
        }

        $task->update($data);

        return redirect()
            ->route('projects.show', $project)
            ->with('success', 'Tâche modifiée avec succès.');
    }

    public function destroy(
        Request $request,
        Project $project,
        Task $task
    ): RedirectResponse {
        $this->checkOwnership($request, $project);

        $task = $project->tasks()
            ->findOrFail($task->id);

        if ($task->attachment_path) {
            Storage::disk('public')
                ->delete($task->attachment_path);
        }

        $task->delete();

        return redirect()
            ->route('projects.show', $project)
            ->with('success', 'Tâche supprimée avec succès.');
    }

    private function checkOwnership(
        Request $request,
        Project $project
    ): void {
        abort_unless(
            $project->user_id === $request->user()->id,
            403
        );
    }
}

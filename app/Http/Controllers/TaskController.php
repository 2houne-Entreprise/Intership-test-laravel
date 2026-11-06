<?php

namespace App\Http\Controllers;

use App\Enums\TaskStatus;
use App\Http\Requests\StoreTaskRequest;
use App\Http\Requests\UpdateTaskRequest;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class TaskController extends Controller
{
    public function store(StoreTaskRequest $request, string $projectId)
    {
        $project = $request->user()->projects()->findOrFail($projectId);
        $project->tasks()->create($request->validated());

        return back()->with('success', 'Tâche ajoutée.');
    }

    public function edit(Request $request, string $projectId, string $taskId)
    {
        $project = $request->user()->projects()->findOrFail($projectId);
        $task = $project->tasks()->findOrFail($taskId);

        return view('tasks.edit', compact('project', 'task'));
    }

    public function update(UpdateTaskRequest $request, string $projectId, string $taskId)
    {
        $project = $request->user()->projects()->findOrFail($projectId);
        $project->tasks()->findOrFail($taskId)->update($request->validated());

        return redirect()->route('projects.show', $project)->with('success', 'Tâche modifiée.');
    }

    public function destroy(Request $request, string $projectId, string $taskId)
    {
        $project = $request->user()->projects()->findOrFail($projectId);
        $project->tasks()->findOrFail($taskId)->delete();

        return back()->with('success', 'Tâche supprimée.');
    }

    public function status(Request $request, string $projectId, string $taskId)
    {
        $project = $request->user()->projects()->findOrFail($projectId);
        $data = $request->validate(['status' => ['required', Rule::enum(TaskStatus::class)]]);
        $project->tasks()->findOrFail($taskId)->update($data);

        return back()->with('success', 'Statut mis à jour.');
    }
}

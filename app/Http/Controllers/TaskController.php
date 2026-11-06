<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTaskRequest;
use App\Http\Requests\UpdateTaskRequest;
use Illuminate\Http\Request;

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
}

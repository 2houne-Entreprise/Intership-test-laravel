<?php

namespace App\Http\Controllers;

use App\Enums\TaskStatus;
use App\Http\Requests\StoreTaskRequest;
use App\Http\Requests\UpdateTaskRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class TaskController extends Controller
{
    public function store(StoreTaskRequest $request, string $projectId)
    {
        $project = $request->user()->projects()->findOrFail($projectId);
        $data = $request->safe()->except('attachment');

        if ($request->hasFile('attachment')) {
            $data['attachment_path'] = Storage::disk('public')->putFile('attachments', $request->file('attachment'));
        }

        $project->tasks()->create($data);

        return back()->with('success', __('Tâche ajoutée.'));
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

        return redirect()->route('projects.show', $project)->with('success', __('Tâche modifiée.'));
    }

    public function destroy(Request $request, string $projectId, string $taskId)
    {
        $project = $request->user()->projects()->findOrFail($projectId);
        $project->tasks()->findOrFail($taskId)->delete();

        return back()->with('success', __('Tâche supprimée.'));
    }

    public function status(Request $request, string $projectId, string $taskId)
    {
        $project = $request->user()->projects()->findOrFail($projectId);
        $data = $request->validate(['status' => ['required', Rule::enum(TaskStatus::class)]]);
        $task = $project->tasks()->findOrFail($taskId);
        $task->update($data);

        if ($request->expectsJson()) {
            return response()->json(['status' => $task->status->value, 'overdue' => $task->isOverdue()]);
        }

        return back()->with('success', __('Statut mis à jour.'));
    }
}

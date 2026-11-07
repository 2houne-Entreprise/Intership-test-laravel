<?php

use App\Enums\TaskStatus;
use App\Models\Project;

test('the owner sees the kanban board', function () {
    $project = Project::factory()->create();
    $project->tasks()->create(['title' => 'Maquettes', 'status' => 'in_progress']);

    $this->actingAs($project->user)
        ->get("/projects/{$project->id}/board")
        ->assertOk()
        ->assertSee('data-column="pending"', false)
        ->assertSee('data-column="in_progress"', false)
        ->assertSee('data-column="done"', false)
        ->assertSee('Maquettes');
});

test('another user cannot open the board', function () {
    $project = Project::factory()->create();
    $other = Project::factory()->create()->user;

    $this->actingAs($other)->get("/projects/{$project->id}/board")->assertForbidden();
});

test('a task can be moved with a json request', function () {
    $project = Project::factory()->create();
    $task = $project->tasks()->create(['title' => 'En retard', 'status' => 'pending', 'deadline' => today()->subDay()]);
    $url = "/projects/{$project->id}/tasks/{$task->id}/status";

    $this->actingAs($project->user)
        ->patchJson($url, ['status' => 'done'])
        ->assertOk()
        ->assertJson(['status' => 'done', 'overdue' => false]);

    expect($task->fresh()->status)->toBe(TaskStatus::Done);

    $this->actingAs($project->user)->patchJson($url, ['status' => 'nope'])->assertUnprocessable();
});

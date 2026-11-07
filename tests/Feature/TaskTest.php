<?php

use App\Models\Project;
use App\Models\Task;

test('task title is required', function () {
    $project = Project::factory()->create();

    $this->actingAs($project->user)
        ->post("/projects/{$project->id}/tasks", ['title' => '', 'status' => 'pending'])
        ->assertSessionHasErrors('title');

    expect(Task::count())->toBe(0);
});

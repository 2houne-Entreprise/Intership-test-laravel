<?php

namespace Tests\Feature;

use App\Models\Project;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TaskTest extends TestCase
{
    use RefreshDatabase;

    public function test_task_creation_fails_without_title(): void
    {
        $user = User::factory()->create();

        $project = Project::create([
            'user_id' => $user->id,
            'name' => 'Projet de test',
        ]);

        $response = $this->actingAs($user)
            ->from(route('projects.show', $project))
            ->post(route('tasks.store', $project), [
                'title' => '',
                'status' => 'pending',
                'deadline' => null,
            ]);

        $response->assertRedirect();
        $response->assertSessionHasErrors(['title']);

        $this->assertDatabaseCount('tasks', 0);
    }
}

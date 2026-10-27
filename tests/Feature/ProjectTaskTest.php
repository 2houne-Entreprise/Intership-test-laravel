<?php

namespace Tests\Feature;

use App\Models\Project;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProjectTaskTest extends TestCase
{
    use RefreshDatabase;

    public function test_guest_is_redirected_to_login_when_accessing_projects(): void
    {
        $response = $this->get(route('projects.index'));

        $response->assertRedirect(route('login'));
    }

    public function test_authenticated_user_can_create_a_project(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->post(route('projects.store'), [
            'name' => 'Site vitrine',
            'description' => 'Refonte du site de la société.',
        ]);

        $response->assertRedirect(route('projects.index'));
        $response->assertSessionHasNoErrors();
        $this->assertDatabaseHas('projects', [
            'user_id' => $user->id,
            'name' => 'Site vitrine',
            'description' => 'Refonte du site de la société.',
        ]);
    }

    public function test_task_creation_fails_validation_when_title_is_empty(): void
    {
        $project = Project::factory()->create();

        $response = $this->actingAs($project->user)
            ->from(route('projects.show', $project))
            ->post(route('projects.tasks.store', $project), [
                'title' => '',
                'status' => 'pending',
            ]);

        $response->assertRedirect(route('projects.show', $project));
        $response->assertSessionHasErrors(['title' => 'Le titre est obligatoire.']);
        $this->assertDatabaseCount('tasks', 0);
    }

    public function test_user_cannot_update_a_project_they_do_not_own(): void
    {
        $project = Project::factory()->create(['name' => 'Original']);
        $otherUser = User::factory()->create();

        $response = $this->actingAs($otherUser)->put(route('projects.update', $project), [
            'name' => 'Piraté',
        ]);

        $response->assertForbidden();
        $this->assertDatabaseHas('projects', ['id' => $project->id, 'name' => 'Original']);
    }
}

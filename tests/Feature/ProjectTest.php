<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProjectTest extends TestCase
{
    use RefreshDatabase;

    public function test_guest_is_redirected_to_login(): void
    {
        $response = $this->get('/projects');

        $response->assertRedirect('/login');
    }

    public function test_authenticated_user_can_create_project(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->post('/projects', [
            'name' => 'Projet PHPUnit',
            'description' => 'Projet de test automatique',
        ]);

        $response->assertRedirect(route('projects.index'));

        $this->assertDatabaseHas('projects', [
            'user_id' => $user->id,
            'name' => 'Projet PHPUnit',
        ]);
    }

    public function test_user_cannot_update_another_users_project(): void
    {
        $owner = User::factory()->create();
        $otherUser = User::factory()->create();

        $project = $owner->projects()->create([
            'name' => 'Projet privé',
            'description' => 'Confidentiel',
        ]);

        $response = $this->actingAs($otherUser)
            ->put(route('projects.update', $project), [
                'name' => 'Projet piraté',
                'description' => 'Modification interdite',
            ]);

        $response->assertForbidden();

        $this->assertDatabaseHas('projects', [
            'id' => $project->id,
            'name' => 'Projet privé',
            'user_id' => $owner->id,
        ]);
    }
}

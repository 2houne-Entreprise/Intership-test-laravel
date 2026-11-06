<?php

use App\Models\User;

test('guests are redirected to login', function () {
    $this->get('/projects')->assertRedirect('/login');
});

test('a user can create a project', function () {
    $user = User::factory()->create();

    $this->actingAs($user)
        ->post('/projects', ['name' => 'Site vitrine', 'description' => 'Refonte'])
        ->assertRedirect();

    $this->assertDatabaseHas('projects', [
        'user_id' => $user->id,
        'name' => 'Site vitrine',
    ]);
});

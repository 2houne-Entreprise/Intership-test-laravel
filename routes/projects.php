<?php

use App\Http\Controllers\ProjectController;
use App\Http\Controllers\TaskController;
use App\Http\Middleware\EnsureUserOwnsProject;
use Illuminate\Support\Facades\Route;

Route::resource('projects', ProjectController::class)
    ->except(['create'])
    ->middlewareFor(['show', 'edit', 'update', 'destroy'], EnsureUserOwnsProject::class);

Route::middleware(EnsureUserOwnsProject::class)->group(function () {
    Route::resource('projects.tasks', TaskController::class)
        ->only(['store', 'edit', 'update', 'destroy']);

    Route::patch('projects/{project}/tasks/{task}/status', [TaskController::class, 'status'])
        ->name('projects.tasks.status');
});

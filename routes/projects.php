<?php

use App\Http\Controllers\ProjectController;
use App\Http\Controllers\TaskController;
use Illuminate\Support\Facades\Route;

Route::resource('projects', ProjectController::class)
    ->except(['create']);

Route::resource('projects.tasks', TaskController::class)
    ->only(['store', 'edit', 'update']);

Route::patch('projects/{project}/tasks/{task}/status', [TaskController::class, 'status'])
    ->name('projects.tasks.status');

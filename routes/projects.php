<?php

use App\Http\Controllers\ProjectController;
use App\Http\Controllers\TaskController;
use Illuminate\Support\Facades\Route;

Route::resource('projects', ProjectController::class)
    ->except(['create'])
    ->middlewareFor(['show', 'edit', 'update', 'destroy'], 'project.owner');

Route::scopeBindings()->group(function () {
    Route::resource('projects.tasks', TaskController::class)
        ->only(['store', 'edit', 'update', 'destroy'])
        ->middleware('project.owner');
});

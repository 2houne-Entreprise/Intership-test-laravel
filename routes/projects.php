
<?php

use App\Http\Controllers\ProjectController;
use App\Http\Controllers\TaskController;
use Illuminate\Support\Facades\Route;

Route::middleware('auth')->group(function () {
    Route::resource('projects', ProjectController::class)
        ->except(['update', 'destroy']);
    Route::middleware('owns.project')->group(function () {
        Route::put(
            '/projects/{project}/tasks/{task}',
            [TaskController::class, 'update']
        )->name('tasks.update');

        Route::delete(
            '/projects/{project}/tasks/{task}',
            [TaskController::class, 'destroy']
        )->name('tasks.destroy');

        Route::post(
            '/projects/{project}/tasks',
            [TaskController::class, 'store']
        )->name('tasks.store');
    });
});

Route::middleware(['auth', 'owns.project'])->group(function () {
    Route::put(
        '/projects/{project}',
        [ProjectController::class, 'update']
    )->name('projects.update');

    Route::delete(
        '/projects/{project}',
        [ProjectController::class, 'destroy']
    )->name('projects.destroy');
});

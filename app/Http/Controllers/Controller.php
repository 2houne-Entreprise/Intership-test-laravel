<?php

namespace App\Http\Controllers;

use App\Models\Project;
use Illuminate\Http\Request;

abstract class Controller
{
    /**
     * Abort with a 403 when the project does not belong to the authenticated user.
     */
    protected function ensureOwnership(Request $request, Project $project): void
    {
        abort_unless($project->user()->is($request->user()), 403);
    }
}

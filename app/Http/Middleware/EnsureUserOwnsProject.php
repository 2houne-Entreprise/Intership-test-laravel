<?php

namespace App\Http\Middleware;

use App\Models\Project;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureUserOwnsProject
{
    /**
     * Abort with a 403 when the {project} route parameter does not belong to the authenticated user.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $project = $request->route('project');

        if (! $project instanceof Project) {
            $project = Project::findOrFail($project);
        }

        abort_unless($project->user()->is($request->user()), 403);

        return $next($request);
    }
}

<?php

namespace App\Http\Middleware;

use App\Models\Project;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureUserOwnsProject
{
    public function handle(Request $request, Closure $next): Response
    {
        $project = $request->route('project');

        if ($project instanceof Project) {
            $projectId = $project->id;
        } else {
            $projectId = $project;
        }

        abort_unless(
            $request->user() &&
            Project::where('id', $projectId)
                ->where('user_id', $request->user()->id)
                ->exists(),
            403
        );

        return $next($request);
    }
}

<?php

namespace App\Http\Middleware;

use App\Models\Project;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureUserOwnsProject
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $project = Project::findOrFail($request->route('project'));

        if ($project->user_id !== $request->user()->id) {
            abort(403);
        }

        return $next($request);
    }
}

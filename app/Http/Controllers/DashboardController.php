<?php

namespace App\Http\Controllers;

use App\Enums\TaskStatus;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function __invoke(Request $request)
    {
        $user = $request->user();

        $statusCounts = $user->tasks()
            ->selectRaw('status, count(*) as total')
            ->groupBy('status')
            ->pluck('total', 'status');

        $projects = $user->projects()
            ->withCount(['tasks', 'tasks as done_count' => fn ($query) => $query->where('status', TaskStatus::Done)])
            ->latest()
            ->take(5)
            ->get();

        $overdueTasks = $user->tasks()->overdue()->with('project')->orderBy('deadline')->take(5)->get();

        return view('dashboard', [
            'statusCounts' => $statusCounts,
            'totalTasks' => $statusCounts->sum(),
            'projectsCount' => $user->projects()->count(),
            'overdueCount' => $user->tasks()->overdue()->count(),
            'projects' => $projects,
            'overdueTasks' => $overdueTasks,
        ]);
    }
}

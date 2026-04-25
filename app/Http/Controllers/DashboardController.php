<?php

namespace App\Http\Controllers;

use App\Models\Goal;
use App\Models\Task;

class DashboardController extends Controller
{
    public function index()
    {
        $userId = auth()->id();

        $goals = Goal::where('user_id', $userId)->get();

        $stats = [
            'total_goals' => $goals->count(),
            'completed_goals' => $goals->where('status', 'completed')->count(),
            'in_progress' => $goals->where('status', 'in_progress')->count(),
            'not_started' => $goals->where('status', 'not_started')->count(),
            'avg_progress' => $goals->count() > 0
                ? (int) round($goals->avg('progress'))
                : 0,
            'total_tasks' => Task::whereHas('step.goal', fn($q) =>
                $q->where('user_id', $userId))->count(),
            'completed_tasks' => Task::whereHas('step.goal', fn($q) =>
                $q->where('user_id', $userId))
                ->where('status', 'completed')->count(),
            'overdue_goals' => $goals->filter(fn($g) => $g->isOverdue())->count(),
        ];

        $pinnedGoals = Goal::where('user_id', $userId)
            ->where('is_pinned', true)
            ->with('steps')
            ->orderBy('created_at', 'desc')
            ->get();

        $recentGoals = Goal::where('user_id', $userId)
            ->with('steps')
            ->orderBy('updated_at', 'desc')
            ->limit(4)
            ->get();

        $upcomingDeadlines = Goal::where('user_id', $userId)
            ->whereNotNull('target_date')
            ->where('target_date', '>=', now())
            ->where('status', '!=', 'completed')
            ->orderBy('target_date')
            ->limit(3)
            ->get();

        return view('dashboard', compact(
            'stats',
            'pinnedGoals',
            'recentGoals',
            'upcomingDeadlines'
        ));
    }
}
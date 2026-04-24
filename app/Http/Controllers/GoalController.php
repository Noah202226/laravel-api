<?php

namespace App\Http\Controllers;

use App\Models\Goal;
use Illuminate\Http\Request;

class GoalController extends Controller
{
    public function index()
    {
        $pinnedGoals = Goal::where('is_pinned', true)
            ->orderBy('created_at', 'desc')
            ->get();

        $recentGoals = Goal::orderBy('created_at', 'desc')
            ->limit(6)
            ->get();

        return view('welcome', [
            'pinnedGoals' => $pinnedGoals,
            'recentGoals' => $recentGoals,
        ]);
    }

    public function goals()
    {
        $goals = Goal::orderByDesc('is_pinned')
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('goals.index', ['goals' => $goals]);
    }

    public function goal($id)
    {
        // Eager load steps → tasks → subtasks in one query
        $goal = Goal::with(['steps.tasks.subtasks'])->findOrFail($id);

        return view('goals.goal', ['goal' => $goal]);
    }

    public function create()
    {
        return view('goals.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'category' => 'nullable|string|max:100',
            'priority' => 'nullable|in:low,medium,high',
            'cover_emoji' => 'nullable|string|max:5',
            'cover_color' => 'nullable|string|max:7',
            'start_date' => 'nullable|date',
            'target_date' => 'nullable|date|after_or_equal:start_date',
            'is_pinned' => 'boolean',
            'purpose' => 'nullable|string',
            'goal_for' => 'nullable|string|max:255',
            'dream_outcome' => 'nullable|string',
            'fear_of_not_doing' => 'nullable|string',
            'motivation_quote' => 'nullable|string|max:255',
            'reward' => 'nullable|string|max:255',
            'reward_type' => 'nullable|in:experience,item,rest,treat',
        ]);

        $validated['is_pinned'] = $request->boolean('is_pinned');
        $validated['status'] = 'not_started';
        $validated['progress'] = 0;

        // Temporary: replace with auth()->id() when you add authentication
        $validated['user_id'] = \App\Models\User::first()->id;

        $goal = Goal::create($validated);

        return redirect()
            ->route('goals.goal', $goal->id)
            ->with('success', 'Goal created! Now add some steps to get started.');
    }
}
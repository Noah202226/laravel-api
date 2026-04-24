<?php

namespace App\Http\Controllers;

use App\Models\Step;
use App\Models\Task;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    public function store(Request $request, Step $step)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'notes' => 'nullable|string',
            'priority' => 'nullable|in:low,medium,high',
            'target_date' => 'nullable|date',
        ]);

        $nextOrder = $step->tasks()->max('order') + 1;

        $step->tasks()->create([
            ...$validated,
            'order' => $nextOrder,
            'status' => 'not_started',
            'priority' => $validated['priority'] ?? 'medium',
        ]);

        $step->recomputeProgress();

        return back()->with('success', 'Task added!');
    }

    public function toggle(Task $task)
    {
        $isCompleted = $task->status === 'completed';

        $task->update([
            'status' => $isCompleted ? 'not_started' : 'completed',
            'progress' => $isCompleted ? 0 : 100,
            'completed_at' => $isCompleted ? null : now(),
        ]);

        $task->step->recomputeProgress();

        return back();
    }

    public function destroy(Task $task)
    {
        $step = $task->step;
        $task->delete();
        $step->recomputeProgress();

        return back()->with('success', 'Task removed.');
    }
}
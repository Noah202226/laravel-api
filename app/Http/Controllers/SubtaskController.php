<?php

namespace App\Http\Controllers;

use App\Models\Subtask;
use App\Models\Task;
use Illuminate\Http\Request;

class SubtaskController extends Controller
{
    public function store(Request $request, Task $task)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
        ]);

        $nextOrder = $task->subtasks()->max('order') + 1;

        $task->subtasks()->create([
            ...$validated,
            'order' => $nextOrder,
            'is_completed' => false,
        ]);

        $task->recomputeProgress();

        return back()->with('success', 'Subtask added!');
    }

    public function toggle(Subtask $subtask)
    {
        $subtask->toggle();

        return back();
    }

    public function destroy(Subtask $subtask)
    {
        $task = $subtask->task;
        $subtask->delete();
        $task->recomputeProgress();

        return back()->with('success', 'Subtask removed.');
    }
}
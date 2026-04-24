<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    public function toggle(Task $task)
    {
        $isCompleted = $task->status === 'completed';

        $task->update([
            'status' => $isCompleted ? 'not_started' : 'completed',
            'progress' => $isCompleted ? 0 : 100,
            'completed_at' => $isCompleted ? null : now(),
        ]);

        // Bubble progress up: task → step → goal
        $task->step->recomputeProgress();

        return back();
    }
}
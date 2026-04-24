<?php

namespace App\Http\Controllers;

use App\Models\Subtask;

class SubtaskController extends Controller
{
    public function toggle(Subtask $subtask)
    {
        // Uses the toggle() method we already defined on the Subtask model
        // which flips is_completed and bubbles up to task → step → goal
        $subtask->toggle();

        return back();
    }
}
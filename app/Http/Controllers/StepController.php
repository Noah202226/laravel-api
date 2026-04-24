<?php

namespace App\Http\Controllers;

use App\Models\Goal;
use App\Models\Step;
use Illuminate\Http\Request;

class StepController extends Controller
{
    public function store(Request $request, Goal $goal)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'target_date' => 'nullable|date',
        ]);

        $nextOrder = $goal->steps()->max('order') + 1;

        $goal->steps()->create([
            ...$validated,
            'order' => $nextOrder,
            'status' => 'not_started',
        ]);

        return back()->with('success', 'Step added!');
    }

    public function destroy(Step $step)
    {
        $goal = $step->goal;
        $step->delete();
        $goal->recomputeProgress();

        return back()->with('success', 'Step removed.');
    }
}
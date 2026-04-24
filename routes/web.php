<?php

use App\Http\Controllers\GoalController;
use App\Http\Controllers\SubtaskController;
use App\Http\Controllers\TaskController;
use Illuminate\Support\Facades\Route;

Route::get('/api/health-check', function () {
    try {
        return response()->json([
            'status' => 'online',
            'server_time' => now()->toDateTimeString(),
            'message' => 'The server is healthy and connected to the database.',
        ]);
    } catch (\Exception $e) {
        return response()->json(['status' => 'error', 'message' => $e->getMessage()], 500);
    }
});

Route::get('/', [GoalController::class, 'index'])->name('goals.index');

Route::get('/goals', [GoalController::class, 'goals'])->name('goals.goals');
Route::get('/goals/create', [GoalController::class, 'create'])->name('goals.create');
Route::post('/goals', [GoalController::class, 'store'])->name('goals.store');
Route::get('/goals/{id}', [GoalController::class, 'goal'])->name('goals.goal');

// Task toggle
Route::patch('/tasks/{task}/toggle', [TaskController::class, 'toggle'])->name('tasks.toggle');

// Subtask toggle
Route::patch('/subtasks/{subtask}/toggle', [SubtaskController::class, 'toggle'])->name('subtasks.toggle');
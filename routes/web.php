<?php

use App\Http\Controllers\GoalController;
use App\Http\Controllers\StepController;
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

// Goals — CRUD
Route::get('/goals', [GoalController::class, 'goals'])->name('goals.goals');
Route::get('/goals/create', [GoalController::class, 'create'])->name('goals.create');
Route::post('/goals', [GoalController::class, 'store'])->name('goals.store');
Route::get('/goals/{id}', [GoalController::class, 'goal'])->name('goals.goal');
Route::get('/goals/{id}/edit', [GoalController::class, 'edit'])->name('goals.edit');
Route::put('/goals/{id}', [GoalController::class, 'update'])->name('goals.update');
Route::delete('/goals/{id}', [GoalController::class, 'destroy'])->name('goals.destroy');

// Steps
Route::post('/goals/{goal}/steps', [StepController::class, 'store'])->name('steps.store');
Route::delete('/steps/{step}', [StepController::class, 'destroy'])->name('steps.destroy');

// Tasks
Route::post('/steps/{step}/tasks', [TaskController::class, 'store'])->name('tasks.store');
Route::patch('/tasks/{task}/toggle', [TaskController::class, 'toggle'])->name('tasks.toggle');
Route::delete('/tasks/{task}', [TaskController::class, 'destroy'])->name('tasks.destroy');

// Subtasks
Route::post('/tasks/{task}/subtasks', [SubtaskController::class, 'store'])->name('subtasks.store');
Route::patch('/subtasks/{subtask}/toggle', [SubtaskController::class, 'toggle'])->name('subtasks.toggle');
Route::delete('/subtasks/{subtask}', [SubtaskController::class, 'destroy'])->name('subtasks.destroy');
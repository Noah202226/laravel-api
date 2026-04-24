<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Illuminate\Database\Eloquent\SoftDeletes;

class Goal extends Model
{
    use HasFactory, HasUuids, SoftDeletes;

    protected $fillable = [
        'user_id',

        // Core
        'title',
        'description',
        'category',

        // Motivation
        'purpose',
        'goal_for',
        'dream_outcome',
        'fear_of_not_doing',
        'motivation_quote',

        // Reward
        'reward',
        'reward_type',
        'reward_claimed',

        // Progress & Status
        'status',
        'progress',
        'priority',
        'is_pinned',
        'is_public',

        // Cover / Mood
        'cover_emoji',
        'cover_color',

        // Dates
        'start_date',
        'target_date',
        'completed_at',
    ];

    protected $casts = [
        'reward_claimed' => 'boolean',
        'is_pinned' => 'boolean',
        'is_public' => 'boolean',
        'start_date' => 'date',
        'target_date' => 'date',
        'completed_at' => 'datetime',
        'progress' => 'integer',
    ];

    // ── Relationships ──────────────────────────────────────────

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function steps(): HasMany
    {
        return $this->hasMany(Step::class)->orderBy('order');
    }

    public function tasks(): HasManyThrough
    {
        return $this->hasManyThrough(Task::class, Step::class);
    }

    // ── Progress Computation ───────────────────────────────────

    /**
     * Recompute progress (0–100) based on completed steps.
     * Call this whenever a step status changes.
     */
    public function recomputeProgress(): void
    {
        $steps = $this->steps()->withCount([
            'tasks',
            'tasks as completed_tasks_count' => fn($q) => $q->where('status', 'completed'),
        ])->get();

        if ($steps->isEmpty()) {
            $this->progress = 0;
        } else {
            $total = $steps->sum('tasks_count');
            $completed = $steps->sum('completed_tasks_count');
            $this->progress = $total > 0 ? (int) round(($completed / $total) * 100) : 0;
        }

        // Auto-mark completed
        if ($this->progress === 100) {
            $this->status = 'completed';
            $this->completed_at = now();
        }

        $this->save();
    }

    // ── Helpers ────────────────────────────────────────────────

    public function isCompleted(): bool
    {
        return $this->status === 'completed';
    }

    public function isOverdue(): bool
    {
        return $this->target_date
            && $this->target_date->isPast()
            && !$this->isCompleted();
    }

    public function claimReward(): void
    {
        if ($this->isCompleted() && !$this->reward_claimed) {
            $this->update(['reward_claimed' => true]);
        }
    }
}
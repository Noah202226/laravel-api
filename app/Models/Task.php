<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Task extends Model
{
    use HasFactory, HasUuids, SoftDeletes;

    protected $fillable = [
        'step_id',
        'title',
        'notes',
        'order',
        'status',
        'priority',
        'progress',
        'target_date',
        'completed_at',
    ];

    protected $casts = [
        'target_date' => 'date',
        'completed_at' => 'datetime',
        'progress' => 'integer',
    ];

    public function step(): BelongsTo
    {
        return $this->belongsTo(Step::class);
    }

    public function subtasks(): HasMany
    {
        return $this->hasMany(Subtask::class)->orderBy('order');
    }

    public function hasSubtasks(): bool
    {
        return $this->subtasks()->exists();
    }

    public function markComplete(): void
    {
        $this->update([
            'status' => 'completed',
            'progress' => 100,
            'completed_at' => now(),
        ]);

        $this->step->recomputeProgress();
    }

    public function recomputeProgress(): void
    {
        if (!$this->hasSubtasks()) {
            return;
        }

        $total = $this->subtasks()->count();
        $completed = $this->subtasks()->where('is_completed', true)->count();
        $progress = $total > 0 ? (int) round(($completed / $total) * 100) : 0;

        $this->update([
            'progress' => $progress,
            'status' => $progress === 100 ? 'completed' : ($progress > 0 ? 'in_progress' : 'not_started'),
            'completed_at' => $progress === 100 ? now() : null,
        ]);

        $this->step->recomputeProgress();
    }
}
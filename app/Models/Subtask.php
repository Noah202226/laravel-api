<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Subtask extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = [
        'task_id',
        'title',
        'is_completed',
        'order',
        'completed_at',
    ];

    protected $casts = [
        'is_completed' => 'boolean',
        'completed_at' => 'datetime',
    ];

    public function task(): BelongsTo
    {
        return $this->belongsTo(Task::class);
    }

    public function toggle(): void
    {
        $this->update([
            'is_completed' => !$this->is_completed,
            'completed_at' => !$this->is_completed ? now() : null,
        ]);

        $this->task->recomputeProgress();
    }
}
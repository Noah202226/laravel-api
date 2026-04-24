<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Step extends Model
{
    use HasFactory, HasUuids, SoftDeletes;

    protected $fillable = [
        'goal_id',
        'title',
        'description',
        'order',
        'status',
        'progress',
        'start_date',
        'target_date',
        'completed_at',
    ];

    protected $casts = [
        'start_date' => 'date',
        'target_date' => 'date',
        'completed_at' => 'datetime',
        'progress' => 'integer',
    ];

    public function goal(): BelongsTo
    {
        return $this->belongsTo(Goal::class);
    }

    public function tasks(): HasMany
    {
        return $this->hasMany(Task::class)->orderBy('order');
    }

    public function recomputeProgress(): void
    {
        $total = $this->tasks()->count();
        $completed = $this->tasks()->where('status', 'completed')->count();
        $progress = $total > 0 ? (int) round(($completed / $total) * 100) : 0;

        $this->update([
            'progress' => $progress,
            'status' => $progress === 100 ? 'completed' : ($progress > 0 ? 'in_progress' : $this->status),
            'completed_at' => $progress === 100 ? now() : null,
        ]);

        $this->goal->recomputeProgress();
    }
}
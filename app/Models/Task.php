<?php

namespace App\Models;

use App\Enums\TaskStatus;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Storage;

#[Fillable(['title', 'status', 'deadline', 'attachment_path'])]
class Task extends Model
{
    protected static function booted(): void
    {
        static::deleted(function (Task $task) {
            if ($task->attachment_path) {
                Storage::disk('public')->delete($task->attachment_path);
            }
        });
    }

    protected function casts(): array
    {
        return [
            'status' => TaskStatus::class,
            'deadline' => 'date',
        ];
    }

    public function project(): BelongsTo
    {
        return $this->belongsTo(Project::class);
    }

    public function scopeOverdue(Builder $query): void
    {
        $query->whereDate('deadline', '<', today())
            ->where('status', '!=', TaskStatus::Done);
    }

    public function getStatusLabelAttribute(): string
    {
        return $this->status->label();
    }

    public function isOverdue(): bool
    {
        return $this->deadline?->lt(today()) && $this->status !== TaskStatus::Done;
    }
}

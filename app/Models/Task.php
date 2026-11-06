<?php

namespace App\Models;

use App\Enums\TaskStatus;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[Fillable(['title', 'status', 'deadline'])]
class Task extends Model
{
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

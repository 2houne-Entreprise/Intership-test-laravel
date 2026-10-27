<?php

namespace App\Models;

use App\TaskStatus;
use Database\Factories\TaskFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[Fillable(['title', 'status', 'deadline', 'attachment_path'])]
class Task extends Model
{
    /** @use HasFactory<TaskFactory> */
    use HasFactory;

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'status' => TaskStatus::class,
            'deadline' => 'date',
        ];
    }

    /**
     * Get the project the task belongs to.
     */
    public function project(): BelongsTo
    {
        return $this->belongsTo(Project::class);
    }

    /**
     * Scope a query to tasks whose deadline has passed and that are not done.
     */
    public function scopeOverdue(Builder $query): void
    {
        $query->whereDate('deadline', '<', today())
            ->where('status', '!=', TaskStatus::Done);
    }

    /**
     * Get the status label in French (e.g. "En attente").
     */
    public function getStatusLabelAttribute(): string
    {
        return $this->status->label();
    }

    /**
     * Get the public URL of the attachment (served through the storage:link symlink).
     */
    public function getAttachmentUrlAttribute(): ?string
    {
        return $this->attachment_path ? asset('storage/'.$this->attachment_path) : null;
    }
}

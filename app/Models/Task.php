<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Task extends Model
{
    protected $fillable = [
        'project_id',
        'title',
        'status',
        'deadline',
        'attachment_path',
    ];

    protected function casts(): array
    {
        return [
            'deadline' => 'date',
        ];
    }

    public function project(): BelongsTo
    {
        return $this->belongsTo(Project::class);
    }

    public function scopeOverdue($query)
    {
        return $query->where('deadline', '<', today())
            ->where('status', '!=', 'done');
    }

    public function getStatusLabelAttribute(): string
    {
        return match ($this->status) {
            'pending' => 'En attente',
            'in_progress' => 'En cours',
            'done' => 'Terminée',
            default => 'Inconnu',
        };
    }
}

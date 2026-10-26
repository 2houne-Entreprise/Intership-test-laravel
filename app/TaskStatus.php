<?php

namespace App;

enum TaskStatus: string
{
    case Pending = 'pending';
    case InProgress = 'in_progress';
    case Done = 'done';

    /**
     * Get the French label displayed to users.
     */
    public function label(): string
    {
        return match ($this) {
            self::Pending => 'En attente',
            self::InProgress => 'En cours',
            self::Done => 'Terminée',
        };
    }
}

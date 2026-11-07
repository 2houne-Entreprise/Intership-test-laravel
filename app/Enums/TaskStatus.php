<?php

namespace App\Enums;

enum TaskStatus: string
{
    case Pending = 'pending';
    case InProgress = 'in_progress';
    case Done = 'done';

    public function label(): string
    {
        return match ($this) {
            self::Pending => __('En attente'),
            self::InProgress => __('En cours'),
            self::Done => __('Terminée'),
        };
    }
}

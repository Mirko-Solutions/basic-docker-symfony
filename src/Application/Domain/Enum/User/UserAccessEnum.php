<?php

namespace App\Domain\Enum\User;

enum UserAccessEnum: string
{
    case READ = 'READ';
    case CREATE = 'CREATE';
    case EDIT = 'EDIT';
    case DELETE = 'DELETE';
    case LIST = 'LIST';

    public static function getAllValues(): array
    {
        return array_column(self::cases(), 'name');
    }
}

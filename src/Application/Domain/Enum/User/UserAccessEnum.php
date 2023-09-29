<?php

namespace App\Domain\Enum\User;

enum UserAccessEnum
{
    case READ;
    case CREATE;
    case EDIT;
    case DELETE;
    case LIST;

    public static function getAllValues(): array
    {
        return array_column(self::cases(), 'name');
    }
}

<?php

namespace App\Domain\Enum\User;

enum GdprTypeEnum: string
{
    case PRIVACY_POLICY = 'PRIVACY_POLICY';
    case TERMS_OF_USE = 'TERMS_OF_USE';

    public static function getAllValues(): array
    {
        return array_column(self::cases(), 'name');
    }
}

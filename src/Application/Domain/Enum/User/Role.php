<?php

namespace App\Domain\Enum\User;

enum Role: string
{
    case ROLE_USER = 'ROLE_USER';
    case ROLE_ADMIN = 'ROLE_ADMIN';
}

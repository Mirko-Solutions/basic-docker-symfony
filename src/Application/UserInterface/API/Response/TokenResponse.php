<?php

namespace App\UserInfrastructure\API\Response;

use App\Infrastructure\Response\Response;

class TokenResponse extends Response
{
    public function getType(mixed $object) : string {
        return 'token';
    }

    public function render(mixed $object): array
    {
        return [
            'token' => $object
        ];
    }
}

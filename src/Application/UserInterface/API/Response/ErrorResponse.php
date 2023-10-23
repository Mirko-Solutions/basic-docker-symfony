<?php

namespace App\UserInfrastructure\API\Response;

use App\Infrastructure\Response\Response;

class ErrorResponse extends Response
{
    public function getType(mixed $object) : string {
        return 'error';
    }

    public function render(mixed $object): array
    {
        return [
            'message' => $object
        ];
    }
}

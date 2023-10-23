<?php

namespace App\UserInfrastructure\API\Response;

use App\Infrastructure\Response\Response;

class SuccessResponse extends Response
{
    public function getType(mixed $object) : string {
        return 'message';
    }

    public function render(mixed $object): array
    {
        return [
            'message' => $object
        ];
    }
}

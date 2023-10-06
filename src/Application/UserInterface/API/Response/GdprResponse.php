<?php

namespace App\UserInfrastructure\API\Response;

use App\Infrastructure\Response\Response;

/**
 * @author Bohdan Sinchuk <bohdan.sinchuk@mirko.in.ua>
 */
class GdprResponse extends Response
{
    public function getType(mixed $object) : string {
        return 'GDPR';
    }
    public function render(mixed $object): array
    {
        return $object;
    }
}

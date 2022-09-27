<?php

namespace App\UserInfrastructure\API\Response;

use App\Infrastructure\Response\Response;

/**
 * @author Mykhailo YATSYSHYN <mykhailo.yatsyshyn@mirko.in.ua>
 */
class ArrayResponse extends Response
{
    public function render(mixed $object): array
    {
        return $object;
    }
}

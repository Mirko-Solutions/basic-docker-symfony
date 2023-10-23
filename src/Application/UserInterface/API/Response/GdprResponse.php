<?php

namespace App\UserInfrastructure\API\Response;

use App\Domain\Entity\User\UserGdprPolicy;
use App\Infrastructure\Response\DateFormatInterface;
use App\Infrastructure\Response\Response;

/**
 * @author Bohdan Sinchuk <bohdan.sinchuk@mirko.in.ua>
 */
class GdprResponse extends Response
{
    public function getType(mixed $object) : string {
        return 'GDPR';
    }
    /**
     * @param UserGdprPolicy $object
     * @return array
     */
    public function render(mixed $object): array
    {
        return [
            'id' => $object->getId(),
            'type' => $object->getType(),
            'accepted_at' => $object->getCreatedAt()->format(DateFormatInterface::DATEFORMAT),
            ];
    }
}

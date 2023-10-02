<?php

namespace App\UserInfrastructure\API\Response;

use App\Domain\Entity\User\User;
use App\Infrastructure\Response\Response;

class UserResponse extends Response
{
    public function getType(mixed $object) : string {
        return 'user';
    }

    /**
     * @param User $object
     * @return array
     */
    public function render(mixed $object): array
    {
        return [
            'id' => $object->getId(),
            'email' => $object->getUserIdentifier(),
            'first_name' => $object->getFirstName(),
            'last_name' => $object->getLastName(),
            'roles' => $object->getRoles(),
            'created_at' => $object->getCreatedAt()->format('Y-m-d H:i:s'),
            'deleted_at' => $object->getDeletedAt()?->format('Y-m-d H:i:s')

        ];
    }
}

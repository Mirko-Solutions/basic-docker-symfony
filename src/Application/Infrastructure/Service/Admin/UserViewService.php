<?php

namespace App\Infrastructure\Service\Admin;

use App\Domain\Entity\User\User;
use App\Domain\ValueObject\Email;
use App\Infrastructure\Repository\User\UserRepository;

/**
 * @author Bohdan Sinchuk <bohdan.sinchuk@mirko.in.ua>
 */
class UserViewService
{
    private UserRepository $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function getById(int $id): array
    {
        return $this->userRepository->findById($id);
    }
}
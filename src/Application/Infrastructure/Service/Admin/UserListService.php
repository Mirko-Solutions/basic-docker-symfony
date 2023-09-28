<?php

namespace App\Infrastructure\Service\Admin;

use App\Domain\Entity\User\User;
use App\Domain\Entity\User\UserCollection;
use App\Infrastructure\Repository\User\UserRepository;

/**
 * @author Bohdan Sinchuk <bohdan.sinchuk@mirko.in.ua>
 */
class UserListService
{
    private UserRepository $userRepository;
    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function findAll(): array
    {
        return $this->userRepository->getAll();
    }
}
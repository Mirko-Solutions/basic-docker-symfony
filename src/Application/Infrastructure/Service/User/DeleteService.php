<?php

namespace App\Infrastructure\Service\User;

use App\Domain\Entity\User\User;
use App\Domain\ValueObject\Email;
use App\Infrastructure\Repository\User\UserRepository;

/**
 * @author Bohdan Sinchuk <bohdan.sinchuk@mirko.in.ua>
 */
class DeleteService
{
    private UserRepository $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function softDelete(User $user): void
    {
        $this->userRepository->softDelete($user);
    }
}
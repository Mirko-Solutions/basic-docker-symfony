<?php

namespace App\Infrastructure\Service\User;

use App\Domain\Entity\User\User;
use App\Domain\ValueObject\Email;
use App\Infrastructure\Exception\BadRequestException;
use App\Infrastructure\Repository\User\UserRepository;

/**
 * @author Bohdan Sinchuk <bohdan.sinchuk@mirko.in.ua>
 */
class UserService
{
    private UserRepository $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function findByEmail(Email $email): User|null
    {
        return $this->userRepository->findByEmail($email);
    }

    public function findByRecoveryToken(string $token): User|null
    {
        return $this->userRepository->findByRecoveryToken($token);
    }
}

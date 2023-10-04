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

    public function checkEmail(Email $email): User|null
    {
        $userByEmail = $this->userRepository->findByEmail($email);
        if ($userByEmail) {
            throw new BadRequestException("User with email {$email} already exists");
        }
        return $userByEmail;
    }

    public function findByEmail(Email $email): User|null
    {
        return $this->userRepository->findByEmail($email);
    }

    public function getById(int $id): array
    {
        return $this->userRepository->findById($id);
    }

    public function findByRecoveryToken(string $token): User|null
    {
        return $this->userRepository->findByRecoveryToken($token);
    }
}

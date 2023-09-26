<?php

namespace App\Infrastructure\Service\User;

use App\Domain\Entity\User\User;
use App\Infrastructure\Repository\User\UserRepository;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

/**
 * @author Bohdan Sinchuk <bohdan.sinchuk@mirko.in.ua>
 */
class UpdateService
{
    private UserRepository $userRepository;
    private UserPasswordHasherInterface $hasher;

    public function __construct(UserRepository $userRepository, UserPasswordHasherInterface $hasher)
    {
        $this->userRepository = $userRepository;
        $this->hasher = $hasher;
    }

    public function update(User $user): User
    {
        $this->userRepository->add($user, true);

        return $user;
    }

    public function updatePassword(User $user, string $plainPassword): User
    {
        $password = $this->hasher->hashPassword($user, $plainPassword);
        $user->setRecoveryToken(null);
        $user->setPassword($password);
        $this->userRepository->add($user, true);

        return $user;
    }
}

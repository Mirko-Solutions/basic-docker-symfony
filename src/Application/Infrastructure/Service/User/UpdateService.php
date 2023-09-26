<?php

namespace App\Infrastructure\Service\User;

use App\Domain\Entity\User\User;
use App\Domain\ValueObject\Email;
use App\Infrastructure\Exception\BadRequestException;
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
        $user->setUpdatedAt();
        $this->userRepository->add($user, true);

        return $user;
    }

    public function updateProfile(User $user, array $data): User
    {
        if ( !password_verify($data['old_password'],$user->getPassword())) {
            throw new BadRequestException('Something was wrong');
        }
        $password = $this->hasher->hashPassword($user, $data['password']);

        $checkUser = $this->userRepository->findByEmailExlUserId(new Email($data['email']),$user->getId());

        if ($checkUser){
            throw new BadRequestException('Email is already exists');
        }
        $user->setEmail($data['email']);
        $user->setFirstName($data['first_name']);
        $user->setLastName($data['last_name']);
        $user->setPassword($password);
        $user->setUpdatedAt();
        $this->userRepository->add($user, true);

        return $user;
    }

    public function updatePassword(User $user, string $plainPassword): User
    {
        $password = $this->hasher->hashPassword($user, $plainPassword);
        $user->setRecoveryToken(null);
        $user->setPassword($password);
        $user->setUpdatedAt();
        $this->userRepository->add($user, true);

        return $user;
    }
}

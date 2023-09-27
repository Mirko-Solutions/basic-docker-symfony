<?php

namespace App\Infrastructure\Service\User;

use App\Domain\DTO\User\UserDTO;
use App\Domain\Entity\User\User;
use App\Domain\ValueObject\Email;
use App\Infrastructure\Exception\BadRequestException;
use App\Infrastructure\Repository\User\UserRepository;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
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

    public function updateProfile(User $user, UserDTO $userDTO, string $old_password): User
    {
        if ( !password_verify($old_password,$user->getPassword())) {
            throw new NotFoundHttpException('Something was wrong');
        }
        $password = $this->hasher->hashPassword($user, $userDTO->getPlainPassword());

        $checkUser = $this->userRepository->findByEmailExlUserId($userDTO->getEmail(),$user->getId());

        if ($checkUser){
            throw new BadRequestException('Email is already exists');
        }
        $user->setEmail($userDTO->getEmail());
        $user->setFirstName($userDTO->getFirstName());
        $user->setLastName($userDTO->getLastName());
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

<?php

namespace App\Infrastructure\Service\Admin;

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
class UserEditService
{
    private UserRepository $userRepository;
    private UserPasswordHasherInterface $hasher;

    public function __construct(UserRepository $userRepository, UserPasswordHasherInterface $hasher)
    {
        $this->userRepository = $userRepository;
        $this->hasher = $hasher;
    }

    public function edit(User $user, UserDTO $userDTO) : User
    {
        $checkUser = $this->userRepository->findByEmailExlUserId($userDTO->getEmail(),$user->getId());

        if ($checkUser){
            throw new NotFoundHttpException("User with email {$userDTO->getEmail()} already exist");
        }

        $password = $this->hasher->hashPassword($user, $userDTO->getPassword());
        $user->setEmail($userDTO->getEmail());
        $user->setFirstName($userDTO->getFirstName());
        $user->setLastName($userDTO->getLastName());
        $user->setPassword($password);
        $user->setUpdatedAt();

        $this->userRepository->add($user, true);

        return $user;
    }
}
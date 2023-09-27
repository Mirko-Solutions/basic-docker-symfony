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
 * @author Mykhailo YATSYSHYN <mykhailo.yatsyshyn@mirko.in.ua>
 */
class CreateService
{
    private UserRepository $userRepository;
    private UserPasswordHasherInterface $hasher;

    public function __construct(UserRepository $userRepository, UserPasswordHasherInterface $hasher)
    {
        $this->userRepository = $userRepository;
        $this->hasher = $hasher;
    }

    public function create(UserDTO $userDTO) : User
    {
        $userByEmail = $this->userRepository->findByEmail($userDTO->getEmail());
        if($userByEmail) {
            throw new NotFoundHttpException("User with email {$userDTO->getEmail()} already exist");
        }

        $user = User::create($userDTO);
        $password = $this->hasher->hashPassword($user, $userDTO->getPlainPassword());
        $user->setPassword($password);

        $this->userRepository->add($user, true);

        return $user;
    }
}

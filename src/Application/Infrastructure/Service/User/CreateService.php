<?php

namespace App\Infrastructure\Service\User;

use App\Domain\Entity\User\User;
use App\Domain\ValueObject\Email;
use App\Infrastructure\Exception\BadRequestException;
use App\Infrastructure\Repository\User\UserRepository;
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

    public function create(Email $email, string $plainPassword) : User
    {
        $userByEmail = $this->userRepository->findByEmail($email);
        if($userByEmail) {
            throw new BadRequestException("User with email {$email} already exist");
        }

        $user = User::create($email);
        $password = $this->hasher->hashPassword($user, $plainPassword);
        $user->setPassword($password);

        $this->userRepository->add($user, true);

        return $user;
    }
}

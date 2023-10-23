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
    private UserService $userService;

    public function __construct(UserRepository $userRepository, UserPasswordHasherInterface $hasher, UserService $userService)
    {
        $this->userRepository = $userRepository;
        $this->hasher = $hasher;
        $this->userService = $userService;
    }

    public function create(UserDTO $userDTO) : User
    {
        try {
            $this->userService->checkEmail($userDTO->getEmail());
            $user = User::create($userDTO->getFirstName(),
                $userDTO->getLastName(),
                $userDTO->getEmail(),
                $userDTO->getPassword());
            $password = $this->hasher->hashPassword($user, $userDTO->getPassword());
            $user->setPassword($password);
            $user->setIsAccepted($userDTO->isAccepted());
            $this->userRepository->add($user, true);

            return $user;
        } catch (\Exception $e) {
            throw new BadRequestException("Error creating user: " . $e->getMessage());
        }
    }
}

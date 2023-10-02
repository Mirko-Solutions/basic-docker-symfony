<?php

namespace App\Infrastructure\Service\User;

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

    public function deleteById(int $id): void
    {
        $this->userRepository->softDelete($id);
    }
}
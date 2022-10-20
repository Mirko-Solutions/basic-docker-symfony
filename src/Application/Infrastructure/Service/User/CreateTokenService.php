<?php

namespace App\Infrastructure\Service\User;

use App\Domain\Entity\User\User;
use App\Domain\Entity\User\UserToken;
use App\Infrastructure\Repository\User\UserTokenRepository;

class CreateTokenService
{
    private UserTokenRepository $userTokenRepository;


    public function __construct(UserTokenRepository $userTokenRepository)
    {
        $this->userTokenRepository = $userTokenRepository;
    }

    public function create(User $user, string $token, string $type) : UserToken
    {
        $userToken = new UserToken();
        $userToken->setUser($user);
        $userToken->setToken($token);
        $userToken->setType($type);
        $this->userTokenRepository->add($userToken, true);

        return $userToken;
    }
}

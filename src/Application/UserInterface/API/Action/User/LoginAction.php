<?php

namespace App\UserInterface\API\Action\User;

use App\Infrastructure\Service\User\AuthService;
use App\UserInterface\API\Type\User\AuthType;
use App\UserInterface\API\Action\AbstractAction;
use App\UserInfrastructure\API\Response\ArrayResponse;
use App\UserInfrastructure\API\Response\TokenResponse;

/**
 * @author Mykhailo YATSYSHYN <mykhailo.yatsyshyn@mirko.in.ua>
 */
class LoginAction extends AbstractAction
{
    public function __invoke(AuthService $authService)
    {
        $data = $this->handleType(AuthType::class);
        $token = $authService->createUserTokenHash($data['email'], $data['password']);
        
        return $this->response(new TokenResponse(), $token);
    }
}

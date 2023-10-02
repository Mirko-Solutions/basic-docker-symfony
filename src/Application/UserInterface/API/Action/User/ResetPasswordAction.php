<?php

declare(strict_types=1);

namespace App\UserInterface\API\Action\User;

use App\Infrastructure\Service\User\UpdateService;
use App\Infrastructure\Service\User\UserService;
use App\UserInfrastructure\API\Response\SuccessResponse;
use App\UserInterface\API\Action\AbstractAction;
use App\UserInterface\API\Type\User\ResetPasswordType;

/**
 * @author Bohdan Sinchuk <bohdan.sinchuk@mirko.in.ua>
 */
class ResetPasswordAction extends AbstractAction
{
    public function __invoke(string $token, UserService $userService, UpdateService $updateService)
    {
        $data = $this->handleType(ResetPasswordType::class);
        $user = $userService->findByRecoveryToken($token);
        $updateService->updatePassword($user, $data['password']);

        return $this->response(new SuccessResponse(), 'Password has been changed successfully');
    }
}
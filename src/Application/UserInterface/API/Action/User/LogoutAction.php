<?php

namespace App\UserInterface\API\Action\User;

use App\Infrastructure\Service\User\AuthService;
use App\UserInfrastructure\API\Response\SuccessResponse;
use App\UserInterface\API\Action\AbstractAction;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpFoundation\Request;

/**
 * @author Bohdan Sinchuk <bohdan.sinchuk@mirko.in.ua>
 */
class LogoutAction extends AbstractAction
{
    public function __invoke(Security $security, Request $request, AuthService $authService)
    {
        $security->logout(false);
        $authService->deleteUserTokenHash($request->headers->get('X-AUTH-TOKEN'));

        return $this->response(new SuccessResponse(), [
            'message' => 'User logout has been successful',
        ]);
    }
}
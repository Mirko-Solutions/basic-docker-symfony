<?php

namespace App\UserInterface\Admin\Action\User;

use App\Domain\Entity\User\User;
use App\Infrastructure\Service\Admin\UserDeleteService;
use App\UserInfrastructure\API\Response\ArrayResponse;
use App\UserInterface\API\Action\AbstractAction;

/**
 * @author Bohdan Sinchuk <bohdan.sinchuk@mirko.in.ua>
 */
class UserDeleteAction extends AbstractAction
{
    public function __invoke(User $user, UserDeleteService $userDeleteService)
    {
        $userDeleteService->deleteById($user->getId());
       return $this->response(new ArrayResponse(), [
           'message' => 'User has been deleted'
       ]);
    }
}
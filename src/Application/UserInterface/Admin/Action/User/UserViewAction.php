<?php

namespace App\UserInterface\Admin\Action\User;

use App\Domain\Entity\User\User;
use App\Infrastructure\Service\Admin\UserViewService;
use App\UserInfrastructure\API\Response\ArrayResponse;
use App\UserInterface\API\Action\AbstractAction;

/**
 * @author Bohdan Sinchuk <bohdan.sinchuk@mirko.in.ua>
 */
class UserViewAction extends AbstractAction
{
    public function __invoke(User $user, UserViewService $userViewService)
    {
       return $this->response(new ArrayResponse(), $userViewService->getById($user->getId()));
    }
}